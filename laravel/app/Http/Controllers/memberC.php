<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Input;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use App\Models\memberM;

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
        if($alert== 'update'){
            $memberData=['horseName'=>$input->memberName,'id'=>$input->id,'action'=>$input->action];
            $alert = $memberM->memberUp($memberData);  //會員資料修改
        }
        if($alert== 'pay'){
            $memberData=['money'=>$input->mmoney,'id'=>$input->id,'action'=>$input->action];
            $alert = $memberM->accountStoredValueUp($memberData);  //帳號儲值
        }
        return view('memberManageV',['memberData' => $memberData,'alert' => $alert]);
    }
    //會員管理頁面顯示(後台)
    public function memberManageShow()
    {
        $input = Input::all();
        $memberM = new memberM();
        $alert = Input::get('action', '');
        if($alert== 'insert'){
            $memberData=['memberName'=>$input->memberName,'email'=>$input->email,'password'=>$input->password,'action'=>$input->action];
            $alert = $memberM->memberInt($memberData);
        }
        if($alert== 'update'){
            $memberData=['horseName'=>$input->horseName,'id'=>$input->id,'action'=>$input->action];
            $alert = $memberM->memberUp($memberData);
        }
        if($alert== 'delete'){
            $alert = $memberM->memberDel($input->id);
        }
        $horseData = $memberM->memberSel();
        return view('horseManageV',['HorseData'=>$horseData,'alert'=>$alert]);
    }
    //會員新增頁面顯示
    public function memberInsertShow()
    {
        return view('memberInsertV');
    }
    //會員修改頁面顯示
    public function memberUpdateShow()
    {
        $user = Auth::user();
        $userId = $user->id;      //會員id
        $memberM = new memberM();
        $memberData = $memberM->memberSelOne($userId); //搜尋會員資料
        return view('memberUpdateV',['memberData'=>$memberData]);
    }
}