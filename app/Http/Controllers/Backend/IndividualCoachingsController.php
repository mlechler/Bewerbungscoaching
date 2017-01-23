<?php

namespace App\Http\Controllers\Backend;

use App\Adress;
use App\Events\MakeCoachingBooking;
use App\Individualcoaching;
use App\Employee;
use App\Invoice;
use App\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\App;

class IndividualCoachingsController extends Controller
{
    protected $coachings;

    public function __construct(Individualcoaching $coachings)
    {
        $this->coachings = $coachings;

        parent::__construct();
    }

    public function index()
    {
        $coachings = Individualcoaching::with('employee', 'member')->orderBy('created_at', 'desc')->paginate(10);

        return view('backend.individualcoachings.index', compact('coachings'));
    }

    public function create(Individualcoaching $coaching)
    {
        $emp = Employee::select('lastname', 'firstname')->get();
        $employees = ['' => ''];
        foreach ($emp as $employee) {
            array_push($employees, $employee->lastname.', '.$employee->firstname);
        }
        array_unshift($employees,'');
        unset($employees[0]);

        $mem = Member::select('lastname', 'firstname')->get();
        $members = ['' => ''];
        foreach ($mem as $member) {
            array_push($members, $member->lastname.', '.$member->firstname);
        }
        array_unshift($members,'');
        unset($members[0]);

        return view('backend.individualcoachings.form', compact('coaching', 'employees', 'members'));
    }

    public function store(Requests\StoreCoachingRequest $request)
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

        $coaching = Individualcoaching::create(array(
            'services' => $request->services,
            'date' => $request->date,
            'time' => $request->time,
            'duration' => $request->duration,
            'price_incl_discount' => $request->price_incl_discount,
            'trial' => $request->trial == 'on' ? true : false,
            'employee_id' => $request->employee_id,
            'member_id' => $request->member_id,
            'adress_id' => $adress->id,
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
        $coaching = Individualcoaching::findOrFail($id);

        $emp = Employee::select('lastname', 'firstname')->get();
        $employees = ['' => ''];
        foreach ($emp as $employee) {
            array_push($employees, $employee->lastname.', '.$employee->firstname);
        }
        array_unshift($employees,'');
        unset($employees[0]);

        $mem = Member::select('lastname', 'firstname')->get();
        $members = ['' => ''];
        foreach ($mem as $member) {
            array_push($members, $member->lastname.', '.$member->firstname);
        }
        array_unshift($members,'');
        unset($members[0]);

        return view('backend.individualcoachings.form', compact('coaching', 'employees', 'members'));
    }

    public function update(Requests\UpdateCoachingRequest $request, $id)
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

        $coaching = Individualcoaching::findOrFail($id);

        $coaching->fill(array(
            'services' => $request->services,
            'date' => $request->date,
            'time' => $request->time,
            'duration' => $request->duration,
            'price_incl_discount' => $request->price_incl_discount,
            'trial' => $request->trial == 'on' ? true : false,
            'employee_id' => $request->employee_id,
            'member_id' => $request->member_id,
            'adress_id' => $adress->id
        ))->save();

        return redirect(route('individualcoachings.index'))->with('status', 'Coaching has been updated.');
    }

    public function confirm($id)
    {
        $coaching = Individualcoaching::findOrFail($id);

        return view('backend.individualcoachings.confirm', compact('coaching'));
    }

    public function destroy($id)
    {
        Individualcoaching::destroy($id);

        return redirect(route('individualcoachings.index'))->with('status', 'Coaching has been deleted.');
    }

    public function detail($id)
    {
        $coaching = Individualcoaching::with('employee', 'member')->findOrFail($id);

        return view('backend.individualcoachings.detail', compact('coaching'));
    }
}
