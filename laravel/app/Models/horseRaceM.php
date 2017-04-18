<?php
namespace App\Models;

use DB;
use Input;
use Illuminate\Http\UploadedFile;

class horseRaceM
{
    public function __construct()
    {

    }
    //計算賽馬名次
    public function horseRaceResult(){
        $input = Input::all();
        $rank=array();
        $horseCount=10;
        $count=0;
        while ($count<$horseCount) {           //計算賽馬名次
            $number = rand(1, $horseCount);
            if (!in_array($number, $rank)) { //去陣列重複值
                $rank[$count] = $number;
                $rowHId=DB::table('horseGame_horse')
                    ->select('h_id')
                    ->where('g_id', $$number)
                    ->get();
                $result[$count] = $rowHId[0]->h_id;
                $count++;
            }
        }

        date_default_timezone_set("Asia/Taipei"); //目前時間
        $endTime = date("Y-m-d H:i:s");
        if ($input['action'] != NULL && $input['action'] == 'insert')           //判斷值是否由欄位輸入
        {
            DB::table('bs_sdBetting')->insert(array(                            //新增會員資料
                array('firth' => $result[0], 'second' => $result[1], 'third' => $result[2], 'fourth' => $result[3], 'fifth' => $result[4], 'sixth' => $result[5], 'seventh' => $result[6], 'eighth' => $result[7], 'ninth' => $result[8], 'tenth' => $result[9], 'end_time' => $endTime )
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
    //賠率修改
    public function raceOddsUpdate()
    {
        $input = Input::all();
        if ($input['action'] != NULL && $input['action'] == 'update')      //判斷值是否由欄位輸入
        {
            DB::table('horseGame_data')
                ->where('game_name', $input['gameName'])
                ->update(['odds' => $input['odds']]);
            return $input['gameName'];
        } else {
            return false;
        }
    }
    //賽馬遊戲開關
    public function horseRaceControl(){
        $input = Input::all();
        if ($input['action'] != NULL && $input['action'] == 'update')      //判斷值是否由欄位輸入
        {
            if($input['gameName']==0) {
                DB::table('horseGame_data')
                    ->where('game_name', $input['gameName'])
                    ->update(['open' => 1]);
            }
            if($input['gameName']==1) {
                DB::table('horseGame_data')
                    ->where('game_name', $input['gameName'])
                    ->update(['open' => 0]);
            }
            return $input['gameName'];
        }else{
            return false;
        }
    }
}