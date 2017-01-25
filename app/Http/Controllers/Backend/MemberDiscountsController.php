<?php

namespace App\Http\Controllers\Backend;

use App\Discount;
use App\Events\ExpireMemberDiscount;
use App\Events\MakeMemberDiscount;
use App\Member;
use App\MemberDiscount;
use Carbon\Carbon;
use App\Http\Requests;

class MemberDiscountsController extends Controller
{
    protected $memberdiscounts;

    public function __construct(MemberDiscount $memberdiscounts)
    {
        $this->memberdiscounts = $memberdiscounts;

        parent::__construct();
    }

    public function index()
    {
        $memberdiscounts = MemberDiscount::with('member', 'discount')->orderBy('expired')->paginate(10);

        $this->checkExpiration();

        return view('backend.memberdiscounts.index', compact('memberdiscounts'));
    }

    public function create(MemberDiscount $memberdiscount)
    {
        $discounts = ['' => ''] + Discount::all()->pluck('title', 'id')->toArray();

        $mem = Member::select('lastname', 'firstname')->get();
        $members = ['' => ''];
        foreach ($mem as $member) {
            array_push($members, $member->lastname . ', ' . $member->firstname);
        }
        array_unshift($members, '');
        unset($members[0]);

        return view('backend.memberdiscounts.form', compact('memberdiscount', 'members', 'discounts'));
    }

    public function store(Requests\StoreMemberDiscountRequest $request)
    {
        $memberdiscount = MemberDiscount::create(array(
            'member_id' => $request->member_id,
            'discount_id' => $request->discount_id,
            'validity' => $request->validity,
            'permanent' => $request->permanent == 'on' ? true : false,
            'startdate' => $request->startdate,
            'code' => $request->code,
            'expired' => false,
            'expirationMailSend' => false,
            'cashedin' => false
        ));

        event(new MakeMemberDiscount($memberdiscount));

        return redirect(route('memberdiscounts.index'))->with('status', 'Member Discount has been created.');
    }

    public function edit($id)
    {
        $memberdiscount = MemberDiscount::findOrFail($id);

        $discounts = ['' => ''] + Discount::all()->pluck('title', 'id')->toArray();

        $mem = Member::select('lastname', 'firstname')->get();
        $members = ['' => ''];
        foreach ($mem as $member) {
            array_push($members, $member->lastname . ', ' . $member->firstname);
        }
        array_unshift($members, '');
        unset($members[0]);

        return view('backend.memberdiscounts.form', compact('memberdiscount', 'members', 'discounts'));
    }

    public function update(Requests\UpdateMemberDiscountRequest $request, $id)
    {
        $memberdiscount = MemberDiscount::findOrFail($id);

        $memberdiscount->fill(array(
            'member_id' => $request->member_id,
            'discount_id' => $request->discount_id,
            'validity' => $request->validity,
            'permanent' => $request->permanent == 'on' ? true : false,
            'startdate' => $request->startdate,
            'code' => $request->code
        ))->save();

        return redirect(route('memberdiscounts.index'))->with('status', 'Member Discount has been updated.');
    }

    public function confirm($id)
    {
        $memberdiscount = MemberDiscount::findOrFail($id);

        return view('backend.memberdiscounts.confirm', compact('memberdiscount'));
    }

    public function destroy($id)
    {
        MemberDiscount::destroy($id);

        return redirect(route('memberdiscounts.index'))->with('status', 'Member Discount has been deleted.');
    }

    public function detail($id)
    {
        $memberdiscount = MemberDiscount::with('member', 'discount')->findOrFail($id);

        return view('backend.memberdiscounts.detail', compact('memberdiscount'));
    }

    public function checkExpiration()
    {
        $memberdiscounts = MemberDiscount::all();

        foreach ($memberdiscounts as $memberdiscount) {
            if ($memberdiscount->startdate->addDays($memberdiscount->validity) < Carbon::now()) {
                if ($memberdiscount->permanent) {
                    $memberdiscount->fill(array(
                        'expired' => false
                    ))->save();
                } else {
                    $memberdiscount->fill(array(
                        'expired' => true
                    ))->save();
                }
                if(!$memberdiscount->expirationMailSend) {
                    event(new ExpireMemberDiscount($memberdiscount));
                    $memberdiscount->fill(array(
                        'expirationMailSend' => true
                    ))->save();
                }
            }
        }
    }
}
