// auto generate slug
$('input[name="title"]').on('input',function (e) {
    var slug = $(this).val();
    slug = slug.toLowerCase();
    slug = slug.replace(/[^a-zA-Z0-9]+/g,'-');
    $('input[name="slug"]').val(slug);
});

// short sms textarea switch
// $('#short_desc').prop('readonly', true);
$('#short_sms_switch').on('input', function (e) {
    var short_sms_switch = $('input[name="short_sms_switch').val();
    if (short_sms_switch == 0) {
        // console.log(short_sms_switch);
        $('#short_desc').prop('readonly', false);
    } else {
        // console.log(short_sms_switch);
        $("#short_desc").val('');
        $('#short_desc').prop('readonly', true);
    }
});

$('#inputCategory').on('input', function (e) {
    var inputCategory = $('#inputCategory').val();
    if (inputCategory == 'Student Affair') {
        $('#inputSubCategories').prop('disabled', false);
    } else {
        $("#inputSubCategories").val('');
        $('#inputSubCategories').prop('disabled', true);
    }
});


// change save button classes from 'btn-success' to 'btn-primary'
$('#saveActions .btn-success').removeClass('btn-success').addClass('btn-primary');
