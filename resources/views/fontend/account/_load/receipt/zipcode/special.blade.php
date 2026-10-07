<script>

    $( document ).ready(function() {
        var hidden_district_id = $('#receipt_district_id').val();

        $.ajax({
            type: "GET",
            url: '{!! route('api.zipcode') !!}',
            data: { district_id:hidden_district_id },
            cache: false,
            beforeSend: function () { },
            success: function (response) {

                $('#receipt__zipcode').val('');
                $.each(response, function (index, item) {
                    $('#receipt__zipcode').val(item.dis_code);
                });

            },
            failure: function (errMsg) {
                alert(errMsg);
            }
        });

    });

</script>
