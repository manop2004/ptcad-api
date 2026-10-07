<script>
    function amphuresChange() {
        var province_id = $('#receipt_province').val();

        $.ajax({
            type: "GET",
            url: '{!! route('user.api.json.amphure') !!}',
            data: { id: province_id },
            cache: false,
            beforeSend: function () {
                $("#amphures").html('<option></option>');
            },
            success: function (response) {

                $("#receipt_amphures").html('');
                $("#receipt_district").html('<option></option>');
                $('#receipt_zipcode').val(' ');
                if(response != ""){
                    $("#receipt_amphures").append('<option></option>');
                    $.each(response, function (index, item) {
                        $("#receipt_amphures").append(
                            '<option value="' + item.id + '">' + item.amp_name_th + "</option>"
                        );
                    });
                }else{
                    $("#receipt_amphures").append(
                        '<option value="">ไม่มีข้อมูล</option>'
                    );
                }

            },
            failure: function (errMsg) {
                alert(errMsg);
            }
        });

    }
</script>
