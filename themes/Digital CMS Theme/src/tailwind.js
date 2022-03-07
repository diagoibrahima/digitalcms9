class XlsExport {
  // data: array of objects with the data for each row of the table
  // name: title for the worksheet
  constructor(data, title = 'Worksheet') {
    // input validation: new xlsExport([], String)
    if (!Array.isArray(data) || (typeof title !== 'string' || Object.prototype.toString.call(title) !== '[object String]')) {
      throw new Error('Invalid input types: new xlsExport(Array [], String)');
    }

    this._data = data;
    this._title = title;
  }

  set setData(data) {
    if (!Array.isArray(data)) throw new Error('Invalid input type: setData(Array [])');

    this._data = data;
  }

  get getData() {
    return this._data;
  }

  exportToXLS(fileName = 'export.xls') {
    if (typeof fileName !== 'string' || Object.prototype.toString.call(fileName) !== '[object String]') {
      throw new Error('Invalid input type: exportToCSV(String)');
    }

    const TEMPLATE_XLS = `
        <html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
        <meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8"/>
        <head><!--[if gte mso 9]><xml>
        <x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{title}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml>
        <![endif]--></head>
        <body>{table}</body></html>`;
    const MIME_XLS = 'application/vnd.ms-excel;base64,';

    const parameters = {
      title: this._title,
      table: this.objectToTable(),
    };
    const computeOutput = TEMPLATE_XLS.replace(/{(\w+)}/g, (x, y) => parameters[y]);

    const computedXLS = new Blob([computeOutput], {
      type: MIME_XLS,
    });
    const xlsLink = window.URL.createObjectURL(computedXLS);
    this.downloadFile(xlsLink, fileName);
  }

  exportToCSV(fileName = 'export.csv') {
    if (typeof fileName !== 'string' || Object.prototype.toString.call(fileName) !== '[object String]') {
      throw new Error('Invalid input type: exportToCSV(String)');
    }
    const computedCSV = new Blob([this.objectToSemicolons()], {
      type: 'text/csv;charset=utf-8',
    });
    const csvLink = window.URL.createObjectURL(computedCSV);
    this.downloadFile(csvLink, fileName);
  }

  downloadFile(output, fileName) {
    const link = document.createElement('a');
    document.body.appendChild(link);
    link.download = fileName;
    link.href = output;
    link.click();
  }

  toBase64(string) {
    return window.btoa(unescape(encodeURIComponent(string)));
  }

  objectToTable() {
    // extract keys from the first object, will be the title for each column
    const colsHead = `<tr>${Object.keys(this._data[0]).map(key => `<td>${key}</td>`).join('')}</tr>`;

    const colsData = this._data.map(obj => [`<tr>
                ${Object.keys(obj).map(col => `<td>${obj[col] ? obj[col] : ''}</td>`).join('')}
            </tr>`]) // 'null' values not showed
      .join('');

    return `<table>${colsHead}${colsData}</table>`.trim(); // remove spaces...
  }

  objectToSemicolons() {
    const colsHead = Object.keys(this._data[0]).map(key => [key]).join(';');
    const colsData = this._data.map(obj => [ // obj === row
      Object.keys(obj).map(col => [
        obj[col], // row[column]
      ]).join(';'), // join the row with ';'
    ]).join('\n'); // end of row

    return `${colsHead}\n${colsData}`;
  }
}

var hostname = window.location.hostname;
var protocol = window.location.protocol;

//export default XlsExport; // comment this line to babelize

jQuery("form#node-content-edit-form").ready( function(){
  var  valeuredit =jQuery("input#edit-title-0-value").val();
  //console.log(valeuredit)
  jQuery('.tilteconteValue').html(valeuredit);

  });

jQuery('#buttonstatusserver').click(function () {
   
    jQuery("#block-views-block-listserver-block-1 views-field views-field-field-etat").val("On");
});



// Appell API to get the url of the translation Server
  let url = protocol+"//"+hostname+"/serverconf";
//  console.log(url);
  fetch(url).then((response)=>
    response.json().then((data)=>{
    //  console.log(data);
      for(let conf of data){
        if(conf.state==1){
          var urlserver = conf.ipadress +":"+conf.port+"/translate";
       //   console.log(urlserver);
          //document.querySelector("#servertt").innerHTML = urlserver;
          window.localStorage.setItem('serverul', urlserver);
        }
      }
    })
  );

  function getSMS(element) {
    var regex = /(<([^>]+)>)/ig
    sms ="";
    //var p = element.match(/<p>.*?<\/p>/g);
    var p = element.match(/<.*?(.).*?>*?<\/.*?\1>/g);
    
    for(i=0; i<p.length; i++){
      var sms = sms+" "+p[i];
    }
    return sms.replace(regex, "").match(/.{1,160}/g);
  }
  

