<?php

namespace App\Http\Controllers\Backend;

use App\Seminar;
use App\Seminarfile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Requests;

class SeminarsController extends Controller
{
    protected $seminars;

    public function __construct(Seminar $seminars)
    {
        $this->seminars = $seminars;

        parent::__construct();
    }

    public function index()
    {
        $seminars = Seminar::paginate(10);

        return view('backend.seminars.index', compact('seminars'));
    }

    public function create(Seminar $seminar)
    {
        $files = null;

        return view('backend.seminars.form', compact('seminar', 'files'));
    }

    public function store(Requests\StoreSeminarRequest $request)
    {
        $seminar = Seminar::create(array(
            'title' => $request->title,
            'description' => $request->description,
            'services' => $request->services,
            'maxMembers' => $request->maxMembers,
            'duration' => $request->duration,
            'price' => $request->price
        ));

        if ($request->hasFile('files')) {
            $files = $request->file('files');
            $this->storeFiles($files, $seminar->id);

        }

        return redirect(route('seminars.index'))->with('status', 'Seminar has been created.');
    }

    public function edit($id)
    {
        $seminar = Seminar::findOrFail($id);

        $files = Seminarfile::where('seminar_id', '=', $seminar->id)->pluck('name', 'id')->toArray();

        return view('backend.seminars.form', compact('seminar', 'files'));
    }

    public function update(Requests\UpdateSeminarRequest $request, $id)
    {
        $seminar = Seminar::findOrFail($id);

        $seminar->fill(array(
            'title' => $request->title,
            'description' => $request->description,
            'services' => $request->services,
            'maxMembers' => $request->maxMembers,
            'duration' => $request->duration,
            'price' => $request->price
        ))->save();

        if ($request->hasFile('files')) {
            $files = $request->file('files');
            $this->storeFiles($files, $seminar->id);
        }

        return redirect(route('seminars.index'))->with('status', 'Seminar has been updated.');
    }

    public function confirm($id)
    {
        $seminar = Seminar::findOrFail($id);

        return view('backend.seminars.confirm', compact('seminar'));
    }

    public function destroy($id)
    {
        Seminar::destroy($id);

        $this->deleteFiles($id);

        return redirect(route('seminars.index'))->with('status', 'Seminar has been deleted.');
    }

    public function storeFiles($files, $seminar_id)
    {
        foreach ($files as $file) {
            $fileName = $file->getClientOriginalName();
            $fileType = $file->getClientMimeType();
            $destinationPath = config('app.fileDestinationPath') . '/seminars/' . $seminar_id . '/' . $fileName;
            $uploaded = Storage::put($destinationPath, file_get_contents($file->getRealPath()));

            if ($uploaded) {
                $seminarfile = Seminarfile::where('path', '=', $destinationPath)->first();

                if (!$seminarfile) {
                    Seminarfile::create(array(
                        'name' => $fileName,
                        'path' => $destinationPath,
                        'type' => $fileType,
                        'size' => filesize($file),
                        'seminar_id' => $seminar_id
                    ));
                }
            }
        }
    }

    public function deleteFiles($seminar_id)
    {
        $seminarfiles = Seminarfile::all()->where('seminar_id', '=', $seminar_id);

        foreach ($seminarfiles as $seminarfile) {
            Seminarfile::destroy($seminarfile->id);
            Storage::delete($seminarfile->path);
        }
    }

    public function deleteFile($file_id)
    {
        $seminarfile = Seminarfile::whereId($file_id)->first();
        Seminarfile::destroy($file_id);
        Storage::delete($seminarfile->path);

        return redirect()->back()->with('status', 'File has been deleted.');
    }
}
