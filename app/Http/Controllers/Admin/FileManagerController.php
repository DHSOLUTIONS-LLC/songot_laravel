<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Stem;

class FileManagerController extends Controller
{
    // Get all files organized by folders
    public function index(Request $request)
    {
        try {
            $disk = Storage::disk('public');
            $currentPath = $request->get('path', '');
            
            // Get folders (directories) in current path
            $folders = [];
            $directories = $disk->directories($currentPath);
            
            foreach ($directories as $dir) {
                $dirName = basename($dir);
                $folders[] = [
                    'name' => $dirName,
                    'path' => $dir,
                    'type' => 'folder',
                    'file_count' => count($disk->files($dir)),
                    'modified' => date('Y-m-d H:i:s', $disk->lastModified($dir)),
                ];
            }
            
            // Get files in current path
            $files = [];
            $allFiles = $disk->files($currentPath);
            
            foreach ($allFiles as $file) {
                // Only show audio files
                if (!preg_match('/\.(mp3|wav|ogg)$/i', $file)) {
                    continue;
                }
                
                $fileName = basename($file);
                $fileSize = $disk->size($file);
                $fileModified = $disk->lastModified($file);
                
                $stem = Stem::where('storage_path', $file)->first();
              // Find this section where files array is created
                $files[] = [
                    'name' => $fileName,
                    'path' => $file,
                    'type' => 'file',
                    'size' => $this->formatBytes($fileSize),
                    'modified' => date('Y-m-d H:i:s', $fileModified),
                    'url' => Storage::url($file),  // ← YEH LINE SAHI HAI
                    'full_url' => asset('storage/' . $file),  // ← YEH LINE ADD KARO
                    'stem_id' => $stem ? $stem->id : null,
                    'title' => $stem ? $stem->title : str_replace('.mp3', '', $fileName),
                    'artist' => $stem ? $stem->artist : $this->extractArtistFromPath($file),
                ];
            }
            
            // Sort folders first, then files
            $items = array_merge($folders, $files);
            
            return response()->json([
                'success' => true,
                'items' => $items,
                'current_path' => $currentPath,
                'parent_path' => $this->getParentPath($currentPath),
                'total_folders' => count($folders),
                'total_files' => count($files),
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    // Create new folder
    public function createFolder(Request $request)
    {
        $request->validate([
            'folder_name' => 'required|string|max:100|regex:/^[a-zA-Z0-9\s\-_]+$/',
            'path' => 'nullable|string'
        ]);
        
        $disk = Storage::disk('public');
        $newPath = trim($request->path . '/' . $request->folder_name, '/');
        
        if (!$disk->exists($newPath)) {
            $disk->makeDirectory($newPath);
            return response()->json([
                'success' => true,
                'message' => 'Folder created successfully',
                'path' => $newPath
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Folder already exists'
        ], 400);
    }
    
    // Delete folder (and all contents)
    public function deleteFolder(Request $request)
    {
        $request->validate([
            'path' => 'required|string'
        ]);
        
        $disk = Storage::disk('public');
        
        if ($disk->exists($request->path)) {
            // Delete all files in folder from stems table
            $files = $disk->files($request->path);
            foreach ($files as $file) {
                $stem = Stem::where('storage_path', $file)->first();
                if ($stem) {
                    $stem->delete();
                }
            }
            
            // Delete folder and all contents
            $disk->deleteDirectory($request->path);
            
            return response()->json([
                'success' => true,
                'message' => 'Folder deleted successfully'
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Folder not found'
        ], 404);
    }
    
    // Move file to folder
    public function moveFile(Request $request)
    {
        $request->validate([
            'file_path' => 'required|string',
            'destination_path' => 'required|string'
        ]);
        
        $disk = Storage::disk('public');
        $fileName = basename($request->file_path);
        $newPath = trim($request->destination_path . '/' . $fileName, '/');
        
        if ($disk->exists($request->file_path)) {
            $disk->move($request->file_path, $newPath);
            
            // Update stem record
            $stem = Stem::where('storage_path', $request->file_path)->first();
            if ($stem) {
                $stem->update(['storage_path' => $newPath]);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'File moved successfully',
                'new_path' => $newPath
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'File not found'
        ], 404);
    }
    
    // Upload file to specific folder
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:mp3,wav,ogg|max:51200',
            'folder_path' => 'nullable|string'
        ]);
        
        $file = $request->file('file');
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        
        // Clean filename
        $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9]/', '_', $originalName) . '.' . $extension;
        
        $folderPath = $request->folder_path ?: 'stems';
        $path = $file->storeAs($folderPath, $filename, 'public');
        
        // Create stem record
        $stem = Stem::create([
            'title' => $request->title ?? $originalName,
            'artist' => $request->artist ?? $this->extractArtistFromPath($folderPath),
            'stem_type' => $request->stem_type ?? 'Instrumental',
            'bpm' => $request->bpm ?? 120,
            'musical_key' => $request->key ?? 'C Maj',
            'genre' => $request->genre ?? 'Other',
            'storage_path' => $path,
            'is_visible' => true,
            'is_free' => Stem::count() < 200,
            'is_locked' => Stem::count() >= 200,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'File uploaded successfully',
            'path' => $path,
            'url' => Storage::url($path),
            'stem' => $stem
        ]);
    }
    
    // Delete single file
    public function delete(Request $request)
    {
        $request->validate([
            'path' => 'required|string'
        ]);
        
        $disk = Storage::disk('public');
        
        if ($disk->exists($request->path)) {
            $disk->delete($request->path);
            
            $stem = Stem::where('storage_path', $request->path)->first();
            if ($stem) {
                $stem->delete();
            }
            
            return response()->json([
                'success' => true,
                'message' => 'File deleted successfully'
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'File not found'
        ], 404);
    }
    
    // Bulk delete
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'paths' => 'required|array'
        ]);
        
        $disk = Storage::disk('public');
        $deleted = 0;
        
        foreach ($request->paths as $path) {
            if ($disk->exists($path)) {
                $disk->delete($path);
                
                $stem = Stem::where('storage_path', $path)->first();
                if ($stem) {
                    $stem->delete();
                }
                $deleted++;
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => "$deleted files deleted successfully",
            'deleted' => $deleted
        ]);
    }
    
