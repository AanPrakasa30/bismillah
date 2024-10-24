<?php

namespace App\Services;

use App\Models\FileTemp;
use App\Services\Interfaces\FileService;
use Storage;

class FilepoundServiceImpl implements FileService
{
    private const TEMP_PATH = "temp/";

    public function uploadTemp(\Illuminate\Http\Request $request): bool|string
    {
        // return false;
        // get request has files
        foreach ($request->allFiles() as $key => $itemFilesReq) {

            logDebug('request file masuk', [
                $key
            ]);

            // jika multy file
            if (is_array($itemFilesReq)) {

                // ambil tiap data array
                foreach ($itemFilesReq as $item) {
                    $folder = rand();
                    $file   = \Illuminate\Support\Str::random() . "-" . $item->getClientOriginalName();

                    Storage::disk("public")->putFileAs(FilepoundServiceImpl::TEMP_PATH . $folder, $item, $file);

                    FileTemp::create([
                        'folder' => $folder,
                        'file' => $file,
                        'user_id' => auth()->user()->id
                    ]);

                    return $folder;
                }
            }

            // jika single file
            if ($request->hasFile($key)) {
                $folder = rand();

                logDebug('masuk disini');
                $file = \Illuminate\Support\Str::random() . "-" . $request->file($key)->getClientOriginalName();

                logDebug('file masuk', [
                    $request->file($key)
                ]);

                Storage::disk("local")->putFileAs(FilepoundServiceImpl::TEMP_PATH . $folder, $request->file($key), $file);

                FileTemp::create([
                    'folder' => $folder,
                    'file' => $file,
                    'user_id' => auth()->user()->id
                ]);

                return $folder;
            }
        }

        return false;
    }

    public function revertTemp(\Illuminate\Http\Request $request): bool
    {
        $temp = FileTemp::where('folder', $request->getContent())->first();
        Storage::disk('local')->deleteDirectory(FilepoundServiceImpl::TEMP_PATH . $request->getContent());
        $temp->delete();

        return true;
    }

    public function getTempPathFile(int $tempFolderNumber): string
    {
        $temp = FileTemp::where('folder', $tempFolderNumber)->first();

        if (!$temp) {
            throw new \Exception("temp tidak ditemukan");
        }

        if (!Storage::disk("local")->exists(self::TEMP_PATH . $temp->folder)) {
            throw new \Exception("file target not exists");
        }

        return self::TEMP_PATH . "$temp->folder/$temp->file";
    }

    public function deleteTempData(int $tempFolderNumber): bool
    {
        $temp = FileTemp::where('folder', $tempFolderNumber)->first();
        if ($temp) {
            Storage::disk('local')->deleteDirectory(self::TEMP_PATH . $tempFolderNumber);
            $temp->delete();

            return true;
        }

        return false;
    }
}