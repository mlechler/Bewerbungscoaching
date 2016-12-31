<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\Post;

class RecentPosts extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $posts = Post::orderBy('updated_at', 'desc')->take(5)->get();

        return view("backend.widgets.recent_posts", [
            'config' => $this->config,
        ], compact('posts'));
    }
}