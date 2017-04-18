<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;

class horseM
{
    //賽馬資料搜尋
    public function horseSel()
    {
        $rowHorseData=DB::table('horse_data')
            ->select('h_id','horse_name','horse_age','horse_introduce')
            ->get();
        return $rowHorseData;
    }
    //賽馬資料單筆搜尋
    public function horseSelOne($HId)
    {
        $rowHorseData=DB::table('horse_data')
            ->select('h_id','horse_name','horse_age','horse_introduce')
            ->where('h_id',$HId)
            ->get();
        return $rowHorseData;
    }
    //賽馬資料新增
    public function horseInt($horseData)
    {
        if ($horseData->action != NULL && $horseData->action == 'insert')         //判斷值是否由欄位輸入
        {
                DB::table('horse_data')->insert(array(                            //新增賽馬資料
                    array('horse_name' => $horseData->horseName, 'horse_age' => $horseData->horseAge, 'horseIntroduce' => $horseData->horseIntroduce)
                ));
            return $horseData->horseName;
        }else{
            return false;
        }
    }
    //賽馬資料修改
    public function horseUp($horseData)
    {
        if ($horseData->action != NULL && $horseData->action == 'update')      //判斷值是否由欄位輸入
        {
            DB::table('house_data')
                ->where('h_id', $horseData->HId)
                ->update(['horse_name' => $horseData->horseName,'horse_age' => $horseData->horseAge,'horse_introduce' => $horseData->horseIntroduce]);
            return $horseData->horseName;
        }else{
            return false;
        }
    }
    //賽馬資料刪除
    public function horseDel($horseData)
    {
        if ($horseData->action != NULL && $horseData->action == 'delete')      //判斷值是否由欄位輸入
        {
            $rowName=DB::table('horse_data')
                ->select('horse_name')
                ->where('h_id', $horseData->num)
                ->get();
            $horseName=$rowName[0]->horse_name;
            DB::table('horse_data')->where('h_id', '=', $horseData->num)->delete();
            return $horseName;
        }else{
            return false;
        }
    }
}