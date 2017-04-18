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
        $rank=array();
        $horseCount=10;
        $count=0;
        while ($count<$horseCount) {           //計算賽馬名次
            $number = rand(1, $horseCount);
            if (!in_array($number, $rank)) { //去陣列重複值
                $rank[$count] = $number;
                $rowHId=DB::table('horseGame_horse')
                    ->select('h_id')
                    ->where('g_id', $number)
                    ->get();
                $result[$count] = $rowHId[0]->h_id;
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