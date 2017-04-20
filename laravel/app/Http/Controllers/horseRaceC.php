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
        $alert='';
        //賽馬下注後提示顯示
        if($action== 'bsBetting'){
            $bettingData=['num'=>$input['num'],'money'=>$input['money'],'horseName'=>$input['horseName'],'action'=>$input['action'],'control'=>$input['control']];
            $alert = new bigOrSmallGameM();
            $alert = $alert->bsBettingMoneyInsert($bettingData);
        }
        if($action== 'poBetting'){
            $bettingData=['num'=>$input['num'],'money'=>$input['money'],'horseName'=>$input['horseName'],'action'=>$input['action'],'control'=>$input['control'],'rank'=>$input['rank']];
            $alert = new positionGameM();
            $alert = $alert->poBettingMoneyInsert($bettingData);
        }
        //賽馬開獎
        if($action== 'lottery'){
            $this->lotteryControl($action);
        }
        return view('horseRaceShowV',['alert' => $alert,'action' => $action]);
    }
    //賽果總覽(前台)頁面顯示
    public function raceOverviewShow(){
        $user = Auth::user();
        $userId=$user->id;
        $horseRaceM = new horseRaceM();
        $bettingData = $horseRaceM->horseRaceResultPersonalData($userId);
        $memberM = new memberM();
        $memberData = $memberM->memberSelOne($userId);

        return view('raceOverviewV',['bettingData' => $bettingData,'memberData' => $memberData]);
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
        $horseRaceM->bettingHistoryUpdate($alert);  //之前下注改成歷史紀錄&登錄新賽果時間
        $horseRaceM->horseRaceResult($alert);       //計算賽馬名次
        $bsGameM = new bigOrSmallGameM();
        $bsGameM->RaceBonus();                      //單雙大小賽馬結果計算&贏家派彩
        $horseRaceM->poRaceBonus();                 //定位賽馬結果計算&贏家派彩
        $horseRaceM->raceLoseUpdate($alert);        //輸家狀態改為當次已計算,無派彩
    }
}