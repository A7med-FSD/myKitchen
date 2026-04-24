<?php

namespace App\Http\Controllers;

use App\ApiResponse;
use App\Http\Requests\SettingRequest;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    use ApiResponse;

    public function update(SettingRequest $request) {
        $newSetting = $request->validated();
        $oldSetting = json_decode(Storage::disk('private')->get('setting.json'), true);

        $result = array_replace_recursive($oldSetting, $newSetting);
        Storage::disk('private')->put('setting.json', json_encode($result, JSON_PRETTY_PRINT)); 
        return $this->successResponse(null, 200);
    }
}
