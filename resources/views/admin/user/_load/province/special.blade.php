<script>

$( document ).ready(function() {
    var province_id = $('#hidden_province_id').val();

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

                    if(item.id == province_id){
                        var selected = 'selected';
                    }else{
                        var selected = '';
                    }
                    $("#input_province").append(
                        '<option value="' + item.id + '" '+selected+'>' + item.prov_name_th + "</option>"
                    );
                });
            }else{
                $("#input_province").append(
                    '<option value="">ไม่มีข้อมูล</option>'
                );
            }

        },
    });

});

</script>
