<script>

    var filtering = function() {
        DataTable.ajax.reload();
    }

    function loadFilter(e) {
        let month = $("#month").val();
        let year = $("#year").val();
        filtering();
    }

    function callChange(e) {
        loadFilter();
    }

    var DataTable = $('#userOrder').DataTable({
        autoWidth: false,
        responsive: true,
        lengthChange: false,
        processing: true,
        serverSide: true,
        destroy: true,
        paging: false,
        pageLength: false,
        searching: false,
        ordering: false,
        language: {
            search: 'ค้นหา',
            processing: '<i class="fa fa-spinner fa-spin fa-lg"></i><span class="ml-2">กำลังโหลดข้อมูล...</span> ',
            info: "",
            infoEmpty: "",
            zeroRecords: "ไม่พบข้อมูล",
            infoFiltered: "(ค้นหา จาก _MAX_ รายการ)",
            paginate: {
                first: '<i class="fas fa-angle-double-left"></i>',
                last: '<i class="fas fa-angle-double-right">',
                next: '<i class="fas fa-angle-right"></i>',
                previous: '<i class="fas fa-angle-left"></i>'
            },
        },
        ajax: {
            url: '{!! route('order.report.json.userOrder') !!}',
            dataType: 'json',
            type: "GET",
            data: function(d) {
                d.month = $('#month').val();
                d.year = $('#year').val();
            },
        },
        order: [],
        columnDefs: [
            {
                'targets': [0],
                'className': 'text-center',
            },
            {
                'targets': [2],
                'className': 'text-right',
            },
        ],
        columns: [
            {data: 'code'},
            {data: 'fullname'},
            {data: 'total'},
        ]
    });


</script>
