<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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

        // Set up Google API credentials (ensure these values are stored in your config or env)
        $this->clientId = env("GOOGLE_DRIVE_CLIENT_ID");
        $this->clientSecret = env("GOOGLE_DRIVE_CLIENT_SECRET");
        $this->refreshToken = env("GOOGLE_DRIVE_REFRESH_TOKEN");
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            // Step 1: Perform the database backup
            $this->backupDatabase();

            // Step 2: Prepare file for uploading to Google Drive
            $sqlFiles = File::glob(storage_path('backups') . "/*.sql");
            if (count($sqlFiles)) {
                $sqlFile = $sqlFiles[0]; // Get the first SQL file
                $fileName = basename($sqlFile);

                // Step 3: Specify the Google Drive folder ID
                $folderId = "1xat6U4zx7Ijy19NtgfjeNYeui9N7iO7K"; // Your Google Drive folder ID

                // Step 4: Upload the file to Google Drive
                $this->info("Uploading $fileName to Google Drive...");
                $response = $this->uploadFileToGoogleDrive($sqlFile, $fileName, $folderId);

                // Log the file path or response
                $this->info('File uploaded successfully: ' . json_encode($response));
            } else {
                $this->error('No SQL backup files found to upload.');
            }
        } catch (Exception $e) {
            // Step 5: Catch and log any errors
            Log::error("DB Backup Error in Drive: " . $e->getMessage());
            $this->error("Error: " . $e->getMessage());
        }
    }

    /**
     * Perform the database backup and store it in the backups folder.
     */
    private function backupDatabase()
    {
        // You can call your existing database_backup logic or implement it here
        $this->info('Backing up the database...');
        database_backup(new \App\Helper\Trait\Helper, false);
        $this->info('Database backup completed.');
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
