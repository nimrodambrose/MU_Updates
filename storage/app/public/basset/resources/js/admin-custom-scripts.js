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

// Get Units from input
// $('#units_field').on('change', function () {
// 	var units = $(this).val();
// 	console.log(units);

// 	// Serialize the units array into JSON
// 	var unitsJSON = JSON.stringify(units);

// 	$.ajax({
// 		type: "post",
// 		url: "/request/get-programmes",
// 		data: { units: unitsJSON }, // Send as JSON data
// 		dataType: "json", // Expect JSON response
// 		success: function (response) {
// 			console.log(response);
// 		}
// 	});
// });



// Assuming you have already initialized your Select2 fields
// $('#units_field').select2();
// $('#programme_field').select2();

var programmes = [];

// Listen for changes in the units_field
$('#units_field').on('change', function () {
    // Get the selected units (an array)
    var units = $(this).val();
    console.log(units);

    // Serialize the units array into JSON
    var unitsJSON = JSON.stringify(units);

    $.ajax({
        type: "post",
        url: "/request/get-programmes",
        data: { units: unitsJSON }, // Send as JSON data
        dataType: "json", // Expect JSON response
        success: function (response) {
            // Store the response data in the programmes array
            programmes = response;

            // Clear existing options in the programme_field
            $('#programme_field').empty();

            // Add an "All" option to select all programs
            $('#programme_field').append($('<option>', {
                value: 'all',
                text: 'All Programs'
            }));

            // Add new options based on selected units
            $.each(programmes, function (key, value) {
                $('#programme_field').append($('<option>', {
                    value: key,
                    text: value
                }));
                console.log(value);
            });

            // Refresh the Select2 field
            $('#programme_field').trigger('change');
        }
    });
});

