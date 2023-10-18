<?php
 function createDirecrotory($folder)
{
    if (!file_exists(storage_path().$folder)) {
        mkdir(storage_path().'/'.$folder, 0777, true);
    }
}

function change_active_status($table_name,$id)
{

     $data =  \DB::table($table_name)->where(['id'=>$id])->first();
     if($data->is_active=='1')
     {
         $category = \DB::table($table_name)->where(['id'=>$id])->update(['is_active'=>'0']);
         return false;
         
     }
     else
     {
         $category = \DB::table($table_name)->where(['id'=>$id])->update(['is_active'=>'1']);
         return true;
     }
 }

?>