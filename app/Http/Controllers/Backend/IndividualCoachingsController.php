<?php

namespace App\Http\Controllers\Backend;

use App\Address;
use App\Events\CancelCoaching;
use App\Events\ChangeCoachingAddress;
use App\Events\ChangeCoachingDateTime;
use App\Events\MakeCoachingBooking;
use App\IndividualCoaching;
use App\Employee;
use App\Invoice;
use App\Member;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class IndividualCoachingsController extends Controller
{
    protected $coachings;

    public function __construct(IndividualCoaching $coachings)
    {
        $this->coachings = $coachings;

        parent::__construct();
    }

    public function index()
    {
        if (Auth::user()->isAdmin()) {
            $coachings = IndividualCoaching::with('employee', 'member')->orderBy('created_at', 'desc')->paginate(10);
        } else {
            $coachings = IndividualCoaching::with('employee', 'member')->where('employee_id', '=', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(10);
        }
        return view('backend.individualcoachings.index', compact('coachings'));
    }

    public function create(IndividualCoaching $coaching)
    {
        if (!Auth::user()->isAdmin()) {
            $emp = Employee::select('id', 'lastname', 'firstname')->whereId(Auth::user()->id)->get();
            $employees = ['' => ''];
            foreach ($emp as $employee) {
                $employees[$employee->id] = $employee->lastname . ', ' . $employee->firstname;
            }
        } else {
            $emp = Employee::select('lastname', 'firstname')->get();
            $employees = ['' => ''];
            foreach ($emp as $employee) {
                array_push($employees, $employee->lastname . ', ' . $employee->firstname);
            }
            array_unshift($employees, '');
            unset($employees[0]);
        }

        $mem = Member::select('lastname', 'firstname')->get();
        $members = ['' => ''];
        foreach ($mem as $member) {
            array_push($members, $member->lastname . ', ' . $member->firstname);
        }
        array_unshift($members, '');
        unset($members[0]);

        return view('backend.individualcoachings.form', compact('coaching', 'employees', 'members'));
    }

    public function store(Requests\StoreCoachingRequest $request)
    {
        $address = Address::where('zip', '=', $request->zip)->where('city', '=', $request->city)->where('street', '=', $request->street)->where('housenumber', '=', $request->housenumber)->first();

        if (!$address) {
            $newaddress = Address::create(array(
                'zip' => $request->zip,
                'city' => $request->city,
                'street' => $request->street,
                'housenumber' => $request->housenumber
            ));
            $address = $newaddress;
        }

        $coaching = IndividualCoaching::create(array(
            'services' => $request->services,
            'date' => $request->date,
            'time' => $request->time,
            'duration' => $request->duration,
            'price_incl_discount' => $request->price_incl_discount,
            'trial' => $request->trial == 'on' ? true : false,
            'employee_id' => $request->employee_id,
            'member_id' => $request->member_id,
            'address_id' => $address->id,
            'paid' => $request->trial == 'on' ? true : false,
        ));

        $invoice = Invoice::create(array(
            'member_id' => $request->member_id,
            'individualcoaching_id' => $coaching->id,
            'booking_id' => null,
            'packagepurchase_id' => null,
            'layoutpurchase_id' => null,
            'totalprice' => $request->price_incl_discount,
            'date' => Carbon::now()
        ));

        event(new MakeCoachingBooking($coaching, $invoice));

        return redirect(route('individualcoachings.index'))->with('status', 'Coaching has been created.');
    }

    public function edit($id)
    {
        $coaching = IndividualCoaching::findOrFail($id);

        if (!Auth::user()->isAdmin()) {
            $emp = Employee::select('id', 'lastname', 'firstname')->whereId(Auth::user()->id)->get();
            $employees = ['' => ''];
            foreach ($emp as $employee) {
                $employees[$employee->id] = $employee->lastname . ', ' . $employee->firstname;
            }
        } else {
            $emp = Employee::select('lastname', 'firstname')->get();
            $employees = ['' => ''];
            foreach ($emp as $employee) {
                array_push($employees, $employee->lastname . ', ' . $employee->firstname);
            }
            array_unshift($employees, '');
            unset($employees[0]);
        }

        $mem = Member::select('lastname', 'firstname')->get();
        $members = ['' => ''];
        foreach ($mem as $member) {
            array_push($members, $member->lastname . ', ' . $member->firstname);
        }
        array_unshift($members, '');
        unset($members[0]);

        return view('backend.individualcoachings.form', compact('coaching', 'employees', 'members'));
    }

    public function update(Requests\UpdateCoachingRequest $request, $id)
    {
        $address = Address::where('zip', '=', $request->zip)->where('city', '=', $request->city)->where('street', '=', $request->street)->where('housenumber', '=', $request->housenumber)->first();

        if (!$address) {
            $newaddress = Address::create(array(
                'zip' => $request->zip,
                'city' => $request->city,
                'street' => $request->street,
                'housenumber' => $request->housenumber
            ));
            $address = $newaddress;
        }

        $coaching = IndividualCoaching::findOrFail($id);

        $olddate = $coaching->date;
        $oldtime = Carbon::parse($coaching->time)->format('H:i');
        $oldaddress_id = $coaching->address_id;

        $coaching->fill(array(
            'services' => $request->services,
            'date' => $request->date,
            'time' => $request->time,
            'duration' => $request->duration,
            'price_incl_discount' => $request->price_incl_discount,
            'trial' => $request->trial == 'on' ? true : false,
            'employee_id' => $request->employee_id,
            'member_id' => $request->member_id,
            'address_id' => $address->id
        ))->save();

        if ($olddate != $coaching->date || $oldtime != $coaching->time) {
            event(new ChangeCoachingDateTime($coaching, $olddate, $oldtime));
        }

        if ($oldaddress_id != $coaching->address_id) {
            $oldaddress = Address::findOrFail($oldaddress_id);
            event(new ChangeCoachingAddress($coaching, $oldaddress));
        }

        return redirect(route('individualcoachings.index'))->with('status', 'Coaching has been updated.');
    }

    public function confirm($id)
    {
        $coaching = IndividualCoaching::findOrFail($id);

        return view('backend.individualcoachings.confirm', compact('coaching'));
    }

    public function destroy($id)
    {
        $coaching = IndividualCoaching::findOrFail($id);

        event(new CancelCoaching($coaching));

        IndividualCoaching::destroy($id);

        return redirect(route('individualcoachings.index'))->with('status', 'Coaching has been deleted.');
    }

    public function detail($id)
    {
        $coaching = IndividualCoaching::with('employee', 'member')->findOrFail($id);

        return view('backend.individualcoachings.detail', compact('coaching'));
    }
}
