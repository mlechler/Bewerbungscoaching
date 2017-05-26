<?php

namespace App\Http\Controllers\Backend;

use App\Booking;
use App\Events\UploadMemberFile;
use App\IndividualCoaching;
use App\Invoice;
use App\LayoutPurchase;
use App\Member;
use App\Address;
use App\MemberDiscount;
use App\MemberFile;
use App\PackagePurchase;
use App\Role;
use Carbon\Carbon;
use Dropbox\WriteMode;
use GrahamCampbell\Dropbox\Facades\Dropbox;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Cornford\Googlmapper\Facades\MapperFacade as Mapper;

class MembersController extends Controller
{
    protected $members;

    public function __construct(Member $members)
    {
        $this->member = $members;

        parent::__construct();
    }

    public function index()
    {
        $members = Member::orderBy('lastname')->paginate(10);

        return view('backend.members.index', compact('members'));
    }

    public function create(Member $member)
    {
        $roles = ['' => ''] + Role::all()->pluck('display_name', 'id')->toArray();

        return view('backend.members.form', compact('member', 'roles'));
    }

    public function store(Requests\Backend\StoreMemberRequest $request)
    {
        $address = Address::where('zip', '=', $request->zip)->where('city', '=', $request->city)->where('street', '=', $request->street)->where('housenumber', '=', $request->housenumber)->first();

        if (!$address) {
            $geo = Mapper::location('Germany' . $request->zip . $request->street . $request->housenumber);
            if ($geo) {
                $newaddress = Address::create(array(
                    'zip' => $request->zip,
                    'city' => $request->city,
                    'street' => $request->street,
                    'housenumber' => $request->housenumber,
                    'latitude' => $geo->getLatitude(),
                    'longitude' => $geo->getLongitude()
                ));
                $address = $newaddress;
            } else {
                return redirect()->back()->withErrors(['error' => 'Address not found.']);
            }
        }

        $member = Member::create(array(
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'birthday' => $request->birthday,
            'phone' => $request->phone,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'address_id' => $address->id,
            'role_id' => $request->role_id,
            'job' => $request->job,
            'employer' => $request->employer,
            'university' => $request->university,
            'courseofstudies' => $request->courseofstudies,
            'password' => Hash::make($request->password),
            'remember_token' => Auth::viaRemember()
        ));

        if ($request->hasFile('files')) {
            $files = $request->file('files');
            $this->storeFiles($files, $member->id);

            event(new UploadMemberFile($member));
        }

        return redirect(route('members.index'))->with('status', 'Member has been created.');
    }

    public function edit($id)
    {
        $member = Member::findOrFail($id);

        $roles = ['' => ''] + Role::all()->pluck('display_name', 'id')->toArray();

        return view('backend.members.form', compact('member', 'roles'));
    }

    public function update(Requests\Backend\UpdateMemberRequest $request, $id)
    {
        $address = Address::where('zip', '=', $request->zip)->where('city', '=', $request->city)->where('street', '=', $request->street)->where('housenumber', '=', $request->housenumber)->first();

        if (!$address) {
            $geo = Mapper::location('Germany' . $request->zip . $request->street . $request->housenumber);
            if ($geo) {
                $newaddress = Address::create(array(
                    'zip' => $request->zip,
                    'city' => $request->city,
                    'street' => $request->street,
                    'housenumber' => $request->housenumber,
                    'latitude' => $geo->getLatitude(),
                    'longitude' => $geo->getLongitude()
                ));
                $address = $newaddress;
            } else {
                return redirect()->back()->withErrors(['error' => 'Address not found.']);
            }
        }

        $member = Member::findOrFail($id);

        $oldpw = $member->password;

        $member->fill(array(
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'birthday' => $request->birthday,
            'phone' => $request->phone,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'address_id' => $address->id,
            'role_id' => $request->role_id,
            'job' => $request->job,
            'employer' => $request->employer,
            'university' => $request->university,
            'courseofstudies' => $request->courseofstudies,
            'password' => $request->password ? Hash::make($request->password) : $oldpw,
            'remember_token' => Auth::viaRemember()
        ))->save();

        if ($request->hasFile('files')) {
            $files = $request->file('files');
            $this->storeFiles($files, $member->id);

            event(new UploadMemberFile($member));
        }

        return redirect(route('members.index'))->with('status', 'Member has been updated.');
    }

    public function confirm($id)
    {
        $member = Member::findOrFail($id);

        return view('backend.members.confirm', compact('member'));
    }

