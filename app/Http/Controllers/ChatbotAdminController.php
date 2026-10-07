<?php

namespace App\Http\Controllers;

use App\Models\TbChatbotQna;
use Illuminate\Http\Request;

class ChatbotAdminController extends Controller
{
    public function index()
    {
        $items = TbChatbotQna::orderBy('parent_id')->orderBy('sort_order')->get();
        return view('admin.chatbot.main', compact('items'));
    }

    public function crate(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer_type' => 'required|in:text,link',
        ]);

        TbChatbotQna::create($request->only([
            'parent_id', 'question', 'answer', 'answer_type',
            'link_url', 'link_label', 'sort_order',
        ]) + ['is_active' => 1]);

        return redirect()->route('chatbot.index')->with('success', 'เพิ่มคำถามสำเร็จ');
    }

    public function update(Request $request, $id)
    {
        $item = TbChatbotQna::findOrFail($id);
        $item->update($request->only([
            'parent_id', 'question', 'answer', 'answer_type',
            'link_url', 'link_label', 'sort_order',
        ]));

        return redirect()->route('chatbot.index')->with('success', 'แก้ไขสำเร็จ');
    }
    public function toggleWidget()
{
    $setting = \App\Models\TbSetting::first();
    $setting->setting_chatbot_status = ($setting->setting_chatbot_status == 1) ? 2 : 1;
    $setting->save();

    return redirect()->route('chatbot.index')->with('success', 'อัปเดตสถานะปุ่ม Chatbot สำเร็จ');
}

    public function status($id)
    {
        $item = TbChatbotQna::findOrFail($id);
        $item->is_active = !$item->is_active;
        $item->save();

        return redirect()->route('chatbot.index');
    }

    public function delete(Request $request)
    {
        TbChatbotQna::findOrFail($request->id)->delete();
        return response()->json(['success' => true]);
    }
}
