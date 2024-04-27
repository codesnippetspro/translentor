console.log('ssss'); 
document.addEventListener("DOMContentLoaded", function(event) {
    function translentorClearWooCartFragments(){

        // clear WooCommerce cart fragments when switching language
        var translentor_language_switcher_urls = document.querySelectorAll(".translentor-language-switcher-container a:not(.translentor-ls-disabled-language)");

        for (i = 0; i < translentor_language_switcher_urls.length; i++) {
            translentor_language_switcher_urls[i].addEventListener("click", function(){
                if ( typeof wc_cart_fragments_params !== 'undefined' && typeof wc_cart_fragments_params.fragment_name !== 'undefined' ) {
                    window.sessionStorage.removeItem(wc_cart_fragments_params.fragment_name);
                }
            });
        }
    }

    translentorClearWooCartFragments();
});
