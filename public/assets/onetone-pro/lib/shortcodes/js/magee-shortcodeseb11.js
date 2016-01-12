// counterUP
(function( $ ){
  "use strict";

  $.fn.counterUp = function( options ) {

    // Defaults
    var settings = $.extend({
        'time': 400,
        'delay': 10
    }, options);

    return this.each(function(){

        // Store the object
        var $this = $(this);
        var $settings = settings;

        var counterUpper = function() {
            var nums = [];
            var divisions = $settings.time / $settings.delay;
            var num = $this.text();
            var isComma = /[0-9]+,[0-9]+/.test(num);
            num = num.replace(/,/g, '');
            var isInt = /^[0-9]+$/.test(num);
            var isFloat = /^[0-9]+\.[0-9]+$/.test(num);
            var decimalPlaces = isFloat ? (num.split('.')[1] || []).length : 0;

            // Generate list of incremental numbers to display
            for (var i = divisions; i >= 1; i--) {

                // Preserve as int if input was int
                var newNum = parseInt(num / divisions * i);

                // Preserve float if input was float
                if (isFloat) {
                    newNum = parseFloat(num / divisions * i).toFixed(decimalPlaces);
                }

                // Preserve commas if input had commas
                if (isComma) {
                    while (/(\d+)(\d{3})/.test(newNum.toString())) {
                        newNum = newNum.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
                    }
                }

                nums.unshift(newNum);
            }

            $this.data('counterup-nums', nums);
            $this.text('0');

            // Updates the number until we're done
            var f = function() {
                $this.text($this.data('counterup-nums').shift());
                if ($this.data('counterup-nums').length) {
                    setTimeout($this.data('counterup-func'), $settings.delay);
                } else {
                    delete $this.data('counterup-nums');
                    $this.data('counterup-nums', null);
                    $this.data('counterup-func', null);
                }
            };
            $this.data('counterup-func', f);

            // Start the count up
            setTimeout($this.data('counterup-func'), $settings.delay);
        };

        // Perform counts when the element gets into view
        $this.waypoint(counterUpper, { offset: '100%', triggerOnce: true });
    });

  };

})( jQuery );

