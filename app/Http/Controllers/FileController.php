<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public static function saveLetterAttachment($letter, $file)
    {
        $dirPathPublic = 'public/letters/' . $letter->id;
        $dirPath = '/storage/letters/' . $letter->id;
        $filename = substr(md5($letter->id . '-' . microtime()), 0, 15) . '.' . $file->getClientOriginalExtension();
        $name = $file->getClientOriginalName();

        $file_path = $letter->file_path;
        $letter = Letter::updateAttachment($letter, $file, $dirPath, $filename, $name);
        if ($letter) {
            $file->storeAs($dirPathPublic, $filename);
            if ($file_path) {
                self::deleteFileFromStorage($file_path);
            }
        }

        return $letter;
    }

    public static function deleteLetterAttachment($letter)
    {
        $file_path = $letter->file_path;
        $letter = Letter::deleteAttachment($letter);

        if ($letter && $file_path) {
            self::deleteFileFromStorage($file_path);
        }

        return $letter;
    }

    public static function deleteFileFromStorage($filePath)
    {
        return Storage::delete(str_replace('storage/', 'public/', $filePath));
    }

    public static function deleteDirectoryFromStorage($directoryPath)
    {
        return Storage::deleteDirectory($directoryPath);
    }

}
