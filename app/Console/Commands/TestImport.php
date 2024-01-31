<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Imports\ProjectImport;
use Maatwebsite\Excel\Facades\Excel;


class TestImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Excel::import(new ProjectImport(), 'files/projects.xlsx', 'public');

        $this->info('Successfully test ');
    }
}
