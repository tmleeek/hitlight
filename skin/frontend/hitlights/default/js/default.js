$j = jQuery.noConflict();

$j(document).ready(function () {
    $j('.sales-order-view .not-use').removeClass('container');
    clickShow('.top-user-info', '.header_wrapper .info_account', '.header');
    clickShow('.login-link-mb', '.info_account_scroll', '.header');
    clickShow('.search_icon', '.box_search_wrapper', '.menu_nav');
    clickShow('.person_icon', '.info_account_scroll', '.menu_nav');
    clickShow('.shop_icon', '.mini_cart_header', '.menu_nav');
    setHeight('.title_shop_project_category span', 0);
    addHeights('.col_box_instruction', '.content_col_instruction', 20);
    setHeight('.col-products-grid .product-name', 0);

    //clickShow('.right_header .login-link-lg', '.info_account', '.header');

    $j('.product-image-thumbs').bxSlider({
        slideWidth: 75,
        minSlides: 1,
        maxSlides: 5,
        slideMargin: 10,
        pager: false,
        infiniteLoop: false,
    });

    $j('.back_top').click(function () {
        $j('html, body').animate({scrollTop: 0}, 'slow');
    });

    $j('.back_top_mobile').click(function () {
        $j('html, body').animate({scrollTop: 0}, 'slow');
    });

    $j('.move-right-blogs .block-blog .block-title').click(function(){
        if($j(this).hasClass('active')) {
            $j(this).closest('.block-blog').find('.block-content').slideUp(200);
            $j(this).closest('.block-blog').find('.block-title').toggleClass('active');
        } else {
            $j('.move-right-blogs .block-content').hide();
            $j('.move-right-blogs .block-blog .block-title').removeClass('active');
            $j(this).addClass('active');
            $j(this).closest('.block-blog').find('.block-content').slideDown(200);
        }
    })

    $j(window).scroll(function () {
        if ($j(document).scrollTop() > $j('.header').height()) {
            $j('.menu_nav').addClass('fixed');
            $j('.header').css('margin-bottom', $j('.menu_nav').height() + 'px');
        } else {
            $j('.menu_nav').removeClass('fixed');
            $j('.header').removeAttr('style');
            $j('.info_account_scroll').hide();
        }
    });

    $j(window).load(function() {
        // setTop('.item_category_name', '.box_category_menu');
        setTop('.child_category_menu_wrapper', '.box_category_menu');
        setTop('.content-post-entry .featured-image img', '.content-post-entry .featured-image');

        if ($j(window).width() > 767 ) {
            if ( $j('.product-boxd-media').outerHeight() > $j('#product-groupd-view').outerHeight()) {
                $j('.product-essential').height($j('.product-boxd-media').outerHeight());
            }
        };

        $j(window).resize(function(){
            if ($j(window).width() > 767 ) {
                if ( $j('.product-boxd-media').outerHeight() > $j('#product-groupd-view').outerHeight()) {
                    $j('.product-essential').height($j('.product-boxd-media').outerHeight());
                }
            }else{
                $j('.product-essential').removeAttr('style');
            }
        });
    });

    $j(window).resize(function() {
        addHeights('.col_box_instruction', '.content_col_instruction', 20);
        imgAjaxLoad();
        if($j('.col_testimonial').length > 0) {
            $j('.text_testimonial').css('height', $j('.author_testimonial').height() + 'px');
        }
    });

    $j('.desc-attr-wrapper .show-more span').click(function() {
        var parent = $j(this).parent().prev().attr('class');

        if($j(this).hasClass('show-content')) {
            $j(this).toggleClass('show-content hidden-content');
            outHeight('.' + parent);
            $j(this).html('Show less...');
        } else {
            $j(this).toggleClass('show-content hidden-content');
            $j('.' + parent).css('height', '200px');
            $j(this).html('Show more...');
        }
    });

    ZoomImageProduct();

    $j('.more-gallery-views ul li').click(function() {
        var dataImage = $j(this).attr('data-image');
        $j('.gallery-image').attr('src', dataImage);

        $j('.zoomContainer').remove();

        ZoomImageProduct();
    });

    $j('.rating-links a[href*="#"]:not([href="#"])').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
            var target = $j(this.hash);
            target = target.length ? target : $j('[name=' + this.hash.slice(1) +']');
            if (target.length) {
                $j('html, body').animate({
                    scrollTop: target.offset().top
                }, 1000);
                return false;
            }
        }
    });

    $j('.label-review-customer').click(function() {
        $j(this).toggleClass('review-customer-show');
        $j(this).find('i').toggleClass('fa-angle-right fa-angle-down');
        $j(this).next().fadeToggle('fast');
    });

    if($j('.text-effect-gradient').length > 0) {
        jQuery('.text-effect-gradient').pxgradient({
            step: 10,
            colors: ["#005190","#7a36c9"],
            dir: "x"
        });
    }

    if($j('.title-category-effect').length > 0) {
        jQuery('.title-category-effect').pxgradient({
            step: 10,
            colors: ["#005190","#7a36c9"],
            dir: "x"
        });
    }

    if($j('.title-button-effect').length > 0) {
        jQuery('.title-button-effect').pxgradient({
            step: 10,
            colors: ["#005190","#7a36c9"],
            dir: "x"
        });
    }

    if($j('.amia-effect').length > 0) {
        jQuery('.amia-effect').pxgradient({
            step: 10,
            colors: ["#005190","#7a36c9"],
            dir: "x"
        });
    }

    if($j('.tab-attributes_show span.attributes-effect').length > 0) {
        jQuery('.tab-attributes_show span.attributes-effect').pxgradient({
            step: 10,
            colors: ["#005190","#7a36c9"],
            dir: "x"
        });
    }

    if($j('.col_testimonial').length > 0) {
        $j('.text_testimonial').css('height', $j('.author_testimonial').height() + 'px');
    }

    $j(document).mouseup(function (e) {
        var containerSearch = $j('.box_search_wrapper');
        var containerCart = $j('.mini_cart_header');
        var containerAccount = $j('.info_account');
        var containerAccountScroll = $j('.info_account_scroll');

        if (!containerSearch.is(e.target) && containerSearch.has(e.target).length === 0) {
            containerSearch.slideUp();
        }

        if (!containerCart.is(e.target) && containerCart.has(e.target).length === 0) {
            containerCart.slideUp();
        }

        if (!containerAccount.is(e.target) && containerAccount.has(e.target).length === 0) {
            containerAccount.slideUp();
        }

        if (!containerAccountScroll.is(e.target) && containerAccountScroll.has(e.target).length === 0) {
            containerAccountScroll.slideUp();
        }
    });

    imgAjaxLoad();

    // set max height item also_like block
    var maxHeight = 0;
    $j(window).load(function() {
        $j('#amia-also-like .col_also_like')
            .each(function() { maxHeight = Math.max(maxHeight, $j(this).height()); })
            .height(maxHeight);
    });


    $j(window).resize(function() {
        $j('#amia-also-like .col_also_like').removeAttr('style');
        var maxHeight = 0;
        setTimeout(function() {
            $j('#amia-also-like .col_also_like')
                .each(function() { maxHeight = Math.max(maxHeight, $j(this).height()); })
                .height(maxHeight);
        }, 500);
    });

    // if($j(window).width() > 580) {
    //     var a = $j('.col_box_home.first').outerWidth();
    //     var b = $j('.logo').offset().left;
    //     $j('.first .content_col_box_home').width(a - b);
    // };

    $j('.col-level.parent').click(function(){
        $j(this).children('.col-sub').slideToggle(300);
    });

    if ($j('.right_header a:first-child').hasClass('activeStore')) {
        $j('body').addClass('wholesaleTemplate');
    }

    // $j(document).on('keypress', '#billing\\:postcode', function (e) {
    //     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
    //         return false;
    //     }
    // });

    $j(document).on('keypress', '.giant-onestepcheckout-cart-table .qty-wrapper .qty-wrap', function (e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });

    $j(document).on('keypress', '#qty', function (e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });

    // $j(document).on('keypress', '#shipping\\:postcode', function (e) {
    //     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
    //         return false;
    //     }
    // });

    $j(document).on('keypress', '#zip', function (e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });

    $j(document).on('keypress', '.amia-zipcode', function (e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });
});

