<?php

namespace App\Http\Controllers\Backend;

use App\Applicationpackage;
use App\Packagepurchase;
use App\Member;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Storage;

class PackagePurchasesController extends Controller
{
    protected $packagepurchases;

    public function __construct(Packagepurchase $packagepurchases)
    {
        $this->packagepurchases = $packagepurchases;

        parent::__construct();
    }

    public function index()
    {
        $packagepurchases = Packagepurchase::with('member', 'applicationpackage')->orderBy('created_at', 'desc')->paginate(10);

        return view('backend.packagepurchases.index', compact('packagepurchases'));
    }

    public function create(Packagepurchase $packagepurchase)
    {
        $mem = Member::select('lastname', 'firstname')->get();
        $members = ['' => ''];
        foreach ($mem as $member) {
            array_push($members, $member->lastname . ', ' . $member->firstname);
        }
        array_unshift($members,'');
        unset($members[0]);

        $applicationpackages = ['' => ''] + Applicationpackage::all()->pluck('title', 'id')->toArray();

        return view('backend.packagepurchases.form', compact('packagepurchase', 'members', 'applicationpackages'));
    }

    public function store(Requests\StorePackagepurchaseRequest $request)
    {
        $packagepurchase = Packagepurchase::create(array(
            'member_id' => $request->member_id,
            'applicationpackage_id' => $request->applicationpackage_id,
            'price_incl_discount' => $request->price_incl_discount,
            'paid' => false,
            'path' => null
        ));

        if ($request->hasFile('package')) {
            $packageFile = $request->file('package');
            $this->storeFile($packageFile, $packagepurchase);
        }

        return redirect(route('packagepurchases.index'))->with('status', 'Package Purchase has been created.');
    }

    public function edit($id)
    {
        $packagepurchase = Packagepurchase::findOrFail($id);

        $mem = Member::select('lastname', 'firstname')->get();
        $members = ['' => ''];
        foreach ($mem as $member) {
            array_push($members, $member->lastname . ', ' . $member->firstname);
        }
        array_unshift($members,'');
        unset($members[0]);

        $applicationpackages = ['' => ''] + Applicationpackage::all()->pluck('title', 'id')->toArray();

        return view('backend.packagepurchases.form', compact('packagepurchase', 'members', 'applicationpackages'));
    }

    public function update(Requests\UpdatePackagepurchaseRequest $request, $id)
    {
        $packagepurchase = Packagepurchase::findOrFail($id);

        $packagepurchase->fill(array(
            'member_id' => $request->member_id,
            'applicationpackage_id' => $request->applicationpackage_id,
            'price_incl_discount' => $request->price_incl_discount
        ))->save();

        if ($request->hasFile('package')) {
            $packageFile = $request->file('package');
            $this->storeFile($packageFile, $packagepurchase);
        }

        return redirect(route('packagepurchases.index'))->with('status', 'Package Purchase has been updated.');
    }

    public function confirm($id)
    {
        $packagepurchase = Packagepurchase::findOrFail($id);

        return view('backend.packagepurchases.confirm', compact('packagepurchase'));
    }

    public function destroy($id)
    {
        Packagepurchase::destroy($id);

        return redirect(route('packagepurchases.index'))->with('status', 'Package Purchase has been deleted.');
    }

    public function detail($id)
    {
        $packagepurchase = Packagepurchase::with('member', 'applicationpackage')->findOrFail($id);

        return view('backend.packagepurchases.detail', compact('packagepurchase'));
    }

    public function storeFile($packageFile, $purchase)
    {
        $fileName = $packageFile->getClientOriginalName();
        $destinationpath = config('app.packageDestinationPath') . '/member' . $purchase->member_id . '/' . $fileName;
        $uploaded = Storage::put($destinationpath, file_get_contents($packageFile->getRealPath()));

        if ($uploaded) {
            $packagepurchase = Packagepurchase::findOrFail($purchase->id);

            $packagepurchase->fill(array(
                'path' => $destinationpath
            ))->save();
        }
    }

    public function deleteFile($id)
    {
        $package = Packagepurchase::findOrFail($id);

        Storage::delete($package->path);

        $package->fill(array(
            'path' => null
        ))->save();

        return redirect()->back()->with('status', 'File has been deleted.');
    }
}