// Function detect tops levels
function detectTopLevel(content){
  regex = /<h[1-6].*>.*<\/h[1-6]>/g
  header_tags = [];
  header_tags_populated = content.match(regex);
  
  for(i=0; i < header_tags_populated.length; i++){
    header_tags.push(jQuery(header_tags_populated[i]).get(0).tagName);
  }
  header_tags = [...new Set(header_tags)];
  header_tags.sort(); 
  moduletags = header_tags[0];
  submoduletags = header_tags[1]; 

  return [moduletags,submoduletags];
}
// Function detect tops levels_________________________ end



  // Appel Url to get list of translation by split it in pieces of message
  

  jQuery('#excellink').click(function () {
    var items2 = [];
    var pathname = window.location.pathname.split("/");
    var idnode = pathname[pathname.length-1];
    //var hostname = window.location.hostname;
    //var protocol = window.location.protocol;
    
    
    //alert(idnode);
  let url2 = protocol+"//"+hostname+"/digitalcms9/en/rest/localizationList/"+idnode;  
  console.log(url2);

  fetch(url2).then((response)=>
    response.json().then((data)=>{
      //console.log(data);
      for(let translation of data){
        var regex = /(<([^>]+)>)/ig

        //Detecton le toplevel
        tabtoplevelexcel = detectTopLevel(translation.Translation);

        excelmodule = tabtoplevelexcel[0].toLowerCase();
        excelsubmodule = tabtoplevelexcel[1].toLowerCase();

        console.log("---------------------------");
        console.log("Top 1 "+excelmodule);
        console.log("Top 2"+excelsubmodule);
        console.log("---------------------------");

        excelregexa = new RegExp(`<${excelmodule}.*?>.*?<\/${excelmodule}>`, "g")
        excelregexb = new RegExp(`<${excelsubmodule}.*?>.*?<\/${excelsubmodule}>`, "g")
        
        var smssplit = getSMS(translation.Translation);
        for(i=0; i<smssplit.length; i++){
          if(excelsubmodule == null){
            items2.push([translation.Cours,translation.language,translation.Channel,translation.Translation.match(excelregexa)[0].replace(regex, ""),,smssplit[i]]);
          }else {
            items2.push([translation.Cours,translation.language,translation.Channel,translation.Translation.match(excelregexa)[0].replace(regex, ""),translation.Translation.match(excelregexb)[0].replace(regex, ""),smssplit[i]]);
          }
          
        }
        window.localStorage.setItem('filename', translation.Cours+"_translation");
      }
    //  console.log(items2);
      var filename2 = window.localStorage.getItem('filename');
      const xls = new XlsExport(items2, "monexcel");
      xls.exportToXLS(filename2);
      window.localStorage.removeItem(filename);

    })
  );
  
  });

  //href="/digitalcms9/en/rest/localizationList/{{ nid }}"
  




/*


jQuery('article').ready(function(){

  //meme format au niveau des courses et transtation

  var incourseformat =jQuery('article .node-content').html();
  console.log(incourseformat);

  regex = /<h[1-6].*>.*<\/h[1-6]>/g
  header_tags_populated = incourseformat.match(regex);
  header_tags = [];
  console.log(header_tags_populated);
  for(i=0; i < header_tags_populated.length; i++){
    header_tags.push(jQuery(header_tags_populated[i]).get(0).tagName)

    }
    header_tags = [...new Set(header_tags)]
    console.log(header_tags);
    header_tags.sort();
    moduletags = header_tags[0];
jQuery(moduletags.toLowerCase()).addClass('module-title');
   
    submoduletags = header_tags[1];
    if( submoduletags ===null ){

      console.log('pas de submodule');
     
    } else{
      jQuery(submoduletags).addClass('supmoduletitle');
    }

   // jQuery('article .node-content .module-title').append('<svg class="svg-inline--fa fa-chevron-down fa-w-14 expand-minimize-button text-light text-xl font-thin text-gray-400" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-down" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z"></path></svg>');

     

});

*/







  

