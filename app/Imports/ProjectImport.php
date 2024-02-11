<?php

namespace App\Imports;

use App\Factory\ProjectFactory;
use App\Models\Project;
use App\Models\Type;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Date as DateTimeExcelDate;
use PhpOffice\PhpSpreadsheet\Shared\Date;


class ProjectImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {


        $typesMap = $this->getTypesMap(Type::all());

        foreach($collection as $row) {


            if(!isset($row['naimenovanie'])) continue;

            $projectFactory = ProjectFactory::make($typesMap, $row);

            Project::updateOrCreate([
                'type_id' => $projectFactory->getValues()['type_id'],
                'title' => $projectFactory->getValues()['title'],
                'created_at_time' => $projectFactory->getValues()['created_at_time'],
                'contracted_at' => $projectFactory->getValues()['contracted_at'],
            ], $projectFactory->getValues());

        }


    }

    private function getTypesMap($types)
    {
        $map = [];

        foreach($types as $type) {
            $map[$type->title] = $type->id;
        }

        return $map;
    }


}
