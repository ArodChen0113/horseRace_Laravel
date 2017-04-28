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
        $this->accountCheck();     //帳號驗證
    }
    //大小單雙遊戲介紹頁面顯示(首頁)
    public function bsIntroduceShow()
    {
        $input = Input::all();
        $action = Input::get('action', '');
        $horseData = bigOrSmallGameM::horseData(); //賽馬資料
        $horseName = '';
        //下注資料刪除
        if($action == 'delete'){
            $delData = ['num' => $input['num'], 'hId' => $input['hId'], 'action' => $input['action']];
            $horseName = bigOrSmallGameM::bsBettingDel($delData);
        }
        return view('bsIntroduceV', ['horseData' => $horseData, 'horseName' => $horseName, 'action' => $action]);
    }
    //大小單雙遊戲下注頁面顯示(首頁)
    public function bsBettingShow()
    {
        $user = Auth::user();
        $input = Input::all();
        $action = Input::get('action', '');
        $token = memberC::actionVerificationCode(); //加入token表單驗證碼
        $alert = '';
        //下注資料新增
        if($action == 'insert'){
            $rowHorseData = horseRaceM::horseDataOne($input['hId']);  //賽馬資料
            $horseData = ['h_id' => $input['hId'], 'horseName' => $rowHorseData[0]->horse_name,
                'horsePic' => $rowHorseData[0]->horse_picture, 'action' => $input['action']];
            $alert = bigOrSmallGameM::bsBettingInsert($horseData);
        }
        $bettingData = horseRaceM::bettingData();       //下注資料
        $memberData = memberM::memberSelOne($user->id); //會員資料
        $gameName = '賽馬大小遊戲';
        $odds = horseRaceM::raceOddsOneData($gameName); //遊戲賠率

        return view('bsBettingV', ['bettingData' => $bettingData, 'alert' => $alert, 'action' => $action,
            'memberData' => $memberData, 'odds' => $odds, 'token' => $token]);
    }
    //大小單雙下注總覽(後台)頁面顯示
    public function bsBettingOverviewShow(){
        $this->Authority(); //權限驗證
        $bsHorseRaceResultData = bigOrSmallGameM::bsBettingData();  //下注資料
        $sumProfit = bigOrSmallGameM::sumProfit();                  //獲利加總
        return view('bsBettingOverviewV', ['bsHorseRaceResultData' => $bsHorseRaceResultData, 'sumProfit' => $sumProfit]);
    }
}