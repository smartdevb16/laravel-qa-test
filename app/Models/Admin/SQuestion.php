<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class SQuestion extends Model
{
    //
    public $fillable = [
        'id',
        'sc_id',
        'title',
        'contents',
        'score',
        'attached_files',
        'sanswer_ids',
        'sreply_ids',
    ];

    public function sCategory() {
        return $this->belongsTo('App\Models\Admin\SCategory', 'sc_id', 'id');
    }
}
