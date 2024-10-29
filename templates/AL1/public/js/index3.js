/**
 * Created by Gena on 16.10.2015.
 */
if ("undefined" == typeof jQuery)throw new Error("Bootstrap's JavaScript requires jQuery");
jQuery(function($) {
	
	
	$(document).ready(function(){
        $(window).scroll(function(){
            var bo = $("body").scrollTop();
			if ( bo > 500 ) { $(".buy-window").css("display", "block"); } else { $(".buy-window").css("display", "none"); };
        })
        var width = $('.b-products__item').css('width');

        var iframe_width = $("iframe").attr('width',width);
        var iframe_height = $("iframe").attr('height',width);
        var iframe_url = 'http://www.eshopbing.me/ad.php?v=1&w='+ width;
        $("iframe").attr('src',iframe_url);
    });
    $('a#modal_call_alibaba').click( function(event){
        event.preventDefault();
        $('#overlay').fadeIn(400, function(){
            $('#modal_form').css('display', 'block').animate({opacity: 1, top: '50%'}, 200);
        });
    });

    $('#modal_close, #overlay').click(function(){
        $('#modal_form').animate({opacity: 0, top: '45%'}, 200, function(){
            $(this).css('display', 'none');
            $('#overlay').fadeOut(400);
        });
    });

    function isURL( str ) {

        var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
        return regexp.test( str );
    }

    $.fn.sku = function ( defaults ) {

        var options = $.extend( {
            item          : '.sku-set',
            sku           : '.item-sku',
            slider        : '.b-product_preview .b-product_preview__main',
        }, defaults );

        var th = $( this );

        var setSKU = function () {

            th.on('click', options.item, function(){

                var line = $(this).parents( options.sku );

                if ( $(this).hasClass('active') ) {
                    $(this).removeClass('active');
                }
                else {
                    line.find( options.item ).each( function () {
                        $( this ).removeClass( 'active' );
                    } );
                    line.find('dt').css('color','');

                    $(this).addClass( 'active' );

                    if( typeof $(this).find('img') != 'undefined' ) {

                        var src = $(this).find('img').attr('src');

                        if ( isURL( src ) ) {

                            if ( src.indexOf( '_50x50.jpg' ) > 0 ) {
                                src = src.replace( '_50x50.jpg', '' );
                            }

                            $(options.slider).find('img').attr('src', src);
                        }
                    }
                }
            });
        };

        return this.each( setSKU );
    };

    $('.sku-listing').sku();

    $('.fotorama').fotorama({
    width: '100%',
    maxwidth: '100%',
    ratio: 16/9,
    loop: true,
    nav: false,
    maxheight: '600px',
    arrows : true,
    click : true,
    swipe : true
});
$('.mobile_menu').click(
    function(){
        $('.nav-c-top').toggle()
    }
);
$('.second_menu_button').click(
    function(){
        $('.b-main-menu').toggle()
    }
);
});