jQuery("#block-views-block-contenttotranslate-block-1").ready(function(){
  
      //hide ckeditor menu on sms channel
    jQuery('form#node-localization-form #cke_19,form#node-localization-form #cke_22,form#node-localization-form #cke_29,form#node-localization-form #cke_35').addClass('hidemenuckeditorOnSms');
/*
// api url
const api_url = "http://localhost/digitalcms9/serverconf";


var urlapi1;
// Defining async function

const zzzz = (async function getapi(url){
    
    // Storing response
    const response = await fetch(url);
    
    // Storing data in form of JSON
    var data = await response.json();

    var server = data;

    for(i=0; i<server.length; i++) {
      if(server[i].state == 1) { 
       // console.log(server[i].ipadress);
        urlapi1 = "http://"+server[i].ipadress+":"+server[i].port+"/translate";
        //console.log(urlapi1);
        
      }
    }
return urlapi1;
   // console.log(server);
    
})();

const aby = (async () => {
  const data = await fetch(api_url);
  return data
})()
// Calling that async function
var bestUrl = getapi(api_url);

console.log(aby);


*/



//const urlapi = "http://"+server[i].ipadress+":"+server[i].port+"/translate";


//const urlapi ="http://0.0.0.0:5000/translate"; 
var urlapi = window.localStorage.getItem('serverul');


  var textToTranslate = jQuery(".bodyContentToTranslate").html();
  var titletotranslate = jQuery(".initial-title a").text();
  var descriptiontotranslate = jQuery(".description-preview + *").text();

  //console.log("description a traduire " + descriptiontotranslate);

// Start function
const starttranslate = async function(a, b,c) {

  const res = await fetch(urlapi, {
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

  const res = await fetch(urlapi, {
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

  const res = await fetch(urlapi, {
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
  // console.log(descgood);
  
   
   jQuery("#edit-field-descriptino-content-0-value").val(descgood);
   //console.log(descgood);
}



// Default translation 
jQuery("#edit-field-titre-content-0-value, #edit-field-descriptino-content-0-value").val("Translating...");
CKEDITOR.instances['edit-field-localization-messagebody-0-value'].setData("Translating...");
starttranslate(textToTranslate, "auto", "fr");
trabslatetitle(titletotranslate, "auto", "fr");
translatedesc(descriptiontotranslate, "auto", "fr");


// Translation when we click on selected lanague 
document.getElementById('edit-field-localization-langue').addEventListener('change', function() {
  
    var e = document.getElementById("edit-field-localization-langue");
    var text = e.options[e.selectedIndex].text;
    jQuery("#edit-field-titre-content-0-value, #edit-field-descriptino-content-0-value").val("Translating...");
    CKEDITOR.instances['edit-field-localization-messagebody-0-value'].setData("Translating...");
    if(text=="Spanish"){

      starttranslate(textToTranslate, "auto", "es");
      trabslatetitle(titletotranslate, "auto", "es");
      translatedesc(descriptiontotranslate, "auto", "es");
    }else if(text=="Arabic"){
      starttranslate(textToTranslate, "auto", "ar");
      trabslatetitle(titletotranslate, "auto", "ar");
      translatedesc(descriptiontotranslate, "auto", "ar");
    }else if(text=="English"){
      starttranslate(textToTranslate, "auto", "en");
      trabslatetitle(titletotranslate, "auto", "en");
      translatedesc(descriptiontotranslate, "auto", "en");
    }else if(text=="Chinese"){
      starttranslate(textToTranslate, "auto", "zh");
      trabslatetitle(titletotranslate, "auto", "zh");
      translatedesc(descriptiontotranslate, "auto", "zh");
    }

  //  console.log('You selected: ', text);
});



//jQuery('select#edit-field-localization-langue option:contains("French")').prop('selected',true); 

});

/*

jQuery('form#views-exposed-form-list-of-content-page-1').( function(){

  jQuery('input#edit-submit-list-of-content').click();
  jQuery('form#views-exposed-form-list-of-content-page-1').remove();
})  

*/


jQuery(document).ready(function () {

  jQuery('.module-title').removeClass('course-content')

   jQuery('article .node-content .module-title').append('<svg class="svg-inline--fa fa-chevron-down fa-w-14 expand-minimize-button text-light text-xl font-thin text-gray-400" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-down" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z"></path></svg>');

 // var payspardefaut = jQuery("h6.country-of-userlog").text();
 // jQuery('select#edit-field-pays-teste-value option:contains('+payspardefaut+')').prop('selected',true); 
  jQuery('.course-content').hide();
  
  //var payspardefaut = jQuery("h6.country-of-userlog").text();
  //jQuery('select#edit-field-pays-teste-value option:contains('+payspardefaut+')').prop('selected',true); 

  jQuery('#edit-field-descriptioncontent-wrapper label').val('Update description');

  jQuery('form').attr('autocomplete', 'off');
  jQuery('form#comment-form textarea ').attr('placeholder', 'Type a comment...✍️');
  jQuery('li.comment-add').remove();
  jQuery('nav#block-digitalcmsmenu ul li:nth-child(3) ul').hide();
  jQuery('.print__wrapper.print__wrapper--pdf').append('<svg class="svg-inline--fa fa-file-pdf fa-w-12" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="file-pdf" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg=""><path fill="currentColor" d="M181.9 256.1c-5-16-4.9-46.9-2-46.9 8.4 0 7.6 36.9 2 46.9zm-1.7 47.2c-7.7 20.2-17.3 43.3-28.4 62.7 18.3-7 39-17.2 62.9-21.9-12.7-9.6-24.9-23.4-34.5-40.8zM86.1 428.1c0 .8 13.2-5.4 34.9-40.2-6.7 6.3-29.1 24.5-34.9 40.2zM248 160h136v328c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V24C0 10.7 10.7 0 24 0h200v136c0 13.2 10.8 24 24 24zm-8 171.8c-20-12.2-33.3-29-42.7-53.8 4.5-18.5 11.6-46.6 6.2-64.2-4.7-29.4-42.4-26.5-47.8-6.8-5 18.3-.4 44.1 8.1 77-11.6 27.6-28.7 64.6-40.8 85.8-.1 0-.1.1-.2.1-27.1 13.9-73.6 44.5-54.5 68 5.6 6.9 16 10 21.5 10 17.9 0 35.7-18 61.1-61.8 25.8-8.5 54.1-19.1 79-23.2 21.7 11.8 47.1 19.5 64 19.5 29.2 0 31.2-32 19.7-43.4-13.9-13.6-54.3-9.7-73.6-7.2zM377 105L279 7c-4.5-4.5-10.6-7-17-7h-6v128h128v-6.1c0-6.3-2.5-12.4-7-16.9zm-74.1 255.3c4.1-2.7-2.5-11.9-42.8-9 37.1 15.8 42.8 9 42.8 9z"></path></svg>');
  jQuery('textarea#edit-field-descriptioncontent-0-value').hide()
  jQuery('.js-form-item.form-item.js-form-type-textarea.form-item-field-descriptioncontent-0-value.js-form-item-field-descriptioncontent-0-value label').html('Add Description')
  jQuery('.blockmodule-submodule').hide();
  jQuery('a.btn').hide();
  jQuery('form#node-content-edit-form .js-form-item.form-item.js-form-type-textarea.form-item-field-descriptioncontent-0-value.js-form-item-field-descriptioncontent-0-value label').html('Update Description');

 // jQuery('section').hide();
 // jQuery('.module-title').append('<svg class="svg-inline--fa fa-chevron-down fa-w-14 expand-minimize-button text-light text-xl font-thin text-gray-400" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-down" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z"></path></svg>');
  jQuery('<div class="live-preveiw-section "> <div class="livepreview-content"> Course preview  </div> <div class="tilteconteValue" ></div> <div class="DescriptioncontentValue"></div> <div class="contentent-preview-good-format">  </div> </div>').insertBefore('form#node-content-form , form#node-content-edit-form');
  //hide submodule and message content 
 // jQuery('article .node-content p , article .node-content h1+* , .supmoduletitle ').hide();
  jQuery('.node-content-form input#edit-submit').prop('disabled', true);
 // jQuery('<span class="button-add-new-comment">Add a new comment</span>').insertBefore('section');
  jQuery('.node-content p:nth-child(1)').insertBefore('.node-content p:nth-child(1)');
  //jQuery('#block-views-block-editcourse-block-1-2').hide();
 // jQuery('div#block-views-block-editcourse-block-1').hide();
 // var divContentedite = jQuery('#block-views-block-editcourse-block-1-2 span').html();
 // jQuery('article .node-content h1').append(divContentedite);
  jQuery('svg.svg-inline--fa.fa-chevron-down.fa-w-14.expand-minimize-button.text-light.text-xl.font-thin.text-gray-400 + a').html('<i class="fa fa-pencil"></i>')
 //console.log(divContentedite);

  //on change input title   & description


  jQuery('nav#block-digitalcmsmenu ul li:nth-child(3)').click(function(){
    jQuery('nav#block-digitalcmsmenu ul li:nth-child(3) ul').toggle(1000);
  }
  );

    jQuery(" textarea#edit-field-descriptioncontent-0-value ").ready( function () {
      // jQuery('.DescriptioncontentValue').remove();
      DescriptioncontentValue = jQuery(this).val();
      jQuery('.DescriptioncontentValue').html('<div class="description-preview">Description</div> <br>' + DescriptioncontentValue + '<div class="separateur-whenwehavedescrip"></div>');
    });


    jQuery("div#block-views-block-list-localization-block-1 .show-message  span.message-etat").each(function () {

       if(jQuery(this).text()=='Submit for review' || jQuery(this).text()=='Submit for review'){

         jQuery(this).addClass('statesubmiteforreviw').text('Pending');
       }
       else if(jQuery(this).text()=='Rejected') {

        jQuery(this).addClass('stateRejected');
       }
       else if(jQuery(this).text()=='Draft'){

        jQuery(this).addClass('stateDraft');

       }else{
        jQuery(this).addClass('stateApproved');

       }

  
    });

 


  //Download files and archive them in to a zipfile

  //The FileSaver API
  jQuery(".downloadzipfile").click(function () {
  //  console.log("Salut jszip");
    var zip = new JSZip();
    zip.file("Hello.txt", "Hello World\n");
    var img = zip.folder("images");
    img.file("smile.gif", imgData, { base64: true });
    zip.generateAsync({ type: "blob" })
      .then(function (content) {
        // see FileSaver.js
        saveAs(content, "course.zip");
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
    
    var nbmodule = jQuery(this).find('.module-title').length;
    
    //console.log(nbmodule);
    
    if (nbmodule <= 0 || nbmodule == 1) {
    
    jQuery(this).find(".numberomodul").html(nbmodule + " Module");
    
    } else jQuery(this).find(".numberomodul").html(nbmodule + " Modules");
    
    });

/*
  jQuery(".views-col .tw-item-card").each(function () {
  //  var oldh1= jQuery(this).find(".tw-item-card ").html().replace('a' , "span").replace('/a' , "/span");
    
    
    var numberofmodule =jQuery(this).html();
      console.log(numberofmodule);
   regex = /<h[1-6].*>.*<\/h[1-6]>/g
    header_tags_populated = numberofmodule.match(regex);

    header_tags = [];
    for(i=0; i < header_tags_populated.length; i++){
      header_tags.push(jQuery(header_tags_populated[i]).get(0).tagName)
      }
      header_tags = [...new Set(header_tags)]
      header_tags.sort();
      moduletags = header_tags[0];

    jQuery(moduletags.toLowerCase()).addClass('nombredemodulecourse');
    var nbmodule = 0;
    var nbmodule = jQuery(this).find('.nombredemodulecourse').length;

    //console.log(nbmodule);
    if (nbmodule <= 0 || nbmodule == 1) {
      jQuery(this).find(".numberomodul").html(nbmodule + " Module");
    } else jQuery(this).find(".numberomodul").html(nbmodule + " Modules");

  });

  */




    jQuery('p span span span span').click(function () {
    jQuery('.node-content p span b').toggle();
  });

  //Hide and show add description

  jQuery('.js-form-item.form-item.js-form-type-textarea.form-item-field-descriptioncontent-0-value.js-form-item-field-descriptioncontent-0-value label').click(function () {

    jQuery('textarea#edit-field-descriptioncontent-0-value').toggle(500);

    var add_description = (jQuery('.js-form-item.form-item.js-form-type-textarea.form-item-field-descriptioncontent-0-value.js-form-item-field-descriptioncontent-0-value label').text());
    if (add_description == "Add Description") {

      jQuery('.js-form-item.form-item.js-form-type-textarea.form-item-field-descriptioncontent-0-value.js-form-item-field-descriptioncontent-0-value label').text('Description');
      jQuery('.js-form-item.form-item.js-form-type-textarea.form-item-field-descriptioncontent-0-value.js-form-item-field-descriptioncontent-0-value label').addClass('desactive-cursoraddcursort');
    } 
    else if(add_description == "Update Description"){
      jQuery('.js-form-item.form-item.js-form-type-textarea.form-item-field-descriptioncontent-0-value.js-form-item-field-descriptioncontent-0-value label').text('Update Description');
      jQuery('.js-form-item.form-item.js-form-type-textarea.form-item-field-descriptioncontent-0-value.js-form-item-field-descriptioncontent-0-value label').removeClass('desactive-cursoraddcursort');
     

    }
    else{

      jQuery('.js-form-item.form-item.js-form-type-textarea.form-item-field-descriptioncontent-0-value.js-form-item-field-descriptioncontent-0-value label').text('Add Description');
      jQuery('.js-form-item.form-item.js-form-type-textarea.form-item-field-descriptioncontent-0-value.js-form-item-field-descriptioncontent-0-value label').removeClass('desactive-cursoraddcursort');

    }


  });

  jQuery('option[value="_none"]').remove();
  jQuery('.entity-moderation-form .form-item label').html('');
  jQuery('form#node-localization-form div#edit-actions').append('<div class="tw-flex tw-items-center tw-jtw-ustify-center tw-mb-4 btn-group"><button class="btn btn-edit tw-bg-blue-700 tw-text-white hover:tw-bg-blue-700 hover:tw-text-white active tw-font-bold uppercase tw-text-sm tw-px-6 tw-py-3 tw-rounded-l tw-outline-none tw-focus:outline-none tw-mb-1 tw-ease-linear tw-transition-all tw-duration-150" type="button">Edit</button><button class="btn btn-preview tw-bg-blue-500 tw-text-white hover:tw-bg-blue-700 hover:tw-text-white tw-font-bold uppercase tw-text-sm tw-px-6 tw-py-3 tw-rounded-r outline-none tw-focus:outline-none tw-mb-1 tw-ease-linear transition-all duration-150" type="button">Preview</button></div>');
  jQuery('.simpler_quickedit_click.simpler_quickedit.quickedit-field').append("<i class='fas fa-pencil-alt editeur-conten'></i>");
  
  //Show add comment form
/*
  jQuery("span.button-add-new-comment ").click(function () {
    jQuery('section').show();
    jQuery('div#block-views-block-listcomments-block-1').addClass('add-height-block-comment')
  });

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

    jQuery('.nbmessage').remove();

    jQuery('#edit-field-titre-content-wrapper').show();
    jQuery('#edit-field-descriptino-content-wrapper').show();
    

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
    jQuery('.nbmessage').remove();
    jQuery('.nbcarac').remove();
    var count = 0;
    var size = 160;
    var tabsms = [];
    var regex1 = /(<([^>]+)>)/ig
    var regex2 = /<h1>.*?<\/h1>|<h2>.*?<\/h2>/g
    nbcaracterecontent = 0;
    


// function ChunkSubStr pour diviser un contenu en plusieur enseble de size caractere
    function chunkSubstr(str, size) {
      const numChunks = Math.ceil(str.length / size)
      const chunks = new Array(numChunks)
    
      for (let i = 0, o = 0; i < numChunks; ++i, o += size) {
        chunks[i] = str.substr(o, size)
      }
    
      return chunks
    }
// function ChunkSubStr__________________end

// Function detect tops levels
function detectTopLevel(content){
  regex = /<h[1-6].*>.*<\/h[1-6]>/g
  header_tags = [];
  header_tags_populated = content.match(regex);
  
  for(i=0; i < header_tags_populated.length; i++){
    header_tags.push(jQuery(header_tags_populated[i]).get(0).tagName);
  }
  header_tags = [...new Set(header_tags)];
  header_tags.sort(); 
  moduletags = header_tags[0];
  submoduletags = header_tags[1]; 

  return [moduletags,submoduletags];
}
// Function detect tops levels_________________________ end

    // recuperer le contenu de ckeditor
    var description = CKEDITOR.instances['edit-field-localization-messagebody-0-value'].getData();

    // recuperation du contenu du ckeditor
    var htmldata = CKEDITOR.instances['edit-field-localization-messagebody-0-value'].document.getBody().getHtml();

    //recuperation de toutes les balise avec leur contenu dans une table
    resultdata  = description.match(/<.*?(.).*?>*?<\/.*?\1>/g);

    //Nombre de caracterer du content traduit
    nbcaracterecontent =  description.replace(regex1,"").trim().replace(/(^[ \t]*\n)/gm, "").length;

//Detectons Top Level du contenu
    var tabtoplevel = detectTopLevel(description);
    tagmodule = tabtoplevel[0].toLowerCase();
    tagsubmodule = tabtoplevel[1].toLowerCase();

    console.log("top level 1 "+tagmodule);
    console.log("top level 2 "+tagsubmodule);


    //messagestrip = textebrute.match(/.{1,160}/g);

    var items = [];

  // regex avec des variable correspondant a nos oplevel
  regexa = new RegExp(`<${tagmodule}.*?>.*?<\/${tagmodule}>`, "g")
  regexb = new RegExp(`<${tagsubmodule}.*?>.*?<\/${tagsubmodule}>`, "g")

  // ici on parcours tout les element de resultdata
  resultdata.forEach(function(element) {
          if(element.match(regexa)){ 
            items.push([element,,]);
          }else if(element.match(regexb)){ 
            items.push([,element,]);
          }else { 
            // compter le nombre de message per cours
            count = count + element.match(/.{1,160}/g).length;
            items.push([,,element.match(/.{1,160}/g)]);
          }
  });

  //console.table(items);

    jQuery(this).removeClass("tw-bg-blue-500");
    jQuery(this).addClass("tw-bg-blue-700");
    jQuery(".btn-group > .btn-edit").removeClass("tw-bg-blue-700");
    jQuery(".btn-group > .btn-edit").addClass("tw-bg-blue-500");

    jQuery('label[for="edit-field-localization-messagebody-0-value"]').hide();
    jQuery('#cke_edit-field-localization-messagebody-0-value').hide();

    jQuery('#edit-field-titre-content-wrapper').hide();
    jQuery('#edit-field-descriptino-content-wrapper').hide();

    //jQuery('#edit-field-localization-channel').prop('disabled', true);
    //jQuery('#edit-field-localization-channel').hide();
    //jQuery('#edit-field-localization-langue').hide();

    jQuery('#edit-field-localization-langue, #edit-field-localization-channel').hide();
    jQuery('label[for="edit-field-localization-langue"], label[for="edit-field-localization-channel"]').hide();

    jQuery(".btn-group > .btn-edit").prop('disabled', false);
    jQuery(".btn-group > .btn-preview").prop('disabled', true);
    if (jQuery('#edit-field-localization-channel').find(":selected").text() == "SMS") {
      jQuery('<div class="channelgenerategeneral"> <div class="channelgenerate sms" id="sms"><i class="fas fa-sms"></i>SMS</div> </div>').insertAfter('#edit-field-localization-channel');
      jQuery(' <div class="nbmessage"> Translation will be divided into <span class="circlenb">'+count+'</span> messages </div> ').insertBefore('.channelgenerategeneral');
    } else if (jQuery('#edit-field-localization-channel').find(":selected").text() == "Whatsapp") {
      jQuery('<div class="channelgenerategeneral"><div class="channelgenerate whatsapp"><i class="fab fa-whatsapp"></i>WHATSAPP</div> </div>').insertAfter('#edit-field-localization-channel');
      jQuery(' <div class="nbmessage"> A whatsapp message can contain <span class="circlenb">'+65.536+'</span> characters </div> ').insertBefore('.channelgenerategeneral');
    } else if (jQuery('#edit-field-localization-channel').find(":selected").text() == "Telegram") {
      jQuery('<div class="channelgenerategeneral"><div class="channelgenerate telegrame"><i class="fab fa-telegram"></i>TELEGRAM</div> </div>').insertAfter('#edit-field-localization-channel');
      jQuery(' <div class="nbmessage"> A telegram message can contain <span class="circlenb">'+4.096+'</span> characters </div> ').insertBefore('.channelgenerategeneral');
    } else if (jQuery('#edit-field-localization-channel').find(":selected").text() == "Messenger") {
      jQuery('<div class="channelgenerategeneral"><div class="channelgenerate messanger"><i class="fab fa-facebook-messenger"></i>MESSENGER</div> </div>').insertAfter('#edit-field-localization-channel');
    } else if (jQuery('#edit-field-localization-channel').find(":selected").text() == "Moodle") {
      jQuery('<div class="channelgenerategeneral"><div class="channelgenerate moodle"><i class="fas fa-graduation-cap"></i>MOODLE</div> </div>').insertAfter('#edit-field-localization-channel');
    } else if (jQuery('#edit-field-localization-channel').find(":selected").text() == "IOGT") {
      jQuery('<div class="channelgenerategeneral"><div class="channelgenerate moodle"><i class="fas fa-graduation-cap"></i>IOGT</div></div>').insertAfter('#edit-field-localization-channel');
    }

    
    //jQuery(".cke_path_empty").html(nbcaracterecontent);
    jQuery('<div class="nbcarac"> <span class="circlenb2">'+nbcaracterecontent+'</span> Characters </div>').insertAfter('#cke_edit-field-localization-messagebody-0-value');
    
      //jQuery('.channelgenerate ').append(items);

    for (var i = 0; i < items.length; i++) {
      for (var j = 0; j < items[i].length; j++) {
        jQuery('.channelgenerate ').append(items[i][j]);
        for (var k = 0; k < items[i].length; k++) { 
          //jQuery('.channelgenerate ').append(items[k][i]);
        }
        //console.log(items[i][j]); 
      }
    }

    //jQuery('.channelgenerate ').append(items);

    //console.log(items[2][1]);
    //console.table(items);
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
  jQuery(".node-content-form , .node-content-edit-form").ready(function () {
    CKEDITOR.instances['edit-body-0-value'].on('change', function (e) {
      
      jQuery('.messageduformat-texteformat').remove();
      jQuery('.node-content-form input#edit-submit').prop('disabled', true);
      var body = CKEDITOR.instances['edit-body-0-value'].getData();
      jQuery(".contentent-preview-good-format").html(body);
    //  CKEDITOR.instances.Editor.document.getBody().getHtml();
     
      regex = /<h[1-6].*>.*<\/h[1-6]>/g
      header_tags_populated = body.match(regex);
      header_tags = [];
    //  console.log(header_tags_populated);
      if(header_tags_populated === null){
        jQuery('.node-content-form input#edit-submit').prop('disabled', true);
        jQuery('<div class="messageduformat-texteformat">😬 Oups !  Please review the format of the content.We did not detect any Module.</div>').insertBefore('.node-content-form div#edit-actions #edit-submit'); 

      }else{
        jQuery('.node-content-form input#edit-submit').prop('disabled', false);
      for(i=0; i < header_tags_populated.length; i++){
      header_tags.push(jQuery(header_tags_populated[i]).get(0).tagName)

      }
      header_tags = [...new Set(header_tags)]
     // console.log(header_tags);
      header_tags.sort();
      moduletags = header_tags[0];
      jQuery(moduletags.toLowerCase()).addClass('module-title');
     
      submoduletags = header_tags[1];
     
      if( submoduletags ===null ){

     //   console.log('pas de submodule');
       
      } else{
        jQuery(submoduletags).addClass('supmoduletitle');
      }
    //  jQuery(submoduletags.toLowerCase()).addClass('supmoduletitle');
      }

    });

    //changement contenu Ckeditor
      jQuery('form#node-content-form input#edit-submit , .node-content-edit-form input#edit-submit').click(function(){

        

     jQuery('.contentent-preview-good-format').find('*').addClass('course-content');
     var ckedi = jQuery('.contentent-preview-good-format').html();
     var ck2 =   jQuery(".module-title span:nth-last-of-type(1)").remove()
     console.log('===================Debut ck 2===================')
     console.log(ck2)

        CKEDITOR.instances['edit-body-0-value'].setData(ckedi);
      });

     //remove all p 

      jQuery('p').each(function() {
        var $this = jQuery(this);
        if($this.html().replace(/\s|&nbsp;/g, '').length == 0) {
            $this.remove();
        }
    });

    
  
   //teste
   var valeurtilt = jQuery('input#edit-title-0-value').val();
  // console.log(valeurtilt)
   jQuery('.tilteconteValue').html(valeurtilt)

  var valdesciption =jQuery('textarea#edit-field-descriptioncontent-0-value').val();
   jQuery('.DescriptioncontentValue').html('<div class="description-edite ">Description </div>'+ valdesciption)

  // var body2 = CKEDITOR.instances['edit-body-0-value'].getData();
 jQuery('.contentent-preview-good-format').html(CKEDITOR.instances['edit-body-0-value'].getData());
// alert(body);

    
  });
  
  
    jQuery('#edit-field-localization-channel').change(function() {
  
    let channel=jQuery( "#edit-field-localization-channel option:selected" ).text();
  
    if(channel=="SMS"){
      jQuery('#cke_19,#cke_22,#cke_29,#cke_35').removeClass('showmenuckeditorOnSms');

     }else if(channel=="Whatsapp")
     {
      jQuery('#cke_19,#cke_22,#cke_29,#cke_35').addClass('showmenuckeditorOnSms');
     }else if(channel=="Moodle"){
      jQuery('#cke_19,#cke_22,#cke_29,#cke_35').addClass('shrowmenuckeditorOnSms');
     }else if(channel=="Telegram"){
      jQuery('#cke_19,#cke_22,#cke_29,#cke_35').addClass('showmenuckeditorOnSms');
     }else if(channel=="Messenger"){
      jQuery('#cke_19,#cke_22,#cke_29,#cke_35').addClass('showmenuckeditorOnSms');
     }else if(channel=="IOGT"){
      jQuery('#cke_19,#cke_22,#cke_29,#cke_35').addClass('showmenuckeditorOnSms');
     }else{
   //  console.log(str);
     }
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

    jQuery('.blockmodule-submodule:eq(' + moduleIndex + ')').toggle(500);

  });

  var acc = document.getElementsByClassName("module-title");
  var i;
  
  for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
      
    var chevronbi = this.lastChild

   // jQuery('module-title p').remove();
    //console.log(chevronbi)
  //jQuery(chevronbi).toggleClass('tranfromnation-chevreon');
  // this.childNodes.classList.toggle("tranfromnation-chevreon")

       panel = this.nextElementSibling;
        if (panel.style.display === "block") {
          panel.style.display = "none";
  jQuery(chevronbi).removeClass('tranfromnation-chevreon');
         
         // jQuery('.svg-inline--fa.fa-w-14').removeClass('tranfromnation-chevreon');
        } else {
          panel.style.display = "block";
  jQuery(chevronbi).addClass('tranfromnation-chevreon');

        //  jQuery('.svg-inline--fa.fa-w-14').addClass('tranfromnation-chevreon');

        }
       do {
        
        panel = panel.nextElementSibling;

     //   console.log(panel)
        if (panel.style.display === "block") {
  jQuery(chevronbi).removeClass('tranfromnation-chevreon');
        
          panel.style.display = "none";
       //  jQuery('.svg-inline--fa.fa-w-14').removeClass('tranfromnation-chevreon');
        } else {
          panel.style.display = "block";
  jQuery(chevronbi).addClass('tranfromnation-chevreon');

        //  jQuery('.svg-inline--fa.fa-w-14').addClass('tranfromnation-chevreon');

        }
    }while(panel.className!='module-title')
      
    });
  }



  jQuery('p').each(function() {
    var $this = jQuery(this);
    if($this.html().replace(/\s|&nbsp;/g, '').length == 0) {
        $this.remove();
    }
});




  // Expand All 
  jQuery('span.expandalle-minimizeall-button.cursor-pointer').click(function () {

   // jQuery('article .node-content p, article .node-content h2,article .node-content h1+* ').toggle(500);
  // jQuery('.course-content').toggle();

    

    var expand = (jQuery('span.expandalle-minimizeall-button.cursor-pointer').text());
    if(expand == "Expand all"){
      jQuery('span.expandalle-minimizeall-button.cursor-pointer').text('Minimize')
      jQuery('.svg-inline--fa.fa-w-14').addClass('tranfromnation-chevreon');
      jQuery('.course-content').show();
    }else{
      jQuery('span.expandalle-minimizeall-button.cursor-pointer').text('Expand all')
    
      jQuery('.svg-inline--fa.fa-w-14').removeClass('tranfromnation-chevreon');
      jQuery('.course-content').hide();

    }
  //  expand == "Expand all" ? jQuery('span.expandalle-minimizeall-button.cursor-pointer').text('Minimize') : jQuery('span.expandalle-minimizeall-button.cursor-pointer').text('Expand all')
  });



  jQuery('span.tw-switch-editing-button.tw-rounded.border.tw-border-green-500.tw-px-5.py-2.tw-text-green-700.tw-text-sm.tw-cursor-pointer').click(function () {

    jQuery('.tw-switch-editing-button').toggleClass('turneditone');
    jQuery('a.addnewlocalisation').toggleClass('afficher-add-new-localistion');
    jQuery('a.detaillebody').toggleClass('addnewlocalisationcacher');
    jQuery('a.btn').toggle(500);
    jQuery('.add-module').toggleClass('add-module-enable');

    var turneoff = (jQuery('.tw-switch-editing-button').text());
    var expand = (jQuery('.expandall-minimizeall-button').text());
    jQuery('.blockmodule-titre-module').toggleClass('blockmodule-titre-module-expland');
    jQuery('.tw-switch-editing-button').toggleClass('colore-turne-edite');

    jQuery('svg.svg-inline--fa.fa-chevron-down.fa-w-14.expand-minimize-button.text-light.text-xl.font-thin.text-gray-400 + a').toggleClass('show-edite-mode');


   // turneoff == "Turn editing on" ? jQuery('.tw-switch-editing-button').text('Turn editing off') : jQuery('.tw-switch-editing-button').text('Turn editing on');
  });

  var notefounddasbord = (jQuery('div#block-tailwindcss-content').text());
  notefounddasbord == " The requested page could not be found. " ? jQuery('div#block-tailwindcss-content').text('') : jQuery('div#block-tailwindcss-content').removeClass('hidenotefoundasbord');

  // jQuery('.a.use-ajax').hide();
  jQuery('<h1 class="titre-cms-translation"> CONTENT MANAGEMENT AND ADAPTATION PLATFORM </h1>').insertBefore('.js-form-item.form-item.js-form-type-textfield.form-item-name.js-form-item-name');
  jQuery('<i class="fa fa-fw fa-user"></i>').insertBefore('input#edit-name');
  jQuery('<i class="fa fa-fw fa-lock"></i>').insertBefore('input#edit-pass');
  //jQuery('a.use-ajax').prepend('<i class="fas fa-plus-square"></i>');
  jQuery('.views-view-grid.horizontal.cols-4.clearfix .views-row').last().append('<div class="views-col col-1 addcourse-blank" style="width: 25%;"><div class="views-field views-field-nothing"><span class="field-content"><div class=" tw-item-card "><a href="node/add/content" class="addcoursebutton" tabindex="-1">New course</a></div></div> ');
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


});

