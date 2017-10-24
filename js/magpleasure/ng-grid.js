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
 * @package    Magpleasure_Common
 * @version    0.7.8
 * @copyright  Copyright (c) 2014 MagPleasure Ltd. (http://www.magpleasure.com)
 * @license    http://www.magpleasure.com/LICENSE-CE.txt
 */

//, $http, columns, views, options
var ControllerGrid = function ($scope, $http) {


    $scope.navigator = {
        page: 0,
        pages: 0,
        limit: 20,
        total: 0,
        is_first: true,
        is_last: true,

        assign: function (data, source) {
            data.page = source.page;
            data.pages = source.pages;
            data.limit = source.limit;
            data.total = source.total;
            data.is_first = source.is_first;
            data.is_last = source.is_last;
        },
        next: function () {
            this.page += 1;
            $scope.refreshGrid();
        },
        prior: function () {
            this.page -= 1;
            $scope.refreshGrid();
        },
        src_right: {
            true: 'pager_arrow_right.gif',
            false: 'pager_arrow_right_off.gif'
        },
        src_left: {
            true: 'pager_arrow_left.gif',
            false: 'pager_arrow_left_off.gif'
        },
        refresh:{

        }
    };

    $scope.selections = {
        items:[],
        count: function(){
            return this.items.length
        },
        clear: function(){
            for (var i = 0; i < this.count(); i++) {
                this.items[i].selector = '0';
            }

            items = [];
        },
        select: function(data, state){
            if (state) {
                this.items.push(data);
            } else {
                var _list = [];
                for (var i = 0; i < this.count(); i++) {
                    var $_data = this.items[i];
                    if ($_data != data) {
                        _list.push($_data);
                    }
                }
                this.items = _list;
            }
        }
    };

    $scope.sort_columns = {
        items: [],
        count: function(){
            return this.items.length
        },
        newDirection: function(column){
            var direction = column.sort_direction;
            if (column && column.can_sort==true){
                if (window.event.ctrlKey || this.count() == 0) {
                    direction = 0;
                    if (column.sort_direction == direction) {
                        direction = 1;
                    }
                }else if (direction != 0){
                    direction = 2;
                    if (column.sort_direction == direction) {
                        direction = 1;
                    }
                }
            }

            return direction;
        },

        sorting: function(column){
            var direction = this.newDirection(column);

            if (direction != column.sort_direction) {
                if (direction == 0) {
                    var _list = [];
                    for (var i = 0; i < this.count(); i++) {
                        var $col = this.items[i];
                        if ($col != column) {
                            _list.push($col);
                            $col.sort_index = _list.length;
                        } else {
                            column.sort_index = null;
                        }
                    }
                    this.items = _list;
                } else if (column.sort_direction == 0) {
                        this.items.push(column);
                        column.sort_index = this.count();
                    }
                column.sort_direction = direction;
                $scope.refreshGrid();
            }
        },

        order_by: function(){

            var $order = {};
            for (var i = 0; i < this.count(); i++) {
                var column = this.items[i];
                if (column.sort_direction > 0 && column.sort_index) {
                    $order[column.index] = column.sort_direction;
                }
            }
            return  $order;
        }

    };




    $scope.processing = false;

    $scope.records = [];

    $scope.getMaxId = function () {
        var maxId = 0;
        $scope.records.each((function (item) {
            if (item.recordNumber && item.recordNumber > maxId) {
                maxId = item.recordNumber;
            }
        }).bind(maxId));
        return maxId;
    };

    $scope.select = function (data, state) {
        this.selections.select(data, state);
    }

    $scope.modifyRecord = function (index, column, value) {
        $scope.records[index][column.index] = value;
    }

    $scope.clickColumn = function (column) {
        if (!$scope.processing)
            $scope.sort_columns.sorting(column);
    }

    $scope.doKeyUpPage = function (code) {
        if (code == 13) {
            $scope.refreshGrid();
        }
    }

    $scope.refreshGrid = function () {
        var controller = $scope.options.controller;
        var $url = controller.url;
        $url += controller.refresh + '/id/' + controller.id + '/';
        $scope.processing = true;
        var $old_data = $scope.records;
        $scope.records = [];
        var $form_data = {};
        $form_data.can_pager = $scope.options.can_pager;
        if ($scope.options.can_pager){
            $scope.navigator.assign($form_data, $scope.navigator);
        }
        $form_data.form_key = controller.form_key;
        $form_data.order_by = JSON.stringify($scope.sort_columns.order_by());
        $http.post($url, $form_data).success(function (transport) {
            $scope.records = transport.data;
            if ($scope.options.can_pager){
                $scope.navigator.assign($scope.navigator, transport.navigator);
            }

            $scope.processing = false;
        }).error(function (transport) {
                $scope.processing = false;
                $scope.data = $old_data;
            }
        );
        /*get data grid*/
    }

    $scope.appendRecord = function (data) {
        if (!data)
            var record = {};
        else {
            var record = data;
        }
        record.recordNumber = $scope.getMaxId() + 1;
        $scope.records.push(record);
    }

    $scope.delete = function(record){
        record.recordNumber = 0;
    }


    if ($scope.options.auto_load)
        $scope.refreshGrid();
}

