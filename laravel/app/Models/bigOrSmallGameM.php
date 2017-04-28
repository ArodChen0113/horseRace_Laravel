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
    //指定場次下注資料
    public static function bsEndTimeBettingData($endTime){

        $poEndTimeBettingData = DB::table('bs_sdBetting')
            ->select('money','odds')
            ->whereIn('control', [1, 2, 3, 4])
            ->where('open_time', $endTime);
        return $poEndTimeBettingData;
    }
    //大小單雙下注總覽資料
    public static function bsBettingData()
    {
        $bsHorseRaceResultData = array();
        $horseRaceData = horseRaceM::horseRaceData(); //賽馬場次資料
        foreach ($horseRaceData as $value){
            $bettingData = bigOrSmallGameM::bsEndTimeBettingData($value->end_time)->get(); //指定場次下注資料
            $sumBettingMoney = 0;
            foreach ($bettingData as $value2){
                $sumBettingMoney += $value2->money;  //該場次投注總金額
            }
            $bettingLose = bigOrSmallGameM::bsEndTimeBettingData($value->end_time)->where('win', 1)->get();
            $loseMoney = 0;
            foreach ($bettingLose as $value3){
                $value3->money *= $value3->odds;
                $loseMoney += $value3->money;  //該場次虧損金額
            }
            $winMoney = $sumBettingMoney - $loseMoney;  //剛場次獲利金額
            $bsHorseRaceResultData[] = ['num' => $value->num, 'raceCount' => count($bettingData),
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
        if ($bettingData['action'] == NULL || $bettingData['action'] != 'bsBetting') //判斷值是否由欄位輸入
        {
            return false;
        }
        $user = Auth::user();
        $bettingTime = horseRaceM::nowDateTime();  //現在時間
        $gameName = '賽馬大小遊戲';
        $odds = horseRaceM::raceOddsOneData($gameName); //查詢賠率

        DB::table('bs_sdBetting')->where('user_id', '=', $user->id)->where('control', '=', 0)->delete();  //清空之前下注紀錄
        DB::table('bs_sdBetting')->insert(array(  //新增下注資料
            array('user_id' => $user->id, 'user_name' => $user->name, 'odds' => $odds[0]->odds, 'h_rank' => $bettingData['rank'],
                'money' => $bettingData['money'], 'control' => $bettingData['control'], 'count' => 0, 'betting_time' => $bettingTime)
        ));
        $memberData = memberM::memberSelOne($user->id); //查詢會員資料
        $updateMoney = $memberData[0]->money - $bettingData['money']; //下注後剩餘金額
        DB::table('member')
            ->where('id', $user->id)
            ->update(['money' => $updateMoney]);  //修改玩家剩餘金額

        $reBettingData = ['h_rank' => $bettingData['rank'], 'control' => $bettingData['control']];
            return $reBettingData;
    }
    //賽馬單雙小大遊戲投注結果(計算輸贏)
    public static function sdBettingResult()
    {
        $bettingData = DB::table('bs_sdBetting')
            ->select('num','h_rank','control')
            ->where('count', 0)
            ->get();
        $rankHId = horseRaceM::RankDistinguish(); //賽馬名次
        foreach ($bettingData as $value) {
            $value->h_rank--; //下注名次
            //賽馬比單數計算輸贏
            if ($value->control == 1 && $rankHId[$value->h_rank] % 2 == 1) {
                DB::table('bs_sdBetting')
                    ->where('num', $value->num)//中獎的彩劵編號
                    ->update(['win' => 1, 'count' => 1]);  //修改成贏家和尚未派彩
            }
            //賽馬比雙數計算輸贏
            if ($value->control == 2 && $rankHId[$value->h_rank] % 2 == 0) {
                DB::table('bs_sdBetting')
                    ->where('num', $value->num)//中獎的彩劵編號
                    ->update(['win' => 1, 'count' => 1]);  //修改成贏家和尚未派彩
            }
            //賽馬比小數計算輸贏
            if ($value->control == 3 && $rankHId[$value->h_rank] <= 5) {
                DB::table('bs_sdBetting')
                    ->where('num', $value->num)//中獎的彩劵編號
                    ->update(['win' => 1, 'count' => 1]);  //修改成贏家和尚未派彩

            }
            //賽馬比大數計算輸贏
            if ($value->control == 4 && $rankHId[$value->h_rank] > 5) {
                DB::table('bs_sdBetting')
                    ->where('num', $value->num)//中獎的彩劵編號
                    ->update(['win' => 1, 'count' => 1]);  //修改成贏家和尚未派彩
            }
        }
    }
}