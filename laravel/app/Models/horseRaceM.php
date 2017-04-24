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
        $userId = $user->id;  //登入者id
        $bettingData = DB::table('bs_sdBetting')
            ->select('num','user_id','user_name','h_id','horse_picture','horse_name')
            ->where('user_id', $userId)
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
                $trueRank = $count + 1;
                DB::table('bs_sdBetting')
                    ->where('h_id', $rowHId[0]->h_id)
                    ->where('count','!=', 3)
                    ->update(['r_rank' => $trueRank]);   //更新下注單賽果賽馬名次
                $count++;
            }
        }
        $endTime = horseRaceM::nowDateTime(); //目前時間
        if ($action != NULL && $action == 'lottery')     //判斷值是否由欄位輸入
        {
            DB::table('horseRace_result')->insert(array( //新增賽果資料
                array('firth' => $rankHId[0], 'second' => $rankHId[1], 'third' => $rankHId[2], 'fourth' => $rankHId[3],
                    'fifth' => $rankHId[4], 'sixth' => $rankHId[5], 'seventh' => $rankHId[6], 'eighth' => $rankHId[7],
                    'ninth' => $rankHId[8], 'tenth' => $rankHId[9], 'end_time' => $endTime )
            ));
        }
        if ($action == NULL){ //判斷值是否由欄位輸入
            return false;
        }
    }
    //賽馬區分名次hid
    public static function RankDistinguish()
    {
        $rowRankHId = DB::table('horseRace_result') //最新場次賽馬名次
        ->select('firth','second','third','fourth','fifth','sixth','seventh','eighth','ninth','tenth')
            ->orderBy('num', 'desc')
            ->get();
        $rankHId[0] = $rowRankHId[0]->firth;
        $rankHId[1] = $rowRankHId[0]->second;
        $rankHId[2] = $rowRankHId[0]->third;
        $rankHId[3] = $rowRankHId[0]->fourth;
        $rankHId[4] = $rowRankHId[0]->fifth;
        $rankHId[5] = $rowRankHId[0]->sixth;
        $rankHId[6] = $rowRankHId[0]->seventh;
        $rankHId[7] = $rowRankHId[0]->eighth;
        $rankHId[8] = $rowRankHId[0]->ninth;
        $rankHId[9] = $rowRankHId[0]->tenth;
        return $rankHId;
    }
    //賽馬遊戲派彩資料修改
    public static function RaceBonus(){

        bigOrSmallGameM::singleBettingResult();    //下注"單數"輸贏結果運算
        bigOrSmallGameM::doubleBettingResult();    //下注"雙數"輸贏結果運算
        bigOrSmallGameM::smallerBettingResult();   //下注"比小"輸贏結果運算
        bigOrSmallGameM::biggerBettingResult();    //下注"比大"輸贏結果運算
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
                $userMoney = $rowUserMoney[0]->money;    //查詢贏家現餘金額
                $odds = $value -> odds;                  //投注賠率
                $bettingMoney = $value->money;           //投注金額
                $winMoney = $bettingMoney * $odds;       //贏得金額
                $sumMoney = $userMoney + $winMoney;      //計算贏得後總金額

                DB::table('member')
                    ->where('id', $value->user_id)
                    ->update(['money' => $sumMoney]);    //修改最終贏得金額
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
        if ($action != NULL && $action == 'lottery') //判斷值是否由欄位輸入
        {
            DB::table('bs_sdBetting')
                ->where('win', 0)
                ->where('count','!=', 3)
                ->update(['count' => 2]);
        }
    }
    //之前下注改成歷史紀錄&登錄新賽果時間
    public static function bettingHistoryUpdate($action)
    {
        if ($action != NULL && $action == 'lottery')  //判斷值是否由欄位輸入
        {
            $nowTime = horseRaceM::nowDateTime();
            DB::table('bs_sdBetting')
                ->where('count', 2)
                ->update(['count' => 3]);

            DB::table('bs_sdBetting')
                ->where('count', 0)
                ->update(['open_time' => $nowTime]);
        }
    }
    //計算賽果資料
    public static function horseRaceResultData()
    {
        $rowWinMoney = DB::table('bs_sdBetting')
        ->select('money')
            ->where('win',0)
            ->where('count',2)
            ->get();
        $winMoney = 0;
        foreach ($rowWinMoney as $value){
            $money = $value->money;
            $winMoney += $money;  //當次獲利金額
        }
        $rowWinMoney = DB::table('bs_sdBetting')
        ->select('money')
            ->where('win',1)
            ->where('count',2)
            ->get();
        $loseMoney = 0;
        foreach ($rowWinMoney as $value){
            $money = $value->money;
            $loseMoney += $money;  //當次損失金額
        }
        $bettingCount = DB::table('bs_sdBetting')
            ->where('count',2)
            ->count();
        $resultData = ['winMoney' => $winMoney, 'loseMoney' => $loseMoney, 'bettingCount' => $bettingCount];
        return $resultData;
    }
    //個人賽果資料
    public static function horseRaceResultPersonalData($id)
    {
        $resultData = array();
        $rowHorseRaceResult=DB::table('bs_sdBetting')
            ->select('money','horse_name','h_rank','r_rank','control','win','count','open_time')
            ->where('user_id',$id)
            ->orderBy('betting_time', 'desc')
            ->get();

        $profit='';
        $odds='';
        foreach ($rowHorseRaceResult as $value){

            switch ($value->control) {
                case 1:
                case 2:
                    $gameName = '賽馬單雙遊戲';
                    $rowOdds = horseRaceM::raceOddsOneData($gameName);
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
                    $rowOdds = horseRaceM::raceOddsOneData($gameName);
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
                    $rowOdds = horseRaceM::raceOddsOneData($gameName);
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
            $rowNum = DB::table('horseRace_result')  //賽馬場次資料
                ->select('num')
                ->where('end_time', $value->open_time)
                ->get();
            if($rowNum != NULL) {
                $horseRaceNum = $rowNum[0]->num;
            }else{
                $rowNum = DB::table('horseRace_result')
                    ->select('num')
                    ->orderBy('num', 'desc')
                    ->get();
                $lastNum = $rowNum[0]->num;
                $horseRaceNum = $lastNum + 1;
            }
            $resultData[] = ['horseRaceNum' => $horseRaceNum, 'horse_name' => $value->horse_name,
                'h_rank' => $value->h_rank, 'r_rank' => $value->r_rank, 'control' => $value->control,
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
        if ($oddsData['action'] != NULL && $oddsData['action'] == 'update') //判斷值是否由欄位輸入
        {
            for ($i=0 ; $i<count($oddsData['gameName']) ; $i++) {
                DB::table('horseGame_data')
                    ->where('num', $oddsData['num'][$i])
                    ->update(['game_name' => $oddsData['gameName'][$i], 'odds' => $oddsData['odds'][$i]]);
            }
            return $oddsData['gameName'];
        }
        if ($oddsData['action'] == NULL){ //判斷值是否由欄位輸入
            return false;
        }
    }
    //賽馬遊戲開關
    public static function horseRaceControl($horseRaceData){
        if ($horseRaceData['action'] != NULL && $horseRaceData['action'] == 'update') //判斷值是否由欄位輸入
        {
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
        if ($horseRaceData['action'] == NULL){ //判斷值是否由欄位輸入
            return false;
        }
    }
    //目前時間
    public static function nowDateTime()
    {
        date_default_timezone_set("Asia/Taipei"); //目前時間
        $dateTime = date("Y-m-d H:i:s");
        return $dateTime;
    }
}