<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table         = 'adm_user';
    protected $primaryKey    = "adm_id";
    public $timestamps         = false;

}
