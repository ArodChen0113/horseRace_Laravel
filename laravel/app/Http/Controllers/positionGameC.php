<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Input;
use Illuminate\Http\UploadedFile;
use App\Models\positionGameM;
use App\Models\memberM;
use App\Models\horseRaceM;
use Illuminate\Support\Facades\Auth;

class positionGameC extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); //驗證使用者是否登入
    }
    //定位賽馬遊戲介紹頁面顯示(首頁)
    public function poIntroduceShow()
    {
        $input = Input::all();
        $horseData = positionGameM::horseData();  //賽馬資料
        $action = Input::get('action', '');
        $horseName = '';
        //取消賽馬下注(未付款)
        if($action == 'delete'){
            $delData = ['num' => $input['num'], 'hId' => $input['hId'], 'action' => $input['action']];
            $horseName = positionGameM::poBettingDel($delData);
        }
        return view('poIntroduceV', ['horseData' => $horseData, 'horseName' => $horseName, 'action' => $action]);
    }
    //定位賽馬遊戲下注頁面顯示(首頁)
    public function poBettingShow()
    {
        $input = Input::all();
        $user = Auth::user();
        $userId = $user->id;
        $action = Input::get('action', '');
        $alert = '';
        //下注資料新增
        if($action == 'insert'){
            $rowHorseData = horseRaceM::horseDataOne($input['hId']);
            $horseData = ['h_id' => $input['hId'], 'horseName' => $rowHorseData[0]->horse_name, 'horsePic' => $rowHorseData[0]->horse_picture, 'action' => $input['action']];
            $alert = positionGameM::poBettingInsert($horseData);
        }
        $bettingData = horseRaceM::bettingData();
        $member = new memberM();
        $memberData = $member->memberSelOne($userId);  //會員資料
        $gameName = '賽馬定位遊戲';
        $odds = horseRaceM::raceOddsOneData($gameName); //遊戲賠率

        return view('poBettingV', ['bettingData' => $bettingData, 'alert' => $alert,'action' => $action, 'memberData' => $memberData, 'odds' => $odds]);
    }
    //定位賽馬下注總覽(後台)頁面顯示
    public function poBettingOverviewShow(){
        $poHorseRaceResultData = positionGameM::poBettingData();
        $sumProfit = positionGameM::sumProfit();
        return view('poBettingOverviewV' ,['poHorseRaceResultData' => $poHorseRaceResultData, 'sumProfit' => $sumProfit]);
    }
}