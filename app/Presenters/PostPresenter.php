<?php

namespace App\Presenters;

use App\Post;
use McCool\LaravelAutoPresenter\BasePresenter;
use League\CommonMark\Converter;

class PostPresenter extends BasePresenter
{
    public function __construct($resource, Converter $converter)
    {
        $this->converter = $converter;

        parent::__construct($resource);
    }

    public function excerptHtml()
    {
        return $this->excerpt ? $this->converter->convertToHtml($this->excerpt) : null;
    }

    public function bodyHtml()
    {
        return $this->body ? $this->converter->convertToHtml($this->body) : null;
    }

    public function getName()
    {
        if($this->author == null) {
            $post = Post::findOrFail($this->id);

            $post->fill(array('author_id' => null))->save();
            return 'Author not found';
        }
        return ($this->author->lastname . ' ' . $this->author->firstname);
    }

    public function publishedDate()
    {
        if ($this->published_at) {
            return $this->published_at->toFormattedDateString();
        }

        return 'Not Published';
    }

    public function publishedHighlight()
    {
        if($this->published_at && $this->published_at->isFuture()){
            return 'info';
        } elseif(! $this->published_at){
            return 'warning';
        }
    }
}