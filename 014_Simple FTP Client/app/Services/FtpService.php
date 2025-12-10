<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
use League\Flysystem\Ftp\FtpAdapter;
use League\Flysystem\Ftp\FtpConnectionOptions;

class FtpService
{
    private $connection = null;

    public function connect($host, $username, $password, $port = 21, $ssl = false, $timeout = 30)
    {
        try {
            $adapter = new FtpAdapter(
                FtpConnectionOptions::fromArray([
                    'host' => $host,
                    'username' => $username,
                    'password' => $password,
                    'port' => $port,
                    'ssl' => $ssl,
                    'root' => '/',
                    'timeout' => $timeout,
                    'utf8' => true,
                ])
            );

            $this->connection = new Filesystem($adapter);
            return true;
        } catch (\Exception $e) {
            throw new \Exception("Connection failed: " . $e->getMessage());
        }
    }

    public function disconnect()
    {
        $this->connection = null;
    }

    public function listContents($directory = '/')
    {
        if (!$this->connection) {
            throw new \Exception("Not connected to FTP server");
        }

        return $this->connection->listContents($directory)->toArray();
    }

    public function isConnected()
    {
        return $this->connection !== null;
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function uploadFile($localPath, $remotePath)
    {
        if (!$this->connection) {
            throw new \Exception("Not connected to FTP server");
        }

        $stream = fopen($localPath, 'r+');
        $this->connection->writeStream($remotePath, $stream);
        fclose($stream);
    }

    public function downloadFile($remotePath, $localPath)
    {
        if (!$this->connection) {
            throw new \Exception("Not connected to FTP server");
        }

        $stream = $this->connection->readStream($remotePath);
        file_put_contents($localPath, stream_get_contents($stream));
        fclose($stream);
    }

    public function deleteFile($remotePath)
    {
        if (!$this->connection) {
            throw new \Exception("Not connected to FTP server");
        }

        $this->connection->delete($remotePath);
    }

    public function createDirectory($path)
    {
        if (!$this->connection) {
            throw new \Exception("Not connected to FTP server");
        }

        $this->connection->createDirectory($path);
    }

    public function getFileSize($path)
    {
        if (!$this->connection) {
            throw new \Exception("Not connected to FTP server");
        }

        return $this->connection->fileSize($path);
    }
}