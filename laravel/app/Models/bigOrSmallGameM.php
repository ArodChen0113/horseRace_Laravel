<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use App\Models\horseRaceM as horseRace;

class bigOrSmallGameM extends horseRace
{
    //大小單雙遊戲下注新增
    public function bsBettingInsert($bettingData)
    {
        $user = Auth::user();
        $userName = $user->name;
        $userId=$user->id;
        $bettingTime = $this->nowDateTime();  //現在時間
        $horseData = $this->horseName($bettingData->HId);  //賽馬資料

        if ($bettingData->action != NULL && $bettingData->action == 'insert')  //判斷值是否由欄位輸入
        {
            DB::table('bs_sdBetting')->insert(array(                          //新增下注資料
                array('user_id' => $userId, 'user_name' => $userName, 'h_id' => $bettingData->HId, 'betting_time' => $bettingTime, 'control' => $bettingData->control)
            ));
            return $horseData[0]->horse_name;
        }else{
            return false;
        }
    }
    //大小單雙遊戲下注刪除
    public function bsBettingDel($delData)
    {
        if ($delData->action != NULL && $delData->action == 'delete')      //判斷值是否由欄位輸入
        {
            $horseData=$this->horseName($delData->HId);
            DB::table('bs_sdBetting')->where('num', '=', $delData->num)->delete();
            return $horseData[0]->horse_name;
        }else{
            return false;
        }
    }
    //大小單雙遊戲金額新增
    public function bsBettingMoneyInsert($bettingData)
    {
        $user = Auth::user();
        $userName = $user->name;
        $userId = $user->id;

        if ($bettingData->action != NULL && $bettingData->action == 'betting')         //判斷值是否由欄位輸入
        {
        $money = $bettingData->money;             //下注金額
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
                ->where('num', $bettingData->num)
                ->update(['money' => $bettingData->money]);  //修改玩家剩餘金額

            return $userName;
        }else{
            return false;
        }
    }
    //賽馬比單數遊戲投注結果(計算輸贏)
    public function singleBettingResult()
    {
        $rankHId=$this->RankDistinguish();
        for($i=0;$i<10;$i++) {
            if($i % 2 == 0) {
                $singleHId[$i] = $rankHId[$i];  //賽馬比單數hid
            }
        }
        $count=count($singleHId);
        for ($i=0;$i<$count;$i++) {
            DB::table('bs_sdBetting')
                ->where('count', 0)                    //是否已計算
                ->where('control', 1)                  //下注"單數"的玩家
                ->where('h_id', $singleHId[$i])        //中獎的馬號
                ->update(['win' => 1,'count' => 1]);   //修改成贏家和尚未派彩
        }
    }
    //賽馬比雙數遊戲投注結果(計算輸贏)
    public function doubleBettingResult()
    {
        $rankHId=$this->RankDistinguish();
        for($i=0;$i<10;$i++) {
            if($i % 2 == 1) {
                $doubleHId[$i] = $rankHId[$i];  //賽馬比雙數hid
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
    //單雙遊戲派彩資料修改
    public function sdRaceBonus()
    {
        $this->singleBettingResult();   //下注"單數"輸贏結果運算
        $this->doubleBettingResult();   //下注"雙數"輸贏結果運算

        $rowSDPayData=DB::table('bs_sdBetting')     //查詢下注單雙數贏家uId,下注金額
        ->select('user_id','money')
            ->where('control',1)
            ->orWhere('control', 2)
            ->where('win',1)
            ->where('count',1)
            ->get();
        $rowOdds=DB::table('horseGame_data')           //查詢遊戲賠率
            ->select('odds')
            ->where('game_name','賽馬單雙遊戲')
            ->get();
        $odds=$rowOdds[0]->odds;

        $count=count($rowSDPayData);
        for ($i=0;$i<$count;$i++) {                    //單雙數下注贏家派彩
            $value=$rowSDPayData[$i];
            $rowUserMoney=DB::table('member')
            ->select('money')
                ->where('id',$value->user_id)
                ->get();
            $userMoney=$rowUserMoney[0]->money;        //查詢贏家現餘金額
            $bettingMoney=$value->money;               //下注金額
            $winMoney=$bettingMoney*$odds;             //贏得金額
            $sumMoney=$userMoney+$winMoney;            //計算贏得後總金額

            DB::table('member')
                ->where('id', $value->user_id)
                ->update(['money' => $sumMoney]);      //修改最終贏得金額
        }
    }
    //大小遊戲派彩資料修改
    public function bsRaceBonus()
    {
        $this->biggerBettingResult();    //下注"大"輸贏結果運算
        $this->smallerBettingResult();   //下注"小"輸贏結果運算

        $rowBSPayData=DB::table('bs_sdBetting')     //查詢贏家uId,下注金額
        ->select('user_id','money')
            ->where('control',3)
            ->orWhere('control', 4)
            ->where('win',1)
            ->where('count',1)
            ->get();
        $rowOdds=DB::table('horseGame_data')           //查詢遊戲賠率
        ->select('odds')
            ->where('game_name','賽馬大小遊戲')
            ->get();
        $odds=$rowOdds[0]->odds;

        $count=count($rowBSPayData);
        for ($i=0;$i<$count;$i++) {                    //大小下注贏家派彩
            $value=$rowBSPayData[$i];
            $rowUserMoney=DB::table('member')
                ->select('money')
                ->where('id',$value->user_id)
                ->get();
            $userMoney=$rowUserMoney[0]->money;        //查詢贏家現餘金額
            $bettingMoney=$value->money;               //下注金額
            $winMoney=$bettingMoney*$odds;             //贏得金額
            $sumMoney=$userMoney+$winMoney;            //計算贏得後總金額

            DB::table('member')
                ->where('id', $value->user_id)
                ->update(['money' => $sumMoney]);      //贏家派彩
        }
    }
}