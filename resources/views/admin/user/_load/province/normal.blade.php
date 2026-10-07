<script>
    $.ajax({
        type: "GET",
        url: '{!! route('api.provinces') !!}',
        cache: false,
        beforeSend: function () {
            $("#input_province").html('<option></option>');
        },
        success: function (response) {

            $("#input_province").html('');
            $("#input_district").html('<option></option>');
            $('#input_zipcode').val(' ');

            if(response != ""){
                $("#input_province").append('<option></option>');
                $.each(response, function (index, item) {
                    $("#input_province").append(
                        '<option value="' + item.id  + '">' + item.prov_name_th + "</option>"
                    );
                });
            }else{
                $("#input_province").append(
                    '<option value="">ไม่มีข้อมูล</option>'
                );
            }

        },
    });
</script>
