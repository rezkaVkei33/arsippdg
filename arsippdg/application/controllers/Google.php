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
            Drive::DRIVE
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

        $result = file_put_contents($tokenPath, json_encode($token));

        if ($result === false) {
            show_error('Gagal menulis drive_token.json. Periksa permission folder application/');
        }

        redirect('suratmasuk');
    }

}
