<?php

namespace App\Http\Controllers;

use App\Models\Receipt;

class ReceiptController extends Controller {

    public function delete(Receipt $receipt) {
        $receipt->delete();
    }
}
