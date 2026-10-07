<script>

    $('#tableProvince').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 10,
        ordering: false,
        "searching": false,
        "bLengthChange": false,
        "bInfo" : false,
        "paging": false,
        ajax: {
            url: '{!! route('user.jsonprovince') !!}'
        },
        order: [[ 2, "desc" ]],
        columnDefs: [
            {
                'targets': [0],
                'width': '10px',
                'className': 'text-center',
            },
            {
                'targets': [2],
                'width': '100px',
                'className': 'text-center',
            },
        ],
        columns: [
            {data: 'DT_RowIndex'},
            {data: 'provinces'},
            {data: 'count'},
        ]
    });

</script>