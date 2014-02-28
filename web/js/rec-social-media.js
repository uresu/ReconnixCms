jQuery(".latest-news").hover(
    // hover in
    function(){
        jQuery(this).fadeTo(100, 0.3, function(){
            jQuery("#main-container .social-box.latest-news").css("background", "#566068");
            jQuery("#main-container .social-box.latest-news a").css("color", "#fff");
            jQuery("#main-container .latest-news h3").css("border-bottom-color", "#8e8e8e");
            jQuery("#main-container .latest-news img").attr("src", "/symfony2/path/web/images/yellow_arrow_20x28.png");
        }).fadeTo(100, 1);
    }, 
    // hover out
    function(){
        jQuery(this).fadeTo(100, 0.3, function(){
            jQuery("#main-container .social-box.latest-news").css("background", "#a1a8ae");
            jQuery("#main-container .social-box.latest-news a").css("color", "#000");
            jQuery("#main-container .latest-news h3").css("border-bottom-color", "#566068");
            jQuery("#main-container .latest-news img").attr("src", "/symfony2/path/web/images/darkGray_arrow_20x28.png");
        }).fadeTo(100, 1);
    }
);

jQuery(".press-releases").hover(
    // hover in
    function(){
        jQuery(this).fadeTo(100, 0.3, function(){
            jQuery("#main-container .social-box.press-releases").css("background", "#566068");
            jQuery("#main-container .social-box.press-releases a").css("color", "#fff");
            jQuery("#main-container .press-releases h3").css("border-bottom-color", "#8e8e8e");
            jQuery("#main-container .press-releases img").attr("src", "/symfony2/path/web/images/yellow_arrow_20x28.png");
        }).fadeTo(100, 1);
    }, 
    // hover out
    function(){
        jQuery(this).fadeTo(100, 0.3, function(){
            jQuery("#main-container .social-box.press-releases").css("background", "#a1a8ae");
            jQuery("#main-container .social-box.press-releases a").css("color", "#000");
            jQuery("#main-container .press-releases h3").css("border-bottom-color", "#566068");
            jQuery("#main-container .press-releases img").attr("src", "/symfony2/path/web/images/darkGray_arrow_20x28.png");
        }).fadeTo(100, 1);
    }
);

jQuery(".latest-tweets").hover(
    // hover in
    function(){
        jQuery(this).fadeTo(100, 0.3, function(){
            jQuery("#main-container .social-box.latest-tweets").css("background", "#566068");
            jQuery("#main-container .social-box.latest-tweets a p").css("color", "#fff");
            jQuery("#main-container .latest-tweets h3").css("border-bottom-color", "#8e8e8e");
            jQuery("#main-container .latest-tweets img").attr("src", "/symfony2/path/web/images/twiter_yellow.png");
        }).fadeTo(100, 1);
    }, 
    // hover out
    function(){
        jQuery(this).fadeTo(100, 0.3, function(){
            jQuery("#main-container .social-box.latest-tweets").css("background", "#a1a8ae");
            jQuery("#main-container .social-box.latest-tweets a p").css("color", "#000");
            jQuery("#main-container .latest-tweets h3").css("border-bottom-color", "#566068");
            jQuery("#main-container .latest-tweets img").attr("src", "/symfony2/path/web/images/twiter_white_27x23.png");
        }).fadeTo(100, 1);
    }
);
