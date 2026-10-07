<?php

namespace App\Http\Controllers;

use App\Models\TbChatbotQna;
use App\Models\TbChatbotLog;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function getQna()
    {
        $items = TbChatbotQna::where('is_active', 1)
            ->orderBy('sort_order')
            ->get(['id', 'parent_id', 'question', 'answer', 'answer_type', 'link_url', 'link_label']);

        return response()->json($items);
    }

    public function logClick(Request $request)
    {
        TbChatbotLog::create([
            'qna_id'     => $request->input('qna_id'),
            'session_id' => $request->input('session_id'),
            'created_at' => now(),
        ]);

        return response()->json(['ok' => true]);
    }
}