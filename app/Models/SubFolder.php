<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Crypt;
use Yajra\Datatables\Datatables;

class SubFolder extends Model
{
    use HasFactory;
   

   const STATUS_INACTIVE=0;
   const STATUS_ACTIVE=1;

   public function sub_folder()
   {
   		return $this->belongsTo('\App\Models\Folder', 'folder_id', 'id');
   }
   
}
