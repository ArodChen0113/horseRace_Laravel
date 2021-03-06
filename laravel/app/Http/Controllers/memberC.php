<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Input;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use App\Models\memberM;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;

class memberC extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); //驗證使用者是否登入
        $this->accountCheck();     //帳號驗證
    }
    //帳號管理頁面顯示(前台)
    public function accountManageShow()
    {
        $this->Authority(); //權限驗證
        $user = Auth::user();
        $input = Input::all();
        $alert = Input::get('action', '');
        $memberData = memberM::memberSelOne($user->id); //搜尋會員資料
        if($alert == 'update'){
            $memberData = ['horseName' => $input->memberName, 'id' => $input->id, 'action' => $input->action];
            $alert = memberM::memberUp($memberData);  //會員資料修改
        }
        if($alert == 'pay'){
            $memberData = ['money' => $input->mmoney, 'id' => $input->id, 'action' => $input->action];
            $alert = memberM::accountStoredValueUp($memberData);  //帳號儲值
        }
        return view('memberManageV', ['memberData' => $memberData, 'alert' => $alert]);
    }
    //會員金額儲值頁面顯示(前台)
    public function accountStoredValueShow()
    {
        $user = Auth::user();
        $action = Input::get('action', '');
        $storedMoney = Input::get('money', '');
        $token = memberC::actionVerificationCode(); //加入token表單驗證碼
        $memberData = memberM::memberSelOne($user->id);
        return view('accountStoredValueV', ['money' => $memberData[0]->money,
            'action' => $action, 'storedMoney' => $storedMoney, 'token' => $token]);
    }
    //會員管理頁面顯示(後台)
    public function memberManageShow()
    {
        $this->Authority(); //權限驗證
        $action = Input::get('action', '');
        $memberName = Input::get('memberName', '');
        $memberData = memberM::memberSel();
        memberC::actionVerificationCode(); //加入token表單驗證碼
        $token = Session::get('token');
        return view('memberManageV', ['memberData' => $memberData, 'action' => $action,
            'memberName' => $memberName, 'token' => $token]);
    }
    //會員新增頁面顯示
    public function memberInsertShow()
    {
        $this->Authority(); //權限驗證
        memberC::actionVerificationCode(); //加入token表單驗證碼
        $token = Session::get('token');
        return view('memberInsertV', ['token' => $token]);
    }
    //會員修改頁面顯示
    public function memberUpdateShow()
    {
        $this->Authority(); //權限驗證
        memberC::actionVerificationCode(); //加入token表單驗證碼
        $token = Session::get('token');
        $memberData = memberM::memberSel(); //會員資料
        return view('memberUpdateV', ['memberData' => $memberData, 'token' => $token]);
    }
    //會員執行動作控制
    public function memberActionControl(Request $request)
    {
        $input = Input::all();
        $token = Session::get('token'); //取得token
        $pass = $this->actionControl(); //1分內不能執行相同動作
        if($input['token'] == NULL || $input['token'] != $token || $pass == NULL || $pass != 'pass'){ //通過驗證
            return redirect()->action('Controller@limitActionUrl'); //轉向錯誤頁面
            exit;
        }
        $user = Auth::user();
        $action = Input::get('action', '');
        //會員儲值
        if($action == 'pay') {
            $this->validate($request, [
                'money' => 'required|min:100|integer',
            ]);
            $storedData = ['money' => $input['money'], 'action' => $action, 'id' => $user->id];
            $money = memberM::accountStoredValueUp($storedData); //會員儲值更新
            return redirect()->action('memberC@accountStoredValueShow', ['money' => $money, 'action' => $action]);
        }
        //會員資料新增
        if($action == 'insert'){
            $this->validate($request, [
                'name' => 'required|max:255|alpha_num',
                'email' => 'required|email|max:255|unique:member',
                'password' => 'required|min:6|confirmed|alpha_num',
            ]);
            $memberData = ['name' => $input['name'], 'email' => $input['email'], 'password' => $input['password']];
            $memberName = AuthController::create($memberData);
        }
        //會員資料修改
        if($action == 'update'){
            $this->validate($request, [
                'name' => 'required|max:255|alpha_num',
                'email' => 'required|email|max:255|unique:member',
            ]);
            $memberData = ['name' => $input['name'], 'email' => $input['email'], 'action' => $action,
                'id' => $input['id']];
            $memberName = memberM::memberUp($memberData);
        }
        return redirect()->action('memberC@memberManageShow', ['memberName' => $memberName, 'action' => $action]);
    }
    //會員刪除執行動作控制
    public function memberActionControlDel()
    {
        $input = Input::all();
        $token = Session::get('token'); //取得token
        $pass = $this->actionControl(); //1分內不能執行相同動作
        if($input['token'] == NULL || $input['token'] != $token || $pass == NULL || $pass != 'pass'){ //通過驗證
            return redirect()->action('Controller@limitActionUrl'); //轉向錯誤頁面
            exit;
        }
        $action = Input::get('action', '');
        //會員資料刪除
        if($action == 'delete'){
            $memberData = ['id' => $input['id'], 'action' => $action];
            $memberName = memberM::memberDel($memberData);
        }
        return redirect()->action('memberC@memberManageShow', ['memberName' => $memberName, 'action' => $action]);
    }
    //加入token表單驗證碼
    public static function actionVerificationCode()
    {
        $value = base64_encode(openssl_random_pseudo_bytes(32));
        Session::put('token',$value);
        $token = Session::get('token');
        return $token;
    }
}