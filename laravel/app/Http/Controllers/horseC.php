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
        return view('horseInsertV',['result' => $result]);
    }
    //賽馬修改頁面顯示
    public function horseUpdateShow()
    {

    }
}