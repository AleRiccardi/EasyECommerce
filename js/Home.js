
//
// function scrollToAnchor(aid){
// var aTag = $("a[name='"+ aid +"']");
// $('html,body').animate({scroll: aTag.offset().top},'slow');
// }



$( document ).ready(function() {
  var index = 1;

  $('html,body').bind('mousewheel', function(event){
    //////////////////////////////////////////////////////////////
    if (event.originalEvent.wheelDelta /120 < 0) { //aka se è stato mandata giu la rotellina del mouse
      switch (index) {

        case 1:
        index++;
        $('html,body').animate({scrollTop: $("h2").offset().top-150},'slow').delay(3000);
        break;

        case 2:
        index++;
        $('html,body').animate({scrollTop: $("h3").offset().top-150},'slow').delay(3000);
        break;

        default:
        break;
      }
    }


    if (event.originalEvent.wheelDelta /120 > 0) {//aka se è stato mandata sù la rotellina del mouse

      switch (index) {

        case 2:
        index--;
        $('html,body').animate({scrollTop: $("html").offset().top-150},'slow').delay(3000);
        break;

        case 3:
        index--;
        $('html,body').animate({scrollTop: $("h2").offset().top-150},'slow').delay(3000);
        break;

        default:
        break;
      }
    }
  });
});
