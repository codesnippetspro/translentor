jQuery(document).ready(function(){
	//googleTranslateElementInit();
	toast_title=jQuery("#toast_title").text();
	toast_position=jQuery("#toast_position").text();
	toast_transition=jQuery("#toast_transition").text();
	toasthide=jQuery("#toast-hide").text();
	toast_text_color=jQuery("#toast_text_color").text();
	toast_bg_color=jQuery("#toast_bg_color").text();
	default_language=jQuery('#default_language').text();
	language_style=jQuery('#language_style').text();
	console.log(default_language);
	myStorage = window.localStorage;
	myStroage1=window.localStorage;
	myStorage2=window.localStorage;
	selected_img_src=myStorage.getItem('img_src');
	lang_name=myStorage2.getItem('lang_name');
	check_onetime=myStroage1.getItem('check_onetime');
	icon_position=jQuery("#position").text();
	translate_style=jQuery("#style_icon").text();
	if( lang_name !=null )
		{
				//const after_ = selected_img_src.substring(selected_img_src.indexOf('flags/') + 6);
            const result = lang_name;//after_.replace(".svg", " ");
			console.log(myStroage1.getItem('check_onetime'));
			if(check_onetime=="yes")
				{
					jQuery.toast({	 
    position: toast_position,
    stack: false,
    heading: toast_title,
    text: 'You Have Translated Your Website To '+result,
    icon: 'success',
    loader: false,  
	showHideTransition: toast_transition,
	hideAfter: toasthide,
    bgColor: toast_bg_color,
    textColor: toast_text_color  // To change the background
});
		         myStroage1.setItem('check_onetime', "no");
				}
			console.log(selected_img_src);
			if(translate_style=='both' || translate_style=='both_short')
				{
			if(icon_position=='right')
				{
			
			jQuery(".drop i").remove();
					jQuery(".drop_footer i").remove();
			//const after_ = selected_img_src.substring(selected_img_src.indexOf('flags/') + 6);
            const result = lang_name;//after_.replace(".svg", " ");
			 console.log(result);
			
			jQuery(".drop").append("<img width='24' height='24' src='"+selected_img_src+"'/>");
			jQuery(".drop_footer").append("<img width='24' height='24' src='"+selected_img_src+"'/>");
			jQuery(".drop span").text(' '+result+' ');
			jQuery(".drop_footer span").text(' '+result+' ');
				
				}else{
					jQuery(".drop i").remove();
					jQuery(".drop_footer i").remove();
			//const after_ = selected_img_src.substring(selected_img_src.indexOf('flags/') + 6);
            const result = lang_name;//after_.replace(".svg", " ");
			console.log(result);
			console.log('check point');
			jQuery(".drop").prepend("<img width='24' height='24' src='"+selected_img_src+"'/>");
			jQuery(".drop_footer").prepend("<img width='24' height='24' src='"+selected_img_src+"'/>");
			jQuery(".drop span").text(' '+result+' ');
			jQuery(".drop_footer span").text(' '+result+' ');
				}
				}else if(translate_style=='icon'){
						 jQuery(".drop i").remove();
					jQuery(".drop_footer i").remove();
					jQuery(".drop").append("<img width='24' height='24' src='"+selected_img_src+"'/>");
					jQuery(".drop_footer").append("<img width='24' height='24' src='"+selected_img_src+"'/>");
						 }else{
							 //const after_ = selected_img_src.substring(selected_img_src.indexOf('flags/') + 6);
            const result = lang_name;//after_.replace(".svg", " ");
							 jQuery(".drop span").text(' '+result+' ');
			jQuery(".drop_footer span").text(' '+result+' ');
						 }
			
		}
		else{
			myStorage.clear();
			console.log('rIGHT hERE');
			src=jQuery('#default_language_image').text();
			myStorage.setItem('img_src', src);
				
			myStorage = window.localStorage;
			selected_img_src=myStorage.getItem('img_src');
				
			if( selected_img_src !=null )
		{
			const after_ = selected_img_src.substring(selected_img_src.indexOf('flags/') + 6);
            const result = after_.replace(".svg", " ");

			console.log('ddd'+result);
			if(translate_style=='both' || translate_style=='both_short')
				{
			if(icon_position=='right')
				{
			
			jQuery(".drop i").remove();
					jQuery(".drop_footer i").remove();
			//const after_ = selected_img_src.substring(selected_img_src.indexOf('flags/') + 6);
            //const result = lang_name;//after_.replace(".svg", " ");
			
			
			jQuery(".drop").append("<img width='24' height='24' src='"+selected_img_src+"'/>");
			jQuery(".drop_footer").append("<img width='24' height='24' src='"+selected_img_src+"'/>");
			jQuery(".drop span").text(' '+result+' ');
			jQuery(".drop_footer span").text(' '+result+' ');
				
				}else{
					jQuery(".drop i").remove();
					jQuery(".drop_footer i").remove();
			//const after_ = selected_img_src.substring(selected_img_src.indexOf('flags/') + 6);
            //const result = lang_name;//after_.replace(".svg", " ");
			
			
			jQuery(".drop").prepend("<img width='24' height='24' src='"+selected_img_src+"'/>");
			jQuery(".drop_footer").prepend("<img width='24' height='24' src='"+selected_img_src+"'/>");
			jQuery(".drop span").text(' '+result+' ');
			jQuery(".drop_footer span").text(' '+result+' ');
				}
				}else if(translate_style=='icon'){
						 jQuery(".drop i").remove();
					jQuery(".drop_footer i").remove();
					jQuery(".drop").append("<img width='24' height='24' src='"+selected_img_src+"'/>");
					jQuery(".drop_footer").append("<img width='24' height='24' src='"+selected_img_src+"'/>");
						 }else{
							 //const after_ = selected_img_src.substring(selected_img_src.indexOf('flags/') + 6);
            //const result = lang_name;//after_.replace(".svg", " ");
							 jQuery(".drop span").text(' '+result+' ');
			jQuery(".drop_footer span").text(' '+result+' ');
						 }
			
		}
		}
		
		console.log("URL:	"+window.location.href);
jQuery(document).on('click','a.lang-select', function(e){
	myStorage.clear();
	
   e.preventDefault();
	 var targetUrl = jQuery(this).attr('href');

	var src=jQuery(this).children("img").attr("src");
	var alt=jQuery(this).children("img").attr("alt");
	console.log(src);
	 
	 myStorage.setItem('img_src', src);
	 myStorage2.setItem('lang_name',alt);
	myStroage1.setItem('check_onetime', "yes");
jQuery(".ct-language__dropdown").css("overflow", "hidden");
	jQuery(".search").css("display", "none");

jQuery(".progress-bar").css("display", "block");
	jQuery('.progress-bar').each(function(){
    var $this = jQuery(this);
    var percent = $this.attr('percent');
    $this.css("width",percent+'%');
    jQuery({animatedValue: 0}).animate({animatedValue: percent},{
        duration: 2000,
        step: function(){
            $this.attr('percent', Math.floor(this.animatedValue) + '%');
			$this.css("width",Math.floor(this.animatedValue) + '%');
		
        },
        complete: function(){
			
            $this.attr('percent', Math.floor(this.animatedValue) + '%');
			$this.css("width",Math.floor(this.animatedValue) + '%');
        }
    });
});

  jQuery.ajax({
        url: targetUrl,
        type: "POST",
	  cache: false,
        success:function(){
          jQuery(".goog-te-combo").val(t), (window.location = targetUrl);
		check_onetime=true;
			setInterval(() => {
					jQuery(".progress-bar").css("display", "none");
       
 window.location.reload(true);


    }, 4000);
			
				
        },
        error:function (){
            alert("Error Occure while Translating");
        },
    });
});
	
	//Footer......
jQuery(document).on('click','a.lang-select_footer', function(e){
	myStorage.clear();
	
   e.preventDefault();
	 var targetUrl = jQuery(this).attr('href');

	var src=jQuery(this).children("img").attr("src");
	var alt=jQuery(this).children("img").attr("alt");
	console.log(src);
	 
	 myStorage.setItem('img_src', src);
	 myStorage2.setItem('lang_name',alt);
jQuery(".language_footer").css("overflow", "hidden");
		jQuery(".search_footer").css("display", "none");
jQuery(".progress-bar_footer").css("display", "block");
	jQuery('.progress-bar_footer').each(function(){
    var $this = jQuery(this);
    var percent = $this.attr('percent');
    $this.css("width",percent+'%');
    jQuery({animatedValue: 0}).animate({animatedValue: percent},{
        duration: 2000,
        step: function(){
            $this.attr('percent', Math.floor(this.animatedValue) + '%');
			$this.css("width",Math.floor(this.animatedValue) + '%');
		
        },
        complete: function(){
			
            $this.attr('percent', Math.floor(this.animatedValue) + '%');
			$this.css("width",Math.floor(this.animatedValue) + '%');
        }
    });
});

  jQuery.ajax({
        url: targetUrl,
        type: "POST",
	  
        success:function(){
          jQuery(".goog-te-combo").val(t), (window.location = targetUrl);
			
			setInterval(() => {
					jQuery(".progress-bar_footer").css("display", "none");
       
 window.location.reload();


    }, 4000);
        },
        error:function (){
            alert("Error Occure while Translating");
        },
    });
});
 
jQuery.fn.clickToggle = function(a, b) {
  return this.on("click", function(ev) { [b, a][this.$_io ^= 1].call(this, ev) })
};


jQuery('.drop').clickToggle(function(ev) {
  jQuery(".ct-language__dropdown").css("overflow", "visible");
	jQuery(".search").css("display", "block");
}, function(ev) {
  jQuery(".ct-language__dropdown").css("overflow", "hidden");
	jQuery(".search").css("display", "none");
});
	
	jQuery('.drop_footer').clickToggle(function(ev) {
  jQuery(".language_footer").css("overflow", "visible");
		jQuery(".search_footer").css("display", "block");
}, function(ev) {
  jQuery(".language_footer").css("overflow", "hidden");
		jQuery(".search_footer").css("display", "none");
});
	jQuery( function() {
    jQuery( '#search' ).keyup( function() {
		if(language_style==='icon')
			{
				if(jQuery( this ).val().length !== 0)
					{
		var matches = jQuery( 'ul#mydata' ).find( ' li a:has(img[alt*="'+ jQuery( this ).val() +'"]) ' );
        jQuery( 'li a', 'ul#mydata' ).not( matches ).slideUp(function() {
    jQuery('.ct-language__dropdown li').css('padding','0px 0px 0px 0px');
		jQuery('.ct-language__dropdown').css('grid-template-columns','repeat(1, 1fr)');	
			
			
  });
        matches.slideDown();  
			console.log(matches);
					}else{
					var matches = jQuery( 'ul#mydata' ).find( 'li a:contains('+ jQuery( this ).val() +') ' );
        jQuery( 'li a', 'ul#mydata' ).not( matches ).slideUp();
        matches.slideDown(function() {
    jQuery('.ct-language__dropdown li').css('padding','');
			jQuery('.ct-language__dropdown').css('grid-template-columns','');
  }); 	
					}
			}
		else{
        var matches = jQuery( 'ul#mydata' ).find( 'li a:contains('+ jQuery( this ).val() +') ' );
        jQuery( 'li a', 'ul#mydata' ).not( matches ).slideUp(function() {
    jQuery('.ct-language__dropdown li').css('padding','0px 0px 0px 0px');
		jQuery('.ct-language__dropdown').css('grid-template-columns','repeat(1, 1fr)');	
				
  });
        matches.slideDown(function() {
    jQuery('.ct-language__dropdown li').css('padding','');
			jQuery('.ct-language__dropdown').css('grid-template-columns','');
  });   
			console.log(matches);
		}
    });
});
	
	//footer search
	jQuery( function() {
    jQuery( '#search_footer' ).keyup( function() {
		if(language_style==='icon')
			{
				if(jQuery( this ).val().length !== 0)
					{
		var matches = jQuery( 'ul#mydata_footer' ).find( ' li a:has(img[alt*="'+ jQuery( this ).val() +'"]) ' );
        jQuery( 'li a', 'ul#mydata_footer' ).not( matches ).slideUp(function() {
    jQuery('.language_footer li').css('padding','0px 0px 0px 0px');
		jQuery('.language_footer').css('grid-template-columns','repeat(1, 1fr)');	
			
			
  });
        matches.slideDown();  
			console.log(matches);
					}else{
					var matches = jQuery( 'ul#mydata_footer' ).find( 'li a:contains('+ jQuery( this ).val() +') ' );
        jQuery( 'li a', 'ul#mydata_footer' ).not( matches ).slideUp();
        matches.slideDown(function() {
    jQuery('.language_footer li').css('padding','');
			jQuery('.language_footer').css('grid-template-columns','');
  }); 	
					}
			}
		else{
        var matches = jQuery( 'ul#mydata_footer' ).find( 'li a:contains('+ jQuery( this ).val() +') ' );
        jQuery( 'li a', 'ul#mydata_footer' ).not( matches ).slideUp(function() {
    jQuery('.language_footer li').css('padding','0px 0px 0px 0px');
		jQuery('.language_footer').css('grid-template-columns','repeat(1, 1fr)');	
				
  });
        matches.slideDown(function() {
    jQuery('.language_footer li').css('padding','');
			jQuery('.language_footer').css('grid-template-columns','');
  });   
			console.log(matches);
		}
    });
});
	});


var t = jQuery(this).attr("data-lang");
const element = document.querySelector("html");
let prevState = element.classList.contains("translated-ltr");
const observer = new MutationObserver((t) => {
    t.forEach((t) => {
        const { target: e } = t;
        if ("class" === t.attributeName) {
			
            const e = t.target.classList.contains("translated-ltr");
            if (prevState !== e && "" !== (prevState = e)) {
                var n = window.location.toString();
                if (n.indexOf("#") > 0) {
                    var a = n.substring(0, n.indexOf("#"));
                    window.history.replaceState({}, document.title, a);
                }
            }
        }
    });
});
observer.observe(document.querySelector("html"), { attributes: !0, attributeOldValue: !0, attributeFilter: ["class"] });