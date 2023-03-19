<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Crypt;
use Yajra\Datatables\Datatables;

class FileMan extends Model
{
    use HasFactory;


   const STATUS_INACTIVE=0;
   const STATUS_ACTIVE=1;

 
}
