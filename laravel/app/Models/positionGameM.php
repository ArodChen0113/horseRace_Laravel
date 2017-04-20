<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use App\Models\horseRaceM as horseRace;
use Illuminate\Support\Facades\Auth;

class positionGameM extends horseRace
{
    //定位賽馬下注資料總覽
    public function poBettingData(){
        $horseRaceM = new horseRaceM();
        $horseRaceData = $horseRaceM->horseRaceData();   //賽馬場次資料
        $count=count($horseRaceData);
        for ($i=0;$i<$count;$i++) {
            $value=$horseRaceData[$i];
            $bettingData = DB::table('bs_sdBetting') //該場次下注資料
            ->select('money')
                ->where('control', 5)
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
                ->where('control', 5)
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
            $poHorseRaceResultData[$i]=['num'=>$value->num,'raceCount'=>$numBettingData,'sumBettingMoney'=>$sumBettingMoney,'winMoney'=>$winMoney,'loseMoney'=>$loseMoney];
        }
        return $poHorseRaceResultData;
    }
    //定位賽馬總獲利
    public function sumProfit(){
        $bsHorseRaceResultData=$this->poBettingData();
        $sumProfit=0;
        $count=count($bsHorseRaceResultData);
        for($i=0;$i<$count;$i++){
            $value=$bsHorseRaceResultData[$i];
            $sumProfit=$sumProfit+$value['winMoney'];
        }
        return $sumProfit;
    }
    //定位遊戲下注新增
    public function poBettingInsert($bettingData)
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
    //定位遊戲下注刪除
    public function poBettingDel($delData)
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
    //定位遊戲金額新增
    public function poBettingMoneyInsert($bettingData)
    {
        $user = Auth::user();
        $userId = $user->id;

        if ($bettingData['action'] != NULL && $bettingData['action'] == 'poBetting')         //判斷值是否由欄位輸入
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
                ->update(['money'=>$bettingData['money'],'control'=>$bettingData['control'],'h_rank'=>$bettingData['rank'],'count' => 0]);  //修改玩家剩餘金額

            return $bettingData['horseName'];
        }else{
            return false;
        }
    }
    //賽馬定位遊戲投注結果(計算輸贏)
    public function positionBettingResult()
    {
        $rankHId=$this->RankDistinguish();             //賽馬名次hid
        $rowBettingData=DB::table('bs_sdBetting')      //玩家下注資料
            ->select('h_id','h_rank','user_id')
            ->where('control',5)
            ->where('count',0)
            ->get();

        $count=count($rowBettingData);
        for ($i=0;$i<$count;$i++) {
            $value=$rowBettingData[$i];                //列出玩家下注資料
            $bettingHId=$value->h_id;
            $bettingRank=$value->h_rank;
            $bettingRank=$bettingRank-1;
            if($rankHId[$bettingRank]==$bettingHId) {  //比對下注名次馬號是否相符
                DB::table('bs_sdBetting')
                    ->where('user_id', $value->user_id)
                    ->where('count', 0)                    //是否已計算
                    ->where('control', 5)                  //下注"大"的玩家
                    ->update(['win' => 1, 'count' => 1]);   //修改成贏家和尚未派彩
            }
            }
    }
}