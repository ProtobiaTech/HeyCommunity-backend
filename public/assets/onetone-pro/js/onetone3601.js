  ///// contact form
  
  function IsEmail(email) {
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(!regex.test(email)) {
           return false;
        }else{
           return true;
        }
      }
	  
	 
	jQuery("form.contact-form #submit").click(function(){
	
	
	var obj = jQuery(this).parents(".contact-form");
	obj.find(".noticefailed").text("");
	var sendto  = obj.find("input#sendto").val();
	var ver     = obj.find(".contact-form-ver").val();
	var email_error = obj.find(".email_error").val();
	var name_error = obj.find(".name_error").val();
	var message_error = obj.find(".message_error").val();
	
	if( typeof email_error == 'undefined' || email_error == '' )
	email_error = 'Please enter valid email.';
	if( typeof name_error == 'undefined' || name_error == '' )
	name_error = 'Please enter your name.';
	if( typeof message_error == 'undefined' || message_error == '' )
	message_error = 'Message is required.';
	
	//////
	if( typeof ver !== 'undefined' && ver == '2'){
	var values = new Array();
	var error  = 0;
	obj.find("fieldset").find('input, select, textarea').each(
    function(index){
		values[index] = new Array(); 
        var field = jQuery(this);
		values[index]['name'] = field.data('name');
		values[index]['value'] = field.val();
        if(typeof field.data('required') !=='undefined' && field.data('required') =='1' ){
			if( values[index]['value'] == '' ){
				
				obj.find(".noticefailed").text( values[index]['name'] + " is required.");
	            error = 1;
			
				 return false;
				}
           }
			
			if( field.attr('type') == 'email' ){
				if( !IsEmail( values[index]['value'] ) ) {
	               obj.find(".noticefailed").text( email_error );
				   error = 1;
	               return false;
	                 }
				}
    });
	if( error == 1) return false;
	obj.find(".noticefailed").html("");
	obj.find(".noticefailed").append("<img alt='loading' class='loading' src='"+onetone_params.themeurl+"/images/loading.gif' />");
	 jQuery.ajax({
				 type:"POST",
				 dataType:"json",
				 url:onetone_params.ajaxurl,
				 data: {
                'values': jQuery.param(values),
				'action':'onetone_contact_advanced',
				'sendto':sendto
            },
				 success:function(data){
					 if(data.error==0){
						 
						 obj.find(".noticefailed").addClass("noticesuccess").removeClass("noticefailed");
					     obj.find(".noticesuccess").html(data.msg);
						 }else{
							 obj.find(".noticefailed").html(data.msg);	
							 }
		           jQuery('.loading').remove();
				   obj[0].reset(); 
		           return false;
				   },error:function(){
					   obj.find(".noticefailed").html("Error.");
					   obj.find('.loading').remove();
					   return false;
					   }
					   });
	 return false;
	}
	/////
	
	var Name    = obj.find("input#name").val();
	var Email   = obj.find("input#email").val();
	var Message = obj.find("textarea#message").val();
	
	

   if( !IsEmail( Email ) ) {
	obj.find(".noticefailed").text( email_error );
	return false;
	}
	if(Name ===""){
	obj.find(".noticefailed").text( name_error );
	return false;
	}
	if(Message === ""){
	obj.find(".noticefailed").text( message_error );
	return false;
	}
	obj.find(".noticefailed").html("");
	obj.find(".noticefailed").append("<img alt='loading' class='loading' src='"+onetone_params.themeurl+"/images/loading.gif' />");
	
	 jQuery.ajax({
				 type:"POST",
				 dataType:"json",
				 url:onetone_params.ajaxurl,
				 data:"Name="+Name+"&Email="+Email+"&Message="+Message+"&sendto="+sendto+"&action=onetone_contact",
				 success:function(data){
					 if(data.error==0){
						 obj.find(".noticefailed").addClass("noticesuccess").removeClass("noticefailed");
					     obj.find(".noticesuccess").html(data.msg);
						 }else{
							 obj.find(".noticefailed").html(data.msg);	
							 }
		           jQuery('.loading').remove();obj[0].reset(); 
		           return false;
				   },error:function(){
					   obj.find(".noticefailed").html("Error.");
					   obj.find('.loading').remove();
					   return false;
					   }
					   });
	 });


  //top menu

 jQuery(".site-navbar,.home-navbar").click(function(){
				jQuery(".top-nav").toggle();
			});
	
  jQuery('.top-nav ul li').hover(function(){
	jQuery(this).find('ul:first').slideDown(100);
	jQuery(this).addClass("hover");
	},function(){
	jQuery(this).find('ul').css('display','none');
	jQuery(this).removeClass("hover");
	});
  jQuery('.top-nav li ul li:has(ul)').find("a:first").append(" <span class='menu_more'>»</span> ");
 
   jQuery(".top-nav > ul > li,.main-nav > li").click(function(){
	jQuery(".top-nav > ul > li,.main-nav > li").removeClass("active");
	jQuery(this).addClass("active");
    });
   
   //
     ////
  var windowWidth = jQuery(window).width(); 
  if(windowWidth > 939){
	  if(jQuery(".site-main .sidebar").height() > jQuery(".site-main .main-content").height()){
		  jQuery(".site-main .main-content").css("height",(jQuery(".site-main .sidebar").height()+140)+"px");
		  }
	}else{
		jQuery(".site-main .main-content").css("height","auto");
		}
	jQuery(window).resize(function() {
	var windowWidth = jQuery(window).width(); 
	 if(windowWidth > 939){
	  if(jQuery(".site-main .sidebar").height() > jQuery(".site-main .main-content").height()){
		  jQuery(".site-main .main-content").css("height",(jQuery(".site-main .sidebar").height()+140)+"px");
		  }
	}		else{
		jQuery(".site-main .main-content").css("height","auto");
		}	
		
		if(windowWidth > 919){
			jQuery(".top-nav").show();
		}else{
			jQuery(".top-nav").hide();
			}
		
  });

		



