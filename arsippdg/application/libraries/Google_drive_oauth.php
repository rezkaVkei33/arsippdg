<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Google\Client;
use Google\Service\Drive;
use Google\Http\MediaFileUpload;

class Google_drive_oauth {

    private $client;
    private $service;
    private $tokenPath;

    public function __construct()
    {
        require_once FCPATH . 'vendor/autoload.php';

        $this->tokenPath = APPPATH . 'drive_token.json';

        if (!file_exists($this->tokenPath)) {
            throw new Exception('Google Drive token not found. Please login first.');
        }

        $this->client = new Client();
        $this->client->setAuthConfig(APPPATH . 'client_secret.json');
        $this->client->setScopes([Drive::DRIVE]);
        $this->client->setAccessType('offline');

        $accessToken = json_decode(file_get_contents($this->tokenPath), true);

        if (!is_array($accessToken) || empty($accessToken['access_token'])) {
            throw new Exception('Google Drive token tidak valid. Silakan hubungkan akun Google sekali lagi.');
        }

        $this->client->setAccessToken($accessToken);

        if ($this->client->isAccessTokenExpired()) {
            $refreshToken = $this->client->getRefreshToken();

            if (empty($refreshToken)) {
                throw new Exception('Google token expired. Please login again.');
            }

            $newToken = $this->client->fetchAccessTokenWithRefreshToken($refreshToken);

            if (isset($newToken['error'])) {
                log_message('error', 'Google Drive token refresh gagal: ' . ($newToken['error_description'] ?? $newToken['error']));
                throw new Exception('Sesi Google Drive tidak dapat diperbarui. Silakan hubungkan akun Google kembali.');
            }

            // Provider OAuth tidak selalu mengirim refresh_token pada respons refresh.
            // Simpan token lama agar refresh berikutnya tetap dapat dilakukan otomatis.
            $newToken = $this->client->getAccessToken();
            $newToken['refresh_token'] = $refreshToken;
            $this->saveToken($newToken);
        }

        $this->service = new Drive($this->client);
    }

    /**
     * Menyimpan token hasil refresh. LOCK_EX mencegah token rusak saat dua
     * request upload/delete berjalan dalam waktu yang bersamaan.
     */
    private function saveToken($token)
    {
        $json = json_encode($token);

        if ($json === false || file_put_contents($this->tokenPath, $json, LOCK_EX) === false) {
            throw new Exception('Gagal menyimpan token Google Drive. Periksa izin tulis file application/drive_token.json.');
        }
    }

    public function upload($filePath, $fileName, $parentId)
    {
        $fileMetadata = new Drive\DriveFile([
            'name' => $fileName,
            'parents' => [$parentId]
        ]);

        $content = file_get_contents($filePath);

        $file = $this->service->files->create(
            $fileMetadata,
            [
                'data' => $content,
                'uploadType' => 'multipart',
                'fields' => 'id, webViewLink, mimeType'
            ]
        );

        return [
            'file_id'    => $file->id,
            'file_url'   => $file->webViewLink,
            'mime_type'  => $file->mime_type
        ];
    }

    public function copy_file($fileId, $fileName, $parentId)
    {
        $fileMetadata = new Drive\DriveFile([
            'name' => $fileName,
            'parents' => [$parentId]
        ]);

        $file = $this->service->files->copy(
            $fileId,
            $fileMetadata,
            [
                'fields' => 'id, webViewLink, mimeType'
            ]
        );

        return [
            'file_id'    => $file->id,
            'file_url'   => $file->webViewLink,
            'mime_type'  => $file->mimeType ?? 'application/pdf'
        ];
    }

    public function delete_file($fileId)
    {
        try {
            $this->service->files->delete($fileId);
            return true;
        } catch (Exception $e) {
            throw new Exception('Gagal menghapus file dari Google Drive: ' . $e->getMessage());
        }
    }
}
