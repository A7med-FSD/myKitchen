<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait ManagesFiles {

    public function uploadFile($file, $folderName, $userId = null): string {

        $fileExt = $file->getClientOriginalExtension();
        $prefix = $userId ? $userId . '_' : '';
        $fileName = $prefix . time() . '.' . $fileExt; 
        $file->storeAs($folderName, $fileName, 'public');
        return $fileName;
    }

    public function updateFile($file, $folderName, $oldFile, $userId = null) {
        if($oldFile) {
            $oldPath = $folderName . '/' . $oldFile;
            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }
        return $this->uploadFile($file, $folderName, $userId);
    }

    public function deleteFile($filePath, $folderName) {
        $oldPath = $folderName . '/' . $filePath;
        if (Storage::disk('public')->exists($oldPath)) {
            Storage::disk('public')->delete($oldPath);
        }
    }
}