/**
 * Sets proper language cookie
 *
 * Sends ajax request to get browser and IP language.
 * Sets cookie with current language.
 * Changes cookie when clicking a link pointed to another language.
 *
 */
function translentor_IN_Determine_Language(){
    var _this = this;
    var translentorCookie = null;
    var translentorHelper = null;

    this.get_lang_from_url = function ( url ) {
        // we remove http or https
        // if the user links to a http link but the abs_home_url is https, we're serving the https one so we don't brake cookies if he doesn't have proper redirects
        var lang = url.replace( /^(http|https):\/\//g, '');
        var abs_home = translentor_language_cookie_data[ 'abs_home' ].replace( /^(http|https):\/\//g, '');

        // we have removed the home path from our URL. We're adding a / in case it's the homepage of one of the languages
        // removing / from the front so it's easier for understanding explode()
        lang = translentorHelper.ltrim( translentorHelper.trailingslashit( lang.replace(abs_home, '') ),'/' );

        // We now have to see if the first part of the string is actually a language slug
        var lang_array = lang.split("/");
        if( lang_array.length < 2 ){
            return translentor_language_cookie_data['translentor-default-language'];
        }
        // The language code is the first non-empty item in this array depending on abs_home slashes
        for ( var i = 0; i < lang_array.length; i++ ){
            if ( lang_array[i] != undefined && lang_array[i] != '' ) {
                lang = lang_array[i];
                break;
            }
        }
        // the lang slug != actual lang. So we need to do array_search so we don't end up with en instead of en_US
        if( translentorHelper.in_array( lang, translentor_language_cookie_data['translentor-lang-slugs']) ){
            return translentorHelper.array_search(lang, translentor_language_cookie_data['translentor-lang-slugs'] );
        } else {
            return translentor_language_cookie_data['translentor-default-language'];
        }

    };

    this.get_current_dom_language = function(){
        var html_language = jQuery('html').attr('lang');
        html_language = html_language.split("-").join("_");
        return html_language;
    };


    this.ajax_get_needed_language = function() {
        console.log(translentor_language_cookie_data['translentor_translentor_ajax_url']);
        jQuery.ajax({
            url: translentor_language_cookie_data['translentor_translentor_ajax_url'],
            type: 'post',
            dataType: 'json',
            data: {
                action: 'translentor_translentor_get_needed_language',
                detection_method: translentor_language_cookie_data['detection_method'],
                popup_option: translentor_language_cookie_data['popup_option'],
                popup_textarea: translentor_language_cookie_data['popup_textarea'],
                popup_type: translentor_language_cookie_data['popup_type'],
                popup_textarea_change_button: translentor_language_cookie_data['popup_textarea_change_button'],
                popup_textarea_close_button: translentor_language_cookie_data['popup_textarea_close_button'],
                publish_languages: translentor_language_cookie_data['publish_languages'],
                iso_codes: translentor_language_cookie_data['iso_codes'],
                english_name: translentor_language_cookie_data['english_name'],
                default_language: translentor_language_cookie_data['default_language']
            },
            success: function( response ) {
                if ( response ) {
                    _this.redirect_if_needed( response );
                   
                }else{
                    _this.redirect_if_needed( _this.get_current_dom_language() );
                  
                }

            },
            error: function( errorThrown ){
                // make current language the needed language
                _this.redirect_if_needed( _this.get_current_dom_language() );
            }
        });
    };

    this.activate_popup = function( response, url_to_redirect ){

        _this.make_ls_clickable();
        _this.ls_make_default_language_preselected( response );

        var text_popup = document.getElementById("translentor_translentor_popup_text");
        var popup = document.getElementById("translentor_translentor_modal_container");
        var close = document.getElementById("translentor_translentor_x_button_and_textarea");

        var popup_change_button = document.getElementById("translentor_translentor_popup_change_language");
        var popup_close_button_text = document.getElementById("translentor_translentor_x_button_textarea");

        popup.style.display= 'block';

        var no_text_popup_select_current_language = document.getElementById('translentor_translentor_popup_current_language');

        text_popup.innerHTML = translentor_language_cookie_data['popup_textarea'];

        popup_change_button.innerHTML = translentor_language_cookie_data['popup_textarea_change_button'];


        close.title = translentor_language_cookie_data['popup_textarea_close_button'];
        popup_close_button_text.title = translentor_language_cookie_data['popup_textarea_close_button'];

        close.onclick = function (){
            popup.style.display = 'none';
            translentorCookie.setCookie( translentor_language_cookie_data['cookie_name'], _this.get_current_dom_language(), translentor_language_cookie_data['cookie_age'], translentor_language_cookie_data['cookie_path'] );

        }

        popup_close_button_text.onclick = function(){
            popup.style.display = 'none';
            translentorCookie.setCookie( translentor_language_cookie_data['cookie_name'], _this.get_current_dom_language(), translentor_language_cookie_data['cookie_age'], translentor_language_cookie_data['cookie_path'] );

        }

        _this.ls_select_language();

        popup_change_button.onclick = function(){
            var selected_language = no_text_popup_select_current_language.getAttribute('data-translentor-translentor-selected-language');
          
            translentorCookie.setCookie( translentor_language_cookie_data['cookie_name'], selected_language, translentor_language_cookie_data['cookie_age'], translentor_language_cookie_data['cookie_path'] );
            if (selected_language === _this.get_current_dom_language()){
                popup.style.display = 'none';
                return;
            }
            var url = _this.get_url_for_lang(selected_language);
            window.location.replace( url );

            if(translentor_language_cookie_data['is_google']=='yes')
            {
                window.location.reload(true);
            }
           
        }

    }


    this.make_ls_clickable = function (){
        jQuery('.translentor_ip_container .translentor-ls-shortcode-current-language').click(function () {
            
            jQuery( '.translentor_ip_container .translentor-ls-shortcode-current-language' ).addClass('translentor-lp-clicked');
            jQuery( '.translentor_ip_container .translentor-lp-shortcode-language' ).addClass('translentor-lp-clicked');
        });

        jQuery('.translentor_ip_container .translentor-lp-shortcode-language').click(function () {
            jQuery( '.translentor_ip_container .translentor-ls-shortcode-current-language' ).removeClass('translentor-lp-clicked');
            jQuery( '.translentor_ip_container .translentor-lp-shortcode-language' ).removeClass('translentor-lp-clicked');
        });


        jQuery(document).keyup(function(e) {
            if (e.key === "Escape") {
                jQuery( '.translentor_ip_container .translentor-ls-shortcode-current-language' ).removeClass('translentor-lp-clicked');
                jQuery( '.translentor_ip_container .translentor-lp-shortcode-language' ).removeClass('translentor-lp-clicked');
            }
        });

        jQuery(document).on("click", function(event){
            if(!jQuery(event.target).closest(".translentor_ip_container .translentor-ls-shortcode-current-language").length){
                jQuery( '.translentor_ip_container .translentor-ls-shortcode-current-language' ).removeClass('translentor-lp-clicked');
                jQuery( '.translentor_ip_container .translentor-lp-shortcode-language' ).removeClass('translentor-lp-clicked');
            }
        });
    }

    this.ls_select_language = function(){

        // todo
        var no_text_current_language = document.getElementById('translentor_translentor_popup_current_language');

        jQuery('.translentor-ip-popup-select').click(function ( item ) {
            no_text_current_language.innerHTML = item.target.innerHTML;
            no_text_current_language.setAttribute('data-translentor-translentor-selected-language', item.target.getAttribute('data-translentor-translentor-selected-language'));
        });
    }

    this.ls_make_default_language_preselected = function( response ){

        var no_text_current_language = document.querySelector('.translentor_ip_container #translentor_translentor_popup_current_language');
        var all_languages = document.querySelectorAll('.translentor_ip_container .translentor-ip-popup-select');

        for ( var i = 0; i< all_languages.length; i++){
            if (all_languages[i].id == response){
                no_text_current_language.innerHTML = all_languages[i].innerHTML;
                no_text_current_language.setAttribute('data-translentor-translentor-selected-language', response);
            }
        }
    }

    this.get_url_for_lang = function( language ){
       
        for( i in translentor_language_cookie_data['language_urls'] ){
            if( i === language ) {
                return translentor_language_cookie_data['language_urls'][i];
            }
        }

        return false;
    };

    this.is_valid_url = function ( url ) {
        if ( typeof url === 'undefined' || url === '' ){
            return false;
        }
        var starting_characters = ['#','?', 'javascript'];
        for (var i = 0; i < starting_characters.length; i++ ){
            if ( url.substring(0, starting_characters[i].length) === starting_characters[i]){
                return false;
            }
        }
        return true;
    };

    this.replace_underscore_with_dash = function (var_replace){
        var_replace = var_replace.toLowerCase();
        var_replace = var_replace.split("_").join("-");

        return var_replace;
    }

    this.is_same_language_code = function (var1, var2){
        var1 = _this.replace_underscore_with_dash(var1);
        var2 = _this.replace_underscore_with_dash(var2);

        if(var1 == var2){
            return true;
        }
        return false;
    }

    this.is_login_url = function( url ){
        if( url.includes( "wp-login.php" )){
            return true;
        }
        return false;
    }

    this.add_event_handlers = function(){
        jQuery('body').on('click', 'a', function(e) {

            var clicked_url = jQuery(this).attr("href");
            if ( _this.is_valid_url( clicked_url ) && !_this.is_login_url( clicked_url )) {
                var clicked_language = _this.get_lang_from_url(clicked_url);
                var translentor_current_language = translentorCookie.getCookie(translentor_language_cookie_data['cookie_name']);

                if (!(_this.is_same_language_code(translentor_current_language, clicked_language))) {
                    translentorCookie.setCookie(translentor_language_cookie_data['cookie_name'], clicked_language, translentor_language_cookie_data['cookie_age'], translentor_language_cookie_data['cookie_path']);
                }
            }
        });
    };

    this.redirect_if_needed = function( needed_language ){
        translentorCookie.setCookie( translentor_language_cookie_data['cookie_name'], needed_language, translentor_language_cookie_data['cookie_age'], translentor_language_cookie_data['cookie_path'] );
        _this.add_event_handlers();

        if (!(_this.is_same_language_code(_this.get_current_dom_language(), needed_language))){
            url_to_redirect = _this.get_url_for_lang( needed_language );
            //window.location.replace( url_to_redirect );
            if(url_to_redirect != 'undefined' && url_to_redirect!= false) {
                // redirect to needed language
                if(translentor_language_cookie_data['popup_type'] == 'normal_popup' && translentor_language_cookie_data['popup_option'] == 'popup'){
                    
                    _this.activate_popup( needed_language, url_to_redirect );
                }else{
                   
                        window.location.replace( url_to_redirect );
                    
                }
            }
        }
    };

    this.initialize = function (){
        translentorCookie = new translentor_IN_Cookie();
        translentorHelper = new translentor_IN_Helper();
        if ( ! translentorCookie.areCookiesEnabled() ){
            _this.add_event_handlers();
            return;
        }

        var language_from_cookie = translentorCookie.getCookie( translentor_language_cookie_data['cookie_name'] );
        if ( language_from_cookie && translentorHelper.in_array( language_from_cookie, translentor_language_cookie_data['publish_languages'] ) ) {
            // if cookie is set, redirect if needed
            _this.redirect_if_needed( language_from_cookie );
            
        }else{
            // if cookie is not set, send request to find out language and then redirect if needed
            _this.ajax_get_needed_language();
        }
    };

    _this.initialize();
}

/**
 * String manipulation functions
 */
function translentor_IN_Helper(){

    this.trailingslashit = function ( string ){
        string = string.replace(/\/+$/,'');
        string = string + '/';
        return string;
    };

    this.ltrim = function ( string ) {
        var trimmed = string.replace(/^\s+/g, '');
        return trimmed;
    };

    this.in_array = function (needle, haystack) {
        for(var i in haystack ) {
            if(haystack[i] == needle) {
                return true;
            }
        }
        return false;
    };

    this.array_search = function(val, array) {
        if(typeof(array) === 'array' || typeof(array) === 'object') {
            var rekey;
            for(var i in array) {
                if(array[i] == val) {
                    rekey = i;
                    break;
                }
            }
            return rekey;
        }
    };

    /**
     * Update url with query string.
     *
     */
    this.update_query_string = function(key, value, url) {
        if (!url) url = window.location.href;
        var re = new RegExp("([?&])" + key + "=.*?(&|#|$)(.*)", "gi"),
            hash;

        if (re.test(url)) {
            if (typeof value !== 'undefined' && value !== null)
                return url.replace(re, '$1' + key + "=" + value + '$2$3');
            else {
                hash = url.split('#');
                url = hash[0].replace(re, '$1$3').replace(/(&|\?)$/, '');
                if (typeof hash[1] !== 'undefined' && hash[1] !== null)
                    url += '#' + hash[1];
                return url;
            }
        }
        else {
            if (typeof value !== 'undefined' && value !== null ) {
                var separator = url.indexOf('?') !== -1 ? '&' : '?';
                hash = url.split('#');
                url = hash[0] + separator + key + '=' + value;
                if (typeof hash[1] !== 'undefined' && hash[1] !== null)
                    url += '#' + hash[1];
                return url;
            }
            else
                return url;
        }
    };
}

/**
 * Manipulate cookie: set/get/erase
 */
function translentor_IN_Cookie() {
    this.setCookie = function(cname,cvalue,exdays,cpath){
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=" + cpath + ";SameSite=Lax";
    };

    this.getCookie = function(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    };

    this.eraseCookie = function(name) {
        document.cookie = name+'=; Max-Age=-99999999;';
    };

    this.areCookiesEnabled = function(){
        if (navigator.cookieEnabled) return true;

        // set and read cookie
        document.cookie = "cookietest=1";
        var ret = document.cookie.indexOf("cookietest=") != -1;

        // delete cookie
        document.cookie = "cookietest=1; expires=Thu, 01-Jan-1970 00:00:01 GMT";

        return ret;
    }
}


jQuery( function() {
    translentorDetermineLanguage = new translentor_IN_Determine_Language();
    console.log('hjh');
});
