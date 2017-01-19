<?php

namespace App\Http\Controllers\Backend;

use App\Booking;
use App\Events\MemberfileUploaded;
use App\Events\UploadMemberFile;
use App\Individualcoaching;
use App\Layoutpurchase;
use App\Member;
use App\Adress;
use App\Memberdiscount;
use App\Memberfile;
use App\Packagepurchase;
use App\Role;
use App\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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

    public function store(Requests\StoreMemberRequest $request)
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

        $member = Member::create(array(
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'birthday' => $request->birthday,
            'phone' => $request->phone,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'adress_id' => $adress->id,
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

    public function update(Requests\UpdateMemberRequest $request, $id)
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

        $member = Member::findOrFail($id);

        $member->fill(array(
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'birthday' => $request->birthday,
            'phone' => $request->phone,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'adress_id' => $adress->id,
            'role_id' => $request->role_id,
            'job' => $request->job,
            'employer' => $request->employer,
            'university' => $request->university,
            'courseofstudies' => $request->courseofstudies,
            'password' => Hash::make($request->password),
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
            $destinationPath = config('app.fileDestinationPath') . '/members/' . $member_id . '/' . $fileName;
            $uploaded = Storage::put($destinationPath, file_get_contents($file->getRealPath()));

            if ($uploaded) {
                $memberfile = Memberfile::where('path', '=', $destinationPath)->first();

                if (!$memberfile) {
                    Memberfile::create(array(
                        'name' => $fileName,
                        'path' => $destinationPath,
                        'type' => $fileType,
                        'size' => filesize($file),
                        'member_id' => $member_id,
                        'checked' => false
                    ));
                } elseif ($memberfile) {
                    $memberfile->fill(array(
                        'name' => $fileName,
                        'path' => $destinationPath,
                        'type' => $fileType,
                        'size' => filesize($file),
                        'member_id' => $member_id,
                        'checked' => true
                    ))->save();
                }
            }
        }
    }

    public function deleteAllFiles(Requests\DeleteAllMemberFilesRequest $request)
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

        $files = Memberfile::where('updated_at', '<=', $date)->get();

        foreach ($files as $file) {
            Memberfile::destroy($file->id);
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
        $memberfiles = Memberfile::all()->where('member_id', '=', $member_id);

        foreach ($memberfiles as $memberfile) {
            Storage::delete($memberfile->path);

            Memberfile::destroy($memberfile->id);
        }
    }

    public function deleteFile($file_id)
    {
        $memberfile = Memberfile::findOrFail($file_id);

        Storage::delete($memberfile->path);

        Memberfile::destroy($file_id);

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
        $coachings = Individualcoaching::all()->where('member_id', '=', $member_id);

        foreach ($coachings as $coaching) {
            Individualcoaching::destroy($coaching->id);
        }
    }

    public function deleteDiscounts($member_id)
    {
        $discounts = Memberdiscount::all()->where('member_id', '=', $member_id);

        foreach ($discounts as $discount) {
            Memberdiscount::destroy($discount->id);
        }
    }

    public function deleteLayouts($member_id)
    {
        $layouts = Layoutpurchase::all()->where('member_id', '=', $member_id);

        foreach ($layouts as $layout) {
            Layoutpurchase::destroy($layout->id);
        }
    }

    public function deletePackages($member_id)
    {
        $packages = Packagepurchase::all()->where('member_id', '=', $member_id);

        foreach ($packages as $package) {
            Storage::delete($package->path);

            Packagepurchase::destroy($package->id);
        }
    }
}
