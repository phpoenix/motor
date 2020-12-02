define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'vehicle/index' + location.search,
                    add_url: 'vehicle/add',
                    edit_url: 'vehicle/edit',
                    del_url: 'vehicle/del',
                    multi_url: 'vehicle/multi',
                    table: 'vehicle',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'user_id', title: __('User_id')},
                        {field: 'imei', title: __('Imei')},
                        {field: 'motor', title: __('Motor')},
                        {field: 'type_id', title: __('Type_id')},
                        {field: 'registertime', title: __('Registertime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'km', title: __('Km'), operate:'BETWEEN'},
                        {field: 'digit', title: __('Digit')},
                        {field: 'booktime', title: __('Booktime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'insurancetime', title: __('Insurancetime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'license', title: __('License')},
                        {field: 'travel', title: __('Travel')},
                        {field: 'licensetime', title: __('Licensetime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'number', title: __('Number')},
                        {field: 'illegal', title: __('Illegal')},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});