<?php

namespace App\Http\Controllers\Backend;

use App\Member;
use App\Adress;
use App\Role;
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
        $adress = null;

        $roles = ['' => ''] + Role::all()->pluck('display_name', 'id')->toArray();

        return view('backend.members.form', compact('member', 'adress', 'roles'));
    }

    public function store(Requests\StoreMemberRequest $request)
    {
        $adress = Adress::where('zip', '=', $request->zip)->where('city', '=', $request->city)->where('street', '=', $request->street)->where('housenumber', '=', $request->housenumber)->first();

        if (!$adress) {
            $newadress = Adress::create(array(
                'zip' => $request->zip,
                'city' => $request->city,
                'street' => $request->street,
                'housenumber' => $request->housenumber
            ));
            $adress = $newadress;
        }

        Member::create(array(
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'birthday' => $request->birthday,
            'phone' => $request->phone,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'adress_id' => $adress->id,
            'role_id' => $request->role_id,
            'job' => $request->job,
            'employer' => $request->employer,
            'university' => $request->university,
            'courseofstudies' => $request->courseofstudies,
            'password' => Hash::make($request->password),
            'remember_token' => Auth::viaRemember()
        ));

        return redirect(route('members.index'))->with('status', 'Member has been created.');
    }

    public function edit($id)
    {
        $member = Member::findOrFail($id);

        $adress = Adress::whereId($member->adress_id)->first();

        $roles = ['' => ''] + Role::all()->pluck('display_name', 'id')->toArray();

        return view('backend.members.form', compact('member', 'adress', 'roles'));
    }

    public function update(Requests\UpdateMemberRequest $request, $id)
    {
        $adress = Adress::where('zip', '=', $request->zip)->where('city', '=', $request->city)->where('street', '=', $request->street)->where('housenumber', '=', $request->housenumber)->first();

        if (!$adress) {
            $newadress = Adress::create(array(
                'zip' => $request->zip,
                'city' => $request->city,
                'street' => $request->street,
                'housenumber' => $request->housenumber
            ));
            $adress = $newadress;
        }

        $member = Member::findOrFail($id);

        $member->fill(array(
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'birthday' => $request->birthday,
            'phone' => $request->phone,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'adress_id' => $adress->id,
            'role_id' => $request->role_id,
            'job' => $request->job,
            'employer' => $request->employer,
            'university' => $request->university,
            'courseofstudies' => $request->courseofstudies,
            'password' => Hash::make($request->password),
            'remember_token' => Auth::viaRemember()
        ))->save();

        return redirect(route('members.index'))->with('status', 'Member has been updated.');
    }

    public function confirm($id)
    {
        $member = Member::findOrFail($id);

        return view('backend.members.confirm', compact('member'));
    }

    public function destroy($id)
    {
        Member::destroy($id);

        return redirect(route('members.index'))->with('status', 'Member has been deleted.');
    }
}
