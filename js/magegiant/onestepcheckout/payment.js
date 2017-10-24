MagegiantOnestepcheckoutPayment = Class.create();
MagegiantOnestepcheckoutPayment.prototype = {
    initialize: function (config) {
        this.container = $$(config.containerSelector).first();
        this.wrapContainer = $$(config.wrapContainerSelector).first();
        this.switchMethodInputs = $$(config.switchMethodInputsSelector);
        this.methodAdditionalContainerIdPrefix = config.methodAdditionalContainerIdPrefix;
        this.savePaymentUrl = config.savePaymentUrl;
        this.storedData = {};

        this.cvv = {};
        this.cvv.tooltip = $$(config.cvv.tooltipSelector).first();
        this.cvv.closeEl = $$(config.cvv.closeElSelector).first();
        this.cvv.triggerEls = $$(config.cvv.triggerElsSelector);

        if (navigator.userAgent.indexOf("MSIE 8.0") == -1) {
            this.initMock();
            this.init();
            this.initObservers();
        } else {
            var me = this;
            Event.observe(window, 'load', function (e) {
                me.initMock();
                me.init();
                me.initObservers();
            });
        }
    },

    initMock: function () {
        window.payment = window.payment || {};
        window.payment.switchMethod = Prototype.emptyFunction;

        //paypal payment advanced support
        window.checkout = {
            setLoadWaiting: Prototype.emptyFunction,
            accordion: {
                container: {
                    readAttribute: Prototype.emptyFunction
                }
            },
            steps: [],
            gotoSection: Prototype.emptyFunction
        };
        var checkoutReviewBtn = new Element('div', {'id': 'checkout-review-submit', 'style': 'display:none'});
        var iframeWaiting = new Element('div', {'id': 'iframe-warning', 'style': 'display:none'});
        window.document.body.appendChild(checkoutReviewBtn);
        window.document.body.appendChild(iframeWaiting);
    },

    init: function () {
        var me = this;
        this.switchMethodInputs.each(function (element) {
            var methodCode = element.value;
            var additionalInfoContainer = $(me.methodAdditionalContainerIdPrefix + methodCode);
            if (additionalInfoContainer) {
                additionalInfoContainer.setStyle({'overflow': 'hidden', 'display': 'none'})
            }
            if (element.checked) {
                me.showAdditionalInfo(methodCode);
                me.currentMethod = methodCode;
            } else {
                me.hideAdditionalInfo(methodCode);
            }
        });
    },

    initObservers: function () {
        var me = this;
        //CVV
        this.cvv.triggerEls.each(function (element) {
            element.observe('click', me.onTooltipTriggerElClick.bind(me));
        });
        if (this.cvv.closeEl) {
            this.cvv.closeEl.observe('click', me.onTooltipTriggerElClick.bind(me));
        }

        //method changed
        this.switchMethodInputs.each(function (element) {
            element.observe('click', function (e) {
                me.switchToMethod(element.value);
            });
            var block = me.methodAdditionalContainerIdPrefix + element.value;
            [block + '_before', block, block + '_after'].each(function (elementId) {
                var element = $(elementId);
                if (!element) {
                    return;
                }
                Form.getElements(element).each(function (formElement) {
                    formElement.observe('change', function (e) {
                        me.savePayment();
                        Validation.reset(formElement);
                    });
                });
            });
        });

        //on block update
        var me = this;
        if (!this.wrapContainer.addActionBlocksToQueueAfterFn) {
            this.wrapContainer.addActionBlocksToQueueAfterFn = function () {
                me.storedData = {};
                Form.getElements(me.wrapContainer).each(function (element) {
                    var elementId = element.getAttribute('id');
                    if (elementId) {
                        me.storedData[elementId] = element.getValue();
                    }
                });
            }
        }
        if (!this.wrapContainer.removeActionBlocksFromQueueAfterFn) {
            this.wrapContainer.removeActionBlocksFromQueueAfterFn = function () {
                Form.getElements(me.wrapContainer).each(function (element) {
                    var elementId = element.getAttribute('id');
                    if (elementId in me.storedData) {
                        element.setValue(me.storedData[elementId]);
                    }
                });
                me.storedData = {};
            }
        }
    },

    onTooltipTriggerElClick: function (e) {
        if (this.cvv.tooltip) {
            this.cvv.tooltip.setStyle({
                top: (Event.pointerY(e) - 560) + 'px'
            });
            this.cvv.tooltip.toggle();
        }
        e.stop();
    },

    switchToMethod: function (methodCode) {
        var prefix = this.methodAdditionalContainerIdPrefix;
        if (this.currentMethod !== methodCode) {
            if (this.currentMethod && $(prefix + this.currentMethod)) {
                this.hideAdditionalInfo(this.currentMethod);
                $(prefix + this.currentMethod).fire('payment-method:switched-off', {method_code: this.currentMethod});
            }
            if ($(prefix + methodCode)) {
                this.showAdditionalInfo(methodCode);
                $(prefix + methodCode).fire('payment-method:switched', {method_code: methodCode});
            } else {
                //Event fix for payment methods without form like "Check / Money order"
                document.body.fire('payment-method:switched', {method_code: methodCode});
            }
            this.currentMethod = methodCode;
            this.savePayment();
        }
    },

    showAdditionalInfo: function (methodCode) {
        var me = this;
        var block = this.methodAdditionalContainerIdPrefix + methodCode;
        [block + '_before', block, block + '_after'].each(function (el) {
            var element = $(el);
            if (element) {
                //apply show effect
                element.setStyle({'display': '', height: '0px'});
                var newHeight = MagegiantOnestepcheckoutCore.getElementHeight(element);
                me._applyEffect(element, newHeight, 0.5, function () {
                    element.setStyle({'height': ''});
                });

                //enable elements
                element.select('input', 'select', 'textarea', 'button').each(function (field) {
                    field.disabled = false;
                });
            }
        });
    },

    hideAdditionalInfo: function (methodCode) {
        var me = this;
        var block = this.methodAdditionalContainerIdPrefix + methodCode;
        [block + '_before', block, block + '_after'].each(function (el) {
            var element = $(el);
            if (element) {
                //apply hide effect
                me._applyEffect(element, 0, 0.5, function () {
                    element.setStyle({'display': 'none'});
                });

                //disable elements
                element.select('input', 'select', 'textarea', 'button').each(function (field) {
                    field.disabled = true;
                });
            }
        });
    },

    savePayment: function () {
        var me = this;
        var isValid = true;
        var block = this.methodAdditionalContainerIdPrefix + this.currentMethod;
        [block + '_before', block, block + '_after'].each(function (el) {
            var element = $(el);
            if (!element) {
                return;
            }
            //validation
            Form.getElements(element).each(function (vElm) {
                var cn = $w(vElm.className);
                isValid = isValid && cn.all(function (name) {
                    var v = Validation.get(name);
                    try {
                        if (Validation.isVisible(vElm) && !v.test($F(vElm), vElm)) {
                            return false;
                        } else {
                            return true;
                        }
                    } catch (e) {
                        return true;
                    }
                });
            })
        });
        if (!isValid) {
            return;
        }
        window.payment.currentMethod = this.currentMethod;
        MagegiantOnestepcheckoutCore.updater.startRequest(this.savePaymentUrl, {
            method: 'post',
            parameters: Form.serialize(this.container, true)
        });
    },

    _applyEffect: function (element, newHeight, duration, afterFinish) {
        if (element.effect) {
            element.effect.cancel();
        }
        var afterFinishFn = afterFinish || Prototype.emptyFunction;
        element.effect = new Effect.Morph(element, {
            style: {
                'height': newHeight + 'px'
            },
            duration: duration,
            afterFinish: function () {
                delete element.effect;
                afterFinishFn();
            }
        });
    }
};
MagegiantOnestepcheckoutPaymentGiantPoints = Class.create();
MagegiantOnestepcheckoutPaymentGiantPoints.prototype = {
    initialize: function (config) {
        this.containerSelector = $$(config.containerSelector).first();
        this.sliderContainer = $$(config.silderContainer).first();
        this.usePointCheckbox = $(config.usePointCheckbox);
        // init urls
        this.applyPointsUrl = config.applyPointsUrl;
        this.initObserver();
    },
    initObserver: function () {
        if (this.usePointCheckbox) {
            this.usePointCheckbox.observe('change', this.applyPoints.bind(this));
        }
    },
    applyPoints: function () {
        var me = this;
        if (this.usePointCheckbox.checked) {
            this.showSliderPoint();
        }
        else {
            this.hideSliderPoint();
        }
        var params = Form.serializeElements(this.containerSelector.select('input, select, textarea'));
        var requestOptions = {
            method: 'post',
            parameters: params,
            postBody: params,
        };
        MagegiantOnestepcheckoutCore.updater.startRequest(this.applyPointsUrl, requestOptions);
    },
    showSliderPoint: function () {
        var me = this;
        var newHeight = MagegiantOnestepcheckoutCore.getElementHeight(this.sliderContainer);
        this.sliderContainer.setStyle({'display': ''});
        this._applyEffect(this.sliderContainer, newHeight, 0.01, function () {
            me.sliderContainer.setStyle({'height': ''});
        });
    },
    hideSliderPoint: function () {
        var me = this;
        this._applyEffect(me.sliderContainer, 0, 0.1, function () {
            me.sliderContainer.setStyle({'display': 'none'});
        });
    },
    _applyEffect: function (element, newHeight, duration, afterFinish) {
        if (element.effect) {
            element.effect.cancel();
        }
        var afterFinishFn = afterFinish || Prototype.emptyFunction;
        element.effect = new Effect.Morph(element, {
            style: {
                'height': newHeight + 'px'
            },
            duration: duration,
            afterFinish: function () {
                delete element.effect;
                afterFinishFn();
            }
        });
    },
};