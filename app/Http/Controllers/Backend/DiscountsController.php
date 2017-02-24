<?php

namespace App\Http\Controllers\Backend;

use App\Discount;
use App\MemberDiscount;
use App\Http\Requests;
use Carbon\Carbon;

class DiscountsController extends Controller
{
    protected $discounts;

    public function __construct(Discount $discounts)
    {
        $this->discounts = $discounts;

        parent::__construct();
    }

    public function index()
    {
        $discounts = Discount::paginate(10);

        return view('backend.discounts.index', compact('discounts'));
    }

    public function create(Discount $discount)
    {
        return view('backend.discounts.form', compact('discount'));
    }

    public function store(Requests\Backend\StoreDiscountRequest $request)
    {
        Discount::create(array(
            'title' => $request->title,
            'service' => $request->service,
            'amount' => $request->amount,
            'percentage' => $request->percentage == 'on' ? true : false,
            'validity' => $request->validity,
            'permanent' => $request->permanent == 'on' ? true : false,
            'startdate' => $request->startdate,
            'code' => $request->code,
            'expired' => false
        ));

        return redirect(route('discounts.index'))->with('status', 'Discount has been created.');
    }

    public function edit($id)
    {
        $discount = Discount::findOrFail($id);

        return view('backend.discounts.form', compact('discount'));
    }

    public function update(Requests\Backend\UpdateDiscountRequest $request, $id)
    {
        $discount = Discount::findOrFail($id);

        $discount->fill(array(
            'title' => $request->title,
            'service' => $request->service,
            'amount' => $request->amount,
            'percentage' => $request->percentage == 'on' ? true : false,
            'validity' => $request->validity,
            'permanent' => $request->permanent == 'on' ? true : false,
            'startdate' => $request->startdate,
            'code' => $request->code,
            'expired' => false
        ))->save();

        return redirect(route('discounts.index'))->with('status', 'Discount has been updated.');
    }

    public function confirm($id)
    {
        $discount = Discount::findOrFail($id);

        return view('backend.discounts.confirm', compact('discount'));
    }

    public function destroy($id)
    {
        Discount::destroy($id);

        return redirect(route('discounts.index'))->with('status', 'Discount has been deleted.');
    }

    public function detail($id)
    {
        $discount = Discount::findOrFail($id);

        return view('backend.discounts.detail', compact('discount'));
    }

    public function checkExpiration()
    {
        $discounts = Discount::all();

        foreach ($discounts as $discount) {
            if ($discount->startdate->addDays($discount->validity) < Carbon::now()) {
                if ($discount->permanent) {
                    $discount->fill(array(
                        'expired' => false
                    ))->save();
                } else {
                    $discount->fill(array(
                        'expired' => true
                    ))->save();
                }
            }
        }
    }
}
