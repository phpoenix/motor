define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'book/index' + location.search,
                    add_url: 'book/add',
                    edit_url: 'book/edit',
                    del_url: 'book/del',
                    multi_url: 'book/multi',
                     order_url: 'book/order',
                    table: 'book',
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
                        {field: 'category', title: __('Category')},
                        {field: 'user.username', title: __('User_id')},
                        {field: 'booktime', title: __('Booktime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'telephone', title: __('Telephone')},
                        {field: 'position', title: __('Position')},
                        {
                            field: 'status', title: __('Status'),
                            searchList: {"1": __('Status 1'),"2": __('Status 2'),"3": __('Status 3'),"4": __('Status 4')},
                            icon: "fa fa-check-square-o",
                            formatter: Table.api.formatter.normal
                        },
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        // {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                        {field: 'order',
                            width: "160px",
                            title: __('按钮组'),
                            table: table,
                            events: Table.api.events.operate,
                            buttons: [
                                {
                                    name: 'order',
                                    text: __('预约审核'), 
                                    classname: 'btn btn-xs btn-primary btn-dialog',
                                    icon: 'fa fa-list',
                                    url: 'book/order',
                                    callback: function (data) {
                                        Layer.alert("接收到回传数据：" + JSON.stringify(data), {title: "回传数据"});
                                    },
                                    visible: function (row) {
                                        //返回true时按钮显示,返回false隐藏
                                        return true;
                                    }
                                },
                            ],
                           table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate
                        }
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