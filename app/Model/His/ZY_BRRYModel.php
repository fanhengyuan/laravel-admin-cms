<?php

namespace App\Model\His;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ZY_BRRYModel
 * @package App\Model
 * 住院信息
 */
class ZY_BRRYModel extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'ZY_BRRY';
}
