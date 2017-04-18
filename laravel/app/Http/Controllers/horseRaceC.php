<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Input;
use Illuminate\Http\UploadedFile;
use App\Models\bigOrSmallGameM;

class horseRaceC extends Controller
{
    public function __construct()
    {

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


        return view('raceOverviewV');
    }
    //下注總覽(後台)頁面顯示
    public function BettingOverviewShow(){

    }
    //開獎盈餘(後台)頁面顯示
    public function raceSurplusShow(){

    }
    //賠率管理(後台)頁面顯示
    public function raceOddsShow(){

    }
}