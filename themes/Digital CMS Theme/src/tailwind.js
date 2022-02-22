jQuery("#block-views-block-contenttotranslate-block-1").ready(function(){




var textToTranslate = jQuery(".bodyContentToTranslate").html();
  console.log(textToTranslate);
  var titletotranslate = jQuery(".initial-title a").text();
  var descriptiontotranslate = jQuery(".section-initial-content p").text();

  //console.log("description a traduire " + descriptiontotranslate);

// Start function
const starttranslate = async function(a, b,c) {

  const res = await fetch("http://0.0.0.0:5000/translate", {
    method: "POST",
     body: JSON.stringify({
       q: a,
       source: b,
       target: c,
       format: "html"
     }),
     headers: { "Content-Type": "application/json" }
   });
   
   var obj = await res.json();

   var resultgood  = (obj.translatedText);

   CKEDITOR.instances['edit-field-localization-messagebody-0-value'].setData(resultgood);
  // console.log(resultgood);
}

const trabslatetitle = async function(at,bt,ct) {

  const res = await fetch("http://0.0.0.0:5000/translate", {
    method: "POST",
     body: JSON.stringify({
       q: at,
       source: bt,
       target: ct,
       format: "html"
     }),
     headers: { "Content-Type": "application/json" }
   });
   
   var objt = await res.json();

   var titlegood  = (objt.translatedText);
  
   
   jQuery("#edit-field-titre-content-0-value").val(titlegood);
   //console.log(titlegood);
}

const translatedesc = async function(ad,bd,cd) {

  const res = await fetch("http://0.0.0.0:5000/translate", {
    method: "POST",
     body: JSON.stringify({
       q: ad,
       source: bd,
       target: cd,
       format: "html"
     }),
     headers: { "Content-Type": "application/json" }
   });
   
   var objd = await res.json();

   var descgood  = (objd.translatedText);
  
   
   jQuery("#edit-field-descriptino-content-0-value").val(descgood);
   //console.log(descgood);
}


// Default translation 
jQuery("#edit-field-titre-content-0-value, #edit-field-descriptino-content-0-value").val("Translating.........");
CKEDITOR.instances['edit-field-localization-messagebody-0-value'].setData("Translatin........");
starttranslate(textToTranslate, "auto", "fr");
trabslatetitle(titletotranslate, "auto", "fr");
translatedesc(descriptiontotranslate, "auto", "fr");


// Translation when we click on selected lanague 
document.getElementById('edit-field-localization-langue').addEventListener('change', function() {
    var e = document.getElementById("edit-field-localization-langue");
    var text = e.options[e.selectedIndex].text;
    jQuery("#edit-field-titre-content-0-value, #edit-field-descriptino-content-0-value").val("Translating.........");
    CKEDITOR.instances['edit-field-localization-messagebody-0-value'].setData("Translatin........");
    if(text=="Espagnol"){

      starttranslate(textToTranslate, "auto", "es");
      trabslatetitle(titletotranslate, "auto", "es");
      translatedesc(descriptiontotranslate, "auto", "es");
    }else if(text=="Arabic"){
      starttranslate(textToTranslate, "auto", "ar");
      trabslatetitle(titletotranslate, "auto", "ar");
translatedesc(descriptiontotranslate, "auto", "ar");
    }else if(text=="Anglais"){
      starttranslate(textToTranslate, "auto", "en");
      trabslatetitle(titletotranslate, "auto", "en");
translatedesc(descriptiontotranslate, "auto", "en");
    }else if(text=="Chinois"){
      starttranslate(textToTranslate, "auto", "zh");
      trabslatetitle(titletotranslate, "auto", "zh");
translatedesc(descriptiontotranslate, "auto", "zh");
    }

    console.log('You selected: ', text);
});





});





