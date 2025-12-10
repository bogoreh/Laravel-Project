<?php

namespace App\Http\Controllers;

use App\Services\FtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FtpController extends Controller
{
    protected $ftpService;

    public function __construct(FtpService $ftpService)
    {
        $this->ftpService = $ftpService;
    }

    public function index()
    {
        return view('ftp.index');
    }

    public function connect(Request $request)
    {
        $request->validate([
            'host' => 'required',
            'username' => 'required',
            'password' => 'required',
            'port' => 'numeric|min:1|max:65535',
        ]);

        try {
            $this->ftpService->connect(
                $request->host,
                $request->username,
                $request->password,
                $request->port ?? 21,
                $request->has('ssl'),
                $request->timeout ?? 30
            );

            Session::put('ftp_connected', true);
            Session::put('ftp_host', $request->host);

            return redirect()->route('ftp.files')->with('success', 'Connected successfully!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function disconnect()
    {
        $this->ftpService->disconnect();
        Session::forget(['ftp_connected', 'ftp_host']);
        return redirect()->route('ftp.index')->with('success', 'Disconnected successfully!');
    }

    public function listFiles(Request $request)
    {
        if (!Session::get('ftp_connected')) {
            return redirect()->route('ftp.index')->with('error', 'Please connect to FTP server first');
        }

        try {
            $path = $request->get('path', '/');
            $files = $this->ftpService->listContents($path);
            
            return view('ftp.files', [
                'files' => $files,
                'currentPath' => $path,
                'host' => Session::get('ftp_host')
            ]);
        } catch (\Exception $e) {
            return redirect()->route('ftp.index')->with('error', $e->getMessage());
        }
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
            'path' => 'required'
        ]);

        try {
            $file = $request->file('file');
            $remotePath = $request->path . '/' . $file->getClientOriginalName();
            
            $this->ftpService->uploadFile($file->getRealPath(), $remotePath);
            
            return back()->with('success', 'File uploaded successfully!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function download(Request $request)
    {
        $request->validate([
            'remote_path' => 'required',
            'local_path' => 'required'
        ]);

        try {
            $this->ftpService->downloadFile(
                $request->remote_path,
                $request->local_path
            );
            
            return back()->with('success', 'File downloaded successfully!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function delete(Request $request)
    {
        $request->validate(['path' => 'required']);

        try {
            $this->ftpService->deleteFile($request->path);
            return back()->with('success', 'File deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function createFolder(Request $request)
    {
        $request->validate(['folder_name' => 'required']);

        try {
            $path = $request->current_path . '/' . $request->folder_name;
            $this->ftpService->createDirectory($path);
            return back()->with('success', 'Folder created successfully!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}