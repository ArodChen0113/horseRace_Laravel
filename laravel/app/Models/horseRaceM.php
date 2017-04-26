<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use App\Models\bigOrSmallGameM;
use App\Models\positionGameM;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class horseRaceM
{
    //賽馬資料搜尋
    public static function horseData(){
        $horseData = DB::table('horse_data')
            ->select('h_id','horse_name','horse_age','horse_introduce','horse_picture')
            ->get();
        return $horseData;
    }
    //賽馬單筆資料搜尋
    public static function horseDataOne($hId){
        $horseData = DB::table('horse_data')
            ->select('h_id','horse_name','horse_age','horse_introduce','horse_picture')
            ->where('h_id',$hId)
            ->get();
        return $horseData;
    }
    //user下注資料搜尋
    public static function bettingData(){
        $user = Auth::user();
        $bettingData = DB::table('bs_sdBetting')
            ->select('num','user_id','user_name','h_id','horse_picture','horse_name')
            ->where('user_id', $user->id)
            ->where('control', 0)
            ->where('count', 9)
            ->get();
        return $bettingData;
    }
    //賽馬場次資料搜尋
    public static function horseRaceData(){
        $horseRaceData = DB::table('horseRace_result')
            ->select('num', 'end_time')
            ->orderBy('num', 'desc')
            ->get();
        return $horseRaceData;
    }
    //比對賽馬場次資料搜尋
    public static function horseRaceSel($endTime){
        $horseNum = DB::table('horseRace_result')
            ->select('num')
            ->where('end_time', $endTime)
            ->get();
        return $horseNum;
    }
    //未出賽賽馬場次搜尋
    public static function unHorseRaceSel(){
        $rowNum = DB::table('horseRace_result')
            ->select(DB::raw('MAX(num) as maxNum'))
            ->get();
        $rowNum[0]->maxNum ++;
        return $rowNum[0]->maxNum;
    }
    //定位下注資料總覽
    public static function poBettingData(){
        $bettingData = DB::table('bs_sdBetting')
            ->select('user_name','money','h_id','h_rank','control')
            ->where('control', 5)
            ->get();
        return $bettingData;
    }

    //計算賽馬名次
    public static function horseRaceResult($action){

        if ($action == NULL || $action != 'lottery') //判斷值是否由欄位輸入
        {
            return false;
        }
        $rank = array();
        $horseCount = 10;
        $count = 0;
        while ($count < $horseCount) {        //計算賽馬名次
            $number = rand(1, $horseCount);
            if (!in_array($number, $rank)) {  //去陣列重複值
                $rank[$count] = $number;
                $rowHId = DB::table('horseGame_horse')
                    ->select('h_id')
                    ->where('g_id', $number)
                    ->get();
                $rankHId[$count] = $rowHId[0]->h_id;
                $count++;
                DB::table('bs_sdBetting')
                    ->where('h_id', $rowHId[0]->h_id)
                    ->where('count','!=', 3)
                    ->update(['r_rank' => $count]);   //更新下注單賽果賽馬名次
                DB::table('bs_sdBetting')
                    ->where('h_rank', $count)
                    ->where('count','!=', 3)
                    ->update(['r_hId' => $number]);   //更新下注單賽果賽馬編號
            }
        }
        $endTime = horseRaceM::nowDateTime(); //目前時間

            DB::table('horseRace_result')->insert(array( //新增賽果資料
                array('first' => $rankHId[0], 'second' => $rankHId[1], 'third' => $rankHId[2], 'fourth' => $rankHId[3],
                    'fifth' => $rankHId[4], 'sixth' => $rankHId[5], 'seventh' => $rankHId[6], 'eighth' => $rankHId[7],
                    'ninth' => $rankHId[8], 'tenth' => $rankHId[9], 'end_time' => $endTime )
            ));
    }
    //賽馬區分名次hid
    public static function RankDistinguish()
    {
        $rowRankHId = DB::table('horseRace_result') //最新場次賽馬名次
        ->select('first','second','third','fourth','fifth','sixth','seventh','eighth','ninth','tenth')
            ->orderBy('num', 'desc')
            ->get();
        $rankHId = array(
            $rowRankHId[0]->first,
            $rowRankHId[0]->second,
            $rowRankHId[0]->third,
            $rowRankHId[0]->fourth,
            $rowRankHId[0]->fifth,
            $rowRankHId[0]->sixth,
            $rowRankHId[0]->seventh,
            $rowRankHId[0]->eighth,
            $rowRankHId[0]->ninth,
            $rowRankHId[0]->tenth
        );
        return $rankHId;
    }
    //賽馬遊戲派彩資料修改
    public static function RaceBonus(){

        bigOrSmallGameM::sdBettingResult();        //下注"單雙小大"輸贏結果運算
        positionGameM::positionBettingResult();    //下注"定位"輸贏結果運算

        $rowSDPayData = DB::table('bs_sdBetting')  //查詢下注定位賽馬贏家uId,下注金額
        ->select('num','user_id','money','odds')
            ->where('win', 1)
            ->where('count', 1)
            ->get();

        if($rowSDPayData != NULL) {
            foreach ($rowSDPayData as $value){     //定位賽馬下注贏家派彩
                $rowUserMoney = DB::table('member')
                    ->select('money')
                    ->where('id', $value->user_id)
                    ->get();
                $value->money *= $value->odds;  //贏得金額
                $rowUserMoney[0]->money += $value->money; //計算贏得後總金額

                DB::table('member')
                    ->where('id', $value->user_id)
                    ->update(['money' => $rowUserMoney[0]->money]);    //修改最終贏得金額
                DB::table('bs_sdBetting')
                    ->where('num', $value->num)
                    ->where('count','!=', 3)
                    ->update(['count' => 2]);            //改為已派彩
            }
        }
    }
    //輸家狀態改為當次已計算,無派彩
    public static function raceLoseUpdate($action)
    {
        if ($action == NULL || $action != 'lottery') //判斷值是否由欄位輸入
        {
            return false;
        }
            DB::table('bs_sdBetting')
                ->where('win', 0)
                ->where('count','!=', 3)
                ->update(['count' => 2]);
    }
    //之前下注改成歷史紀錄&登錄新賽果時間
    public static function bettingHistoryUpdate($action)
    {
        if ($action == NULL || $action != 'lottery') //判斷值是否由欄位輸入
        {
            return false;
        }
            $nowTime = horseRaceM::nowDateTime();    //目前時間
            DB::table('bs_sdBetting')
                ->where('count', 2)
                ->update(['count' => 3]);

            DB::table('bs_sdBetting')
                ->where('count', 0)
                ->update(['open_time' => $nowTime]);
    }
    //下注賽果資料
    public static function bettingResultData()
    {
        $bettingResultData = DB::table('bs_sdBetting')
            ->select('money')
            ->where('count',2);

        return $bettingResultData;
    }
    //計算賽果資料
    public static function horseRaceResultData()
    {
        $rowWinMoney = horseRaceM::bettingResultData()->where('win',0)->get();  //下注賽果資料
        $winMoney = 0;
        foreach ($rowWinMoney as $value){
            $winMoney += $value->money;  //當次獲利金額
        }
        $rowWinMoney = horseRaceM::bettingResultData()->where('win',1)->get();
        $loseMoney = 0;
        foreach ($rowWinMoney as $value){
            $loseMoney += $value->money;  //當次損失金額
        }
        $bettingCount = horseRaceM::bettingResultData()->count();
        $resultData = ['winMoney' => $winMoney, 'loseMoney' => $loseMoney, 'bettingCount' => $bettingCount];
        return $resultData;
    }
    //個人賽果資料
    public static function horseRaceResultPersonalData($id)
    {
        $resultData = array();
        $profit = '';
        $odds = '';
        $rowHorseRaceResult=DB::table('bs_sdBetting')
            ->select('money','horse_name','h_id','h_rank','r_rank','r_hId','control','win','count','open_time')
            ->where('user_id',$id)
            ->orderBy('betting_time', 'desc')
            ->get();
        foreach ($rowHorseRaceResult as $value){

            switch ($value->control) {
                case 1:
                case 2:
                    $gameName = '賽馬單雙遊戲';
                    $rowOdds = horseRaceM::raceOddsOneData($gameName); //遊戲賠率
                    $odds = $rowOdds[0]->odds;
                    if ($value->win == 1) {
                        $money = $value->money;
                        $profit = $money * $odds;
                    }
                    if ($value->win == 0) {
                        $profit = $value->money;
                    }
                    break;
                case 3:
                case 4:
                    $gameName = '賽馬大小遊戲';
                    $rowOdds = horseRaceM::raceOddsOneData($gameName); //遊戲賠率
                    $odds = $rowOdds[0]->odds;
                    if ($value->win == 1) {
                        $money = $value->money;
                        $profit = $money * $odds;
                    }
                    if ($value->win == 0) {
                        $profit = $value->money;
                    }
                    break;
                case 5:
                    $gameName = '賽馬定位遊戲';
                    $rowOdds = horseRaceM::raceOddsOneData($gameName); //遊戲賠率
                    $odds = $rowOdds[0]->odds;
                    if ($value->win == 1) {
                        $money = $value->money;
                        $profit = $money * $odds;
                    }
                    if ($value->win == 0) {
                        $profit = $value->money;
                    }
                    break;
            }
            $rowNum = horseRaceM::horseRaceSel($value->open_time); //查詢賽馬場次
            if($rowNum != NULL) {
                $horseRaceNum = $rowNum[0]->num;
            }
            if($rowNum == NULL) {
                $horseRaceNum = horseRaceM::unHorseRaceSel(); //未出賽馬場次
            }
            $resultData[] = ['horseRaceNum' => $horseRaceNum, 'horse_name' => $value->horse_name, 'h_id' => $value->h_id,
                'h_rank' => $value->h_rank, 'r_rank' => $value->r_rank, 'r_hId' => $value->r_hId, 'control' => $value->control,
                'money' => $value->money, 'win' => $value->win, 'odds' => $odds, 'profit' => $profit , 'count' => $value->count];
        }
        return $resultData;
    }
    //賠率資料
    public static function raceOddsData()
    {
        $rowOddsData = DB::table('horseGame_data')
            ->select('num','game_name','odds')
            ->get();
        return $rowOddsData;
    }
    //查詢遊戲賠率
    public static function raceOddsOneData($gameName)
    {
        $rowOdds = DB::table('horseGame_data')
            ->select('odds')
            ->where('game_name', $gameName)
            ->get();
        return $rowOdds;
    }
    //賠率修改
    public static function raceOddsUpdate($oddsData)
    {
        if ($oddsData['action'] == NULL || $oddsData['action'] != 'update') //判斷值是否由欄位輸入
        {
            return false;
        }
            for ($i=0 ; $i<count($oddsData['gameName']) ; $i++) {
                DB::table('horseGame_data')
                    ->where('num', $oddsData['num'][$i])
                    ->update(['game_name' => $oddsData['gameName'][$i], 'odds' => $oddsData['odds'][$i]]);
            }
            return $oddsData['gameName'];

    }
    //賽馬遊戲開關
    public static function horseRaceControl($horseRaceData){
        if ($horseRaceData['action'] == NULL || $horseRaceData['action'] != 'update') //判斷值是否由欄位輸入
        {
            return false;
        }
            $query = DB::table('horseGame_data')
                ->where('game_name', $horseRaceData->gameName);
            if($horseRaceData->gameName == 0) {
                $query->update(['open' => 1]);
            }
            if($horseRaceData->gameName == 1) {
                $query->update(['open' => 0]);
            }
            return $horseRaceData->gameName;
    }
    //目前時間
    public static function nowDateTime()
    {
        date_default_timezone_set("Asia/Taipei"); //目前時間
        $dateTime = date("Y-m-d H:i:s");
        return $dateTime;
    }
}