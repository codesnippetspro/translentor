"use strict";
var translentor_currency_loading_first_time = true;
var translentor_currency_sumbit_currency_changing = true;

jQuery(function ($) {
    
    if(typeof translentor_currency_array_of_get === 'undefined'){
        return;
    }

    translentor_currency_array_of_get = JSON.parse(translentor_currency_array_of_get);

    if (Object.keys(translentor_currency_array_of_get).length !== 0) {
        if ('currency' in translentor_currency_array_of_get) {

            $('body.woocommerce-cart .shop_table.cart').closest('form').find('input[name="update_cart"]').prop('disabled', false);
            $('body.woocommerce-cart .shop_table.cart').closest('form').find('input[name="update_cart"]').trigger('click');
        }
    }



    if (Object.keys(translentor_currency_array_of_get).length == 0) {
        translentor_currency_array_of_get = {};
    }

    translentor_currency_array_no_cents = JSON.parse(translentor_currency_array_no_cents);
   
   

    if (!parseInt(translentor_currency_get_cookie('woocommerce_items_in_cart'), 10)) {
        $('.widget_shopping_cart_content').empty();
        $(document.body).trigger('wc_fragment_refresh');
    }

    if (translentor_currency_array_of_get.currency != undefined || translentor_currency_array_of_get.removed_item != undefined || translentor_currency_array_of_get.key != undefined)
    {
        translentor_currency_refresh_mini_cart(555);
    }
    if (translentor_currency_redraw_cart) {

        jQuery(document).on("adding_to_cart", function () {
            translentor_currency_refresh_mini_cart(999);
        });
    }

    jQuery('body').on('click', '.translentor_currency_price_info', function () {
        return false;
    });






    translentor_currency_loading_first_time = false;


    if (typeof translentor_currency_shop_is_cached !== 'undefined') {
        if (translentor_currency_shop_is_cached) {

            setTimeout(function () {
                translentor_currency_sumbit_currency_changing = false;
                if (typeof translentor_currency_array_of_get.currency === 'undefined') {

                    if (jQuery('body').hasClass('single')) {
                        jQuery('.translentor_currency_price_info').remove();
                    }

                    
                    var custom_prices = [];
                    jQuery.each(jQuery('.translentor_currency_amount_custom_price'), function (index, item) {
                        custom_prices.push(jQuery(item).data('value'));
                    });
                    if (custom_prices.length != 0) {

                        var data = {
                            action: "translentor_currency_get_custom_price_html",
                            custom_prices: custom_prices
                        };
                        jQuery.post(translentor_currency_ajaxurl, data, function (data) {
                            data = JSON.parse(data);

                            if (!jQuery.isEmptyObject(data)) {
                                jQuery.each(data, function (val, price) {
                                    jQuery(".translentor_currency_amount_custom_price[data-value='" + val + "']").replaceWith(price);
                                });

                            }
                        });
                    }


               

                    var variation_ids = [];
                    var var_data = jQuery("form.variations_form").data("product_variations");
                    if (typeof var_data != "undefined") {
                        jQuery.each(var_data, function (indx, attr) {
                            variation_ids.push(attr['variation_id']);
                        });
                        if (variation_ids.length != 0) {
                            var data_var = {
                                action: "translentor_currency_get_variation_products_price_html",
                                var_products_ids: variation_ids
                            };

                            jQuery.post(translentor_currency_ajaxurl, data_var, function (data) {
                                data = JSON.parse(data);

                                if (!jQuery.isEmptyObject(data)) {
                                    jQuery.each(var_data, function (indx, attr) {
                                        if (typeof data[attr['variation_id']] != "undefined") {
                                            var_data[indx]['price_html'] = data[attr['variation_id']];
                                        }
                                    });
                                    jQuery("form.variations_form").data("product_variations", var_data);
                                }
                            });
                        }
                    }

                   
                    var products_ids = [];
                    jQuery.each(jQuery('.translentor_currency_price_code'), function (index, item) {
                        products_ids.push(jQuery(item).data('product-id'));
                    });

                 
                    if (products_ids.length === 0) {
                        translentor_currency_sumbit_currency_changing = true;
                        return;
                    }


                    var data = {
                        action: "translentor_currency_get_products_price_html",
                        products_ids: products_ids,
                    };

                    jQuery.post(translentor_currency_ajaxurl, data, function (data) {

                        data = JSON.parse(data);
                        if (!jQuery.isEmptyObject(data)) {
                            jQuery('.translentor_currency_price_info').remove();
                            jQuery.each(jQuery('.translentor_currency_price_code'), function (index, item) {

                                if (data.ids[jQuery(item).data('product-id')] != undefined) {
                                    jQuery(item).replaceWith(data.ids[jQuery(item).data('product-id')]);
                                }

                            });
                            jQuery('.translentor_currency_price_code').removeClass('translentor_currency_preloader_ajax');
                           
                            jQuery('.woomentor-currency').val(data.current_currency);
                
                            if (translentor_currency_drop_down_view == 'chosen' || translentor_currency_drop_down_view == 'chosen_dark') {
                                try {
                                    if (jQuery("select.woomentor-currency").length) {
                                        jQuery("select.woomentor-currency").chosen({
                                            disable_search_threshold: 10
                                        });
                                        jQuery('select.woomentor-currency').trigger("chosen:updated");
                                    }
                                } catch (e) {
                                    console.log(e);
                                }
                            }
                            if (typeof data.currency_data != "undefined") {
                                translentor_currency_current_currency = data.currency_data;
                    
                                var min = jQuery('.price_slider_amount #min_price').val();
                                var max = jQuery('.price_slider_amount #max_price').val();
                                if (typeof max != 'undefined' && typeof min != 'undefined') {
                                    max = translentor_currency_convert_price_slider(max);
                                    min = translentor_currency_convert_price_slider(min);
                                    jQuery(document.body).trigger('price_slider_create', [min, max]);
                                }
                            }
                     
                            if (translentor_currency_drop_down_view == 'ddslick') {
                                try {
                                    jQuery('div.dd-container').ddslick('destroy');
                                    jQuery('select.woomentor-currency').val(data.current_currency);
                                    translentor_currency_init_ddslick_select();
                                } catch (e) {
                                    console.log(e);
                                }
                            }
                         
                            if (translentor_currency_drop_down_view == 'wselect' && translentor_currency_is_mobile != 1) {
                                
                                try {
                                    jQuery('select.woomentor-currency').val(data.current_currency).change();
                                } catch (e) {
                                    console.log(e);
                                }
                            }
                           

                            var auto_switcher = jQuery('.translentor_currency_auto_switcher');
                            if (auto_switcher.length > 0) {
                                translentor_currency_auto_switcher_redraw(data.current_currency, auto_switcher);
                            }
                            translentor_currency_sumbit_currency_changing = true;

                            var shortcode_currency = jQuery('strong.translentor_currency_current_currency_code');
                            if (shortcode_currency.length) {
                                shortcode_currency.text(data.current_currency);
                            }


                            document.dispatchEvent(new CustomEvent('after_translentor_currency_get_products_price_html', {detail: {
                                    current_currency: data.current_currency
                                }}));
                        }

                    });

                } else {
                    translentor_currency_sumbit_currency_changing = true;
                    jQuery('.translentor_currency_price_code').removeClass('translentor_currency_preloader_ajax');
                }
            }, 300);

        }
    }

    setTimeout(function () {
     
    }, 300);
   


});


