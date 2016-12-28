<?php

namespace App\Http\Controllers\Backend;

use App\Member;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
        $members = Member::paginate(10);

        return view('backend.members.index', compact('members'));
    }

    public function create(Member $member)
    {
        return view('backend.members.form', compact('member'));
    }

    public function store(Requests\StoreMemberRequest $request)
    {
        Member::create(array(
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'birthday' => $request->birthday,
            'phone' => $request->phone,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'job' => $request->job,
            'employer' => $request->employer,
            'university' => $request->university,
            'courseofstudies' => $request->courseofstudies,
            'password' => Hash::make($request->password)
        ));

        return redirect('/admin/members')->with('status', 'Member has been created.');
    }

    public function edit($id)
    {
        $member = Member::findOrFail($id);
        return view('backend.members.form', compact('member'));
    }

    public function update(Requests\UpdateMemberRequest $request, $id)
    {
        $member = Member::findOrFail($id);

        $member->fill(array(
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'birthday' => $request->birthday,
            'phone' => $request->phone,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'job' => $request->job,
            'employer' => $request->employer,
            'university' => $request->university,
            'courseofstudies' => $request->courseofstudies,
            'password' => Hash::make($request->password)
        ))->save();

        return redirect('/admin/members')->with('status', 'Member has been updated.');
    }

    public function confirm($id)
    {
        $member = Member::findOrFail($id);
        return view('backend.members.confirm', compact('member'));
    }

    public function destroy($id)
    {
        Member::destroy($id);

        return redirect('/admin/members')->with('status', 'Member has been deleted.');
    }
}
