<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class Receipt extends Model
{
    protected $fillable = [
        'path',
    ];

    const STORAGE_PATH = 'receipts';

    /**
     * Get the parent of the receipt.
     */
    public function receiptable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Gets the public url of the receipt
     *
     * @return string
     */
    public function url() {
       return asset(Storage::url($this->path));
    }

    /**
     * Checks if the file is an image or not
     *
     * @return bool
     */
    public function isImage() {
        $mime = Storage::disk('public')->mimeType($this->path);

        if (str_starts_with($mime, 'image/')) {
            return true;
        }

        return false;
    }

    static public function bindReceiptsToExpense(Expense $expense, array $receipts) {
        $uploadedReceipts = [];
        foreach ($receipts as $receipt) {
            // Copy the file from a temporary location to a permanent location.
            $uploadedReceipts[] = [
                'path' => Receipt::putFile($receipt),
            ];
        }

        $expense->receipts()->createMany($uploadedReceipts);
    }

    /**
     * Moves the tmp uploaded file into the storage destination
     *
     * @param $tmpUploadedReceipt
     *
     * @return false|string
     */
    static public function putFile($tmpUploadedReceipt) {
        return Storage::disk('public')->
            putFile(
                path: self::STORAGE_PATH,
                file: new File(Storage::path($tmpUploadedReceipt))
            );
    }

}
