<div class="modal fade" id="deleteThump_detail" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('product.detail.deleteImg') }}">
                @csrf
                @method('DELETE')
                <div class="modal-header text-align-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="nc-icon nc-simple-remove"></i>
                </button>
                <h4 class="title title-up">ยืนยันการลบรูปภาพสินค้า</h4>
                </div>
                <div class="modal-body text-align-center">
                    <input type="hidden" id="deleteId5" name="deleteId" value=""/>
                    <p><span id="deleteName5"></span>?</p>
                </div>
                <div class="modal-footer">
                    <div class="left-side">
                        <button type="button" class="btn btn-default btn-link" data-dismiss="modal">ยกเลิก</button>
                    </div>
                    <div class="divider"></div>
                    <div class="right-side">
                        <button type="submit" class="btn btn-danger btn-link">ลบข้อมูล</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

