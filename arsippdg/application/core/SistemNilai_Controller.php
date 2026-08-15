<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Base controller for every Sistem Nilai module.
 * Keeps authorization and the module layout in one place.
 */
class SistemNilai_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        require_role('sistem_nilai');
    }

    protected function render($view, array $data = [])
    {
        $this->load->view('sistem_nilai/layouts/header', $data);
        $this->load->view('sistem_nilai/' . $view, $data);
        $this->load->view('sistem_nilai/layouts/footer');
    }

    protected function render_empty_page($title, $section, $icon)
    {
        $this->render('empty_page', [
            'title' => $title . ' - Sistem Nilai',
            'page_title' => $title,
            'section' => $section,
            'icon' => $icon
        ]);
    }
}
