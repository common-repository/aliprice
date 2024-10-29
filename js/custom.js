jQuery(function($) {
	$('#order_example').on('keyup change', function (){
		var order_val = $('#order_example').val();
		$('#order_example_preview').val(order_val);
	});
	$('#smarter_button_example').on('keyup change', function (){
		var order_val = $('#smarter_button_example').val();
		$('#smarter_button_example_preview').val(order_val);
	});
	$('#smarter_text').on('keyup change', function (){
		var order_val = $('#smarter_text').val();
		$('#smarter_text_example').html(order_val);
	});
	$('#text_btn1').on('keyup change', function (){
		var order_val = $('#text_btn1').val();
		$('.btn1').html(order_val);
	});
	$('#text_btn2').on('keyup change', function (){
		var order_val = $('#text_btn2').val();
		$('.btn2').html(order_val);
	});
	$('#text_btn3').on('keyup change', function (){
		var order_val = $('#text_btn3').val();
		$('.btn3').html(order_val);
	});
	
	
});
