$(document).ready(function(){
	
	$('#wrap .large ul.list li').mouseenter(function()
	{	
		$(this).children(".actions").show();
	}).mouseleave(function()
	{
		$(this).children(".actions").hide();
	});
	
	$('#minusButton').click(function()
	{
	
		if($(this).hasClass("twisted"))
		{
			$(this).removeClass("twisted");
			$(".deleteButton").fadeOut("fast");
			$(".hours").fadeIn("fast");
		}
		else
		{
			$(this).addClass("twisted");
			$(".deleteButton").fadeIn("fast");
			$(".hours, .actions").fadeOut("fast");
		}
	
	});
	
	$('.deleteButtonA').live("click",function()
	{
		if($(this).hasClass("deactivate"))
		{
			var popup = confirm("Are you sure you want to deactivate this member of staff?");
		}
		else
		{
			var popup = confirm("Are you sure you want to delete this, there is no undo?");
		}
		if(popup)
		{
			var href = $(this).attr("href");
			$(this).children(".deleteButton").fadeOut("fast");
			if($(this).hasClass("deactivate"))
			{
				$(this).parent("li").animate({opacity:"0.5"});
				$(this).parent("li").children(".actions.normal").children("a").css({"display":"none"});
				$(this).parent("li").children(".hiddenactions").addClass("actions extra");
				$(this).parent("li").children(".hiddenactions").css({"display":"block"});
				$(this).parent("li").children(".hiddenactions").removeClass("hiddenactions");
			}
			else
			{
				$(this).parent("li").slideUp(300,  function (){ $(this).remove();});
			}
			if($('ul.list').children().size() == 1)
			{
				$('ul.list, #minusButton, #addButton').hide();
				$(this).removeClass("twisted");
				$('#noneLeft').show();
			}
			$.get(href);
			return false;
		}
		else
		{
			return false;
		}	
	});
	
	$('.permDelete').live("click",function()
	{
		var popup = confirm("Permanently deleting this member of staff will result in the deletion of all clock ins by them. Are you sure you want to continue?");
		if(popup)
		{
			var href = $(this).attr("href");
			$(this).parent(".actions").parent("li").slideUp(300,  function (){ $(this).remove();});
			$.get(href);
			return false;
		}
		else
		{
			return false;
		}	
	});
	
	$('.restoreStaff').live("click",function()
	{
		var href = $(this).attr("href");
		$(this).parent(".actions").parent("li").animate({opacity:"1"},200);
		$(this).parent(".actions").parent("li").children(".hiddendelete").addClass("deleteButtonA deactivate");
		$(this).parent(".actions").parent("li").children(".deleteButtonA").css({"display":"block"});
		$(this).parent(".actions").parent("li").children(".deleteButtonA").removeClass("hiddendelete");
		$(this).parent(".actions").parent("li").children(".actions.normal").children("a").css({"display":"block"});
		$(this).parent(".actions").parent("li").children(".actions.extra").addClass("hiddenactions");
		$(this).parent(".actions").parent("li").children(".actions.extra").css({"display":"none"});
		$(this).parent(".actions").parent("li").children(".actions.extra").removeClass("actions");
		setTimeout('$(this).parent(".actions").parent("li").removeClass("faded")',200);
		$(this).removeClass("twisted");
		$.get(href);
		return false;	
	});
	
});