$(document).ready(function(){
	// $(document).ready() is executed after the page DOM id loaded
	$('#addressLoading').hide();
	$('#address').blur(function(){
	  $('#addressLoading').show();
      $.post("/address/check_address.php", {
        address: $('#address').val()
      }, function(response){
        $('#addressResult').fadeOut();
        setTimeout("finishAjax('addressResult', '"+escape(response)+"')", 400);
      });
    	return false;
	});

	
	// Binding an listener to the submit event on the form:
	$('#addressform').submit(function(e){

		// If a previous submit is in progress:
		if($('#submit').hasClass('active')) return false;
		
		// Adding the active class to the button. Will show the preloader gif:
		$('#submit').addClass('active');
		
		// Removing the current error tooltips
		$('.errorTip').remove();
		
		// Issuing a POST ajax request to submit.php (the action attribute of the form):
		$.post($('#addressform').attr('action'),$('#addressform').serialize()+'&fromAjax=1',function(response){
			
			if(!response.status)
			{
				// Some kind of input error occured
				
				// Looping through all the input text boxes,
				// and checking whether they produced an error
				$('input[type!=submit]').each(function(){
					var elem = $(this);
					var id = elem.attr('id');
					
					if(response[id])
						showTooltip(elem,response[id]);
				});
			}
			else location.replace(response.redirectURL);
			
			$('#submit').removeClass('active');
		},'json');
		
		e.preventDefault();
	});
	
	$(window).resize();
});

// Centering the form vertically on every window resize:
$(window).resize(function(){
	var cf = $('#carbonForm');
	
//	$('#carbonForm').css('margin-top',($(window).height()-cf.outerHeight())/2)
});

// Helper function that creates an error tooltip:
function showTooltip(elem,txt)
{
	// elem is the text box, txt is the error text
	$('<div class="errorTip">').html(txt).appendTo(elem.closest('.formRow'));
}

function finishAjax(id, response) {
  $('#addressLoading').hide();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
} //finishAjax