jQuery(document).ready(function () {
  jQuery('textarea#edit-field-descriptioncontent-0-value').hide()
  jQuery('.js-form-item.form-item.js-form-type-textarea.form-item-field-descriptioncontent-0-value.js-form-item-field-descriptioncontent-0-value label').html('Add Description')
  jQuery('.blockmodule-submodule').hide();
  jQuery('a.btn').hide();
  jQuery('section').hide();
  jQuery('<div class="live-preveiw-section "> <div class="livepreview-content"> Live preview  Content </div> <div class="tilteconteValue" ></div> <div class="DescriptioncontentValue"></div> <div class="contentent-preview-good-format">  </div> </div>').insertBefore('form#node-content-form');
  //hide submodule and message content 
  jQuery('.node-content p span b').hide();
  jQuery('.node-content-form input#edit-submit').prop('disabled', true);
  jQuery('<span class="button-add-new-comment">Add a new comment</span>').insertBefore('section');
  jQuery('.node-content p:nth-child(1)').insertBefore('.node-content p:nth-child(1)');





  





  //Download files and archive them in to a zipfile

  //The FileSaver API
  jQuery(".downloadzipfile").click(function () {
    console.log("Salut jszip");
    var zip = new JSZip();
    zip.file("Hello.txt", "Hello World\n");
    var img = zip.folder("images");
    img.file("smile.gif", imgData, { base64: true });
    zip.generateAsync({ type: "blob" })
      .then(function (content) {
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

  jQuery(".views-col").each(function () {
    var nbmodule = 0;
    var nbmodule = jQuery(this).find('.tw-item-card h1').length - 1;
    //console.log(nbmodule);
    if (nbmodule <= 0 || nbmodule == 1) {
      jQuery(this).find(".numberomodul").html(nbmodule + " Module");
    } else jQuery(this).find(".numberomodul").html(nbmodule + " Modules");
  });




    jQuery('p span span span span').click(function () {
    jQuery('.node-content p span b').toggle();
  });

  //Hide and show add description

  jQuery('.js-form-item.form-item.js-form-type-textarea.form-item-field-descriptioncontent-0-value.js-form-item-field-descriptioncontent-0-value label').click(function () {

    jQuery('textarea#edit-field-descriptioncontent-0-value').toggle(1000);

    var add_description = (jQuery('.js-form-item.form-item.js-form-type-textarea.form-item-field-descriptioncontent-0-value.js-form-item-field-descriptioncontent-0-value label').text());
    if (add_description == "Add Description") {
      jQuery('.js-form-item.form-item.js-form-type-textarea.form-item-field-descriptioncontent-0-value.js-form-item-field-descriptioncontent-0-value label').text('Description');
      jQuery('.js-form-item.form-item.js-form-type-textarea.form-item-field-descriptioncontent-0-value.js-form-item-field-descriptioncontent-0-value label').addClass('desactive-cursoraddcursort');
    } else {

      jQuery('.js-form-item.form-item.js-form-type-textarea.form-item-field-descriptioncontent-0-value.js-form-item-field-descriptioncontent-0-value label').text('Add Description');
      jQuery('.js-form-item.form-item.js-form-type-textarea.form-item-field-descriptioncontent-0-value.js-form-item-field-descriptioncontent-0-value label').removeClass('desactive-cursoraddcursort');

    }
  });

  jQuery('option[value="_none"]').remove();
  jQuery('.entity-moderation-form .form-item label').html('');
  jQuery('form#node-localization-form div#edit-actions').append('<div class="tw-flex tw-items-center tw-jtw-ustify-center tw-mb-4 btn-group"><button class="btn btn-edit tw-bg-blue-700 tw-text-white hover:tw-bg-blue-700 hover:tw-text-white active tw-font-bold uppercase tw-text-sm tw-px-6 tw-py-3 tw-rounded-l tw-outline-none tw-focus:outline-none tw-mb-1 tw-ease-linear tw-transition-all tw-duration-150" type="button">Edit</button><button class="btn btn-preview tw-bg-blue-500 tw-text-white hover:tw-bg-blue-700 hover:tw-text-white tw-font-bold uppercase tw-text-sm tw-px-6 tw-py-3 tw-rounded-r outline-none tw-focus:outline-none tw-mb-1 tw-ease-linear transition-all duration-150" type="button">Preview</button></div>');
  jQuery('.simpler_quickedit_click.simpler_quickedit.quickedit-field').append("<i class='fas fa-pencil-alt editeur-conten'></i>");
  
  //Show add comment form

  jQuery("span.button-add-new-comment ").click(function () {
    jQuery('section').show();
    jQuery('div#block-views-block-listcomments-block-1').addClass('add-height-block-comment')
  });

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
  var restotranslate = totalmessage - nombredemessagetraduit;

  if (isNaN(restotranslate)) { restotranslate = 0; }
  //console.log(restotranslate);

  var pourcentage = nombredemessagetraduit * 100 / (totalmessage * nblangue);

  var pourcentagemyInt = parseInt(pourcentage);

  //console.log(pourcentagemyInt);

  jQuery('.contentrestetotranslate').html(restotranslate + ' ' + 'to translate');
  //jQuery('div#block-views-block-completionnbmessage-block-1 header').append('<h1> voici le pourcentage '+pourcentagemyInt +'<h1>')

  if (pourcentagemyInt >= 100) {
    jQuery('p.tw-font-bold.tw-text-5xl.tw-text-center.tw-my-3.tw-text-red-600.tw-translations-indicator').html(100 + '%');
    //  console.log(pourcentagemyInt);
  } else

    jQuery('p.tw-font-bold.tw-text-5xl.tw-text-center.tw-my-3.tw-text-red-600.tw-translations-indicator').html(pourcentagemyInt + '%');

  if (pourcentagemyInt >= 33) {
    jQuery('p.tw-font-bold.tw-text-5xl.tw-text-center.tw-my-3.tw-text-red-600.tw-translations-indicator').addClass('colo-midle');
    jQuery('p.tw-rounded.tw-bg-red-100.tw-border.tw-border-red-500.tw-text-gray-800.p-1').addClass('coloremidel');
  }
  if (pourcentagemyInt >= 100) {

    jQuery('p.tw-font-bold.tw-text-5xl.tw-text-center.tw-my-3.tw-text-red-600.tw-translations-indicator').addClass('colo-midlegr');
    jQuery('p.tw-rounded.tw-bg-red-100.tw-border.tw-border-red-500.tw-text-gray-800.p-1').addClass('coloremidelgr');
    jQuery('p.tw-rounded.tw-bg-red-100.tw-border.tw-border-red-500.tw-text-gray-800.p-1').html('This course has been fully translated');
    jQuery('p.tw-my-2.tw-text-center.tw-text-gray-500 span.contentrestetotranslate').html('');
  }

  if ((jQuery('p.tw-font-bold.tw-text-5xl.tw-text-center.tw-my-3.tw-text-red-600.tw-translations-indicator').text()) == 'NaN%') {
    jQuery('p.tw-font-bold.tw-text-5xl.tw-text-center.tw-my-3.tw-text-red-600.tw-translations-indicator').html('0 %');
  }




  //Dasboard 

  let cours = (jQuery('div#block-views-block-cardnbcours-block-1 header').text());

  jQuery('span.rounded-full.text-white.badge.bg-teal-400.text-xs.Cours').html(cours);
  let messagesimpe = (jQuery('div#block-views-block-cardnbmessage-block-1 header').text());
  jQuery('span.rounded-full.text-white.badge.bg-teal-400.text-xs.Messages').html(messagesimpe);
  let messagesimpetranslate = (jQuery('div#block-views-block-cardnbmessagetranslated-block-1 header').text());
  jQuery('span.rounded-full.text-white.badge.bg-teal-400.text-xs.Messagestranslated').html(messagesimpetranslate);

  var nblangueused = jQuery('#block-views-block-cardnblangue-block-1 h3 a').length;
  jQuery('span.rounded-full.text-white.badge.bg-red-400.text-xs.Module').html(nblangueused);

  let totalenombremessagelocalized = jQuery('div#block-views-block-cardnbmessagelocalized-block-1 header').text();

  locationRate = parseInt((totalenombremessagelocalized * 100) / (messagesimpe * nblangueused));
  jQuery('span.rounded-full.text-white.badge.bg-teal-400.text-xs.Messagestranslated').html(locationRate + '%');

  //console.log(totalenombremessagelocalized);





  //disable draft status when adding localization
  jQuery('#edit-moderation-state-0-state').hide();
  jQuery('label[for="edit-moderation-state-0-state"]').hide();

  // EDIT AND PREVIEW BUTTON

  // When click on edit button

  jQuery(".btn-group > .btn-edit").click(function () {

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
  jQuery(".btn-group > .btn-preview").click(function () {

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
    if (jQuery('#edit-field-localization-channel').find(":selected").text() == "SMS") {
      jQuery('<div class="channelgenerategeneral"> <div class="channelgenerate sms" id="sms"><i class="fas fa-sms"></i>SMS</div> </div>').insertAfter('#edit-field-localization-channel');
    } else if (jQuery('#edit-field-localization-channel').find(":selected").text() == "Whatsapp") {
      jQuery('<div class="channelgenerategeneral"><div class="channelgenerate whatsapp"><i class="fab fa-whatsapp"></i>WHATSAPP</div> </div>').insertAfter('#edit-field-localization-channel');
    } else if (jQuery('#edit-field-localization-channel').find(":selected").text() == "Telegram") {
      jQuery('<div class="channelgenerategeneral"><div class="channelgenerate telegrame"><i class="fab fa-telegram"></i>TELEGRAM</div> </div>').insertAfter('#edit-field-localization-channel');
    } else if (jQuery('#edit-field-localization-channel').find(":selected").text() == "Messenger") {
      jQuery('<div class="channelgenerategeneral"><div class="channelgenerate messanger"><i class="fab fa-facebook-messenger"></i>MESSENGER</div> </div>').insertAfter('#edit-field-localization-channel');
    } else if (jQuery('#edit-field-localization-channel').find(":selected").text() == "Moodle") {
      jQuery('<div class="channelgenerategeneral"><div class="channelgenerate moodle"><i class="fas fa-graduation-cap"></i>MOODLE</div> </div>').insertAfter('#edit-field-localization-channel');
    } else if (jQuery('#edit-field-localization-channel').find(":selected").text() == "IOGT") {
      jQuery('<div class="channelgenerategeneral"><div class="channelgenerate moodle"><i class="fas fa-graduation-cap"></i>IOGT</div></div>').insertAfter('#edit-field-localization-channel');
    }

    jQuery('.channelgenerate ').append(description);

  });





/* Fonction calcul nombre doccurance du titre h1 
  function countOccurences(string, word) {
    return string.split(word).length - 1;
  }
  */

  //on change input title   & description
  jQuery("input#edit-title-0-value").on('change', function (e) {

    // jQuery('.tilteconteValue').remove();
    tilteconteValue = jQuery(this).val();
    jQuery('.tilteconteValue').html(tilteconteValue);
    // 
  });
  jQuery(" textarea#edit-field-descriptioncontent-0-value ").on('change', function (e) {
    // jQuery('.DescriptioncontentValue').remove();
    DescriptioncontentValue = jQuery(this).val();
    jQuery('.DescriptioncontentValue').html('<div class="description-preview">Description</div> <br>' + DescriptioncontentValue + '<div class="separateur-whenwehavedescrip"></div>');
  });



  // detecte change in CKeditor
  jQuery(".node-content-form").ready(function () {
    CKEDITOR.instances['edit-body-0-value'].on('change', function (e) {
      jQuery('.messageduformat-texteformat').remove();
      jQuery('.node-content-form input#edit-submit').prop('disabled', true);
      var description2 = CKEDITOR.instances['edit-body-0-value'].getData();
      jQuery(".contentent-preview-good-format").html(description2);

      //find all elemtent in the Ckeditor
      // console.log(description2);
      var res = description2.substring(0, 3);
      if (res == "<h1" || res == "<h2" || res == "<h3" || res == "<h4" || res == "<h5" || res == "<h6") {
        // activation du button submit
        jQuery('.node-content-form input#edit-submit').prop('disabled', false);
      } else {
        // Desactivation du button submit
        jQuery('.node-content-form input#edit-submit').prop('disabled', true);
        jQuery('<div class="messageduformat-texteformat">😬 Oups !  Please review the format of the content.  Heading for Modules  and  Submodules  Normal For messages  </div>').insertBefore('.node-content-form div#edit-actions #edit-submit'); }
    });
  });

  //MANAGE MODERATION STATE
  var moderationstate = jQuery.trim(jQuery('.entity-moderation-form__item div#edit-current').text());

  jQuery('<span class="message-langage pstStatusModeration">' + moderationstate + '</span>').insertBefore('form#content-moderation-entity-moderation-form');

  if (moderationstate == "Draft") {
    jQuery('a.moderationStateButton.sforreview').remove();
    jQuery('a.moderationStateButton.approve').remove();
    jQuery('a.moderationStateButton.reject').remove();
    jQuery('a.moderationStateButton.rsubmit').remove();
    jQuery('a.moderationStateButton.submit').addClass('submitpositionleft');


  }

  if (moderationstate == 'Submit for review') {
    jQuery('a.moderationStateButton.submit').remove();
    jQuery('a.moderationStateButton.sforreview').remove();
    jQuery('a.moderationStateButton.rsubmit').remove();
    jQuery('a.moderationStateButton.submit').addClass('submitpositionleft');

  }

  if (moderationstate == 'Rejected') {
    jQuery('a.moderationStateButton.sforreview').remove();
    jQuery('a.moderationStateButton.submit').remove();
    jQuery('a.moderationStateButton.approve').remove();
    jQuery('a.moderationStateButton.reject').remove();
    jQuery('span.message-langage.pstStatusModeration').addClass('back-rejected')


  }

  if (moderationstate == '') {
    jQuery('a.moderationStateButton.sforreview').remove();
    jQuery('a.moderationStateButton.submit').remove();
    jQuery('a.moderationStateButton.approve').remove();
    jQuery('a.moderationStateButton.reject').remove();
    jQuery('a.moderationStateButton.rsubmit').remove();
  }





  // Click On moderation State button function______________________________________________________

  // +Submit content for review

  jQuery('a.moderationStateButton.submit').click(function () {
    //alert('submit content for reveiw');
    jQuery('option[value="ready_for_review"]').prop('selected', true);
    jQuery("#edit-submit").click();


  });

  // +re submit 
  jQuery('a.moderationStateButton.rsubmit').click(function () {
    //alert('submit content for reveiw');
    jQuery('option[value="ready_for_review"]').prop('selected', true);
    jQuery("#edit-submit").click();


  });

  // +Approve content 
  jQuery('a.moderationStateButton.approve').click(function () {

    jQuery('option[value="published"]').prop('selected', true);
    jQuery("#edit-submit").click();

  });

  // +Reject content 
  jQuery('a.moderationStateButton.reject').click(function () {

    jQuery('option[value="needs_work"]').prop('selected', true);
    jQuery("#edit-submit").click();

  });

  // Expand switch for one single learning module  new
  jQuery('.blockmodule-titre-module').click(function () {
    //console.log(this);

    var moduleIndex = jQuery(this).index();

    jQuery('.blockmodule-submodule:eq(' + moduleIndex + ')').toggle(1000);

  });

  // Expand All 
  jQuery('span.expandalle-minimizeall-button.cursor-pointer').click(function () {
    jQuery('.node-content p span b').toggle(1000);
    var expand = (jQuery('span.expandalle-minimizeall-button.cursor-pointer').text());
    expand == "Expand all" ? jQuery('span.expandalle-minimizeall-button.cursor-pointer').text('Minimize') : jQuery('span.expandalle-minimizeall-button.cursor-pointer').text('Expand all')
  });



  jQuery('span.tw-switch-editing-button.tw-rounded.border.tw-border-green-500.tw-px-5.py-2.tw-text-green-700.tw-text-sm.tw-cursor-pointer').click(function () {

    jQuery('.tw-switch-editing-button').toggleClass('turneditone');
    jQuery('a.addnewlocalisation').toggleClass('afficher-add-new-localistion');
    jQuery('a.detaillebody').toggleClass('addnewlocalisationcacher');
    jQuery('a.btn').toggle(1000);
    jQuery('.add-module').toggleClass('add-module-enable');

    var turneoff = (jQuery('.tw-switch-editing-button').text());
    var expand = (jQuery('.expandall-minimizeall-button').text());
    jQuery('.blockmodule-titre-module').toggleClass('blockmodule-titre-module-expland');
    jQuery('.tw-switch-editing-button').toggleClass('colore-turne-edite')

    turneoff == "Turn editing on" ? jQuery('.tw-switch-editing-button').text('Turn editing off') : jQuery('.tw-switch-editing-button').text('Turn editing on');
  });

  var notefounddasbord = (jQuery('div#block-tailwindcss-content').text());
  notefounddasbord == " The requested page could not be found. " ? jQuery('div#block-tailwindcss-content').text('') : jQuery('div#block-tailwindcss-content').removeClass('hidenotefoundasbord');

  // jQuery('.a.use-ajax').hide();
  jQuery('<h1 class="titre-cms-translation"> CONTENT MANAGEMENT AND ADAPTATION PLATFORM </h1>').insertBefore('.js-form-item.form-item.js-form-type-textfield.form-item-name.js-form-item-name');
  jQuery('<i class="fa fa-fw fa-user"></i>').insertBefore('input#edit-name');
  jQuery('<i class="fa fa-fw fa-lock"></i>').insertBefore('input#edit-pass');
  //jQuery('a.use-ajax').prepend('<i class="fas fa-plus-square"></i>');
  jQuery('.views-view-grid.horizontal.cols-4.clearfix .views-row').last().append('<div class="views-col col-1 addcourse-blank" style="width: 25%;"><div class="views-field views-field-nothing"><span class="field-content"><div class=" tw-item-card "><a href="node/add/course_" class="addcoursebutton" tabindex="-1">Add Content</a></div></div> ');
  jQuery('#edit-name').attr('placeholder', '  Username');
  jQuery('#edit-pass').attr('placeholder', '  Password');
  jQuery('.dataTables_wrapper .dataTables_filter input').attr('placeholder', ' Search');

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
      backgroundColor: '#36B1B4',
      borderColor: '#36B1B4',
      //data: [ cours, modulesdecourse, messagesimpetranslate, modulesdecourse ],
      data: [10, 39, 50, 60]
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

  jQuery('.module-section').each(function () {

    var moduleIndexee = jQuery(this).index();


    jQuery(this).find('.blockmodule-titre-module span').html('Module ' + moduleIndexee + ':');

  });




  //


 // API AUTOMATIC TRANSLATION 






});

