<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait ManagesFiles {

    protected function uploadFile($file): string {
        $fileExt = $file->getClientOriginalExtension();
        $fileName = time() . '.' . $fileExt;
        $file->storeAs('dishes', $fileName, 'public');
        return $fileName;
    }
}