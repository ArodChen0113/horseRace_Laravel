<?php

namespace App\Http\Controllers;

use App\Models\horseRaceM;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    //帳號驗證&錯誤時間
    public function accountCheck()
    {
        $this->reErrorTime(); //重置錯誤時間
        $user = Auth::user();
        $rowCheck = DB::table('member')
            ->select('error')
            ->where('id', $user->id)
            ->get();
        if ($rowCheck[0]->error == 1) {
            header("Location:limitAccountV");
            exit;
        }
    }
    //帳號鎖定頁面顯示
    public function limitAccountUrl()
    {
        return view('limitAccountV');
    }
    //權限控制
    public function Authority()
    {
        $user = Auth::user();
        $rowCheck = DB::table('member')
            ->select('authority')
            ->where('id', $user->id)
            ->get();
        if ($rowCheck[0]->authority == 0) {
            header("Location:noAuthV");
            exit;
        }
    }
    //無權限頁面顯示
    public function authUrl()
    {
        return view('noAuthV');
    }
    //執行動作限制(一次/分)
    public function actionControl()
    {
        $dateTime = horseRaceM::nowDateTime(); //目前時間
        if(session('actionTime') == NULL) {
            session()->put('actionTime', $dateTime);
            return 'pass';
            exit;
        }
        $evaTime = strtotime(session('actionTime'));
        if(strtotime($dateTime) < strtotime('+1 min', $evaTime)){
            return '';
            exit;
        }
        session()->forget('actionTime');
        return 'pass';
    }
    //執行錯誤顯示
    public function limitActionUrl()
    {
        $user = Auth::user();
        if(session($user->id) == NULL){
            session()->put($user->id, 0);
        }
        $countError = session($user->id);
        $countError++; //每執行錯誤一次加一
        session()->put($user->id, $countError);
        $dateTime = horseRaceM::nowDateTime(); //目前時間
        session()->put('errorTime', $dateTime); //最新執行錯誤時間
        $this->accountLock(); //檢驗帳號錯誤次數

        return view('limitActionV');
    }
    //帳號鎖定(執行錯誤過多)
    public function accountLock()
    {
        $user = Auth::user();
        if(session($user->id) >= 5){
            DB::table('member')
                ->where('id', $user->id)
                ->update(['error' => 1]);
        }
    }
    //執行錯誤時間重置(一天內無再執行錯誤)
    public function reErrorTime()
    {
        $dateTime = horseRaceM::nowDateTime(); //目前時間
        $errorTime = strtotime(session('errorTime'));
        if(strtotime($dateTime) > strtotime('+1 day', $errorTime)){ //一天內無執行錯誤
            session()->forget('errorTime'); //重置執行錯誤次數
        }
    }
}