jQuery(document).ready(function($) {
								
            var s=$(".magee-feature-box.style2");
            for(i=0;i<s.length;i++) {
                var t=$(s[i]).find(".icon-box").outerWidth();
				if($(s[i]).find("img.feature-box-icon").length){
				var t=$(s[i]).find("img.feature-box-icon").outerWidth();
				}
                t+=15;
                t+="px";
                $(s[i]).css({"padding-left":t});
            }
            var s=$(".magee-feature-box.style2.reverse");
            for(i=0;i<s.length;i++) {
                var t=$(s[i]).find(".icon-box").outerWidth();
				if($(s[i]).find("img.feature-box-icon").length)
				var t=$(s[i]).find("img.feature-box-icon").outerWidth();
				
                t+=15;
                t+="px";
                $(s[i]).css({"padding-left":0,"padding-right":t});
            }
            var s=$(".magee-feature-box.style3");
            for(i=0;i<s.length;i++) {
                var t=$(s[i]).find(".icon-box").outerWidth();
				if($(s[i]).find("img.feature-box-icon").length)
				var t=$(s[i]).find("img.feature-box-icon").outerWidth();
                t+="px";
                $(s[i]).find("h3").css({"line-height":t});
            }
            var s=$(".magee-feature-box.style4");
            for(i=0;i<s.length;i++) {
                var t=$(s[i]).find(".icon-box").outerWidth();
				if($(s[i]).find("img.feature-box-icon").length)
				var t=$(s[i]).find("img.feature-box-icon").outerWidth();
                t=t/2;
                t1=-t;
                t+="px";
                t1+="px";
                $(s[i]).css({"padding-top":t,"margin-top":t});
                $(s[i]).find(".icon-box").css({"top":t1,"margin-left":t1});
				$(s[i]).find("img.feature-box-icon").css({"top":t1,"margin-left":t1});
            }
  
 //
 
  $(".wow").each(function(){
	var duration = $(this).data("animationduration");
       if( typeof duration !== "undefined"){
		   $(this).css({"-webkit-animation-duration":duration+"s","animation-duration":duration+"s"});
		   }
    });
  //

  // contact form

  
 function MageeIsEmail(email) {
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(!regex.test(email)) {
           return false;
        }else{
           return true;
        }
      }
	  
 $(document).on("click","form.magee-contact-form #submit",function(){
									
	var obj = jQuery(this).parents(".magee-contact-form");
	obj.find(".contact-failed").text("");		
	var receiver  = obj.find("input#receiver").val();
	var email     = obj.find("input#email").val();
	var name      = obj.find("input#name").val();
	var subject   = obj.find("input#subject").val();
	var message   = obj.find("textarea#message").val();
	var terms     = obj.find("input#terms").val();
	var checkboxWarning = '';
	if( $('#checkboxWarning').length && $('#checkboxWarning').is(':checked'))
	 checkboxWarning = '1';
	

	obj.find(".contact-failed").append("<img alt='loading' class='loading' src='"+onetone_params.themeurl+"/images/AjaxLoader.gif' />");
	
	 $.ajax({
				 type:"POST",
				 dataType:"json",
				 url:onetone_params.ajaxurl,
				 data:"name="+name+"&email="+email+"&subject="+subject+"&receiver="+receiver+"&terms="+terms+"&message="+message+"&checkboxWarning="+checkboxWarning+"&action=magee_contact",
				 success:function(data){
					 if( data.error == 0 ){
						     obj.find(".contact-failed").addClass("notice-success");
					         obj.find(".contact-failed").html(data.msg);
							  jQuery('.loading').remove();obj[0].reset(); 
						 }else{
							 obj.find(".contact-failed").removeClass("notice-success");
							 obj.find(".contact-failed").html(data.msg);	
							 }
		          
		           return false;
				   },error:function(){
					   obj.find(".contact-failed").addClass("notice-error");
					   obj.find(".contact-failed").html("Error.");
					   obj.find('.loading').remove();
					   return false;
					   }
			 });
	
	 return false;
	});
 
 //
								 
								 
 function DY_scroll(wraper,prev,next,img,speed,or)
 { 
  var wraper = $(wraper);
  var prev = $(prev);
  var next = $(next);
  var img = $(img).find('ul');
  var w = img.find('li').outerWidth(true);
  var s = speed;
  
  next.click(function()
       {
        img.animate({'margin-left':-w},function()
                  {
                   img.find('li').eq(0).appendTo(img);
                   img.css({'margin-left':0});
                   });
        });
 
  prev.click(function()
       {
        img.find('li:last').prependTo(img);
        img.css({'margin-left':-w});
        img.animate({'margin-left':0});
        });
 
  if (or == true)
  {
   ad = setInterval(function() { next.click();},s*1000);
   wraper.hover(function(){clearInterval(ad);},function(){ad = setInterval(function() { next.click();},s*1000);});
  }
 
 }
 
 DY_scroll('.multi-carousel','.multi-carousel-nav-prev','.multi-carousel-nav-next','.multi-carousel-inner',3,false);
 
            $('[data-toggle="tooltip"]').tooltip();
            $('[data-toggle="popover"]').popover();
            $("[data-animation]").mouseover(function(){
                var anmiationName=$(this).attr("data-animation");
                $(this).addClass("animated").addClass(anmiationName);
            });
            $("[data-animation]").mouseout(function(){
                var anmiationName=$(this).attr("data-animation");
                $(this).removeClass("animated").removeClass(anmiationName);
            });
 
 ////flipbox
 
 $('.magee-flipbox-wrap').each(function(){
	var front_height = $(this).find('.flipbox-front').outerHeight();
	var back_height = $(this).find('.flipbox-back').outerHeight();
	var height = front_height>back_height?front_height:back_height;
	 	$(this).css({'height':height});	
 });
 
 // counter up
 
  $('.magee-counter-up .counter-num').counterUp({
            delay: 10,
            time: 1000
        });
  
  /* ------------------------------------------------------------------------ */
/*  animation													*/
/* ------------------------------------------------------------------------ */
										  
 jQuery('.magee-animated').each(function(){
			 if(jQuery(this).data('imageanimation')==="yes"){
		         jQuery(this).find("img,i.fa").css("visibility","hidden");	
		 }
		 else{
	           jQuery(this).css("visibility","hidden");	
		 }		
		 
	 });
	
	if(jQuery().waypoint) {
		jQuery('.magee-animated').waypoint(function() {
											  
			jQuery(this).css({'visibility':'visible'});
			jQuery(this).find("img,i.fa").css({'visibility':'visible'});	


			// this code is executed for each appeared element
			var animation_type       = jQuery(this).data('animationtype');
			var animation_duration   = jQuery(this).data('animationduration');
	        var image_animation      = jQuery(this).data('imageanimation');
			 if(image_animation === "yes"){
						 
			jQuery(this).find("img,i.fa").addClass("animated "+animation_type);

			if(animation_duration) {
				jQuery(this).find("img,i.fa").css('-moz-animation-duration', animation_duration+'s');
				jQuery(this).find("img,i.fa").css('-webkit-animation-duration', animation_duration+'s');
				jQuery(this).find("img,i.fa").css('-ms-animation-duration', animation_duration+'s');
				jQuery(this).find("img,i.fa").css('-o-animation-duration', animation_duration+'s');
				jQuery(this).find("img,i.fa").css('animation-duration', animation_duration+'s');
			}
			
				 
			 }else{
			jQuery(this).addClass("animated "+animation_type);

			if(animation_duration) {
				jQuery(this).css('-moz-animation-duration', animation_duration+'s');
				jQuery(this).css('-webkit-animation-duration', animation_duration+'s');
				jQuery(this).css('-ms-animation-duration', animation_duration+'s');
				jQuery(this).css('-o-animation-duration', animation_duration+'s');
				jQuery(this).css('animation-duration', animation_duration+'s');
			}
			 }

			 
		},{ triggerOnce: true, offset: 'bottom-in-view' });
	}
  
 });

// faq filter
jQuery(function ($) {
    
    var filterList = {
    
        init: function () {
        
            // MixItUp plugin
            // http://mixitup.io
            $('.faq-list-filter').mixitup({
                targetSelector: '.faq-box-wrap',
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