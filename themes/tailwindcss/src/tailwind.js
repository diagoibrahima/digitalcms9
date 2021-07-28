
var number = parseInt(jQuery('.numberofmodule').text());
console.log(number);
if (number==1){
    jQuery('.numberofmodule').append('module');
}
else  jQuery('.numberofmodule').append('modules')