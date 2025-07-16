(function($) {
    /**
     * Structured logger for debugging.
     * Can be disabled in production by setting `debug` to false.
     */
    const TLogger = {
        debug: true, // Set to false for production environments
        log: function(...args) {
            if (this.debug) {
                console.log('[Translentor]', ...args);
            }
        },
        error: function(...args) {
            if (this.debug) {
                console.error('[Translentor Error]', ...args);
            }
        }
    };

    /**
     * Main Translentor script object.
     */
    const Translentor = {
        /**
         * Initializes the script.
         */
        init: function() {
            TLogger.log('Initializing...');
            this.cacheDOMElements();
            this.getInitialSettings();
            this.setupInitialState();
            this.bindEventHandlers();
        },

        /**
         * Caches frequently used DOM elements.
         */
        cacheDOMElements: function() {
            this.dom = {
                toastTitle: $("#toast_title"),
                toastPosition: $("#toast_position"),
                toastTransition: $("#toast_transition"),
                toastHide: $("#toast-hide"),
                toastTextColor: $("#toast_text_color"),
                toastBgColor: $("#toast_bg_color"),
                defaultLanguage: $("#default_language"),
                languageStyle: $("#language_style"),
                iconPosition: $("#position"),
                translateStyle: $("#style_icon"),
                defaultLanguageImage: $("#default_language_image"),
                search: $("#search"),
                searchFooter: $("#search_footer"),
                html: $("html")
            };
        },

        /**
         * Reads initial settings from the DOM and localStorage.
         */
        getInitialSettings: function() {
            this.settings = {
                toast_title: this.dom.toastTitle.text(),
                toast_position: this.dom.toastPosition.text(),
                toast_transition: this.dom.toastTransition.text(),
                toasthide: this.dom.toastHide.text(),
                toast_text_color: this.dom.toastTextColor.text(),
                toast_bg_color: this.dom.toastBgColor.text(),
                default_language: this.dom.defaultLanguage.text(),
                language_style: this.dom.languageStyle.text(),
                icon_position: this.dom.iconPosition.text(),
                translate_style: this.dom.translateStyle.text()
            };
            this.storage = {
                local: window.localStorage,
                session: window.sessionStorage
            };
        },

        /**
         * Sets up the initial state of the language switcher.
         */
        setupInitialState: function() {
            const storedDefaultLang = this.storage.local.getItem("default_language");
            if (storedDefaultLang && storedDefaultLang !== this.settings.default_language) {
                TLogger.log('Default language changed. Clearing storage.');
                this.storage.session.removeItem('urlUpdated');
                this.storage.local.clear();
            }

            const lang_name = this.storage.local.getItem("lang_name");
            const selected_img_src = this.storage.local.getItem("img_src");

            if (lang_name) {
                TLogger.log(`Language already selected: ${lang_name}`);
                this.showToastOnTranslate(lang_name);
                this.updateLanguageSwitcherUI(lang_name, selected_img_src);
            } else {
                TLogger.log('No language selected. Setting up default language.');
                this.storage.local.clear();
                const src = this.dom.defaultLanguageImage.text();
                this.storage.local.setItem("img_src", src);
                this.storage.local.setItem("default_language", this.settings.default_language);
                
                const defaultImgSrc = this.storage.local.getItem("img_src");
                if (defaultImgSrc) {
                    const langNameFromSrc = defaultImgSrc.substring(defaultImgSrc.indexOf("flags/") + 6).replace(".svg", " ");
                    this.updateLanguageSwitcherUI(langNameFromSrc, defaultImgSrc);
                    this.handleInitialPageLoad();
                }
            }
        },

        /**
         * Handles the initial page load logic, including URL update and reload.
         */
        handleInitialPageLoad: function() {
            if (!this.storage.session.getItem('urlUpdated')) {
                TLogger.log("Performing first-time URL update and reload.");
                const newUrl = window.location.href + this.settings.default_language;
                history.pushState(null, '', newUrl);
                this.storage.session.setItem('urlUpdated', 'true');
                location.reload();
            }
        },

        /**
         * Shows a toast notification after translation.
         * @param {string} lang_name - The name of the language.
         */
        showToastOnTranslate: function(lang_name) {
            if (this.storage.local.getItem("check_onetime") === "yes") {
                $.toast({
                    position: this.settings.toast_position,
                    stack: false,
                    heading: this.settings.toast_title,
                    text: "You Have Translated Your Website To " + lang_name,
                    icon: "success",
                    loader: false,
                    showHideTransition: this.settings.toast_transition,
                    hideAfter: this.settings.toasthide,
                    bgColor: this.settings.toast_bg_color,
                    textColor: this.settings.toast_text_color,
                });
                this.storage.local.setItem("check_onetime", "no");
            }
        },

        /**
         * Updates the language switcher UI.
         * @param {string} langName - The language name to display.
         * @param {string} imgSrc - The path to the flag image.
         */
        updateLanguageSwitcherUI: function(langName, imgSrc) {
            const { translate_style, icon_position } = this.settings;
            const $drop = $(".drop, .drop_footer");
            const $span = $drop.find("span");
            
            $drop.find("i, img").remove();

            if (["both", "both_short"].includes(translate_style)) {
                const img = `<img width='24' height='24' src='${imgSrc}'/>`;
                if (icon_position === "right") {
                    $drop.append(img);
                } else {
                    $drop.prepend(img);
                }
                $span.text(` ${langName} `);
            } else if (translate_style === "icon") {
                $drop.append(`<img width='24' height='24' src='${imgSrc}'/>`);
            } else {
                $span.text(` ${langName} `);
            }
        },

        /**
         * Binds all necessary event handlers.
         */
        bindEventHandlers: function() {
            const self = this;

            // Language selection
            $(document).on("click", "a.lang-select, a.lang-select_footer", function(e) {
                e.preventDefault();
                self.handleLanguageSelection($(this));
            });

            // Dropdown toggles
            this.setupDropdownToggle(".drop", ".ct-language__dropdown", ".search");
            this.setupDropdownToggle(".drop_footer", ".language_footer", ".search_footer");

            // Search filters
            this.setupSearchFilter("#search", "ul#mydata", ".ct-language__dropdown");
            this.setupSearchFilter("#search_footer", "ul#mydata_footer", ".language_footer");
        },

        /**
         * Handles the logic when a new language is selected.
         * @param {jQuery} $element - The clicked language link.
         */
        handleLanguageSelection: function($element) {
            this.storage.local.clear();
            const href = $element.attr("href");
            const imgSrc = $element.children("img").attr("src");
            const langName = $element.children("img").attr("alt");

            this.storage.local.setItem("img_src", imgSrc);
            this.storage.local.setItem("default_language", this.settings.default_language);
            this.storage.local.setItem("lang_name", langName);
            this.storage.local.setItem("check_onetime", "yes");

            const isFooter = $element.hasClass('lang-select_footer');
            const $progressBar = isFooter ? $(".progress-bar_footer") : $(".progress-bar");
            
            if(isFooter) {
                $(".language_footer").css("overflow", "hidden");
                $(".search_footer").hide();
            } else {
                $(".ct-language__dropdown").css("overflow", "hidden");
                $(".search").hide();
            }

            this.animateProgressBar($progressBar);

            $.ajax({
                url: href,
                type: "POST",
                cache: false,
                success: function() {
                    TLogger.log(`Successfully initiated translation to ${langName}`);
                    window.location = href;
                    setTimeout(() => {
                        $progressBar.hide();
                        window.location.reload(true);
                    }, 4000);
                },
                error: function(xhr, status, error) {
                    TLogger.error("Translation AJAX request failed.", { status, error });
                    alert("Error occurred while Translating");
                }
            });
        },

        /**
         * Animates the progress bar.
         * @param {jQuery} $progressBar - The progress bar element.
         */
        animateProgressBar: function($progressBar) {
            $progressBar.show().each(function() {
                const $bar = $(this);
                const percent = $bar.attr("percent");
                $bar.css("width", "0%");
                $({ animatedValue: 0 }).animate({ animatedValue: percent }, {
                    duration: 2000,
                    step: function() {
                        const w = Math.floor(this.animatedValue) + "%";
                        $bar.attr("percent", w).css("width", w);
                    }
                });
            });
        },

        /**
         * Sets up a click toggle for a dropdown menu.
         * @param {string} triggerSelector - The selector for the dropdown trigger.
         * @param {string} dropdownSelector - The selector for the dropdown container.
         * @param {string} searchSelector - The selector for the search input.
         */
        setupDropdownToggle: function(triggerSelector, dropdownSelector, searchSelector) {
            $(triggerSelector).on('click', function() {
                const $dropdown = $(dropdownSelector);
                const isVisible = $dropdown.css('overflow') === 'visible';
                $dropdown.css('overflow', isVisible ? 'hidden' : 'visible');
                $(searchSelector).toggle(!isVisible);
            });
        },

        /**
         * Sets up a search filter for a language list.
         * @param {string} inputSelector - The selector for the search input.
         * @param {string} listSelector - The selector for the list to filter.
         * @param {string} containerSelector - The selector for the list's container.
         */
        setupSearchFilter: function(inputSelector, listSelector, containerSelector) {
            const self = this;
            $(inputSelector).on('keyup', function() {
                const val = $(this).val().toLowerCase();
                const $listItems = $(`${listSelector} li`);
                
                $listItems.slideUp();

                const $matches = $listItems.filter(function() {
                    if (self.settings.language_style === 'icon') {
                        return $(this).find(`img[alt*='${val}']`).length > 0;
                    }
                    return $(this).text().toLowerCase().includes(val);
                });

                $matches.slideDown();

                const isFiltering = val.length > 0;
                $(containerSelector).css({
                    "grid-template-columns": isFiltering ? "repeat(1, 1fr)" : "",
                });
                 $(`${containerSelector} li`).css({
                    "padding": isFiltering ? "0px" : "",
                });
            });
        }
    };

    /**
     * Initializes Google Translate script.
     */
    function loadGoogleTranslate() {
        try {
            var script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = 'https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';
            document.body.appendChild(script);

            window.googleTranslateElementInit = function() {
                try {
                    new google.translate.TranslateElement({
                        layout: google.translate.TranslateElement.FloatPosition.TOP_LEFT
                    }, "google_translate_element");
                    var currentUrl = window.location.toString();
                    if (currentUrl.includes("#")) {
                        var cleanUrl = currentUrl.substring(0, currentUrl.indexOf("#"));
                        window.history.replaceState({}, document.title, cleanUrl);
                    }
                } catch (e) {
                    TLogger.error("Google Translate init failed.", e);
                }
            };
        } catch (e) {
            TLogger.error("Google Translate script load failed.", e);
        }
    }

    /**
     * Observes changes to the HTML tag's class to handle translation state.
     */
    function setupMutationObserver() {
        const element = document.querySelector("html");
        if (!element) return;

        let prevState = element.classList.contains("translated-ltr");
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.attributeName === "class") {
                    let currentState = mutation.target.classList.contains("translated-ltr");
                    if (prevState !== currentState) {
                        prevState = currentState;
                        let r = window.location.toString();
                        if (r.includes("#")) {
                            let i = r.substring(0, r.indexOf("#"));
                            window.history.replaceState({}, document.title, i);
                        }
                    }
                }
            });
        });
        observer.observe(element, { attributes: true, attributeOldValue: true, attributeFilter: ["class"] });
    }

    // --- Document Ready ---
    $(document).ready(function() {
        try {
            Translentor.init();
        } catch (e) {
            TLogger.error("Translentor initialization failed.", e);
        }
    });

    // --- DOM Content Loaded ---
    document.addEventListener('DOMContentLoaded', function() {
        loadGoogleTranslate();
        setupMutationObserver();
    });

})(jQuery);
