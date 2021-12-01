jQuery(document).ready(function() {
  jQuery('.blockmodule-submodule').hide();
  jQuery('.add-module , .use-ajax').hide();
  jQuery('option[value="_none"]').remove();
  jQuery('.entity-moderation-form .form-item label').html('');
 
let str = localStorage.getItem("channelVal");

/*
if(str=="Moodle"){
 jQuery('#edit-field-localization-channel option[value="Moodle"]').prop('selected',true);
 jQuery('#edit-field-localization-messagebody-0-value').show();
 jQuery('#edit-field-localisation-message-0-value').show();

}else if(str=="Whatsapp"){
 jQuery('#edit-field-localization-channel option[value="Whatsapp"]').prop('selected',true);
 jQuery('#edit-field-localisation-message-0-value').hide();
 jQuery('#edit-field-localization-messagebody-0-value').show();

}else if(str=="SMS"){
 jQuery('#edit-field-localization-channel option[value="SMS"]').prop('selected',true);
 jQuery('#edit-field-localization-messagebody-0-value').remove();
 jQuery('#edit-field-localization-messagebody-wrapper').remove();
 jQuery('#edit-field-localisation-message-0-value').show();
 

}else if(str=="Telegram"){
 jQuery('#edit-field-localization-channel option[value="Whatsapp"]').prop('selected',true);
 jQuery('#edit-field-localisation-message-0-value').hide();
 jQuery('#edit-field-localization-messagebody-0-value').show();

}else if(str=="Messenger"){
 jQuery('#edit-field-localization-channel option[value="Whatsapp"]').prop('selected',true);
 jQuery('#edit-field-localisation-message-0-value').hide();
 jQuery('#edit-field-localization-messagebody-0-value').show();

}else if(str=="IOGT"){
 jQuery('#edit-field-localization-channel option[value="Whatsapp"]').prop('selected',true);
 jQuery('#edit-field-localisation-message-0-value').hide();
 jQuery('#edit-field-localization-messagebody-0-value').show();

}else{

console.log(str);
}

*/
 
 //content completion   
 //nombre de message traduit
 var nombredemessagetraduit = (jQuery('div#block-views-block-testcompletion-block-1 header').text());
 
 //total message
 var totalmessage = (jQuery('div#block-views-block-completionnbmessage-block-1 header').text());
 //console.log(totalmessage);
 var restotranslate=totalmessage-nombredemessagetraduit;
 
 var pourcentage = nombredemessagetraduit*100/totalmessage;
 
 var pourcentagemyInt = parseInt(pourcentage);
 
 
 jQuery('.contentrestetotranslate').html(restotranslate +' '+'to translate');
 //jQuery('div#block-views-block-completionnbmessage-block-1 header').append('<h1> voici le pourcentage '+pourcentagemyInt +'<h1>')
 
 if(pourcentagemyInt >=100){
   jQuery('p.tw-font-bold.tw-text-5xl.tw-text-center.tw-my-3.tw-text-red-600.tw-translations-indicator').html(100+'%')
 }else  
 
 jQuery('p.tw-font-bold.tw-text-5xl.tw-text-center.tw-my-3.tw-text-red-600.tw-translations-indicator').html(pourcentagemyInt+'%')
 
 if(pourcentagemyInt >=33){
   jQuery('p.tw-font-bold.tw-text-5xl.tw-text-center.tw-my-3.tw-text-red-600.tw-translations-indicator').addClass('colo-midle');
   jQuery('p.tw-rounded.tw-bg-red-100.tw-border.tw-border-red-500.tw-text-gray-800.p-1').addClass('coloremidel');
 }
 if(pourcentagemyInt >=100){
   
   jQuery('p.tw-font-bold.tw-text-5xl.tw-text-center.tw-my-3.tw-text-red-600.tw-translations-indicator').addClass('colo-midlegr');
   jQuery('p.tw-rounded.tw-bg-red-100.tw-border.tw-border-red-500.tw-text-gray-800.p-1').addClass('coloremidelgr');
   jQuery('p.tw-rounded.tw-bg-red-100.tw-border.tw-border-red-500.tw-text-gray-800.p-1').html('This course has been fully translated');
   jQuery('p.tw-my-2.tw-text-center.tw-text-gray-500 span.contentrestetotranslate').html('');
 }
 
 if((jQuery('p.tw-font-bold.tw-text-5xl.tw-text-center.tw-my-3.tw-text-red-600.tw-translations-indicator').text())=='NaN%'){
   jQuery('p.tw-font-bold.tw-text-5xl.tw-text-center.tw-my-3.tw-text-red-600.tw-translations-indicator').html('0 %')
 }
 
 
 
 //Dasboard 
 
 let cours=(jQuery('div#block-views-block-cardnbcours-block-1 header').text());

 jQuery('span.rounded-full.text-white.badge.bg-teal-400.text-xs.Cours').html(cours);
 let messagesimpe=(jQuery('div#block-views-block-cardnbmessage-block-1 header').text());
 jQuery('span.rounded-full.text-white.badge.bg-teal-400.text-xs.Messagaes').html('8');
 let messagesimpetranslate=(jQuery('div#block-views-block-cardnbmessagetranslated-block-1 header').text());
 //jQuery('span.rounded-full.text-white.badge.bg-teal-400.text-xs.Messagestranslated').html(messagesimpetranslate);
 jQuery('span.rounded-full.text-white.badge.bg-teal-400.text-xs.Messagestranslated').html('25%');
 let modulesdecourse=(jQuery('div#block-views-block-cardnbmodule-block-1 header').text());
 jQuery('span.rounded-full.text-white.badge.bg-red-400.text-xs.Module').html(modulesdecourse);
 
 //GENERATE CHANNEL
 
 
   jQuery("a.generatebutton").click(function() {
 
 
   jQuery( '<div class="channelgenerategeneral"> <div class="channelgenerate sms" id="sms"><i class="fas fa-sms"></i>SMS</div> <br> <div class="channelgenerate moodle"><i class="fas fa-graduation-cap"></i>MOODLE</div> <br>  <div class="channelgenerate whatsapp"><i class="fab fa-whatsapp"></i>WHATSAPP</div> <br>  <div class="channelgenerate telegrame"><i class="fab fa-telegram"></i>TELEGRAM</div> <br> <div class="channelgenerate messanger"><i class="fab fa-facebook-messenger"></i>MESSENGER</div> </div>').insertAfter('a.generatebutton');
  
   let messagetolacalise=(jQuery('article').html());
   jQuery('.channelgenerate ').append(messagetolacalise);
   jQuery('a.generatebutton').hide();
   jQuery('<a class="cancelbutton"> Cancel </a>').insertBefore('a.generatebutton');
   //jQuery('a.generatebutton').removeClass('generatebutton');

   jQuery('.cancelbutton').click(function() {

    jQuery('.channelgenerategeneral').remove();
    jQuery('a.generatebutton').show();
    jQuery('a.cancelbutton').hide();
 
 });


//Selectio channel option




  jQuery('.sms').click(function() {

      try {localStorage.setItem("channelVal", "SMS");} catch(e){}
      jQuery('.sms').css('border-left', '6px solid #1491c1');
      jQuery('.moodle').css('border', 'none');
      jQuery('.whatsapp').css('border', 'none');
      jQuery('.telegrame').css('border', 'none');
      jQuery('.messanger').css('border', 'none');
    
 });

  jQuery('.moodle').click(function() {
      
      try {localStorage.setItem("channelVal", "Moodle");} catch(e){}
      jQuery('.sms').css('border', 'none');
      jQuery('.moodle').css('border-left', '6px solid #1491c1');
      jQuery('.whatsapp').css('border', 'none');
      jQuery('.telegrame').css('border', 'none');
      jQuery('.messanger').css('border', 'none');
      jQuery('#edit-field-localization-channel option[value="Moodle"]').prop('selected',true);
     
 });

  jQuery('.whatsapp').click(function() {

      try {localStorage.setItem("channelVal", "Whatsapp");} catch(e){}
      jQuery('.sms').css('border', 'none');
      jQuery('.moodle').css('border', 'none');
      jQuery('.whatsapp').css('border-left', '6px solid #1491c1');
      jQuery('.telegrame').css('border', 'none');
      jQuery('.messanger').css('border', 'none');
     
 });

  jQuery('.telegrame').click(function() {

      try {localStorage.setItem("channelVal", "Telegram");} catch(e){}
      jQuery('.sms').css('border', 'none');
      jQuery('.moodle').css('border', 'none');
      jQuery('.whatsapp').css('border', 'none');
      jQuery('.telegrame').css('border-left', '6px solid #1491c1');
      jQuery('.messanger').css('border', 'none');
     
 });

  jQuery('.messanger').click(function() {

      try {localStorage.setItem("channelVal", "Messenger");} catch(e){}
      jQuery('.sms').css('border', 'none');
      jQuery('.moodle').css('border', 'none');
      jQuery('.whatsapp').css('border', 'none');
      jQuery('.telegrame').css('border', 'none');
      jQuery('.messanger').css('border-left', '6px solid #1491c1');
     
 });
 
 });


 
 //MANAGE MODERATION STATE
 
 var moderationstate = jQuery.trim(jQuery('.entity-moderation-form__item div#edit-current').text());
 
jQuery('<span class="message-langage pstStatusModeration">'+moderationstate+'</span>').insertBefore('form#content-moderation-entity-moderation-form');



 
 
 if(moderationstate =="Draft"){
 jQuery('a.moderationStateButton.sforreview').remove();
 jQuery('a.moderationStateButton.approve').remove();
 jQuery('a.moderationStateButton.reject').remove();
 jQuery('a.moderationStateButton.rsubmit').remove();
 jQuery('a.moderationStateButton.submit').addClass('submitpositionleft');
 
 
 }
 
 if(moderationstate =='Submit for review'){
 jQuery('a.moderationStateButton.submit').remove();
 jQuery('a.moderationStateButton.sforreview').remove();
 jQuery('a.moderationStateButton.rsubmit').remove();
 jQuery('a.moderationStateButton.submit').addClass('submitpositionleft');
 
 }
 
 if(moderationstate =='Rejected'){
 jQuery('a.moderationStateButton.sforreview').remove();
 jQuery('a.moderationStateButton.submit').remove();
 jQuery('a.moderationStateButton.approve').remove();
 jQuery('a.moderationStateButton.reject').remove();
 
 }
 
 if(moderationstate ==''){
 jQuery('a.moderationStateButton.sforreview').remove();
 jQuery('a.moderationStateButton.submit').remove();
 jQuery('a.moderationStateButton.approve').remove();
 jQuery('a.moderationStateButton.reject').remove();
 jQuery('a.moderationStateButton.rsubmit').remove();
 }
 
 



// Click On moderation State button function______________________________________________________

// +Submit content for review

 jQuery('a.moderationStateButton.submit').click(function() {
     //alert('submit content for reveiw');
      jQuery('option[value="ready_for_review"]').prop('selected',true);
      jQuery( "#edit-submit" ).click();


 });

// +re submit 
 jQuery('a.moderationStateButton.rsubmit').click(function() {
     //alert('submit content for reveiw');
      jQuery('option[value="ready_for_review"]').prop('selected',true);
      jQuery( "#edit-submit" ).click();


 });

// +Approve content 
 jQuery('a.moderationStateButton.approve').click(function() {

      jQuery('option[value="published"]').prop('selected',true);
      jQuery( "#edit-submit" ).click();
 
 });

// +Reject content 
 jQuery('a.moderationStateButton.reject').click(function() {
      
     jQuery('option[value="needs_work"]').prop('selected',true);
     jQuery( "#edit-submit" ).click();
 
 });
 
 //______________________________________________________________________________________________
 
 
 // Expand switch for one single learning module 
 /*
 jQuery('.module-section').click(function(){
   var moduleIndex = jQuery(this).index()+2;
  
   jQuery('.field-content:eq('+moduleIndex+') .blockmodule-submodule').toggle('fast');
   jQuery('.field-content:eq('+moduleIndex+') .fa-chevron-down').toggleClass( 'ch-rotation' );
   jQuery('.field-content:eq('+moduleIndex+') .blockmodule-titre-module').addClass('blockmodule-titre-module-green');
   });
 
   */
 
 
 
  // let languesnumber= jQuery('.views-field.views-field-field-field-langage a').text();
 
  // console.log(languesnumber);
 
 
 
   // Expand switch for one single learning module  new
   jQuery('.blockmodule-titre-module').click(function(){
     //console.log(this);
 
     var moduleIndex = jQuery(this).index();
  
     jQuery('.blockmodule-submodule:eq('+moduleIndex+')').toggle('fast');
    
     });
 
       // Expand All 
     jQuery('.expandall-minimizeall-button').click(function() {
     jQuery('.blockmodule-submodule').toggle('fast');
     //jQuery('h3').toggleClass( 'colore-black' ); 
     jQuery('.blockmodule-titre-module').toggleClass('blockmodule-titre-module-green');
     jQuery('.fa-chevron-down').toggleClass( 'ch-rotation' );
     var expand = (jQuery('.expandall-minimizeall-button').text());
     expand == "Expand all" ?  jQuery('.expandall-minimizeall-button').text('Minimize')  : jQuery('.expandall-minimizeall-button').text('Expand all')
     
      
    //  else jQuery('.use-ajax').toggle()
     
   //  expand == "Minimize" ? jQuery('.use-ajax').hide() : jQuery('.use-ajax').show()
     });
 

 
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
 
 
 
 
 
 
 // jQuery('.a.use-ajax').hide();
 jQuery('<h1 class="titre-cms-translation"> CONTENT MANAGEMENT AND ADAPTATION PLATFORM </h1>').insertBefore('.js-form-item.form-item.js-form-type-textfield.form-item-name.js-form-item-name'); 
 jQuery('<i class="fa fa-fw fa-user"></i>').insertBefore('input#edit-name');
 jQuery('<i class="fa fa-fw fa-lock"></i>').insertBefore('input#edit-pass');
 jQuery('a.use-ajax').prepend('<i class="fas fa-plus-square"></i>');
 jQuery('.views-view-grid.horizontal.cols-4.clearfix .views-row').last().append('<div class="views-col col-1 addcourse-blank" style="width: 25%;"><div class="views-field views-field-nothing"><span class="field-content"><div class=" tw-item-card "><a href="node/add/course_" class="addcoursebutton" tabindex="-1">New Course</a></div></div> ');
 jQuery('#edit-name').attr('placeholder','  Username');
 jQuery('#edit-pass').attr('placeholder','  Password');
 jQuery('.dataTables_wrapper .dataTables_filter input').attr('placeholder',' Search');
 
 jQuery('<i class="fa fa-sign-in logout-menu" aria-hidden="true"></i>').insertBefore('nav#block-logout ul li a span');
 
 jQuery('option[value="_none"]').remove();
 
 jQuery('<h1> Add Custom Image</h1>').insertBefore('#edit-field-image-0-upload');
 
 
 
 
 //bar chart
 
 
 const labelsBarChart = [
   'Content',
   'Localizations',
   'Messages',
   'Messages translated'
 ];
 const dataBarChart = {
   labels: labelsBarChart,
   datasets: [{
     label: 'Dataset Content management and adaption platform',
     backgroundColor:'#36B1B4',
     borderColor: '#36B1B4',
     //data: [ cours, modulesdecourse, messagesimpetranslate, modulesdecourse ],
     data: [ 10, 39, 50, 60 ]
   }]
 };
 
 const configBarChart = {
   type: 'bar',
   data: dataBarChart,
   options: {}
 };
 
 
 var chartBar = new Chart(
   document.getElementById('chartBar'),
   configBarChart
 );
 
 jQuery('.module-section').each(function(){
   
   var moduleIndexee = jQuery(this).index();
 
 
   jQuery(this).find('.blockmodule-titre-module span').html('Module '+moduleIndexee+':');
  
 
   });
 

 
 });

