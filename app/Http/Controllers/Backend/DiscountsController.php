<?php

namespace App\Http\Controllers\Backend;

use App\Discount;
use App\MemberDiscount;
use App\Http\Requests;

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
        $discounts = Discount::orderBy('title')->paginate(10);

        return view('backend.discounts.index', compact('discounts'));
    }

    public function create(Discount $discount)
    {
        return view('backend.discounts.form', compact('discount'));
    }

    public function store(Requests\StoreDiscountRequest $request)
    {
        Discount::create(array(
            'title' => $request->title,
            'service' => $request->service,
            'amount' => $request->amount,
            'percentage' => $request->percentage == 'on' ? true : false
        ));

        return redirect(route('discounts.index'))->with('status', 'Discount has been created.');
    }

    public function edit($id)
    {
        $discount = Discount::findOrFail($id);

        return view('backend.discounts.form', compact('discount'));
    }

    public function update(Requests\UpdateDiscountRequest $request, $id)
    {
        $discount = Discount::findOrFail($id);

        $discount->fill(array(
            'title' => $request->title,
            'service' => $request->service,
            'amount' => $request->amount,
            'percentage' => $request->percentage == 'on' ? true : false
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

        $this->deleteMemberDiscounts($id);

        return redirect(route('discounts.index'))->with('status', 'Discount has been deleted.');
    }

    public function detail($id)
    {
        $discount = Discount::findOrFail($id);

        return view('backend.discounts.detail', compact('discount'));
    }

    public function deleteMemberDiscounts($discount_id)
    {
        $discounts = MemberDiscount::all()->where('discount_id', '=', $discount_id);

        foreach ($discounts as $discount) {
            MemberDiscount::destroy($discount->id);
        }
    }
}
