document.addEventListener('DOMContentLoaded', function () {
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            layout: google.translate.TranslateElement.FloatPosition.TOP_LEFT
        }, "google_translate_element");

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



jQuery(document).ready(function () {
    (toast_title = jQuery("#toast_title").text()),
        (toast_position = jQuery("#toast_position").text()),
        (toast_transition = jQuery("#toast_transition").text()),
        (toasthide = jQuery("#toast-hide").text()),
        (toast_text_color = jQuery("#toast_text_color").text()),
        (toast_bg_color = jQuery("#toast_bg_color").text()),
        (default_language = jQuery("#default_language").text()),
        (language_style = jQuery("#language_style").text()),
        console.log(default_language),
        (myStorage = window.localStorage),
        (myStroage1 = window.localStorage),
        (myStorage2 = window.localStorage),
        (selected_img_src = myStorage.getItem("img_src")),
        (lang_name = myStorage2.getItem("lang_name")),
        (check_onetime = myStroage1.getItem("check_onetime")),
        (icon_position = jQuery("#position").text()),
        (translate_style = jQuery("#style_icon").text());
        if(myStorage.getItem("default_language") !=null && myStorage.getItem("default_language") != default_language){
            console.log('changed'),
            sessionStorage.removeItem('urlUpdated'),
            myStorage.clear(),
            myStroage1.clear(),
            myStorage2.clear();
        }
    if (
        null != lang_name
    ) {
        let e = lang_name;
        if (
            (console.log(myStroage1.getItem("check_onetime")),
            "yes" == check_onetime &&
                (jQuery.toast({
                    position: toast_position,
                    stack: !1,
                    heading: toast_title,
                    text: "You Have Translated Your Website To " + e,
                    icon: "success",
                    loader: !1,
                    showHideTransition: toast_transition,
                    hideAfter: toasthide,
                    bgColor: toast_bg_color,
                    textColor: toast_text_color,
                }),
                myStroage1.setItem("check_onetime", "no")),
            console.log(selected_img_src),
            "both" == translate_style || "both_short" == translate_style)
        ) {
            if ("right" == icon_position) {
                jQuery(".drop i").remove(), jQuery(".drop_footer i").remove();
                let o = lang_name;
                console.log(o),
                    jQuery(".drop").append("<img width='24' height='24' src='" + selected_img_src + "'/>"),
                    jQuery(".drop_footer").append("<img width='24' height='24' src='" + selected_img_src + "'/>"),
                    jQuery(".drop span").text(" " + o + " "),
                    jQuery(".drop_footer span").text(" " + o + " ");
            } else {
                jQuery(".drop i").remove(), jQuery(".drop_footer i").remove();
                let a = lang_name;
                console.log(a),
                    console.log("check point"),
                    jQuery(".drop").prepend("<img width='24' height='24' src='" + selected_img_src + "'/>"),
                    jQuery(".drop_footer").prepend("<img width='24' height='24' src='" + selected_img_src + "'/>"),
                    jQuery(".drop span").text(" " + a + " "),
                    jQuery(".drop_footer span").text(" " + a + " ");
            }
        } else if ("icon" == translate_style)
            jQuery(".drop i").remove(),
                jQuery(".drop_footer i").remove(),
                jQuery(".drop").append("<img width='24' height='24' src='" + selected_img_src + "'/>"),
                jQuery(".drop_footer").append("<img width='24' height='24' src='" + selected_img_src + "'/>");
        else {
            let r = lang_name;
            jQuery(".drop span").text(" " + r + " "), jQuery(".drop_footer span").text(" " + r + " ");
        }
    } else if ((myStorage.clear(), console.log("rIGHT hERE"), (src = jQuery("#default_language_image").text()), myStorage.setItem("img_src", src),myStorage.setItem("default_language", default_language), null != (selected_img_src = (myStorage = window.localStorage).getItem("img_src")))) {
        let i = selected_img_src.substring(selected_img_src.indexOf("flags/") + 6),
            n = i.replace(".svg", " ");
        console.log("ddd" + n);
        if (!sessionStorage.getItem('urlUpdated')) {
            console.log("Once"),
         newUrl = window.location.href +  default_language,

        // Update the URL without reloading the page
        history.pushState(null, '', newUrl),

        // Reload the page
        location.reload(),
        
        sessionStorage.setItem('urlUpdated', 'true');
        }
        //  window.location.href =default_language,
        //  window.location.reload(!0),
            "both" == translate_style || "both_short" == translate_style
                ? "right" == icon_position
                    ? (jQuery(".drop i").remove(),
                      jQuery(".drop_footer i").remove(),
                      jQuery(".drop").append("<img width='24' height='24' src='" + selected_img_src + "'/>"),
                      jQuery(".drop_footer").append("<img width='24' height='24' src='" + selected_img_src + "'/>"),
                      jQuery(".drop span").text(" " + n + " "),
                      jQuery(".drop_footer span").text(" " + n + " "))
                    : (jQuery(".drop i").remove(),
                      jQuery(".drop_footer i").remove(),
                      jQuery(".drop").prepend("<img width='24' height='24' src='" + selected_img_src + "'/>"),
                      jQuery(".drop_footer").prepend("<img width='24' height='24' src='" + selected_img_src + "'/>"),
                      jQuery(".drop span").text(" " + n + " "),
                      jQuery(".drop_footer span").text(" " + n + " "))
                : "icon" == translate_style
                ? (jQuery(".drop i").remove(),
                  jQuery(".drop_footer i").remove(),
                  jQuery(".drop").append("<img width='24' height='24' src='" + selected_img_src + "'/>"),
                  jQuery(".drop_footer").append("<img width='24' height='24' src='" + selected_img_src + "'/>"))
                : (jQuery(".drop span").text(" " + n + " "), jQuery(".drop_footer span").text(" " + n + " "));
    }
    
        jQuery(document).on("click", "a.lang-select", function (e) {
            myStorage.clear(), e.preventDefault();
            var o = jQuery(this).attr("href"),
                a = jQuery(this).children("img").attr("src"),
                r = jQuery(this).children("img").attr("alt");
            console.log(a),
                myStorage.setItem("img_src", a),
                myStorage.setItem("default_language", default_language),
                myStorage2.setItem("lang_name", r),
                myStroage1.setItem("check_onetime", "yes"),
                jQuery(".ct-language__dropdown").css("overflow", "hidden"),
                jQuery(".search").css("display", "none"),
                jQuery(".progress-bar").css("display", "block"),
                jQuery(".progress-bar").each(function () {
                    var e = jQuery(this),
                        o = e.attr("percent");
                    e.css("width", o + "%"),
                        jQuery({ animatedValue: 0 }).animate(
                            { animatedValue: o },
                            {
                                duration: 2e3,
                                step: function () {
                                    e.attr("percent", Math.floor(this.animatedValue) + "%"), e.css("width", Math.floor(this.animatedValue) + "%");
                                },
                                complete: function () {
                                    e.attr("percent", Math.floor(this.animatedValue) + "%"), e.css("width", Math.floor(this.animatedValue) + "%");
                                },
                            }
                        );
                }),
                jQuery.ajax({
                    url: o,
                    type: "POST",
                    cache: !1,
                    success: function () {
                        jQuery(".goog-te-combo").val(t),
                            (window.location = o),
                            (check_onetime = !0),
                            setInterval(() => {
                                jQuery(".progress-bar").css("display", "none"), window.location.reload(!0);
                            }, 4e3);
                    },
                    error: function () {
                        alert("Error Occure while Translating");
                    },
                });
        }),
        jQuery(document).on("click", "a.lang-select_footer", function (e) {
            myStorage.clear(), e.preventDefault();
            var o = jQuery(this).attr("href"),
                a = jQuery(this).children("img").attr("src"),
                r = jQuery(this).children("img").attr("alt");
            console.log(a),
                myStorage.setItem("img_src", a),
                myStorage.setItem("default_language", default_language),
                myStorage2.setItem("lang_name", r),
                jQuery(".language_footer").css("overflow", "hidden"),
                jQuery(".search_footer").css("display", "none"),
                jQuery(".progress-bar_footer").css("display", "block"),
                jQuery(".progress-bar_footer").each(function () {
                    var e = jQuery(this),
                        o = e.attr("percent");
                    e.css("width", o + "%"),
                        jQuery({ animatedValue: 0 }).animate(
                            { animatedValue: o },
                            {
                                duration: 2e3,
                                step: function () {
                                    e.attr("percent", Math.floor(this.animatedValue) + "%"), e.css("width", Math.floor(this.animatedValue) + "%");
                                },
                                complete: function () {
                                    e.attr("percent", Math.floor(this.animatedValue) + "%"), e.css("width", Math.floor(this.animatedValue) + "%");
                                },
                            }
                        );
                }),
                jQuery.ajax({
                    url: o,
                    type: "POST",
                    success: function () {
                        jQuery(".goog-te-combo").val(t),
                            (window.location = o),
                            setInterval(() => {
                                jQuery(".progress-bar_footer").css("display", "none"), window.location.reload();
                            }, 4e3);
                    },
                    error: function () {
                        alert("Error Occure while Translating");
                    },
                });
        }),
        (jQuery.fn.clickToggle = function (e, o) {
            return this.on("click", function (a) {
                [o, e][(this.$_io ^= 1)].call(this, a);
            });
        }),
        jQuery(".drop").clickToggle(
            function (e) {
                jQuery(".ct-language__dropdown").css("overflow", "visible"), jQuery(".search").css("display", "block");
            },
            function (e) {
                jQuery(".ct-language__dropdown").css("overflow", "hidden"), jQuery(".search").css("display", "none");
            }
        ),
        jQuery(".drop_footer").clickToggle(
            function (e) {
                jQuery(".language_footer").css("overflow", "visible"), jQuery(".search_footer").css("display", "block");
            },
            function (e) {
                jQuery(".language_footer").css("overflow", "hidden"), jQuery(".search_footer").css("display", "none");
            }
        ),
        jQuery(function () {
            jQuery("#search").keyup(function () {
                if ("icon" === language_style) {
                    if (0 !== jQuery(this).val().length) {
                        var e = jQuery("ul#mydata").find(' li a:has(img[alt*="' + jQuery(this).val() + '"]) ');
                        jQuery("li a", "ul#mydata")
                            .not(e)
                            .slideUp(function () {
                                jQuery(".ct-language__dropdown li").css("padding", "0px 0px 0px 0px"), jQuery(".ct-language__dropdown").css("grid-template-columns", "repeat(1, 1fr)");
                            }),
                            e.slideDown(),
                            console.log(e);
                    } else {
                        var e = jQuery("ul#mydata").find("li a:contains(" + jQuery(this).val() + ") ");
                        jQuery("li a", "ul#mydata").not(e).slideUp(),
                            e.slideDown(function () {
                                jQuery(".ct-language__dropdown li").css("padding", ""), jQuery(".ct-language__dropdown").css("grid-template-columns", "");
                            });
                    }
                } else {
                    var e = jQuery("ul#mydata").find("li a:contains(" + jQuery(this).val() + ") ");
                    jQuery("li a", "ul#mydata")
                        .not(e)
                        .slideUp(function () {
                            jQuery(".ct-language__dropdown li").css("padding", "0px 0px 0px 0px"), jQuery(".ct-language__dropdown").css("grid-template-columns", "repeat(1, 1fr)");
                        }),
                        e.slideDown(function () {
                            jQuery(".ct-language__dropdown li").css("padding", ""), jQuery(".ct-language__dropdown").css("grid-template-columns", "");
                        }),
                        console.log(e);
                }
            });
        }),
        jQuery(function () {
            jQuery("#search_footer").keyup(function () {
                if ("icon" === language_style) {
                    if (0 !== jQuery(this).val().length) {
                        var e = jQuery("ul#mydata_footer").find(' li a:has(img[alt*="' + jQuery(this).val() + '"]) ');
                        jQuery("li a", "ul#mydata_footer")
                            .not(e)
                            .slideUp(function () {
                                jQuery(".language_footer li").css("padding", "0px 0px 0px 0px"), jQuery(".language_footer").css("grid-template-columns", "repeat(1, 1fr)");
                            }),
                            e.slideDown(),
                            console.log(e);
                    } else {
                        var e = jQuery("ul#mydata_footer").find("li a:contains(" + jQuery(this).val() + ") ");
                        jQuery("li a", "ul#mydata_footer").not(e).slideUp(),
                            e.slideDown(function () {
                                jQuery(".language_footer li").css("padding", ""), jQuery(".language_footer").css("grid-template-columns", "");
                            });
                    }
                } else {
                    var e = jQuery("ul#mydata_footer").find("li a:contains(" + jQuery(this).val() + ") ");
                    jQuery("li a", "ul#mydata_footer")
                        .not(e)
                        .slideUp(function () {
                            jQuery(".language_footer li").css("padding", "0px 0px 0px 0px"), jQuery(".language_footer").css("grid-template-columns", "repeat(1, 1fr)");
                        }),
                        e.slideDown(function () {
                            jQuery(".language_footer li").css("padding", ""), jQuery(".language_footer").css("grid-template-columns", "");
                        }),
                        console.log(e);
                }
            });
        });
});
var t = jQuery(this).attr("data-lang");
const element = document.querySelector("html");
let prevState = element.classList.contains("translated-ltr");
const observer = new MutationObserver((e) => {
    e.forEach((e) => {
        let { target: o } = e;
        if ("class" === e.attributeName) {
            let a = e.target.classList.contains("translated-ltr");
            if (prevState !== a && "" !== (prevState = a)) {
                var r = window.location.toString();
                if (r.indexOf("#") > 0) {
                    var i = r.substring(0, r.indexOf("#"));
                    window.history.replaceState({}, document.title, i);
                }
            }
        }
    });
});
observer.observe(document.querySelector("html"), { attributes: !0, attributeOldValue: !0, attributeFilter: ["class"] });
