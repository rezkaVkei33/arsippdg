<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Auth Helper
 * Helper functions untuk authentication
 */

/**
 * Check if user is logged in
 * @return boolean
 */
if (!function_exists('is_logged_in')) {
    function is_logged_in()
    {
        $CI = &get_instance();
        return $CI->session->userdata('logged_in');
    }
}

/**
 * Check if user is admin
 * @return boolean
 */
if (!function_exists('is_admin')) {
    function is_admin()
    {
        $CI = &get_instance();
        return $CI->session->userdata('role') === 'admin';
    }
}

/**
 * Get current user ID
 * @return mixed
 */
if (!function_exists('current_user_id')) {
    function current_user_id()
    {
        $CI = &get_instance();
        return $CI->session->userdata('user_id');
    }
}

/**
 * Get current user data
 * @return object
 */
if (!function_exists('current_user')) {
    function current_user()
    {
        $CI = &get_instance();
        return (object) [
            'id'        => $CI->session->userdata('user_id'),
            'username'  => $CI->session->userdata('username'),
            'email'     => $CI->session->userdata('email'),
            'full_name' => $CI->session->userdata('full_name'),
            'role'      => $CI->session->userdata('role')
        ];
    }
}

/**
 * Get user username
 * @return string
 */
if (!function_exists('current_username')) {
    function current_username()
    {
        $CI = &get_instance();
        return $CI->session->userdata('username');
    }
}

/**
 * Get user full name
 * @return string
 */
if (!function_exists('current_fullname')) {
    function current_fullname()
    {
        $CI = &get_instance();
        return $CI->session->userdata('full_name');
    }
}

/**
 * Redirect to login page if not logged in
 * @return void
 */
if (!function_exists('require_login')) {
    function require_login()
    {
        if (!is_logged_in()) {
            $CI = &get_instance();
            $CI->session->set_flashdata('error', 'Anda harus login terlebih dahulu');
            show_error('Akses Ditolak - Silakan Login Terlebih Dahulu', 403);
        }
    }
}

/**
 * Redirect to login page if not admin
 * @return void
 */
if (!function_exists('require_admin')) {
    function require_admin()
    {
        require_login();
        
        if (!is_admin()) {
            $CI = &get_instance();
            $CI->session->set_flashdata('error', 'Anda tidak memiliki akses');
            redirect('dashboard');
        }
    }
}

/**
 * Hash password
 * @param string $password
 * @return string
 */
if (!function_exists('hash_password')) {
    function hash_password($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}

/**
 * Verify password
 * @param string $password
 * @param string $hash
 * @return boolean
 */
if (!function_exists('verify_password')) {
    function verify_password($password, $hash)
    {
        return password_verify($password, $hash);
    }
}
