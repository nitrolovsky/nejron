$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("input").on("input", function () {
        var idV = $('input[name="id"]').val();
        var valueAttr = $(this).val();
        var nameAttr = $(this).attr("name");
        $.ajax({
            type: "POST",
            url: "/pages/updateajax",
            data: {id: idV, namei: nameAttr, valuei: valueAttr },
            success: function(res) {
                console.log(res);
            }
        });
    });

    $(".status").on("input", function () {
        var valueAttr = $(this).val();
        var nameAttr = $(this).attr("name");
        var idAttr = $(this).attr("id");
        $.ajax({
            type: "POST",
            url: "/leads/updatestatus",
            data: {id: idAttr, namei: nameAttr, valuei: valueAttr },
            success: function(res) {
                console.log(res);
            }
        });
    });

    $(".textarea").on("input", function () {
        var idV = $('input[name="id"]').val();
        var valueAttr = $(this).val();
        var nameAttr = $(this).attr("name");
        $.ajax({
            type: "POST",
            url: "/pages/updateajax",
            data: {id: idV, namei: nameAttr, valuei: valueAttr },
            success: function(res) {
                console.log(res);
            }
        });
    });

    $('input[type="checkbox"]').on("change", function () {
        var idV = $('input[name="id"]').val();
        if ($(this).is(':checked')) {
            var valueAttr = $(this).val();
        } else {
            var valueAttr = '';
        }

        var nameAttr = $(this).attr("name");
        $.ajax({
            type: "POST",
            url: "/pages/updateajax",
            data: {id: idV, namei: nameAttr, valuei: valueAttr },
            success: function(res) {
                console.log(res);
            }
        });
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#bg-img').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#background_image").change(function(){
        readURL(this);

        var file_data = $('#background_image').prop('files')[0];
        var form_data = new FormData();
        var idV = $('input[name="id"]').val();
        form_data.append('background_image', file_data);
        form_data.append('id', idV);

        $.ajax({
            url: '/pages/updateajaximage',
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(res){
                console.log(res);
            }
         });
    });

    $("#lead_magnet_file").change(function(){
        var file_data = $('#lead_magnet_file').prop('files')[0];
        var form_data = new FormData();
        var idV = $('input[name="id"]').val();
        form_data.append('lead_magnet_file', file_data);
        form_data.append('id', idV);

        $.ajax({
            url: '/pages/updateajaxfile',
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(res){
                console.log(res);
            }
         });
    });

    $("#video").on("input", function(){
        var valueAttr = $(this).val();
        valueAttr = valueAttr + "?rel=0&showinfo=0";
         $('#video_iframe').attr("src", valueAttr);
    });


});
