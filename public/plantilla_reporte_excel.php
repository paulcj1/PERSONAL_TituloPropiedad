<?php

require_once("../public/PhpSpreadsheet/vendor/autoload.php");

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ExcelReport
{
    protected $spreadsheet;
    protected $sheet;
    protected $row;
    protected $columnCount;
    protected $headers;

    public function __construct()
    {
        $this->spreadsheet = new Spreadsheet();
        $this->sheet = $this->spreadsheet->getActiveSheet();
        $this->row = 1;
        $this->columnCount = 0;
        $this->headers = [];
    }

    public function setTitle($title)
    {
        $this->sheet->setCellValue('A1', $title);
        $this->sheet->mergeCells('A1:X1'); // Ajusta según la cantidad de columnas

        $this->sheet->getStyle('A1')->getFont()->setSize(20)->setBold(true);
        $this->sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $this->sheet->getStyle('A1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $this->sheet->getStyle('A1')->getFill()->setFillType(Fill::FILL_SOLID)
                                             ->getStartColor()->setARGB('B0E0E6');

        $this->sheet->getStyle('A1:X1')->getBorders()->getTop()->setBorderStyle(Border::BORDER_THICK);
        $this->sheet->getStyle('A1:X1')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THICK);
        $this->sheet->getStyle('A1:X1')->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THICK);
        $this->sheet->getStyle('A1:X1')->getBorders()->getRight()->setBorderStyle(Border::BORDER_THICK);

        for ($col = 'A'; $col <= 'X'; $col++) {
            $this->sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $this->sheet->getRowDimension(1)->setRowHeight(40);

        $this->row = 2;
    }

    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
        $this->columnCount = count($headers);

        $col = 'A';
        foreach ($headers as $header) {
            $this->sheet->setCellValue($col . $this->row, $header);
            $col++;
        }

        $headerRange = 'A' . $this->row . ':' . Coordinate::stringFromColumnIndex($this->columnCount) . $this->row;
        $this->sheet->getStyle($headerRange)->getFont()->setBold(true);
        $this->sheet->getStyle($headerRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $this->sheet->getStyle($headerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $this->sheet->getStyle($headerRange)->getFill()->setFillType(Fill::FILL_SOLID)
                                                    ->getStartColor()->setARGB('D3D3D3');

        for ($col = 'A', $i = 1; $i <= $this->columnCount; $i++, $col++) {
            $this->sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $this->row++;
    }

    private function setCheckCellStyle()
    {
        $rowRange = 'A' . $this->row . ':' . Coordinate::stringFromColumnIndex($this->columnCount) . $this->row;
        $this->sheet->getStyle($rowRange)->getFill()->setFillType(Fill::FILL_SOLID)
                                                   ->getStartColor()->setARGB('C0C0C0');
        $this->sheet->getStyle($rowRange)->getFont()->getColor()->setARGB('FFFFFF');
        $this->sheet->getStyle($rowRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $this->sheet->getStyle($rowRange)->getBorders()->getAllBorders()->getColor()->setARGB('FFFFFF');
    }

    private function setOutputCellStyle()
    {
        $rowRange = 'A' . $this->row . ':' . Coordinate::stringFromColumnIndex($this->columnCount) . $this->row;
        $this->sheet->getStyle($rowRange)->getFill()->setFillType(Fill::FILL_SOLID)
                                                   ->getStartColor()->setARGB('C0C0C0');
        $this->sheet->getStyle($rowRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $this->sheet->getStyle($rowRange)->getBorders()->getAllBorders()->getColor()->setARGB('FFFFFF');
    }

    public function addRow(array $row)
    {
        $col = 'A';
        foreach ($row as $value) {
            $this->sheet->setCellValue($col . $this->row, $value);
            $col++;
        }

        $rowRange = 'A' . $this->row . ':' . Coordinate::stringFromColumnIndex($this->columnCount) . $this->row;
        $this->sheet->getStyle($rowRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        $this->row++;
    }

    public function download($filename)
    {
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($this->spreadsheet);
        $writer->save('php://output');

        exit;
    }
}
?>
