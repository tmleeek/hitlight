var AW_AjaxCartProUpdaterObject = new AW_AjaxCartProUpdater('topLinks', null, ['.shop_icon .fa-shopping-cart>', '.items-shopping-cart']);

Object.extend(AW_AjaxCartProUpdaterObject, {
    updateOnUpdateRequest: true,
    updateOnActionRequest: false,

    beforeUpdate: function(html){
        return null;
    },
    afterUpdate: function(html, selectors){
        return null;
    }
});


AW_AjaxCartPro.registerUpdater(AW_AjaxCartProUpdaterObject);

delete AW_AjaxCartProUpdaterObject;