<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MediaController extends Controller
{
    public function show(Request $request, string $path)
    {
        $full = storage_path('app/public/' . $path);
        abort_unless(is_file($full), 404);

        $mime = File::mimeType($full) ?: 'application/octet-stream';

        if (!str_starts_with($mime, 'video/')) {
            return response()->file($full, [
                'Cache-Control' => 'public, max-age=86400',
                'Content-Type' => $mime,
            ]);
        }

        return $this->streamVideo($request, $full, $mime);
    }

    private function streamVideo(Request $request, string $full, string $mime): StreamedResponse
    {
        $size = filesize($full);
        $start = 0;
        $end = $size - 1;
        $status = 200;
        $headers = [
            'Content-Type' => $mime,
            'Accept-Ranges' => 'bytes',
            'Cache-Control' => 'public, max-age=86400',
            'Content-Disposition' => 'inline; filename="' . basename($full) . '"',
        ];

        $range = $request->header('Range');
        if ($range && preg_match('/bytes=(\d*)-(\d*)/i', $range, $matches)) {
            $start = $matches[1] === '' ? 0 : (int) $matches[1];
            $end = $matches[2] === '' ? $end : (int) $matches[2];
            $end = min($end, $size - 1);
            $start = min($start, $end);
            $status = 206;
            $headers['Content-Range'] = "bytes {$start}-{$end}/{$size}";
        }

        $length = ($end - $start) + 1;
        $headers['Content-Length'] = (string) $length;

        return response()->stream(function () use ($full, $start, $end) {
            $chunkSize = 1024 * 1024;
            $handle = fopen($full, 'rb');
            if ($handle === false) {
                return;
            }

            fseek($handle, $start);
            $remaining = ($end - $start) + 1;

            while ($remaining > 0 && !feof($handle)) {
                $read = min($chunkSize, $remaining);
                $buffer = fread($handle, $read);
                if ($buffer === false) {
                    break;
                }
                echo $buffer;
                flush();
                $remaining -= strlen($buffer);
            }

            fclose($handle);
        }, $status, $headers);
    }
}
