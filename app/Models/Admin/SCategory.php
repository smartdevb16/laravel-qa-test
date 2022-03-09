<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class SCategory extends Model
{
    //
    public $fillable = [
        'id',
        'name',
        'color',
    ];

    public function sQuestions() {
        return $this->hasMany('App\Models\Admin\SQuestion', 'sc_id', 'id');
    }
}
