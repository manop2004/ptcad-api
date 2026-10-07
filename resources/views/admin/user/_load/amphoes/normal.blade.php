<script>
    function amphuresChange() {
        var province_id = $('#province').val();

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
                $('#zipcode').val(' ');
                if(response != ""){
                    $("#amphures").append('<option></option>');
                    $.each(response, function (index, item) {
                        $("#amphures").append(
                            '<option value="' + item.id + '">' + item.amp_name_th + "</option>"
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

    }
</script>
