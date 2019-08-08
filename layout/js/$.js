$(function () {

	'use strict';

	// Dashboard 

	// Trigger The Selectboxit

	$("select").selectBoxIt({

		autoWidth: false

	});

	// Hide Placeholder On Form Focus

	$('[placeholder]').focus(function () {

		$(this).attr('data-text', $(this).attr('placeholder'));

		$(this).attr('placeholder', '');

	}).blur(function () {

		$(this).attr('placeholder', $(this).attr('data-text'));

	});

	// Add Asterisk On Required Field

	$('input').each(function () {

		if ($(this).attr('required') === 'required') {

			$(this).after('<span class="asterisk">*</span>');

		}

	});
    //context between signin siginUp
    $(".page-login h1 span").on("click",function(){
    
    $(this).addClass("active").siblings().removeClass("active");
        $("form").fadeOut(200);
        $ ("."+$(this).data("class") ).fadeIn(200).removeClass("ds-none");
    
});
    
    
    // create  live ads show in fornt of U depend on data-class and give to another tie this val 
    $(".Live").keyup(function(){
        
        $("."+ $(this).data('class')).text($(this).val());
        
    });
    


});