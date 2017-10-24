(function($) {
    $.fn.scrollShow = function(options) {
        $.extend($.fn.scrollShow.options, options);
        bindShow(this);
        return this;
    };

    function addStyle(elem) {
        $(elem).css($.fn.scrollShow.options.css);
    }

    function removeStyle(elem) {
        $(elem).removeAttr("style");
    }

    function bindShow(elem) {
        $(window).scroll(function() {
            $.fn.scrollShow.options.offCallback();
            newScroll = $(this).scrollTop();
            if ($.inArray(direction(newScroll), $.fn.scrollShow.options.direction) != -1 && $.fn.scrollShow.options.on) {
                $.fn.scrollShow.show(elem);
                setTimeout(function() { $.fn.scrollShow.hide(elem); }, 250);
            }
            updateScroll(newScroll);
        });
    }

    function direction(currentScroll) {
        if (currentScroll > previousScroll) {
            return "down";
        } else {
            return "up";
        }
    }

    function updateScroll(newScroll) {
        previousScroll = newScroll;
    }

    var previousScroll = 0;

    $.fn.scrollShow.show = function(elem) {
        addStyle(elem);
        $.fn.scrollShow.options.showCallback(elem);
    }

    $.fn.scrollShow.hide = function(elem) {
        removeStyle(elem);
        $.fn.scrollShow.options.hideCallback(elem);
    };

    $.fn.scrollShow.options = {
        css: { "position": "fixed", "height": "15%", "bottom": "0", "top": "auto", "left": "50%" },
        showCallback: null,
        hideCallback: null,
        offCallback: function() {
            if ($(window).scrollTop() + $(window).height() == $(document).height()) {
                $.fn.scrollShow.options.on = false;
            }
        },
        direction: ["down"],
        on: true
    };

})(jQuery);