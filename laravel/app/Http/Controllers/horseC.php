<?php
namespace App\Http\Controllers;

use DB;
use App\Http\Controllers\Controller;
use Input;
use Illuminate\Http\UploadedFile;

class horseC extends Controller
{
    public function __construct()
    {

    }
    //賽馬管理頁面顯示
    public function horseManageShow()
    {

    }
    //賽馬新增頁面顯示
    public function horseInsertShow()
    {
        $result=array();
        $horseCount=10;
        $count=0;
        while ($count<$horseCount) {           //計算賽馬名次
            $number = rand(1, $horseCount);
            if (!in_array($number, $result)) { //去陣列重複值
                $j=$count+1;
                $rowHId=DB::table('horseGame_horse')
                    ->select('h_id')
                    ->where('g_id',$j)
                    ->get();
                $hId=$rowHId[0]->h_id;
                $result[$number] = $hId;
                $count++;
            }
        }

        return view('horseInsertV',['result' => $result]);
    }
    //賽馬修改頁面顯示
    public function horseUpdateShow()
    {

    }
}