    public function destroy($id)
    {
        Member::destroy($id);

        $this->deleteFiles($id);
        $this->deleteBookings($id);
        $this->deleteCoachings($id);
        $this->deleteDiscounts($id);
        $this->deleteLayouts($id);
        $this->deletePackages($id);
        $this->deleteInvoices($id);

        return redirect(route('members.index'))->with('status', 'Member has been deleted.');
    }

    public function detail($id)
    {
        $member = Member::findOrFail($id);

        return view('backend.members.detail', compact('member'));
    }

    public function storeFiles($files, $member_id)
    {
        foreach ($files as $file) {
            $fileName = $file->getClientOriginalName();
            $fileType = $file->getClientMimeType();
            $destinationPath = '/members/' . $member_id . '/' . $fileName;

            Dropbox::uploadFileFromString($destinationPath, WriteMode::force(), file_get_contents($file));

            $memberfile = MemberFile::where('path', '=', $destinationPath)->first();

            $downloadLink = Dropbox::createShareableLink($destinationPath);

            if (!$memberfile) {
                MemberFile::create(array(
                    'name' => $fileName,
                    'path' => $destinationPath,
                    'type' => $fileType,
                    'size' => filesize($file),
                    'member_id' => $member_id,
                    'checked' => false,
                    'download' => $downloadLink
                ));
            } elseif ($memberfile) {
                $memberfile->fill(array(
                    'name' => $fileName,
                    'path' => $destinationPath,
                    'type' => $fileType,
                    'size' => filesize($file),
                    'member_id' => $member_id,
                    'checked' => true,
                    'download' => $downloadLink
                ))->save();
            }
        }
    }

    public function deleteAllFiles(Requests\Backend\DeleteAllMemberFilesRequest $request)
    {
        switch ($request->timerange) {
            case 'one':
                $date = Carbon::now()->subMonths(1)->format('Y-m-d');
                break;
            case 'three':
                $date = Carbon::now()->subMonths(3)->format('Y-m-d');
                break;
            case 'six':
                $date = Carbon::now()->subMonths(6)->format('Y-m-d');
                break;
        }

        $files = MemberFile::where('updated_at', '<=', $date)->get();

        if ($files) {
            foreach ($files as $file) {
                MemberFile::destroy($file->id);
                Dropbox::delete($file->path);
            }
        }
        return redirect(route('members.index'))->with('status', 'Files have been deleted.');
    }

    public function uploadCheckedFiles(Request $request, $id)
    {
        if ($request->hasFile('checkedFiles')) {
            $checkedFiles = $request->file('checkedFiles');
            $this->storeFiles($checkedFiles, $id);
        }

        return redirect()->back()->with('status', 'Checked Files has been uploaded.');
    }

    public function deleteFiles($member_id)
    {
        $memberfiles = MemberFile::all()->where('member_id', '=', $member_id);

        if ($memberfiles) {
            foreach ($memberfiles as $memberfile) {
                Dropbox::delete($memberfile->path);

                MemberFile::destroy($memberfile->id);
            }
        }
    }

    public function deleteFile($file_id)
    {
        $memberfile = MemberFile::findOrFail($file_id);

        Dropbox::delete($memberfile->path);

        MemberFile::destroy($file_id);

        return redirect()->back()->with('status', 'File has been deleted.');
    }

    public function deleteBookings($member_id)
    {
        $bookings = Booking::all()->where('member_id', '=', $member_id);

        foreach ($bookings as $booking) {
            Booking::destroy($booking->id);
        }
    }

    public function deleteCoachings($member_id)
    {
        $coachings = IndividualCoaching::all()->where('member_id', '=', $member_id);

        foreach ($coachings as $coaching) {
            IndividualCoaching::destroy($coaching->id);
        }
    }

    public function deleteDiscounts($member_id)
    {
        $discounts = MemberDiscount::all()->where('member_id', '=', $member_id);

        foreach ($discounts as $discount) {
            MemberDiscount::destroy($discount->id);
        }
    }

    public function deleteLayouts($member_id)
    {
        $layouts = LayoutPurchase::all()->where('member_id', '=', $member_id);

        foreach ($layouts as $layout) {
            LayoutPurchase::destroy($layout->id);
        }
    }

    public function deletePackages($member_id)
    {
        $packages = PackagePurchase::all()->where('member_id', '=', $member_id);

        foreach ($packages as $package) {
            Dropbox::delete($package->path);

            PackagePurchase::destroy($package->id);
        }
    }

    public function deleteInvoices($member_id)
    {
        $invoices = Invoice::all()->where('member_id', '=', $member_id);

        foreach ($invoices as $invoice) {
            Invoice::destroy($invoice->id);
        }
    }
}
