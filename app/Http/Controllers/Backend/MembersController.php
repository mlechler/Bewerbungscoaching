<?php

namespace App\Http\Controllers\Backend;

use App\Member;
use App\Adress;
use App\Memberfile;
use App\Role;
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

    public function deleteAllFiles()
    {
        $date = Carbon::now()->subMonths(3)->format('Y-m-d');
        $files = Memberfile::where('updated_at', '<=', $date)->get();

        foreach ($files as $file) {
            Memberfile::destroy($file->id);
        }
        return redirect(route('members.index'))->with('status', 'Files have been deleted.');
    }

    public function deleteFiles($member_id)
    {
        $memberfiles = Memberfile::all()->where('member_id', '=', $member_id);

        foreach ($memberfiles as $memberfile) {
            Memberfile::destroy($memberfile->id);
            Storage::delete($memberfile->path);
        }
    }

    public function deleteFile($file_id)
    {
        $memberfile = Memberfile::findOrFail($file_id);
        Memberfile::destroy($file_id);
        Storage::delete($memberfile->path);

        return redirect()->back()->with('status', 'File has been deleted.');
    }

    public function uploadCheckedFiles(Request $request, $id)
    {
        if ($request->hasFile('checkedFiles')) {
            $checkedFiles = $request->file('checkedFiles');
            $this->storeFiles($checkedFiles, $id);
        }

        return redirect()->back()->with('status', 'Checked Files has been uploaded.');
    }
}
