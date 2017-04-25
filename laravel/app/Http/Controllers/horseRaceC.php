<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Input;
use Illuminate\Http\UploadedFile;
use App\Models\bigOrSmallGameM;
use App\Models\positionGameM;
use App\Models\horseRaceM;
use App\Models\memberM;
use Illuminate\Support\Facades\Auth;

class horseRaceC extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); //驗證使用者是否登入
    }
    //賽馬&遊戲介紹頁面顯示(首頁)
    public function horseRaceShow(){
        $input = Input::all();
        $action = Input::get('action', '');
        $alert = '';
        //賽馬下注後提示顯示
        if($action == 'bsBetting'){
            $bettingData = ['money' => $input['money'], 'action' => $input['action'], 'control' => $input['control'], 'rank' => $input['rank']];
            $alert = bigOrSmallGameM::bsBettingInsert($bettingData);
        }
        if($action == 'poBetting'){
            $bettingData = ['num' => $input['num'], 'money' => $input['money'], 'horseName' => $input['horseName'],
                'action' => $input['action'], 'control' => $input['control'], 'rank' => $input['rank']];
            $alert = positionGameM::poBettingMoneyInsert($bettingData);
        }
        //賽馬開獎
        if($action == 'lottery'){
            $alert = $this->lotteryControl($action);
        }
        return view('horseRaceShowV', ['alert' => $alert, 'action' => $action]);
    }
    //賽果總覽(前台)頁面顯示
    public function raceOverviewShow(){
        $user = Auth::user();
        $bettingData = horseRaceM::horseRaceResultPersonalData($user->id); //個人賽馬資料
        $memberData = memberM::memberSelOne($user->id); //會員資料
        return view('raceOverviewV', ['bettingData' => $bettingData, 'memberData' => $memberData]);
    }
    //開獎盈餘(後台)頁面顯示
    public function raceSurplusShow(){
        $alert = Input::get('action', '');
        //開獎
        if($alert == 'lottery'){
            $this->lotteryControl($alert); //賽馬賽果開獎
        }
        $horseRaceResultData = horseRaceM::horseRaceResultData();
        return view('raceSurplusV', ['horseRaceResultData' => $horseRaceResultData, 'alert' => $alert]);
    }
    //賠率管理(後台)頁面顯示
    public function raceOddsShow(){
        $input = Input::all();
        $action = Input::get('action', '');
        $oddsData = horseRaceM::raceOddsData(); //賠率資料
        $gameName = '';
        //修改遊戲賠率
        if($action == 'update'){
            $gameName = horseRaceM::raceOddsUpdate($input);
        }
        return view('raceOddsV',['oddsData' => $oddsData, 'action' => $action, 'gameName' => $gameName]);
    }
    //賽馬賽果開獎
    public function lotteryControl($alert){
        horseRaceM::bettingHistoryUpdate($alert);  //之前下注改成歷史紀錄&登錄新賽果時間
        horseRaceM::horseRaceResult($alert);       //計算賽馬名次
        horseRaceM::RaceBonus();                   //賽馬結果計算&贏家派彩
        horseRaceM::raceLoseUpdate($alert);        //輸家狀態改為當次已計算,無派彩
    }
}