    // Download file
    public function download($filename)
    {
        $disk = Storage::disk('public');
        
        // Search for file in all directories
        $allFiles = $disk->allFiles();
        $filePath = null;
        
        foreach ($allFiles as $file) {
            if (basename($file) === $filename) {
                $filePath = $file;
                break;
            }
        }
        
        if (!$filePath || !$disk->exists($filePath)) {
            return response()->json(['error' => 'File not found'], 404);
        }
        
        return response()->download(storage_path('app/public/' . $filePath), $filename);
    }
    
    // Auto-organize files by artist
    public function organize(Request $request)
    {
        $disk = Storage::disk('public');
        $organized = 0;
        
        // Get all audio files
        $allFiles = $disk->files('stems');
        
        foreach ($allFiles as $file) {
            $stem = Stem::where('storage_path', $file)->first();
            
            if ($stem && $stem->artist) {
                $artistFolder = 'stems/' . preg_replace('/[^a-zA-Z0-9]/', '_', $stem->artist);
                
                // Create artist folder if not exists
                if (!$disk->exists($artistFolder)) {
                    $disk->makeDirectory($artistFolder);
                }
                
                $fileName = basename($file);
                $newPath = $artistFolder . '/' . $fileName;
                
                // Move file to artist folder
                if ($file !== $newPath && $disk->exists($file)) {
                    $disk->move($file, $newPath);
                    $stem->update(['storage_path' => $newPath]);
                    $organized++;
                }
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => "Organized $organized files into artist folders",
            'organized' => $organized
        ]);
    }
    
    private function getParentPath($path)
    {
        if (empty($path)) {
            return null;
        }
        
        $parts = explode('/', $path);
        array_pop($parts);
        return implode('/', $parts);
    }
    
    private function extractArtistFromPath($path)
    {
        // Extract artist name from folder path
        $parts = explode('/', $path);
        if (count($parts) > 1) {
            return end($parts);
        }
        return 'Unknown Artist';
    }
    
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}