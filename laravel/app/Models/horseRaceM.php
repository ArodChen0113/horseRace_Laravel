<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use App\Models\bigOrSmallGameM;
use App\Models\positionGameM;
use Illuminate\Support\Facades\Auth;

class horseRaceM
{
    //賽馬資料搜尋
    public function horseData(){
        $horseData=DB::table('horse_data')
            ->select('h_id','horse_name','horse_age','horse_introduce','horse_picture')
            ->get();
        return $horseData;
    }
    //賽馬單筆資料搜尋
    public function horseDataOne($HId){
        $horseData=DB::table('horse_data')
            ->select('h_id','horse_name','horse_age','horse_introduce','horse_picture')
            ->where('h_id',$HId)
            ->get();
        return $horseData;
    }
    //user下注資料搜尋
    public function bettingData(){
        $user = Auth::user();
        $userId=$user->id;
        $bettingData=DB::table('bs_sdBetting')
            ->select('num','user_id','user_name','h_id','horse_picture','horse_name')
            ->where('user_id',$userId)
            ->where('control',0)
            ->where('count',9)
            ->get();
        return $bettingData;
    }
    //賽馬場次資料搜尋
    public function horseRaceData(){
        $horseRaceData=DB::table('horseRace_result')
            ->select('num','end_time')
            ->orderBy('num', 'desc')
            ->get();
        return $horseRaceData;
    }
    //定位下注資料總覽
    public function poBettingData(){
        $bettingData=DB::table('bs_sdBetting')
            ->select('user_name','money','h_id','h_rank','control')
            ->where('control',5)
            ->get();
        return $bettingData;
    }

