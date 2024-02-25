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


class ProjectImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnFailure
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


    public function rules(): array
    {
        return [
            'tip' => 'required|string',
            'naimenovanie' => 'required|string',
            'data_sozdaniia'=> 'required|integer',
            'podpisanie_dogovora' => 'required|integer',
            'dedlain' => 'nullable|integer',
            'setevik' => 'nullable|string',
            'sdaca_v_srok' => 'nullable|string',
            'nalicie_autsorsinga' => 'nullable|string',
            'nalicie_investorov' => 'nullable|string',
            'kolicestvo_ucastnikov' => 'nullable|integer',
            'kolicestvo_uslug' => 'nullable|integer',
            'vlozenie_v_pervyi_etap' => 'nullable|integer',
            'vlozenie_vo_vtoroi_etap' => 'nullable|integer',
            'vlozenie_v_tretii_etap' => 'nullable|integer',
            'vlozenie_v_cetvertyi_etap' => 'nullable|integer',
            'kommentarii' => 'nullable|string',
            'znacenie_effektivnosti' => 'nullable|numeric',
        ];
    }

    public function onFailure(Failure ...$failures)
    {
        $map = [];
        foreach($failures as $failure) {
            foreach($failure->errors() as $error) {
                $map[] = [
                    'key' => $this->attributesMap()[$failure->attribute()],
                    'row' => $failure->row(),
                    'message' => $error,
                    'task_id' => $this->task->id
                ];
            }

        }
    }




}
