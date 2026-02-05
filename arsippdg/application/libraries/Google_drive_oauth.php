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

        $accessToken = json_decode(
            file_get_contents($this->tokenPath),
            true
        );

        $this->client->setAccessToken($accessToken);

        if ($this->client->isAccessTokenExpired()) {
            if ($this->client->getRefreshToken()) {
                $this->client->fetchAccessTokenWithRefreshToken(
                    $this->client->getRefreshToken()
                );
                file_put_contents(
                    $this->tokenPath,
                    json_encode($this->client->getAccessToken())
                );
            } else {
                throw new Exception('Google token expired. Please login again.');
            }
        }

        $this->service = new Drive($this->client);
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
