<script>

    $( document ).ready(function() {
        var hidden_district_id = $('#hidden_district_id').val();

        $.ajax({
            type: "GET",
            url: '{!! route('api.zipcode') !!}',
            data: { district_id:hidden_district_id },
            cache: false,
            beforeSend: function () { },
            success: function (response) {

                $('#input_zipcode').val('');
                $.each(response, function (index, item) {
                    $('#input_zipcode').val(item.dis_code);
                });

            },
            failure: function (errMsg) {
                alert(errMsg);
            }
        });

    });

</script>
