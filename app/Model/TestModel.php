<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TestModel extends Model
{
    protected $table = 'test';
    protected $primaryKey = 'id';

    public static function getMember()
    {
        return 'member name is sean';
    }

    public function getContentAttribute($value)
    {
        return html_entity_decode($value);
    }

    public function setContentAttribute($value)
    {
        $this->attributes['content'] = htmlentities($value);
    }
}