// sticky menu

(function($){
	$.fn.sticky = function( options ) {
		// adding a class to users div
		$(this).addClass('sticky-header');
		var settings = $.extend({
            'scrollSpeed '  : 500
            }, options);


   ////// get homepage sections
	var sections = [];
				jQuery(".top-nav .onetone-menuitem > a").each(function() {
				linkHref =  $(this).attr('href').split('#')[1];
				$target =  $('#' + linkHref);
 
				if($target.length) {
					topPos = $target.offset().top;
					sections[linkHref] = Math.round(topPos);
				
					
				}
			});
				
		//////////		
				
		return $('.sticky-header .home-navigation ul li.onetone-menuitem a').each( function() {
			
			if ( settings.scrollSpeed ) {

				var scrollSpeed = settings.scrollSpeed

			}
			
			
			  if( $("body.admin-bar").length){
		if( $(window).width() < 765) {
				stickyTop = 46;
				
			} else {
				stickyTop = 32;
			}
	  }
	  else{
		  stickyTop = 0;
		  }
		  $(this).css({'top':stickyTop});

			var stickyMenu = function(){

				var scrollTop = $(window).scrollTop(); 
				if (scrollTop > stickyTop) { 
					$('.sticky-header').css({ 'position': 'fixed'}).addClass('fxd');
					} else {
						$('.sticky-header').css({ 'position': 'static' }).removeClass('fxd'); 
					}   
					
			//// set nav menu active status
			var returnValue = null;
			var windowHeight = Math.round($(window).height() * 0.3);

			for(var section in sections) {
				
				if((sections[section] - windowHeight) < scrollTop) {
					position = section;
					
				}
			}
			 
          if( typeof position !== "undefined" && position !== null ) {
			 
				jQuery(".home-navigation .onetone-menuitem ").removeClass("current");
			    jQuery(".home-navigation .onetone-menuitem ").find('a[href$="#' + position + '"]').parent().addClass("current");;
		  }

        ////
			};
			stickyMenu();
			$(window).scroll(function() {
				 stickyMenu();
			});
			  $(this).on('click', function(e){
				var selectorHeight = $('.sticky-header').height();   
				e.preventDefault();
		 		var id = $(this).attr('href');
				if(typeof $('section'+ id).offset() !== 'undefined'){
				if( $("header").css("position") === "static")
				goTo = $(id).offset().top  - 2*selectorHeight;
				else
				 goTo = $(id).offset().top - selectorHeight;
				 
				$("html, body").animate({ scrollTop: goTo }, scrollSpeed);
				}

			});	
					
		});

	}

})(jQuery);

//slider
 if(jQuery("section.homepage-slider").length){
 jQuery("#onetone-owl-slider").owlCarousel({
	navigation : false, // Show next and prev buttons
	slideSpeed : 300,
	items:1,
	autoplay:true,
	loop:true,
	paginationSpeed : 400,
	singleItem:true,
	autoPlay:parseInt(onetone_params.slideSpeed)
 
});
}

