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

    /**
     * Prevent state-changing actions from being requested with GET.
     */
    protected function require_post()
    {
        if (strtoupper($this->input->method()) !== 'POST') {
            show_404();
        }
    }

    /**
     * Apply the shared Bootstrap pagination markup used by Sistem Nilai pages.
     */
    protected function initialize_pagination($base_url, $total_rows, $per_page = 10)
    {
        $this->pagination->initialize([
            'base_url' => $base_url,
            'total_rows' => (int) $total_rows,
            'per_page' => (int) $per_page,
            'use_page_numbers' => TRUE,
            'page_query_string' => TRUE,
            'query_string_segment' => 'page',
            'reuse_query_string' => TRUE,
            'full_tag_open' => '<nav aria-label="Pagination"><ul class="pagination pagination-sm justify-content-center mb-0">',
            'full_tag_close' => '</ul></nav>',
            'first_link' => 'Awal',
            'last_link' => 'Akhir',
            'next_link' => '›',
            'prev_link' => '‹',
            'num_tag_open' => '<li class="page-item"><span class="page-link">',
            'num_tag_close' => '</span></li>',
            'cur_tag_open' => '<li class="page-item active"><span class="page-link">',
            'cur_tag_close' => '</span></li>',
            'next_tag_open' => '<li class="page-item"><span class="page-link">',
            'next_tag_close' => '</span></li>',
            'prev_tag_open' => '<li class="page-item"><span class="page-link">',
            'prev_tag_close' => '</span></li>',
            'first_tag_open' => '<li class="page-item"><span class="page-link">',
            'first_tag_close' => '</span></li>',
            'last_tag_open' => '<li class="page-item"><span class="page-link">',
            'last_tag_close' => '</span></li>'
        ]);
    }
}
