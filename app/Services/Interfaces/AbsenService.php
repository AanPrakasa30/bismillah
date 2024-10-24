<?php

namespace App\Services\Interfaces;

interface AbsenService
{
    function createAbsenSiswaBySpreadsheet(int $folderTemp): array;
}