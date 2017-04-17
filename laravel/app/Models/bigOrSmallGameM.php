<?php

class bigOrSmallGameM
{
    public function __construct()
    {

    }
    //大小單雙遊戲下注新增
    public function bsBettingInsert()
    {
        $user = Auth::user();
        $userName = $user->name;
        $rowId=DB::table('member')
            ->select('id')
            ->where('user_name', $userName)
            ->get();
        $userId=$rowId[0]->id;
        $input = Input::all();
        $money = $input['money'];
        $control = $input['control'];
        date_default_timezone_set("Asia/Taipei"); //目前時間
        $bettingTime = date("Y-m-d H:i:s");

        if ($input['action'] != NULL && $input['action'] == 'insert')         //判斷值是否由欄位輸入
        {
            DB::table('bs_sdBetting')->insert(array(                          //新增會員資料
                array('user_id' => $userId, 'user_name' => $userName, 'money' => $money, 'betting_time' => $bettingTime, 'control' => $control)
            ));
            return $userName;
        }else{
            return false;
        }
    }
    //大小遊戲投注結果(計算輸贏)
    public function bsBettingResult()
    {

    }
    //單雙遊戲投注結果(計算輸贏)
    public function sdBettingResult()
    {

    }
    //大小單雙遊戲派彩資料修改
    public function bsRaceBonus()
    {

    }
}