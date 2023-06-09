<?php

namespace App\Imports;

use App\Models\MaePais;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class PaisesImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError
{
    use Importable, SkipsErrors;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new MaePais([
            'pais' => $row['pais'],
            'codigo_alfa2' => $row['codigo_alfa2'],
            'codigo_alfa3' => $row['codigo_alfa3'],
            'codigo_numerico' => $row['codigo_numerico'],
            'continente' => $row['continente'],
            'activo' => $row['activo'],
        ]);
    }

    public function rules(): array
    {
        return [
            '1' => Rule::in(['patrick@maatwebsite.nl']),

            // Above is alias for as it always validates in batches
            '*.1' => Rule::in(['patrick@maatwebsite.nl']),

            // Can also use callback validation rules
            '0' => function ($attribute, $value, $onFailure) {
                if ($value !== 'Patrick Brouwers') {
                    $onFailure('Name is not Patrick Brouwers');
                }
            }
        ];
    }
}