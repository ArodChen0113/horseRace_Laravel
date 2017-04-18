<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Input;
use Illuminate\Http\UploadedFile;
use App\Models\positionGameM;

class positionGameC extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); //驗證使用者是否登入
    }
    //定位賽馬遊戲介紹頁面顯示(首頁)
    public function poIntroduceShow()
    {
        $poGameM = new positionGameM();
        $horseData = $poGameM->horseData();
        return view('pgIntroduceV',['horseData' => $horseData]);
    }
    //定位賽馬遊戲下注頁面顯示(首頁)
    public function poBettingShow()
    {
        $input = Input::all();
        $poGameM = new positionGameM();
        $alert = Input::get('action', '');
        //下注資料新增
        if($alert == 'insert'){
            $horseData=['h_id'=>$input->HId,'control'=>$input->control,'action'=>$input->action];
            $alert = $poGameM->poBettingInsert($horseData);
        }
        //下注資料刪除
        if($alert == 'delete'){
            $delData=['num'=>$input->num,'HId'=>$input->HId,'action'=>$input->action];
            $alert = $poGameM->poBettingDel($delData);
        }
        $bettingData=$poGameM->bettingData();
        return view('poBettingV',['bettingData' => $bettingData,'alert' => $alert]);
    }
}