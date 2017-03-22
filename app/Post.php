<?php

namespace App;

use App\Presenters\PostPresenter;
use Illuminate\Database\Eloquent\Model;
use McCool\LaravelAutoPresenter\HasPresenter;

class Post extends Model implements HasPresenter
{
    protected $table = 'posts';
    protected $fillable = ['author_id', 'title', 'slug', 'body', 'excerpt', 'published_at', 'image', 'preview'];
    protected $dates = ['published_at'];

    public function getPresenterClass()
    {
        return PostPresenter::class;
    }

    public function setPublishedAtAttribute($value)
    {
        $this->attributes['published_at'] = $value ?: null;
    }

    public function author()
    {
        return $this->belongsTo(Employee::class);
    }
}
