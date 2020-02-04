
window.cpress = window.cpress || {};
var page =
{
    tickerDescriptions: {}
};
window.cpress.bounds = window.cpress.bounds || {};
$.extend(cpress.bounds, {
    Bounds: function (b, d, c, a)
    {
        this.x = b;
        this.y = d;
        this.width = c;
        this.height = a
    }
});
$.extend(cpress.bounds.Bounds.prototype, {
    encloses: function (a, b)
    {
        return a > this.x && a < this.x + this.width && b > this.y && b < this.y + this.height
    },
    toString: function ()
    {
        return "(" + this.x + "," + this.y + ") " + this.width + "x" + this.height
    }
});
(function (a)
{
    a.fn.extend(
    {
        bounds: function ()
        {
            var c = this.eq(0);
            var b = c.offset();
            return new cpress.bounds.Bounds(b.left, b.top, c.outerWidth(), c.outerHeight())
        }
    })
})(jQuery);

(function (A)
{
    A.extend(window, {
        tickerTip: {
            parseIntDefault: function (B, D)
            {
                D = D || 0;
                var C = parseInt(B);
                return isNaN(C) ? D : C
            },
            clearBounds: function ()
            {
                this.data("bounds", [])
            },
            addToBounds: function (B)
            {
                if (!this.data("bounds"))
                {
                    this.data("bounds", [])
                }
                this.data("bounds").push(B)
            },
            enclosing: function (B, D)
            {
                if (!this.data("bounds"))
                {
                    this.data("bounds", [])
                }
                var C = false;
                A.each(this.data("bounds"), function (F, E)
                {
                    if (E.encloses(B, D))
                    {
                        C = true
                    }
                });
                return C
            },
            clearScrollInterval: function ()
            {
                clearInterval(this.data("interval"))
            },
            setScrollInterval: function (B)
            {
                if (this.data("interval"))
                {
                    this.clearScrollInterval()
                }
                this.data("interval", setInterval(B, 30))
            },
            duplicateContent: function (B)
            {
                var C = 0;
                B.children().each(function ()
                {
                    C += A(this).outerWidth(true);
                    B.append(A(this).clone())
                });
                B.css(
                {
                    zoom: 1,
                    width: (2 * C) + "px"
                });
                return C
            },
            initScroller: function ()
            {
                var C = this;
                var E = this.duplicateContent(C);
                var B = tickerTip.parseIntDefault(C.css("left"), 0);
                var D = function ()
                {
                    B = (B % E) - 1;
                    C.css(
                    {
                        left: B
                    })
                };
                C.bind("tickerEnter", function ()
                {
                    C.clearScrollInterval()
                }).bind("tickerLeave", function ()
                {
                    C.setScrollInterval(D)
                }).trigger("tickerLeave")
            }
        }
    });
    A.extend(A.fn, {
        tickerTip: function ()
        {
            var B = false;
            var C = A(this);
            A.extend(C, tickerTip);
            C.initScroller();
            C.find("li a").each(function () {
                var D = A(this).closest("li");
                var E = {
                    mouseenter: function (G) {
                        var F = A(this);
                        A(".doubleColumnW.article-box").trigger("tickerLeave");
                        if (C.oldCapturedticker) {
                            C.oldCapturedticker.trigger("tickerLeave")
                        }
                        C.oldCapturedticker = F;
                        C.addToBounds(F.bounds());
                        if (C.enclosing(G.pageX, G.pageY)) {
                            A(".doubleColumnW.article-box").trigger("tickerEnter");
                            F.trigger("tickerEnter");
                            var H = function (I) {
                                if (!C.enclosing(I.pageX, I.pageY)) {
                                    A(".doubleColumnW.article-box").trigger("tickerLeave");
                                    F.trigger("tickerLeave")
                                }
                            };
                            A(document).bind("mousemove", H);
                            F.bind("tickerLeave", function (I) {
                                C.clearBounds();
                                A(document).unbind("mousemove", H)
                            })
                        }
                    },
                    tickerenter: function () {
                    },
                    tickerleave: function (G) {
                    }
                };
                A(this).mouseenter(E.mouseenter).bind("tickerEnter", E.tickerenter).bind("tickerLeave", E.tickerleave)
            });
            return this
        }
    })
})(jQuery);

function FrontPage()
{
    return $.extend(this, {
        $tickers: $(".doubleColumnW"),
        $tickerTip: $(".tickertip:eq(0)")

    })
}

$.extend(FrontPage.prototype, {
    init: function ()
    {
        this.inittickerHover();
    },
    inittickerHover: function ()
    {
        this.hoveringticker = false;
        var A = this;
        $(".doubleColumnW ul").tickerTip()
    }
});
(jQuery);

var Frontend = new(function ($)
{
    var $tickerSpace, tickerSpaceWidth;

    this.viewLayout = function ()
    {
        initTickers();
        initCarousel();
        initGallery();
        $('p')
          .filter(function() {
              return $.trim($(this).text()) === ''
          })
          .remove()
        $('.column').masonry({
          columnWidth: 240,
          itemSelector: '.box:visible',
        });
    };

    function initTickers()
    {
        new FrontPage().init();
    }

    function initCarousel()
    {
        $('.carouselSpace .buttons a[href="#next"]').live('click', function ()
        {
            var $next = $('.carouselSpace .carouselItem.open').next();
            if ($next.length == 0) $next = $('.carouselSpace .carouselItem:first');
            $('.carouselSpace .carouselItem').removeClass('open').hide();
            $next.addClass('open').show();
            return false;
        });
        $('.carouselSpace .buttons a[href="#prev"]').live('click', function ()
        {
            var $prev = $('.carouselSpace .carouselItem.open').prev();
            if ($prev.length == 0) $prev = $('.carouselSpace .carouselItem:last');
            $('.carouselSpace .carouselItem').removeClass('open').hide();
            $prev.addClass('open').show();
            return false;
        });
    }

    function initGallery()
    {
        $('.gallery .buttons a[href="#next"]').live('click', function ()
        {
            var $next = $('.gallery .photos img.selected').next();
            if ($next.length == 0) $next = $('.gallery .photos img:first');
            $('.gallery .photos img').removeClass('selected').hide();
            $next.addClass('selected').show();
            return false;
        });
        $('.gallery .buttons a[href="#prev"]').live('click', function ()
        {
            var $prev = $('.gallery .photos img.selected').prev();
            if ($prev.length == 0) $prev = $('.gallery .photos img:last');
            $('.gallery .photos img').removeClass('selected').hide();
            $prev.addClass('selected').show();
            return false;
        });
    }
})(jQuery);
