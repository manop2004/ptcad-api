<script>
    $( document ).ready(function() {
        var province_id = $('#hd_province').val();
        var amphures_id = $('#hd_amphures').val();
        var zipcode     = $('#hd_zipcode').val();

        $.ajax({
            type: "GET",
            url: '{!! route('user.api.json.amphure') !!}',
            data: { id: province_id },
            cache: false,
            beforeSend: function () {
                $("#amphures").html('<option></option>');
            },
            success: function (response) {

                $("#amphures").html('');
                $("#district").html('<option></option>');
                $('#zipcode').val(zipcode);
                if(response != ""){
                    $("#amphures").append('<option></option>');
                    $.each(response, function (index, item) {

                        if(item.id == amphures_id){
                            var selected = 'selected';
                        }else{
                            var selected = '';
                        }

                        $("#amphures").append(
                            '<option value="' + item.id + '" '+selected+'>' + item.amp_name_th + "</option>"
                        );
                    });
                }else{
                    $("#amphures").append(
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
