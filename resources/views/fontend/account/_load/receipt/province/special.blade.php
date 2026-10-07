<script>

$( document ).ready(function() {
    var province_id = $('#receipt_hd_province').val();

    $.ajax({
        type: "GET",
        url: '{!! route('user.api.json.province') !!}',
        data: { id: province_id },
        cache: false,
        beforeSend: function () {
            $("#receipt_province").html('<option></option>');
        },
        success: function (response) {

            $("#receipt_province").html('');
            $("#receipt_district").html('<option></option>');
            $('#receipt_zipcode').val(' ');

            if(response != ""){
                $("#receipt_province").append('<option></option>');
                $.each(response, function (index, item) {

                    if(item.id == province_id){
                        var selected = 'selected';
                    }else{
                        var selected = '';
                    }
                    $("#receipt_province").append(
                        '<option value="' + item.id + '" '+selected+'>' + item.prov_name_th + "</option>"
                    );
                });
            }else{
                $("#receipt_province").append(
                    '<option value="">ไม่มีข้อมูล</option>'
                );
            }

        },
    });

});

</script>
