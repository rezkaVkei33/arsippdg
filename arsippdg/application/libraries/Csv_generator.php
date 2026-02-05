<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Csv_generator {

    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    public function download($filename, $headers, $data)
    {
        try {
            // Set headers for CSV download
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename="' . $filename . '.csv"');
            header('Cache-Control: max-age=0');
            header('Pragma: public');
            header('Expires: 0');

            // Clear any output buffer
            if (ob_get_contents()) {
                ob_end_clean();
            }

            // Open output stream
            $output = fopen('php://output', 'w');

            // Add BOM for Excel to recognize UTF-8
            fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

            // Write headers
            fputcsv($output, $headers, ';', '"');

            // Write data rows
            foreach ($data as $row) {
                fputcsv($output, $row, ';', '"');
            }

            fclose($output);
            exit;
        } catch (Exception $e) {
            log_message('error', 'CSV_generator download Error: ' . $e->getMessage());
            throw new Exception('Gagal download CSV: ' . $e->getMessage());
        }
    }

    public function save($filepath, $headers, $data)
    {
        try {
            $handle = fopen($filepath, 'w');

            // Add BOM for Excel to recognize UTF-8
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            // Write headers
            fputcsv($handle, $headers, ';', '"');

            // Write data
            foreach ($data as $row) {
                fputcsv($handle, $row, ';', '"');
            }

            fclose($handle);
        } catch (Exception $e) {
            log_message('error', 'CSV_generator save Error: ' . $e->getMessage());
            throw new Exception('Gagal save CSV: ' . $e->getMessage());
        }
    }
}
