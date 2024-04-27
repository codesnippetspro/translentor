
!(function () {
    
 
    !(function () {
        "use strict";
       
       
        function r(e, t) {
            return (
                (function (e) {
                    if (Array.isArray(e)) return e;
                })(e) ||
                (function (e, t) {
                    var a = null == e ? null : ("undefined" != typeof Symbol && e[Symbol.iterator]) || e["@@iterator"];
                    if (null == a) return;
                    var r,
                        n,
                        o = [],
                        l = !0,
                        i = !1;
                    try {
                        for (a = a.call(e); !(l = (r = a.next()).done) && (o.push(r.value), !t || o.length !== t); l = !0);
                    } catch (c) {
                        (i = !0), (n = c);
                    } finally {
                        try {
                            l || null == a["return"] || a["return"]();
                        } finally {
                            if (i) throw n;
                        }
                    }
                    return o;
                })(e, t) ||
                (function (e, t) {
                    if (!e) return;
                    if ("string" == typeof e) return n(e, t);
                    var a = Object.prototype.toString.call(e).slice(8, -1);
                    "Object" === a && e.constructor && (a = e.constructor.name);
                    if ("Map" === a || "Set" === a) return Array.from(e);
                    if ("Arguments" === a || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(a)) return n(e, t);
                })(e, t) ||
                (function () {
                    throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
                })()
            );
        }
        function n(e, t) {
            (null == t || t > e.length) && (t = e.length);
            for (var a = 0, r = new Array(t); a < t; a++) r[a] = e[a];
            return r;
        }
        var o = function (e) {
            var t = e.menuItems,
                a = e.switchTab,
                n = e.currentTab,
                o = e.isMenu,
                l = e.isDisabled;
            return o
                ? React.createElement(
                      "div",
                      { className: "elementor-templates-modal__header__menu-area", "data-disabled": l },
                      React.createElement(
                          "div",
                          { id: "elementor-template-library-header-menu" },
                          Object.entries(t)
                              .reverse()
                              .map(function (e, t) {
                                  var o = r(e, 2),
                                      l = (o[0], o[1]);
                                  return React.createElement("div", { className: "elementor-component-tab elementor-template-library-menu-item" + (n === l.slug ? " elementor-active" : ""), "data-tab": l.slug, onClick: a, key: t }, l.title);
                              })
                      )
                  )
                : React.createElement("div", { className: "elementor-templates-modal__header__menu-area", hidden: !0 });
        };
        
        
        function s(e, t) {
            return (
                (function (e) {
                    if (Array.isArray(e)) return e;
                })(e) ||
                (function (e, t) {
                    var a = null == e ? null : ("undefined" != typeof Symbol && e[Symbol.iterator]) || e["@@iterator"];
                    if (null == a) return;
                    var r,
                        n,
                        o = [],
                        l = !0,
                        i = !1;
                    try {
                        for (a = a.call(e); !(l = (r = a.next()).done) && (o.push(r.value), !t || o.length !== t); l = !0);
                    } catch (c) {
                        (i = !0), (n = c);
                    } finally {
                        try {
                            l || null == a["return"] || a["return"]();
                        } finally {
                            if (i) throw n;
                        }
                    }
                    return o;
                })(e, t) ||
                (function (e, t) {
                    if (!e) return;
                    if ("string" == typeof e) return u(e, t);
                    var a = Object.prototype.toString.call(e).slice(8, -1);
                    "Object" === a && e.constructor && (a = e.constructor.name);
                    if ("Map" === a || "Set" === a) return Array.from(e);
                    if ("Arguments" === a || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(a)) return u(e, t);
                })(e, t) ||
                (function () {
                    throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
                })()
            );
        }
        function u(e, t) {
            (null == t || t > e.length) && (t = e.length);
            for (var a = 0, r = new Array(t); a < t; a++) r[a] = e[a];
            return r;
        }
        
        
        function f(e, t) {
            return (
                (function (e) {
                    if (Array.isArray(e)) return e;
                })(e) ||
                (function (e, t) {
                    var a = null == e ? null : ("undefined" != typeof Symbol && e[Symbol.iterator]) || e["@@iterator"];
                    if (null == a) return;
                    var r,
                        n,
                        o = [],
                        l = !0,
                        i = !1;
                    try {
                        for (a = a.call(e); !(l = (r = a.next()).done) && (o.push(r.value), !t || o.length !== t); l = !0);
                    } catch (c) {
                        (i = !0), (n = c);
                    } finally {
                        try {
                            l || null == a["return"] || a["return"]();
                        } finally {
                            if (i) throw n;
                        }
                    }
                    return o;
                })(e, t) ||
                (function (e, t) {
                    if (!e) return;
                    if ("string" == typeof e) return p(e, t);
                    var a = Object.prototype.toString.call(e).slice(8, -1);
                    "Object" === a && e.constructor && (a = e.constructor.name);
                    if ("Map" === a || "Set" === a) return Array.from(e);
                    if ("Arguments" === a || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(a)) return p(e, t);
                })(e, t) ||
                (function () {
                    throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
                })()
            );
        }
        function p(e, t) {
            (null == t || t > e.length) && (t = e.length);
            for (var a = 0, r = new Array(t); a < t; a++) r[a] = e[a];
            return r;
        }
        
            
       
       
     
     
        function E(e) {
            return (
                (E =
                    "function" == typeof Symbol && "symbol" == typeof Symbol.iterator
                        ? function (e) {
                              return typeof e;
                          }
                        : function (e) {
                              return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e;
                          }),
                E(e)
            );
        }
        function R(e, t) {
            for (var a = 0; a < t.length; a++) {
                var r = t[a];
                (r.enumerable = r.enumerable || !1), (r.configurable = !0), "value" in r && (r.writable = !0), Object.defineProperty(e, r.key, r);
            }
        }
        function _(e, t) {
            return (
                (_ =
                    Object.setPrototypeOf ||
                    function (e, t) {
                        return (e.__proto__ = t), e;
                    }),
                _(e, t)
            );
        }
        function k(e) {
            var t = (function () {
                if ("undefined" == typeof Reflect || !Reflect.construct) return !1;
                if (Reflect.construct.sham) return !1;
                if ("function" == typeof Proxy) return !0;
                try {
                    return Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})), !0;
                } catch (e) {
                    return !1;
                }
            })();
            return function () {
                var a,
                    r = O(e);
                if (t) {
                    var n = O(this).constructor;
                    a = Reflect.construct(r, arguments, n);
                } else a = r.apply(this, arguments);
                return N(this, a);
            };
        }
        function N(e, t) {
            if (t && ("object" === E(t) || "function" == typeof t)) return t;
            if (void 0 !== t) throw new TypeError("Derived constructors may only return object or undefined");
            return L(e);
        }
        function L(e) {
            if (void 0 === e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
            return e;
        }
        function O(e) {
            return (
                (O = Object.setPrototypeOf
                    ? Object.getPrototypeOf
                    : function (e) {
                          return e.__proto__ || Object.getPrototypeOf(e);
                      }),
                O(e)
            );
        }
        function T(e, t, a) {
            return t in e ? Object.defineProperty(e, t, { value: a, enumerable: !0, configurable: !0, writable: !0 }) : (e[t] = a), e;
        }
        var I,
            S
        (I = jQuery),
            (S = {
                
                previewLoaded: function () {
                    var e = setInterval(function () {
                        window.elementor.$previewContents.find(".elementor-add-new-section").length && (S.addButton(), clearInterval(e));
                    }, 100);
                    window.elementor.$previewContents.on("click", ".elementor-add-translation-button a", function () {
                         var targetUrl = jQuery(this).attr('href');
                        window.location = targetUrl;
                    });
            
                },
                addButton: function () {
                    var e = window.elementor.$previewContents.find(".elementor-add-template-button"),
                        t = I('<div class="elementor-add-translation-button"> <a  class="edit_translation" aria-haspopup="true" href='+localize.url+'><span class="edit-label">Edit Translation</span></a></div>');
                    e.after(t),
                        window.elementor.$previewContents.on("click", ".elementor-add-translation-button a", function () {
                             var targetUrl = jQuery(this).attr('href');
                             window.location = targetUrl;
                        });
                },
                init: function () {
                    window.elementor.on("preview:loaded", window._.bind(S.previewLoaded, S));
                },
            }),
            I(window).on("elementor:init", S.init);
    })();
})();
