<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Input;
use Illuminate\Http\UploadedFile;
use App\Models\horseM;

class horseC extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); //驗證使用者是否登入
    }
    //賽馬管理頁面顯示
    public function horseManageShow()
    {
        $input = Input::all();
        $horseM = new horseM();
        $action = Input::get('action', '');
        $horseName = '';
        //賽馬資料新增
        if($action == 'insert'){
            $horseData = ['horseName' => $input['horseName'], 'horseAge' => $input['horseAge'], 'horseIntroduce' => $input['horseIntroduce'], 'action' => $input['action']];
            $horseName = $horseM->horseInt($horseData);
        }
        //賽馬資料修改
        if($action == 'update'){
            $horseData = ['horseName' => $input['horseName'], 'horseAge' => $input['horseAge'], 'horseIntroduce' => $input['horseIntroduce'], 'action' => $input['action'], 'hId' => $input['hId']];
            $horseName = $horseM->horseUp($horseData);
        }
        //賽馬資料刪除
        if($action == 'delete'){
            $horseData = ['hId' => $input['hId'], 'action' => $action];
            $horseName = $horseM->horseDel($horseData);
        }
        $horseData = $horseM->horseSel();
        return view('horseManageV', ['horseData' => $horseData, 'horseName' => $horseName, 'action' => $action]);
    }
    //賽馬新增頁面顯示
    public function horseInsertShow()
    {
        return view('horseInsertV');
    }
    //賽馬修改頁面顯示
    public function horseUpdateShow()
    {
        $input = Input::all();
        $horseM = new horseM();
        $horseData = $horseM->horseSelOne($input['hId']);
        return view('horseUpdateV', ['horseData' => $horseData]);
    }
}