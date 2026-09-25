<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class IngresoExport implements FromCollection, WithHeadings, WithMapping
{
    protected $registros;

    public function __construct($registros)
    {
        $this->registros = $registros;
    }

    public function collection()
    {
        return $this->registros;
    }

    public function headings(): array
    {
        return [
            'Equipo',
            'Núm. Económico',
            'Matrícula',
            'MAC',
            'Fecha / Hora',
            'Estado',
            'Latitud',
            'Longitud',
        ];
    }

    public function map($row): array
    {
        return [
            $row->equipo ?: $row->numeconomico,
            $row->numeconomico,
            $row->matricula,
            $row->mac,
            $row->datetime,
            $row->estado,
            $row->latitud,
            $row->longitud,
        ];
    }
}