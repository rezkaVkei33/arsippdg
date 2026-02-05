<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Simple Excel Generator
 * Membuat file Excel .xlsx dengan struktur manual
 * Tidak bergantung pada external library
 */
class Excel_simple {

    protected $CI;
    protected $rows = [];
    protected $headers = [];

    public function __construct()
    {
        if (function_exists('get_instance')) {
            $this->CI =& get_instance();
        }
    }

    public function set_headers($headers)
    {
        $this->headers = $headers;
        return $this;
    }

    public function add_row($row)
    {
        $this->rows[] = $row;
        return $this;
    }

    public function add_rows($rows)
    {
        foreach ($rows as $row) {
            $this->rows[] = $row;
        }
        return $this;
    }

    /**
     * Download as XLSX file (using archive approach)
     */
    public function download_xlsx($filename)
    {
        // Generate XML content
        $xml = $this->generate_spreadsheet_xml();
        
        // Create ZIP archive
        $zip = new ZipArchive();
        $temp_file = sys_get_temp_dir() . '/' . uniqid('excel_') . '.xlsx';
        
        if ($zip->open($temp_file, ZipArchive::CREATE) !== TRUE) {
            throw new Exception('Tidak dapat membuat file Excel');
        }

        try {
            // Add required files for XLSX
            $zip->addFromString('[Content_Types].xml', $this->get_content_types_xml());
            $zip->addFromString('_rels/.rels', $this->get_rels_xml());
            $zip->addFromString('xl/_rels/workbook.xml.rels', $this->get_workbook_rels_xml());
            $zip->addFromString('xl/workbook.xml', $this->get_workbook_xml());
            $zip->addFromString('xl/worksheets/sheet1.xml', $xml);
            $zip->addFromString('xl/styles.xml', $this->get_styles_xml());
            $zip->addFromString('docProps/core.xml', $this->get_core_xml());
            $zip->addFromString('docProps/app.xml', $this->get_app_xml());
            
            $zip->close();

            // Download file
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            header('Pragma: public');
            header('Expires: 0');

            if (ob_get_contents()) {
                ob_end_clean();
            }

            readfile($temp_file);
            @unlink($temp_file);
            exit;
        } catch (Exception $e) {
            @unlink($temp_file);
            throw $e;
        }
    }

    /**
     * Download as CSV file (simpler alternative)
     */
    public function download_csv($filename)
    {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '.csv"');
        header('Cache-Control: max-age=0');
        header('Pragma: public');
        header('Expires: 0');

        if (ob_get_contents()) {
            ob_end_clean();
        }

        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM

        if (!empty($this->headers)) {
            fputcsv($output, $this->headers, ';');
        }

        foreach ($this->rows as $row) {
            fputcsv($output, $row, ';');
        }

        fclose($output);
        exit;
    }

    private function generate_spreadsheet_xml()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' . "\n";
        $xml .= '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">' . "\n";
        $xml .= '<sheetData>' . "\n";

        $row_num = 1;

        // Add headers
        if (!empty($this->headers)) {
            $xml .= '<row r="' . $row_num . '">' . "\n";
            foreach ($this->headers as $col_num => $header) {
                $col_letter = $this->num2col($col_num + 1);
                $xml .= '<c r="' . $col_letter . '1" t="inlineStr" s="1">';
                $xml .= '<is><t>' . htmlspecialchars($header) . '</t></is>';
                $xml .= '</c>' . "\n";
            }
            $xml .= '</row>' . "\n";
            $row_num++;
        }

        // Add data rows
        foreach ($this->rows as $row_data) {
            $xml .= '<row r="' . $row_num . '">' . "\n";
            foreach ($row_data as $col_num => $value) {
                $col_letter = $this->num2col($col_num + 1);
                $xml .= '<c r="' . $col_letter . $row_num . '" t="inlineStr">';
                $xml .= '<is><t>' . htmlspecialchars($value) . '</t></is>';
                $xml .= '</c>' . "\n";
            }
            $xml .= '</row>' . "\n";
            $row_num++;
        }

        $xml .= '</sheetData>' . "\n";
        $xml .= '</worksheet>';

        return $xml;
    }

    private function num2col($num)
    {
        $numeric = ($num - 1) % 26;
        $letter = chr(65 + $numeric);
        $num = intdiv($num - 1, 26);
        if ($num > 0) {
            return $this->num2col($num) . $letter;
        } else {
            return $letter;
        }
    }

    private function get_content_types_xml()
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' . "\n" .
               '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">' .
               '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>' .
               '<Default Extension="xml" ContentType="application/xml"/>' .
               '<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>' .
               '<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>' .
               '<Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>' .
               '<Override PartName="/docProps/core.xml" ContentType="application/vnd.openxmlformats-package.core-properties+xml"/>' .
               '<Override PartName="/docProps/app.xml" ContentType="application/vnd.openxmlformats-officedocument.custom-properties+xml"/>' .
               '</Types>';
    }

    private function get_rels_xml()
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' . "\n" .
               '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">' .
               '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>' .
               '<Relationship Id="rId2" Type="http://schemas.openxmlformats.org/package/2006/relationships/metadata/core-properties" Target="docProps/core.xml"/>' .
               '<Relationship Id="rId3" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/extended-properties" Target="docProps/app.xml"/>' .
               '</Relationships>';
    }

    private function get_workbook_rels_xml()
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' . "\n" .
               '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">' .
               '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>' .
               '<Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>' .
               '</Relationships>';
    }

    private function get_workbook_xml()
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' . "\n" .
               '<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">' .
               '<sheets><sheet name="Sheet1" sheetId="1" r:id="rId1"/></sheets>' .
               '</workbook>';
    }

    private function get_styles_xml()
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' . "\n" .
               '<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">' .
               '<fonts><font/></fonts>' .
               '<fills><fill><patternFill patternType="none"/></fill><fill><patternFill patternType="gray125"/></fill></fills>' .
               '<borders><border><left/><right/><top/><bottom/><diagonal/></border></borders>' .
               '<cellStyleXfs><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>' .
               '<cellXfs><xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0"/><xf numFmtId="0" fontId="0" fillId="2" borderId="0" xfId="0" applyFill="1"/></cellXfs>' .
               '</styleSheet>';
    }

    private function get_core_xml()
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' . "\n" .
               '<cp:coreProperties xmlns:cp="http://schemas.openxmlformats.org/officeDocument/2006/custom-properties" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:dcterms="http://purl.org/dc/terms/" xmlns:dcmitype="http://purl.org/dc/dcmitype/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">' .
               '<dc:creator>E-Arsip Surat PDG</dc:creator>' .
               '<dcterms:created xsi:type="dcterms:W3CDTF">' . date('Y-m-dTH:i:sZ') . '</dcterms:created>' .
               '</cp:coreProperties>';
    }

    private function get_app_xml()
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' . "\n" .
               '<Properties xmlns="http://schemas.openxmlformats.org/officeDocument/2006/custom-properties" xmlns:vt="http://schemas.openxmlformats.org/officeDocument/2006/docPropsVTypes">' .
               '<TotalTime>1</TotalTime>' .
               '</Properties>';
    }
}
