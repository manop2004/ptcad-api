<a href="{{ route('document.edit',['id' => $id]) }}" class="btn btn-warning btn-link btn-icon edit" title="แก้ไข"><i class="fa fa-edit"></i></a>
<a href="{{ route('document.status',['id' => $id]) }}" class="btn btn-link btn-icon" title="เปิด/ปิดใช้งาน">
    @if($status == 1)
        <i class="fa fa-toggle-on text-success"></i>
    @else
        <i class="fa fa-toggle-off text-secondary"></i>
    @endif
</a>
<a href="#" data-toggle="modal" data-target="#deleteModal" onclick="deleteModal(this)" data-id="{{ $id }}" data-name="{{ $name }}" class="btn btn-danger btn-link btn-icon remove" title="ลบ"><i class="fa fa-times"></i></a>