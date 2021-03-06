<?php

namespace App\Http\Controllers\Backend;

use App\ApplicationPackage;
use App\Events\MakePackagePurchase;
use App\Invoice;
use App\PackagePurchase;
use App\Member;
use Carbon\Carbon;
use Dropbox\WriteMode;
use GrahamCampbell\Dropbox\Facades\Dropbox;
use Illuminate\Http\Request;
use App\Http\Requests;

class PackagePurchasesController extends Controller
{
    protected $packagepurchases;

    public function __construct(PackagePurchase $packagepurchases)
    {
        $this->packagepurchases = $packagepurchases;

        parent::__construct();
    }

    public function index()
    {
        $packagepurchases = PackagePurchase::with('member', 'applicationpackage')->orderBy('created_at', 'desc')->paginate(10);

        return view('backend.packagepurchases.index', compact('packagepurchases'));
    }

    public function create(PackagePurchase $packagepurchase)
    {
        $mem = Member::select('id', 'lastname', 'firstname')->get();
        $members = ['' => ''];
        foreach ($mem as $member) {
            $members[$member->id] = $member->lastname . ', ' . $member->firstname;
        }

        $applicationpackages = ['' => ''] + ApplicationPackage::all()->pluck('title', 'id')->toArray();

        return view('backend.packagepurchases.form', compact('packagepurchase', 'members', 'applicationpackages'));
    }

    public function store(Requests\Backend\StorePackagePurchaseRequest $request)
    {
        $package = ApplicationPackage::findOrFail($request->applicationpackage_id);
        $price = $request->price_incl_discount > $package->price ? $package->price : $request->price_incl_discount;

        $packagepurchase = PackagePurchase::create(array(
            'member_id' => $request->member_id,
            'applicationpackage_id' => $request->applicationpackage_id,
            'price_incl_discount' => $price,
            'paid' => false,
            'path' => null
        ));

        if ($request->hasFile('package')) {
            $packageFile = $request->file('package');
            $this->storeFile($packageFile, $packagepurchase);
        }

        $invoice = Invoice::create(array(
            'member_id' => $request->member_id,
            'individualcoaching_id' => null,
            'booking_id' => null,
            'packagepurchase_id' => $packagepurchase->id,
            'layoutpurchase_id' => null,
            'totalprice' => $price,
            'date' => Carbon::now()
        ));

        event(new MakePackagePurchase($packagepurchase, $invoice));


        return redirect(route('packagepurchases.index'))->with('status', 'Package Purchase has been created.');
    }

    public function edit($id)
    {
        $packagepurchase = PackagePurchase::findOrFail($id);

        $mem = Member::select('id', 'lastname', 'firstname')->get();
        $members = ['' => ''];
        foreach ($mem as $member) {
            $members[$member->id] = $member->lastname . ', ' . $member->firstname;
        }

        $applicationpackages = ['' => ''] + ApplicationPackage::all()->pluck('title', 'id')->toArray();

        return view('backend.packagepurchases.form', compact('packagepurchase', 'members', 'applicationpackages'));
    }

    public function update(Requests\Backend\UpdatePackagePurchaseRequest $request, $id)
    {
        $packagepurchase = PackagePurchase::findOrFail($id);

        $package = ApplicationPackage::findOrFail($request->applicationpackage_id);
        $price = $request->price_incl_discount > $package->price ? $package->price : $request->price_incl_discount;

        $packagepurchase->fill(array(
            'member_id' => $request->member_id,
            'applicationpackage_id' => $request->applicationpackage_id,
            'price_incl_discount' => $price
        ))->save();

        if ($request->hasFile('package')) {
            $packageFile = $request->file('package');
            $this->storeFile($packageFile, $packagepurchase);
        }

        $invoice = Invoice::where('member_id', '=', $request->member_id)->where('packagepurchase_id', '=', $packagepurchase->id)->where('created_at', '=', $packagepurchase->created_at)->first();

        $invoice->fill(array(
            'totalprice' => $price
        ))->save();

        return redirect(route('packagepurchases.index'))->with('status', 'Package Purchase has been updated.');
    }

    public function confirm($id)
    {
        $packagepurchase = PackagePurchase::findOrFail($id);

        return view('backend.packagepurchases.confirm', compact('packagepurchase'));
    }

    public function destroy($id)
    {
        $this->deleteFile($id);
        PackagePurchase::destroy($id);

        return redirect(route('packagepurchases.index'))->with('status', 'Package Purchase has been deleted.');
    }

    public function detail($id)
    {
        $packagepurchase = PackagePurchase::with('member', 'applicationpackage')->findOrFail($id);

        return view('backend.packagepurchases.detail', compact('packagepurchase'));
    }

    public function storeFile($packageFile, $purchase)
    {
        $fileName = $packageFile->getClientOriginalName();
        $destinationPath = '/packages/member' . $purchase->member_id . '/' . $fileName;
        Dropbox::uploadFileFromString($destinationPath, WriteMode::force(), file_get_contents($packageFile));

        $downloadLink = Dropbox::createShareableLink($destinationPath);

        $packagepurchase = PackagePurchase::findOrFail($purchase->id);

        $packagepurchase->fill(array(
            'path' => $destinationPath,
            'packageDownload' => $downloadLink
        ))->save();
    }

    public function deleteFile($id)
    {
        $package = PackagePurchase::findOrFail($id);

        if ($package) {
            Dropbox::delete($package->path);

            $package->fill(array(
                'path' => null,
                'packageDownload' => null
            ))->save();
        }
        return redirect()->back()->with('status', 'File has been deleted.');
    }

    public function uploadPackageFile(Requests\Backend\UploadPackageRequest $request, $id)
    {
        $purchase = PackagePurchase::findOrFail($id);

        if ($request->hasFile('package')) {
            $packageFile = $request->file('package');
            $this->storeFile($packageFile, $purchase);
        }

        return redirect()->back()->with('status', 'Package has been uploaded.');
    }
}