function imgAjaxLoad() {
    if($j('.giant-onestepcheckout-place-order-process').length > 0) {
        $j('.giant-onestepcheckout-place-order-process img').css('top', ($j(window).height() - $j('.giant-onestepcheckout-place-order-process img').height()) /2 + 'px');
    }
}

function outHeight(child) {
    var $main = $j(child),
        totalHeight = 0;

    $main.children().each(function () {
        totalHeight += $j(this).outerHeight(true);
    });

    $main.animate({height: totalHeight}, 300);
}

function ZoomImageProduct() {
    $j('.gallery-image').elevateZoom({
        borderSize: 1,
        borderColour: '#f4f4f4'
    });
}

function addHeights(parent, child, pad) {
    $j(parent).each(function() {
        $j(child).removeAttr('style');
        $j(child).css('height', ($j(this).width() - pad) + 'px');
    });
}

function clickShow(click, show, height) {
    $j(click).click(function () {
        if(jQuery(show).is(':hidden')) {
            $j(show).css('top', $j(height).height() + 'px').slideDown();
        } else {
            $j(show).slideUp();
        }
    });
}

function setTop(child, parent) {
    var top = 0;
    $j(child).each(function() {
        top = ($j(parent).height() - $j(this).height()) / 2;
        $j(this).css('top', top + 'px');
    });
}

function setHeight(child, pah) {
    var maxHeight = 0;

    $j(child).each(function() {
        $j(this).removeAttr('style');
        var height = $j(this).height();
        maxHeight = (height > maxHeight) ? height: maxHeight;
    });

    $j(child).removeAttr('style').css('height', (maxHeight + pah) + 'px');
}

(function() {
    var isBootstrapEvent = false;
    if (window.jQuery) {
        var all = jQuery('*');
        jQuery.each(['hide.bs.dropdown',
            'hide.bs.collapse',
            'hide.bs.modal',
            'hide.bs.tooltip',
            'hide.bs.popover',
            'hide.bs.tab'], function(index, eventName) {
            all.on(eventName, function( event ) {
                isBootstrapEvent = true;
            });
        });
    }
    var originalHide = Element.hide;
    Element.addMethods({
        hide: function(element) {
            if(isBootstrapEvent) {
                isBootstrapEvent = false;
                return element;
            }
            return originalHide(element);
        }
    });
})();