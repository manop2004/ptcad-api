<script>
    function districtChange(e) {
        var amphoe_id = $('#receipt_amphures').val();
        $.ajax({
            type: "GET",
            url: '{!! route('user.api.json.district') !!}',
            data: {id: amphoe_id },
            cache: false,
            beforeSend: function () {
                $("#receipt_district").html('<option></option>');
            },
            success: function (response) {

                $("#receipt_district").val('');
                $('#receipt_zipcode').val('');
                if(response != ""){
                    $.each(response, function (index, item) {
                        $("#receipt_district").append(
                            '<option value="' + item.id + '">' + item.dis_name_th + "</option>"
                        );
                    });
                }else{
                    $("#receipt_district").html('<option></option>');
                }

            },
            failure: function (errMsg) {
                alert(errMsg);
            }
        });

    }
</script>
