<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Google\Client;
use Google\Service\Drive;

class Google extends CI_Controller {

    private $client;

    public function __construct()
    {
        parent::__construct();

        require_once FCPATH . 'vendor/autoload.php';

        $this->client = new Client();
        $this->client->setAuthConfig(APPPATH . 'client_secret.json');
        $this->client->setAccessType('offline');
        $this->client->setPrompt('select_account consent');
        $this->client->setScopes([
            // Scope non-sensitive untuk file yang dibuat/dikelola aplikasi.
            Drive::DRIVE_FILE
        ]);
        $this->client->setRedirectUri(
            base_url('google/callback')
        );
    }

    public function login()
    {
        redirect($this->client->createAuthUrl());
    }

    public function callback()
    {
        if (!isset($_GET['code'])) {
            show_error('Authorization code not found');
        }

        $token = $this->client->fetchAccessTokenWithAuthCode($_GET['code']);

        if (isset($token['error'])) {
            show_error($token['error_description']);
        }

        $tokenPath = APPPATH . 'drive_token.json';

        // Google dapat tidak mengembalikan refresh_token pada otorisasi ulang.
        // Jangan hapus refresh token yang masih valid, karena token inilah yang
        // memungkinkan upload, update, dan delete berjalan tanpa login lagi.
        if (empty($token['refresh_token']) && file_exists($tokenPath)) {
            $previousToken = json_decode(file_get_contents($tokenPath), true);
            if (is_array($previousToken) && !empty($previousToken['refresh_token'])) {
                $token['refresh_token'] = $previousToken['refresh_token'];
            }
        }

        $result = file_put_contents($tokenPath, json_encode($token), LOCK_EX);

        if ($result === false) {
            show_error('Gagal menulis drive_token.json. Periksa permission folder application/');
        }

        redirect('suratmasuk');
    }

}
