<script>
    $.ajax({
        type: "GET",
        url: '{!! route('user.api.json.province') !!}',
        cache: false,
        beforeSend: function () {
            $("#receipt_province").html('<option></option>');
        },
        success: function (response) {

            $("#receipt_province").html('<option></option>');
            $("#receipt_district").html('<option></option>');
            $('#receipt_zipcode').val(' ');

            if(response != ""){
                $.each(response, function (index, item) {
                    $("#receipt_province").append(
                        '<option value="' + item.id  + '">' + item.prov_name_th + "</option>"
                    );
                });
            }else{
                $("#receipt_province").append(
                    '<option value="">ไม่มีข้อมูล</option>'
                );
            }

        },
    });
</script>
