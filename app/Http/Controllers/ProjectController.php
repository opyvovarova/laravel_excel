<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\ImportStoreRequest;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        $file = File::putAndCreate( $data['file'] );

    }
}
