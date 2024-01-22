<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\ImportStoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Backtrace\File;

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
        // dd($data);
        $file = Storage::disk('public')->put('files/', $data['file']);
        File::create([
            'path' => $file,
            'mime_type' => $data['file']->getClientOriginalException(),
            'title' => $data['file']->getClientOriginalName(),
        ]);
    }
}
