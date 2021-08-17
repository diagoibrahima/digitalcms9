jQuery(document).ready(function() {

  jQuery('.blockmodule-submodule').hide();

  jQuery('.views-view-grid.horizontal.cols-4.clearfix .views-row').last().append('<div class="views-col col-1 addcourse-blank" style="width: 25%;"><div class="views-field views-field-nothing"><span class="field-content"><div class=" tw-item-card "><a href="node/add/course_" class="addcoursebutton" tabindex="-1">New Course</a></div></div> ');

  // Expand switch for one single learning module 
  jQuery('.module-section').click(function(){
  var moduleIndex = jQuery(this).index();
  jQuery('.field-content:eq('+moduleIndex+') .blockmodule-submodule').toggle('fast');
  jQuery('.field-content:eq('+moduleIndex+') .fa-chevron-down').toggleClass( 'ch-rotation' );
  jQuery('.field-content:eq('+moduleIndex+') .blockmodule-titre-module').addClass('blockmodule-titre-module-green');
  });

      // Expand All 
    jQuery('.expandall-minimizeall-button').click(function() {
    jQuery('.blockmodule-submodule').toggle('fast');
    jQuery('h3').toggleClass( 'colore-black' ); 
    jQuery('.blockmodule-titre-module').addClass('blockmodule-titre-module-green');
    jQuery('.fa-chevron-down').toggleClass( 'ch-rotation' );
    var expand = (jQuery('.expandall-minimizeall-button').text());
    expand == "Expand all" ?  jQuery('.expandall-minimizeall-button').text('Minimize') : jQuery('.expandall-minimizeall-button').text('Expand all')

    });

});