<?php

namespace App\Widgets;

use App\Employee;
use Arrilot\Widgets\AbstractWidget;

class RecentEmployees extends AbstractWidget
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
        $employees = Employee::whereNotNull('last_login_at')->orderBy('last_login_at', 'desc')->take(5)->get();

        return view("backend.widgets.recent_employees", [
            'config' => $this->config,
        ], compact('employees'));
    }
}