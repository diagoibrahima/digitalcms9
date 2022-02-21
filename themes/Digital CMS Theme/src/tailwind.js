jQuery(document).ready(function() {
  jQuery('.blockmodule-submodule').hide();
  jQuery('a.btn').hide();
  jQuery('section').hide();
 
  jQuery('<div class="live-preveiw-section "> <div class="livepreview-content"> Live preview  Content </div> <div class="tilteconteValue" ></div> <div class="DescriptioncontentValue"></div> <div class="contentent-preview-good-format">  </div> </div>').insertBefore('form#node-content-form');
//  jQuery('<div class="tilteconteValue" ></div>').insertAfter('.livepreview-content');
//  jQuery('<div class="DescriptioncontentValue"></div>').insertAfter('.tilteconteValue')
  
  //hide submodule and message content 
  
jQuery('.node-content p span b').hide();
jQuery('.node-content-form input#edit-submit').prop('disabled', true);

jQuery('<div class="tw-flex tw-items-center tw-jtw-ustify-center tw-mb-4 btn-groupOnAddContent"><button class="btn btn-edit tw-bg-blue-700 tw-text-white hover:tw-bg-blue-700 hover:tw-text-white active tw-font-bold uppercase tw-text-sm tw-px-6 tw-py-3 tw-rounded-l tw-outline-none tw-focus:outline-none tw-mb-1 tw-ease-linear tw-transition-all tw-duration-150" type="button">Edit</button><button class="btn btn-preview  btn-preview-addcontent tw-bg-blue-500 tw-text-white hover:tw-bg-blue-700 hover:tw-text-white  tw-font-bold uppercase tw-text-sm tw-px-6 tw-py-3 tw-rounded-r outline-none tw-focus:outline-none tw-mb-1 tw-ease-linear transition-all duration-150" type="button">Preview</button></div>').insertAfter('.node-content-form input#edit-submit');

jQuery('<span class="button-add-new-comment">Add a new comment</span>').insertBefore('section');
jQuery('.node-content p:nth-child(1)').insertBefore('.node-content p:nth-child(1)')

//Download files and archive them in to a zipfile

//The FileSaver API
jQuery(".downloadzipfile").click(function(){
  console.log("Salut Jszip"); 
  var zip = new JSZip();
  zip.file("Hello.txt", "Hello World\n");
  var img = zip.folder("images");
  img.file("smile.gif", imgData, {base64: true});
  zip.generateAsync({type:"blob"})
  .then(function(content) {
      // see FileSaver.js
      saveAs(content, "example.zip");
  });
/*
//The data URL
var zip = new JSZip();
zip.file("Hello.txt", "Hello world\n");

jQuery("#data_uri").on("click", function () {
    zip.generateAsync({type:"base64"}).then(function (base64) {
        window.location = "data:application/zip;base64," + base64;
    }, function (err) {
        jQuery("#data_uri").text(err);
    });
});
*/

}); 


//Count nb module V2

jQuery(".views-col").each(function(){
  var nbmodule = 0;
  var nbmodule = jQuery(this).find('p span span span span').length;
  console.log(nbmodule);
  if(nbmodule<=0 || nbmodule==1) {
  jQuery(this).find(".numberomodul").html(nbmodule + " Module");
  }else jQuery(this).find(".numberomodul").html(nbmodule + " Modules");
});




jQuery('p span span span span').click(function(){
jQuery('.node-content p span b').toggle();
});

jQuery('.js-form-item.form-item.js-form-type-textarea.form-item-field-descriptioncontent-0-value.js-form-item-field-descriptioncontent-0-value label').click(function(){

  jQuery('textarea#edit-field-descriptioncontent-0-value').toggle(1000);
  
  var add_description = (jQuery('.js-form-item.form-item.js-form-type-textarea.form-item-field-descriptioncontent-0-value.js-form-item-field-descriptioncontent-0-value label').text());
  if( add_description == "Add Description" ){
    jQuery('.js-form-item.form-item.js-form-type-textarea.form-item-field-descriptioncontent-0-value.js-form-item-field-descriptioncontent-0-value label').text('Description');
    jQuery('.js-form-item.form-item.js-form-type-textarea.form-item-field-descriptioncontent-0-value.js-form-item-field-descriptioncontent-0-value label').addClass('desactive-cursoraddcursort');
  }else{

jQuery('.js-form-item.form-item.js-form-type-textarea.form-item-field-descriptioncontent-0-value.js-form-item-field-descriptioncontent-0-value label').text('Add Description');
jQuery('.js-form-item.form-item.js-form-type-textarea.form-item-field-descriptioncontent-0-value.js-form-item-field-descriptioncontent-0-value label').removeClass('desactive-cursoraddcursort');

  }
});

/*


jQuery('p span span span span').click(function(){
    
   jQuery(this).toggleClass('active');
   jQuery(this+'b').addClass('sub-message');

   var elements = document.getElementsByClassName('sub-message');
   console.log(elements);
   jQuery('.node-content').find('.node-content p span b').toggleClass('arrow-animate');
   jQuery('.node-content').find('.node-content p span b').slideToggle(280);
});

*/



 // jQuery('a.addnewlocalisation').hide();
//  jQuery('.use-ajax').hide();
 // jQuery('#edit-field-localization-messagebody-wrapper').hide();
  //jQuery('#cke_edit-field-localization-messagebody-0-value').hide();
  //jQuery("a.add-module ").unbind('click');
  //jQuerys(".add-module").attr("disabled",true);
 // jQuery('.add-module , .use-ajax').hide();


  // jQuery('.name-profile-user').append('<p><iframe height="200" id="replytocomments" src="http://localhost/digitalcms9/en/comment/reply/node/539/field_localization_comments/17" title="replycomment" width="300"></iframe></p>')



  jQuery('option[value="_none"]').remove();
  jQuery('.entity-moderation-form .form-item label').html('');
  jQuery('form#node-localization-form div#edit-actions').append('<div class="tw-flex tw-items-center tw-jtw-ustify-center tw-mb-4 btn-group"><button class="btn btn-edit tw-bg-blue-700 tw-text-white hover:tw-bg-blue-700 hover:tw-text-white active tw-font-bold uppercase tw-text-sm tw-px-6 tw-py-3 tw-rounded-l tw-outline-none tw-focus:outline-none tw-mb-1 tw-ease-linear tw-transition-all tw-duration-150" type="button">Edit</button><button class="btn btn-preview tw-bg-blue-500 tw-text-white hover:tw-bg-blue-700 hover:tw-text-white tw-font-bold uppercase tw-text-sm tw-px-6 tw-py-3 tw-rounded-r outline-none tw-focus:outline-none tw-mb-1 tw-ease-linear transition-all duration-150" type="button">Preview</button></div>');

  jQuery('.simpler_quickedit_click.simpler_quickedit.quickedit-field').append("<i class='fas fa-pencil-alt editeur-conten'></i>");
/*
  let str=jQuery( "#edit-field-localization-channel option:selected" ).text();

  jQuery('#edit-field-localization-channel').change(function() {

    let channel=jQuery( "#edit-field-localization-channel option:selected" ).text();

    if(channel=="SMS"){
      
      jQuery('#edit-field-localization-messagebody-wrapper').hide();
      jQuery('#edit-field-localisation-message-wrapper').show();
     
     }else if(channel=="Whatsapp"){
      jQuery('#edit-field-localization-messagebody-wrapper').show();
      jQuery('#edit-field-localisation-message-wrapper').hide();

     }else if(channel=="Moodle"){
      jQuery('#edit-field-localization-messagebody-wrapper').show();
      jQuery('#edit-field-localisation-message-wrapper').hide();

     }else if(str=="Telegram"){
      jQuery('#edit-field-localization-messagebody-wrapper').show();
      jQuery('#edit-field-localisation-message-wrapper').hide();

     }else if(str=="Messenger"){
      jQuery('#edit-field-localization-messagebody-wrapper').show();
      jQuery('#edit-field-localisation-message-wrapper').hide();

     }else if(str=="IOGT"){
      jQuery('#edit-field-localization-messagebody-wrapper').show();
      jQuery('#edit-field-localisation-message-wrapper').hide();

     }else{
     
   //  console.log(str);
     }
});
*/
//Show add comment form

jQuery( "span.button-add-new-comment " ).click(function() {
  jQuery('section').show();
  jQuery('div#block-views-block-listcomments-block-1').addClass('add-height-block-comment')
});

/*
  let str = localStorage.getItem("channelVal");

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

 
 //content completion ----------------  

 //nombre de message traduit
var nombredemessagetraduit = parseInt((jQuery('div#block-views-block-completionnbtraduction-block-1 header').text()));

// console.log(nombredemessagetraduit);

 //total message
var totalmessage = parseInt((jQuery('div#block-views-block-completionnbmessage-block-1 header').text()));
 //console.log(totalmessage);

var nblangue = jQuery('.nombredelangue').length;
// console.log(nblangue);


 //Nombre de message restant a traduire
var restotranslate=totalmessage-nombredemessagetraduit;

if(isNaN(restotranslate)){restotranslate=0;}
//console.log(restotranslate);

 var pourcentage = nombredemessagetraduit*100/(totalmessage*nblangue);
 
 var pourcentagemyInt = parseInt(pourcentage);
 
//console.log(pourcentagemyInt);
 
 jQuery('.contentrestetotranslate').html(restotranslate +' '+'to translate');
 //jQuery('div#block-views-block-completionnbmessage-block-1 header').append('<h1> voici le pourcentage '+pourcentagemyInt +'<h1>')
 
 if(pourcentagemyInt >=100){
   jQuery('p.tw-font-bold.tw-text-5xl.tw-text-center.tw-my-3.tw-text-red-600.tw-translations-indicator').html(100+'%');
 //  console.log(pourcentagemyInt);
  }else  
 
 jQuery('p.tw-font-bold.tw-text-5xl.tw-text-center.tw-my-3.tw-text-red-600.tw-translations-indicator').html(pourcentagemyInt+'%');
 
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
   jQuery('p.tw-font-bold.tw-text-5xl.tw-text-center.tw-my-3.tw-text-red-600.tw-translations-indicator').html('0 %');
 }

 
 

 //Dasboard 

 let cours=(jQuery('div#block-views-block-cardnbcours-block-1 header').text());

 jQuery('span.rounded-full.text-white.badge.bg-teal-400.text-xs.Cours').html(cours);
 let messagesimpe=(jQuery('div#block-views-block-cardnbmessage-block-1 header').text());
 jQuery('span.rounded-full.text-white.badge.bg-teal-400.text-xs.Messages').html(messagesimpe);
 let messagesimpetranslate=(jQuery('div#block-views-block-cardnbmessagetranslated-block-1 header').text());
 jQuery('span.rounded-full.text-white.badge.bg-teal-400.text-xs.Messagestranslated').html(messagesimpetranslate);

 var nblangueused = jQuery('#block-views-block-cardnblangue-block-1 h3 a').length;
 jQuery('span.rounded-full.text-white.badge.bg-red-400.text-xs.Module').html(nblangueused);

let totalenombremessagelocalized = jQuery('div#block-views-block-cardnbmessagelocalized-block-1 header').text();

locationRate = parseInt((totalenombremessagelocalized *100 )/(messagesimpe * nblangueused));
jQuery('span.rounded-full.text-white.badge.bg-teal-400.text-xs.Messagestranslated').html(locationRate+'%');

//console.log(totalenombremessagelocalized);





//disable draft status when adding localization
jQuery('#edit-moderation-state-0-state').hide();  
jQuery('label[for="edit-moderation-state-0-state"]').hide();

// EDIT AND PREVIEW BUTTON

// When click on edit button

jQuery(".btn-group > .btn-edit").click(function(){

   jQuery(this).removeClass("tw-bg-blue-500");
   jQuery(this).addClass("tw-bg-blue-700");
   jQuery(".btn-group > .btn-preview").removeClass("tw-bg-blue-700");
   jQuery(".btn-group > .btn-preview").addClass("tw-bg-blue-500");

   jQuery(".btn-group > .btn-preview").removeClass("active");
   jQuery('#cke_edit-field-localization-messagebody-0-value').show();
   jQuery('.channelgenerategeneral').remove();

   jQuery(".btn-group > .btn-edit").prop('disabled', true);
   jQuery(".btn-group > .btn-preview").prop('disabled', false);
   //jQuery('#edit-field-localization-channel').prop('disabled', false);

   jQuery('#edit-field-localization-langue, #edit-field-localization-channel').show();
   jQuery('label[for="edit-field-localization-langue"], label[for="edit-field-localization-channel"]').show();


});

// When click on preview button
jQuery(".btn-group > .btn-preview").click(function(){

   // recuperer le contenu de ckeditor
   var description = CKEDITOR.instances['edit-field-localization-messagebody-0-value'].getData();
 
   jQuery(this).removeClass("tw-bg-blue-500");
   jQuery(this).addClass("tw-bg-blue-700");
   jQuery(".btn-group > .btn-edit").removeClass("tw-bg-blue-700"); 
   jQuery(".btn-group > .btn-edit").addClass("tw-bg-blue-500");

   jQuery('label[for="edit-field-localization-messagebody-0-value"]').hide();
   jQuery('#cke_edit-field-localization-messagebody-0-value').hide();
   //jQuery('#edit-field-localization-channel').prop('disabled', true);
   //jQuery('#edit-field-localization-channel').hide();
   //jQuery('#edit-field-localization-langue').hide();

   jQuery('#edit-field-localization-langue, #edit-field-localization-channel').hide();
   jQuery('label[for="edit-field-localization-langue"], label[for="edit-field-localization-channel"]').hide();
   

   jQuery(".btn-group > .btn-edit").prop('disabled', false);
   jQuery(".btn-group > .btn-preview").prop('disabled', true);
if(jQuery('#edit-field-localization-channel').find(":selected").text()=="SMS"){
  jQuery( '<div class="channelgenerategeneral"> <div class="channelgenerate sms" id="sms"><i class="fas fa-sms"></i>SMS</div> </div>').insertAfter('#edit-field-localization-channel');
}else if (jQuery('#edit-field-localization-channel').find(":selected").text()=="Whatsapp"){
  jQuery( '<div class="channelgenerategeneral"><div class="channelgenerate whatsapp"><i class="fab fa-whatsapp"></i>WHATSAPP</div> </div>').insertAfter('#edit-field-localization-channel');
}else if(jQuery('#edit-field-localization-channel').find(":selected").text()=="Telegram"){
  jQuery( '<div class="channelgenerategeneral"><div class="channelgenerate telegrame"><i class="fab fa-telegram"></i>TELEGRAM</div> </div>').insertAfter('#edit-field-localization-channel');
}else if(jQuery('#edit-field-localization-channel').find(":selected").text()=="Messenger"){
  jQuery( '<div class="channelgenerategeneral"><div class="channelgenerate messanger"><i class="fab fa-facebook-messenger"></i>MESSENGER</div> </div>').insertAfter('#edit-field-localization-channel');
}else if(jQuery('#edit-field-localization-channel').find(":selected").text()=="Moodle"){
  jQuery( '<div class="channelgenerategeneral"><div class="channelgenerate moodle"><i class="fas fa-graduation-cap"></i>MOODLE</div> </div>').insertAfter('#edit-field-localization-channel');
}else if(jQuery('#edit-field-localization-channel').find(":selected").text()=="IOGT"){
  jQuery( '<div class="channelgenerategeneral"><div class="channelgenerate moodle"><i class="fas fa-graduation-cap"></i>IOGT</div></div>').insertAfter('#edit-field-localization-channel');
}

jQuery('.channelgenerate ').append(description);

});

 //-------------- Preview button befor adding content

//FUNCTIONS  AND Var
            //Fonction calcul nombre doccurance du titre h1
            function countOccurences(string, word) {
              return string.split(word).length-1;
            }

            // Function that verify if balise existe in liste 

            function checkTitleValue(value,arr){
              var status = 'Not exist';

              for(var i=0; i<arr.length; i++){
                var name = arr[i];
                if(name == value){
                  status = 'Exist';
                  arr .splice(i,1);
                  break;
                }
              }
              return status;
            }
            //  some variables
            var position = 1;

// IMPL

//on change input title  


jQuery("input#edit-title-0-value").on('change',function(e){

 // jQuery('.tilteconteValue').remove();
  tilteconteValue = jQuery(this).val();

  jQuery('.tilteconteValue').html(tilteconteValue);
// 
});


jQuery(" textarea#edit-field-descriptioncontent-0-value ").on('change',function(e){
 // jQuery('.DescriptioncontentValue').remove();

  DescriptioncontentValue = jQuery(this).val();
 jQuery('.DescriptioncontentValue').html('<div class="description-preview">Description</div> <br>'+ DescriptioncontentValue + '<div class="separateur-whenwehavedescrip"></div>');



});

/*
jQuery(".node-content-form").ready(function() {
 jQuery('input#edit-title-0-value').on('change',function(e){
    console.log('change in the input')
    var title_content = jQuery("input#edit-title-0-value").val();
    console.log(title_content);
  });
  });

  */


// When we are on the page that contain ckeditor we start the listener to get changes 

jQuery(".node-content-form").ready(function() {
CKEDITOR.instances['edit-body-0-value'].on('change',function(e){
  
  jQuery('.btn-preview-addcontent').prop('disabled', false);
  jQuery('.messageduformat-texteformat').remove();
  jQuery('.node-content-form input#edit-submit').prop('disabled', true);
  var description2 = CKEDITOR.instances['edit-body-0-value'].getData();
  jQuery(".contentent-preview-good-format").html(description2);
 
  //find all elemtent in the Ckeditor
// console.log(description2);
  var res = description2.substring(0, 3);
  if(res == "<h1" || res == "<h2" || res == "<h3" || res == "<h4" || res == "<h5" || res == "<h6" ){
    // activation du button submit
    jQuery('.node-content-form input#edit-submit').prop('disabled', false);
  }else {
    // Desactivation du button submit
    jQuery('.node-content-form input#edit-submit').prop('disabled', true);
    jQuery( '<div class="messageduformat-texteformat">😬 Oups !  Please review the format of the content.  Heading for Modules  and  Submodules  Normal For messages  </div>').insertBefore('.node-content-form div#edit-actions #edit-submit');

    //jQuery( '<div class="channelgenerategeneral"> <div class="channelgenerate sms" id="sms"><i class="fa fa-book"></i>😬 Oups ! <br> Please review the formatting of the content.  <br> H1 for Modules  <br> H2 or H3 for Submodules <br> Normal For messages</div> </div>').insertBefore('#edit-title-wrapper');
  }
  console.log("ckeditor on change");
});
});

// When we click on preview button
jQuery(".btn-groupOnAddContent > .btn-preview").click(function(){


//appel api 
const res = await fetch("http://0.0.0.0:5000/translate", {
	method: "POST",
	body: JSON.stringify({
		q: description2,
		source: "fr",
		target: "en",
		format: "text"
	}),
	headers: { "Content-Type": "application/json" }
});

console.log(await res.json());

});



  var title_arr = ['<h1','<h2','<h3','<h4','<h5','<h6'];
  
// remove alerte message befor all
jQuery('.channelgenerategeneral').remove();

// New implementation with the object

//Get data from ckeditor textarea
var description2 = CKEDITOR.instances['edit-body-0-value'].document.getBody().getHtml();

//console.log("Data" +description2);
var html = jQuery.parseHTML(description2);

console.log(html);

jQuery.each(html, function(key,valueObj){

if(key == 0){
  var toptitleLevel1 = valueObj;
  var tagtoptitleLevel1 = valueObj.nodeName;
}
if(key == 1){
  var toptitleLevel2 = valueObj;
  var tagtoptitleLevel = valueObj.nodeName;
}
});


/*
//get first 3 chars from first line
var TitletagTopLevel = description2.substring(0, 3);
console.log("Tag title Level 1" + TitletagTopLevel);

console.log("---------");

//After getting tag from first line, verify if 
if(checkTitleValue(TitletagTopLevel, title_arr)=='Exist'){

var tagTopLevelEnd = ["</"+ TitletagTopLevel.slice(position)+">"];

console.log("new value to search" + tagTopLevelEnd);

  //on enleve la premiere ligne qui se termie par un h1 puis mnous enleveons les epaces du reste d string
  var res2 = jQuery.trim(description2.substr(description2.indexOf(tagTopLevelEnd) + 5));
  console.log(res2);

  //----------End first test 

  // ---------Start second test 

console.log("---------Start second test ");

  //get first 3 chars from Second line
var TitletagTopLevel2 = res2.substring(0, 3);
console.log("Tag title level 2" + TitletagTopLevel2);
console.log("---------");
if(checkTitleValue(TitletagTopLevel2, title_arr)=='Exist'){

  var tagTopLevel2End = ["</"+ TitletagTopLevel2.slice(position)+">"];
  
  console.log("new tag to search" + tagTopLevel2End);
  
    //on enleve la premiere ligne qui se termie par un h1 puis mnous enleveons les epaces du reste d string
    var res3 = jQuery.trim(res2.substr(res2.indexOf(tagTopLevel2End) + 5));
    console.log(res3);


  //----------End second test 

  // ---------Start third test 

  console.log("---------Start third test ");

  //get first 3 chars from third line
var TitletagTopLevel3 = res3.substring(0, 3);
console.log("Tag title level 3" + TitletagTopLevel3);
console.log("---------");
if(checkTitleValue(TitletagTopLevel3, title_arr)=='Exist'){

  var tagTopLevel3End = ["</"+ TitletagTopLevel3.slice(position)+">"];
  
  console.log("new tag to search" + tagTopLevel3End);

  //on enleve la deuxieme ligne qui se termie par un p puis mnous enleveons les epaces du reste d string
  var res4 = jQuery.trim(res3.substr(res3.indexOf(tagTopLevel3End) + 5));
  console.log(res4);

}else{
  console.log("This tag is already used");
  // Desactivation du button submit
  jQuery('.node-content-form input#edit-submit').prop('disabled', true);
  jQuery( '<div class="channelgenerategeneral"> <div class="channelgenerate sms" id="sms"><i class="fa fa-book"></i>😬 Oups ! <br> Please review the formatting of the content.  <br> H1 for Modules  <br> H2 or H3 for Submodules <br> Normal For messages</div> </div>').insertBefore('#edit-title-wrapper');


}

}else{
  console.log("This tag is already used");
  // Desactivation du button submit
  jQuery('.node-content-form input#edit-submit').prop('disabled', true);
  jQuery( '<div class="channelgenerategeneral"> <div class="channelgenerate sms" id="sms"><i class="fa fa-book"></i>😬 Oups ! <br> Please review the formatting of the content.  <br> H1 for Modules  <br> H2 or H3 for Submodules <br> Normal For messages</div> </div>').insertBefore('#edit-title-wrapper');


}
// activation du button submit
jQuery('.node-content-form input#edit-submit').prop('disabled', false);


}else if(checkTitleValue(TitletagTopLevel, title_arr)=='Not exist'){

  console.log("This tag is already used");
  // Desactivation du button submit
  jQuery('.node-content-form input#edit-submit').prop('disabled', true);
  jQuery( '<div class="channelgenerategeneral"> <div class="channelgenerate sms" id="sms"><i class="fa fa-book"></i>😬 Oups ! <br> Please review the formatting of the content.  <br> H1 for Modules  <br> H2 or H3 for Submodules <br> Normal For messages</div> </div>').insertBefore('#edit-title-wrapper');


}
//Count the number of title and display alerte if none
//var countNbTitre=countOccurences(description2,"<h1");


*/



/*
// verify if the first balise is a title H1 H2 H3 H4 H5 or H6

  if(TitletagTopLevel == "<h1" || TitletagTopLevel == "<h2" || TitletagTopLevel == "<h3" || TitletagTopLevel == "<h4" || TitletagTopLevel == "<h5" || TitletagTopLevel == "<h6" ){
    //on enleve la premiere lige qui se termie par un h1 puis mnous enleveon sles epaces du reste d string
    var res2 = jQuery.trim(description2.substr(description2.indexOf("</h1>") + 5));
    console.log(res2);

    //get first 3 chars de la deuxieme ligne 
    var res3 = res2.substring(0, 3);
    console.log(res3);

    console.log("---------");

    //on enleve la deuxieme ligne qui se termie par un h2 puis mnous enleveons les epaces du reste d string
    var res4 = jQuery.trim(res2.substr(res2.indexOf("</h2>") + 5));
    console.log(res4);

    //get first 3 chars de la troisieme ligne
    var res5 = res4.substring(0, 3);
    console.log(res5);
    
    console.log("---------");

    // activation du button submit
    jQuery('.node-content-form input#edit-submit').prop('disabled', false);

    // 
  }else {
    // Desactivation du button submit
    jQuery('.node-content-form input#edit-submit').prop('disabled', true);
    jQuery( '<div class="Oups-message-addconten"> <div class="Oups-message-1 addcontenmessage" id="Oups-message-addcontent"><i class="fa fa-close"></i>😬 Oups ! <br> Please review the formatting of the content.  <br> H1 for Modules  <br> H2 or H3 for Submodules <br> Normal For messages</div> </div>').insertBefore('#edit-title-wrapper');
    jQuery('body').addClass('pop-pup-oups');

    //jQuery( '<div class="channelgenerategeneral"> <div class="channelgenerate sms" id="sms"><i class="fa fa-book"></i>😬 Oups ! <br> Please review the formatting of the content.  <br> H1 for Modules  <br> H2 or H3 for Submodules <br> Normal For messages</div> </div>').insertBefore('#edit-title-wrapper');
}
*/

  //get the type of the data 
  //var typecontent = jQuery.type(description2);

  // research balise for content validation 

 // var findh = description2.match("h1");




jQuery( '<div class="channelgenerategeneral"> <div class="channelgenerate sms" id="sms"><i class="fa fa-book"></i>Content preview</div> </div>').insertBefore('#edit-title-wrapper');

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
 jQuery('span.message-langage.pstStatusModeration').addClass('back-rejected')

 
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
     jQuery('span.expandalle-minimizeall-button.cursor-pointer').click(function() {
     jQuery('.node-content p span b').toggle();
     var expand = (jQuery('span.expandalle-minimizeall-button.cursor-pointer').text());
     expand == "Expand all" ?  jQuery('span.expandalle-minimizeall-button.cursor-pointer').text('Minimize')  : jQuery('span.expandalle-minimizeall-button.cursor-pointer').text('Expand all')
     
      
    //  else jQuery('.use-ajax').toggle()
     
   //  expand == "Minimize" ? jQuery('.use-ajax').hide() : jQuery('.use-ajax').show()
     });
 

 
  jQuery('span.tw-switch-editing-button.tw-rounded.border.tw-border-green-500.tw-px-5.py-2.tw-text-green-700.tw-text-sm.tw-cursor-pointer').click(function(){
 
   jQuery('.tw-switch-editing-button').toggleClass( 'turneditone' );
   jQuery('a.addnewlocalisation').toggleClass('afficher-add-new-localistion');
   jQuery('a.detaillebody').toggleClass('addnewlocalisationcacher');
   jQuery('a.btn').toggle();
   jQuery('.add-module').toggleClass('add-module-enable');
 
   var turneoff = (jQuery('.tw-switch-editing-button').text());
   var expand = (jQuery('.expandall-minimizeall-button').text());
  // jQuery('.add-module , .use-ajax ').toggle();
   //jQuery('.use-ajax ').toggle();
   jQuery('.blockmodule-titre-module').toggleClass('blockmodule-titre-module-expland');
  jQuery('.tw-switch-editing-button').toggleClass('colore-turne-edite')
 
 turneoff == "Turn editing on" ?  jQuery('.tw-switch-editing-button').text('Turn editing off') : jQuery('.tw-switch-editing-button').text('Turn editing on');
  });

var notefounddasbord =(jQuery('div#block-tailwindcss-content').text());
notefounddasbord == " The requested page could not be found. " ? jQuery('div#block-tailwindcss-content').text(''): jQuery('div#block-tailwindcss-content').removeClass('hidenotefoundasbord');
  
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
 //jQuery('a.use-ajax').prepend('<i class="fas fa-plus-square"></i>');
 jQuery('.views-view-grid.horizontal.cols-4.clearfix .views-row').last().append('<div class="views-col col-1 addcourse-blank" style="width: 25%;"><div class="views-field views-field-nothing"><span class="field-content"><div class=" tw-item-card "><a href="node/add/course_" class="addcoursebutton" tabindex="-1">Add Content</a></div></div> ');
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




