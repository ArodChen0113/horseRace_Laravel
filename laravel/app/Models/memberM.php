<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use App\Models\horseRaceM;

class memberM
{
    //會員資料搜尋
    public static function memberSel()
    {
        $memberData = DB::table('member')
            ->select('email','name','money','id')
            ->get();
        return $memberData;
    }
    //會員單筆資料搜尋
    public static function memberSelOne($id)
    {
        $memberData = DB::table('member')
            ->select('email','name','money')
            ->where('id', $id)
            ->get();
        return $memberData;
    }
    //會員資料新增
    public static function memberInt($memberData)
    {
        $created_at = horseRaceM::nowDateTime(); //目前時間

        if ($memberData['action'] == NULL || $memberData['action'] != 'insert') //判斷值是否由欄位輸入
        {
            return false;
        }
                DB::table('member')->insert(array( //新增會員資料
                    array('name' => $memberData['userName'], 'email' => $memberData['email'], 'password' => $memberData['password'], 'created_at' => $created_at)
                ));
            return $memberData->userName;
    }
    //會員資料修改
    public static function memberUp($memberData)
    {
        if ($memberData['action'] == NULL || $memberData['action'] != 'update') //判斷值是否由欄位輸入
        {
            return false;
        }
            DB::table('member')
                ->where('id', $memberData['id'])
                ->update(['name' => $memberData['name'],'email' => $memberData['email']]);
            return $memberData['name'];
    }
    //會員資料刪除
    public static function memberDel($memberData)
    {
        if ($memberData['action'] == NULL || $memberData['action'] != 'delete') //判斷值是否由欄位輸入
        {
            return false;
        }
            $rowName = DB::table('member')
                ->select('name')
                ->where('id', $memberData['id'])
                ->get();
            DB::table('member')->where('id', '=', $memberData['id'])->delete();
            return $rowName[0]->name;
    }
    //會員儲值修改
    public static function accountStoredValueUp($memberData)
    {
        if ($memberData['action'] == NULL || $memberData['action'] != 'pay') //判斷值是否由欄位輸入
        {
            return false;
        }
        $rowMemberData = memberM::memberSelOne($memberData['id']);
        $rowMemberData[0]->money += $memberData['money']; //儲值後總金額
            DB::table('member')
                ->where('id', $memberData['id'])
                ->update(['money' => $rowMemberData[0]->money]);
            return $memberData['money'];
    }
}