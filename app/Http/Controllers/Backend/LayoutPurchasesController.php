<?php

namespace App\Http\Controllers\Backend;

use App\Applicationlayout;
use App\Events\MakeLayoutPurchase;
use App\Invoice;
use App\Layoutpurchase;
use App\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;

class LayoutPurchasesController extends Controller
{
    protected $layoutpurchases;

    public function __construct(Layoutpurchase $layoutpurchases)
    {
        $this->layoutpurchases = $layoutpurchases;

        parent::__construct();
    }

    public function index()
    {
        $layoutpurchases = Layoutpurchase::with('member', 'applicationlayout')->paginate(10);

        return view('backend.layoutpurchases.index', compact('layoutpurchases'));
    }

    public function create(Layoutpurchase $layoutpurchase)
    {
        $mem = Member::select('lastname', 'firstname')->get();
        $members = ['' => ''];
        foreach ($mem as $member) {
            array_push($members, $member->lastname.', '.$member->firstname);
        }
        array_unshift($members,'');
        unset($members[0]);

        $applicationlayouts = ['' => ''] + Applicationlayout::all()->pluck('title', 'id')->toArray();

        return view('backend.layoutpurchases.form', compact('layoutpurchase', 'members', 'applicationlayouts'));
    }

    public function store(Requests\StoreLayoutpurchaseRequest $request)
    {
        $layout = Applicationlayout::findOrFail($request->applicationlayout_id);
        $price = $request->price_incl_discount > $layout->price ? $layout->price : $request->price_incl_discount;

        $layoutpurchase = Layoutpurchase::create(array(
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
        $layoutpurchase = Layoutpurchase::findOrFail($id);

        $mem = Member::select('lastname', 'firstname')->get();
        $members = ['' => ''];
        foreach ($mem as $member) {
            array_push($members, $member->lastname.', '.$member->firstname);
        }
        array_unshift($members,'');
        unset($members[0]);

        $applicationlayouts = ['' => ''] + Applicationlayout::all()->pluck('title', 'id')->toArray();

        return view('backend.layoutpurchases.form', compact('layoutpurchase', 'members', 'applicationlayouts'));
    }

    public function update(Requests\UpdateLayoutpurchaseRequest $request, $id)
    {
        $layoutpurchase = Layoutpurchase::findOrFail($id);

        $layout = Applicationlayout::findOrFail($request->applicationlayout_id);
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
        $layoutpurchase = Layoutpurchase::findOrFail($id);

        return view('backend.layoutpurchases.confirm', compact('layoutpurchase'));
    }

    public function destroy($id)
    {
        Layoutpurchase::destroy($id);

        return redirect(route('layoutpurchases.index'))->with('status', 'Layout Purchase has been deleted.');
    }

    public function detail($id)
    {
        $layoutpurchase = Layoutpurchase::with('member', 'applicationlayout')->findOrFail($id);

        return view('backend.layoutpurchases.detail', compact('layoutpurchase'));
    }
}
