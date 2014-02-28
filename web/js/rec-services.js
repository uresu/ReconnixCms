$('html').addClass('jc');
jQuery(document).ready(function(){
  $('html').removeClass('js');
  var hash = window.location.hash;

  if(hash){
    switch(hash){
      case '#eco':
        show_eco(false);
        break;
      case '#digital':
        show_digital(false);
        break;
      case '#cloud':
        show_cloud(false);
        break;
      case '#managed':
        show_managed(false);
        break;
      default:
        break;
    }
  }
  
});

jQuery(".open-source-service").click(
  function(){
    show_eco(true);
  }
);

jQuery(".digital-delivery-service").click(
  function(){
    show_digital(true);
  }
);

jQuery(".cloud-services-service").click(
  function(){
    show_cloud(true);
  }
);

jQuery(".managed-hosting-service").click(
  function(){
    show_managed(true);
  }
);

function show_eco(slide){
  if(slide){
    jQuery(".service-banner.down-arrow").animate({
      margin: "0 0 0 10%"
    }, 250, function(){
    // animation complete
    });
  }else{
    jQuery(".service-banner.down-arrow").css("margin", "0 0 0 10%");
  }

  jQuery(".open-source-service").css("background", "#566068");
  jQuery(".digital-delivery-service").css("background", "#a1a8ae");
  jQuery(".cloud-services-service").css("background", "#a1a8ae");
  jQuery(".managed-hosting-service").css("background", "#a1a8ae");

  jQuery(".cloud-services-service-text").addClass("not-selected");
  jQuery(".managed-hosting-service-text").addClass("not-selected");
  jQuery(".digital-delivery-service-text").addClass("not-selected");
  jQuery(".open-source-service-text").removeClass("not-selected");
}

function show_digital(slide){
  if(slide){ 
    jQuery(".service-banner.down-arrow").animate({
      margin: "0 0 0 34%"
    }, 250, function(){
    // animation complete
    });
  }else{
    jQuery(".service-banner.down-arrow").css("margin", "0 0 0 34%");
  } 

jQuery(".open-source-service").css("background", "#a1a8ae");
jQuery(".digital-delivery-service").css("background", "#566068");
jQuery(".cloud-services-service").css("background", "#a1a8ae");
jQuery(".managed-hosting-service").css("background", "#a1a8ae");

jQuery(".open-source-service-text").addClass("not-selected");
jQuery(".cloud-services-service-text").addClass("not-selected");
jQuery(".managed-hosting-service-text").addClass("not-selected");
jQuery(".digital-delivery-service-text").removeClass("not-selected");
}

function show_cloud(slide){
  if(slide){
    jQuery(".service-banner.down-arrow").animate({
      margin: "0 0 0 58%"
    }, 250, function(){
    // animation complete
    });
  }else{
    jQuery(".service-banner.down-arrow").css("margin", "0 0 0 58%");
  }

  jQuery(".open-source-service").css("background", "#a1a8ae");
  jQuery(".digital-delivery-service").css("background", "#a1a8ae");
  jQuery(".cloud-services-service").css("background", "#566068");
  jQuery(".managed-hosting-service").css("background", "#a1a8ae");

  jQuery(".open-source-service-text").addClass("not-selected");
  jQuery(".cloud-services-service-text").removeClass("not-selected");
  jQuery(".managed-hosting-service-text").addClass("not-selected");
  jQuery(".digital-delivery-service-text").addClass("not-selected");
}

function show_managed(slide){
  if(slide){
    jQuery(".service-banner.down-arrow").animate({
      margin: "0 0 0 82%"
    }, 250, function(){
    // animation complete
    });
  }else{
    jQuery(".service-banner.down-arrow").css("margin", "0 0 0 82%");
  }

  jQuery(".open-source-service").css("background", "#a1a8ae");
  jQuery(".digital-delivery-service").css("background", "#a1a8ae");
  jQuery(".cloud-services-service").css("background", "#a1a8ae");
  jQuery(".managed-hosting-service").css("background", "#566068");

  jQuery(".open-source-service-text").addClass("not-selected");
  jQuery(".cloud-services-service-text").addClass("not-selected");
  jQuery(".managed-hosting-service-text").removeClass("not-selected");
  jQuery(".digital-delivery-service-text").addClass("not-selected");
}
