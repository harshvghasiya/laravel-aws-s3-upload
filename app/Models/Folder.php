<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Crypt;
use Yajra\Datatables\Datatables;

class Folder extends Model
{
    use HasFactory;
   
   const STATUS_INACTIVE=0;
   const STATUS_ACTIVE=1;

   public function self_sub_folder()
   {
   		return $this->hasMany('\App\Models\SubFolder', 'parent_id', 'id');
   }

   public function self_folder()
   {
   		return $this->hasMany('\App\Models\SubFolder', 'folder_id', 'id');
   }


   
}