    //計算賽馬名次
    public function horseRaceResult($action){

        $rank=array();
        $horseCount=10;
        $count=0;
        while ($count<$horseCount) {           //計算賽馬名次
            $number = rand(1, $horseCount);
            if (!in_array($number, $rank)) {   //去陣列重複值
                $rank[$count] = $number;
                $rowHId=DB::table('horseGame_horse')
                    ->select('h_id')
                    ->where('g_id', $number)
                    ->get();
                $rankHId[$count] = $rowHId[0]->h_id;
                $trueRank=$count+1;
                DB::table('bs_sdBetting')
                    ->where('h_id', $rowHId[0]->h_id)
                    ->where('count','!=',3)
                    ->update(['r_rank' => $trueRank]);   //更新下注單賽果賽馬名次
                $count++;
            }
        }

        date_default_timezone_set("Asia/Taipei"); //目前時間
        $endTime = date("Y-m-d H:i:s");
        if ($action != NULL && $action == 'lottery')           //判斷值是否由欄位輸入
        {
            DB::table('horseRace_result')->insert(array(                          //新增賽果資料
                array('firth' => $rankHId[0], 'second' => $rankHId[1], 'third' => $rankHId[2], 'fourth' => $rankHId[3], 'fifth' => $rankHId[4], 'sixth' => $rankHId[5], 'seventh' => $rankHId[6], 'eighth' => $rankHId[7], 'ninth' => $rankHId[8], 'tenth' => $rankHId[9], 'end_time' => $endTime )
            ));
            return $success=1;
        }else{
            return false;
        }
    }
    //賽馬區分名次hid
    public function RankDistinguish()
    {
        $rowRankHId=DB::table('horseRace_result') //第一名hid
        ->select('firth')
            ->orderBy('num', 'desc')
            ->get();
        $rankHId[0] = $rowRankHId[0]->firth;
        $rowRankHId=DB::table('horseRace_result') //第二名hid
        ->select('second')
            ->orderBy('num', 'desc')
            ->get();
        $rankHId[1] = $rowRankHId[0]->second;
        $rowRankHId=DB::table('horseRace_result') //第三名hid
        ->select('third')
            ->orderBy('num', 'desc')
            ->get();
        $rankHId[2] = $rowRankHId[0]->third;
        $rowRankHId=DB::table('horseRace_result') //第四名hid
        ->select('fourth')
            ->orderBy('num', 'desc')
            ->get();
        $rankHId[3] = $rowRankHId[0]->fourth;
        $rowRankHId=DB::table('horseRace_result') //第五名hid
        ->select('fifth')
            ->orderBy('num', 'desc')
            ->get();
        $rankHId[4] = $rowRankHId[0]->fifth;
        $rowRankHId=DB::table('horseRace_result') //第六名hid
        ->select('sixth')
            ->orderBy('num', 'desc')
            ->get();
        $rankHId[5] = $rowRankHId[0]->sixth;
        $rowRankHId=DB::table('horseRace_result') //第七名hid
        ->select('seventh')
            ->orderBy('num', 'desc')
            ->get();
        $rankHId[6] = $rowRankHId[0]->seventh;
        $rowRankHId=DB::table('horseRace_result') //第八名hid
        ->select('eighth')
            ->orderBy('num', 'desc')
            ->get();
        $rankHId[7] = $rowRankHId[0]->eighth;
        $rowRankHId=DB::table('horseRace_result') //第九名hid
        ->select('ninth')
            ->orderBy('num', 'desc')
            ->get();
        $rankHId[8] = $rowRankHId[0]->ninth;
        $rowRankHId=DB::table('horseRace_result') //第十名hid
        ->select('tenth')
            ->orderBy('num', 'desc')
            ->get();
        $rankHId[9] = $rowRankHId[0]->tenth;
        return $rankHId;
    }
    //定位賽馬遊戲派彩資料修改
    public function poRaceBonus(){

        $poGameM = new positionGameM();
        $poGameM->positionBettingResult();             //下注定位賽馬輸贏結果運算

        $rowSDPayData=DB::table('bs_sdBetting')     //查詢下注定位賽馬贏家uId,下注金額
        ->select('num','user_id','money')
            ->where('control',5)
            ->where('win',1)
            ->where('count',1)
            ->get();
        $rowOdds=DB::table('horseGame_data')           //查詢遊戲賠率
        ->select('odds')
            ->where('game_name','賽馬定位遊戲')
            ->get();
        $odds=$rowOdds[0]->odds;

        if($rowSDPayData!=NULL) {
            $count = count($rowSDPayData);
            for ($i = 0; $i < $count; $i++) {                    //定位賽馬下注贏家派彩
                $value = $rowSDPayData[$i];
                $rowUserMoney = DB::table('member')
                    ->select('money')
                    ->where('id', $value->user_id)
                    ->get();
                $userMoney = $rowUserMoney[0]->money;        //查詢贏家現餘金額
                $bettingMoney = $value->money;               //下注金額
                $winMoney = $bettingMoney * $odds;             //贏得金額
                $sumMoney = $userMoney + $winMoney;            //計算贏得後總金額

                DB::table('member')
                    ->where('id', $value->user_id)
                    ->update(['money' => $sumMoney]);      //修改最終贏得金額
                DB::table('bs_sdBetting')
                    ->where('num', $value->num)
                    ->where('count','!=', 3)
                    ->update(['count' => 2]);              //改為已派彩
            }
        }
    }
    //輸家狀態改為當次已計算,無派彩
    public function raceLoseUpdate($action)
    {
        if ($action != NULL && $action == 'lottery')      //判斷值是否由欄位輸入
        {
            DB::table('bs_sdBetting')
                ->where('win', 0)
                ->where('count','!=', 3)
                ->update(['count' => 2]);
        }
    }
    //之前下注改成歷史紀錄&登錄新賽果時間
    public function bettingHistoryUpdate($action)
    {
        if ($action != NULL && $action == 'lottery')      //判斷值是否由欄位輸入
        {
            $nowTime=$this->nowDateTime();
            DB::table('bs_sdBetting')
                ->where('count', 2)
                ->update(['count' => 3]);

            DB::table('bs_sdBetting')
                ->where('count', 0)
                ->update(['open_time' => $nowTime]);
        }
    }
    //計算賽果資料
    public function horseRaceResultData()
    {
        $rowWinMoney=DB::table('bs_sdBetting')
        ->select('money')
            ->where('win',0)
            ->where('count',2)
            ->get();
        $winMoney=0;
        $num=count($rowWinMoney);
        for ($i=0;$i<$num;$i++){
            $value=$rowWinMoney[$i];
            $money=$value->money;
            $winMoney=$winMoney+$money;            //當次獲利金額
        }
        $rowWinMoney=DB::table('bs_sdBetting')
        ->select('money')
            ->where('win',1)
            ->where('count',2)
            ->get();
        $loseMoney=0;
        $num=count($rowWinMoney);
        for ($i=0;$i<$num;$i++){
            $value=$rowWinMoney[$i];
            $money=$value->money;
            $loseMoney=$loseMoney+$money;          //當次損失金額
        }
        $bettingCount=DB::table('bs_sdBetting')
            ->where('count',2)
            ->count();
        $resultData=['winMoney' => $winMoney,'losemoney' => $loseMoney, 'bettingCount' => $bettingCount];
        return $resultData;
    }
    //個人賽果資料
    public function horseRaceResultPersonalData($id)
    {
        $rowHorseRaceResult=DB::table('bs_sdBetting')
            ->select('money','horse_name','h_rank','r_rank','control','win','count','open_time')
            ->where('user_id',$id)
            ->orderBy('betting_time', 'desc')
            ->get();

        $profit='';
        $odds='';
        $num=count($rowHorseRaceResult);
        for ($i=0;$i<$num;$i++) {
            $value = $rowHorseRaceResult[$i];

            if ($value->control == 1 OR $value->control == 2) {
                $gameName='賽馬單雙遊戲';
                $rowOdds = $this->raceOddsOneData($gameName);
                $odds = $rowOdds[0]->odds;
                if ($value->win == 1) {
                    $money = $value->money;
                    $profit = $money * $odds;
                }
                if ($value->win == 0) {
                    $profit = $value->money;
                }
            }
            if ($value->control == 3 OR $value->control == 4) {
                $gameName='賽馬大小遊戲';
                $rowOdds = $this->raceOddsOneData($gameName);
                $odds = $rowOdds[0]->odds;
                if ($value->win == 1) {
                    $money = $value->money;
                    $profit = $money * $odds;
                }
                if ($value->win == 0) {
                    $profit = $value->money;
                }
            }
            if ($value->control == 5) {
                $gameName='賽馬定位遊戲';
                $rowOdds = $this->raceOddsOneData($gameName);
                $odds = $rowOdds[0]->odds;
                if ($value->win == 1) {
                    $money = $value->money;
                    $profit = $money * $odds;
                }
                if ($value->win == 0) {
                    $profit = $value->money;
                }
            }
            $rowNum = DB::table('horseRace_result')
                ->select('num')
                ->where('end_time', $value->open_time)
                ->get();
            if($rowNum!=NULL) {
                $horseRaceNum = $rowNum[0]->num;
            }else{
                $rowNum = DB::table('horseRace_result')
                    ->select('num')
                    ->orderBy('num', 'desc')
                    ->get();
                $lastNum = $rowNum[0]->num;
                $horseRaceNum = $lastNum+1;
            }
            $resultData[$i] = ['horseRaceNum' => $horseRaceNum,'horse_name' => $value->horse_name, 'h_rank' => $value->h_rank, 'r_rank' => $value->r_rank, 'control' => $value->control, 'money' => $value->money, 'win' => $value->win, 'odds' => $odds, 'profit' => $profit , 'count' => $value->count];
        }
        return $resultData;
    }
    //賠率資料
    public function raceOddsData()
    {
        $rowOddsData = DB::table('horseGame_data')
            ->select('game_name','odds')
            ->get();
        return $rowOddsData;
    }
    //查詢遊戲賠率
    public function raceOddsOneData($gameName)
    {
        $rowOdds = DB::table('horseGame_data')
            ->select('odds')
            ->where('game_name', $gameName)
            ->get();
        return $rowOdds;
    }
    //賠率修改
    public function raceOddsUpdate($oddsData)
    {
        if ($oddsData->action != NULL && $oddsData->action == 'update')      //判斷值是否由欄位輸入
        {
            DB::table('horseGame_data')
                ->where('game_name', $oddsData->gameName)
                ->update(['odds' => $oddsData->odds]);
            return $oddsData->gameName;
        } else {
            return false;
        }
    }
    //賽馬遊戲開關
    public function horseRaceControl($horseRaceData){
        if ($horseRaceData->action != NULL && $horseRaceData->action == 'update')      //判斷值是否由欄位輸入
        {
            if($horseRaceData->gameName==0) {
                DB::table('horseGame_data')
                    ->where('game_name', $horseRaceData->gameName)
                    ->update(['open' => 1]);
            }
            if($horseRaceData->gameName==1) {
                DB::table('horseGame_data')
                    ->where('game_name', $horseRaceData->gameName)
                    ->update(['open' => 0]);
            }
            return $horseRaceData->gameName;
        }else{
            return false;
        }
    }
    //目前時間
    public function nowDateTime()
    {
        date_default_timezone_set("Asia/Taipei"); //目前時間
        $dateTime = date("Y-m-d H:i:s");
        return $dateTime;
    }
}