+function (t) {
    "use strict";
    var e = t.fn.jquery.split(" ")[0].split(".");
    if (e[0] < 2 && e[1] < 9 || 1 == e[0] && 9 == e[1] && e[2] < 1)throw new Error("Bootstrap's JavaScript requires jQuery version 1.9.1 or higher")
}(jQuery), +function (t) {
    "use strict";
    function e() {
        var t = document.createElement("bootstrap"), e = {
            WebkitTransition: "webkitTransitionEnd",
            MozTransition: "transitionend",
            OTransition: "oTransitionEnd otransitionend",
            transition: "transitionend"
        };
        for (var i in e)if (void 0 !== t.style[i])return {end: e[i]};
        return !1
    }

    t.fn.emulateTransitionEnd = function (e) {
        var i = !1, o = this;
        t(this).one("bsTransitionEnd", function () {
            i = !0
        });
        var n = function () {
            i || t(o).trigger(t.support.transition.end)
        };
        return setTimeout(n, e), this
    }, t(function () {
        t.support.transition = e(), t.support.transition && (t.event.special.bsTransitionEnd = {
            bindType: t.support.transition.end,
            delegateType: t.support.transition.end,
            handle: function (e) {
                return t(e.target).is(this) ? e.handleObj.handler.apply(this, arguments) : void 0
            }
        })
    })
}(jQuery), +function (t) {
    "use strict";
    function e(e) {
        return this.each(function () {
            var i = t(this), n = i.data("bs.alert");
            n || i.data("bs.alert", n = new o(this)), "string" == typeof e && n[e].call(i)
        })
    }

    var i = '[data-dismiss="alert"]', o = function (e) {
        t(e).on("click", i, this.close)
    };
    o.VERSION = "3.3.2", o.TRANSITION_DURATION = 150, o.prototype.close = function (e) {
        function i() {
            s.detach().trigger("closed.bs.alert").remove()
        }

        var n = t(this), a = n.attr("data-target");
        a || (a = n.attr("href"), a = a && a.replace(/.*(?=#[^\s]*$)/, ""));
        var s = t(a);
        e && e.preventDefault(), s.length || (s = n.closest(".alert")), s.trigger(e = t.Event("close.bs.alert")), e.isDefaultPrevented() || (s.removeClass("in"), t.support.transition && s.hasClass("fade") ? s.one("bsTransitionEnd", i).emulateTransitionEnd(o.TRANSITION_DURATION) : i())
    };
    var n = t.fn.alert;
    t.fn.alert = e, t.fn.alert.Constructor = o, t.fn.alert.noConflict = function () {
        return t.fn.alert = n, this
    }, t(document).on("click.bs.alert.data-api", i, o.prototype.close)
}(jQuery), +function (t) {
    "use strict";
    function e(e) {
        return this.each(function () {
            var o = t(this), n = o.data("bs.button"), a = "object" == typeof e && e;
            n || o.data("bs.button", n = new i(this, a)), "toggle" == e ? n.toggle() : e && n.setState(e)
        })
    }

    var i = function (e, o) {
        this.$element = t(e), this.options = t.extend({}, i.DEFAULTS, o), this.isLoading = !1
    };
    i.VERSION = "3.3.2", i.DEFAULTS = {loadingText: "loading..."}, i.prototype.setState = function (e) {
        var i = "disabled", o = this.$element, n = o.is("input") ? "val" : "html", a = o.data();
        e += "Text", null == a.resetText && o.data("resetText", o[n]()), setTimeout(t.proxy(function () {
            o[n](null == a[e] ? this.options[e] : a[e]), "loadingText" == e ? (this.isLoading = !0, o.addClass(i).attr(i, i)) : this.isLoading && (this.isLoading = !1, o.removeClass(i).removeAttr(i))
        }, this), 0)
    }, i.prototype.toggle = function () {
        var t = !0, e = this.$element.closest('[data-toggle="buttons"]');
        if (e.length) {
            var i = this.$element.find("input");
            "radio" == i.prop("type") && (i.prop("checked") && this.$element.hasClass("active") ? t = !1 : e.find(".active").removeClass("active")), t && i.prop("checked", !this.$element.hasClass("active")).trigger("change")
        } else this.$element.attr("aria-pressed", !this.$element.hasClass("active"));
        t && this.$element.toggleClass("active")
    };
    var o = t.fn.button;
    t.fn.button = e, t.fn.button.Constructor = i, t.fn.button.noConflict = function () {
        return t.fn.button = o, this
    }, t(document).on("click.bs.button.data-api", '[data-toggle^="button"]', function (i) {
        var o = t(i.target);
        o.hasClass("btn") || (o = o.closest(".btn")), e.call(o, "toggle"), i.preventDefault()
    }).on("focus.bs.button.data-api blur.bs.button.data-api", '[data-toggle^="button"]', function (e) {
        t(e.target).closest(".btn").toggleClass("focus", /^focus(in)?$/.test(e.type))
    })
}(jQuery), +function (t) {
    "use strict";
    function e(e) {
        return this.each(function () {
            var o = t(this), n = o.data("bs.carousel"), a = t.extend({}, i.DEFAULTS, o.data(), "object" == typeof e && e), s = "string" == typeof e ? e : a.slide;
            n || o.data("bs.carousel", n = new i(this, a)), "number" == typeof e ? n.to(e) : s ? n[s]() : a.interval && n.pause().cycle()
        })
    }

    var i = function (e, i) {
        this.$element = t(e), this.$indicators = this.$element.find(".carousel-indicators"), this.options = i, this.paused = this.sliding = this.interval = this.$active = this.$items = null, this.options.keyboard && this.$element.on("keydown.bs.carousel", t.proxy(this.keydown, this)), "hover" == this.options.pause && !("ontouchstart"in document.documentElement) && this.$element.on("mouseenter.bs.carousel", t.proxy(this.pause, this)).on("mouseleave.bs.carousel", t.proxy(this.cycle, this))
    };
    i.VERSION = "3.3.2", i.TRANSITION_DURATION = 600, i.DEFAULTS = {
        interval: 5e3,
        pause: "hover",
        wrap: !0,
        keyboard: !0
    }, i.prototype.keydown = function (t) {
        if (!/input|textarea/i.test(t.target.tagName)) {
            switch (t.which) {
                case 37:
                    this.prev();
                    break;
                case 39:
                    this.next();
                    break;
                default:
                    return
            }
            t.preventDefault()
        }
    }, i.prototype.cycle = function (e) {
        return e || (this.paused = !1), this.interval && clearInterval(this.interval), this.options.interval && !this.paused && (this.interval = setInterval(t.proxy(this.next, this), this.options.interval)), this
    }, i.prototype.getItemIndex = function (t) {
        return this.$items = t.parent().children(".item"), this.$items.index(t || this.$active)
    }, i.prototype.getItemForDirection = function (t, e) {
        var i = this.getItemIndex(e), o = "prev" == t && 0 === i || "next" == t && i == this.$items.length - 1;
        if (o && !this.options.wrap)return e;
        var n = "prev" == t ? -1 : 1, a = (i + n) % this.$items.length;
        return this.$items.eq(a)
    }, i.prototype.to = function (t) {
        var e = this, i = this.getItemIndex(this.$active = this.$element.find(".item.active"));
        return t > this.$items.length - 1 || 0 > t ? void 0 : this.sliding ? this.$element.one("slid.bs.carousel", function () {
            e.to(t)
        }) : i == t ? this.pause().cycle() : this.slide(t > i ? "next" : "prev", this.$items.eq(t))
    }, i.prototype.pause = function (e) {
        return e || (this.paused = !0), this.$element.find(".next, .prev").length && t.support.transition && (this.$element.trigger(t.support.transition.end), this.cycle(!0)), this.interval = clearInterval(this.interval), this
    }, i.prototype.next = function () {
        return this.sliding ? void 0 : this.slide("next")
    }, i.prototype.prev = function () {
        return this.sliding ? void 0 : this.slide("prev")
    }, i.prototype.slide = function (e, o) {
        var n = this.$element.find(".item.active"), a = o || this.getItemForDirection(e, n), s = this.interval, r = "next" == e ? "left" : "right", l = this;
        if (a.hasClass("active"))return this.sliding = !1;
        var c = a[0], h = t.Event("slide.bs.carousel", {relatedTarget: c, direction: r});
        if (this.$element.trigger(h), !h.isDefaultPrevented()) {
            if (this.sliding = !0, s && this.pause(), this.$indicators.length) {
                this.$indicators.find(".active").removeClass("active");
                var d = t(this.$indicators.children()[this.getItemIndex(a)]);
                d && d.addClass("active")
            }
            var p = t.Event("slid.bs.carousel", {relatedTarget: c, direction: r});
            return t.support.transition && this.$element.hasClass("slide") ? (a.addClass(e), a[0].offsetWidth, n.addClass(r), a.addClass(r), n.one("bsTransitionEnd", function () {
                a.removeClass([e, r].join(" ")).addClass("active"), n.removeClass(["active", r].join(" ")), l.sliding = !1, setTimeout(function () {
                    l.$element.trigger(p)
                }, 0)
            }).emulateTransitionEnd(i.TRANSITION_DURATION)) : (n.removeClass("active"), a.addClass("active"), this.sliding = !1, this.$element.trigger(p)), s && this.cycle(), this
        }
    };
    var o = t.fn.carousel;
    t.fn.carousel = e, t.fn.carousel.Constructor = i, t.fn.carousel.noConflict = function () {
        return t.fn.carousel = o, this
    };
    var n = function (i) {
        var o, n = t(this), a = t(n.attr("data-target") || (o = n.attr("href")) && o.replace(/.*(?=#[^\s]+$)/, ""));
        if (a.hasClass("carousel")) {
            var s = t.extend({}, a.data(), n.data()), r = n.attr("data-slide-to");
            r && (s.interval = !1), e.call(a, s), r && a.data("bs.carousel").to(r), i.preventDefault()
        }
    };
    t(document).on("click.bs.carousel.data-api", "[data-slide]", n).on("click.bs.carousel.data-api", "[data-slide-to]", n), t(window).on("load", function () {
        t('[data-ride="carousel"]').each(function () {
            var i = t(this);
            e.call(i, i.data())
        })
    })
}(jQuery), +function (t) {
    "use strict";
    function e(e) {
        var i, o = e.attr("data-target") || (i = e.attr("href")) && i.replace(/.*(?=#[^\s]+$)/, "");
        return t(o)
    }

    function i(e) {
        return this.each(function () {
            var i = t(this), n = i.data("bs.collapse"), a = t.extend({}, o.DEFAULTS, i.data(), "object" == typeof e && e);
            !n && a.toggle && "show" == e && (a.toggle = !1), n || i.data("bs.collapse", n = new o(this, a)), "string" == typeof e && n[e]()
        })
    }

    var o = function (e, i) {
        this.$element = t(e), this.options = t.extend({}, o.DEFAULTS, i), this.$trigger = t(this.options.trigger).filter('[href="#' + e.id + '"], [data-target="#' + e.id + '"]'), this.transitioning = null, this.options.parent ? this.$parent = this.getParent() : this.addAriaAndCollapsedClass(this.$element, this.$trigger), this.options.toggle && this.toggle()
    };
    o.VERSION = "3.3.2", o.TRANSITION_DURATION = 350, o.DEFAULTS = {
        toggle: !0,
        trigger: '[data-toggle="collapse"]'
    }, o.prototype.dimension = function () {
        var t = this.$element.hasClass("width");
        return t ? "width" : "height"
    }, o.prototype.show = function () {
        if (!this.transitioning && !this.$element.hasClass("in")) {
            var e, n = this.$parent && this.$parent.children(".panel").children(".in, .collapsing");
            if (!(n && n.length && (e = n.data("bs.collapse"), e && e.transitioning))) {
                var a = t.Event("show.bs.collapse");
                if (this.$element.trigger(a), !a.isDefaultPrevented()) {
                    n && n.length && (i.call(n, "hide"), e || n.data("bs.collapse", null));
                    var s = this.dimension();
                    this.$element.removeClass("collapse").addClass("collapsing")[s](0).attr("aria-expanded", !0), this.$trigger.removeClass("collapsed").attr("aria-expanded", !0), this.transitioning = 1;
                    var r = function () {
                        this.$element.removeClass("collapsing").addClass("collapse in")[s](""), this.transitioning = 0, this.$element.trigger("shown.bs.collapse")
                    };
                    if (!t.support.transition)return r.call(this);
                    var l = t.camelCase(["scroll", s].join("-"));
                    this.$element.one("bsTransitionEnd", t.proxy(r, this)).emulateTransitionEnd(o.TRANSITION_DURATION)[s](this.$element[0][l])
                }
            }
        }
    }, o.prototype.hide = function () {
        if (!this.transitioning && this.$element.hasClass("in")) {
            var e = t.Event("hide.bs.collapse");
            if (this.$element.trigger(e), !e.isDefaultPrevented()) {
                var i = this.dimension();
                this.$element[i](this.$element[i]())[0].offsetHeight, this.$element.addClass("collapsing").removeClass("collapse in").attr("aria-expanded", !1), this.$trigger.addClass("collapsed").attr("aria-expanded", !1), this.transitioning = 1;
                var n = function () {
                    this.transitioning = 0, this.$element.removeClass("collapsing").addClass("collapse").trigger("hidden.bs.collapse")
                };
                return t.support.transition ? void this.$element[i](0).one("bsTransitionEnd", t.proxy(n, this)).emulateTransitionEnd(o.TRANSITION_DURATION) : n.call(this)
            }
        }
    }, o.prototype.toggle = function () {
        this[this.$element.hasClass("in") ? "hide" : "show"]()
    }, o.prototype.getParent = function () {
        return t(this.options.parent).find('[data-toggle="collapse"][data-parent="' + this.options.parent + '"]').each(t.proxy(function (i, o) {
            var n = t(o);
            this.addAriaAndCollapsedClass(e(n), n)
        }, this)).end()
    }, o.prototype.addAriaAndCollapsedClass = function (t, e) {
        var i = t.hasClass("in");
        t.attr("aria-expanded", i), e.toggleClass("collapsed", !i).attr("aria-expanded", i)
    };
    var n = t.fn.collapse;
    t.fn.collapse = i, t.fn.collapse.Constructor = o, t.fn.collapse.noConflict = function () {
        return t.fn.collapse = n, this
    }, t(document).on("click.bs.collapse.data-api", '[data-toggle="collapse"]', function (o) {
        var n = t(this);
        n.attr("data-target") || o.preventDefault();
        var a = e(n), s = a.data("bs.collapse"), r = s ? "toggle" : t.extend({}, n.data(), {trigger: this});
        i.call(a, r)
    })
}(jQuery), +function (t) {
    "use strict";
    function e(e) {
        e && 3 === e.which || (t(n).remove(), t(a).each(function () {
            var o = t(this), n = i(o), a = {relatedTarget: this};
            n.hasClass("open") && (n.trigger(e = t.Event("hide.bs.dropdown", a)), e.isDefaultPrevented() || (o.attr("aria-expanded", "false"), n.removeClass("open").trigger("hidden.bs.dropdown", a)))
        }))
    }

    function i(e) {
        var i = e.attr("data-target");
        i || (i = e.attr("href"), i = i && /#[A-Za-z]/.test(i) && i.replace(/.*(?=#[^\s]*$)/, ""));
        var o = i && t(i);
        return o && o.length ? o : e.parent()
    }

    function o(e) {
        return this.each(function () {
            var i = t(this), o = i.data("bs.dropdown");
            o || i.data("bs.dropdown", o = new s(this)), "string" == typeof e && o[e].call(i)
        })
    }

    var n = ".dropdown-backdrop", a = '[data-toggle="dropdown"]', s = function (e) {
        t(e).on("click.bs.dropdown", this.toggle)
    };
    s.VERSION = "3.3.2", s.prototype.toggle = function (o) {
        var n = t(this);
        if (!n.is(".disabled, :disabled")) {
            var a = i(n), s = a.hasClass("open");
            if (e(), !s) {
                "ontouchstart"in document.documentElement && !a.closest(".navbar-nav").length && t('<div class="dropdown-backdrop"/>').insertAfter(t(this)).on("click", e);
                var r = {relatedTarget: this};
                if (a.trigger(o = t.Event("show.bs.dropdown", r)), o.isDefaultPrevented())return;
                n.trigger("focus").attr("aria-expanded", "true"), a.toggleClass("open").trigger("shown.bs.dropdown", r)
            }
            return !1
        }
    }, s.prototype.keydown = function (e) {
        if (/(38|40|27|32)/.test(e.which) && !/input|textarea/i.test(e.target.tagName)) {
            var o = t(this);
            if (e.preventDefault(), e.stopPropagation(), !o.is(".disabled, :disabled")) {
                var n = i(o), s = n.hasClass("open");
                if (!s && 27 != e.which || s && 27 == e.which)return 27 == e.which && n.find(a).trigger("focus"), o.trigger("click");
                var r = " li:not(.divider):visible a", l = n.find('[role="menu"]' + r + ', [role="listbox"]' + r);
                if (l.length) {
                    var c = l.index(e.target);
                    38 == e.which && c > 0 && c--, 40 == e.which && c < l.length - 1 && c++, ~c || (c = 0), l.eq(c).trigger("focus")
                }
            }
        }
    };
    var r = t.fn.dropdown;
    t.fn.dropdown = o, t.fn.dropdown.Constructor = s, t.fn.dropdown.noConflict = function () {
        return t.fn.dropdown = r, this
    }, t(document).on("click.bs.dropdown.data-api", e).on("click.bs.dropdown.data-api", ".dropdown form", function (t) {
        t.stopPropagation()
    }).on("click.bs.dropdown.data-api", a, s.prototype.toggle).on("keydown.bs.dropdown.data-api", a, s.prototype.keydown).on("keydown.bs.dropdown.data-api", '[role="menu"]', s.prototype.keydown).on("keydown.bs.dropdown.data-api", '[role="listbox"]', s.prototype.keydown)
}(jQuery), +function (t) {
    "use strict";
    function e(e, o) {
        return this.each(function () {
            var n = t(this), a = n.data("bs.modal"), s = t.extend({}, i.DEFAULTS, n.data(), "object" == typeof e && e);
            a || n.data("bs.modal", a = new i(this, s)), "string" == typeof e ? a[e](o) : s.show && a.show(o)
        })
    }

    var i = function (e, i) {
        this.options = i, this.$body = t(document.body), this.$element = t(e), this.$backdrop = this.isShown = null, this.scrollbarWidth = 0, this.options.remote && this.$element.find(".modal-content").load(this.options.remote, t.proxy(function () {
            this.$element.trigger("loaded.bs.modal")
        }, this))
    };
    i.VERSION = "3.3.2", i.TRANSITION_DURATION = 300, i.BACKDROP_TRANSITION_DURATION = 150, i.DEFAULTS = {
        backdrop: !0,
        keyboard: !0,
        show: !0
    }, i.prototype.toggle = function (t) {
        return this.isShown ? this.hide() : this.show(t)
    }, i.prototype.show = function (e) {
        var o = this, n = t.Event("show.bs.modal", {relatedTarget: e});
        this.$element.trigger(n), this.isShown || n.isDefaultPrevented() || (this.isShown = !0, this.checkScrollbar(), this.setScrollbar(), this.$body.addClass("modal-open"), this.escape(), this.resize(), this.$element.on("click.dismiss.bs.modal", '[data-dismiss="modal"]', t.proxy(this.hide, this)), this.backdrop(function () {
            var n = t.support.transition && o.$element.hasClass("fade");
            o.$element.parent().length || o.$element.appendTo(o.$body), o.$element.show().scrollTop(0), o.options.backdrop && o.adjustBackdrop(), o.adjustDialog(), n && o.$element[0].offsetWidth, o.$element.addClass("in").attr("aria-hidden", !1), o.enforceFocus();
            var a = t.Event("shown.bs.modal", {relatedTarget: e});
            n ? o.$element.find(".modal-dialog").one("bsTransitionEnd", function () {
                o.$element.trigger("focus").trigger(a)
            }).emulateTransitionEnd(i.TRANSITION_DURATION) : o.$element.trigger("focus").trigger(a)
        }))
    }, i.prototype.hide = function (e) {
        e && e.preventDefault(), e = t.Event("hide.bs.modal"), this.$element.trigger(e), this.isShown && !e.isDefaultPrevented() && (this.isShown = !1, this.escape(), this.resize(), t(document).off("focusin.bs.modal"), this.$element.removeClass("in").attr("aria-hidden", !0).off("click.dismiss.bs.modal"), t.support.transition && this.$element.hasClass("fade") ? this.$element.one("bsTransitionEnd", t.proxy(this.hideModal, this)).emulateTransitionEnd(i.TRANSITION_DURATION) : this.hideModal())
    }, i.prototype.enforceFocus = function () {
        t(document).off("focusin.bs.modal").on("focusin.bs.modal", t.proxy(function (t) {
            this.$element[0] === t.target || this.$element.has(t.target).length || this.$element.trigger("focus")
        }, this))
    }, i.prototype.escape = function () {
        this.isShown && this.options.keyboard ? this.$element.on("keydown.dismiss.bs.modal", t.proxy(function (t) {
            27 == t.which && this.hide()
        }, this)) : this.isShown || this.$element.off("keydown.dismiss.bs.modal")
    }, i.prototype.resize = function () {
        this.isShown ? t(window).on("resize.bs.modal", t.proxy(this.handleUpdate, this)) : t(window).off("resize.bs.modal")
    }, i.prototype.hideModal = function () {
        var t = this;
        this.$element.hide(), this.backdrop(function () {
            t.$body.removeClass("modal-open"), t.resetAdjustments(), t.resetScrollbar(), t.$element.trigger("hidden.bs.modal")
        })
    }, i.prototype.removeBackdrop = function () {
        this.$backdrop && this.$backdrop.remove(), this.$backdrop = null
    }, i.prototype.backdrop = function (e) {
        var o = this, n = this.$element.hasClass("fade") ? "fade" : "";
        if (this.isShown && this.options.backdrop) {
            var a = t.support.transition && n;
            if (this.$backdrop = t('<div class="modal-backdrop ' + n + '" />').prependTo(this.$element).on("click.dismiss.bs.modal", t.proxy(function (t) {
                    t.target === t.currentTarget && ("static" == this.options.backdrop ? this.$element[0].focus.call(this.$element[0]) : this.hide.call(this))
                }, this)), a && this.$backdrop[0].offsetWidth, this.$backdrop.addClass("in"), !e)return;
            a ? this.$backdrop.one("bsTransitionEnd", e).emulateTransitionEnd(i.BACKDROP_TRANSITION_DURATION) : e()
        } else if (!this.isShown && this.$backdrop) {
            this.$backdrop.removeClass("in");
            var s = function () {
                o.removeBackdrop(), e && e()
            };
            t.support.transition && this.$element.hasClass("fade") ? this.$backdrop.one("bsTransitionEnd", s).emulateTransitionEnd(i.BACKDROP_TRANSITION_DURATION) : s()
        } else e && e()
    }, i.prototype.handleUpdate = function () {
        this.options.backdrop && this.adjustBackdrop(), this.adjustDialog()
    }, i.prototype.adjustBackdrop = function () {
        this.$backdrop.css("height", 0).css("height", this.$element[0].scrollHeight)
    }, i.prototype.adjustDialog = function () {
        var t = this.$element[0].scrollHeight > document.documentElement.clientHeight;
        this.$element.css({
            paddingLeft: !this.bodyIsOverflowing && t ? this.scrollbarWidth : "",
            paddingRight: this.bodyIsOverflowing && !t ? this.scrollbarWidth : ""
        })
    }, i.prototype.resetAdjustments = function () {
        this.$element.css({paddingLeft: "", paddingRight: ""})
    }, i.prototype.checkScrollbar = function () {
        this.bodyIsOverflowing = document.body.scrollHeight > document.documentElement.clientHeight, this.scrollbarWidth = this.measureScrollbar()
    }, i.prototype.setScrollbar = function () {
        var t = parseInt(this.$body.css("padding-right") || 0, 10);
        this.bodyIsOverflowing && this.$body.css("padding-right", t + this.scrollbarWidth)
    }, i.prototype.resetScrollbar = function () {
        this.$body.css("padding-right", "")
    }, i.prototype.measureScrollbar = function () {
        var t = document.createElement("div");
        t.className = "modal-scrollbar-measure", this.$body.append(t);
        var e = t.offsetWidth - t.clientWidth;
        return this.$body[0].removeChild(t), e
    };
    var o = t.fn.modal;
    t.fn.modal = e, t.fn.modal.Constructor = i, t.fn.modal.noConflict = function () {
        return t.fn.modal = o, this
    }, t(document).on("click.bs.modal.data-api", '[data-toggle="modal"]', function (i) {
        var o = t(this), n = o.attr("href"), a = t(o.attr("data-target") || n && n.replace(/.*(?=#[^\s]+$)/, "")), s = a.data("bs.modal") ? "toggle" : t.extend({remote: !/#/.test(n) && n}, a.data(), o.data());
        o.is("a") && i.preventDefault(), a.one("show.bs.modal", function (t) {
            t.isDefaultPrevented() || a.one("hidden.bs.modal", function () {
                o.is(":visible") && o.trigger("focus")
            })
        }), e.call(a, s, this)
    })
}(jQuery), +function (t) {
    "use strict";
    function e(e) {
        return this.each(function () {
            var o = t(this), n = o.data("bs.tooltip"), a = "object" == typeof e && e;
            (n || "destroy" != e) && (n || o.data("bs.tooltip", n = new i(this, a)), "string" == typeof e && n[e]())
        })
    }

    var i = function (t, e) {
        this.type = this.options = this.enabled = this.timeout = this.hoverState = this.$element = null, this.init("tooltip", t, e)
    };
    i.VERSION = "3.3.2", i.TRANSITION_DURATION = 150, i.DEFAULTS = {
        animation: !0,
        placement: "top",
        selector: !1,
        template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',
        trigger: "hover focus",
        title: "",
        delay: 0,
        html: !1,
        container: !1,
        viewport: {selector: "body", padding: 0}
    }, i.prototype.init = function (e, i, o) {
        this.enabled = !0, this.type = e, this.$element = t(i), this.options = this.getOptions(o), this.$viewport = this.options.viewport && t(this.options.viewport.selector || this.options.viewport);
        for (var n = this.options.trigger.split(" "), a = n.length; a--;) {
            var s = n[a];
            if ("click" == s)this.$element.on("click." + this.type, this.options.selector, t.proxy(this.toggle, this)); else if ("manual" != s) {
                var r = "hover" == s ? "mouseenter" : "focusin", l = "hover" == s ? "mouseleave" : "focusout";
                this.$element.on(r + "." + this.type, this.options.selector, t.proxy(this.enter, this)), this.$element.on(l + "." + this.type, this.options.selector, t.proxy(this.leave, this))
            }
        }
        this.options.selector ? this._options = t.extend({}, this.options, {
            trigger: "manual",
            selector: ""
        }) : this.fixTitle()
    }, i.prototype.getDefaults = function () {
        return i.DEFAULTS
    }, i.prototype.getOptions = function (e) {
        return e = t.extend({}, this.getDefaults(), this.$element.data(), e), e.delay && "number" == typeof e.delay && (e.delay = {
            show: e.delay,
            hide: e.delay
        }), e
    }, i.prototype.getDelegateOptions = function () {
        var e = {}, i = this.getDefaults();
        return this._options && t.each(this._options, function (t, o) {
            i[t] != o && (e[t] = o)
        }), e
    }, i.prototype.enter = function (e) {
        var i = e instanceof this.constructor ? e : t(e.currentTarget).data("bs." + this.type);
        return i && i.$tip && i.$tip.is(":visible") ? void(i.hoverState = "in") : (i || (i = new this.constructor(e.currentTarget, this.getDelegateOptions()), t(e.currentTarget).data("bs." + this.type, i)), clearTimeout(i.timeout), i.hoverState = "in", i.options.delay && i.options.delay.show ? void(i.timeout = setTimeout(function () {
            "in" == i.hoverState && i.show()
        }, i.options.delay.show)) : i.show())
    }, i.prototype.leave = function (e) {
        var i = e instanceof this.constructor ? e : t(e.currentTarget).data("bs." + this.type);
        return i || (i = new this.constructor(e.currentTarget, this.getDelegateOptions()), t(e.currentTarget).data("bs." + this.type, i)), clearTimeout(i.timeout), i.hoverState = "out", i.options.delay && i.options.delay.hide ? void(i.timeout = setTimeout(function () {
            "out" == i.hoverState && i.hide()
        }, i.options.delay.hide)) : i.hide()
    }, i.prototype.show = function () {
        var e = t.Event("show.bs." + this.type);
        if (this.hasContent() && this.enabled) {
            this.$element.trigger(e);
            var o = t.contains(this.$element[0].ownerDocument.documentElement, this.$element[0]);
            if (e.isDefaultPrevented() || !o)return;
            var n = this, a = this.tip(), s = this.getUID(this.type);
            this.setContent(), a.attr("id", s), this.$element.attr("aria-describedby", s), this.options.animation && a.addClass("fade");
            var r = "function" == typeof this.options.placement ? this.options.placement.call(this, a[0], this.$element[0]) : this.options.placement, l = /\s?auto?\s?/i, c = l.test(r);
            c && (r = r.replace(l, "") || "top"), a.detach().css({
                top: 0,
                left: 0,
                display: "block"
            }).addClass(r).data("bs." + this.type, this), this.options.container ? a.appendTo(this.options.container) : a.insertAfter(this.$element);
            var h = this.getPosition(), d = a[0].offsetWidth, p = a[0].offsetHeight;
            if (c) {
                var f = r, u = this.options.container ? t(this.options.container) : this.$element.parent(), g = this.getPosition(u);
                r = "bottom" == r && h.bottom + p > g.bottom ? "top" : "top" == r && h.top - p < g.top ? "bottom" : "right" == r && h.right + d > g.width ? "left" : "left" == r && h.left - d < g.left ? "right" : r, a.removeClass(f).addClass(r)
            }
            var m = this.getCalculatedOffset(r, h, d, p);
            this.applyPlacement(m, r);
            var v = function () {
                var t = n.hoverState;
                n.$element.trigger("shown.bs." + n.type), n.hoverState = null, "out" == t && n.leave(n)
            };
            t.support.transition && this.$tip.hasClass("fade") ? a.one("bsTransitionEnd", v).emulateTransitionEnd(i.TRANSITION_DURATION) : v()
        }
    }, i.prototype.applyPlacement = function (e, i) {
        var o = this.tip(), n = o[0].offsetWidth, a = o[0].offsetHeight, s = parseInt(o.css("margin-top"), 10), r = parseInt(o.css("margin-left"), 10);
        isNaN(s) && (s = 0), isNaN(r) && (r = 0), e.top = e.top + s, e.left = e.left + r, t.offset.setOffset(o[0], t.extend({
            using: function (t) {
                o.css({top: Math.round(t.top), left: Math.round(t.left)})
            }
        }, e), 0), o.addClass("in");
        var l = o[0].offsetWidth, c = o[0].offsetHeight;
        "top" == i && c != a && (e.top = e.top + a - c);
        var h = this.getViewportAdjustedDelta(i, e, l, c);
        h.left ? e.left += h.left : e.top += h.top;
        var d = /top|bottom/.test(i), p = d ? 2 * h.left - n + l : 2 * h.top - a + c, f = d ? "offsetWidth" : "offsetHeight";
        o.offset(e), this.replaceArrow(p, o[0][f], d)
    }, i.prototype.replaceArrow = function (t, e, i) {
        this.arrow().css(i ? "left" : "top", 50 * (1 - t / e) + "%").css(i ? "top" : "left", "")
    }, i.prototype.setContent = function () {
        var t = this.tip(), e = this.getTitle();
        t.find(".tooltip-inner")[this.options.html ? "html" : "text"](e), t.removeClass("fade in top bottom left right")
    }, i.prototype.hide = function (e) {
        function o() {
            "in" != n.hoverState && a.detach(), n.$element.removeAttr("aria-describedby").trigger("hidden.bs." + n.type), e && e()
        }

        var n = this, a = this.tip(), s = t.Event("hide.bs." + this.type);
        return this.$element.trigger(s), s.isDefaultPrevented() ? void 0 : (a.removeClass("in"), t.support.transition && this.$tip.hasClass("fade") ? a.one("bsTransitionEnd", o).emulateTransitionEnd(i.TRANSITION_DURATION) : o(), this.hoverState = null, this)
    }, i.prototype.fixTitle = function () {
        var t = this.$element;
        (t.attr("title") || "string" != typeof t.attr("data-original-title")) && t.attr("data-original-title", t.attr("title") || "").attr("title", "")
    }, i.prototype.hasContent = function () {
        return this.getTitle()
    }, i.prototype.getPosition = function (e) {
        e = e || this.$element;
        var i = e[0], o = "BODY" == i.tagName, n = i.getBoundingClientRect();
        null == n.width && (n = t.extend({}, n, {width: n.right - n.left, height: n.bottom - n.top}));
        var a = o ? {
            top: 0,
            left: 0
        } : e.offset(), s = {scroll: o ? document.documentElement.scrollTop || document.body.scrollTop : e.scrollTop()}, r = o ? {
            width: t(window).width(),
            height: t(window).height()
        } : null;
        return t.extend({}, n, s, r, a)
    }, i.prototype.getCalculatedOffset = function (t, e, i, o) {
        return "bottom" == t ? {
            top: e.top + e.height,
            left: e.left + e.width / 2 - i / 2
        } : "top" == t ? {
            top: e.top - o,
            left: e.left + e.width / 2 - i / 2
        } : "left" == t ? {top: e.top + e.height / 2 - o / 2, left: e.left - i} : {
            top: e.top + e.height / 2 - o / 2,
            left: e.left + e.width
        }
    }, i.prototype.getViewportAdjustedDelta = function (t, e, i, o) {
        var n = {top: 0, left: 0};
        if (!this.$viewport)return n;
        var a = this.options.viewport && this.options.viewport.padding || 0, s = this.getPosition(this.$viewport);
        if (/right|left/.test(t)) {
            var r = e.top - a - s.scroll, l = e.top + a - s.scroll + o;
            r < s.top ? n.top = s.top - r : l > s.top + s.height && (n.top = s.top + s.height - l)
        } else {
            var c = e.left - a, h = e.left + a + i;
            c < s.left ? n.left = s.left - c : h > s.width && (n.left = s.left + s.width - h)
        }
        return n
    }, i.prototype.getTitle = function () {
        var t, e = this.$element, i = this.options;
        return t = e.attr("data-original-title") || ("function" == typeof i.title ? i.title.call(e[0]) : i.title)
    }, i.prototype.getUID = function (t) {
        do t += ~~(1e6 * Math.random()); while (document.getElementById(t));
        return t
    }, i.prototype.tip = function () {
        return this.$tip = this.$tip || t(this.options.template)
    }, i.prototype.arrow = function () {
        return this.$arrow = this.$arrow || this.tip().find(".tooltip-arrow")
    }, i.prototype.enable = function () {
        this.enabled = !0
    }, i.prototype.disable = function () {
        this.enabled = !1
    }, i.prototype.toggleEnabled = function () {
        this.enabled = !this.enabled
    }, i.prototype.toggle = function (e) {
        var i = this;
        e && (i = t(e.currentTarget).data("bs." + this.type), i || (i = new this.constructor(e.currentTarget, this.getDelegateOptions()), t(e.currentTarget).data("bs." + this.type, i))), i.tip().hasClass("in") ? i.leave(i) : i.enter(i)
    }, i.prototype.destroy = function () {
        var t = this;
        clearTimeout(this.timeout), this.hide(function () {
            t.$element.off("." + t.type).removeData("bs." + t.type)
        })
    };
    var o = t.fn.tooltip;
    t.fn.tooltip = e, t.fn.tooltip.Constructor = i, t.fn.tooltip.noConflict = function () {
        return t.fn.tooltip = o, this
    }
}(jQuery), +function (t) {
    "use strict";
    function e(e) {
        return this.each(function () {
            var o = t(this), n = o.data("bs.popover"), a = "object" == typeof e && e;
            (n || "destroy" != e) && (n || o.data("bs.popover", n = new i(this, a)), "string" == typeof e && n[e]())
        })
    }

    var i = function (t, e) {
        this.init("popover", t, e)
    };
    if (!t.fn.tooltip)throw new Error("Popover requires tooltip.js");
    i.VERSION = "3.3.2", i.DEFAULTS = t.extend({}, t.fn.tooltip.Constructor.DEFAULTS, {
        placement: "right",
        trigger: "click",
        content: "",
        template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
    }), i.prototype = t.extend({}, t.fn.tooltip.Constructor.prototype), i.prototype.constructor = i, i.prototype.getDefaults = function () {
        return i.DEFAULTS
    }, i.prototype.setContent = function () {
        var t = this.tip(), e = this.getTitle(), i = this.getContent();
        t.find(".popover-title")[this.options.html ? "html" : "text"](e), t.find(".popover-content").children().detach().end()[this.options.html ? "string" == typeof i ? "html" : "append" : "text"](i), t.removeClass("fade top bottom left right in"), t.find(".popover-title").html() || t.find(".popover-title").hide()
    }, i.prototype.hasContent = function () {
        return this.getTitle() || this.getContent()
    }, i.prototype.getContent = function () {
        var t = this.$element, e = this.options;
        return t.attr("data-content") || ("function" == typeof e.content ? e.content.call(t[0]) : e.content)
    }, i.prototype.arrow = function () {
        return this.$arrow = this.$arrow || this.tip().find(".arrow")
    }, i.prototype.tip = function () {
        return this.$tip || (this.$tip = t(this.options.template)), this.$tip
    };
    var o = t.fn.popover;
    t.fn.popover = e, t.fn.popover.Constructor = i, t.fn.popover.noConflict = function () {
        return t.fn.popover = o, this
    }
}(jQuery), +function (t) {
    "use strict";
    function e(i, o) {
        var n = t.proxy(this.process, this);
        this.$body = t("body"), this.$scrollElement = t(t(i).is("body") ? window : i), this.options = t.extend({}, e.DEFAULTS, o), this.selector = (this.options.target || "") + " .nav li > a", this.offsets = [], this.targets = [], this.activeTarget = null, this.scrollHeight = 0, this.$scrollElement.on("scroll.bs.scrollspy", n), this.refresh(), this.process()
    }

    function i(i) {
        return this.each(function () {
            var o = t(this), n = o.data("bs.scrollspy"), a = "object" == typeof i && i;
            n || o.data("bs.scrollspy", n = new e(this, a)), "string" == typeof i && n[i]()
        })
    }

    e.VERSION = "3.3.2", e.DEFAULTS = {offset: 10}, e.prototype.getScrollHeight = function () {
        return this.$scrollElement[0].scrollHeight || Math.max(this.$body[0].scrollHeight, document.documentElement.scrollHeight)
    }, e.prototype.refresh = function () {
        var e = "offset", i = 0;
        t.isWindow(this.$scrollElement[0]) || (e = "position", i = this.$scrollElement.scrollTop()), this.offsets = [], this.targets = [], this.scrollHeight = this.getScrollHeight();
        var o = this;
        this.$body.find(this.selector).map(function () {
            var o = t(this), n = o.data("target") || o.attr("href"), a = /^#./.test(n) && t(n);
            return a && a.length && a.is(":visible") && [[a[e]().top + i, n]] || null
        }).sort(function (t, e) {
            return t[0] - e[0]
        }).each(function () {
            o.offsets.push(this[0]), o.targets.push(this[1])
        })
    }, e.prototype.process = function () {
        var t, e = this.$scrollElement.scrollTop() + this.options.offset, i = this.getScrollHeight(), o = this.options.offset + i - this.$scrollElement.height(), n = this.offsets, a = this.targets, s = this.activeTarget;
        if (this.scrollHeight != i && this.refresh(), e >= o)return s != (t = a[a.length - 1]) && this.activate(t);
        if (s && e < n[0])return this.activeTarget = null, this.clear();
        for (t = n.length; t--;)s != a[t] && e >= n[t] && (!n[t + 1] || e <= n[t + 1]) && this.activate(a[t])
    }, e.prototype.activate = function (e) {
        this.activeTarget = e, this.clear();
        var i = this.selector + '[data-target="' + e + '"],' + this.selector + '[href="' + e + '"]', o = t(i).parents("li").addClass("active");
        o.parent(".dropdown-menu").length && (o = o.closest("li.dropdown").addClass("active")), o.trigger("activate.bs.scrollspy")
    }, e.prototype.clear = function () {
        t(this.selector).parentsUntil(this.options.target, ".active").removeClass("active")
    };
    var o = t.fn.scrollspy;
    t.fn.scrollspy = i, t.fn.scrollspy.Constructor = e, t.fn.scrollspy.noConflict = function () {
        return t.fn.scrollspy = o, this
    }, t(window).on("load.bs.scrollspy.data-api", function () {
        t('[data-spy="scroll"]').each(function () {
            var e = t(this);
            i.call(e, e.data())
        })
    })
}(jQuery), +function (t) {
    "use strict";
    function e(e) {
        return this.each(function () {
            var o = t(this), n = o.data("bs.tab");
            n || o.data("bs.tab", n = new i(this)), "string" == typeof e && n[e]()
        })
    }

    var i = function (e) {
        this.element = t(e)
    };
    i.VERSION = "3.3.2", i.TRANSITION_DURATION = 150, i.prototype.show = function () {
        var e = this.element, i = e.closest("ul:not(.dropdown-menu)"), o = e.data("target");
        if (o || (o = e.attr("href"), o = o && o.replace(/.*(?=#[^\s]*$)/, "")), !e.parent("li").hasClass("active")) {
            var n = i.find(".active:last a"), a = t.Event("hide.bs.tab", {relatedTarget: e[0]}), s = t.Event("show.bs.tab", {relatedTarget: n[0]});
            if (n.trigger(a), e.trigger(s), !s.isDefaultPrevented() && !a.isDefaultPrevented()) {
                var r = t(o);
                this.activate(e.closest("li"), i), this.activate(r, r.parent(), function () {
                    n.trigger({type: "hidden.bs.tab", relatedTarget: e[0]}), e.trigger({
                        type: "shown.bs.tab",
                        relatedTarget: n[0]
                    })
                })
            }
        }
    }, i.prototype.activate = function (e, o, n) {
        function a() {
            s.removeClass("active").find("> .dropdown-menu > .active").removeClass("active").end().find('[data-toggle="tab"]').attr("aria-expanded", !1), e.addClass("active").find('[data-toggle="tab"]').attr("aria-expanded", !0), r ? (e[0].offsetWidth, e.addClass("in")) : e.removeClass("fade"), e.parent(".dropdown-menu") && e.closest("li.dropdown").addClass("active").end().find('[data-toggle="tab"]').attr("aria-expanded", !0), n && n()
        }

        var s = o.find("> .active"), r = n && t.support.transition && (s.length && s.hasClass("fade") || !!o.find("> .fade").length);
        s.length && r ? s.one("bsTransitionEnd", a).emulateTransitionEnd(i.TRANSITION_DURATION) : a(), s.removeClass("in")
    };
    var o = t.fn.tab;
    t.fn.tab = e, t.fn.tab.Constructor = i, t.fn.tab.noConflict = function () {
        return t.fn.tab = o, this
    };
    var n = function (i) {
        i.preventDefault(), e.call(t(this), "show")
    };
    t(document).on("click.bs.tab.data-api", '[data-toggle="tab"]', n).on("click.bs.tab.data-api", '[data-toggle="pill"]', n)
}(jQuery), +function (t) {
    "use strict";
    function e(e) {
        return this.each(function () {
            var o = t(this), n = o.data("bs.affix"), a = "object" == typeof e && e;
            n || o.data("bs.affix", n = new i(this, a)), "string" == typeof e && n[e]()
        })
    }

    var i = function (e, o) {
        this.options = t.extend({}, i.DEFAULTS, o), this.$target = t(this.options.target).on("scroll.bs.affix.data-api", t.proxy(this.checkPosition, this)).on("click.bs.affix.data-api", t.proxy(this.checkPositionWithEventLoop, this)), this.$element = t(e), this.affixed = this.unpin = this.pinnedOffset = null, this.checkPosition()
    };
    i.VERSION = "3.3.2", i.RESET = "affix affix-top affix-bottom", i.DEFAULTS = {
        offset: 0,
        target: window
    }, i.prototype.getState = function (t, e, i, o) {
        var n = this.$target.scrollTop(), a = this.$element.offset(), s = this.$target.height();
        if (null != i && "top" == this.affixed)return i > n ? "top" : !1;
        if ("bottom" == this.affixed)return null != i ? n + this.unpin <= a.top ? !1 : "bottom" : t - o >= n + s ? !1 : "bottom";
        var r = null == this.affixed, l = r ? n : a.top, c = r ? s : e;
        return null != i && i >= n ? "top" : null != o && l + c >= t - o ? "bottom" : !1
    }, i.prototype.getPinnedOffset = function () {
        if (this.pinnedOffset)return this.pinnedOffset;
        this.$element.removeClass(i.RESET).addClass("affix");
        var t = this.$target.scrollTop(), e = this.$element.offset();
        return this.pinnedOffset = e.top - t
    }, i.prototype.checkPositionWithEventLoop = function () {
        setTimeout(t.proxy(this.checkPosition, this), 1)
    }, i.prototype.checkPosition = function () {
        if (this.$element.is(":visible")) {
            var e = this.$element.height(), o = this.options.offset, n = o.top, a = o.bottom, s = t("body").height();
            "object" != typeof o && (a = n = o), "function" == typeof n && (n = o.top(this.$element)), "function" == typeof a && (a = o.bottom(this.$element));
            var r = this.getState(s, e, n, a);
            if (this.affixed != r) {
                null != this.unpin && this.$element.css("top", "");
                var l = "affix" + (r ? "-" + r : ""), c = t.Event(l + ".bs.affix");
                if (this.$element.trigger(c), c.isDefaultPrevented())return;
                this.affixed = r, this.unpin = "bottom" == r ? this.getPinnedOffset() : null, this.$element.removeClass(i.RESET).addClass(l).trigger(l.replace("affix", "affixed") + ".bs.affix")
            }
            "bottom" == r && this.$element.offset({top: s - e - a})
        }
    };
    var o = t.fn.affix;
    t.fn.affix = e, t.fn.affix.Constructor = i, t.fn.affix.noConflict = function () {
        return t.fn.affix = o, this
    }, t(window).on("load", function () {
        t('[data-spy="affix"]').each(function () {
            var i = t(this), o = i.data();
            o.offset = o.offset || {}, null != o.offsetBottom && (o.offset.bottom = o.offsetBottom), null != o.offsetTop && (o.offset.top = o.offsetTop), e.call(i, o)
        })
    })
}(jQuery), function (t, e, i, o) {
    var n = i("html"), a = i(t), s = i(e), r = i.fancybox = function () {
        r.open.apply(this, arguments)
    }, l = navigator.userAgent.match(/msie/i), c = null, h = e.createTouch !== o, d = function (t) {
        return t && t.hasOwnProperty && t instanceof i
    }, p = function (t) {
        return t && "string" === i.type(t)
    }, f = function (t) {
        return p(t) && 0 < t.indexOf("%")
    }, u = function (t, e) {
        var i = parseInt(t, 10) || 0;
        return e && f(t) && (i *= r.getViewport()[e] / 100), Math.ceil(i)
    }, g = function (t, e) {
        return u(t, e) + "px"
    };
    i.extend(r, {
        version: "2.1.5",
        defaults: {
            padding: 15,
            margin: 20,
            width: 800,
            height: 600,
            minWidth: 100,
            minHeight: 100,
            maxWidth: 9999,
            maxHeight: 9999,
            pixelRatio: 1,
            autoSize: !0,
            autoHeight: !1,
            autoWidth: !1,
            autoResize: !0,
            autoCenter: !h,
            fitToView: !0,
            aspectRatio: !1,
            topRatio: .5,
            leftRatio: .5,
            scrolling: "auto",
            wrapCSS: "",
            arrows: !0,
            closeBtn: !0,
            closeClick: !1,
            nextClick: !1,
            mouseWheel: !0,
            autoPlay: !1,
            playSpeed: 3e3,
            preload: 3,
            modal: !1,
            loop: !0,
            ajax: {dataType: "html", headers: {"X-fancyBox": !0}},
            iframe: {scrolling: "auto", preload: !0},
            swf: {wmode: "transparent", allowfullscreen: "true", allowscriptaccess: "always"},
            keys: {
                next: {13: "left", 34: "up", 39: "left", 40: "up"},
                prev: {8: "right", 33: "down", 37: "right", 38: "down"},
                close: [27],
                play: [32],
                toggle: [70]
            },
            direction: {next: "left", prev: "right"},
            scrollOutside: !0,
            index: 0,
            type: null,
            href: null,
            content: null,
            title: null,
            tpl: {
                wrap: '<div class="fancybox-wrap" tabIndex="-1"><div class="fancybox-skin"><div class="fancybox-outer"><div class="fancybox-inner"></div></div></div></div>',
                image: '<img class="fancybox-image" src="{href}" alt="" />',
                iframe: '<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" frameborder="0" vspace="0" hspace="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen' + (l ? ' allowtransparency="true"' : "") + "></iframe>",
                error: '<p class="fancybox-error">The requested content cannot be loaded.<br/>Please try again later.</p>',
                closeBtn: '<a title="Close" class="fancybox-item fancybox-close" href="javascript:;"></a>',
                next: '<a title="Next" class="fancybox-nav fancybox-next" href="javascript:;"><span></span></a>',
                prev: '<a title="Previous" class="fancybox-nav fancybox-prev" href="javascript:;"><span></span></a>'
            },
            openEffect: "fade",
            openSpeed: 250,
            openEasing: "swing",
            openOpacity: !0,
            openMethod: "zoomIn",
            closeEffect: "fade",
            closeSpeed: 250,
            closeEasing: "swing",
            closeOpacity: !0,
            closeMethod: "zoomOut",
            nextEffect: "elastic",
            nextSpeed: 250,
            nextEasing: "swing",
            nextMethod: "changeIn",
            prevEffect: "elastic",
            prevSpeed: 250,
            prevEasing: "swing",
            prevMethod: "changeOut",
            helpers: {overlay: !0, title: !0},
            onCancel: i.noop,
            beforeLoad: i.noop,
            afterLoad: i.noop,
            beforeShow: i.noop,
            afterShow: i.noop,
            beforeChange: i.noop,
            beforeClose: i.noop,
            afterClose: i.noop
        },
        group: {},
        opts: {},
        previous: null,
        coming: null,
        current: null,
        isActive: !1,
        isOpen: !1,
        isOpened: !1,
        wrap: null,
        skin: null,
        outer: null,
        inner: null,
        player: {timer: null, isActive: !1},
        ajaxLoad: null,
        imgPreload: null,
        transitions: {},
        helpers: {},
        open: function (t, e) {
            return t && (i.isPlainObject(e) || (e = {}), !1 !== r.close(!0)) ? (i.isArray(t) || (t = d(t) ? i(t).get() : [t]), i.each(t, function (n, a) {
                var s, l, c, h, f, u = {};
                "object" === i.type(a) && (a.nodeType && (a = i(a)), d(a) ? (u = {
                    href: a.data("fancybox-href") || a.attr("href"),
                    title: a.data("fancybox-title") || a.attr("title"),
                    isDom: !0,
                    element: a
                }, i.metadata && i.extend(!0, u, a.metadata())) : u = a), s = e.href || u.href || (p(a) ? a : null), l = e.title !== o ? e.title : u.title || "", h = (c = e.content || u.content) ? "html" : e.type || u.type, !h && u.isDom && (h = a.data("fancybox-type"), h || (h = (h = a.prop("class").match(/fancybox\.(\w+)/)) ? h[1] : null)), p(s) && (h || (r.isImage(s) ? h = "image" : r.isSWF(s) ? h = "swf" : "#" === s.charAt(0) ? h = "inline" : p(a) && (h = "html", c = a)), "ajax" === h && (f = s.split(/\s+/, 2), s = f.shift(), f = f.shift())), c || ("inline" === h ? s ? c = i(p(s) ? s.replace(/.*(?=#[^\s]+$)/, "") : s) : u.isDom && (c = a) : "html" === h ? c = s : !h && !s && u.isDom && (h = "inline", c = a)), i.extend(u, {
                    href: s,
                    type: h,
                    content: c,
                    title: l,
                    selector: f
                }), t[n] = u
            }), r.opts = i.extend(!0, {}, r.defaults, e), e.keys !== o && (r.opts.keys = e.keys ? i.extend({}, r.defaults.keys, e.keys) : !1), r.group = t, r._start(r.opts.index)) : void 0
        },
        cancel: function () {
            var t = r.coming;
            t && !1 !== r.trigger("onCancel") && (r.hideLoading(), r.ajaxLoad && r.ajaxLoad.abort(), r.ajaxLoad = null, r.imgPreload && (r.imgPreload.onload = r.imgPreload.onerror = null), t.wrap && t.wrap.stop(!0, !0).trigger("onReset").remove(), r.coming = null, r.current || r._afterZoomOut(t))
        },
        close: function (t) {
            r.cancel(), !1 !== r.trigger("beforeClose") && (r.unbindEvents(), r.isActive && (r.isOpen && !0 !== t ? (r.isOpen = r.isOpened = !1, r.isClosing = !0, i(".fancybox-item, .fancybox-nav").remove(), r.wrap.stop(!0, !0).removeClass("fancybox-opened"), r.transitions[r.current.closeMethod]()) : (i(".fancybox-wrap").stop(!0).trigger("onReset").remove(), r._afterZoomOut())))
        },
        play: function (t) {
            var e = function () {
                clearTimeout(r.player.timer)
            }, i = function () {
                e(), r.current && r.player.isActive && (r.player.timer = setTimeout(r.next, r.current.playSpeed))
            }, o = function () {
                e(), s.unbind(".player"), r.player.isActive = !1, r.trigger("onPlayEnd")
            };
            !0 === t || !r.player.isActive && !1 !== t ? r.current && (r.current.loop || r.current.index < r.group.length - 1) && (r.player.isActive = !0, s.bind({
                "onCancel.player beforeClose.player": o,
                "onUpdate.player": i,
                "beforeLoad.player": e
            }), i(), r.trigger("onPlayStart")) : o()
        },
        next: function (t) {
            var e = r.current;
            e && (p(t) || (t = e.direction.next), r.jumpto(e.index + 1, t, "next"))
        },
        prev: function (t) {
            var e = r.current;
            e && (p(t) || (t = e.direction.prev), r.jumpto(e.index - 1, t, "prev"))
        },
        jumpto: function (t, e, i) {
            var n = r.current;
            n && (t = u(t), r.direction = e || n.direction[t >= n.index ? "next" : "prev"], r.router = i || "jumpto", n.loop && (0 > t && (t = n.group.length + t % n.group.length), t %= n.group.length), n.group[t] !== o && (r.cancel(), r._start(t)))
        },
        reposition: function (t, e) {
            var o, n = r.current, a = n ? n.wrap : null;
            a && (o = r._getPosition(e), t && "scroll" === t.type ? (delete o.position, a.stop(!0, !0).animate(o, 200)) : (a.css(o), n.pos = i.extend({}, n.dim, o)))
        },
        update: function (t) {
            var e = t && t.type, i = !e || "orientationchange" === e;
            i && (clearTimeout(c), c = null), r.isOpen && !c && (c = setTimeout(function () {
                var o = r.current;
                o && !r.isClosing && (r.wrap.removeClass("fancybox-tmp"), (i || "load" === e || "resize" === e && o.autoResize) && r._setDimension(), "scroll" === e && o.canShrink || r.reposition(t), r.trigger("onUpdate"), c = null)
            }, i && !h ? 0 : 300))
        },
        toggle: function (t) {
            r.isOpen && (r.current.fitToView = "boolean" === i.type(t) ? t : !r.current.fitToView, h && (r.wrap.removeAttr("style").addClass("fancybox-tmp"), r.trigger("onUpdate")), r.update())
        },
        hideLoading: function () {
            s.unbind(".loading"), i("#fancybox-loading").remove()
        },
        showLoading: function () {
            var t, e;
            r.hideLoading(), t = i('<div id="fancybox-loading"><div></div></div>').click(r.cancel).appendTo("body"), s.bind("keydown.loading", function (t) {
                27 === (t.which || t.keyCode) && (t.preventDefault(), r.cancel())
            }), r.defaults.fixed || (e = r.getViewport(), t.css({
                position: "absolute",
                top: .5 * e.h + e.y,
                left: .5 * e.w + e.x
            }))
        },
        getViewport: function () {
            var e = r.current && r.current.locked || !1, i = {x: a.scrollLeft(), y: a.scrollTop()};
            return e ? (i.w = e[0].clientWidth, i.h = e[0].clientHeight) : (i.w = h && t.innerWidth ? t.innerWidth : a.width(), i.h = h && t.innerHeight ? t.innerHeight : a.height()), i
        },
        unbindEvents: function () {
            r.wrap && d(r.wrap) && r.wrap.unbind(".fb"), s.unbind(".fb"), a.unbind(".fb")
        },
        bindEvents: function () {
            var t, e = r.current;
            e && (a.bind("orientationchange.fb" + (h ? "" : " resize.fb") + (e.autoCenter && !e.locked ? " scroll.fb" : ""), r.update), (t = e.keys) && s.bind("keydown.fb", function (n) {
                var a = n.which || n.keyCode, s = n.target || n.srcElement;
                return 27 === a && r.coming ? !1 : void!(n.ctrlKey || n.altKey || n.shiftKey || n.metaKey || s && (s.type || i(s).is("[contenteditable]")) || !i.each(t, function (t, s) {
                    return 1 < e.group.length && s[a] !== o ? (r[t](s[a]), n.preventDefault(), !1) : -1 < i.inArray(a, s) ? (r[t](), n.preventDefault(), !1) : void 0
                }))
            }), i.fn.mousewheel && e.mouseWheel && r.wrap.bind("mousewheel.fb", function (t, o, n, a) {
                for (var s = i(t.target || null), l = !1; s.length && !l && !s.is(".fancybox-skin") && !s.is(".fancybox-wrap");)l = s[0] && !(s[0].style.overflow && "hidden" === s[0].style.overflow) && (s[0].clientWidth && s[0].scrollWidth > s[0].clientWidth || s[0].clientHeight && s[0].scrollHeight > s[0].clientHeight), s = i(s).parent();
                0 !== o && !l && 1 < r.group.length && !e.canShrink && (a > 0 || n > 0 ? r.prev(a > 0 ? "down" : "left") : (0 > a || 0 > n) && r.next(0 > a ? "up" : "right"), t.preventDefault())
            }))
        },
        trigger: function (t, e) {
            var o, n = e || r.coming || r.current;
            if (n) {
                if (i.isFunction(n[t]) && (o = n[t].apply(n, Array.prototype.slice.call(arguments, 1))), !1 === o)return !1;
                n.helpers && i.each(n.helpers, function (e, o) {
                    o && r.helpers[e] && i.isFunction(r.helpers[e][t]) && r.helpers[e][t](i.extend(!0, {}, r.helpers[e].defaults, o), n)
                }), s.trigger(t)
            }
        },
        isImage: function (t) {
            return p(t) && t.match(/(^data:image\/.*,)|(\.(jp(e|g|eg)|gif|png|bmp|webp|svg)((\?|#).*)?$)/i)
        },
        isSWF: function (t) {
            return p(t) && t.match(/\.(swf)((\?|#).*)?$/i)
        },
        _start: function (t) {
            var e, o, n = {};
            if (t = u(t), e = r.group[t] || null, !e)return !1;
            if (n = i.extend(!0, {}, r.opts, e), e = n.margin, o = n.padding, "number" === i.type(e) && (n.margin = [e, e, e, e]), "number" === i.type(o) && (n.padding = [o, o, o, o]), n.modal && i.extend(!0, n, {
                    closeBtn: !1,
                    closeClick: !1,
                    nextClick: !1,
                    arrows: !1,
                    mouseWheel: !1,
                    keys: null,
                    helpers: {overlay: {closeClick: !1}}
                }), n.autoSize && (n.autoWidth = n.autoHeight = !0), "auto" === n.width && (n.autoWidth = !0), "auto" === n.height && (n.autoHeight = !0), n.group = r.group, n.index = t, r.coming = n, !1 === r.trigger("beforeLoad"))r.coming = null; else {
                if (o = n.type, e = n.href, !o)return r.coming = null, r.current && r.router && "jumpto" !== r.router ? (r.current.index = t, r[r.router](r.direction)) : !1;
                if (r.isActive = !0, ("image" === o || "swf" === o) && (n.autoHeight = n.autoWidth = !1, n.scrolling = "visible"), "image" === o && (n.aspectRatio = !0), "iframe" === o && h && (n.scrolling = "scroll"), n.wrap = i(n.tpl.wrap).addClass("fancybox-" + (h ? "mobile" : "desktop") + " fancybox-type-" + o + " fancybox-tmp " + n.wrapCSS).appendTo(n.parent || "body"), i.extend(n, {
                        skin: i(".fancybox-skin", n.wrap),
                        outer: i(".fancybox-outer", n.wrap),
                        inner: i(".fancybox-inner", n.wrap)
                    }), i.each(["Top", "Right", "Bottom", "Left"], function (t, e) {
                        n.skin.css("padding" + e, g(n.padding[t]))
                    }), r.trigger("onReady"), "inline" === o || "html" === o) {
                    if (!n.content || !n.content.length)return r._error("content")
                } else if (!e)return r._error("href");
                "image" === o ? r._loadImage() : "ajax" === o ? r._loadAjax() : "iframe" === o ? r._loadIframe() : r._afterLoad()
            }
        },
        _error: function (t) {
            i.extend(r.coming, {
                type: "html",
                autoWidth: !0,
                autoHeight: !0,
                minWidth: 0,
                minHeight: 0,
                scrolling: "no",
                hasError: t,
                content: r.coming.tpl.error
            }), r._afterLoad()
        },
        _loadImage: function () {
            var t = r.imgPreload = new Image;
            t.onload = function () {
                this.onload = this.onerror = null, r.coming.width = this.width / r.opts.pixelRatio, r.coming.height = this.height / r.opts.pixelRatio, r._afterLoad()
            }, t.onerror = function () {
                this.onload = this.onerror = null, r._error("image")
            }, t.src = r.coming.href, !0 !== t.complete && r.showLoading()
        },
        _loadAjax: function () {
            var t = r.coming;
            r.showLoading(), r.ajaxLoad = i.ajax(i.extend({}, t.ajax, {
                url: t.href, error: function (t, e) {
                    r.coming && "abort" !== e ? r._error("ajax", t) : r.hideLoading()
                }, success: function (e, i) {
                    "success" === i && (t.content = e, r._afterLoad())
                }
            }))
        },
        _loadIframe: function () {
            var t = r.coming, e = i(t.tpl.iframe.replace(/\{rnd\}/g, (new Date).getTime())).attr("scrolling", h ? "auto" : t.iframe.scrolling).attr("src", t.href);
            i(t.wrap).bind("onReset", function () {
                try {
                    i(this).find("iframe").hide().attr("src", "//about:blank").end().empty()
                } catch (t) {
                }
            }), t.iframe.preload && (r.showLoading(), e.one("load", function () {
                i(this).data("ready", 1), h || i(this).bind("load.fb", r.update), i(this).parents(".fancybox-wrap").width("100%").removeClass("fancybox-tmp").show(), r._afterLoad()
            })), t.content = e.appendTo(t.inner), t.iframe.preload || r._afterLoad()
        },
        _preloadImages: function () {
            var t, e, i = r.group, o = r.current, n = i.length, a = o.preload ? Math.min(o.preload, n - 1) : 0;
            for (e = 1; a >= e; e += 1)t = i[(o.index + e) % n], "image" === t.type && t.href && ((new Image).src = t.href)
        },
        _afterLoad: function () {
            var t, e, o, n, a, s = r.coming, l = r.current;
            if (r.hideLoading(), s && !1 !== r.isActive)if (!1 === r.trigger("afterLoad", s, l))s.wrap.stop(!0).trigger("onReset").remove(), r.coming = null; else {
                switch (l && (r.trigger("beforeChange", l), l.wrap.stop(!0).removeClass("fancybox-opened").find(".fancybox-item, .fancybox-nav").remove()), r.unbindEvents(), t = s.content, e = s.type, o = s.scrolling, i.extend(r, {
                    wrap: s.wrap,
                    skin: s.skin,
                    outer: s.outer,
                    inner: s.inner,
                    current: s,
                    previous: l
                }), n = s.href, e) {
                    case"inline":
                    case"ajax":
                    case"html":
                        s.selector ? t = i("<div>").html(t).find(s.selector) : d(t) && (t.data("fancybox-placeholder") || t.data("fancybox-placeholder", i('<div class="fancybox-placeholder"></div>').insertAfter(t).hide()), t = t.show().detach(), s.wrap.bind("onReset", function () {
                            i(this).find(t).length && t.hide().replaceAll(t.data("fancybox-placeholder")).data("fancybox-placeholder", !1)
                        }));
                        break;
                    case"image":
                        t = s.tpl.image.replace("{href}", n);
                        break;
                    case"swf":
                        t = '<object id="fancybox-swf" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="100%" height="100%"><param name="movie" value="' + n + '"></param>', a = "", i.each(s.swf, function (e, i) {
                            t += '<param name="' + e + '" value="' + i + '"></param>', a += " " + e + '="' + i + '"'
                        }), t += '<embed src="' + n + '" type="application/x-shockwave-flash" width="100%" height="100%"' + a + "></embed></object>"
                }
                (!d(t) || !t.parent().is(s.inner)) && s.inner.append(t), r.trigger("beforeShow"), s.inner.css("overflow", "yes" === o ? "scroll" : "no" === o ? "hidden" : o), r._setDimension(), r.reposition(), r.isOpen = !1, r.coming = null, r.bindEvents(), r.isOpened ? l.prevMethod && r.transitions[l.prevMethod]() : i(".fancybox-wrap").not(s.wrap).stop(!0).trigger("onReset").remove(), r.transitions[r.isOpened ? s.nextMethod : s.openMethod](), r._preloadImages()
            }
        },
        _setDimension: function () {
            var t, e, o, n, a, s, l, c, h, d = r.getViewport(), p = 0, m = !1, v = !1, m = r.wrap, y = r.skin, b = r.inner, w = r.current, v = w.width, x = w.height, T = w.minWidth, C = w.minHeight, $ = w.maxWidth, k = w.maxHeight, E = w.scrolling, S = w.scrollOutside ? w.scrollbarWidth : 0, I = w.margin, O = u(I[1] + I[3]), D = u(I[0] + I[2]);
            if (m.add(y).add(b).width("auto").height("auto").removeClass("fancybox-tmp"), I = u(y.outerWidth(!0) - y.width()), t = u(y.outerHeight(!0) - y.height()), e = O + I, o = D + t, n = f(v) ? (d.w - e) * u(v) / 100 : v, a = f(x) ? (d.h - o) * u(x) / 100 : x, "iframe" === w.type) {
                if (h = w.content, w.autoHeight && 1 === h.data("ready"))try {
                    h[0].contentWindow.document.location && (b.width(n).height(9999), s = h.contents().find("body"), S && s.css("overflow-x", "hidden"), a = s.outerHeight(!0))
                } catch (A) {
                }
            } else(w.autoWidth || w.autoHeight) && (b.addClass("fancybox-tmp"), w.autoWidth || b.width(n), w.autoHeight || b.height(a), w.autoWidth && (n = b.width()), w.autoHeight && (a = b.height()), b.removeClass("fancybox-tmp"));
            if (v = u(n), x = u(a), c = n / a, T = u(f(T) ? u(T, "w") - e : T), $ = u(f($) ? u($, "w") - e : $), C = u(f(C) ? u(C, "h") - o : C), k = u(f(k) ? u(k, "h") - o : k), s = $, l = k, w.fitToView && ($ = Math.min(d.w - e, $), k = Math.min(d.h - o, k)), e = d.w - O, D = d.h - D, w.aspectRatio ? (v > $ && (v = $, x = u(v / c)), x > k && (x = k, v = u(x * c)), T > v && (v = T, x = u(v / c)), C > x && (x = C, v = u(x * c))) : (v = Math.max(T, Math.min(v, $)), w.autoHeight && "iframe" !== w.type && (b.width(v), x = b.height()), x = Math.max(C, Math.min(x, k))), w.fitToView)if (b.width(v).height(x), m.width(v + I), d = m.width(), O = m.height(), w.aspectRatio)for (; (d > e || O > D) && v > T && x > C && !(19 < p++);)x = Math.max(C, Math.min(k, x - 10)), v = u(x * c), T > v && (v = T, x = u(v / c)), v > $ && (v = $, x = u(v / c)), b.width(v).height(x), m.width(v + I), d = m.width(), O = m.height(); else v = Math.max(T, Math.min(v, v - (d - e))), x = Math.max(C, Math.min(x, x - (O - D)));
            S && "auto" === E && a > x && e > v + I + S && (v += S), b.width(v).height(x), m.width(v + I), d = m.width(), O = m.height(), m = (d > e || O > D) && v > T && x > C, v = w.aspectRatio ? s > v && l > x && n > v && a > x : (s > v || l > x) && (n > v || a > x), i.extend(w, {
                dim: {
                    width: g(d),
                    height: g(O)
                },
                origWidth: n,
                origHeight: a,
                canShrink: m,
                canExpand: v,
                wPadding: I,
                hPadding: t,
                wrapSpace: O - y.outerHeight(!0),
                skinSpace: y.height() - x
            }), !h && w.autoHeight && x > C && k > x && !v && b.height("auto")
        },
        _getPosition: function (t) {
            var e = r.current, i = r.getViewport(), o = e.margin, n = r.wrap.width() + o[1] + o[3], a = r.wrap.height() + o[0] + o[2], o = {
                position: "absolute",
                top: o[0],
                left: o[3]
            };
            return e.autoCenter && e.fixed && !t && a <= i.h && n <= i.w ? o.position = "fixed" : e.locked || (o.top += i.y, o.left += i.x), o.top = g(Math.max(o.top, o.top + (i.h - a) * e.topRatio)), o.left = g(Math.max(o.left, o.left + (i.w - n) * e.leftRatio)), o
        },
        _afterZoomIn: function () {
            var t = r.current;
            t && (r.isOpen = r.isOpened = !0, r.wrap.css("overflow", "visible").addClass("fancybox-opened"), r.update(), (t.closeClick || t.nextClick && 1 < r.group.length) && r.inner.css("cursor", "pointer").bind("click.fb", function (e) {
                !i(e.target).is("a") && !i(e.target).parent().is("a") && (e.preventDefault(), r[t.closeClick ? "close" : "next"]())
            }), t.closeBtn && i(t.tpl.closeBtn).appendTo(r.skin).bind("click.fb", function (t) {
                t.preventDefault(), r.close()
            }), t.arrows && 1 < r.group.length && ((t.loop || 0 < t.index) && i(t.tpl.prev).appendTo(r.outer).bind("click.fb", r.prev), (t.loop || t.index < r.group.length - 1) && i(t.tpl.next).appendTo(r.outer).bind("click.fb", r.next)), r.trigger("afterShow"), t.loop || t.index !== t.group.length - 1 ? r.opts.autoPlay && !r.player.isActive && (r.opts.autoPlay = !1, r.play()) : r.play(!1))
        },
        _afterZoomOut: function (t) {
            t = t || r.current, i(".fancybox-wrap").trigger("onReset").remove(), i.extend(r, {
                group: {},
                opts: {},
                router: !1,
                current: null,
                isActive: !1,
                isOpened: !1,
                isOpen: !1,
                isClosing: !1,
                wrap: null,
                skin: null,
                outer: null,
                inner: null
            }), r.trigger("afterClose", t)
        }
    }), r.transitions = {
        getOrigPosition: function () {
            var t = r.current, e = t.element, i = t.orig, o = {}, n = 50, a = 50, s = t.hPadding, l = t.wPadding, c = r.getViewport();
            return !i && t.isDom && e.is(":visible") && (i = e.find("img:first"), i.length || (i = e)), d(i) ? (o = i.offset(), i.is("img") && (n = i.outerWidth(), a = i.outerHeight())) : (o.top = c.y + (c.h - a) * t.topRatio, o.left = c.x + (c.w - n) * t.leftRatio), ("fixed" === r.wrap.css("position") || t.locked) && (o.top -= c.y, o.left -= c.x), o = {
                top: g(o.top - s * t.topRatio),
                left: g(o.left - l * t.leftRatio),
                width: g(n + l),
                height: g(a + s)
            }
        }, step: function (t, e) {
            var i, o, n = e.prop;
            o = r.current;
            var a = o.wrapSpace, s = o.skinSpace;
            ("width" === n || "height" === n) && (i = e.end === e.start ? 1 : (t - e.start) / (e.end - e.start), r.isClosing && (i = 1 - i), o = "width" === n ? o.wPadding : o.hPadding, o = t - o, r.skin[n](u("width" === n ? o : o - a * i)), r.inner[n](u("width" === n ? o : o - a * i - s * i)))
        }, zoomIn: function () {
            var t = r.current, e = t.pos, o = t.openEffect, n = "elastic" === o, a = i.extend({opacity: 1}, e);
            delete a.position, n ? (e = this.getOrigPosition(), t.openOpacity && (e.opacity = .1)) : "fade" === o && (e.opacity = .1), r.wrap.css(e).animate(a, {
                duration: "none" === o ? 0 : t.openSpeed,
                easing: t.openEasing,
                step: n ? this.step : null,
                complete: r._afterZoomIn
            })
        }, zoomOut: function () {
            var t = r.current, e = t.closeEffect, i = "elastic" === e, o = {opacity: .1};
            i && (o = this.getOrigPosition(), t.closeOpacity && (o.opacity = .1)), r.wrap.animate(o, {
                duration: "none" === e ? 0 : t.closeSpeed,
                easing: t.closeEasing,
                step: i ? this.step : null,
                complete: r._afterZoomOut
            })
        }, changeIn: function () {
            var t, e = r.current, i = e.nextEffect, o = e.pos, n = {opacity: 1}, a = r.direction;
            o.opacity = .1, "elastic" === i && (t = "down" === a || "up" === a ? "top" : "left", "down" === a || "right" === a ? (o[t] = g(u(o[t]) - 200), n[t] = "+=200px") : (o[t] = g(u(o[t]) + 200), n[t] = "-=200px")), "none" === i ? r._afterZoomIn() : r.wrap.css(o).animate(n, {
                duration: e.nextSpeed,
                easing: e.nextEasing,
                complete: r._afterZoomIn
            })
        }, changeOut: function () {
            var t = r.previous, e = t.prevEffect, o = {opacity: .1}, n = r.direction;
            "elastic" === e && (o["down" === n || "up" === n ? "top" : "left"] = ("up" === n || "left" === n ? "-" : "+") + "=200px"), t.wrap.animate(o, {
                duration: "none" === e ? 0 : t.prevSpeed,
                easing: t.prevEasing,
                complete: function () {
                    i(this).trigger("onReset").remove()
                }
            })
        }
    }, r.helpers.overlay = {
        defaults: {closeClick: !0, speedOut: 200, showEarly: !0, css: {}, locked: !h, fixed: !0},
        overlay: null,
        fixed: !1,
        el: i("html"),
        create: function (t) {
            t = i.extend({}, this.defaults, t), this.overlay && this.close(), this.overlay = i('<div class="fancybox-overlay"></div>').appendTo(r.coming ? r.coming.parent : t.parent), this.fixed = !1, t.fixed && r.defaults.fixed && (this.overlay.addClass("fancybox-overlay-fixed"), this.fixed = !0)
        },
        open: function (t) {
            var e = this;
            t = i.extend({}, this.defaults, t), this.overlay ? this.overlay.unbind(".overlay").width("auto").height("auto") : this.create(t), this.fixed || (a.bind("resize.overlay", i.proxy(this.update, this)), this.update()), t.closeClick && this.overlay.bind("click.overlay", function (t) {
                return i(t.target).hasClass("fancybox-overlay") ? (r.isActive ? r.close() : e.close(), !1) : void 0
            }), this.overlay.css(t.css).show()
        },
        close: function () {
            var t, e;
            a.unbind("resize.overlay"), this.el.hasClass("fancybox-lock") && (i(".fancybox-margin").removeClass("fancybox-margin"), t = a.scrollTop(), e = a.scrollLeft(), this.el.removeClass("fancybox-lock"), a.scrollTop(t).scrollLeft(e)), i(".fancybox-overlay").remove().hide(), i.extend(this, {
                overlay: null,
                fixed: !1
            })
        },
        update: function () {
            var t, i = "100%";
            this.overlay.width(i).height("100%"), l ? (t = Math.max(e.documentElement.offsetWidth, e.body.offsetWidth), s.width() > t && (i = s.width())) : s.width() > a.width() && (i = s.width()), this.overlay.width(i).height(s.height())
        },
        onReady: function (t, e) {
            var o = this.overlay;
            i(".fancybox-overlay").stop(!0, !0), o || this.create(t), t.locked && this.fixed && e.fixed && (o || (this.margin = s.height() > a.height() ? i("html").css("margin-right").replace("px", "") : !1), e.locked = this.overlay.append(e.wrap), e.fixed = !1), !0 === t.showEarly && this.beforeShow.apply(this, arguments)
        },
        beforeShow: function (t, e) {
            var o, n;
            e.locked && (!1 !== this.margin && (i("*").filter(function () {
                return "fixed" === i(this).css("position") && !i(this).hasClass("fancybox-overlay") && !i(this).hasClass("fancybox-wrap")
            }).addClass("fancybox-margin"), this.el.addClass("fancybox-margin")), o = a.scrollTop(), n = a.scrollLeft(), this.el.addClass("fancybox-lock"), a.scrollTop(o).scrollLeft(n)), this.open(t)
        },
        onUpdate: function () {
            this.fixed || this.update()
        },
        afterClose: function (t) {
            this.overlay && !r.coming && this.overlay.fadeOut(t.speedOut, i.proxy(this.close, this))
        }
    }, r.helpers.title = {
        defaults: {type: "float", position: "bottom"}, beforeShow: function (t) {
            var e = r.current, o = e.title, n = t.type;
            if (i.isFunction(o) && (o = o.call(e.element, e)), p(o) && "" !== i.trim(o)) {
                switch (e = i('<div class="fancybox-title fancybox-title-' + n + '-wrap">' + o + "</div>"), n) {
                    case"inside":
                        n = r.skin;
                        break;
                    case"outside":
                        n = r.wrap;
                        break;
                    case"over":
                        n = r.inner;
                        break;
                    default:
                        n = r.skin, e.appendTo("body"), l && e.width(e.width()), e.wrapInner('<span class="child"></span>'), r.current.margin[2] += Math.abs(u(e.css("margin-bottom")))
                }
                e["top" === t.position ? "prependTo" : "appendTo"](n)
            }
        }
    }, i.fn.fancybox = function (t) {
        var e, o = i(this), n = this.selector || "", a = function (a) {
            var s, l, c = i(this).blur(), h = e;
            !(a.ctrlKey || a.altKey || a.shiftKey || a.metaKey || c.is(".fancybox-wrap") || (s = t.groupAttr || "data-fancybox-group", l = c.attr(s), l || (s = "rel", l = c.get(0)[s]), l && "" !== l && "nofollow" !== l && (c = n.length ? i(n) : o, c = c.filter("[" + s + '="' + l + '"]'), h = c.index(this)), t.index = h, !1 === r.open(c, t) || !a.preventDefault()))
        };
        return t = t || {}, e = t.index || 0, n && !1 !== t.live ? s.undelegate(n, "click.fb-start").delegate(n + ":not('.fancybox-item, .fancybox-nav')", "click.fb-start", a) : o.unbind("click.fb-start").bind("click.fb-start", a), this.filter("[data-fancybox-start=1]").trigger("click"), this
    }, s.ready(function () {
        var e, a;
        if (i.scrollbarWidth === o && (i.scrollbarWidth = function () {
                var t = i('<div style="width:50px;height:50px;overflow:auto"><div/></div>').appendTo("body"), e = t.children(), e = e.innerWidth() - e.height(99).innerWidth();
                return t.remove(), e
            }), i.support.fixedPosition === o) {
            e = i.support, a = i('<div style="position:fixed;top:20px;"></div>').appendTo("body");
            var s = 20 === a[0].offsetTop || 15 === a[0].offsetTop;
            a.remove(), e.fixedPosition = s
        }
        i.extend(r.defaults, {
            scrollbarWidth: i.scrollbarWidth(),
            fixed: i.support.fixedPosition,
            parent: i("body")
        }), e = i(t).width(), n.addClass("fancybox-lock-test"), a = i(t).width(), n.removeClass("fancybox-lock-test"), i("<style type='text/css'>.fancybox-margin{margin-right:" + (a - e) + "px;}</style>").appendTo("head")
    })
}(window, document, jQuery), function (t) {
    "use strict";
    Array.prototype.unique = function () {
        for (var t = {}, e = [], i = 0, o = this.length; o > i; ++i)t[this[i]] || (t[this[i]] = !0, e.push(this[i]));
        return e
    }, t(function () {
        function e() {
            if ("" !== location.hash) {
                var e = location.hash.replace("#gallery-", ""), i = e.split("-");
                i.filter(function (t) {
                    return parseInt(t)
                });
                var o = t("#gallery-" + i.shift() + " .gallery-item:eq(" + i.shift() + ") a");
                o.length && o.trigger("click")
            }
        }

        t(".gallery a").fancybox({
            afterShow: function () {
                var e = t(this.element).parents(".gallery"), i = e.find(".gallery-item").index(t(this.element).parents(".gallery-item"));
                location.hash = e.attr("id") + "-" + i
            }, beforeShow: function () {
                this.title = t(this.element).parent().parent().find(".wp-caption-text").text()
            }
        }), e(), t('[data-toggle="tooltip"]').tooltip(), t('[data-toggle="ctooltip"]').hover(function () {
            t(this).find('[data-toggle="tooltip"]').tooltip("show")
        }, function () {
            t(this).find('[data-toggle="tooltip"]').tooltip("hide")
        }), t(".b-redirect").click(function (e) {
            e.preventDefault(), t('.b-product_order input[type="submit"]').click()
        });
        var i = t("#b-autosize-menu li").length;
        13 > i && t("#b-autosize-menu").addClass("b-autosize-height")
    }), t(function () {
        var e = t('[data-toggle="stickmenu"]');
        if (e.length) {
            var i = e.position().top, o = t("#wpadminbar").length;
            o && e.css("top", "32px"), t(window).scroll(function () {
                var o = t(window).scrollTop();
                t(window).width() >= 975 ? o >= i ? e.hasClass("b-main-menu-fixed") || e.addClass("b-main-menu-fixed") : e.hasClass("b-main-menu-fixed") && e.removeClass("b-main-menu-fixed") : e.removeClass("b-main-menu-fixed")
            })
        }
    }), t(function () {
        var e = function () {
            return this._getParams = this.MGET(), this
        };
        e.prototype.getParamByName = function (t) {
            return this._getParams[t] ? this._getParams[t] : !1
        }, e.prototype.setParamByName = function (t, e) {
            return this._getParams[t] = e, this
        }, e.prototype.deleteParamByName = function (t) {
            return this._getParams[t] && delete this._getParams[t], this
        }, e.prototype.MGET = function () {
            var t = {}, e = window.location.search.split(/\?|\&/);
            return e.forEach(function (e) {
                if (e) {
                    var i = e.split("=");
                    t[i[0]] = i[1]
                }
            }), t
        }, e.prototype.getParameterString = function (e) {
            return t.param(t.extend(this._getParams, e))
        }, e.prototype.getUrl = function () {
            var t = location.origin + location.pathname;
            return this.getParameterString() ? t + "?" + this.getParameterString() : t
        }, e.prototype.redirect = function (t) {
            location.href = decodeURIComponent(t)
        }, t(window).on("ssdmaFilterPrice", function (t, i, o) {
            var n = new e;
            n.getParamByName("order") || n.setParamByName("order", "DESC"), n.setParamByName("pmin", i), n.setParamByName("pmax", o), n.setParamByName("orderby", "price"), n.redirect(n.getUrl())
        }), t(".b-unselect").click(function (e) {
            e.preventDefault(), t(window).trigger("ssdmaFilterCheckboxClean")
        }), t(window).on("ssdmaFilterCheckboxClean", function () {
            var t = new e;
            t.deleteParamByName("ids"), t.redirect(t.getUrl())
        }), t(window).on("ssdmaFilterCheckbox", function (t, i, o) {
            var n = new e, a = n.getParamByName("ids");
            a = a ? a.split("-").filter(function (t) {
                return "" != t ? t : void 0
            }) : [], i ? a.push(o) : a.forEach(function (t, e, i) {
                t == o && i.splice(e, 1)
            }), a = a.unique().join("-"), "" == a ? n.deleteParamByName("ids") : n.setParamByName("ids", a), n.redirect(n.getUrl())
        }), t(window).on("ssdmaFilterPriceInit", function () {
            var i = new e, o = t('[data-toggle="slider"]'), n = t("#filter-slider-min"), a = t("#filter-slider-max"), s = parseFloat(o.attr("data-max")), r = parseFloat(i.getParamByName("pmin") && i.getParamByName("pmin") >= 0 ? i.getParamByName("pmin") : 0), l = parseFloat(i.getParamByName("pmax") ? i.getParamByName("pmax") : Math.ceil(s / 2));
            o.slider({
                range: !0, min: 0, max: s, values: [r, l], create: function () {
                    n.val(r), a.val(l)
                }, slide: function (t, e) {
                    n.val(e.values[0]), a.val(e.values[1])
                }, stop: function (e, i) {
                    t(window).trigger("ssdmaFilterPrice", [i.values[0], i.values[1]])
                }
            }), n.change(function () {
                var e = parseFloat(t(this).val()), i = parseFloat(a.val());
                t(window).trigger("ssdmaFilterPrice", [e, i])
            }), a.change(function () {
                var e = parseFloat(t(this).val()), i = parseFloat(n.val());
                t(window).trigger("ssdmaFilterPrice", [i, e])
            })
        }), t(".b-checked-cats input:checkbox").click(function () {
            var e = !1;
            t(this).attr("checked") && (e = !0), t(window).trigger("ssdmaFilterCheckbox", [e, t(this).val()])
        }), t(window).trigger("ssdmaFilterPriceInit")
    })
}(jQuery);