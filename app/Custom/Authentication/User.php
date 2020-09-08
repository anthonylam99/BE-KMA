<?php

namespace App\Custom\Authentication;

use App\Projectors\Common\Hub;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthContract;

class User extends Model implements AuthContract
{
    use HasApiTokens, Authenticate;
    /**
     * @var string $table table name
     */
    protected $table = 'adm_user';

    /**
     * The column name primaryKey
     *
     * @var string $primaryKey
     */
    protected $primaryKey = 'adm_id';

 
}
