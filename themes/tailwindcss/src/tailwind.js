jQuery(document).ready(function() {

 jQuery('.blockmodule-submodule').hide();
 jQuery('.add-module , .use-ajax').hide();
 jQuery('option[value="_none"]').remove();


//content completion 
//nombre de message traduit
var nombredemessagetraduit = (jQuery('div#block-views-block-testcompletion-block-1 header').text());
//console.log(nombredemessagetraduit);
//total message
var totalmessage = (jQuery('div#block-views-block-completionnbmessage-block-1 header').text());
//console.log(totalmessage);
var restotranslate=totalmessage-nombredemessagetraduit;
var pourcentage = nombredemessagetraduit*100/totalmessage;
var pourcentagemyInt = parseInt(pourcentage);

console.log(pourcentagemyInt);


jQuery('.contentrestetotranslate').html(restotranslate +' '+'to translate');
//jQuery('div#block-views-block-completionnbmessage-block-1 header').append('<h1> voici le pourcentage '+pourcentagemyInt +'<h1>')
/*
if(pourcentagemyInt >=100){
  jQuery('p.tw-font-bold.tw-text-5xl.tw-text-center.tw-my-3.tw-text-red-600.tw-translations-indicator').html(100+'%')
}else  */

jQuery('p.tw-font-bold.tw-text-5xl.tw-text-center.tw-my-3.tw-text-red-600.tw-translations-indicator').html(pourcentagemyInt+'%')

if(pourcentagemyInt >=33){
  jQuery('p.tw-font-bold.tw-text-5xl.tw-text-center.tw-my-3.tw-text-red-600.tw-translations-indicator').addClass('colo-midle');
  jQuery('p.tw-rounded.tw-bg-red-100.tw-border.tw-border-red-500.tw-text-gray-800.p-1').addClass('coloremidel');
}
if(pourcentagemyInt >=100){
  
  jQuery('p.tw-font-bold.tw-text-5xl.tw-text-center.tw-my-3.tw-text-red-600.tw-translations-indicator').addClass('colo-midlegr');
  jQuery('p.tw-rounded.tw-bg-red-100.tw-border.tw-border-red-500.tw-text-gray-800.p-1').addClass('coloremidelgr');
  jQuery('p.tw-rounded.tw-bg-red-100.tw-border.tw-border-red-500.tw-text-gray-800.p-1').html('This course has been fully translated');
}


// jQuery('.a.use-ajax').hide();
 jQuery('<h1 class="titre-cms-translation">CMS Translation</h1>').insertBefore('.js-form-item.form-item.js-form-type-textfield.form-item-name.js-form-item-name'); 
 jQuery('<i class="fa fa-fw fa-user"></i>').insertBefore('input#edit-name');
 jQuery('<i class="fa fa-fw fa-lock"></i>').insertBefore('input#edit-pass');
 jQuery('a.use-ajax').prepend('<i class="fas fa-plus-square"></i>');
 jQuery('.views-view-grid.horizontal.cols-4.clearfix .views-row').last().append('<div class="views-col col-1 addcourse-blank" style="width: 25%;"><div class="views-field views-field-nothing"><span class="field-content"><div class=" tw-item-card "><a href="node/add/course_" class="addcoursebutton" tabindex="-1">New Course</a></div></div> ');
 jQuery('#edit-name').attr('placeholder','  Username');
 jQuery('#edit-pass').attr('placeholder','  Password');

 jQuery('<i class="fa fa-sign-in logout-menu" aria-hidden="true"></i>').insertBefore('nav#block-logout ul li a span');

 jQuery('option[value="_none"]').remove();

jQuery('<h1> Add Custom Image</h1>').insertBefore('#edit-field-image-0-upload');





 jQuery('span.tw-switch-editing-button.tw-rounded.border.tw-border-green-500.tw-px-5.py-2.tw-text-green-700.tw-text-sm.tw-cursor-pointer').click(function(){

  jQuery('.tw-switch-editing-button').toggleClass( 'turneditone' );

  var turneoff = (jQuery('.tw-switch-editing-button').text());
  var expand = (jQuery('.expandall-minimizeall-button').text());
  jQuery('.add-module , .use-ajax ').toggle();
  jQuery('.blockmodule-titre-module').toggleClass('blockmodule-titre-module-expland');

turneoff == "Turn editing on" ?  jQuery('.tw-switch-editing-button').text('Turn editing off') : jQuery('.tw-switch-editing-button').text('Turn editing on')
 });
 
  // Expand switch for one single learning module  old
  /*
  jQuery('.module-section').click(function(){
  var moduleIndex = jQuery(this).index();
  jQuery('.field-content:eq('+moduleIndex+') .blockmodule-submodule').toggle('fast');
  jQuery('.field-content:eq('+moduleIndex+') .fa-chevron-down').toggleClass( 'ch-rotation' );
  jQuery('.field-content:eq('+moduleIndex+') .blockmodule-titre-module').addClass('blockmodule-titre-module-green');
  });
*/

// Expand switch for one single learning module 
jQuery('.module-section').click(function(){
  var moduleIndex = jQuery(this).index()+2;
 
  jQuery('.field-content:eq('+moduleIndex+') .blockmodule-submodule').toggle('fast');
  jQuery('.field-content:eq('+moduleIndex+') .fa-chevron-down').toggleClass( 'ch-rotation' );
  jQuery('.field-content:eq('+moduleIndex+') .blockmodule-titre-module').addClass('blockmodule-titre-module-green');
  });



  // Expand switch for one single learning module  new
  jQuery('.listee-des-module-sub-module').click(function(){

    var moduleIndex = jQuery(this).parent().index();
    console.log(moduleIndex);
    jQuery('.blockmodule-titre-module:eq('+moduleIndex+') .blockmodule-submodule').toggle('fast');
    jQuery('.field-content:eq('+moduleIndex+') .fa-chevron-down').toggleClass( 'ch-rotation' );
    jQuery('.field-content:eq('+moduleIndex+') .blockmodule-titre-module').addClass('blockmodule-titre-module-green');
    });

      // Expand All 
    jQuery('.expandall-minimizeall-button').click(function() {
    jQuery('.blockmodule-submodule').toggle('fast');
    jQuery('h3').toggleClass( 'colore-black' ); 
    jQuery('.blockmodule-titre-module').toggleClass('blockmodule-titre-module-green');
    jQuery('.fa-chevron-down').toggleClass( 'ch-rotation' );
    var expand = (jQuery('.expandall-minimizeall-button').text());
    expand == "Expand all" ?  jQuery('.expandall-minimizeall-button').text('Minimize')  : jQuery('.expandall-minimizeall-button').text('Expand all')
    
     
   //  else jQuery('.use-ajax').toggle()
    
  //  expand == "Minimize" ? jQuery('.use-ajax').hide() : jQuery('.use-ajax').show()
    });

});

 // Expand switch for one single learning module 
 jQuery('.module-section').each(function(){
  
  var moduleIndexee = jQuery(this).index();
  console.log(moduleIndexee);

  jQuery(this).find('.blockmodule-titre-module span').html('Module '+moduleIndexee+':');
 

  });


  /*
  
  jQuery(document).ready(function() {

  var expand = (jQuery('.expandall-minimizeall-button').text());
  console.log(expand);
 expand == "Expand all" ? jQuery('.use-ajax').hide() : jQuery('.expandall-minimizeall-button').text('Expand all')
  });

  */

