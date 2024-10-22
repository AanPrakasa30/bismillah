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
}