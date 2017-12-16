var index = 1;
var anchor = ["id1","id2","id3"]

function scrollToAnchor(aid){
  var aTag = $("a[name='"+ aid +"']");
  $('html,body').animate({scrollTop: aTag.offset().top},'slow');
}

$"quando scrollo giù"(function() {
  index++;
  scrollToAnchor(anchor[index]);
}

$"quando scrollo sù"(function() {
  index--;
  scrollToAnchor(anchor[index]);

}

$("body").mousewheel(function(event) {
    console.log(event.deltaX, event.deltaY, event.deltaFactor);
});
