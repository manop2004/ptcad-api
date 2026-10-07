@extends('layouts.temp_admin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>จัดการคำถาม-คำตอบ Chatbot</h5>
                <hr/>
                <div class="card-header">
    <h5>จัดการคำถาม-คำตอบ Chatbot</h5>

    @php
        $chatbotSetting = \App\Models\TbSetting::first();
        $isChatbotOn = optional($chatbotSetting)->setting_chatbot_status == 1;
    @endphp
    <form action="{{ route('chatbot.toggleWidget') }}" method="POST" style="margin-top:10px;">
        @csrf
        <label style="display:flex;align-items:center;gap:10px;">
            <span>ปุ่ม Chatbot บนหน้าเว็บ:</span>
            <button type="submit" class="btn btn-sm {{ $isChatbotOn ? 'btn-success' : 'btn-secondary' }}">
                {{ $isChatbotOn ? '🟢 เปิดใช้งานอยู่' : '⚪ ปิดอยู่' }}
            </button>
        </label>
    </form>

    <hr/>
</div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalAdd">+ เพิ่มคำถาม</button>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>คำถาม</th>
                            <th>เป็นลูกของ</th>
                            <th>ประเภทคำตอบ</th>
                            <th>ลำดับ</th>
                            <th>สถานะ</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                        <tr>
                            <td>@if($item->parent_id) &nbsp;&nbsp;↳ @endif {{ $item->question }}</td>
                            <td>{{ $item->parent_id ? optional($items->firstWhere('id', $item->parent_id))->question : '(เมนูหลัก)' }}</td>
                            <td>{{ $item->answer_type === 'link' ? 'ลิงก์ (LINE/URL)' : 'ข้อความ' }}</td>
                            <td>{{ $item->sort_order }}</td>
                            <td>
                                <a href="{{ route('chatbot.status', $item->id) }}" class="btn btn-sm {{ $item->is_active ? 'btn-success' : 'btn-secondary' }}">
                                    {{ $item->is_active ? 'เปิดใช้งาน' : 'ปิดอยู่' }}
                                </a>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalEdit{{ $item->id }}">แก้ไข</button>
                                <a href="#" class="btn btn-sm btn-danger" onclick="if(confirm('ลบแน่นะ?')){document.getElementById('delform{{ $item->id }}').submit();} return false;">ลบ</a>
                                <form id="delform{{ $item->id }}" action="{{ route('chatbot.delete') }}" method="POST" style="display:none;">
                                    @csrf @method('DELETE')
                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- ===== Modal ทั้งหมดอยู่นอกตาราง ===== --}}

{{-- Modal เพิ่มคำถามใหม่ --}}
<div class="modal fade" id="modalAdd">
    <div class="modal-dialog">
        <form action="{{ route('chatbot.crate') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header"><h5>เพิ่มคำถามใหม่</h5></div>
            <div class="modal-body">
                <label>เป็นลูกของ (เว้นว่าง = เมนูหลัก)</label>
                <select name="parent_id" class="form-control mb-2">
                    <option value="">(เมนูหลัก)</option>
                    @foreach($items as $p)
                        <option value="{{ $p->id }}">{{ $p->question }}</option>
                    @endforeach
                </select>
                <label>คำถาม</label>
                <input type="text" name="question" class="form-control mb-2" required>
                <label>คำตอบ</label>
                <textarea name="answer" class="form-control mb-2" rows="3"></textarea>
                <label>ประเภทคำตอบ</label>
                <select name="answer_type" class="form-control mb-2">
                    <option value="text">ข้อความธรรมดา</option>
                    <option value="link">มีปุ่มลิงก์ (LINE/URL)</option>
                </select>
                <label>ลิงก์</label>
                <input type="text" name="link_url" class="form-control mb-2" placeholder="https://line.me/...">
                <label>ข้อความบนปุ่มลิงก์</label>
                <input type="text" name="link_label" class="form-control mb-2" placeholder="แชทผ่าน LINE OA">
                <label>ลำดับการแสดง</label>
                <input type="number" name="sort_order" class="form-control" value="0">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">เพิ่ม</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal แก้ไข — วนลูปสร้างทีละอัน แต่อยู่นอกตารางแล้ว --}}
@foreach($items as $item)
<div class="modal fade" id="modalEdit{{ $item->id }}">
    <div class="modal-dialog">
        <form action="{{ route('chatbot.update', $item->id) }}" method="POST" class="modal-content">
            @csrf @method('PUT')
            <div class="modal-header"><h5>แก้ไขคำถาม</h5></div>
            <div class="modal-body">
                <label>เป็นลูกของ (เว้นว่าง = เมนูหลัก)</label>
                <select name="parent_id" class="form-control mb-2">
                    <option value="">(เมนูหลัก)</option>
                    @foreach($items as $p)
                        @if($p->id != $item->id)
                        <option value="{{ $p->id }}" {{ $item->parent_id == $p->id ? 'selected' : '' }}>{{ $p->question }}</option>
                        @endif
                    @endforeach
                </select>

                <label>คำถาม (ข้อความบนปุ่ม)</label>
                <input type="text" name="question" class="form-control mb-2" value="{{ $item->question }}" required>

                <label>คำตอบ</label>
                <textarea name="answer" class="form-control mb-2" rows="3">{{ $item->answer }}</textarea>

                <label>ประเภทคำตอบ</label>
                <select name="answer_type" class="form-control mb-2">
                    <option value="text" {{ $item->answer_type == 'text' ? 'selected' : '' }}>ข้อความธรรมดา</option>
                    <option value="link" {{ $item->answer_type == 'link' ? 'selected' : '' }}>มีปุ่มลิงก์ (LINE/URL)</option>
                </select>

                <label>ลิงก์ (ใช้ถ้าเลือก "มีปุ่มลิงก์")</label>
                <input type="text" name="link_url" class="form-control mb-2" value="{{ $item->link_url }}" placeholder="https://line.me/...">

                <label>ข้อความบนปุ่มลิงก์</label>
                <input type="text" name="link_label" class="form-control mb-2" value="{{ $item->link_label }}" placeholder="แชทผ่าน LINE OA">

                <label>ลำดับการแสดง</label>
                <input type="number" name="sort_order" class="form-control" value="{{ $item->sort_order }}">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">บันทึก</button>
            </div>
        </form>
    </div>
</div>
@endforeach

@endsection