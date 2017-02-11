<?php

namespace App\Http\Controllers\Backend;

use App\ApplicationLayout;
use App\Events\MakeLayoutPurchase;
use App\Invoice;
use App\LayoutPurchase;
use App\Member;
use Carbon\Carbon;
use App\Http\Requests;

class LayoutPurchasesController extends Controller
{
    protected $layoutpurchases;

    public function __construct(LayoutPurchase $layoutpurchases)
    {
        $this->layoutpurchases = $layoutpurchases;

        parent::__construct();
    }

    public function index()
    {
        $layoutpurchases = LayoutPurchase::with('member', 'applicationlayout')->paginate(10);

        return view('backend.layoutpurchases.index', compact('layoutpurchases'));
    }

    public function create(LayoutPurchase $layoutpurchase)
    {
        $mem = Member::select('lastname', 'firstname')->get();
        $members = ['' => ''];
        foreach ($mem as $member) {
            array_push($members, $member->lastname.', '.$member->firstname);
        }
        array_unshift($members,'');
        unset($members[0]);

        $applicationlayouts = ['' => ''] + ApplicationLayout::all()->pluck('title', 'id')->toArray();

        return view('backend.layoutpurchases.form', compact('layoutpurchase', 'members', 'applicationlayouts'));
    }

    public function store(Requests\Backend\StoreLayoutPurchaseRequest $request)
    {
        $layout = ApplicationLayout::findOrFail($request->applicationlayout_id);
        $price = $request->price_incl_discount > $layout->price ? $layout->price : $request->price_incl_discount;

        $layoutpurchase = LayoutPurchase::create(array(
            'member_id' => $request->member_id,
            'applicationlayout_id' => $request->applicationlayout_id,
            'price_incl_discount' => $price,
            'paid' => false
        ));

        $invoice = Invoice::create(array(
            'member_id' => $request->member_id,
            'individualcoaching_id' => null,
            'booking_id' => null,
            'packagepurchase_id' => null,
            'layoutpurchase_id' => $layoutpurchase->id,
            'totalprice' => $price,
            'date' => Carbon::now()
        ));

        event(new MakeLayoutPurchase($layoutpurchase, $invoice));

        return redirect(route('layoutpurchases.index'))->with('status', 'Layout Purchase has been created.');
    }

    public function edit($id)
    {
        $layoutpurchase = LayoutPurchase::findOrFail($id);

        $mem = Member::select('lastname', 'firstname')->get();
        $members = ['' => ''];
        foreach ($mem as $member) {
            array_push($members, $member->lastname.', '.$member->firstname);
        }
        array_unshift($members,'');
        unset($members[0]);

        $applicationlayouts = ['' => ''] + ApplicationLayout::all()->pluck('title', 'id')->toArray();

        return view('backend.layoutpurchases.form', compact('layoutpurchase', 'members', 'applicationlayouts'));
    }

    public function update(Requests\Backend\UpdateLayoutPurchaseRequest $request, $id)
    {
        $layoutpurchase = LayoutPurchase::findOrFail($id);

        $layout = ApplicationLayout::findOrFail($request->applicationlayout_id);
        $price = $request->price_incl_discount > $layout->price ? $layout->price : $request->price_incl_discount;

        $layoutpurchase->fill(array(
            'member_id' => $request->member_id,
            'applicationlayout_id' => $request->applicationlayout_id,
            'price_incl_discount' => $price
        ))->save();

        $invoice = Invoice::where('member_id', '=', $request->member_id)->where('layoutpurchase_id', '=', $layoutpurchase->id)->where('created_at', '=', $layoutpurchase->created_at)->first();

        $invoice->fill(array(
            'totalprice' => $price
        ))->save();

        return redirect(route('layoutpurchases.index'))->with('status', 'Layout Purchase has been updated.');
    }

    public function confirm($id)
    {
        $layoutpurchase = LayoutPurchase::findOrFail($id);

        return view('backend.layoutpurchases.confirm', compact('layoutpurchase'));
    }

    public function destroy($id)
    {
        LayoutPurchase::destroy($id);

        return redirect(route('layoutpurchases.index'))->with('status', 'Layout Purchase has been deleted.');
    }

    public function detail($id)
    {
        $layoutpurchase = LayoutPurchase::with('member', 'applicationlayout')->findOrFail($id);

        return view('backend.layoutpurchases.detail', compact('layoutpurchase'));
    }
}
