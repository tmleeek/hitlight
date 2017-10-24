function updateAcpSuperAttributePrice(id){
    var currentValues = new Array();
    var i = 0;
    jQuery('.super-attribute-select-acp').each(function(){
        currentValues[i] = jQuery(this).val();
        i++;
    });

    console.log(currentValues);
    for(var j in productValuesConfig){
        if(isAcpCorrectValue(currentValues, productValuesConfig[j]['values'])){
            setTimeout(function () {
                jQuery('.price-custom-'+id).html('<span class="price">'+productValuesConfig[j]['price']+'</span>');
                jQuery('#ajaxcat-product-'+id).html(productValuesConfig[j]['name']);
            },50);
            break;
        }
    }
}

function isAcpCorrectValue(needs, haystack){
    var check = true;
    for(var i=0; i<needs.length; i++){
        if(!in_array_acp(needs[i], haystack)){
            check = false;
            break;
        }
    }
    return check;
}

function in_array_acp(needle, haystack) {
    for (var key = 0; key < haystack.length; key++) {
        if (needle == haystack[key]) {
            return true;
        }
    }

    return false;
}