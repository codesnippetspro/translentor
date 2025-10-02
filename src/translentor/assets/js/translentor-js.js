/**
 * Translentor Website Translator
 * Google Translate integration and UI management
 */

// Initialize Google Translate on DOM load
document.addEventListener('DOMContentLoaded', function () {
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            layout: google.translate.TranslateElement.FloatPosition.TOP_LEFT
        }, "google_translate_element");

        // Clean up hash from URL if present
        var currentUrl = window.location.toString();
        if (currentUrl.indexOf("#") > 0) {
            var cleanUrl = currentUrl.substring(0, currentUrl.indexOf("#"));
            window.history.replaceState({}, document.title, cleanUrl);
        }
    }

    function triggerHtmlEvent(element, eventType) {
        var event;
        if (document.createEvent) {
            event = document.createEvent("HTMLEvents");
            event.initEvent(eventType, true, true);
            element.dispatchEvent(event);
        } else if (document.createEventObject) { // For IE < 9
            event = document.createEventObject();
            event.eventType = eventType;
            element.fireEvent("on" + event.eventType, event);
        }
    }

    // Initialize the Google Translate element
    googleTranslateElementInit();
});

// Main translator functionality
jQuery(document).ready(function () {
    // Toast configuration
    var toastConfig = {
        title: jQuery("#toast_title").text(),
        position: jQuery("#toast_position").text(),
        transition: jQuery("#toast_transition").text(),
        hideAfter: jQuery("#toast-hide").text(),
        textColor: jQuery("#toast_text_color").text(),
        bgColor: jQuery("#toast_bg_color").text()
    };

    // Widget configuration
    var widgetConfig = {
        defaultLanguage: jQuery("#default_language").text(),
        defaultLanguageImage: jQuery("#default_language_image").text(),
        languageStyle: jQuery("#language_style").text(),
        iconPosition: jQuery("#position").text(),
        translateStyle: jQuery("#style_icon").text()
    };

    // LocalStorage references
    var storage = {
        main: window.localStorage,
        langName: window.localStorage,
        checkOneTime: window.localStorage
    };

    // Get stored values
    var selectedImageSrc = storage.main.getItem("img_src");
    var languageName = storage.langName.getItem("lang_name");
    var checkOneTime = storage.checkOneTime.getItem("check_onetime");

    console.log("Default Language:", widgetConfig.defaultLanguage);

    // Check if default language has changed and clear storage if needed
    if (storage.main.getItem("default_language") !== null && 
        storage.main.getItem("default_language") !== widgetConfig.defaultLanguage) {
        console.log('Default language changed, clearing storage');
        sessionStorage.removeItem('urlUpdated');
        storage.main.clear();
        storage.checkOneTime.clear();
        storage.langName.clear();
    }

    /**
     * Show loading toast notification
     */
    function showLoadingToast() {
        jQuery.toast({
            position: toastConfig.position,
            stack: false,
            heading: 'Translating',
            text: 'Translation is in progress, please wait...',
            icon: 'info',
            loader: true,
            showHideTransition: toastConfig.transition,
            hideAfter: false,
            bgColor: toastConfig.bgColor,
            textColor: toastConfig.textColor
        });
    }

    /**
     * Show success toast notification
     * @param {string} languageName - Name of the selected language
     */
    function showSuccessToast(languageName) {
        jQuery.toast({
            position: toastConfig.position,
            stack: false,
            heading: toastConfig.title,
            text: "You Have Translated Your Website To " + languageName,
            icon: "success",
            loader: false,
            showHideTransition: toastConfig.transition,
            hideAfter: toastConfig.hideAfter,
            bgColor: toastConfig.bgColor,
            textColor: toastConfig.textColor
        });
    }

    /**
     * Update widget display with flag and language name
     * @param {string} imageSrc - Source path of the flag image
     * @param {string} langName - Name of the language
     * @param {string} selector - CSS selector for the widget (.drop or .drop_footer)
     */
    function updateWidgetDisplay(imageSrc, langName, selector) {
        var flagHtml = "<img width='24' height='24' src='" + imageSrc + "'/>";
        
        jQuery(selector + " i").remove();
        
        if (widgetConfig.translateStyle === "both" || widgetConfig.translateStyle === "both_short") {
            if (widgetConfig.iconPosition === "right") {
                jQuery(selector).append(flagHtml);
                jQuery(selector + " span").text(" " + langName + " ");
            } else {
                jQuery(selector).prepend(flagHtml);
                jQuery(selector + " span").text(" " + langName + " ");
            }
        } else if (widgetConfig.translateStyle === "icon") {
            jQuery(selector).append(flagHtml);
        } else {
            jQuery(selector + " span").text(" " + langName + " ");
        }
    }

    /**
     * Animate progress bar
     * @param {jQuery} progressBar - jQuery element of the progress bar
     */
    function animateProgressBar(progressBar) {
        var targetPercent = progressBar.attr("percent");
        progressBar.css("width", targetPercent + "%");
        
        jQuery({ animatedValue: 0 }).animate(
            { animatedValue: targetPercent },
            {
                duration: 2000,
                step: function () {
                    var currentValue = Math.floor(this.animatedValue);
                    progressBar.attr("percent", currentValue + "%");
                    progressBar.css("width", currentValue + "%");
                },
                complete: function () {
                    var finalValue = Math.floor(this.animatedValue);
                    progressBar.attr("percent", finalValue + "%");
                    progressBar.css("width", finalValue + "%");
                }
            }
        );
    }

    /**
     * Handle language selection and translation
     * @param {string} translationUrl - URL for the translation
     * @param {string} flagImageSrc - Source of the flag image
     * @param {string} languageName - Name of the selected language
     * @param {boolean} isFooter - Whether this is the footer widget
     */
    function handleLanguageSelection(translationUrl, flagImageSrc, languageName, isFooter) {
        storage.main.clear();
        
        // Show loading toast
        showLoadingToast();
        
        // Store selection in localStorage
        storage.main.setItem("img_src", flagImageSrc);
        storage.main.setItem("default_language", widgetConfig.defaultLanguage);
        storage.langName.setItem("lang_name", languageName);
        storage.checkOneTime.setItem("check_onetime", "yes");
        
        // Update UI based on widget type
        var dropdownSelector = isFooter ? ".language_footer" : ".ct-language__dropdown";
        var searchSelector = isFooter ? ".search_footer" : ".search";
        var progressBarSelector = isFooter ? ".progress-bar_footer" : ".progress-bar";
        
        jQuery(dropdownSelector).css("overflow", "hidden");
        jQuery(searchSelector).css("display", "none");
        jQuery(progressBarSelector).css("display", "block");
        
        // Animate progress bar
        jQuery(progressBarSelector).each(function () {
            animateProgressBar(jQuery(this));
        });
        
        // Make AJAX call for translation
        jQuery.ajax({
            url: translationUrl,
            type: "POST",
            cache: false,
            success: function () {
                jQuery(".goog-te-combo").val(translationUrl);
                window.location = translationUrl;
                checkOneTime = true;
                
                setTimeout(function() {
                    jQuery(progressBarSelector).css("display", "none");
                    window.location.reload(true);
                }, 4000);
            },
            error: function () {
                alert("Error occurred while translating");
            }
        });
    }

    // Initialize widget display if language is already selected
    if (languageName !== null) {
        console.log("Stored language found:", checkOneTime);
        
        // Show success toast if this is the first time after selection
        if (checkOneTime === "yes") {
            showSuccessToast(languageName);
            storage.checkOneTime.setItem("check_onetime", "no");
        }
        
        console.log("Selected image source:", selectedImageSrc);
        
        // Update both main and footer widgets
        updateWidgetDisplay(selectedImageSrc, languageName, ".drop");
        updateWidgetDisplay(selectedImageSrc, languageName, ".drop_footer");
        
    } else {
        // Initialize with default language
        storage.main.clear();
        console.log("Initializing with default language");
        
        storage.main.setItem("img_src", widgetConfig.defaultLanguageImage);
        storage.main.setItem("default_language", widgetConfig.defaultLanguage);
        
        selectedImageSrc = storage.main.getItem("img_src");
        
        if (selectedImageSrc !== null) {
            // Extract language name from image path
            var flagPath = selectedImageSrc.substring(selectedImageSrc.indexOf("flags/") + 6);
            var defaultLangName = flagPath.replace(".svg", " ");
            console.log("Default language name:", defaultLangName);
            
            // Update URL with default language (only once)
            if (!sessionStorage.getItem('urlUpdated')) {
                console.log("Updating URL with default language");
                var newUrl = window.location.href + widgetConfig.defaultLanguage;
                history.pushState(null, '', newUrl);
                location.reload();
                sessionStorage.setItem('urlUpdated', 'true');
            }
            
            // Update both main and footer widgets
            updateWidgetDisplay(selectedImageSrc, defaultLangName, ".drop");
            updateWidgetDisplay(selectedImageSrc, defaultLangName, ".drop_footer");
        }
    }

    // Event handler for main widget language selection
    jQuery(document).on("click", "a.lang-select", function (event) {
        event.preventDefault();
        
        var translationUrl = jQuery(this).attr("href");
        var flagImageSrc = jQuery(this).children("img").attr("src");
        var languageName = jQuery(this).children("img").attr("alt");
        
        console.log("Language selected:", flagImageSrc);
        handleLanguageSelection(translationUrl, flagImageSrc, languageName, false);
    });

    // Event handler for footer widget language selection
    jQuery(document).on("click", "a.lang-select_footer", function (event) {
        event.preventDefault();
        
        var translationUrl = jQuery(this).attr("href");
        var flagImageSrc = jQuery(this).children("img").attr("src");
        var languageName = jQuery(this).children("img").attr("alt");
        
        console.log("Language selected (footer):", flagImageSrc);
        handleLanguageSelection(translationUrl, flagImageSrc, languageName, true);
    });

    // Click toggle helper function
    jQuery.fn.clickToggle = function (firstAction, secondAction) {
        return this.on("click", function (event) {
            [secondAction, firstAction][(this.$_io ^= 1)].call(this, event);
        });
    };

    // Toggle main widget dropdown
    jQuery(".drop").clickToggle(
        function (event) {
            jQuery(".ct-language__dropdown").css("overflow", "visible");
            jQuery(".search").css("display", "block");
        },
        function (event) {
            jQuery(".ct-language__dropdown").css("overflow", "hidden");
            jQuery(".search").css("display", "none");
        }
    );

    // Toggle footer widget dropdown
    jQuery(".drop_footer").clickToggle(
        function (event) {
            jQuery(".language_footer").css("overflow", "visible");
            jQuery(".search_footer").css("display", "block");
        },
        function (event) {
            jQuery(".language_footer").css("overflow", "hidden");
            jQuery(".search_footer").css("display", "none");
        }
    );

    /**
     * Filter language list based on search input
     * @param {jQuery} searchInput - The search input element
     * @param {string} listSelector - Selector for the language list
     * @param {string} dropdownSelector - Selector for the dropdown container
     */
    function filterLanguageList(searchInput, listSelector, dropdownSelector) {
        var searchValue = searchInput.val();
        var matchedItems;
        
        if (widgetConfig.languageStyle === "icon") {
            if (searchValue.length !== 0) {
                matchedItems = jQuery(listSelector).find(' li a:has(img[alt*="' + searchValue + '"]) ');
                jQuery("li a", listSelector)
                    .not(matchedItems)
                    .slideUp(function () {
                        jQuery(dropdownSelector + " li").css("padding", "0px 0px 0px 0px");
                        jQuery(dropdownSelector).css("grid-template-columns", "repeat(1, 1fr)");
                    });
                matchedItems.slideDown();
            } else {
                matchedItems = jQuery(listSelector).find("li a:contains(" + searchValue + ") ");
                jQuery("li a", listSelector).not(matchedItems).slideUp();
                matchedItems.slideDown(function () {
                    jQuery(dropdownSelector + " li").css("padding", "");
                    jQuery(dropdownSelector).css("grid-template-columns", "");
                });
            }
        } else {
            matchedItems = jQuery(listSelector).find("li a:contains(" + searchValue + ") ");
            jQuery("li a", listSelector)
                .not(matchedItems)
                .slideUp(function () {
                    jQuery(dropdownSelector + " li").css("padding", "0px 0px 0px 0px");
                    jQuery(dropdownSelector).css("grid-template-columns", "repeat(1, 1fr)");
                });
            matchedItems.slideDown(function () {
                jQuery(dropdownSelector + " li").css("padding", "");
                jQuery(dropdownSelector).css("grid-template-columns", "");
            });
        }
        
        console.log("Filtered items:", matchedItems);
    }

    // Main widget search functionality
    jQuery("#search").keyup(function () {
        filterLanguageList(jQuery(this), "ul#mydata", ".ct-language__dropdown");
    });

    // Footer widget search functionality
    jQuery("#search_footer").keyup(function () {
        filterLanguageList(jQuery(this), "ul#mydata_footer", ".language_footer");
    });
});

// Global variable for data-lang attribute
var translationDataLang = jQuery(this).attr("data-lang");

// Monitor HTML class changes for translation state
const htmlElement = document.querySelector("html");
let previousTranslationState = htmlElement.classList.contains("translated-ltr");

const translationObserver = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
        if (mutation.attributeName === "class") {
            let currentTranslationState = mutation.target.classList.contains("translated-ltr");
            
            if (previousTranslationState !== currentTranslationState && currentTranslationState !== "") {
                previousTranslationState = currentTranslationState;
                
                // Clean up hash from URL
                var currentUrl = window.location.toString();
                if (currentUrl.indexOf("#") > 0) {
                    var cleanUrl = currentUrl.substring(0, currentUrl.indexOf("#"));
                    window.history.replaceState({}, document.title, cleanUrl);
                }
            }
        }
    });
});

translationObserver.observe(htmlElement, { 
    attributes: true, 
    attributeOldValue: true, 
    attributeFilter: ["class"] 
});
