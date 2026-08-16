<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Nilai_excel
{
    private $headers = ['nim', 'nama', 'nilai_angka', 'nilai_huruf', 'bobot'];

    public function __construct()
    {
        $manualAutoload = APPPATH . 'third_party/phpoffice/autoload.php';
        if (file_exists($manualAutoload)) {
            require_once $manualAutoload;
        } else {
            require_once FCPATH . 'vendor/autoload.php';
        }
    }

    public function download_template($students = [])
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Nilai');

        $headerRow = ['NIM', 'Nama Mahasiswa', 'Nilai Angka', 'Nilai Huruf', 'Bobot'];
        $sheet->fromArray($headerRow, NULL, 'A1');
        $sheet->getStyle('A1:E1')->getFont()->setBold(TRUE)->getColor()->setARGB('FFFFFFFF');
        $sheet->getStyle('A1:E1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF198754');

        $row = 2;
        foreach ($students as $student) {
            $sheet->setCellValue('A' . $row, $student->nim);
            $sheet->setCellValue('B' . $row, $student->nama);
            $sheet->setCellValue('C' . $row, '');
            $sheet->setCellValue('D' . $row, '');
            $sheet->setCellValue('E' . $row, '');
            $row++;
        }

        $sheet->freezePane('A2');
        $sheet->getStyle('A:A')->getNumberFormat()->setFormatCode('@');
        foreach (['A' => 20, 'B' => 30, 'C' => 18, 'D' => 15, 'E' => 15] as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        while (ob_get_level() > 0) { ob_end_clean(); }
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="template_upload_nilai.xlsx"');
        header('Cache-Control: max-age=0');
        (new Xlsx($spreadsheet))->save('php://output');
        exit;
    }

    public function read($file_path)
    {
        $spreadsheet = IOFactory::load($file_path);
        $sheet = $spreadsheet->getActiveSheet();
        $headers = [];
        foreach (range('A', 'E') as $column) {
            $headers[] = strtolower(trim((string) $sheet->getCell($column . '1')->getFormattedValue()));
        }

        $expected = ['nim', 'nama mahasiswa', 'nilai angka', 'nilai huruf', 'bobot'];
        if ($headers !== $expected) {
            return ['rows' => [], 'error' => 'Format kolom tidak sesuai template. Kolom yang benar: NIM, Nama Mahasiswa, Nilai Angka, Nilai Huruf, Bobot.'];
        }

        $rows = [];
        for ($row = 2; $row <= $sheet->getHighestDataRow(); $row++) {
            $values = [];
            foreach (range('A', 'E') as $column) {
                $values[] = trim((string) $sheet->getCell($column . $row)->getFormattedValue());
            }

            if (implode('', $values) !== '') {
                $rows[$row] = [
                    'nim' => $values[0],
                    'nama' => $values[1],
                    'nilai_angka' => $values[2],
                    'nilai_huruf' => $values[3],
                    'bobot' => $values[4],
                ];
            }
        }

        return ['rows' => $rows, 'error' => NULL];
    }
}
