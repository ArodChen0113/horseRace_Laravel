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
        $alert = Input::get('action', '');
        //賽馬資料新增
        if($alert== 'insert'){
            $horseData=['horseName'=>$input->horseName,'horseAge'=>$input->horseAge,'horseIntroduce'=>$input->horseIntroduce,'action'=>$input->action];
            $alert = $horseM->horseInt($horseData);
        }
        //賽馬資料修改
        if($alert== 'update'){
            $horseData=['horseName'=>$input->horseName,'horseAge'=>$input->horseAge,'horseIntroduce'=>$input->horseIntroduce,'action'=>$input->action,'HId'=>$input->HId];
            $alert = $horseM->horseDel($horseData);
        }
        //賽馬資料刪除
        if($alert== 'delete'){
            $alert = $horseM->horseDel($input->HId);
        }
        $horseData = $horseM->horseSel();
        return view('horseManageV',['HorseData'=>$horseData,'alert'=>$alert]);
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
        $horseData = $horseM->horseSelOne($input->HId);
        return view('horseUpdateV',['horseData'=>$horseData]);
    }
}