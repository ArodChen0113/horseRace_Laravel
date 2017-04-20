<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Input;
use Illuminate\Http\UploadedFile;
use App\Models\bigOrSmallGameM;
use App\Models\memberM;
use App\Models\horseRaceM;
use Illuminate\Support\Facades\Auth;

class bigOrSmallGameC extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); //驗證使用者是否登入
    }
    //大小單雙遊戲介紹頁面顯示(首頁)
    public function bsIntroduceShow()
    {
        $input = Input::all();
        $bsGameM = new bigOrSmallGameM();
        $horseData = $bsGameM->horseData();
        $action = Input::get('action', '');
        $horseName = '';
        //下注資料刪除
        if($action == 'delete'){
            $delData=['num'=>$input['num'],'hId'=>$input['hId'],'action'=>$input['action']];
            $horseName=$bsGameM->bsBettingDel($delData);
        }
        return view('bsIntroduceV',['horseData' => $horseData,'horseName' => $horseName,'action' => $action]);
    }
    //大小單雙遊戲下注頁面顯示(首頁)
    public function bsBettingShow()
    {
        $input = Input::all();
        $user = Auth::user();
        $userId=$user->id;
        $bsGameM = new bigOrSmallGameM();
        $horseRaceM = new horseRaceM();
        $action = Input::get('action', '');
        $alert = '';
        //下注資料新增
        if($action == 'insert'){
            $rowHorseData=$horseRaceM->horseDataOne($input['hId']);
            $horseData=['h_id'=>$input['hId'],'horseName'=>$rowHorseData[0]->horse_name,'horsePic'=>$rowHorseData[0]->horse_picture,'action'=>$input['action']];
            $alert = $bsGameM->bsBettingInsert($horseData);
        }
        $bettingData=$horseRaceM->bettingData();
        $member = new memberM();
        $memberData = $member->memberSelOne($userId);

        return view('bsBettingV',['bettingData' => $bettingData,'alert' => $alert,'action' => $action,'memberData' => $memberData]);
    }
    //大小單雙下注總覽(後台)頁面顯示
    public function bsBettingOverviewShow(){
        $bsGameM = new bigOrSmallGameM();
        $bsHorseRaceResultData = $bsGameM->bsBettingData();
        $sumProfit = $bsGameM->sumProfit();
        return view('bsBettingOverviewV',['bsHorseRaceResultData' => $bsHorseRaceResultData,'sumProfit'=>$sumProfit]);
    }
}