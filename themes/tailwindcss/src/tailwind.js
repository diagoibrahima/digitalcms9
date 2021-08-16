jQuery(document).ready(function() {

  jQuery('.blockmodule-submodule').hide();


 
  jQuery('.module-section').click(function(){


  var moduleIndex = jQuery(this).index();
  console.log(moduleIndex);
  jQuery('.field-content:eq('+moduleIndex+') .blockmodule-submodule').toggle('fast');

  jQuery('.field-content:eq('+moduleIndex+') .fa-chevron-down').toggleClass( 'ch-rotation' );
  jQuery('.field-content:eq('+moduleIndex+') .blockmodule-titre-module').addClass('blockmodule-titre-module-green');


});


    jQuery('.expandall-minimizeall-button').click(function() {
    jQuery('.blockmodule-submodule').toggle();
    jQuery('h3').toggleClass( 'colore-black' ); 
    jQuery('.blockmodule-titre-module').addClass('blockmodule-titre-module-green');
    jQuery('.fa-chevron-down').toggleClass( 'ch-rotation' );
    var expand = (jQuery('.expandall-minimizeall-button').text());
    expand == "Expand all" ?  jQuery('.expandall-minimizeall-button').text('Minimize') : jQuery('.expandall-minimizeall-button').text('Expand all')

    });

});