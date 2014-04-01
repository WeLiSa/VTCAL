
/** Function when the page loads*/

$(document).ready(function(){
	viewdatepicker1();
	viewdatepicker2();
});


/**Showing datepicker*/
var viewdatepicker1=function(){
	$("#datepicker1").datepicker( {dateFormat: 'dd/mm/yy', firstDay:1 }).attr("readonly","readonly");
};

var viewdatepicker2=function(){
	$("#datepicker2").datepicker( {dateFormat: 'dd/mm/yy', firstDay:1 }).attr("readonly","readonly");
};


