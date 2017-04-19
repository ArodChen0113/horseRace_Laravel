<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;

class memberM
{
    //會員資料搜尋
    public function memberSel()
    {
        $memberData=DB::table('member')
            ->select('email','name','money','id')
            ->get();
        return $memberData;
    }
    //會員單筆資料搜尋
    public function memberSelOne($id)
    {
        $memberData=DB::table('member')
            ->select('email','name','money')
            ->where('id', $id)
            ->get();
        return $memberData;
    }
    //會員資料新增
    public function memberInt($memberData)
    {
        date_default_timezone_set("Asia/Taipei"); //目前時間
        $created_at = date("Y-m-d H:i:s");

        if ($memberData->action != NULL && $memberData->action == 'insert')   //判斷值是否由欄位輸入
        {
                DB::table('member')->insert(array(                            //新增會員資料
                    array('name' => $memberData->userName, 'email' => $memberData->email, 'password' => $memberData->password, 'created_at' => $created_at)
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
                ->update(['name' => $memberData->userName]);
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
                ->select('name')
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
        if ($memberData->action != NULL && $memberData->action == 'pay')      //判斷值是否由欄位輸入
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