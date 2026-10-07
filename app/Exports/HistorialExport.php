<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class HistorialExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $historial;

    public function __construct($historial)
    {
        $this->historial = $historial;
    }

    public function collection()
    {
        return $this->historial;
    }

    public function headings(): array
    {
        return [
            'Equipo',
            'N° Económico',
            'Matrícula',
            'MAC',
            'Evento',
            'Estado',
            'Fecha / Hora',
        ];
    }

    public function map($registro): array
    {
        return [
            $registro->equipo ?: 'N/A',
            $registro->numeconomico ?: 'N/A',
            $registro->matricula ?: 'N/A',
            $registro->mac ?: 'N/A',
            ucfirst($registro->evento ?? 'desconocido'),
            ucfirst($registro->estado ?? '-'),
            Carbon::parse($registro->datetime)->format('d/m/Y H:i:s'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1F2937'],
                ],
            ],
        ];
    }
}