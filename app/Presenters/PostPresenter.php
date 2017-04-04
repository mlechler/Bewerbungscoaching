<?php

namespace App\Presenters;

use App\Post;
use GrahamCampbell\Dropbox\Facades\Dropbox;
use Intervention\Image\Facades\Image;
use McCool\LaravelAutoPresenter\BasePresenter;
use AlfredoRamos\ParsedownExtra\Facades\ParsedownExtra as Markdown;

class PostPresenter extends BasePresenter
{
    public function excerptHtml()
    {
        return ($this->excerpt ? Markdown::parse($this->excerpt) : null);
    }

    public function shortExcerptHtml()
    {
        $excerpt = Markdown::parse($this->excerpt);
        $pieces = explode(" ", $excerpt);
        return (implode(" ", array_splice($pieces, 0, 25)));
    }

    public function bodyHtml()
    {
        return ($this->body ? Markdown::parse($this->body) : null);
    }

    public function shortBodyHtml()
    {
        $body = Markdown::parse($this->body);
        $pieces = explode(" ", $body);
        return (implode(" ", array_splice($pieces, 0, 25)));
    }

    public function getName()
    {
        if ($this->author == null) {
            $post = Post::findOrFail($this->id);

            $post->fill(array('author_id' => null))->save();
            return 'Author not found';
        }
        return ($this->author->lastname . ', ' . $this->author->firstname);
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
        if ($this->published_at && $this->published_at->isFuture()) {
            return 'info';
        } elseif (!$this->published_at) {
            return 'danger';
        }
    }

    public
    function getPreview()
    {
        if ($this->preview) {
            $newlink = substr($this->preview, 0, -1);

            return $newlink . '1&raw=1';
        }

        return null;
    }
}