<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class IngresoExport implements FromCollection, WithHeadings, WithMapping, WithEvents, WithDrawings, ShouldAutoSize
{
    protected $registros;
    protected $fechaInicio;
    protected $fechaFin;
    protected $tema;

    public function __construct($registros, $fechaInicio, $fechaFin)
    {
        $this->registros   = $registros;
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin    = $fechaFin;

        $theme = getTheme();

        $this->tema = [
            'key'    => $theme['key'],
            'nombre' => $theme['name'],
            'logo'   => public_path($theme['logo']),
            'acento' => $theme['key'] === 'keysecure' ? 'F0A500' : '06B6D4',
        ];
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

    public function drawings()
    {
        if (!file_exists($this->tema['logo'])) {
            return [];
        }

        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setPath($this->tema['logo']);
        $drawing->setHeight(30);
        $drawing->setCoordinates('A1');
        $drawing->setOffsetX(5);
        $drawing->setOffsetY(3);

        return $drawing;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Insertar 4 filas arriba
                $sheet->insertNewRowBefore(1, 4);

                // Títulos en columna B (logo va en A)
                $sheet->setCellValue('B1', $this->tema['nombre']);
                $sheet->setCellValue('B2', 'Reporte de Ingresos');
                $sheet->setCellValue('B3', 'Del ' . $this->fechaInicio . ' al ' . $this->fechaFin);

                // Alturas de las filas del header
                $sheet->getRowDimension(1)->setRowHeight(30);
                $sheet->getRowDimension(2)->setRowHeight(20);
                $sheet->getRowDimension(3)->setRowHeight(20);
                $sheet->getRowDimension(4)->setRowHeight(8);

                // Estilos de los títulos
                $sheet->getStyle('B1')->applyFromArray([
                    'font' => [
                        'bold'  => true,
                        'size'  => 16,
                        'color' => ['rgb' => $this->tema['acento']],
                        'name'  => 'Calibri',
                    ],
                    'alignment' => [
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                $sheet->getStyle('B2')->applyFromArray([
                    'font' => [
                        'bold'  => true,
                        'size'  => 12,
                        'color' => ['rgb' => '333333'],
                    ],
                ]);

                $sheet->getStyle('B3')->applyFromArray([
                    'font' => [
                        'size'   => 10,
                        'italic' => true,
                        'color'  => ['rgb' => '666666'],
                    ],
                ]);

                // Fila de encabezados = 5
                $filaEncabezados = 5;
                $ultimaFila = $filaEncabezados + $this->registros->count();

                // Estilo de encabezados
                $rangoEncabezados = 'A' . $filaEncabezados . ':H' . $filaEncabezados;
                $sheet->getStyle($rangoEncabezados)->applyFromArray([
                    'font' => [
                        'bold'  => true,
                        'color' => ['rgb' => 'FFFFFF'],
                        'size'  => 11,
                    ],
                    'fill' => [
                        'fillType'   => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => $this->tema['acento']],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color'       => ['rgb' => 'FFFFFF'],
                        ],
                    ],
                ]);

                $sheet->getRowDimension($filaEncabezados)->setRowHeight(25);

                // Cuerpo
                if ($this->registros->count() > 0) {
                    $rangoCuerpo = 'A' . ($filaEncabezados + 1) . ':H' . $ultimaFila;
                    $sheet->getStyle($rangoCuerpo)->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color'       => ['rgb' => 'DDDDDD'],
                            ],
                        ],
                        'alignment' => [
                            'vertical' => Alignment::VERTICAL_CENTER,
                        ],
                    ]);

                    // Filas alternadas
                    for ($i = $filaEncabezados + 1; $i <= $ultimaFila; $i++) {
                        if (($i - $filaEncabezados) % 2 === 0) {
                            $sheet->getStyle('A' . $i . ':H' . $i)->applyFromArray([
                                'fill' => [
                                    'fillType'   => Fill::FILL_SOLID,
                                    'startColor' => ['rgb' => 'F9FAFB'],
                                ],
                            ]);
                        }
                    }

                    // Color de columna Estado
                    for ($i = $filaEncabezados + 1; $i <= $ultimaFila; $i++) {
                        $valor = $sheet->getCell('F' . $i)->getValue();
                        $color = '6B7280';
                        if (stripos($valor, 'detect') !== false) {
                            $color = '10B981';
                        } elseif (stripos($valor, 'cerrad') !== false) {
                            $color = 'EF4444';
                        } elseif (stripos($valor, 'abiert') !== false) {
                            $color = 'F59E0B';
                        }

                        $sheet->getStyle('F' . $i)->applyFromArray([
                            'font' => ['color' => ['rgb' => $color], 'bold' => true],
                        ]);
                    }
                }

                // Congelar encabezados
                $sheet->freezePane('A' . ($filaEncabezados + 1));

                // Ancho de la columna A (para el logo)
                $sheet->getColumnDimension('A')->setWidth(14);
            },
        ];
    }
}