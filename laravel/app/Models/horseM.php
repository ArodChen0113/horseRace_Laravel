<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;

class horseM
{
    //賽馬資料搜尋
    public static function horseSel()
    {
        $rowHorseData=DB::table('horse_data')
            ->select('h_id','horse_name','horse_age','horse_introduce','horse_picture')
            ->get();
        return $rowHorseData;
    }
    //賽馬資料單筆搜尋
    public static function horseSelOne($hId)
    {
        $rowHorseData=DB::table('horse_data')
            ->select('h_id','horse_name','horse_age','horse_introduce','horse_picture')
            ->where('h_id',$hId)
            ->get();
        return $rowHorseData;
    }
    //賽馬資料新增
    public static function horseInt($horseData)
    {
        if ($horseData['action'] != NULL && $horseData['action'] == 'insert') //判斷值是否由欄位輸入
        {
                DB::table('horse_data')->insert(array(  //新增賽馬資料
                    array('horse_name' => $horseData['horseName'], 'horse_age' => $horseData['horseAge'], 'horse_introduce' => $horseData['horseIntroduce'])
                ));
            return $horseData['horseName'];
        }
        if ($horseData['action'] == NULL){ //判斷值是否由欄位輸入
            return false;
        }
    }
    //賽馬資料修改
    public static function horseUp($horseData)
    {
        if ($horseData['action'] != NULL && $horseData['action'] == 'update') //判斷值是否由欄位輸入
        {
            DB::table('horse_data')
                ->where('h_id', $horseData['hId'])
                ->update(['horse_name' => $horseData['horseName'], 'horse_age' => $horseData['horseAge'], 'horse_introduce' => $horseData['horseIntroduce']]);

            return $horseData['horseName'];
        }
        if ($horseData['action'] == NULL){ //判斷值是否由欄位輸入
            return false;
        }
    }
    //賽馬資料刪除
    public static function horseDel($horseData)
    {
        if ($horseData['action'] != NULL && $horseData['action'] == 'delete') //判斷值是否由欄位輸入
        {
            $rowName = DB::table('horse_data')
                ->select('horse_name')
                ->where('h_id', $horseData['hId'])
                ->get();
            $horseName = $rowName[0]->horse_name;
            DB::table('horse_data')->where('h_id', '=', $horseData['hId'])->delete();
            return $horseName;
        }
        if ($horseData['action'] == NULL){ //判斷值是否由欄位輸入
            return false;
        }
    }
}