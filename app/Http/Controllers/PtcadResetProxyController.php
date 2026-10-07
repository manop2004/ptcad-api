<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class PtcadResetProxyController extends Controller
{
    private string $ptcadBaseUrl;
    private string $apiKeys;

    public function __construct()
    {
        $this->ptcadBaseUrl = rtrim(env('PTCAD_DOMAIN', 'https://admin.pt-cad.com'), '/');
        $this->apiKeys = env('PTCAD_API_KEYS', '');
    }

    private function ptcadHeaders(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->apiKeys,
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
        ];
    }

    /**
     * GET — ตรวจสอบสถานะ Reset Request ล่าสุด (เรียกตอนโหลดหน้า "My Products")
     * Pass-through เต็มรูปแบบ — ไม่เช็คความเป็นเจ้าของใน DB เราแล้ว ให้ระบบ PTCAD ตรวจสอบเอง
     */
    public function status(Request $request)
    {
        $serialnumber = $request->query('serialnumber');

        if (empty($serialnumber)) {
            return response()->json(['success' => false, 'error' => 'Missing serialnumber'], 400);
        }

        try {
            $response = Http::withHeaders($this->ptcadHeaders())
                ->get("{$this->ptcadBaseUrl}/api/external/hardware-reset-status", [
                    'serialnumber' => $serialnumber,
                ]);

            Log::info('PtcadResetProxy: status checked', [
                'userId' => Auth::id(), 'serialnumber' => $serialnumber, 'status' => $response->status(),
            ]);

            return response()->json($response->json(), $response->status());

        } catch (\Exception $e) {
            Log::error('PtcadResetProxy: GET Error - ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Proxy Error'], 500);
        }
    }

    /**
     * POST — สร้างคำขอ Reset Hardware (เรียกตอนลูกค้ากดปุ่ม "Reset Hardware" แล้วยืนยันใน modal)
     * Pass-through เต็มรูปแบบ — ไม่เช็คความเป็นเจ้าของใน DB เราแล้ว ให้ระบบ PTCAD ตรวจสอบเอง
     */
    public function request(Request $request)
    {
        $serialnumber = $request->input('serialnumber');

        if (empty($serialnumber)) {
            return response()->json(['success' => false, 'error' => 'Missing serialnumber'], 400);
        }

        try {
            $response = Http::withHeaders($this->ptcadHeaders())
                ->post("{$this->ptcadBaseUrl}/api/external/request-reset-hardware", [
                    'serialnumber' => $serialnumber,
                ]);

            Log::info('PtcadResetProxy: reset requested', [
                'userId' => Auth::id(), 'serialnumber' => $serialnumber, 'status' => $response->status(),
            ]);

            return response()->json($response->json(), $response->status());

        } catch (\Exception $e) {
            Log::error('PtcadResetProxy: POST Error - ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Proxy Error'], 500);
        }
    }
}