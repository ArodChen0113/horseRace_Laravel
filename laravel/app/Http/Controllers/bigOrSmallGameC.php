<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Input;
use Illuminate\Http\UploadedFile;
use App\Models\bigOrSmallGameM;

class bigOrSmallGameC extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); //驗證使用者是否登入
    }
    //大小單雙遊戲介紹頁面顯示(首頁)
    public function bsIntroduceShow()
    {
        $bsGameM = new bigOrSmallGameM();
        $horseData = $bsGameM->horseData();
        return view('bsIntroduceV',['horseData' => $horseData]);
    }
    //大小單雙遊戲下注頁面顯示(首頁)
    public function bsBettingShow()
    {
        $input = Input::all();
        $bsGameM = new bigOrSmallGameM();
        $alert = Input::get('action', '');
        //下注資料新增
        if($alert == 'insert'){
            $horseData=['h_id'=>$input->HId,'control'=>$input->control,'action'=>$input->action];
            $alert = $bsGameM->bsBettingInsert($horseData);
        }
        //下注資料刪除
        if($alert == 'delete'){
            $delData=['num'=>$input->num,'HId'=>$input->HId,'action'=>$input->action];
            $alert = $bsGameM->bsBettingDel($delData);
        }
        $bettingData=$bsGameM->bettingData();
        return view('bsBettingV',['bettingData' => $bettingData,'alert' => $alert]);
    }
}