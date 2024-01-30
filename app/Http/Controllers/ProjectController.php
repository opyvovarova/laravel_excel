<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Imports\ProjectImport;
use App\Http\Requests\Project\ImportStoreRequest;
use App\Jobs\ImportProjectExcelFileJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Bus;


class ProjectController extends Controller
{
    public function index()
    {
        return inertia('Project/Index');
    }

    public function import()
    {
        return inertia('Project/Import');
    }

    public function importStore(ImportStoreRequest $request)
    {
        $data = $request->validated();

        $file = File::putAndCreate($data['file']);

        ImportProjectExcelFileJob::dispatch($file->path)->onQueue('imports');

        return redirect()->back()->with(['message' =>  'Excel import in process']);



    }
}
