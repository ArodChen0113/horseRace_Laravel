<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Input;
use Illuminate\Http\UploadedFile;
use App\Models\bigOrSmallGameM;
use App\Models\horseRaceM;

class horseRaceC extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); //驗證使用者是否登入
    }
    //賽馬&遊戲介紹頁面顯示(首頁)
    public function horseRaceShow(){
        $input = Input::all();
        $alert = Input::get('action', '');
        //賽馬下注後提示顯示
        if($alert== 'betting'){
            $bettingData=['num'=>$input->num,'money'=>$input->money,'action'=>$input->action];
            $alert = new bigOrSmallGameM();
            $alert = $alert->bsBettingMoneyInsert($bettingData);
        }
        return view('horseRaceShowV',['alert' => $alert]);
    }
    //賽果總覽(前台)頁面顯示
    public function raceOverviewShow(){
        $user = Auth::user();
        $userId=$user->id;
        $horseRaceM = new horseRaceM();
        $resultData = $horseRaceM->horseRaceResultPersonalData($userId);
        return view('raceOverviewV',['resultData' => $resultData]);
    }
    //大小下注總覽(後台)頁面顯示
    public function bsBettingOverviewShow(){
        $horseRaceM = new horseRaceM();
        $bettingData = $horseRaceM->bsBettingData();
        return view('bsBettingOverviewV',['bettingData' => $bettingData]);
    }
    //單雙下注總覽(後台)頁面顯示
    public function sdBettingOverviewShow(){
        $horseRaceM = new horseRaceM();
        $bettingData = $horseRaceM->sdBettingData();
        return view('sdBettingOverviewV',['bettingData' => $bettingData]);
    }
    //定位下注總覽(後台)頁面顯示
    public function poBettingOverviewShow(){
        $horseRaceM = new horseRaceM();
        $bettingData = $horseRaceM->poBettingData();
        return view('poBettingOverviewV',['bettingData' => $bettingData]);
    }
    //開獎盈餘(後台)頁面顯示
    public function raceSurplusShow(){
        $alert = Input::get('action', '');
        //開獎
        if($alert== 'lottery'){
            $this->lotteryControl($alert);
        }
        $horseRaceM = new horseRaceM();
        $horseRaceResultData = $horseRaceM->horseRaceResultData();
        return view('raceSurplusV',['horseRaceResultData' => $horseRaceResultData,'alert' => $alert]);
    }
    //賠率管理(後台)頁面顯示
    public function raceOddsShow(){
        $input = Input::all();
        $horseRaceM = new horseRaceM();
        $oddsData = $horseRaceM->raceOddsData();
        $alert = Input::get('action', '');
        //修改遊戲賠率
        if($alert == 'update'){
            $upOddsData=['gameName'=>$input->game_name,'action'=>$input->action];
            $alert = $horseRaceM->raceOddsUpdate($upOddsData);
        }
        return view('horseRaceShowV',['oddsData' => $oddsData ,'alert' => $alert]);
    }
    //賽馬賽果開獎
    public function lotteryControl($alert){
        $horseRaceM = new horseRaceM();
        $horseRaceM->bettingHistoryUpdate($alert);  //之前下注改成歷史紀錄
        $horseRaceM->horseRaceResult($alert);       //計算賽馬名次
        $horseRaceM->sdRaceBonus();                 //單雙賽馬結果計算&贏家派彩
        $horseRaceM->bsRaceBonus();                 //大小賽馬結果計算&贏家派彩
        $horseRaceM->poRaceBonus();                 //定位賽馬結果計算&贏家派彩
        $horseRaceM->raceLoseUpdate($alert);        //輸家狀態改為當次已計算,無派彩
    }
}