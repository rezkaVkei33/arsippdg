<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;

class Pdf_generator {

    protected $dompdf;
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();

        // Require DOMPDF autoloader
        require_once(APPPATH . 'third_party/dompdf/autoload.inc.php');

        // Initialize DOMPDF
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $this->dompdf = new Dompdf($options);
    }

    public function generate($html, $filename, $download = true)
    {
        // Load HTML
        $this->dompdf->loadHtml($html);

        // Set paper size and orientation
        $this->dompdf->setPaper('A4', 'portrait');

        // Render PDF
        $this->dompdf->render();

        if ($download) {
            // Download PDF
            $this->dompdf->stream($filename . '.pdf', ['Attachment' => 1]);
        } else {
            // Return PDF as string
            return $this->dompdf->output();
        }
    }

    public function generate_landscape($html, $filename, $download = true)
    {
        // Load HTML
        $this->dompdf->loadHtml($html);

        // Set paper size and orientation
        $this->dompdf->setPaper('A4', 'landscape');

        // Render PDF
        $this->dompdf->render();

        if ($download) {
            // Download PDF
            $this->dompdf->stream($filename . '.pdf', ['Attachment' => 1]);
        } else {
            // Return PDF as string
            return $this->dompdf->output();
        }
    }
}
