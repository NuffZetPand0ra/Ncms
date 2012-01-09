var	$alertBox = $("<h4 class='alert_info'></h4>"),
	$successBox = $("<h4 class='alert_success'></h4>"),
	$errorBox = $("<h4 class='alert_error'></h4>"),
	$warningBox = $("<h4 class='alert_warning'></h4>");
		
(function($){

	$.fn.loadPage = function (pageToLoad, callBack){
		var $this = $(this);
		$.get(pageToLoad+".php", function(r){
			$this.html(r);
			$(".section_title").html(pageToLoad);
			$(".current").html(pageToLoad);
			document.title = "Admin - "+pageToLoad;
			window.location.hash = pageToLoad;
		}).complete(function(){			
			if(callBack){
				callBack.apply(this, arguments);
			}
		});
		return $this;
	}
	$.fn.alertInfo = function(displayText, $boxElement){
		var $this = $(this);
		$this.prepend($boxElement.html(displayText+"<a href='#' class='close'>X</a>").show());
		return $this;
	}
	$.fn.sendForm = function(callBack){
		var $form = $(this),
			data = $form.serialize();
		$.post("admin_ajax.php", data).complete(function(r){
			if(callBack){
				callBack.apply(this, arguments);
			}
		});
		return $form;
	}
}(jQuery));
$(function(){
	$menuItems = $("nav ul li a");
	$mainSection = $("#main");
	var firstPage = window.location.hash.substr(1) || "frontpage";
	$mainSection.loadPage(firstPage);
	$menuItems.click(function(e){
		e.preventDefault();
		var pageToLoad = this.hash.substr(1);
		$mainSection.fadeOut("fast", function(){
			$mainSection.loadPage(pageToLoad, function(){
				$mainSection.fadeIn("fast");
			});
		});
	});
	$mainSection.delegate("form", "submit", function(e,o){
		e.preventDefault();
	});
	$mainSection.delegate(".close", "click", function(){
		$(this).parent().fadeOut(function(){
			$(this).detach();
		});
	});
});