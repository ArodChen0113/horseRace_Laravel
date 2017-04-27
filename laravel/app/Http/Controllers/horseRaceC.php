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
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class horseRaceC extends Controller
{
    public function __construct()
    {
        $this->accountCheck();     //帳號驗證
        $this->middleware('auth'); //驗證使用者是否登入
    }
    //賽馬&遊戲介紹頁面顯示(首頁)
    public function horseRaceShow(){
        return view('horseRaceShowV');
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
        $action = Input::get('action', '');
        $oddsData = horseRaceM::raceOddsData(); //賠率資料
        memberC::actionVerificationCode(); //加入token表單驗證碼
        $token = Session::get('token');
        return view('raceOddsV',['oddsData' => $oddsData, 'action' => $action, 'token' => $token]);
    }
    //賽馬賽果開獎
    public function lotteryControl($alert){
        horseRaceM::bettingHistoryUpdate($alert);  //之前下注改成歷史紀錄&登錄新賽果時間
        horseRaceM::horseRaceResult($alert);       //計算賽馬名次
        horseRaceM::RaceBonus();                   //賽馬結果計算&贏家派彩
        horseRaceM::raceLoseUpdate($alert);        //輸家狀態改為當次已計算,無派彩
    }
    //賽馬遊戲執行動作控制
    public function horseRaceActionControl(Request $request)
    {
        $input = Input::all();
        $token = Session::get('token'); //取得token
        $pass = $this->actionControl(); //1分內不能執行相同動作
        if($input['token'] == NULL || $input['token'] != $token || $pass == NULL || $pass != 'pass'){ //通過驗證
            return redirect()->action('Controller@limitActionUrl'); //轉向錯誤頁面
            exit;
        }
        $alert = Input::get('alert', '');
        $action = Input::get('action', '');
        //賽馬下注後提示顯示
        if($action == 'bsBetting'){
            $this->validate($request, [
                'money' => 'required|min:100|integer',
            ]);
            $bettingData = ['money' => $input['money'], 'action' => $input['action'], 'control' => $input['control'], 'rank' => $input['rank']];
            $alert = bigOrSmallGameM::bsBettingInsert($bettingData);
        }
        if($action == 'poBetting'){
            $this->validate($request, [
                'money' => 'required|min:100|integer',
            ]);
            $bettingData = ['num' => $input['num'], 'money' => $input['money'], 'horseName' => $input['horseName'],
                'action' => $input['action'], 'control' => $input['control'], 'rank' => $input['rank']];
            $alert = positionGameM::poBettingMoneyInsert($bettingData);
        }
        //設定遊戲賠率
        if($action == 'odds'){
            $this->validate($request, [
                'gameName' => 'required',
                'odds' => 'required',
            ]);
            horseRaceM::raceOddsUpdate($input);
            return redirect()->action('horseRaceC@raceOddsShow', ['action' => $action]);
        }
        //賽馬開獎
        if($action == 'lottery'){
            $alert = $this->lotteryControl($action);
        }
        return redirect()->action('horseC@horseIntroduceShow', ['alert' => $alert, 'action' => $action]);
    }
    //賽馬遊戲執行動作控制
    public function openActionControl()
    {
        $action = Input::get('action', '');
        //賽馬開獎
        if($action == 'lottery'){
            $alert = $this->lotteryControl($action);
        }
        return redirect()->action('horseC@horseIntroduceShow', ['alert' => $alert, 'action' => $action]);
    }
}