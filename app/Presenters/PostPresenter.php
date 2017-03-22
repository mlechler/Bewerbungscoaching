<?php

namespace App\Presenters;

use App\Post;
use GrahamCampbell\Dropbox\Facades\Dropbox;
use McCool\LaravelAutoPresenter\BasePresenter;
use AlfredoRamos\ParsedownExtra\Facades\ParsedownExtra as Markdown;

class PostPresenter extends BasePresenter
{
    public function excerptHtml()
    {
        return ($this->excerpt ? Markdown::parse($this->excerpt) : null);
    }

    public function bodyHtml()
    {
        return ($this->body ? Markdown::parse($this->body) : null);
    }

    public function getName()
    {
        if($this->author == null) {
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
        if($this->published_at && $this->published_at->isFuture()){
            return 'info';
        } elseif(! $this->published_at){
            return 'danger';
        }
    }

    public function getPreview()
    {
        if ($this->image) {
            $link = Dropbox::createShareableLink($this->image);
            $newlink = substr($link, 0, -1);

            return '<a href="' . $link . '" target="_blank">
                                <img src="' . $newlink . '1&raw=1"
                                     style="width:200px; height:320px;"></a>';
        }

        return 'Currently no Preview available.';
    }
}