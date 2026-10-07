<script>

    function zipcodeChange(e) {
        var district_id = $('#receipt_district').val();

        $.ajax({
            type: "GET",
            url: '{!! route('user.api.json.zipcode') !!}',
            data: {id:district_id },
            cache: false,
            beforeSend: function () { },
            success: function (response) {

                $('#receipt_zipcode').val('');
                $.each(response, function (index, item) {
                    $('#receipt_zipcode').val(item.dis_code);
                });

            },
            failure: function (errMsg) {
                alert(errMsg);
            }
        });

    }
</script>
