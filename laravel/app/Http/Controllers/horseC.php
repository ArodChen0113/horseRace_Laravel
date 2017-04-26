<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\memberM;
use Input;
use Illuminate\Http\UploadedFile;
use App\Models\horseM;
use App\Models\horseRaceM;
use Illuminate\Support\Facades\Session;

class horseC extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); //驗證使用者是否登入
    }
    //賽馬介紹頁面顯示
    public function horseIntroduceShow()
    {
        $alert = Input::get('alert', '');
        $action = Input::get('action', '');
        $horseData = horseRaceM::horseData();  //賽馬資料
        return view('horseIntroduceV', ['horseData' => $horseData,'alert' => $alert, 'action' => $action]);
    }
    //賽馬管理頁面顯示
    public function horseManageShow()
    {
        $this->Authority(); //權限驗證
        $action = Input::get('action', '');
        $horseName = Input::get('horseName', '');
        $horseData = horseM::horseSel();
        return view('horseManageV', ['horseData' => $horseData, 'horseName' => $horseName, 'action' => $action]);
    }
    //賽馬新增頁面顯示
    public function horseInsertShow()
    {
        $this->Authority(); //權限驗證
        return view('horseInsertV');
    }
    //賽馬修改頁面顯示
    public function horseUpdateShow()
    {
        $this->Authority(); //權限驗證
        $input = Input::all();
        $token = memberC::actionVerificationCode(); //加入token表單驗證碼
        $horseData = horseM::horseSelOne($input['hId']); //賽馬資料
        return view('horseUpdateV', ['horseData' => $horseData, 'token' => $token]);
    }
    //賽馬執行動作控制
    public function horseActionControl()
    {
        $input = Input::all();
        $token = Session::get('token');

        if($input['token'] == NULL || $input['token'] != $token){ //表單通過驗證
            return false;
        }
        $action = Input::get('action', '');
        //賽馬資料新增
        if($action == 'insert'){
            $horseData = ['horseName' => $input['horseName'], 'horseAge' => $input['horseAge'],
                'horseIntroduce' => $input['horseIntroduce'], 'action' => $input['action']];
            $horseName = horseM::horseInt($horseData);
        }
        //賽馬資料修改
        if($action == 'update'){
            $horseData = ['horseName' => $input['horseName'], 'horseAge' => $input['horseAge'],
                'horseIntroduce' => $input['horseIntroduce'], 'action' => $input['action'], 'hId' => $input['hId']];
            $horseName = horseM::horseUp($horseData);
        }
        //賽馬資料刪除
        if($action == 'delete'){
            $horseData = ['hId' => $input['hId'], 'action' => $action];
            $horseName = horseM::horseDel($horseData);
        }
        return redirect()->action('horseC@horseManageShow', ['horseName' => $horseName, 'action' => $action]);
    }
}