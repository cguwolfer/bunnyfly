
function productByCountry( country_code ){

	console.log("country_code=" + country_code );
	
	$.post("queryDB.php",
		{
			country: country_code
		},
		function( data ){
			
			console.log("DB return =" + data );
			// var obj = JSON.parse(data);
			// console.log("DB return =" + obj.result );
			window.location.assign("../3/3-0.html");
		}
	);
}

/*
function post() {
	$.ajax({
			url: 'js_php.php',
			type: 'POST',               
			// Form data
			data: function(){
					var data = new FormData();
					data.append('test', $("#test").val() );     
					return data;
			}(),
			success: function (data) {
					var obj = JSON.parse(data);
					$("#test").val( obj.result );                   
			},
			error: function (data) {
					console.log(data);
			},
			complete: function () {                 

			},
			cache: false,
			contentType: false,
			processData: false
	});
}
*/