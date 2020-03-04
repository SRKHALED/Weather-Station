$(document).ready(function(){
	fetch();

	$(document).on('click', '.delete_product', function(){
		var id = $(this).data('id');

		swal({
		  	title: 'Are you sure?',
		  	text: "You won't be able to revert this!",
		  	type: 'warning',
		  	showCancelButton: true,
		  	confirmButtonColor: '#3085d6',
		  	cancelButtonColor: '#d33',
		  	confirmButtonText: 'Yes, delete it!',
		}).then((result) => {
		  	if (result.value){
		  		$.ajax({
			   		url: 'api.php?action=delete',
			    	type: 'POST',
			       	data: 'id='+id,
			       	dataType: 'json'
			    })
			    .done(function(response){
			     	swal('Deleted!', response.message, response.status);
					fetch();
			    })
			    .fail(function(){
			     	swal('Oops...', 'Something went wrong with ajax !', 'error');
			    });
		  	}

		})

	});
});

function fetch(){
	$.ajax({
		method: 'POST',
		url: 'api.php',
		dataType: 'json',
		success: function(response){
			$('#tbody').html(response);
		}
	});
}