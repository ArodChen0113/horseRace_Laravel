<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Input;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use App\Models\memberM;
use App\Http\Controllers\Auth\AuthController;

class memberC extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); //驗證使用者是否登入
    }
    //帳號管理頁面顯示(前台)
    public function accountManageShow()
    {
        $input = Input::all();
        $user = Auth::user();
        $userId = $user->id;      //會員id
        $memberM = new memberM();
        $memberData = $memberM->memberSelOne($userId); //搜尋會員資料
        $alert = Input::get('action', '');
        if($alert == 'update'){
            $memberData = ['horseName' => $input->memberName, 'id' => $input->id, 'action' => $input->action];
            $alert = $memberM->memberUp($memberData);  //會員資料修改
        }
        if($alert== 'pay'){
            $memberData = ['money' => $input->mmoney, 'id' => $input->id, 'action' => $input->action];
            $alert = $memberM->accountStoredValueUp($memberData);  //帳號儲值
        }
        return view('memberManageV', ['memberData' => $memberData, 'alert' => $alert]);
    }
    //會員金額儲值頁面顯示(前台)
    public function accountStoredValueShow()
    {
        $input = Input::all();
        $action = Input::get('action', '');
        $user = Auth::user();
        $userId = $user->id;      //會員id
        $memberM = new memberM();
        $memberName = '';
        //會員資料修改
        if($action == 'pay') {
            $storedData = ['money' => $input['money'], 'action' => $action, 'id' => $userId];
            $memberName = $memberM->accountStoredValueUp($storedData);
        }
        $memberData = $memberM -> memberSelOne($userId);
        $money = $memberData[0]->money;

        return view('accountStoredValueV', ['money' => $money, 'action' => $action, 'memberName' => $memberName]);
    }
    //會員管理頁面顯示(後台)
    public function memberManageShow()
    {
        $input = Input::all();
        $action = Input::get('action', '');
        $memberM = new memberM();
        $memberName = '';
        //會員資料新增
        if($action == 'insert'){
            $memberData = ['name' => $input['name'], 'email' => $input['email'], 'password' => $input['password']];
            $authC = new AuthController();
            $authC ->create($memberData);
            $memberName = $input['name'];
        }
        //會員資料修改
        if($action == 'update'){
            $memberData = ['name' => $input['name'], 'email' => $input['email'], 'action' => $action, 'id' => $input['id']];
            $memberName = $memberM -> memberUp($memberData);
        }
        //會員資料刪除
        if($action == 'delete'){
            $memberData = ['id' => $input['id'], 'action' => $action];
            $memberName = $memberM->memberDel($memberData);
        }
        $memberData = $memberM -> memberSel();
        return view('memberManageV', ['memberData' => $memberData, 'action' => $action, 'memberName' => $memberName]);
    }
    //會員新增頁面顯示
    public function memberInsertShow()
    {
        return view('memberInsertV');
    }
    //會員修改頁面顯示
    public function memberUpdateShow()
    {

        $input = Input::all();
        $memberM = new memberM();
        $memberData = $memberM->memberSel();

        return view('memberUpdateV', ['memberData' => $memberData]);
    }
}