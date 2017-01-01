<?php

namespace App\Widgets;

use App\Member;
use Arrilot\Widgets\AbstractWidget;

class RecentMembers extends AbstractWidget
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
        $members = Member::whereNotNull('last_login_at')->orderBy('last_login_at', 'desc')->take(5)->get();

        return view("backend.widgets.recent_members", [
            'config' => $this->config,
        ], compact('members'));
    }
}