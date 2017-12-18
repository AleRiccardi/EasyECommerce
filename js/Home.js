

$( document ).ready(function() {
  $('html,body').bind('mousewheel', function(event){
    console.log(event.originalEvent.wheelDelta);
    if (event.originalEvent.wheelDelta /120 < 0) { //aka se è stato mandata giu la rotellina del mouse
        $('html,body').animate({scrollTop: $("#homesection2").offset().top-150},'slow');
}


    if (event.originalEvent.wheelDelta /120 > 0) {//aka se è stato mandata sù la rotellina del mouse
      $('html,body').animate({scrollTop: $("#homesection").offset().top-150},'slow');
    }
  });
});
