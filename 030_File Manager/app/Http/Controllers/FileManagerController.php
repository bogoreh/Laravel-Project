<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FileManagerController extends Controller
{
    protected $path = 'files'; // storage/app/public/files

    public function index(Request $request)
    {
        $currentPath = $request->query('path', '');
        $fullPath = $this->path . ($currentPath ? '/' . $currentPath : '');

        $directories = Storage::disk('public')->directories($fullPath);
        $files = Storage::disk('public')->files($fullPath);

        return view('filemanager.index', compact('directories', 'files', 'currentPath'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // max 10MB
        ]);

        $path = $request->input('path', '');
        $fullPath = $this->path . ($path ? '/' . $path : '');

        $file = $request->file('file');
        $file->storeAs($fullPath, $file->getClientOriginalName(), 'public');

        return redirect()->route('filemanager.index', ['path' => $path])
            ->with('success', 'File uploaded successfully!');
    }

    public function createFolder(Request $request)
    {
        $request->validate([
            'folder_name' => 'required|string|max:255',
        ]);

        $path = $request->input('path', '');
        $fullPath = $this->path . ($path ? '/' . $path : '');

        $folderName = $request->folder_name;
        Storage::disk('public')->makeDirectory($fullPath . '/' . $folderName);

        return redirect()->route('filemanager.index', ['path' => $path])
            ->with('success', 'Folder created successfully!');
    }

    public function download($file)
    {
        $path = request()->query('path', '');
        $fullPath = $this->path . ($path ? '/' . $path . '/' . $file : '/' . $file);

        if (!Storage::disk('public')->exists($fullPath)) {
            abort(404);
        }

        return Storage::disk('public')->download($fullPath);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'path' => 'required|string',
            'name' => 'required|string',
            'type' => 'required|in:file,folder',
        ]);

        $basePath = $this->path . ($request->path ? '/' . $request->path : '');
        $target = $basePath . '/' . $request->name;

        if ($request->type === 'folder') {
            Storage::disk('public')->deleteDirectory($target);
        } else {
            Storage::disk('public')->delete($target);
        }

        return redirect()->route('filemanager.index', ['path' => $request->path])
            ->with('success', ucfirst($request->type) . ' deleted successfully!');
    }
}