<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // For file operations

class AppStatusController extends Controller
{
    private $statusFilePath = 'app_status.txt'; // Relative to storage/app

    public function getStatus()
    {
        $status = Storage::exists($this->statusFilePath) ?
            trim(Storage::get($this->statusFilePath)) :
            'open';

        return response()->json(['status' => $status]);
    }

    public function toggleStatus(Request $request)
    {
        $currentStatus = Storage::exists($this->statusFilePath) ?
            trim(Storage::get($this->statusFilePath)) :
            'open';

        $newStatus = ($currentStatus === 'open') ? 'closed' : 'open';
        $message = $request->input('message', 'Aplikasi sedang dalam pemeliharaan.'); // Optional message from admin

        Storage::put($this->statusFilePath, $newStatus);
        Storage::put('app_close_message.txt', $message); // Store message separately

        return response()->json([
            'success' => true,
            'new_status' => $newStatus,
            'message' => 'Status aplikasi berhasil diubah menjadi ' . $newStatus . '.',
        ]);
    }
}
