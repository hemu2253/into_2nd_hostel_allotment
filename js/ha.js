$("document").ready(function() {
	if($("input:checked").length == gsize)
	{
		$("#group-table input[type=checkbox]").attr("disabled",true);
	}
});

/*selection colour*/
$("#group-table td input[type=checkbox]").click(function(){
	if($(this).is(':checked'))
		$(this).parent("b").parent("td").css("background-color", "#3232ee");
});

/*de-selection transparency*/
$("#group-table td input[type=checkbox]").click(function(){
	if(!$(this).is(':checked'))
		$(this).parent("b").parent("td").css("background-color", "transparent");
});

/*side div stuff - counting and listing etc*/
$("td input[type=checkbox]").click(function(){
	if($("input:checked").length>0)
	{
		var left = gsize - $("input:checked").length;
		$("#sidedisp").css("display", "block");
		$("#sidedisp").html("You have<h1>"+left+"</h1>members left<br><br>");
		$("#sidedisp").append("Your Selection<br>");
		$("#sidedisp").append("1. Yourself"+"<br>");
		$("input:checked").each(function(index) {
			$("#sidedisp").append((index+2)+". "+this.value+"<br>");
		})
	}
	$("#sidedisp").append("<div class='button' id='clrbtn'>Clear</div>");
});

/*clear selection*/
$("body").on("click", "#clrbtn", function(){
	if($("td input[type=checkbox]").is(':checked'))
		$("td input[type=checkbox]").parent("b").parent("td").css("background-color", "transparent");
	$("#group-table tr td input[type=checkbox]").removeAttr("checked");
	$("#group-table tr td input[type=checkbox]").removeAttr("disabled");
	$(".green input[type=checkbox]").attr("disabled",true);
	$(".yellow input[type=checkbox]").attr("disabled",true);
	var left = gsize - $("input:checked").length;
	$("#sidedisp").css("display", "block");
	$("#sidedisp").html("You have<h1>"+left+"</h1>members left<br><br>");
	$("#sidedisp").append("Your Selection<br>");
	$("input:checked").each(function() {
		$("#sidedisp").append(this.value+"<br>");
	})
	$("#sidedisp").css("display","none");
});

/*disable checkboxes on reaching gsize*/
$("td input[type=checkbox]").click(function(){
	if($("input:checked").length == gsize)
	{
		$("#group-table input[type=checkbox]").attr("disabled",true);
		$("#sidedisp").append("<div class='button' id='submitbtn'>Submit</div>");
	}
});

/*hide side div on zero selection*/
$("td input[type=checkbox]").click(function(){
	if($("input:checked").length==0)
		$("#sidedisp").css("display", "none");
});

/*send data*/
var memIds = [];
$("body").on("click", "#submitbtn", function(){
	$("#group-table td input[type=checkbox]").each(function() {
		if($(this).is(":checked"))
			memIds.push($(this).val());	
	});
	$.post("groupmem.php",{plist: memIds}, function (data,status){
		if(status=="success")
		{
			alert(data);
			$("#group-table td input[type=checkbox]").each(function() {
				if($(this).is(":checked"))
					$(this).parent("b").parent("td").css("background-color", "#ffff00");
			});
			$("#clrbtn").hide();
			$("#submitbtn").hide();
		}
		else
		{
			alert("Blimey! Something went wrong... ");
		}
	});
});

//validate room filling form
function validate(mem,index)
{
	var flag = false;
	for(i=1;i<=mem;i++)
	{
		var selec_var = document.getElementById("select"+i);
		var sel_index = document.getElementById("select"+index);
		if(i==index)
			continue;
		if(selec_var.value == sel_index.value)
		{
			$("#check"+index).removeClass("yup").addClass("nope");
			$("#roomsubbtn").hide();
			flag=true;
		}
	}
	if(!flag)
	{
		$("#check"+index).removeClass("nope").addClass("yup");
	}
	$("#check"+index).css("display","block");
	
	if($(".nope").length==0)
		$("#roomsubbtn").show();
	return;
}