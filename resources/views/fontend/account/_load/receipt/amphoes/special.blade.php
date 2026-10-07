<script>
    $( document ).ready(function() {
        var province_id = $('#receipt_hd_province').val();
        var amphures_id = $('#receipt_hd_amphures').val();
        var zipcode     = $('#receipt_hd_zipcode').val();

        $.ajax({
            type: "GET",
            url: '{!! route('user.api.json.amphure') !!}',
            data: { id: province_id },
            cache: false,
            beforeSend: function () {
                $("#receipt_amphures").html('<option></option>');
            },
            success: function (response) {

                $("#receipt_amphures").html('');
                $("#receipt_district").html('<option></option>');
                $('#receipt_zipcode').val(zipcode);
                if(response != ""){
                    $("#receipt_amphures").append('<option></option>');
                    $.each(response, function (index, item) {

                        if(item.id == amphures_id){
                            var selected = 'selected';
                        }else{
                            var selected = '';
                        }

                        $("#receipt_amphures").append(
                            '<option value="' + item.id + '" '+selected+'>' + item.amp_name_th + "</option>"
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

    });

</script>
