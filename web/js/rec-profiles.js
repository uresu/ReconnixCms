            jQuery(".pat-photo").hover(
                function(){
                    jQuery(".pat-profile").removeClass("not-selected");
                    jQuery(".steve-profile").addClass("not-selected");
                    jQuery(".philip-profile").addClass("not-selected");
                    jQuery(".paul-profile").addClass("not-selected");
                    jQuery(".danielle-profile").addClass("not-selected");

                    jQuery(".pat-large-photo").removeClass("not-selected");
                    jQuery(".steve-large-photo").addClass("not-selected");
                    jQuery(".philip-large-photo").addClass("not-selected");
                    jQuery(".paul-large-photo").addClass("not-selected");
                    jQuery(".danielle-large-photo").addClass("not-selected");

                    jQuery(".pat-photo").addClass('active');
                    jQuery(".steve-photo").removeClass('active');
                    jQuery(".philip-photo").removeClass('active');
                    jQuery(".paul-photo").removeClass('active');
                    jQuery(".danielle-photo").removeClass('active');
                },
                function(){}
            );

            jQuery(".steve-photo").hover(
                // hover in
                function(){
                    jQuery(".pat-profile").addClass("not-selected");
                    jQuery(".steve-profile").removeClass("not-selected");
                    jQuery(".philip-profile").addClass("not-selected");
                    jQuery(".paul-profile").addClass("not-selected");
                    jQuery(".danielle-profile").addClass("not-selected");

                    jQuery(".pat-large-photo").addClass("not-selected");
                    jQuery(".steve-large-photo").removeClass("not-selected");
                    jQuery(".philip-large-photo").addClass("not-selected");
                    jQuery(".paul-large-photo").addClass("not-selected");
                    jQuery(".danielle-large-photo").addClass("not-selected");

                    jQuery(".pat-photo").removeClass('active');
                    jQuery(".steve-photo").addClass('active');
                    jQuery(".philip-photo").removeClass('active');
                    jQuery(".paul-photo").removeClass('active');
                    jQuery(".danielle-photo").removeClass('active');
                }, 
                // hover out

                function(){
                    jQuery(this).find('.gotcolors').stop().animate({opacity: 1}, 500);
                }
            );

            jQuery(".philip-photo").hover(
                // hover in
                function(){
                    jQuery(".pat-profile").addClass("not-selected");
                    jQuery(".steve-profile").addClass("not-selected");
                    jQuery(".philip-profile").removeClass("not-selected");
                    jQuery(".paul-profile").addClass("not-selected");
                    jQuery(".danielle-profile").addClass("not-selected");

                    jQuery(".pat-large-photo").addClass("not-selected");
                    jQuery(".steve-large-photo").addClass("not-selected");
                    jQuery(".philip-large-photo").removeClass("not-selected");
                    jQuery(".paul-large-photo").addClass("not-selected");
                    jQuery(".danielle-large-photo").addClass("not-selected");

                    jQuery(".pat-photo").removeClass('active');
                    jQuery(".steve-photo").removeClass('active');
                    jQuery(".philip-photo").addClass('active');
                    jQuery(".paul-photo").removeClass('active');
                    jQuery(".danielle-photo").removeClass('active');
                }, 
                // hover out
                function(){}
            );

            jQuery(".paul-photo").hover(
                // hover in
                function(){
                    jQuery(".pat-profile").addClass("not-selected");
                    jQuery(".steve-profile").addClass("not-selected");
                    jQuery(".philip-profile").addClass("not-selected");
                    jQuery(".paul-profile").removeClass("not-selected");
                    jQuery(".danielle-profile").addClass("not-selected");

                    jQuery(".pat-large-photo").addClass("not-selected");
                    jQuery(".steve-large-photo").addClass("not-selected");
                    jQuery(".philip-large-photo").addClass("not-selected");
                    jQuery(".paul-large-photo").removeClass("not-selected");
                    jQuery(".danielle-large-photo").addClass("not-selected");

                    jQuery(".pat-photo").removeClass('active');
                    jQuery(".steve-photo").removeClass('active');
                    jQuery(".philip-photo").removeClass('active');
                    jQuery(".paul-photo").addClass('active');
                    jQuery(".danielle-photo").removeClass('active');
                }, 
                // hover out
                function(){}
            );

            jQuery(".danielle-photo").hover(
                // hover in
                function(){
                    jQuery(".pat-profile").addClass("not-selected");
                    jQuery(".steve-profile").addClass("not-selected");
                    jQuery(".philip-profile").addClass("not-selected");
                    jQuery(".paul-profile").addClass("not-selected");
                    jQuery(".danielle-profile").removeClass("not-selected");

                    jQuery(".pat-large-photo").addClass("not-selected");
                    jQuery(".steve-large-photo").addClass("not-selected");
                    jQuery(".philip-large-photo").addClass("not-selected");
                    jQuery(".paul-large-photo").addClass("not-selected");
                    jQuery(".danielle-large-photo").removeClass("not-selected");

                    jQuery(".pat-photo").removeClass('active');
                    jQuery(".steve-photo").removeClass('active');
                    jQuery(".philip-photo").removeClass('active');
                    jQuery(".paul-photo").removeClass('active');
                    jQuery(".danielle-photo").addClass('active');
                }, 
                // hover out
                function(){}
            );