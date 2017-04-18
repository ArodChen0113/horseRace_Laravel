<?php
namespace App\Models;

use DB;
use Illuminate\Http\UploadedFile;

class memberM
{
    public function __construct()
    {

    }
    //會員資料新增
    public function memberInt($memberData)
    {
        date_default_timezone_set("Asia/Taipei"); //目前時間
        $created_at = date("Y-m-d H:i:s");

        if ($memberData->action != NULL && $memberData->action == 'insert')   //判斷值是否由欄位輸入
        {
                DB::table('member')->insert(array(                            //新增會員資料
                    array('user_name' => $memberData->userName, 'email' => $memberData->email, 'password' => $memberData->password, 'money' => $memberData->money, 'created_at' => $created_at)
                ));
            return $memberData->userName;
        }else{
            return false;
        }
    }
    //會員資料修改
    public function memberUp($memberData)
    {
        if ($memberData->action != NULL && $memberData->action == 'update')      //判斷值是否由欄位輸入
        {
            DB::table('member')
                ->where('id', $memberData->id)
                ->update(['user_name' => $memberData->userName,'email' => $memberData->email,'password' => $memberData->password]);
            $userName=$memberData->userName;
            return $userName;
        }else{
            return false;
        }
    }
    //會員資料刪除
    public function memberDel($memberData)
    {
        if ($memberData->action != NULL && $memberData->action == 'delete')      //判斷值是否由欄位輸入
        {
            $rowName=DB::table('member')
                ->select('user_name')
                ->where('id', $memberData->id)
                ->get();
            $userName=$rowName[0]->user_name;
            DB::table('member')->where('id', '=', $memberData->id)->delete();
            return $userName;
        }else{
            return false;
        }
    }
    //會員儲值修改
    public function accountStoredValueUp($memberData)
    {
        if ($memberData->action != NULL && $memberData->action == 'update')      //判斷值是否由欄位輸入
        {
            $rowName=DB::table('member')
                ->select('user_name')
                ->where('id', $memberData->id)
                ->get();
            $userName=$rowName[0]->user_name;
            DB::table('member')
                ->where('id', $memberData->id)
                ->update(['money' => $memberData->money]);
            return $userName;
        }else{
            return false;
        }
    }
}