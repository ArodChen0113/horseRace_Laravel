<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use App\Models\horseRaceM as horseRace;
use Illuminate\Support\Facades\Auth;
use App\Models\horseRaceM;
use Illuminate\Support\Collection;

class bigOrSmallGameM extends horseRace
{
    //大小單雙下注總覽資料
    public static function bsBettingData()
    {
        $bsHorseRaceResultData = array();
        $horseRaceData = horseRaceM::horseRaceData(); //賽馬場次資料
        foreach ($horseRaceData as $value){
            $bettingData = DB::table('bs_sdBetting') //該場次下注資料
            ->select('money')
                ->whereIn('control', [1, 2, 3, 4])
                ->where('open_time', $value->end_time)
                ->get();

            $sumBettingMoney = 0;
            $numBettingData = count($bettingData); //該場次投注筆數
            foreach ($bettingData as $value2){
                $bettingMoney = $value2->money;
                $sumBettingMoney += $bettingMoney;  //該場次投注總金額
            }
            $bettingLose = DB::table('bs_sdBetting')
                ->select('money', 'odds')
                ->whereIn('control', [1, 2, 3, 4])
                ->where('win', 1)
                ->where('open_time', $value->end_time)
                ->get();
            $loseMoney = 0;
            foreach ($bettingLose as $value3){
                $bettingMoneyLose = $value3->money;
                $odds = $value3->odds;             //場次賠率
                $bettingMoneyLose *= $odds;
                $loseMoney += $bettingMoneyLose;   //該場次虧損金額
            }
            $winMoney = $sumBettingMoney - $loseMoney;     //剛場次獲利金額
            $bsHorseRaceResultData[] = ['num' => $value->num, 'raceCount' => $numBettingData,
                'sumBettingMoney' => $sumBettingMoney, 'winMoney' => $winMoney, 'loseMoney' => $loseMoney];
        }
        return $bsHorseRaceResultData;
    }
    //大小單雙總獲利
    public static function sumProfit(){
        $bsHorseRaceResultData = bigOrSmallGameM::bsBettingData(); //大小單雙下注總覽資料
        $sumProfit = 0;
        foreach ($bsHorseRaceResultData as $value){
            $sumProfit += $value['winMoney']; //大小單雙總獲利
        }
        return $sumProfit;
    }
    //大小單雙遊戲下注新增
    public static function bsBettingInsert($bettingData)
    {
        $user = Auth::user();
        $userName = $user->name;
        $userId = $user->id;
        $bettingTime = horseRaceM::nowDateTime();  //現在時間
        $horseData = horseRaceM::horseDataOne($bettingData['h_id']); //賽馬資料
        $gameName = '賽馬大小遊戲';
        $odds = horseRaceM::raceOddsOneData($gameName); //查詢賠率

        if ($bettingData['action'] != NULL && $bettingData['action'] == 'insert') //判斷值是否由欄位輸入
        {
            DB::table('bs_sdBetting')->where('user_id', '=', $userId)->where('control', '=', 0)->delete();  //清空之前下注紀錄
            DB::table('bs_sdBetting')->insert(array(  //新增下注資料
                array('user_id' => $userId, 'user_name' => $userName, 'odds' => $odds[0]->odds, 'h_id' => $bettingData['h_id'],
                    'horse_name' => $bettingData['horseName'], 'horse_picture' => $bettingData['horsePic'], 'betting_time' => $bettingTime)
            ));
            return $horseData[0]->horse_name;
        }
        if ($bettingData['action'] == NULL){ //判斷值是否由欄位輸入
            return false;
        }
    }
    //大小單雙遊戲下注刪除
    public static function bsBettingDel($delData)
    {
        if ($delData['action'] != NULL && $delData['action'] == 'delete')  //判斷值是否由欄位輸入
        {
            $horseData = horseRaceM::horseDataOne($delData['hId']);  //賽馬hid
            DB::table('bs_sdBetting')->where('num', '=', $delData['num'])->delete();
            return $horseData[0]->horse_name;
        }
        if ($delData['action'] == NULL){ //判斷值是否由欄位輸入
            return false;
        }
    }
    //大小單雙遊戲金額新增
    public static function bsBettingMoneyInsert($bettingData)
    {
        $user = Auth::user();
        $userId = $user->id;

        if ($bettingData['action'] != NULL && $bettingData['action'] == 'bsBetting') //判斷值是否由欄位輸入
        {
        $money = $bettingData['money'];          //下注金額
        $rowUserMoney = DB::table('member')
            ->select('money')
            ->where('id',$userId)
            ->get();
        $userMoney = $rowUserMoney[0]->money;    //查詢玩家現餘金額
        $updateMoney = $userMoney-$money;        //下注後剩餘金額
        DB::table('member')
            ->where('id', $userId)
            ->update(['money' => $updateMoney]); //修改玩家剩餘金額
            DB::table('bs_sdBetting')
                ->where('num', $bettingData['num'])
                ->update(['money' => $bettingData['money'], 'control' => $bettingData['control'], 'count' => 0]); //修改玩家剩餘金額

            return $bettingData['horseName'];
        }
        if ($bettingData['action'] == NULL){ //判斷值是否由欄位輸入
            return false;
        }
    }
    //賽馬比單數遊戲投注結果(計算輸贏)
    public static function singleBettingResult()
    {
        $singleHId = array();
        $rankHId = horseRaceM::RankDistinguish();
        $j=0;
        for($i=0 ; $i<10 ; $i++) {
            if($i % 2 == 0) {
                $singleHId[$j] = $rankHId[$i];  //賽馬比單數hid
                $j++;
            }
        }
        foreach ($singleHId as $value){
                DB::table('bs_sdBetting')
                    ->where('count', 0)                    //是否已計算
                    ->where('control', 1)                  //下注"單數"的玩家
                    ->where('h_id', $value)                //中獎的馬號
                    ->update(['win' => 1, 'count' => 1]);  //修改成贏家和尚未派彩
        }
    }
    //賽馬比雙數遊戲投注結果(計算輸贏)
    public static function doubleBettingResult()
    {
        $doubleHId = array();
        $rankHId = horseRaceM::RankDistinguish();
        $j = 0;
        for($i=0 ; $i<10 ; $i++) {
            if($i % 2 == 1) {
                $doubleHId[$j] = $rankHId[$i];  //賽馬比雙數hid
                $j++;
            }
        }
        foreach ($doubleHId as $value){
            DB::table('bs_sdBetting')
                ->where('count', 0)                   //是否已計算
                ->where('control', 2)                 //下注"雙數"的玩家
                ->where('h_id', $value)               //中獎的馬號
                ->update(['win' => 1,'count' => 1]);  //修改成贏家和尚未派彩
        }
    }
    //賽馬比小遊戲投注結果(計算輸贏)
    public static function smallerBettingResult()
    {
        $smallerHId = array();
        $rankHId = horseRaceM::RankDistinguish();
        for($i=0 ; $i<5 ; $i++) {
            $smallerHId[$i] = $rankHId[$i];  //賽馬比小hid
        }
        foreach ($smallerHId as $value){
            DB::table('bs_sdBetting')
                ->where('count', 0)                   //是否已計算
                ->where('control', 3)                 //下注"小"的玩家
                ->where('h_id', $value)               //中獎的馬號
                ->update(['win' => 1,'count' => 1]);  //修改成贏家和尚未派彩
        }
    }
    //賽馬比大遊戲投注結果(計算輸贏)
    public static function biggerBettingResult()
    {
        $biggerHId = array();
        $rankHId = horseRaceM::RankDistinguish();
        for($i=0 ; $i<5 ; $i++) {
            $j = $i + 5;
            $biggerHId[$i] = $rankHId[$j];  //賽馬比大hid
        }
        foreach ($biggerHId as $value){
            DB::table('bs_sdBetting')
                ->where('count', 0)                   //是否已計算
                ->where('control', 4)                 //下注"大"的玩家
                ->where('h_id', $value)               //中獎的馬號
                ->update(['win' => 1,'count' => 1]);  //修改成贏家和尚未派彩
        }
    }
}