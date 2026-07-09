$(document).ready(function() {
	var popOut = "#popout"; // Name of the popout container.
	var adBox = "#adbox"; // Name of the animated bit of the ad.
	var adCookie = "ad-example"; // Name of the cookie to be set.
	var adWidth = $(adBox).width() + $(".cap").width(); // Width of the ad container.
	
	var top=$( window ).height() - 268;
	$(popOut).css({"top":top+"px","width":"25px"});
	
	function openAd() {
		$(popOut).width(adWidth+"px");
		$(adBox).animate({marginRight: "0"},1200);
		$.cookie(adCookie, null);
	}
	
	function closeAd() {
		$(adBox).animate({marginRight: "-"+adWidth+"px"},1200,"linear",
			function(){ $(popOut).width($(".cap").width() + "px"); }
		);
		$.cookie(adCookie,'off',{expires: 28});
	}

	$("#open").click(function() {
		if(!$.cookie(adCookie)) {
			closeAd();
		} else {				   
			openAd();
		}
		return false; 
	});
	$("#close").click(function() {
		closeAd();
		return false;
	});	
	if(!$.cookie(adCookie)) {
		$(popOut).animate({opacity: 1.0}, 1500, "linear", openAd);
	}
});