function translentor_currency_redirect(currency) {
    
	//$.cookie("translentor_currency_current_currency", currency);
jQuery(".ct-currency__dropdown").css("overflow", "hidden");
	jQuery(".currency_search").css("display", "none");

jQuery(".progress-bar-currency").css("display", "block");
	jQuery('.progress-bar-currency').each(function(){
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
    if (!translentor_currency_sumbit_currency_changing) {
        return;
    }


    var l = window.location.href;

    var l_tmp = l.split('#');
    l = l_tmp[0];
    var id_key = "";
    if (l_tmp.length > 1) {
        id_key = "#" + l_tmp[1]
    }


    l = l.split('?');
    l = l[0];
    var string_of_get = '?';
    translentor_currency_array_of_get.currency = currency;


    if (translentor_currency_special_ajax_mode) {
        string_of_get = "";

        var data = {
            action: "translentor_currency_set_currency_ajax",
            currency: currency
        };

        jQuery.post(translentor_currency_ajaxurl, data, function (value) {
            setInterval(() => {
                jQuery(".progress-bar-currency").css("display", "none");

 location.reload();

}, 3000);
           
        });

    } else {
        if (Object.keys(translentor_currency_array_of_get).length > 0) {
            jQuery.each(translentor_currency_array_of_get, function (index, value) {
                string_of_get = string_of_get + "&" + index + "=" + value;
            });

        }
        window.location = l + string_of_get + id_key;
    }


}

function translentor_currency_refresh_mini_cart(delay) {

    setTimeout(function () {
     

    }, delay);

}

function translentor_currency_get_cookie(name) {
    var matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
            ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}
function translentor_currency_set_cookie(name, value, days = 365) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}
jQuery(function () {
	
var 		toast_title_currency=jQuery("#toast_title_currency").text();
var	toast_position_currency=jQuery("#toast_position_currency").text();
var	toast_transition_currency=jQuery("#toast_transition_currency").text();
var	toasthide=jQuery("#toast-hide_currency").text();
var	toast_text_color_currency=jQuery("#toast_text_color_currency").text();
var	toast_bg_color_currency=jQuery("#toast_bg_color_currency").text();
var	currency_style=jQuery('#currency_style').text();
// 	console.log(default_language);
	var myStorage = window.localStorage;
	var selected_img_src=myStorage.getItem('currency_img_src');
	var result=myStorage.getItem('currency_name');
	var icon_position_currency=jQuery("#icon_position_currency").text();
	var currency_style=jQuery("#currency_style").text();
	console.log(currency_style);
	console.log(icon_position_currency);
		if( selected_img_src !=null )
		{
            jQuery.toast({
				 
                position: toast_position_currency,
                stack: false,
                heading: toast_title_currency,
                text: 'You Have Translated Your Website To '+result,
                icon: 'success',
                loader: false,  
                showHideTransition: toast_transition_currency,
                hideAfter: toasthide,
                bgColor: toast_bg_color_currency,
                textColor: toast_text_color_currency  // To change the background
            });
			//console.log(selected_img_src);
			if(currency_style=='both')
				{
			if(icon_position_currency=='right')
				{
			
			jQuery(".drop_currency i").remove();
					//jQuery(".drop_footer i").remove();
			jQuery(".drop_currency").append("<img width='24' height='24' src='"+selected_img_src+"'/>");
			//jQuery(".drop_footer").append("<img width='24' height='24' src='"+selected_img_src+"'/>");
			jQuery(".drop_currency span").text(' '+result+' ');
			//jQuery(".drop_footer span").text(' '+result+' ');
				
				}else{
					jQuery(".drop_currency i").remove();
					//jQuery(".drop_footer i").remove();
			
			console.log("Data "+selected_img_src);
			
			jQuery(".drop_currency").prepend("<img width='24' height='24' src='"+selected_img_src+"'/>");
			//jQuery(".drop_footer").prepend("<img width='24' height='24' src='"+selected_img_src+"'/>");
			jQuery(".drop_currency span").text(' '+result+' ');
			//jQuery(".drop_footer span").text(' '+result+' ');
				}
				}else if(currency_style=='icon'){
						 jQuery(".drop_currency i").remove();
					jQuery(".drop_footer i").remove();
					jQuery(".drop_currency").append("<img width='24' height='24' src='"+selected_img_src+"'/>");
					jQuery(".drop_footer").append("<img width='24' height='24' src='"+selected_img_src+"'/>");
						 }else{
							 
							 jQuery(".drop_currency span").text(' '+result+' ');
			jQuery(".drop_footer span").text(' '+result+' ');
						 }
			
		}
    jQuery('.translentor_currency_currency_link').on('click', function () {
        translentor_currency_set_cookie('translentor_currency_current_currency', jQuery(this).data('currency'));
		myStorage.clear();
		var src=jQuery(this).children("img").attr("src");
	
		var name=jQuery(this).children("img").attr("alt");
	   myStorage.setItem('currency_img_src', src);
		 myStorage.setItem('currency_name', name);
        translentor_currency_redirect(jQuery(this).data('currency'));
        return false;
    });

	jQuery( function() {
        jQuery( '#currency_search' ).keyup( function() {
            if(currency_style==='icon')
                {
                    if(jQuery( this ).val().length !== 0)
                        {
            var matches = jQuery( 'ul#mydata_currency' ).find( ' li a:has(img[alt*="'+ jQuery( this ).val() +'"]) ' );
            jQuery( 'li a', 'ul#mydata_currency' ).not( matches ).slideUp(function() {
        jQuery('.ct-currency__dropdown li').css('padding','0px 0px 0px 0px');
            jQuery('.ct-currency__dropdown').css('grid-template-columns','repeat(1, 1fr)');	
                
                
      });
            matches.slideDown();  
                console.log(matches);
                        }else{
                        var matches = jQuery( 'ul#mydata_currency' ).find( 'li a:contains('+ jQuery( this ).val() +') ' );
            jQuery( 'li a', 'ul#mydata_currency' ).not( matches ).slideUp();
            matches.slideDown(function() {
        jQuery('.ct-currency__dropdown li').css('padding','');
                jQuery('.ct-currency__dropdown').css('grid-template-columns','');
      }); 	
                        }
                }
            else{
            var matches = jQuery( 'ul#mydata_currency' ).find( 'li a:contains('+ jQuery( this ).val() +') ' );
            jQuery( 'li a', 'ul#mydata_currency' ).not( matches ).slideUp(function() {
        jQuery('.ct-currency__dropdown li').css('padding','0px 0px 0px 0px');
            jQuery('.ct-currency__dropdown').css('grid-template-columns','repeat(1, 1fr)');	
                    
      });
            matches.slideDown(function() {
        jQuery('.ct-currency__dropdown li').css('padding','');
                jQuery('.ct-currency__dropdown').css('grid-template-columns','');
      });   
                console.log(matches);
            }
        });
    });
});

