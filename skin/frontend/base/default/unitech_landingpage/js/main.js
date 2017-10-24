var productAddToCartForm;
toastr.options = {
    closeButton: !0,
    positionClass: "toast-bottom-right",
    timeOut: "10000"
};
jQuery(document).ready(function ($) {
    function scrollToReview() {
        var speed = 1000;
        var position = $('.product-review').offset().top;
        $("html, body").animate({scrollTop: position}, speed, "swing");
    }

    function showReviews() {
        var productID = $("#product_options").val();
        var html = reviews[productID];
        $('.product-review').show();
        $('.product-review').html(html).promise().done(function () {
            //var speed = 1000;
            //var position = $(this).offset().top;
            //$("html, body").animate({scrollTop: position}, speed, "swing");

            $("#addYourReview").click(function () {
                var error = 0;
                if ($("#product-review-table input:checked").length < 3) {
                    error = 1;
                    $(".validate-rating").addClass('validation-failed');
                    $("#advice-validate-rating-validate_rating").show();
                } else {
                    $(".validate-rating").removeClass('validation-failed');
                    $("#advice-validate-rating-validate_rating").hide();
                }

                if ($("#nickname_field").val().trim() == "")
                {
                    error = 1;
                    $("#nickname_field").addClass('validation-failed');
                    $("#advice-required-entry-nickname_field").show();
                } else {
                    $("#nickname_field").removeClass('validation-failed');
                    $("#advice-required-entry-nickname_field").hide();
                }

                if ($("#summary_field").val().trim() == "")
                {
                    error = 1;
                    $("#summary_field").addClass('validation-failed');
                    $("#advice-required-entry-summary_field").show();
                } else {
                    $("#summary_field").removeClass('validation-failed');
                    $("#advice-required-entry-summary_field").hide();
                }

                if ($("#review_field").val().trim() == "")
                {
                    error = 1;
                    $("#review_field").addClass('validation-failed');
                    $("#advice-required-entry-review_field").show();
                } else {
                    $("#review_field").removeClass('validation-failed');
                    $("#advice-required-entry-review_field").hide();
                }

                if (error != 1) {
                    $.ajax({
                        url: $("#review-form").attr('action'),
                        type: "POST",
                        data: $("#review-form").serialize(),
                        beforeSend: function () {
                            $("#addYourReview").hide();
                            $(".ajax_loading").show();
                        },
                        complete: function () {
                            $("#addYourReview").show();
                            $(".ajax_loading").hide();
                        },
                        success: function (data, textStatus, jqXHR)
                        {
                            data = $.parseJSON(data);
                            if (data) {
                                toastr.success("Your review has been accepted for moderation.");
                                $("#product-review-table input").prop('checked', false);
                                $("#nickname_field").val('');
                                $("#summary_field").val('');
                                $("#review_field").val('');
                            } else {
                                toastr.error("Unable to post the review. Please try again.");
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            toastr.error("Unable to post the review. Please try again.");
                        }
                    });
                }
            });
        });
    }
    setInterval(function () {
        $('.item1').toggleClass('light_hide');
        $('.item2').toggleClass('light_show');
    }, 4800);

    $('#buy-now > a').click(function () {
        var speed = 1000;
        var href = $(this).attr("href");
        var target = $(href == "#" || href == "" ? 'html' : href);
        var position = target.offset().top;
        $("html, body").animate({scrollTop: position}, speed, "swing");

        return false;
    });

    function init() {
        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            $('.slider-img').slick({
                dots: true,
                autoplay: true,
                autoplaySpeed: 3000,
                infinite: true,
                speed: 1000,
                slidesToShow: 3,
                slidesToScroll: 1,
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1,
                            infinite: true,
                            dots: true
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                    // You can unslick at a given breakpoint now by adding:
                    // settings: "unslick"
                    // instead of a settings object
                ]
            });

            $('.slider-img').show();
        } else {
            $('.gallery').show();
        }

        $('.emailto').click(function () {
            $('.mymodal').modal('show');
        });

        $('#qty_options').change(function () {
            $('#qty').val(this.value);
        });

        $('.product-img').click(function () {
            var productID = $("#product_options").val();
            var html = descriptionCollection[productID];
            $('.product-detail .product-detail-content').html(html).promise().done(function () {
                $('#tag2').removeClass('in active');
                $('.tab-product-detail ul li').removeClass('active');
                $('.tab-product-detail ul li').first().addClass('active');
                $('#tag1').addClass('in active');
                decorateTable('product-attribute-specs-table');

                // Initialize carousel here
                $('.slide-thumb').owlCarousel({
                    items: 3,
                    navigation: true
                });

                // Bind click image event here
                $('.product-detail-content .img-thumb-product .img-thumbnail').click(function () {
                    $('.product-detail-content .img-product img').attr('src', $(this).attr('src'));
                });
                $('.product-detail').modal('show');
            });
        });

        $('#product_options').change(function () {
            var productID = $(this).val();
            var htmlContent = products[productID];
            $('.product-review').html('');
            $('.product-review').hide();
            $('#main-content').html(htmlContent).promise().done(function () {
                $('#product_options').val(productID);

                init();

                // ajax add cart - override add to cart
                var productAddToCartForm1 = new VarienForm('product_addtocart_form');
                MST = {
                    showFancycheckout: function ()
                    {
                        $(' .top-link-cart , .top-link-checkout ').on("click", function () {
                            return false;
                        });
                        $(' .show-instant-checkout , .top-link-cart , .top-link-checkout , .skip-cart , #cart-step ').on("click", function () {
                            $('body').addClass('active-instant-checkout');
                            $('html').addClass('active-instant-checkout');
                            $('.control-overlay').show();
                            $('.offscreen #cart-step').show();
                            $('.offscreen').addClass('active');
                            $('.offscreen').removeClass('step2 step3');
                            $('.goto-shipping-step').show();
                            setTimeout(function () {
                                $('.offscreen #shipping-step').show();
                                $('.offscreen #review-step').show();
                            }, 1000);
                        });
                    },
                    checkThemMagento: function (theme) {
                        var scriptTag = document.getElementsByTagName('link');
                        var href;

                        for (var i = 0; i < scriptTag.length; i++) {
                            href = scriptTag[i].href;
                            if (href.indexOf(theme.toString()) !== -1) {
                                return true;
                                break;
                            }
                        }
                        return	false;
                    },
                    ReloadScripts: function () {
                        $('.skip-link').on('click', function (e) {
                            e.preventDefault();

                            var self = $(this);
                            var target = self.attr('href');

                            // Get target element
                            var elem = $(target);

                            // Check if stub is open
                            var isSkipContentOpen = elem.hasClass('skip-active') ? 1 : 0;

                            // Hide all stubs
                            $('.skip-link').removeClass('skip-active');
                            $('.skip-content').removeClass('skip-active');

                            // Toggle stubs
                            if (isSkipContentOpen) {
                                self.removeClass('skip-active');
                            } else {
                                self.addClass('skip-active');
                                elem.addClass('skip-active');
                            }
                        });

                        $('#header-cart').on('click', '.skip-link-close', function (e) {
                            var parent = $(this).parents('.skip-content');
                            var link = parent.siblings('.skip-link');

                            parent.removeClass('skip-active');
                            link.removeClass('skip-active');

                            e.preventDefault();
                        });
                    },
                    ReloadScriptsUltimo: function () {
                        var dMenuPosTimeout;
                        var ddOpenTimeout;
                        $("#mini-cart.dropdown").hover(function () {
                            var ddToggle = $(this).children('.dropdown-toggle');
                            var ddMenu = $(this).children('.dropdown-menu');
                            var ddWrapper = ddMenu.parent();
                            ddMenu.css("left", "");
                            ddMenu.css("right", "");
                            if ($(this).hasClass('clickable-dropdown'))
                            {
                                if ($(this).hasClass('open'))
                                {
                                    $(this).children('.dropdown-menu').stop(true, true).delay(200).fadeIn(0, "easeOutCubic");
                                }
                            }
                            else
                            {
                                clearTimeout(ddOpenTimeout);
                                ddOpenTimeout = setTimeout(function () {

                                    ddWrapper.addClass('open');

                                }, 200);

                                //$(this).addClass('open');
                                $(this).children('.dropdown-menu').stop(true, true).delay(200).fadeIn(0, "easeOutCubic");
                            }

                            clearTimeout(dMenuPosTimeout);
                            dMenuPosTimeout = setTimeout(function () {

                                if (ddMenu.offset().left < 0)
                                {
                                    var space = ddWrapper.offset().left;
                                    ddMenu.css("left", (-1) * space);
                                    ddMenu.css("right", "auto");
                                }

                            }, 200);
                        }, function () {
                            var ddMenu = $(this).children('.dropdown-menu');
                            clearTimeout(ddOpenTimeout);
                            ddMenu.stop(true, true).delay(0).fadeOut(0, "easeInCubic");
                            if (ddMenu.is(":hidden"))
                            {
                                ddMenu.hide();
                            }
                            $(this).removeClass('open');
                        });
                    },
                    updateToplink: function (topLinks) {
                        if (topLinks) {
                            if ($('.header .quick-access > ul.links').length) {
                                $('.header .quick-access > ul.links').replaceWith(topLinks);
                            }
                        }
                    },
                    minicarthead: function (block) {
                        if ($('.header-minicart').length && MST.checkThemMagento('rwd')) {
                            if (block) {
                                $('.header-minicart').empty();
                                $('.header-minicart').append(block);
                                MST.ReloadScripts();
                            }
                        }
                    },
                    buttonclickproductpage1: function () {
                        if (typeof (productAddToCartForm) != 'undefined') {
                            window.productAddToCartForm.submit = function () {
                                if (productAddToCartForm1.validator && productAddToCartForm1.validator.validate()) {
                                    url = $('#product_addtocart_form').attr('action');
                                    var validate_url1 = url.split("/updateItemOptions/");
                                    var validate_url2 = url.split("/in_cart/");
                                    if (validate_url1.length > 1)
                                    {
                                        url = url.replace("checkout/cart/updateItemOptions", "fancycheckout/instantcheckout/updateItemOptions");
                                    } else {
                                        if (validate_url2.length > 1) {
                                            url = url.replace("checkout/cart/add", "fancycheckout/instantcheckout/updateItemOptions/id/");
                                        } else {
                                            url = url.replace("checkout/cart/add", "fancycheckout/instantcheckout/add"); // New Code
                                        }
                                    }
                                    var data = $('#product_addtocart_form').serialize();
                                    data += '&isAjax=1';
                                    try {
                                        $.ajax({
                                            url: url,
                                            type: 'post',
                                            data: data,
                                            beforeSend: function () {
                                                $('body').addClass('active-instant-checkout');
                                                $('html').addClass('active-instant-checkout');
                                                $('.offscreen #cart-step').show();
                                                $('.offscreen').addClass('active');
                                                $('.offscreen').removeClass('step2 step3');
                                                $('.goto-shipping-step').show();
                                                $('.loading-product-cart').show();
                                                setTimeout(function () {
                                                    $('.offscreen #shipping-step').show();
                                                    $('.offscreen #review-step').show();
                                                }, 1000);
                                                $('.cart-step-content').css('opacity', '0.2');
                                                $('.shipping-step-content').css('opacity', '0.2');
                                                $('.review-step').css('opacity', '0.2');
                                            },
                                            success: function (data) {
                                                $('.loading_image').hide();
                                                $('.cart-step-content').css('opacity', '1');
                                                $('.shipping-step-content').css('opacity', '1');
                                                $('.review-step').css('opacity', '1');
                                                var _json = $.parseJSON(data);
                                                if (_json.status == 'ERROR')
                                                {
                                                    alert(_json.message);
                                                }
                                                $('body').addClass('active-instant-checkout');
                                                $('html').addClass('active-instant-checkout');
                                                $('.control-overlay').show();
                                                $('.offscreen #cart-step').show();
                                                $('.offscreen').addClass('active');
                                                $('.offscreen').removeClass('step2 step3');
                                                $('.cart-step-content-load').html(_json.info);

                                                setTimeout(function () {
                                                    $('.offscreen #shipping-step').show();
                                                    $('.offscreen #review-step').show();
                                                }, 1000);

                                                $('.shipping-step-content-load').html(_json.shippingaddress);
                                                $('.review-step-shipping').html(_json.shipping_method);
                                                $('.header-bottom .quick-access .header-cart#update-cart-header').html('<div class="cart-img"></div>' + _json.cart_header);
                                                $('.review-step-payment').html(_json.payment_method);
                                                $('.review-step-review').html(_json.review_order);
                                                //Update header and slidebar cart
                                                MST.updateToplink(_json.topLinks);
                                                MST.minicarthead(_json.minicarthead);
                                                if (_json.sidebar) {
                                                    if ($('.sidebar > .block-cart').length) {
                                                        $('.sidebar > .block-cart').replaceWith(_json.sidebar);
                                                    }
                                                    if ($('.header-primary #mini-cart').length && MST.checkThemMagento('ultimo')) {
                                                        $('.header-primary #mini-cart').replaceWith(_json.sidebar);
                                                        MST.ReloadScriptsUltimo();
                                                    }
                                                }
                                                MST.showFancycheckout();

                                            }
                                        });
                                    } catch (e) {
                                    }
                                }
                            }
                        }
                    },
                    buttonclickproductpage2: function () {
                        if (typeof (setLocation) != 'undefined') {
                            window.setLocation = function (url) {
                                var validate = url.split("/add/");
                                if (validate.length > 1)
                                {
                                    url += 'isAjax/1';
                                    url = url.replace("checkout/cart/add", "fancycheckout/instantcheckout/add"); // New Code
                                    data = 'isAjax=1';
                                    try {
                                        $.ajax({
                                            url: url,
                                            type: 'post',
                                            data: data,
                                            beforeSend: function () {
                                                $('body').addClass('active-instant-checkout');
                                                $('html').addClass('active-instant-checkout');
                                                $('.offscreen #cart-step').show();
                                                $('.offscreen').addClass('active');
                                                $('.offscreen').removeClass('step2 step3');
                                                $('.goto-shipping-step').show();
                                                $('.loading-product-cart').show();
                                                setTimeout(function () {
                                                    $('.offscreen #shipping-step').show();
                                                    $('.offscreen #review-step').show();
                                                }, 1000);
                                                $('.cart-step-content').css('opacity', '0.2');
                                                $('.shipping-step-content').css('opacity', '0.2');
                                                $('.review-step').css('opacity', '0.2');
                                            },
                                            success: function (data) {
                                                $('.loading_image').hide();
                                                $('.cart-step-content').css('opacity', '1');
                                                $('.shipping-step-content').css('opacity', '1');
                                                $('.review-step').css('opacity', '1');
                                                var _json = $.parseJSON(data);
                                                if (_json.status == 'ERROR')
                                                {
                                                    alert(_json.message);
                                                }
                                                $('body').addClass('active-instant-checkout');
                                                $('html').addClass('active-instant-checkout');
                                                $('.control-overlay').show();
                                                $('.offscreen #cart-step').show();
                                                $('.offscreen').addClass('active');
                                                $('.offscreen').removeClass('step2 step3');
                                                $('.cart-step-content-load').html(_json.info);
                                                setTimeout(function () {
                                                    $('.offscreen #shipping-step').show();
                                                    $('.offscreen #review-step').show();
                                                }, 1000);
                                                $('.shipping-step-content-load').html(_json.shippingaddress);
                                                $('.review-step-shipping').html(_json.shipping_method);
                                                $('.header-bottom .quick-access .header-cart#update-cart-header').html('<div class="cart-img"></div>' + _json.cart_header);
                                                $('.review-step-payment').html(_json.payment_method);
                                                $('.review-step-review').html(_json.review_order);
                                                //Update header and slidebar cart 
                                                MST.updateToplink(_json.topLinks);
                                                MST.minicarthead(_json.minicarthead);
                                                if (_json.sidebar) {
                                                    if ($('.sidebar > .block-cart').length) {
                                                        $('.sidebar > .block-cart').replaceWith(_json.sidebar);
                                                    }
                                                    if ($('.header-primary #mini-cart').length && MST.checkThemMagento('ultimo')) {
                                                        $('.header-primary #mini-cart').replaceWith(_json.sidebar);
                                                        MST.ReloadScriptsUltimo();
                                                    }
                                                }
                                                MST.showFancycheckout();

                                            }
                                        });
                                    } catch (e) {
                                    }
                                } else {
                                    window.location.replace(url);
                                }
                            }
                        }
                    }
                };
                MST.buttonclickproductpage1();
                MST.buttonclickproductpage2();
                //ajax shipping step 
                $('.goto-shipping-step').bind('click', function () {
                    var data = $('#product_addtocart_form').serialize();
                    data += '&isAjax=1';
                    url = $('#mst-address-request').val() + 'fancycheckout/instantcheckout/stepshipping';
                    $.ajax({
                        url: url,
                        type: 'post',
                        data: data,
                        beforeSend: function () {
                            $('.loading-product-cart').show();
                            $('.cart-step-content').css('opacity', '0.2');
                        },
                        success: function (data) {
                            //ken
                            $('.loading_image').hide();
                            $('.cart-step-content').css('opacity', '1');
                            var _json = $.parseJSON(data);
                            $('.shipping-step-content-load').html(_json.shippingaddress);
                            //david
                            $('.offscreen').removeClass('step3');
                            $('.offscreen').addClass('step2');
                            $('.goto-shipping-step').hide();
                            $('.goto-review-step').show();
                        }
                    });
                });
            });
            showReviews();
        });

        $(".showReviews").on('click', function () {
            //showReviews();
            scrollToReview();
        });


        productAddToCartForm = new VarienForm('product_addtocart_form');
        productAddToCartForm.submit = function (button, url) {
            if (this.validator.validate()) {
                var form = this.form;
                var oldUrl = form.action;

                if (url) {
                    form.action = url;
                }
                var e = null;
                try {
                    this.form.submit();
                } catch (e) {
                }
                this.form.action = oldUrl;
                if (e) {
                    throw e;
                }

                if (button && button != 'undefined') {
                    button.disabled = true;
                }
            }
        }.bind(productAddToCartForm);

        productAddToCartForm.submitLight = function (button, url) {
            if (this.validator) {
                var nv = Validation.methods;
                delete Validation.methods['required-entry'];
                delete Validation.methods['validate-one-required'];
                delete Validation.methods['validate-one-required-by-name'];
                // Remove custom datetime validators
                for (var methodName in Validation.methods) {
                    if (methodName.match(/^validate-datetime-.*/i)) {
                        delete Validation.methods[methodName];
                    }
                }

                if (this.validator.validate()) {
                    if (url) {
                        this.form.action = url;
                    }
                    this.form.submit();
                }
                Object.extend(Validation.methods, nv);
            }
        }.bind(productAddToCartForm);

    }

    init();
    showReviews();
});
	