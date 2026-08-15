<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Mahasiswa_excel
{
    private $headers = ['nim', 'nama', 'jenis_kelamin', 'kode_prodi', 'angkatan', 'status'];

    public function __construct()
    {
        $manualAutoload = APPPATH . 'third_party/phpoffice/autoload.php';
        if (file_exists($manualAutoload)) {
            require_once $manualAutoload;
        } else {
            require_once FCPATH . 'vendor/autoload.php';
        }
    }

    public function download_template()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Mahasiswa');
        $sheet->fromArray($this->headers, NULL, 'A1');
        $sheet->getStyle('A1:F1')->getFont()->setBold(TRUE)->getColor()->setARGB('FFFFFFFF');
        $sheet->getStyle('A1:F1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF198754');
        $sheet->freezePane('A2');
        $sheet->getStyle('A:A')->getNumberFormat()->setFormatCode('@');
        foreach (['A' => 22, 'B' => 35, 'C' => 18, 'D' => 18, 'E' => 14, 'F' => 18] as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        while (ob_get_level() > 0) { ob_end_clean(); }
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="template_upload_mahasiswa.xlsx"');
        header('Cache-Control: max-age=0');
        (new Xlsx($spreadsheet))->save('php://output');
        exit;
    }

    public function read($file_path)
    {
        $spreadsheet = IOFactory::load($file_path);
        $sheet = $spreadsheet->getActiveSheet();
        $headers = [];
        foreach (range('A', 'F') as $column) {
            $headers[] = strtolower(trim((string) $sheet->getCell($column . '1')->getFormattedValue()));
        }

        if ($headers !== $this->headers) {
            return ['rows' => [], 'error' => 'Format kolom tidak sesuai template.'];
        }

        $rows = [];
        for ($row = 2; $row <= $sheet->getHighestDataRow(); $row++) {
            $values = [];
            foreach (range('A', 'F') as $column) {
                $values[] = trim((string) $sheet->getCell($column . $row)->getFormattedValue());
            }
            if (implode('', $values) !== '') {
                $rows[$row] = array_combine($this->headers, $values);
            }
        }

        return ['rows' => $rows, 'error' => NULL];
    }
}
