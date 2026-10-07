<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="toolbar"></div>
          <table id="datatableDetail" data-back="{{ route('product.index') }}" data-json="{{ route('product.detail.jsondata',['id'=>$id]) }}"  data-create="{{ route('product.detail.add',['tab'=>4,'id'=>$id]) }}" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th style="width: 30px" class="disabled-sorting"></th>
                <th style="width: 80px" class="disabled-sorting"></th>
                <th class="disabled-sorting">รหัสสินค้า</th>
                <th class="disabled-sorting">ชื่อสินค้า</th>
                <th style="width: 150px" class="text-right">ราคา</th>
                <th style="width: 50px" class="disabled-sorting">สต็อก</th>
                <th style="width: 100px" class="disabled-sorting"></th>
                <th style="width: 80px" class="disabled-sorting">สถานะ</th>
                <th style="width: 120px" class="disabled-sorting">อัพเดตข้อมูล</th>
                <th style="width: 130px" class="disabled-sorting">Actions</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
        <!-- end content-->
      </div>
      <!--  end card  -->
    </div>
</div>