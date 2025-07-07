<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/upload-file', function (Request $request) {
    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $path = $file->store('uploads/event', 'public');
        $url = url('storage/' . $path); // gunakan `url()` bukan `asset()` untuk hasil yang bersih
        // saya tidak ingin mengembalikan path, tapi URL yang bisa diakses env('APP_URL')/storage/uploads/file-upload/filename.ext
        $url_public = '../storage/' . $path;
        return response()->json(['location' => $url_public]);
    }
    return response()->json(['error' => 'No file uploaded'], 400);
})->name('upload.file');

Route::get('/cek', function () {
    return response()->json(['message' => 'Cek route is working!']);
})->name('upload.file');
