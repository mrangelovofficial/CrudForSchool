$(document).ready(function(){
  ContainerSize();
});

function ContainerSize(){
  var height = $(window).height();
  var header = $('header').height();
  var size = (height * 0.96) - header;
  var mTop = Math.floor((height - size - header) / 4);
  var fullSize = Math.floor(size);
  var container = $('#containerR');
  container.css({
   'margin-top' : mTop,
   'height' : fullSize
});

}
