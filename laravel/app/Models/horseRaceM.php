<?php

class horseRaceM
{
    public function __construct()
    {

    }
    //計算賽馬名次
    public function horseRaceResult(){
        $input = Input::all();
        $result=array();
        $horseCount=10;
        $count=0;
        while ($count<$horseCount) {           //計算賽馬名次
            $number = rand(1, $horseCount);
            if (!in_array($number, $result)) { //去陣列重複值
                $rowHId=DB::table('horseGame_horse')
                    ->select('h_id')
                    ->where('g_id',$count+1)
                    ->get();
                $hId=$rowHId->h_id;
                $result[$number] = $hId;
                $count++;
            }
        }

        date_default_timezone_set("Asia/Taipei"); //目前時間
        $endTime = date("Y-m-d H:i:s");
        if ($input['action'] != NULL && $input['action'] == 'insert')         //判斷值是否由欄位輸入
        {
            DB::table('bs_sdBetting')->insert(array(                            //新增會員資料
                array('firth' => $result[0], 'second' => $result[1], 'third' => $result[2], 'fourth' => $result[3], 'fifth' => $result[4], 'sixth' => $result[5], 'seventh' => $result[6], 'eighth' => $result[7], 'ninth' => $result[8], 'tenth' => $result[9], 'end_time' => $endTime )
            ));
            return $success=1;
        }else{
            return false;
        }

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