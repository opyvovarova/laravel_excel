<?php

namespace App\Jobs;

use App\Imports\ProjectImport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ImportProjectExcelFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $path;

    /**
     * Create a new job instance.
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {

        try {
            Log::info('Попытка импорта файла Excel: ' . $this->path);

            \Maatwebsite\Excel\Facades\Excel::import(new ProjectImport(), $this->path, 'public');
            Log::info('Успешный импорт файла Excel');


        } catch (\Maatwebsite\Excel\Exceptions\NoTypeDetectedException $e) {
                        Log::info('Успешный импорт файла Excel');

            Log::error('Ошибка при импорте файла Excel: ' . $e->getMessage());
            throw $e;
        }

    }
}