jQuery(document).ready(function($){
								
 $(".site-nav-toggle").click(function(){
                $(".site-nav").toggle();
            });
 // retina logo
if( window.devicePixelRatio > 1 ){
	if($('.normal_logo').length && $('.retina_logo').length){
		$('.normal_logo').hide();
		$('.retina_logo').show();
		}
	//
	$('.page-title-bar').addClass('page-title-bar-retina');
	
	}
	
//video background
								
if(typeof onetone_bigvideo !== 'undefined' && onetone_bigvideo!=null){
for(var i=0;i<onetone_bigvideo.length;i++){
$(onetone_bigvideo[i].video_section_item).tubular(onetone_bigvideo[i].options);
   }
  }
  
  $(".homepage section.section").each(function(){
	if($(this).find("#tubular-container").length > 0){
		$(this).css({"height":($(window).height()-$("header").height())+"px"});
		$(this).find("#tubular-container,#tubular-player").css({"height":($(window).height()-$("header").height())+"px"});
		}						
 });
 
// BACK TO TOP 											
 $(window).scroll(function(){
		if($(window).scrollTop() > 200){
			$("#back-to-top").fadeIn(200);
		} else{
			$("#back-to-top").fadeOut(200);
		}
	});
	
  	$('#back-to-top, .back-to-top').click(function() {
		  $('html, body').animate({ scrollTop:0 }, '800');
		  return false;
	});
	
/* ------------------------------------------------------------------------ */
/* parallax background image 										  	    */
/* ------------------------------------------------------------------------ */
 $('.onetone-parallax').parallax("50%", 0.1);

// parallax scrolling
if( $('.parallax-scrolling').length ){
	$('.parallax-scrolling').parallax({speed : 0.15});
	}
	
//woocommerce
$('.onetone-quantity .minus').click(function(){
 var qtyWrap  = $(this).parent('.quantity');
 var quantity =  parseInt(qtyWrap.find('.qty').val());
 var min_num  =  parseInt(qtyWrap.find('.qty').attr('min'));
 var max_num  =  parseInt(qtyWrap.find('.qty').attr('max'));
 var step     =  parseInt(qtyWrap.find('.qty').attr('step'));
 
 if( quantity > min_num){
	 quantity = quantity - step;
	 if( quantity > 0 )
	 qtyWrap.find('.qty').val(quantity);
	 }
  });
$('.onetone-quantity .plus').click(function(){
  var qtyWrap  = $(this).parent('.quantity');
  var quantity =  parseInt(qtyWrap.find('.qty').val());
  var min_num  =  parseInt(qtyWrap.find('.qty').attr('min'));
  var max_num  =  parseInt(qtyWrap.find('.qty').attr('max'));
  var step     =  parseInt(qtyWrap.find('.qty').attr('step'));
 if( max_num ){
	 if( quantity < max_num ){
	 quantity = quantity + step;
	 qtyWrap.find('.qty').val(quantity);
	  }
	 }else{
		 quantity = quantity + step;
		qtyWrap.find('.qty').val(quantity); 
		 }
  });

$('.variations_form .single_add_to_cart_button').prepend('<i class="fa fa-shopping-cart"></i> ');
/* ------------------------------------------------------------------------ */
/*  sticky header             	  								  	    */
/* ------------------------------------------------------------------------ */
	
jQuery(window).scroll(function(){
							   
		if( jQuery("body.admin-bar").length ){
		if( jQuery(window).width() < 765 ) {
				stickyTop = 46;
			} else {
				stickyTop = 32;
			}
	  }
	  else{
		        stickyTop = 0;
		  }
		  var scrollTop = $(window).scrollTop(); 
				if (scrollTop > stickyTop) { 
				    $('.fxd-header').css({'top':stickyTop}).show();
					$('header').addClass('fixed-header');
				}else{
					$('.fxd-header').hide();
					$('header').removeClass('fixed-header');
					}
 });
 

	
	
// scheme
 if( typeof onetone_params.primary_color !== 'undefined' && onetone_params.primary_color !== '' ){
 less.modifyVars({
        '@color-main': onetone_params.primary_color
    });
   }
   
/* ------------------------------------------------------------------------ */
/*  sticky header             	  								  	    */
/* ------------------------------------------------------------------------ */
 $(document).on('click',"header .main-header .site-nav ul a[href^='#'],a.scroll,.onetone-nav a[href^='#']", function(e){
				if($("body.admin-bar").length){
				  if($(window).width() < 765) {
						  stickyTop = 46;
						  
					  } else {
						  stickyTop = 32;
					  }
				}
				else{
						  stickyTop = 0;
					}
					
						var selectorHeight = 0;
                if( $('.fxd-header').length )
			    var selectorHeight = $('.fxd-header').height();  
				
				if($(window).width() <= 919) {
					$(".site-nav").hide();
					}
								
				var scrollTop = $(window).scrollTop(); 
				e.preventDefault();
		 		var id = $(this).attr('href');
				if(typeof $(id).offset() !== 'undefined'){
				     var goTo = $(id).offset().top - 2*selectorHeight - stickyTop  + 1;
				     $("html, body").animate({ scrollTop: goTo }, 1000);
				}

			});	
$('header .fxd-header .site-nav ul').onePageNav({filter: 'a[href^="#"]',scrollThreshold:0.3});	

 /* ------------------------------------------------------------------------ */
/*  smooth scrolling  btn       	  								  	    */
/* ------------------------------------------------------------------------ */

  $("div.page a[href^='#'],div.post a[href^='#'],div.home-wrapper a[href^='#'],.banner-scroll a[href^='#']").on('click', function(e){
				var selectorHeight = $('header').height();   
				var scrollTop = $(window).scrollTop(); 
				e.preventDefault();
		 		var id = $(this).attr('href');
				if(typeof $(id).offset() !== 'undefined'){
				var goTo = $(id).offset().top - selectorHeight;
				$("html, body").animate({ scrollTop: goTo }, 1000);
				}

			});	
  
  
 //portfolio carousel
  if($("#related-portfolio").length){
 $("#related-portfolio").owlCarousel({
	navigation : false, // Show next and prev buttons
	pagination: false,
	items:4,
	slideSpeed : 300,
	paginationSpeed : 400,
	singleItem:false,
	autoPlay:parseInt(onetone_params.slideSpeed)
 
});
 }
 
 
 // portfolio filter

jQuery(function ($) {
    
    var filterList = {
    
        init: function () {
        
            // MixItUp plugin
            // http://mixitup.io
            $('.portfolio-list-filter .portfolio-list-items').mixitup({
                targetSelector: '.portfolio-box-wrap',
                filterSelector: '.filter',
                effects: ['fade'],
                easing: 'snap',
                // call the hover effect
                onMixEnd: filterList.hoverEffect()
            });                
        
        },
        
        hoverEffect: function () {             
        
        }
    };
    
    // Run the show!
    filterList.init();
	
    
});        


  $('iframe').each(function(){
							
		if( typeof $(this).attr('width') !=='undefined' && typeof $(this).attr('height') !=='undefined'){
			if( $(this).attr('width') > $(this).outerWidth() ){
			var iframe_height =  $(this).attr('height')*$(this).outerWidth()/$(this).attr('width');
			
			$(this).css({'height':iframe_height});
			
			}
			}
		
		});

   //shop carousel
  
if($(".woocommerce.single-product .thumbnails").length){
 $(".woocommerce.single-product .thumbnails").owlCarousel({
	navigation : true, // Show next and prev buttons
	pagination: false,
	items:4,
	navigationText : ['<i class="fa fa-angle-double-left"></i>', '<i class="fa fa-angle-double-right"></i>'],
	slideSpeed : 300,
	paginationSpeed : 400,
	singleItem:false
	
 
});}
 
 //woo

$(".product-image").each(function() {
               $(this).hover(function() {
                 if($(this).find('.product-image-back img').length){
					   $(this).find('.product-image-front').css({'opacity':'0'});
					 }
               },
           function() {
               $(this).find('.product-image-front').css({'opacity':'1'});
           });
           });

 //masonry
 // portfolio
 $('.onetone-masonry').masonry({
 // options
                itemSelector : '.portfolio-box-wrap'
            });
 // blog
 $('.blog-grid').masonry({
 // options
                itemSelector : '.entry-box-wrap'
            });

 $('.blog-timeline-wrap .entry-box-wrap').each(function(){
													   
	var position   = $(this).offset();		
	var left       = position.left;
	var wrap_width = $(this).parents('.blog-timeline-wrap').innerWidth();
	if( left/wrap_width > 0.5){
		  $(this).removeClass('timeline-left').addClass('timeline-right');
		}else{
		  $(this).removeClass('timeline-right').addClass('timeline-left');	
 }
 });
	
 
  //prettyPhoto
 
 $("a[rel^='portfolio-image']").prettyPhoto();	 
 
 // gallery lightbox
 $(".gallery .gallery-item a").prettyPhoto({animation_speed:'fast',slideshow:10000, hideflash: true});
  
/* ------------------------------------------------------------------------ */
/*  animation												        	    */
/* ------------------------------------------------------------------------ */
										  
 $('.animated').each(function(){
			 if($(this).data('imageanimation')==="yes"){
		         $(this).find("img,i.fa").css("visibility","hidden");	
		 }
		 else{
	           $(this).css("visibility","hidden");	
		 }					   
	 });
	
 if(jQuery().waypoint) {
		$('.animated').waypoint(function() {
			$(this).css('visibility', 'visible');
			$(this).find("img,i.fa").css("visibility","visible");	

			// this code is executed for each appeared element
			var animation_type       = $(this).data('animationtype');
			var animation_duration   = $(this).data('animationduration');
	        var image_animation      = $(this).data('imageanimation');
			 if(image_animation === "yes"){
						 
			$(this).find("img,i.fa").addClass("animated "+animation_type);

			if(animation_duration) {
				$(this).find("img,i.fa").css('-moz-animation-duration', animation_duration+'s');
				$(this).find("img,i.fa").css('-webkit-animation-duration', animation_duration+'s');
				$(this).find("img,i.fa").css('-ms-animation-duration', animation_duration+'s');
				$(this).find("img,i.fa").css('-o-animation-duration', animation_duration+'s');
				$(this).find("img,i.fa").css('animation-duration', animation_duration+'s');
			}
			
				 
			 }else{
            $(this).addClass(animation_type);
			if(animation_duration) {
				$(this).css('-moz-animation-duration', animation_duration+'s');
				$(this).css('-webkit-animation-duration', animation_duration+'s');
				$(this).css('-ms-animation-duration', animation_duration+'s');
				$(this).css('-o-animation-duration', animation_duration+'s');
				$(this).css('animation-duration', animation_duration+'s');
			}
			 }
		},{ triggerOnce: true, offset: 'bottom-in-view' });
	}


/* ------------------------------------------------------------------------ */
/* parallax background image 										  	    */
/* ------------------------------------------------------------------------ */
 $('.onetone-parallax').parallax("50%", 0.1);
	 
/* ------------------------------------------------------------------------ */
/*  Section Heading Color													*/
/* ------------------------------------------------------------------------ */
	 
 $('section').each(function(){
					var headingcolor = $(this).data("headingcolor");
					if(headingcolor != ""){
						$(this).find("h1,h2,h3,h4,h5,h6").css("color",headingcolor);
						}
				});
 
  $(".section-banner").each(function(){
  var videoHeight =$(window).height();
  if( typeof onetone_params.header_cover_video_background !== 'undefined' && onetone_params.header_cover_video_background == '0'){
  var videoHeight = videoHeight-$('.sticky-header').height();
  }
  if( typeof onetone_video !== 'undefined' && typeof onetone_video.header_cover_video_background_html5 !== 'undefined' && onetone_video.header_cover_video_background_html5 == '0'){
	  
  var videoHeight = videoHeight-$('.sticky-header').height();
  $(this).find("#big-video-wrap").css({"position":"absolute"});
  
  }
  $(this).css({"min-height":videoHeight});
  $(this).find("#tubular-container,#big-video-vid").css({"height":videoHeight});
  
  });
 
 });

