@if($row->status == 1)
    <button type="button" class="btn btn-sm btn-success btn-toggle-status" data-id="{{ $row->id }}">เปิดอยู่</button>
@else
    <button type="button" class="btn btn-sm btn-secondary btn-toggle-status" data-id="{{ $row->id }}">ปิดอยู่</button>
@endif
