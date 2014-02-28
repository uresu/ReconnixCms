jQuery(".news-item").hover(
    // hover in
    function(){
        jQuery(this).fadeTo(150, 0.3, function(){
            jQuery(this).css("background", "#fcfcfc");
        }).fadeTo(150, 1);
    }, 
    // hover out
    function(){
        jQuery(this).fadeTo(150, 0.3, function(){
            jQuery(this).css("background", "rgba(205, 209, 212, 0)");
        }).fadeTo(150, 1);
    }
);
