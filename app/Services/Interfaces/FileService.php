<?php

namespace App\Services\Interfaces;

interface FileService
{
    /**
     * Summary of uploadTemp
     * 
     * upload file ke temporarry folder
     * @return string
     */
    function uploadTemp(\Illuminate\Http\Request $request): string|bool;

    /**
     * Summary of revertTemp
     * 
     * revert file yang telah diupload di temp
     * @return bool
     */
    function revertTemp(\Illuminate\Http\Request $request): bool;

    /**
     * Summary of getTempPathFile
     * 
     * get path storage local og temp file target
     * @param int $tempFolderNumber
     * @return string
     */
    function getTempPathFile(int $tempFolderNumber): string;
}