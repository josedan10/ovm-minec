<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'meta_description', 'meta_keywords', 'meta_robots', 'content'
    ];

    public function lastModifiedBy () {
        return $this->belongsTo('App\User');
    }

    public function createdBy () {
        return $this->belongsTo('App\User');
    }
}