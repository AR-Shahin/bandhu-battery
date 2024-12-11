<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use App\Helper\File\File as FileFile;
use Illuminate\Support\Facades\Storage;
use Yaza\LaravelGoogleDriveStorage\Gdrive;

class DBBackupInDrive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db_backup_in_drive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Back up the database and upload the SQL file to a specific Google Drive folder';

    /**
     * Google API credentials.
     */
    protected $clientId;
    protected $clientSecret;
    protected $refreshToken;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {

            $path = $this->backupDatabase();
            Log::info("DB Backup End.......");
            $this->info('Database backup completed.');
            $file = file_get_contents($path);
            Gdrive::deleteDir('shop');
            Log::info("Backup directory delete");
            Gdrive::makeDir('shop');
            Storage::disk("google")->put("shop/backup.sql",$file);

            Log::info("DB Backup in Drive.......");

        } catch (Exception $e) {
            Log::error("DB Backup Error in Drive: " . $e->getMessage());
            $this->error("Error: " . $e->getMessage());
        }
    }

    /**
     * Perform the database backup and store it in the backups folder.
     */
    private function backupDatabase()
    {
        $this->info('Backing up the database...');
        Log::info("DB Backup Start.......");
        return database_backup(new \App\Helper\Trait\Helper, false);
    }

    /**
     * Get an access token from Google using the refresh token.
     */
    private function getAccessToken()
    {
        //dd($this->clientId,$this->clientSecret,$this->refreshToken);
        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'refresh_token' => $this->refreshToken,
            'grant_type' => 'refresh_token',
        ]);

        if ($response->failed()) {
            throw new Exception('Failed to retrieve access token: ' . $response->body());
        }

        return $response->json()['access_token'] ?? null;
    }

    /**
     * Upload a file to Google Drive in a specific folder.
     *
     * @param string $filePath Full path to the SQL file
     * @param string $fileName Name of the file to upload
     * @param string $folderId Google Drive folder ID where the file will be uploaded
     * @return array|false
     */
    private function uploadFileToGoogleDrive($filePath, $fileName, $folderId)
    {
        $accessToken = $this->getAccessToken();
        dd($accessToken);
        if (!$accessToken) {
            throw new Exception('Unable to retrieve access token.');
        }

        // Prepare file metadata and content
        $metadata = [
            'name' => $fileName,
            'parents' => [$folderId], // Specify the folder ID where the file will be uploaded
        ];

        $fileContent = file_get_contents($filePath);

        // Make a multipart request to upload the file
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'multipart/related; boundary=foo_bar_baz',
        ])->post('https://www.googleapis.com/upload/drive/v3/files?uploadType=multipart', [
            '--foo_bar_baz',
            'Content-Type: application/json; charset=UTF-8',
            json_encode($metadata),
            '--foo_bar_baz',
            'Content-Type: application/sql', // Change MIME type if needed for SQL files
            $fileContent,
            '--foo_bar_baz--',
        ]);

        if ($response->failed()) {
            throw new Exception('Failed to upload file to Google Drive: ' . $response->body());
        }

        return $response->json();
    }
}
