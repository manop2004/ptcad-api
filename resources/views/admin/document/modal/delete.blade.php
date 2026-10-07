<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {{ Form::open(['route' => 'document.delete', 'method' => 'delete', 'id' => 'formDelete']) }}
            <div class="modal-header">
                <h5 class="modal-title">ยืนยันการลบข้อมูล</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ต้องการลบหัวข้อ "<span id="deleteName"></span>" ใช่หรือไม่?
                <input type="hidden" name="deleteId" id="deleteId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                <button type="submit" class="btn btn-danger">ยืนยันลบ</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

<script>
    function deleteModal(el) {
        var id = $(el).data('id');
        var name = $(el).data('name');
        $('#deleteId').val(id);
        $('#deleteName').text(name);
    }
</script>