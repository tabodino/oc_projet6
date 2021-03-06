! function() {
    $(document).ready(function() {
        var e, t, o, r, n, a, i, s, l, d;
        return setValidateForm(), setIEHelperClassses(), t = $("#header"), e = $(".hero-carousel"), o = $("#main"), t.attr("fixed") && (t.addClass("header--default"), $(window).scroll(function() {
            return $(window).scrollTop() >= e.height() - 150 ? (t.addClass("header--fixed"), o.addClass("main--header-fixed")) : (t.removeClass("header--fixed"), o.removeClass("main--header-fixed")), $(window).scrollTop() > e.height() ? t.addClass("header--visible") : t.removeClass("header--visible")
        })), jQuery().carousel && ($(".carousel.carousel-auto").carousel(), $(".carousel.carousel-auto").on("swipeleft", function() {
            return $(this).carousel("next")
        }), $(".carousel.carousel-auto").on("swiperight", function() {
            return $(this).carousel("prev")
        })), jQuery().knob && $("[data-stat='circle']").each(function(e, t) {
            return $(t).knob()
        }), d = !1, window.Modernizr && (d = Modernizr.touch), d || ($("body").on("mouseenter", ".has-tooltip", function() {
            var e;
            return e = $(this), void 0 === e.data("tooltip") && e.tooltip({
                placement: e.data("placement") || "top",
                container: "body"
            }), e.tooltip("show")
        }), $("body").on("mouseleave", ".has-tooltip", function() {
            return $(this).tooltip("hide")
        })), window.Modernizr && Modernizr.svg === !1 && $('img[src*="svg"]').attr("src", function() {
            return $(this).attr("src").replace(".svg", ".png")
        }), window.Modernizr && Modernizr.input.placeholder === !1 && ($("[placeholder]").focus(function() {
            var e;
            return e = $(this), e.val() === e.attr("placeholder") ? (e.val(""), e.removeClass("placeholder")) : void 0
        }).blur(function() {
            var e;
            return e = $(this), "" === e.val() || e.val() === e.attr("placeholder") ? (e.addClass("placeholder"), e.val(e.attr("placeholder"))) : void 0
        }).blur(), $("[placeholder]").parents("form").submit(function() {
            return $(this).find("[placeholder]").each(function() {
                var e;
                return e = $(this), e.val() === e.attr("placeholder") ? e.val("") : void 0
            })
        })), $(window).load(function() {
            var e, t;
            return jQuery().flexslider ? (t = $(".flexslider"), e = t.find(".item"), t.addClass("fade-loading"), $(".flexslider").flexslider({
                animation: "fade",
                pauseOnHover: !0,
                slideshowSpeed: 5e3,
                animationSpeed: 400,
                prevText: "",
                nextText: "",
                before: function(o) {
                    var r;
                    return r = t.find(".flex-active-slide"), r.index() === e.length - 1 ? (e.eq(0).find(".animate").children().addClass("animate").removeClass("animated"), e.not(".flex-active-slide").find(".animate").children().addClass("animate").removeClass("animated")) : e.not(".flex-active-slide").find(".animate").children().addClass("animate").removeClass("animated"), setTimeout(function() {
                        return e.eq(o.animatingTo).find(".animate").children().addClass("animated").removeClass("animate")
                    }, 50)
                }
            })) : void 0
        }), jQuery().countdown && $("[data-countdown]").countdown(), r = $("#main-content"), r.length > 0 && (n = $(".sidebar", "#main-content"), a = r.offset().top, s = r.css("paddingTop"), i = parseInt(s.substr(0, s.length - 2)), l = r.outerHeight() - n.outerHeight() + i, n.hasClass("sidebar-fixed") && (n.parent().css({
            position: "relative"
        }), n.css({
            position: "absolute"
        }), $(window).scroll(function() {
            var e;
            return $(this).scrollTop() >= a && $(this).scrollTop() <= l && (e = $(window).scrollTop() - a, n.css({
                top: e
            })), $(this).scrollTop() < a && n.css({
                top: 0
            }), $(this).scrollTop() > l ? n.css({
                top: l - a
            }) : void 0
        }))), $("#scroll-to-top").on("click", function() {
            return $("body, html").animate({
                scrollTop: 0
            }, 800), !1
        }), $(window).load(function() {
            var e, t, o;
            return e = $("#scroll-to-top"), t = e.css("bottom"), o = function() {
                return $(document).outerHeight() - $("#footer").outerHeight() - $(window).outerHeight()
            }, $("body").hasClass("boxed") ? $(window).scroll(function() {
                return $(this).scrollTop() > 500 ? e.addClass("in") : e.removeClass("in")
            }) : $(window).scroll(function() {
                return $(this).scrollTop() > 500 ? e.addClass("in") : e.removeClass("in"), $(this).scrollTop() >= o() ? e.css({
                    bottom: $(this).scrollTop() - o() + 10
                }) : e.css({
                    bottom: t
                })
            })
        }), jQuery().nivoLightbox && $("[data-lightbox]").nivoLightbox(), $(".form-contact").on("submit", function(e) {
            var t, o, r, n;
            return $(this).valid() ? (e.preventDefault(), r = $(this).find(".form-contact-submit"), r.button("loading"), n = $(this).find(".form-contact-success"), t = $(this).find(".form-contact-error"), o = $(this).find("input, textarea"), $.ajax({
                type: "POST",
                url: "",
                data: $(this).serialize(),
                success: function(e) {
                    return "success" === e ? (n.removeClass("hidden"), t.addClass("hidden"), o.val("")) : (t.removeClass("hidden"), n.addClass("hidden"))
                },
                complete: function() {
                    return r.button("reset")
                }
            })) : void 0
        })
    }), this.setValidateForm = function(e) {
        return null == e && (e = $(".form-validation")), jQuery().validate ? e.each(function(e, t) {
            return $(t).validate({
                errorElement: "span",
                errorClass: "help-block has-error",
                errorPlacement: function(e, t) {
                    return t.closest(".control-group").append(e)
                },
                highlight: function(e) {
                    return $(e).closest(".control-group").addClass("has-error")
                },
                unhighlight: function(e) {
                    return $(e).closest(".control-group").removeClass("has-error")
                }
            })
        }) : void 0
    }, this.setIEHelperClassses = function() {
        return /msie/.test(navigator.userAgent.toLowerCase()) ? ($("*:last-child").addClass("last-child"), $("*:nth-child(odd)").addClass("nth-child-odd"), $("*:nth-child(even)").addClass("nth-child-even")) : void 0
    }
}.call(this),
    function() {
        $(window).load(function() {
            var e;
            return jQuery().isotope ? (e = $("#portfolio-container"), e.isotope({
                layoutMode: "sloppyMasonry",
                itemSelector: ".portfolio-item"
            }), $("#portfolio-filter a").click(function() {
                var t;
                return $(this).closest("ul").find("li").removeClass("active"), $(this).parent().addClass("active"), t = $(this).attr("data-filter"), e.isotope({
                    filter: t
                }), !1
            })) : void 0
        })
    }.call(this);