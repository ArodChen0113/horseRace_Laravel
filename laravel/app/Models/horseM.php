<?php
namespace App\Models;

use DB;
use Input;
use Illuminate\Http\UploadedFile;

class horseM
{
    public function __construct()
    {

    }
    //賽馬資料新增
    public function horseInt()
    {
        $input = Input::all();
        $horseName = $input['horseName'];
        $horseAge = $input['horseAge'];
        $horseIntroduce = $input['horseIntroduce'];

        if ($input['action'] != NULL && $input['action'] == 'insert')         //判斷值是否由欄位輸入
        {
            if (Input::hasFile('housePicture')) {
                $file = Input::file('housePicture');                              //取得檔案資訊
                $extension = $file->getClientOriginalExtension();                 //取得檔案副檔名
                $file_name = strval(time()) . str_random(5) . '.' . $extension;   //定義檔案名稱
                $destination_path = public_path() . '/userUpload/';               //定義儲存路徑
                $upload_success = $file->move($destination_path, $file_name);     //移動至指定資料夾
                DB::table('horse_data')->insert(array(                            //新增賽馬資料
                    array('horse_name' => $horseName, 'horse_age' => $horseAge, 'horseIntroduce' => $horseIntroduce, 'horse_picture' => $file_name)
                ));
            } else {
                return "horse_img upload failed!";
            }
            return $horseName;
        }else{
            return false;
        }
    }
    //賽馬資料修改
    public function horseUp()
    {
        $input = Input::all();
        if ($input['action'] != NULL && $input['action'] == 'update')      //判斷值是否由欄位輸入
        {
            DB::table('house_data')
                ->where('h_id', $input['num'])
                ->update(['horse_name' => $input['horseName'],'horse_age' => $input['horseAge'],'horse_introduce' => $input['horseIntroduce']]);

            if (Input::hasFile('horse_picture')!=false) {
                $file = Input::file('horse_picture');                             //取得檔案資訊
                $extension = $file->getClientOriginalExtension();                 //取得檔案副檔名
                $file_name = strval(time()) . str_random(5) . '.' . $extension;   //定義檔案名稱
                $destination_path = public_path() . '/userUpload/';               //定義儲存路徑
                $upload_success = $file->move($destination_path, $file_name);     //移動至指定資料夾
                DB::table('house_data')
                    ->where('num', $input['num'])
                    ->update(['horse_picture' => $file_name]);
            }else {
                return "horse_img upload failed!";
            }
            $horseName=$input['horseName'];

            return $horseName;
        }else{
            return false;
        }
    }
    //賽馬資料刪除
    public function horseDel()
    {
        $input = Input::all();
        if ($input['action'] != NULL && $input['action'] == 'delete')      //判斷值是否由欄位輸入
        {
            $rowName=DB::table('horse_data')
                ->select('horse_name')
                ->where('h_id', $input['num'])
                ->get();
            $horseName=$rowName[0]->horse_name;
            DB::table('horse_data')->where('h_id', '=', $input['num'])->delete();
            return $horseName;
        }else{
            return false;
        }
    }
}