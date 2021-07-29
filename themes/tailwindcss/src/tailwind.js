
var number = parseInt(jQuery('.numberofmodule').text());
number==1 ?  jQuery('.numberofmodule').append('module'):jQuery('.numberofmodule').append('modules')
 
jQuery(document).ready(function() {
        jQuery('.blockmodule-des>h3').append('<i class="expand-minimize-button fas text-light text-xl font-thin text-gray-400 fa-chevron-down"></i>');
        jQuery('.blockmodule-des>h3 , .fa-chevron-down , .expandall-minimizeall-button').click(function() {
        jQuery('.blockmodule-des').addClass('blockmodule-des-open');
        jQuery('.contextual').addClass('blockmodule-des-modale');
    });

    jQuery('.blockmodule-des>h3 , .fa-chevron-down ').click(function() {
    jQuery('.blockmodule-des>div').toggle();
    jQuery('h3').toggleClass( 'colore-black' ); 
    jQuery('.fa-chevron-down').toggleClass( 'ch-rotation' );

    });


    jQuery('.expandall-minimizeall-button').click(function() {
    jQuery('.blockmodule-des>div').toggle();
    jQuery('h3').toggleClass( 'colore-black' ); 
    jQuery('.fa-chevron-down').toggleClass( 'ch-rotation' );
    var expand = (jQuery('.expandall-minimizeall-button').text());
    expand == "Expand all" ?  jQuery('.expandall-minimizeall-button').text('Minimize') : jQuery('.expandall-minimizeall-button').text('Expand all')

    });

});