<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use App\Models\horseRaceM as horseRace;

class positionGameM extends horseRace
{
    //定位遊戲下注新增
    public function poBettingInsert($bettingData)
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
    //定位遊戲下注刪除
    public function poBettingDel($delData)
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
    //定位遊戲金額新增
    public function poBettingMoneyInsert($bettingData)
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
                    ->update(['win' => 1, 'count' => 1]);   //修改成贏家和尚未派彩
            }
            }
    }
    //定位賽馬遊戲派彩資料修改
    public function pgRaceBonus(){

        $this->positionBettingResult();             //下注定位賽馬輸贏結果運算

        $rowSDPayData=DB::table('bs_sdBetting')     //查詢下注定位賽馬贏家uId,下注金額
        ->select('user_id','money')
            ->where('control',5)
            ->where('win',1)
            ->where('count',1)
            ->get();
        $rowOdds=DB::table('horseGame_data')           //查詢遊戲賠率
        ->select('odds')
            ->where('game_name','賽馬定位遊戲')
            ->get();
        $odds=$rowOdds[0]->odds;

        $count=count($rowSDPayData);
        for ($i=0;$i<$count;$i++) {                    //定位賽馬下注贏家派彩
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
}