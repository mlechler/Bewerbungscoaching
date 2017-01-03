<?php

namespace App\Http\Controllers\Backend;

use App\Seminar;
use App\Seminarfile;
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

        if ($request->hasFile('file')) {
            $this->storeFile($seminar->id);
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

        if ($request->hasFile('file')) {
            $this->storeFile($seminar->id);
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

        return redirect(route('seminars.index'))->with('status', 'Seminar has been deleted.');
    }

    public function storeFile($seminar_id)
    {
        $fileName = $_FILES['file']['name'];
        $tmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileType = $_FILES['file']['type'];

        $fp = fopen($tmpName, 'r');
        $fileContent = fread($fp, fileSize($tmpName));
        $fileContent = addslashes($fileContent);
        fclose($fp);

        if (!get_magic_quotes_gpc()) {
            $fileName = addslashes($fileName);
        }

        Seminarfile::create(array(
            'name' => $fileName,
            'type' => $fileType,
            'size' => $fileSize,
            'content' => $fileContent,
            'seminar_id' => $seminar_id
        ));
    }
}
