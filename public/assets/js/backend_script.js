/* select township from db */

$('#region_id').change(function() {

   
	var value = $(this).val();

    $.post( base_url + 'townships',

           	{id: value},

          	function(data) {

          		var options;

				options = '<option value="">--- Select One ---</option>';

				$("#township_id").empty();

				$.each(data, function(k, v) { 

					for(var i = 0; i < v.length; i++) {

						options += '<option value="' + v[i].id + '" >' + v[i].township_name + '</option>';
						
					}

				})


				$("#township_id").append(options);

          },

      'json');
});

/** selected index for academic year **/
$("#academic_year").change(function () {
	var idx = this.selectedIndex;
	var pre_idx = idx - 1;
	$("#previous_year").val($('#academic_year option').eq(pre_idx).val());
    		
});