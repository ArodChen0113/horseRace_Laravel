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
use Illuminate\Support\Facades\Session;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    public function Authority()
    {
        $user = Auth::user();
        $rowCheck = DB::table('member')
            ->select('authority')
            ->where('name', $user->name)
            ->get();
        $checkLevel = $rowCheck[0]->authority;
        if ($checkLevel == 0) {
            header("Location:noAuthV");
            exit;
        }
    }
    public function AuthUrl()
    {
        return view('noAuthV');
    }
    public function actionControl()
    {
        $dateTime = horseRaceM::nowDateTime(); //目前時間
        $controlTime = Session::get('controlTime');
        if($controlTime == NULL) {
            Session::put('controlTime', $dateTime);
            return 'pass';
        }
        $evaTime = strtotime($controlTime);
        if(strtotime($dateTime) > strtotime('+1 min',$evaTime)){
            return '';
        }
        var_dump(strtotime($dateTime));
        var_dump(strtotime('+1 min',$evaTime));
        exit;
//        Session::forget('controlTime');
    }
}
