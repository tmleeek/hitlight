/**
 * MagPleasure Ltd.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE-CE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.magpleasure.com/LICENSE-CE.txt
 *
 * =================================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * =================================================================
 * This package designed for Magento COMMUNITY edition
 * MagPleasure does not guarantee correct work of this extension
 * on any other Magento edition except Magento COMMUNITY edition.
 * Magpleasure does not provide extension support in case of
 * incorrect edition usage.
 * =================================================================
 *
 * @category   MagPleasure
 * @package    Magpleasure_Activecontent
 * @version    1.1.3
 * @copyright  Copyright (c) 2011-2014 MagPleasure Ltd. (http://www.magpleasure.com)
 * @license    http://www.magpleasure.com/LICENSE-CE.txt
 */

var getTrByElement = function (el, num) {
    var number = (typeof(num) !== 'undefined') ? num : 1;
    var limit = 5;

    if (el && (typeof (el.parentNode) !== 'undefined')) {
        var tr = el.parentNode;
        if (number < limit) {

            if (tr.tagName == 'TR') {
                return tr;
            } else {
                return getTrByElement(tr, number + 1);
            }
        } else {
            return false;
        }
    }
};

var showField = function (id, visible) {

    var tr = getTrByElement($(id));

    if (tr) {
        if (visible) {
            tr.style.display = '';
        } else {
            tr.style.display = 'none';
        }


    }
};

var renderFieldsState = function (fieldId, values) {

    var checked = $(fieldId).checked;
    $H(values).each(function (pair) {

        var childId = pair.key;
        var visible = pair.value;

        if (checked) {
            showField(childId, visible);
        } else {
            showField(childId, !visible);
        }
    });
};

var relativeFields = function (fields) {

    $H(fields).each(function (pair) {

        var relativeId = pair.key;
        var values = pair.value;
        if ($(relativeId)) {

            $(relativeId).observe('change', (function () {
                renderFieldsState(relativeId, values);
            }).bind(relativeId).bind(values))
            renderFieldsState(relativeId, values);
        }
    });


};