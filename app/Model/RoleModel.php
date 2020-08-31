<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
    protected $table         = 'adm_group';
    protected $primaryKey    = "gr_id";
    public $timestamps         = false;

}
