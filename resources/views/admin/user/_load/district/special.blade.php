<script>
    $( document ).ready(function() {
        var hidden_amphoe_id   = $('#hd_amphures').val();
        var hidden_district_id = $('#hd_district').val();
        var hidden_zipcode     = $('#hd_zipcode').val();

        $.ajax({
            type: "GET",
            url: '{!! route('user.api.json.district') !!}',
            data: { id: hidden_amphoe_id },
            cache: false,
            beforeSend: function () {
                $("#district").html('<option></option>');
            },
            success: function (response) {

                $("#district").val(' ');
                $('#input_zipcode').val(hidden_zipcode);
                if(response != ""){
                    $.each(response, function (index, item) {

                        if(item.id == hidden_district_id){
                            var selected = 'selected';
                        }else{
                            var selected = '';
                        }

                        $("#district").append(
                            '<option value="' + item.id + '" '+selected+'>' + item.dis_name_th + "</option>"
                        );
                    });
                }else{
                    $("#district").html('<option></option>');
                }

            },
            failure: function (errMsg) {
                alert(errMsg);
            }
        });
    });
</script>
