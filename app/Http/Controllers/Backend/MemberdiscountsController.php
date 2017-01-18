<?php

namespace App\Http\Controllers\Backend;

use App\Discount;
use App\Member;
use App\Memberdiscount;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;

class MemberdiscountsController extends Controller
{
    protected $memberdiscounts;

    public function __construct(Memberdiscount $memberdiscounts)
    {
        $this->memberdiscounts = $memberdiscounts;

        parent::__construct();
    }

    public function index()
    {
        $memberdiscounts = Memberdiscount::with('member', 'discount')->orderBy('created_at', 'desc')->paginate(10);

        $this->checkExpiration();

        return view('backend.memberdiscounts.index', compact('memberdiscounts'));
    }

    public function create(Memberdiscount $memberdiscount)
    {
        $discounts = ['' => ''] + Discount::all()->pluck('title', 'id')->toArray();

        $mem = Member::select('lastname', 'firstname')->get();
        $members = ['' => ''];
        foreach ($mem as $member) {
            array_push($members, $member->lastname.', '.$member->firstname);
        }
        array_unshift($members,'');
        unset($members[0]);

        return view('backend.memberdiscounts.form', compact('memberdiscount', 'members', 'discounts'));
    }

    public function store(Requests\StoreMemberdiscountRequest $request)
    {
        Memberdiscount::create(array(
            'member_id' => $request->member_id,
            'discount_id' => $request->discount_id,
            'validity' => $request->validity,
            'startdate' => $request->startdate,
            'expired' => false,
            'cashedin' => false
        ));

        return redirect(route('memberdiscounts.index'))->with('status', 'Memberdiscount has been created.');
    }

    public function edit($id)
    {
        $memberdiscount = Memberdiscount::findOrFail($id);

        $discounts = ['' => ''] + Discount::all()->pluck('title', 'id')->toArray();

        $mem = Member::select('lastname', 'firstname')->get();
        $members = ['' => ''];
        foreach ($mem as $member) {
            array_push($members, $member->lastname.', '.$member->firstname);
        }
        array_unshift($members,'');
        unset($members[0]);

        return view('backend.memberdiscounts.form', compact('memberdiscount', 'members', 'discounts'));
    }

    public function update(Requests\UpdateMemberdiscountRequest $request, $id)
    {
        $memberdiscount = Memberdiscount::findOrFail($id);

        $memberdiscount->fill(array(
            'member_id' => $request->member_id,
            'discount_id' => $request->discount_id,
            'validity' => $request->validity,
            'startdate' => $request->startdate
        ))->save();

        return redirect(route('memberdiscounts.index'))->with('status', 'Memberdiscount has been updated.');
    }

    public function confirm($id)
    {
        $memberdiscount = Memberdiscount::findOrFail($id);

        return view('backend.memberdiscounts.confirm', compact('memberdiscount'));
    }

    public function destroy($id)
    {
        Memberdiscount::destroy($id);

        return redirect(route('memberdiscounts.index'))->with('status', 'Memberdiscount has been deleted.');
    }

    public function detail($id)
    {
        $memberdiscount = Memberdiscount::with('member', 'discount')->findOrFail($id);

        return view('backend.memberdiscounts.detail', compact('memberdiscount'));
    }

    public function checkExpiration()
    {
        $memberdiscounts = Memberdiscount::all();

        foreach ($memberdiscounts as $memberdiscount) {
            if ($memberdiscount->startdate->addDays($memberdiscount->validity) < Carbon::now()){
                $memberdiscount->fill(array(
                    'expired' => true
                ))->save();
            }
        }
    }
}
