<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    protected $quarded = false;
    protected $table = 'files';
    protected $fillable = [
        'path',
        'mime_type',
        'title',
    ];

    public static function putAndCreate($dataFile)
    {
        $path = Storage::disk('public')->put('files/', $dataFile);
        return File::create([
            'path' => $path,
            'mime_type' => $dataFile->getClientOriginalExtension(),
            'title' => $dataFile->getClientOriginalName(),
        ]);
    }

    public function setType($type)
    {
        $this->update(['mime_type' => $type]);
    }
}
