
//var number = parseInt(jQuery('.numberofmodule').text());
//number==0 || number==1 ?  jQuery('.numberofmodule').append('module'):jQuery('.numberofmodule').append('modules')
//var numberofmodule = jQuery('.views-label-field-modulelibele').text('Nbmodule').length;
//console.log(numberofmodule);
//jQuery('.item-list').append(numberofmodule+"nombre de module");
jQuery(document).ready(function() {


  //jQuery('<div class="courer">').insertBefore('.listes-courses > a');
 
 // jQuery('</div>').insertAfter('.item-list');


 //jQuery('.listes-courses > a').prependTo('.item-list');

    

    

        

       



 //jQuery('#edit-submit').val('Create');
 jQuery('.js-form-item.form-item.js-form-type-textfield.form-item-title-0-value.js-form-item-title-0-value label').html('Label');

    jQuery('.item-list').each(function()
    {
      var totmarks=0;

    //  console.log(this); 

        jQuery(this).find('.views-label').each(function()
        {
     

      var marks = jQuery(this).text();
    
       
          
           if (marks.length!==0)
            {
              totmarks+=parseFloat(marks);
              //console.log(totmarks);
             
            }
        });
        console.log(totmarks);
       
        if(totmarks == 0 || totmarks == 1){

           jQuery(this).find('ul').html(totmarks  +' Module');
        }
       else
       jQuery(this).find('ul').html(totmarks  +' Modules');
       
    });

   









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