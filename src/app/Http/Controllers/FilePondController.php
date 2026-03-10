<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

final class FilePondController extends Controller
{
    /**
     * Uploads a temp file for async upload
     *
     * @param Request $request
     *
     * @return string
     */
    public function up(Request $request): string
    {
        // We don't know the name of the file input, so we need to grab
        // all the files from the request and grab the first file.
        /** @var UploadedFile[] $files */
        $files = $request->allFiles();

        if (empty($files)) {
            abort(422, 'No files were uploaded.');
        }

        if (count($files) > 1) {
            abort(422, 'Only 1 file can be uploaded at a time.');
        }

        // Now that we know there's only one key, we can grab it to get
        // the file from the request.
        $requestKey = array_key_first($files);

        // If we are allowing multiple files to be uploaded, the field in the
        // request will be an array with a single file rather than just a
        // single file (e.g. - `csv[]` rather than `csv`). So we need to
        // grab the first file from the array. Otherwise, we can assume
        // the uploaded file is for a single file input and we can
        // grab it directly from the request.
        $file = is_array($request->input($requestKey))
            ? $request->file($requestKey)[0]
            : $request->file($requestKey);

        // Store the file in a temporary location and return the location
        // for FilePond to use.
        return $file->store(
            path: 'tmp/' . now()->timestamp . '-' . Str::random(20)
        );
    }

    /**
     * Used to load in the up one already uploaded temp file.
     *
     * Needed to recover the form state in case of a POST with validation errors.
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function load(Request $request) {
        $filename = $request->get('file');

        // Prevent path traversal by ensuring the filename doesn't contain '..'
        // and only allow files from the 'tmp' directory.
        if (str_contains($filename, '..') || !str_starts_with($filename, 'tmp/')) {
            abort(403, 'Invalid file path.');
        }

        $path = storage_path("app/{$filename}");

        if (!file_exists($path)) {
            abort(404, 'File not found.');
        }

        return response()->file($path);
    }
}
