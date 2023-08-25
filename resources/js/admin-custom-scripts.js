// change save button classes from 'btn-success' to 'btn-primary'
$('#saveActions .btn-success').removeClass('btn-success').addClass('btn-primary');

// auto generate slug
$('input[name="title"]').on('input',function (e) {
    var slug = $(this).val();
    slug = slug.toLowerCase();
    slug = slug.replace(/[^a-zA-Z0-9]+/g,'-');
    $('input[name="slug"]').val(slug);
});

// short sms textarea switch
$('input[name="short_sms_switch"]').on('change', function (e) {
    var short_sms_switch = $(this).val();
    // console.log(short_sms_switch);
    if (short_sms_switch == 0) {
        // console.log(short_sms_switch);
        $('#short_desc_field').val('');
        $('#short_desc_field').attr('disabled', 'disabled');
    } else {
        // console.log(short_sms_switch);
        $('#short_desc_field').removeAttr('disabled');
    }
});

// get Units on input
$('#units_field').on('change', function () {
    var units = $(this).val();
    console.log(units);

    $.ajax({
        type: "post",
        url: "/request/get-programmes",
        data: units,
        // dataType: "dataType",
        success: function (response) {
            console.log(response);
        }
    });
});