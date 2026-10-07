@if($status == 1)
    <form id="status-form-{{ $id }}" method="post" action="{{ route('transport.status',['id' => $id]) }}">
        @csrf
        @method('PUT')
        <button class="btn btn-danger">ปิดการใช้งาน</button>
    </form>
@elseif($status == 2)
    <form id="status-form-{{ $id }}" method="post" action="{{ route('transport.status',['id' => $id]) }}">
        @csrf
        @method('PUT')
        <button class="btn btn-success">เปิดการใช้งาน</button>
    </form>
@endif
