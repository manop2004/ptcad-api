
<div class="modal fade" id="myDeleteicon" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{
                Form::model($data, [
                    'novalidate',
                    'route' => ['setting.deleteIcon'],
                    'id'=>'data-form',
                    'method' => 'put',
                    'files' => true
                ])
            }}
                @csrf
                <div class="modal-header text-align-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="nc-icon nc-simple-remove"></i>
                </button>
                <h4 class="title title-up">ยืนยันการลบข้อมูล</h4>
                </div>
                <div class="modal-body text-align-center">
                    <input type="hidden" id="deleteId2" name="deleteId2" value=""/>
                    <p><span id="deleteName2"></span>?</p>
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

