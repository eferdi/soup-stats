/*  PROJECT POP-UP
==================================================== */
	$(document).ready(function () {
		$('#project').popup({
		transition: 'all 0.5s'
		});
	});

/*  FLEXSLIDER
==================================================== */
	$(window).load(function(){
		$('.flexslider').flexslider({
        animation: "fade",
		controlNav: true,
		easing: "easeOutQuad", 
		slideshowSpeed: 5000,
		animationSpeed: 1600,
		useCSS: false, 
		directionNav: false ,
			});
	});

/*  CONTACT FORM VALIDATE
==================================================== */
	$(window).load(function(){
		$("#contact-form").validate();
	});

/*  SMOOTH SCROLL
==================================================== */
	$('a[href*=#]:not([href=#])').click(function() {
		if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') 
        || location.hostname == this.hostname) {

        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
           if (target.length) {
             $('html,body').animate({
                 scrollTop: target.offset().top
            }, 1800);
            return false;
			}
		}
	});
  
/*  PORTFOLIO
==================================================== */
	$(function(){
		$('#Grid').mixitup();
	});

/*  EASYPIECHART
==================================================== */
	$(function() {
		$('.chart').easyPieChart({
			easing: ' easeOutSine',
			onStep: function(from, to, percent) {
				$(this.el).find('.percent').text(Math.round(percent));
			}
		});
	});

/*  NAVIGATION
==================================================== */
	$(document).ready(function() {
		$('#nav').onePageNav({
			begin: function() {
			console.log('start')
			},
			end: function() {
			console.log('stop')
			}
		});
	});

