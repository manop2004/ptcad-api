<script>
    function districtChange(e) {
        var amphoe_id = $('#amphures').val();

        console.log(amphoe_id);
        $.ajax({
            type: "GET",
            url: '{!! route('user.api.json.district') !!}',
            data: {id: amphoe_id },
            cache: false,
            beforeSend: function () {
                $("#district").html('<option></option>');
            },
            success: function (response) {

                $("#district").val('');
                $('#zipcode').val('');
                if(response != ""){
                    $.each(response, function (index, item) {
                        $("#district").append(
                            '<option value="' + item.id + '">' + item.dis_name_th + "</option>"
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

    }
</script>
