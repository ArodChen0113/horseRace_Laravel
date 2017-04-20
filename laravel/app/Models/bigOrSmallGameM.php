<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use App\Models\horseRaceM as horseRace;
use Illuminate\Support\Facades\Auth;
use App\Models\horseRaceM;

class bigOrSmallGameM extends horseRace
{
    //大小單雙下注資料總覽
    public function bsBettingData(){
        $horseRaceM = new horseRaceM();
        $horseRaceData = $horseRaceM->horseRaceData();   //賽馬場次資料
        $count=count($horseRaceData);
        for ($i=0;$i<$count;$i++) {
            $value=$horseRaceData[$i];
            $bettingData = DB::table('bs_sdBetting') //該場次下注資料
                ->select('money')
                ->whereIn('control', [1, 2, 3, 4])
                ->where('open_time',$value->end_time)
                ->get();

            $sumBettingMoney=0;
            $numBettingData=count($bettingData);         //該場次投注筆數
            for($j=0;$j<$numBettingData;$j++){
                $value2=$bettingData[$j];
                $bettingMoney=$value2->money;
                $sumBettingMoney=$sumBettingMoney+$bettingMoney; //該場次投注總金額
            }
            $bettingLose = DB::table('bs_sdBetting')
            ->select('money')
                ->whereIn('control', [1, 2, 3, 4])
                ->where('win', 1)
                ->where('open_time',$value->end_time)
                ->get();
            $loseMoney=0;
            $numBettingWin=count($bettingLose);
            for($j=0;$j<$numBettingWin;$j++){
                $value3=$bettingLose[$j];
                $bettingMoneyLose=$value3->money;
                $gameName='賽馬大小遊戲';
                $odds=$horseRaceM->raceOddsOneData($gameName);
                $bettingMoneyLose=$bettingMoneyLose*$odds[0]->odds;
                $loseMoney=$loseMoney+$bettingMoneyLose; //該場次投注虧損金額
            }
            $winMoney=$sumBettingMoney-$loseMoney;
            $bsHorseRaceResultData[$i]=['num'=>$value->num,'raceCount'=>$numBettingData,'sumBettingMoney'=>$sumBettingMoney,'winMoney'=>$winMoney,'loseMoney'=>$loseMoney];
        }
        return $bsHorseRaceResultData;
    }
    //大小單雙總獲利
    public function sumProfit(){
        $bsHorseRaceResultData=$this->bsBettingData();
        $sumProfit=0;
        $count=count($bsHorseRaceResultData);
        for($i=0;$i<$count;$i++){
            $value=$bsHorseRaceResultData[$i];
            $sumProfit=$sumProfit+$value['winMoney'];
        }
        return $sumProfit;
    }
    //大小單雙遊戲下注新增
    public function bsBettingInsert($bettingData)
    {
        $user = Auth::user();
        $userName = $user->name;
        $userId=$user->id;
        $bettingTime = $this->nowDateTime();  //現在時間
        $horseData = $this->horseDataOne($bettingData['h_id']);  //賽馬資料

        if ($bettingData['action'] != NULL && $bettingData['action'] == 'insert')  //判斷值是否由欄位輸入
        {
            DB::table('bs_sdBetting')->where('user_id', '=', $userId)->where('count', '=', 9)->delete(); //清空之前下注紀錄
            DB::table('bs_sdBetting')->insert(array(                          //新增下注資料
                array('user_id' => $userId, 'user_name' => $userName, 'h_id' => $bettingData['h_id'],'horse_name' => $bettingData['horseName'], 'horse_picture' => $bettingData['horsePic'], 'betting_time' => $bettingTime)
            ));
            return $horseData[0]->horse_name;
        }else{
            return false;
        }
    }
    //大小單雙遊戲下注刪除
    public function bsBettingDel($delData)
    {
        if ($delData['action'] != NULL && $delData['action'] == 'delete')      //判斷值是否由欄位輸入
        {
            $horseData=$this->horseDataOne($delData['hId']);
            DB::table('bs_sdBetting')->where('num', '=', $delData['num'])->delete();
            return $horseData[0]->horse_name;
        }else{
            return false;
        }
    }
    //大小單雙遊戲金額新增
    public function bsBettingMoneyInsert($bettingData)
    {
        $user = Auth::user();
        $userId = $user->id;

        if ($bettingData['action'] != NULL && $bettingData['action'] == 'bsBetting')         //判斷值是否由欄位輸入
        {
        $money = $bettingData['money'];             //下注金額
        $rowUserMoney=DB::table('member')
            ->select('money')
            ->where('id',$userId)
            ->get();
        $userMoney=$rowUserMoney[0]->money;       //查詢玩家現餘金額
        $updateMoney=$userMoney-$money;           //下注後剩餘金額
        DB::table('member')
            ->where('id', $userId)
            ->update(['money' => $updateMoney]);  //修改玩家剩餘金額
            DB::table('bs_sdBetting')
                ->where('num', $bettingData['num'])
                ->update(['money' => $bettingData['money'],'control' => $bettingData['control'],'count' => 0]);  //修改玩家剩餘金額

            return $bettingData['horseName'];
        }else{
            return false;
        }
    }
    //賽馬比單數遊戲投注結果(計算輸贏)
    public function singleBettingResult()
    {
        $rankHId=$this->RankDistinguish();
        $j=0;
        for($i=0;$i<10;$i++) {
            if($i % 2 == 0) {
                $singleHId[$j] = $rankHId[$i];  //賽馬比單數hid
                $j++;
            }
        }
        $count=count($singleHId);
        for ($i=0;$i<$count;$i++) {
                DB::table('bs_sdBetting')
                    ->where('count', 0)//是否已計算
                    ->where('control', 1)//下注"單數"的玩家
                    ->where('h_id', $singleHId[$i])//中獎的馬號
                    ->update(['win' => 1, 'count' => 1]);   //修改成贏家和尚未派彩
        }
    }
    //賽馬比雙數遊戲投注結果(計算輸贏)
    public function doubleBettingResult()
    {
        $rankHId=$this->RankDistinguish();
        $j=0;
        for($i=0;$i<10;$i++) {
            if($i % 2 == 1) {
                $doubleHId[$j] = $rankHId[$i];  //賽馬比雙數hid
                $j++;
            }
        }
        $count=count($doubleHId);
        for ($i=0;$i<$count;$i++) {
            DB::table('bs_sdBetting')
                ->where('count', 0)                    //是否已計算
                ->where('control', 2)                  //下注"雙數"的玩家
                ->where('h_id', $doubleHId[$i])        //中獎的馬號
                ->update(['win' => 1,'count' => 1]);   //修改成贏家和尚未派彩
        }
    }
    //賽馬比小遊戲投注結果(計算輸贏)
    public function smallerBettingResult()
    {
        $rankHId=$this->RankDistinguish();
        for($i=0;$i<5;$i++) {
            $smallerHId[$i] = $rankHId[$i];  //賽馬比小hid
        }
        $count=count($smallerHId);
        for ($i=0;$i<$count;$i++) {
            DB::table('bs_sdBetting')
                ->where('count', 0)                    //是否已計算
                ->where('control', 3)                  //下注"小"的玩家
                ->where('h_id', $smallerHId[$i])       //中獎的馬號
                ->update(['win' => 1,'count' => 1]);   //修改成贏家和尚未派彩
        }
    }
    //賽馬比大遊戲投注結果(計算輸贏)
    public function biggerBettingResult()
    {
        $rankHId=$this->RankDistinguish();
        for($i=0;$i<5;$i++) {
            $j=$i+5;
            $biggerHId[$i] = $rankHId[$j];  //賽馬比大hid
        }
        $count=count($biggerHId);
        for ($i=0;$i<$count;$i++) {
            DB::table('bs_sdBetting')
                ->where('count', 0)                    //是否已計算
                ->where('control', 4)                  //下注"大"的玩家
                ->where('h_id', $biggerHId[$i])        //中獎的馬號
                ->update(['win' => 1,'count' => 1]);   //修改成贏家和尚未派彩
        }
    }
    //大小單雙遊戲派彩資料修改
    public function RaceBonus()
    {
        $this->singleBettingResult();   //下注"單數"輸贏結果運算

        $rowSDPayData=DB::table('bs_sdBetting')   //查詢下注單雙數贏家uId,下注金額
        ->select('num','user_id','money')
            ->whereIn('control', [1 , 2 , 3 , 4])
            ->where('win',1)
            ->where('count',1)
            ->get();
        $rowOdds=DB::table('horseGame_data')           //查詢遊戲賠率
        ->select('odds')
            ->where('game_name','賽馬單雙遊戲')
            ->get();
        $odds=$rowOdds[0]->odds;

        if($rowSDPayData!=NULL) {
            $count = count($rowSDPayData);
            for ($i = 0; $i < $count; $i++) {                    //單雙數下注贏家派彩
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
                    ->update(['count' => 2]);            //改為已派彩
            }
        }
    }
}