// Generated by CoffeeScript 1.6.2
/*!
 Waypoints - v2.0.5
Copyright (c) 2011-2014 Caleb Troughton
Licensed under the MIT license.
https://github.com/imakewebthings/jquery-waypoints/blob/master/licenses.txt
*/


(function() {
  var __indexOf = [].indexOf || function(item) { for (var i = 0, l = this.length; i < l; i++) { if (i in this && this[i] === item) return i; } return -1; },
    __slice = [].slice;

  (function(root, factory) {
    if (typeof define === 'function' && define.amd) {
      return define('waypoints', ['jquery'], function($) {
        return factory($, root);
      });
    } else {
      return factory(root.jQuery, root);
    }
  })(window, function($, window) {
    var $w, Context, Waypoint, allWaypoints, contextCounter, contextKey, contexts, isTouch, jQMethods, methods, resizeEvent, scrollEvent, waypointCounter, waypointKey, wp, wps;

    $w = $(window);
    isTouch = __indexOf.call(window, 'ontouchstart') >= 0;
    allWaypoints = {
      horizontal: {},
      vertical: {}
    };
    contextCounter = 1;
    contexts = {};
    contextKey = 'waypoints-context-id';
    resizeEvent = 'resize.waypoints';
    scrollEvent = 'scroll.waypoints';
    waypointCounter = 1;
    waypointKey = 'waypoints-waypoint-ids';
    wp = 'waypoint';
    wps = 'waypoints';
    Context = (function() {
      function Context($element) {
        var _this = this;

        this.$element = $element;
        this.element = $element[0];
        this.didResize = false;
        this.didScroll = false;
        this.id = 'context' + contextCounter++;
        this.oldScroll = {
          x: $element.scrollLeft(),
          y: $element.scrollTop()
        };
        this.waypoints = {
          horizontal: {},
          vertical: {}
        };
        this.element[contextKey] = this.id;
        contexts[this.id] = this;
        $element.bind(scrollEvent, function() {
          var scrollHandler;

          if (!(_this.didScroll || isTouch)) {
            _this.didScroll = true;
            scrollHandler = function() {
              _this.doScroll();
              return _this.didScroll = false;
            };
            return window.setTimeout(scrollHandler, $[wps].settings.scrollThrottle);
          }
        });
        $element.bind(resizeEvent, function() {
          var resizeHandler;

          if (!_this.didResize) {
            _this.didResize = true;
            resizeHandler = function() {
              $[wps]('refresh');
              return _this.didResize = false;
            };
            return window.setTimeout(resizeHandler, $[wps].settings.resizeThrottle);
          }
        });
      }

      Context.prototype.doScroll = function() {
        var axes,
          _this = this;

        axes = {
          horizontal: {
            newScroll: this.$element.scrollLeft(),
            oldScroll: this.oldScroll.x,
            forward: 'right',
            backward: 'left'
          },
          vertical: {
            newScroll: this.$element.scrollTop(),
            oldScroll: this.oldScroll.y,
            forward: 'down',
            backward: 'up'
          }
        };
        if (isTouch && (!axes.vertical.oldScroll || !axes.vertical.newScroll)) {
          $[wps]('refresh');
        }
        $.each(axes, function(aKey, axis) {
          var direction, isForward, triggered;

          triggered = [];
          isForward = axis.newScroll > axis.oldScroll;
          direction = isForward ? axis.forward : axis.backward;
          $.each(_this.waypoints[aKey], function(wKey, waypoint) {
            var _ref, _ref1;

            if ((axis.oldScroll < (_ref = waypoint.offset) && _ref <= axis.newScroll)) {
              return triggered.push(waypoint);
            } else if ((axis.newScroll < (_ref1 = waypoint.offset) && _ref1 <= axis.oldScroll)) {
              return triggered.push(waypoint);
            }
          });
          triggered.sort(function(a, b) {
            return a.offset - b.offset;
          });
          if (!isForward) {
            triggered.reverse();
          }
          return $.each(triggered, function(i, waypoint) {
            if (waypoint.options.continuous || i === triggered.length - 1) {
              return waypoint.trigger([direction]);
            }
          });
        });
        return this.oldScroll = {
          x: axes.horizontal.newScroll,
          y: axes.vertical.newScroll
        };
      };

      Context.prototype.refresh = function() {
        var axes, cOffset, isWin,
          _this = this;

        isWin = $.isWindow(this.element);
        cOffset = this.$element.offset();
        this.doScroll();
        axes = {
          horizontal: {
            contextOffset: isWin ? 0 : cOffset.left,
            contextScroll: isWin ? 0 : this.oldScroll.x,
            contextDimension: this.$element.width(),
            oldScroll: this.oldScroll.x,
            forward: 'right',
            backward: 'left',
            offsetProp: 'left'
          },
          vertical: {
            contextOffset: isWin ? 0 : cOffset.top,
            contextScroll: isWin ? 0 : this.oldScroll.y,
            contextDimension: isWin ? $[wps]('viewportHeight') : this.$element.height(),
            oldScroll: this.oldScroll.y,
            forward: 'down',
            backward: 'up',
            offsetProp: 'top'
          }
        };
        return $.each(axes, function(aKey, axis) {
          return $.each(_this.waypoints[aKey], function(i, waypoint) {
            var adjustment, elementOffset, oldOffset, _ref, _ref1;

            adjustment = waypoint.options.offset;
            oldOffset = waypoint.offset;
            elementOffset = $.isWindow(waypoint.element) ? 0 : waypoint.$element.offset()[axis.offsetProp];
            if ($.isFunction(adjustment)) {
              adjustment = adjustment.apply(waypoint.element);
            } else if (typeof adjustment === 'string') {
              adjustment = parseFloat(adjustment);
              if (waypoint.options.offset.indexOf('%') > -1) {
                adjustment = Math.ceil(axis.contextDimension * adjustment / 100);
              }
            }
            waypoint.offset = elementOffset - axis.contextOffset + axis.contextScroll - adjustment;
            if ((waypoint.options.onlyOnScroll && (oldOffset != null)) || !waypoint.enabled) {
              return;
            }
            if (oldOffset !== null && (oldOffset < (_ref = axis.oldScroll) && _ref <= waypoint.offset)) {
              return waypoint.trigger([axis.backward]);
            } else if (oldOffset !== null && (oldOffset > (_ref1 = axis.oldScroll) && _ref1 >= waypoint.offset)) {
              return waypoint.trigger([axis.forward]);
            } else if (oldOffset === null && axis.oldScroll >= waypoint.offset) {
              return waypoint.trigger([axis.forward]);
            }
          });
        });
      };

      Context.prototype.checkEmpty = function() {
        if ($.isEmptyObject(this.waypoints.horizontal) && $.isEmptyObject(this.waypoints.vertical)) {
          this.$element.unbind([resizeEvent, scrollEvent].join(' '));
          return delete contexts[this.id];
        }
      };

      return Context;

    })();
    Waypoint = (function() {
      function Waypoint($element, context, options) {
        var idList, _ref;

        if (options.offset === 'bottom-in-view') {
          options.offset = function() {
            var contextHeight;

            contextHeight = $[wps]('viewportHeight');
            if (!$.isWindow(context.element)) {
              contextHeight = context.$element.height();
            }
            return contextHeight - $(this).outerHeight();
          };
        }
        this.$element = $element;
        this.element = $element[0];
        this.axis = options.horizontal ? 'horizontal' : 'vertical';
        this.callback = options.handler;
        this.context = context;
        this.enabled = options.enabled;
        this.id = 'waypoints' + waypointCounter++;
        this.offset = null;
        this.options = options;
        context.waypoints[this.axis][this.id] = this;
        allWaypoints[this.axis][this.id] = this;
        idList = (_ref = this.element[waypointKey]) != null ? _ref : [];
        idList.push(this.id);
        this.element[waypointKey] = idList;
      }

      Waypoint.prototype.trigger = function(args) {
        if (!this.enabled) {
          return;
        }
        if (this.callback != null) {
          this.callback.apply(this.element, args);
        }
        if (this.options.triggerOnce) {
          return this.destroy();
        }
      };

      Waypoint.prototype.disable = function() {
        return this.enabled = false;
      };

      Waypoint.prototype.enable = function() {
        this.context.refresh();
        return this.enabled = true;
      };

      Waypoint.prototype.destroy = function() {
        delete allWaypoints[this.axis][this.id];
        delete this.context.waypoints[this.axis][this.id];
        return this.context.checkEmpty();
      };

      Waypoint.getWaypointsByElement = function(element) {
        var all, ids;

        ids = element[waypointKey];
        if (!ids) {
          return [];
        }
        all = $.extend({}, allWaypoints.horizontal, allWaypoints.vertical);
        return $.map(ids, function(id) {
          return all[id];
        });
      };

      return Waypoint;

    })();
    methods = {
      init: function(f, options) {
        var _ref;

        options = $.extend({}, $.fn[wp].defaults, options);
        if ((_ref = options.handler) == null) {
          options.handler = f;
        }
        this.each(function() {
          var $this, context, contextElement, _ref1;

          $this = $(this);
          contextElement = (_ref1 = options.context) != null ? _ref1 : $.fn[wp].defaults.context;
          if (!$.isWindow(contextElement)) {
            contextElement = $this.closest(contextElement);
          }
          contextElement = $(contextElement);
          context = contexts[contextElement[0][contextKey]];
          if (!context) {
            context = new Context(contextElement);
          }
          return new Waypoint($this, context, options);
        });
        $[wps]('refresh');
        return this;
      },
      disable: function() {
        return methods._invoke.call(this, 'disable');
      },
      enable: function() {
        return methods._invoke.call(this, 'enable');
      },
      destroy: function() {
        return methods._invoke.call(this, 'destroy');
      },
      prev: function(axis, selector) {
        return methods._traverse.call(this, axis, selector, function(stack, index, waypoints) {
          if (index > 0) {
            return stack.push(waypoints[index - 1]);
          }
        });
      },
      next: function(axis, selector) {
        return methods._traverse.call(this, axis, selector, function(stack, index, waypoints) {
          if (index < waypoints.length - 1) {
            return stack.push(waypoints[index + 1]);
          }
        });
      },
      _traverse: function(axis, selector, push) {
        var stack, waypoints;

        if (axis == null) {
          axis = 'vertical';
        }
        if (selector == null) {
          selector = window;
        }
        waypoints = jQMethods.aggregate(selector);
        stack = [];
        this.each(function() {
          var index;

          index = $.inArray(this, waypoints[axis]);
          return push(stack, index, waypoints[axis]);
        });
        return this.pushStack(stack);
      },
      _invoke: function(method) {
        this.each(function() {
          var waypoints;

          waypoints = Waypoint.getWaypointsByElement(this);
          return $.each(waypoints, function(i, waypoint) {
            waypoint[method]();
            return true;
          });
        });
        return this;
      }
    };
    $.fn[wp] = function() {
      var args, method;

      method = arguments[0], args = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
      if (methods[method]) {
        return methods[method].apply(this, args);
      } else if ($.isFunction(method)) {
        return methods.init.apply(this, arguments);
      } else if ($.isPlainObject(method)) {
        return methods.init.apply(this, [null, method]);
      } else if (!method) {
        return $.error("jQuery Waypoints needs a callback function or handler option.");
      } else {
        return $.error("The " + method + " method does not exist in jQuery Waypoints.");
      }
    };
    $.fn[wp].defaults = {
      context: window,
      continuous: true,
      enabled: true,
      horizontal: false,
      offset: 0,
      triggerOnce: false
    };
    jQMethods = {
      refresh: function() {
        return $.each(contexts, function(i, context) {
          return context.refresh();
        });
      },
      viewportHeight: function() {
        var _ref;

        return (_ref = window.innerHeight) != null ? _ref : $w.height();
      },
      aggregate: function(contextSelector) {
        var collection, waypoints, _ref;

        collection = allWaypoints;
        if (contextSelector) {
          collection = (_ref = contexts[$(contextSelector)[0][contextKey]]) != null ? _ref.waypoints : void 0;
        }
        if (!collection) {
          return [];
        }
        waypoints = {
          horizontal: [],
          vertical: []
        };
        $.each(waypoints, function(axis, arr) {
          $.each(collection[axis], function(key, waypoint) {
            return arr.push(waypoint);
          });
          arr.sort(function(a, b) {
            return a.offset - b.offset;
          });
          waypoints[axis] = $.map(arr, function(waypoint) {
            return waypoint.element;
          });
          return waypoints[axis] = $.unique(waypoints[axis]);
        });
        return waypoints;
      },
      above: function(contextSelector) {
        if (contextSelector == null) {
          contextSelector = window;
        }
        return jQMethods._filter(contextSelector, 'vertical', function(context, waypoint) {
          return waypoint.offset <= context.oldScroll.y;
        });
      },
      below: function(contextSelector) {
        if (contextSelector == null) {
          contextSelector = window;
        }
        return jQMethods._filter(contextSelector, 'vertical', function(context, waypoint) {
          return waypoint.offset > context.oldScroll.y;
        });
      },
      left: function(contextSelector) {
        if (contextSelector == null) {
          contextSelector = window;
        }
        return jQMethods._filter(contextSelector, 'horizontal', function(context, waypoint) {
          return waypoint.offset <= context.oldScroll.x;
        });
      },
      right: function(contextSelector) {
        if (contextSelector == null) {
          contextSelector = window;
        }
        return jQMethods._filter(contextSelector, 'horizontal', function(context, waypoint) {
          return waypoint.offset > context.oldScroll.x;
        });
      },
      enable: function() {
        return jQMethods._invoke('enable');
      },
      disable: function() {
        return jQMethods._invoke('disable');
      },
      destroy: function() {
        return jQMethods._invoke('destroy');
      },
      extendFn: function(methodName, f) {
        return methods[methodName] = f;
      },
      _invoke: function(method) {
        var waypoints;

        waypoints = $.extend({}, allWaypoints.vertical, allWaypoints.horizontal);
        return $.each(waypoints, function(key, waypoint) {
          waypoint[method]();
          return true;
        });
      },
      _filter: function(selector, axis, test) {
        var context, waypoints;

        context = contexts[$(selector)[0][contextKey]];
        if (!context) {
          return [];
        }
        waypoints = [];
        $.each(context.waypoints[axis], function(i, waypoint) {
          if (test(context, waypoint)) {
            return waypoints.push(waypoint);
          }
        });
        waypoints.sort(function(a, b) {
          return a.offset - b.offset;
        });
        return $.map(waypoints, function(waypoint) {
          return waypoint.element;
        });
      }
    };
    $[wps] = function() {
      var args, method;

      method = arguments[0], args = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
      if (jQMethods[method]) {
        return jQMethods[method].apply(null, args);
      } else {
        return jQMethods.aggregate.call(null, method);
      }
    };
    $[wps].settings = {
      resizeThrottle: 100,
      scrollThrottle: 30
    };
    return $w.on('load.waypoints', function() {
      return $[wps]('refresh');
    });
  });

}).call(this);


