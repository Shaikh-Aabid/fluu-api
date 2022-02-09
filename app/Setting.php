<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'banner_path_1',
        'banner_1_title',
        'banner_1_description',
        'banner_path_2',
        'banner_2_title',
        'banner_2_description',
        'banner_path_3',
        'banner_3_title',
        'banner_3_description',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
