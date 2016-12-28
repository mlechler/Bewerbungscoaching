<?php

namespace App\Http\Controllers\Backend;

use App\Employee;
use App\Member;
use Illuminate\Http\Request;
use App\Http\Requests;

class MembersController extends Controller
{
    protected $members;

    public function __construct(Member $members)
    {
        $this->member = $members;

        parent::__construct();
    }

    public function index()
    {
        $members = Member::all();

        return view('backend.members.index', compact('members'));
    }

    public function confirm($id)
    {
        echo $id;
    }

    public function edit($id)
    {
        echo $id;
    }
}
