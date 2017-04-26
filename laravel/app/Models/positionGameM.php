<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use App\Models\horseRaceM as horseRace;
use Illuminate\Support\Facades\Auth;

class positionGameM extends horseRace
{
    //指定場次下注資料
    public static function poEndTimeBettingData($endTime){

        $poEndTimeBettingData = DB::table('bs_sdBetting')
        ->select('money','odds')
            ->where('control', 5)
            ->where('open_time', $endTime);
        return $poEndTimeBettingData;
    }
    //定位賽馬下注資料總覽
    public static function poBettingData(){

        $poHorseRaceResultData = array();
        $horseRaceData = horseRaceM::horseRaceData(); //賽馬場次資料
        foreach ($horseRaceData as $value){
            $bettingData = positionGameM::poEndTimeBettingData($value->end_time)->get(); //指定場次下注資料
            $sumBettingMoney = 0;
            foreach ($bettingData as $value2){
                $sumBettingMoney += $value2->money; //該場次投注總金額
            }
            $bettingLose = positionGameM::poEndTimeBettingData($value->end_time)->where('win', 1)->get(); //指定場次下注資料
            $loseMoney = 0;
            foreach ($bettingLose as $value3){
                $value3->money *= $value3->odds; //單筆虧損金額
                $loseMoney += $value3->money;    //該場次投注虧損總金額
            }
            $winMoney = $sumBettingMoney - $loseMoney;
            $poHorseRaceResultData[] = ['num' => $value->num, 'raceCount' => count($bettingData),
                'sumBettingMoney' => $sumBettingMoney, 'winMoney' => $winMoney, 'loseMoney' => $loseMoney];
        }
        return $poHorseRaceResultData;
    }
    //定位賽馬總獲利
    public static function sumProfit(){
        $bsHorseRaceResultData = positionGameM::poBettingData();
        $sumProfit = 0;
        foreach ($bsHorseRaceResultData as $value){
            $sumProfit += $value['winMoney'];
        }
        return $sumProfit;
    }
    //定位遊戲下注新增
    public static function poBettingInsert($bettingData)
    {
        if ($bettingData['action'] == NULL || $bettingData['action'] != 'insert')  //判斷值是否由欄位輸入
        {
            return false;
        }
        $user = Auth::user();
        $bettingTime = horseRaceM::nowDateTime();  //現在時間
        $horseData = horseRaceM::horseDataOne($bettingData['h_id']); //賽馬資料
        $gameName = '賽馬定位遊戲';
        $odds = horseRaceM::raceOddsOneData($gameName); //查詢賠率

            DB::table('bs_sdBetting')->where('user_id', '=', $user->id)->where('control', '=', 0)->delete();  //清空之前下注紀錄
            DB::table('bs_sdBetting')->insert(array(    //新增下注資料
                array('user_id' => $user->id, 'user_name' => $user->name, 'h_id' => $bettingData['h_id'], 'horse_name' => $bettingData['horseName'],
                    'odds' => $odds[0]->odds, 'horse_picture' => $bettingData['horsePic'], 'betting_time' => $bettingTime)
            ));
            return $horseData[0]->horse_name;
    }
    //定位遊戲下注刪除
    public static function poBettingDel($delData)
    {
        if ($delData['action'] == NULL || $delData['action'] != 'delete') //判斷值是否由欄位輸入
        {
            return false;
        }
            $horseData = horseRaceM::horseDataOne($delData['hId']);
            DB::table('bs_sdBetting')->where('num', '=', $delData['num'])->delete();
            return $horseData[0]->horse_name;
    }
    //定位遊戲金額新增
    public static function poBettingMoneyInsert($bettingData)
    {
        if ($bettingData['action'] == NULL || $bettingData['action'] != 'poBetting') //判斷值是否由欄位輸入
        {
            return false;
        }
        $user = Auth::user();
        $memberData = memberM::memberSelOne($user->id); //查詢會員資料
        $updateMoney = $memberData[0]->money - $bettingData['money']; //下注後剩餘金額
            DB::table('member')
                ->where('id', $user->id)
                ->update(['money' => $updateMoney]);  //修改玩家剩餘金額
            DB::table('bs_sdBetting')
                ->where('num', $bettingData['num'])
                ->update(['money' => $bettingData['money'], 'control' => $bettingData['control'], 'h_rank' => $bettingData['rank'], 'count' => 0]);  //修改玩家剩餘金額

            return $bettingData['horseName'];
    }
    //賽馬定位遊戲投注結果(計算輸贏)
    public static function positionBettingResult()
    {
        $rankHId = horseRaceM::RankDistinguish();         //賽馬名次hid
        $rowBettingData = DB::table('bs_sdBetting')       //玩家下注資料
            ->select('h_id','h_rank','user_id')
            ->where('control', 5)
            ->where('count', 0)
            ->get();
        foreach ($rowBettingData as $value){//列出玩家下注資料
            $value->h_rank--;
            if($rankHId[$value->h_rank] == $value->h_id) {   //比對下注名次馬號是否相符
                DB::table('bs_sdBetting')
                    ->where('user_id', $value->user_id)
                    ->where('count', 0)                   //是否已計算
                    ->where('control', 5)                 //下注"大"的玩家
                    ->update(['win' => 1, 'count' => 1]); //修改成贏家和尚未派彩
            }
        }
    }
}