/*
Plugin: jQuery Parallax
Version 1.1.3
Author: Ian Lunn
Twitter: @IanLunn
Author URL: http://www.ianlunn.co.uk/
Plugin URL: http://www.ianlunn.co.uk/plugins/jquery-parallax/

Dual licensed under the MIT and GPL licenses:
http://www.opensource.org/licenses/mit-license.php
http://www.gnu.org/licenses/gpl.html
*/

(function( $ ){
	var $window = $(window);
	var windowHeight = $window.height();

	$window.resize(function () {
		windowHeight = $window.height();
	});

	$.fn.parallax = function(xpos, speedFactor, outerHeight) {
		var $this = $(this);
		var getHeight;
		var firstTop;
		var paddingTop = 0;
		
		//get the starting position of each element to have parallax applied to it		
		$this.each(function(){
		    firstTop = $this.offset().top;
		});

		if (outerHeight) {
			getHeight = function(jqo) {
				return jqo.outerHeight(true);
			};
		} else {
			getHeight = function(jqo) {
				return jqo.height();
			};
		}
			
		// setup defaults if arguments aren't specified
		if (arguments.length < 1 || xpos === null) xpos = "50%";
		if (arguments.length < 2 || speedFactor === null) speedFactor = 0.1;
		if (arguments.length < 3 || outerHeight === null) outerHeight = true;
		
		// function to be called whenever the window is scrolled or resized
		function update(){
			var pos = $window.scrollTop();				

			$this.each(function(){
				var $element = $(this);
				var top = $element.offset().top;
				var height = getHeight($element);

				// Check if totally above or totally below viewport
				if (top + height < pos || top > pos + windowHeight) {
					return;
				}

				$this.css('backgroundPosition', xpos + " " + Math.round((firstTop - pos) * speedFactor) + "px");
			});
		}		

		$window.bind('scroll', update).resize(update);
		update();
	};
})(jQuery);

