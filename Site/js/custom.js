
(function($) {

  new WOW().init();

  // jQuery(window).load(function() {
  //   jQuery("#preloader").delay(100).fadeOut("slow");
  //   jQuery("#load").delay(100).fadeOut("slow");
  // });


  //jQuery to collapse the navbar on scroll
  // $(window).scroll(function() {
  //   if ($(".navbar").offset().top > 50) {
  //     $(".navbar-fixed-top").addClass("top-nav-collapse");
  //   }
  //
  //   else {
  //     $(".navbar-fixed-top").removeClass("top-nav-collapse");
  //   }
  // });

  //jQuery for page scrolling feature - requires jQuery Easing plugin
  $(function() {

    // $('.navbar-nav li a').on('click', function(event) {
    //
    //   if ($(this).is('a:not([href^="#"])') || $(this).attr("href") == '#') {
    //     return;
    //   }
    //   var $anchor = $(this);
    //   $('html, body').stop().animate({
    //     scrollTop: $($anchor.attr('href')).offset().top
    //   }, 1500, 'easeInOutExpo');
    //   event.preventDefault();
    // });

    // $('.page-scroll a').on('click', function(event) {
    //   var $anchor = $(this);
    //   $('html, body').stop().animate({
    //     scrollTop: $($anchor.attr('href')).offset().top
    //   }, 1500, 'easeInOutExpo');
    //   event.preventDefault();
    // });

    $(".nav li").on("click", function() {
      $(".nav li ").removeClass("active");
      $(this).addClass("active");
    });
  });

	var navMain = $(".navbar-collapse");
	navMain.on("click", "a:not([data-toggle])", null, function () {
	   navMain.collapse('hide');
	});

  $('#intro').carousel({
        interval: 8000,
        pause: false
  }).on('slide.bs.carousel', function () {
  document.getElementById('player').pause();
});

$('#player').on('ended', function () {
  if (document.exitFullscreen) {
       document.exitFullscreen(); // Standard
   } else if (document.webkitExitFullscreen) {
       document.webkitExitFullscreen(); // Blink
   } else if (document.mozCancelFullScreen) {
       document.mozCancelFullScreen(); // Gecko
   } else if (document.msExitFullscreen) {
       document.msExitFullscreen(); // Old IE
   }
       this.currentTime = 0;
  $('.carousel').carousel('next');
});








       // $.get("nav.html", function(data){
       //     $("#nav-placeholder").replaceWith(data);
       // });
       $(window).scroll(function() {
if ($(this).scrollTop() > 100) {
$('.back-to-top').fadeIn('slow');
} else {
$('.back-to-top').fadeOut('slow');
}
});

$('.back-to-top').click(function(){
$('html, body').animate({scrollTop : 0},1500, 'easeInOutExpo');
return false;
});



$('video').on('play', function (e) {
    $("#intro").carousel('pause');
});
$('video').on('stop pause ended', function (e) {
    $("#intro").carousel();
});

// $(window).load(function() {
//
//       var viewportWidth = $(window).width();
//       if (viewportWidth < 768) {
//               $(".navbar").removeClass("navlogo").addClass("navbar-brand");
//       }
//
//       $(window).resize(function () {
//
//           if (viewportWidth < 768) {
//               $(".navbar").removeClass("navlogo").addClass("navbar-brand");
//           }
//       });
//   });


// window.addEventListener('click',
//   function() {
    $( document ).ready(function() {
    if($(window).width() <768)
    {
    console.log("click fn widht <768");

    $(".navlogo").css("display","none");

    $(".navbar-brand").css("display", "block");
    // $(".navlogo").css("visibility", "hidden");
    }

    if($(window).width() >=768)
     {
       console.log("click fn widht >768");
       $(".navlogo").css("display","inline-block");
       $(".navbar-brand").css("display", "none");
    }

  });
// $(".navbar-brand").css("display","none");

$(window).load(function()
{
if($(window).width() <768)
{
console.log("load fn widht <768");

$(".navlogo").css("display","none");

$(".navbar-brand").css("display", "block");
// $(".navlogo").css("visibility", "hidden");
}
if($(window).width() >=768)
{


  $(".navlogo").css("display","inline-block");
  $(".navbar-brand").css("display", "none");
}
});

 $(window).resize(function()
{
if($(window).width() <768)
{

console.log("rsz fn widht <768");
// $(".navlogo").css("display","none");


$(".navlogo").css("display","none");
$(".navbar-brand").css("display", "block");
}
if($(window).width() >=768)
 {
   console.log("rsz fn widht >768");
   $(".navlogo").css("display","inline-block");
   $(".navbar-brand").css("display", "none");
}

});


  $("#player").css("visibility", "hidden");

  $("#videocover").click(function() {
      var video = $("#player").get(0);
        $("#player").css("visibility", "visible");
      video.play();

      $(this).css("visibility", "hidden");

      return false;
  });

  $("#player").bind(" ended", function() {
      $("#videocover").css("visibility", "visible");
  });
}
)(jQuery);
