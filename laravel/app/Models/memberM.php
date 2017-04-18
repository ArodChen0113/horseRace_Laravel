<?php
namespace App\Models;

use DB;
use Input;
use Illuminate\Http\UploadedFile;

class memberM
{
    public function __construct()
    {

    }
    //會員資料新增
    public function memberInt()
    {
        $input = Input::all();
        $userName = $input['user_Name'];
        $email = $input['email'];
        $password = $input['password'];
        $money = $input['money'];
        date_default_timezone_set("Asia/Taipei"); //目前時間
        $created_at = date("Y-m-d H:i:s");

        if ($input['action'] != NULL && $input['action'] == 'insert')         //判斷值是否由欄位輸入
        {
                DB::table('member')->insert(array(                            //新增會員資料
                    array('user_name' => $userName, 'email' => $email, 'password' => $password, 'money' => $money, 'created_at' => $created_at)
                ));
            return $userName;
        }else{
            return false;
        }
    }
    //會員資料修改
    public function memberUp()
    {
        $input = Input::all();
        if ($input['action'] != NULL && $input['action'] == 'update')      //判斷值是否由欄位輸入
        {
            DB::table('member')
                ->where('id', $input['id'])
                ->update(['user_name' => $input['userName'],'email' => $input['email'],'password' => $input['password']]);
            $userName=$input['userName'];
            return $userName;
        }else{
            return false;
        }
    }
    //會員資料刪除
    public function memberDel()
    {
        $input = Input::all();
        if ($input['action'] != NULL && $input['action'] == 'delete')      //判斷值是否由欄位輸入
        {
            $rowName=DB::table('member')
                ->select('user_name')
                ->where('id', $input['id'])
                ->get();
            $userName=$rowName[0]->user_name;
            DB::table('member')->where('id', '=', $input['id'])->delete();
            return $userName;
        }else{
            return false;
        }
    }
    //會員儲值修改
    public function accountStoredValueUp()
    {
        $input = Input::all();
        if ($input['action'] != NULL && $input['action'] == 'update')      //判斷值是否由欄位輸入
        {
            $rowName=DB::table('member')
                ->select('user_name')
                ->where('id', $input['id'])
                ->get();
            $userName=$rowName[0]->user_name;
            DB::table('member')
                ->where('id', $input['id'])
                ->update(['money' => $input['money']]);
            return $userName;
        }else{
            return false;
        }
    }
}