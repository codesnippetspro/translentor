/**
 * Script used for window previewed in Translation Editor.
 */
 console.log('ssss'); 
function translentor_Iframe_Preview(){

    var _this = this;

    /**
     * Add GET preview parameter for links and forms.
     */
    this.initialize = function() {
        if( typeof translentorTranslator !== 'undefined' ) {
            translentorTranslator.pause_observer();
        }

        jQuery('a').each(function () {
            // target parent brakes from the iframe so we're changing to self.
            // We cannot remove it because we need it in Translation blocks
            if ( ! jQuery(this).attr('data-translentor-original-target') ){
                jQuery( this ).attr( 'data-translentor-original-target', jQuery( this ).attr( 'target' ) );
            }
            jQuery(this).attr('target', '_self');

            if( typeof this.href != "undefined" && this.href != '' ) {
                if (this.action != '' && this.href.indexOf('void(0)') === -1) {
                    if (is_link_previewable(this) && !this.getAttribute('href').startsWith('#')) {
                        this.href = update_query_string('translentor-editor', 'preview', this.getAttribute('href'));
                        
                       

                    } else {
                        jQuery(this).on('click',
                            function (event) {
                                event.preventDefault();
                            }
                        );
                    }
                }
            }
        });

        jQuery('form').each(function () {
            jQuery( this ).append( jQuery('<input></input>').attr({ type: 'hidden', value: 'preview', name: 'translentor-editor' }) );
        });

        addKeyboardShortcutsListener();
        if( typeof translentorTranslator !== 'undefined' ) {
            translentorTranslator.resume_observer();
        }
    };

    function addKeyboardShortcutsListener(){
        document.addEventListener("keydown", function(e) {
            // CTRL + S
            if ((window.navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)  && e.keyCode === 83) {
                e.preventDefault();
                window.parent.dispatchEvent( new Event( 'translentor_trigger_save_translations_event' ) );
            }

            if ((window.navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey) && e.altKey ) {
                switch (e.keyCode){

                    // CTRL + ALT + right arrow
                    case 39:
                        e.preventDefault();
                        window.parent.dispatchEvent( new Event( 'translentor_trigger_next_string_event' ) );
                        break;

                    // CTRL + ALT + left arrow
                    case 37:
                        e.preventDefault();
                        window.parent.dispatchEvent( new Event( 'translentor_trigger_previous_string_event' ) );
                        break;

                    // CTRL + ALT + Z
                    case 90:
                        e.preventDefault();
                        window.parent.dispatchEvent(new Event('translentor_trigger_discard_all_changes_event'));
                        break;
                }
            }
        }, false);
    }

    /**
     * Update url with query string.
     *
     */
    function update_query_string(key, value, url) {
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
    }

    /**
     * Return boolean whether element has unpreviewable attribute.
     */
    function is_link_previewable( element ) {
        if ( jQuery( element ).attr( 'data-translentor-unpreviewable' ) == 'translentor-unpreviewable' ){
            return false;
        }
        return true;
    }

    _this.initialize();
}

var translentor_preview_iframe;

jQuery( function(){
    translentor_preview_iframe = new translentor_Iframe_Preview();
    window.addEventListener( 'translentor_iframe_page_updated', translentor_preview_iframe.initialize )
});

/**
 *   the startsWith method is not supported in IE so in that case we need to implement it
 */
if (!String.prototype.startsWith) {
    String.prototype.startsWith = function(searchString, position) {
        position = position || 0;
        return this.indexOf(searchString, position) === position;
    };
}
