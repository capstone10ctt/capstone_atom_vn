<?php echo $header; ?>
<head>
<style>
    /* Layout 3 columns with equal width */
    #content {
        width: 100%;
    }

    .table_electricity, .table_water, .table_garbage {
        width: 33.33333%;
        height: 20em;
        float: left;
    }
    /*======================================*/

    /* Layout 2 buttons in com-button-panel */
    .com-button-panel {
        margin-right: 5em;
    }

    .com-button-panel input[type="button"] {
        float: right;

    }
    /*=======================================*/

    /* Layout 2 buttons in com-button-panel */
    .com-action-button-panel {
        margin-right: 5em;
    }

    .com-action-button-panel input[type="button"] {
        float: right;
    }
    /*=======================================*/

    /* Layout 2 buttons in com-edit-button-panel */
    .com-edit-button-panel {
        display: inline;
        margin-left: 1em;
    }
    /*=======================================*/

    /* Set width values for 3 tables */
    .electricity_standard_price, .water_standard_price, {
        width: 85%;
    }
    /*=======================================*/

    /* Hide elements of .table_electricity */
    .electricity_content {
        display: none;
    }

    #btnAddElectricity {
        display: none;
    }
    /*=======================================*/

    h2 {
        color: #0000ff;
    }

    h3 {
        color: orangered;
    }

    img:hover {
        cursor: hand;
    }

    input[type=text]:focus, textarea:focus {
        box-shadow: 0 0 5px rgba(81, 203, 238, 1);
        padding: 3px 0px 3px 3px;
        margin: 5px 1px 3px 0px;
        border: 1px solid rgba(81, 203, 238, 1);
    }

    input[type=text] {
        -webkit-transition: all 0.30s ease-in-out;
        -moz-transition: all 0.30s ease-in-out;
        -ms-transition: all 0.30s ease-in-out;
        -o-transition: all 0.30s ease-in-out;
        outline: none;
        padding: 3px 0px 3px 3px;
        margin: 5px 1px 3px 0px;
        border: 1px solid #DDDDDD;
    }

    .invalid {
        border: 1px solid #CB000F;
        color: red
    }

    .valid {
        color: #000000;
    }

    .dlg-no-title .ui-dialog-titlebar {
        display: none;
    }

    #header {
        text-align: center;
        color: cornflowerblue;
    }

    .new-link {
        text-align: center;
    }
</style>

<script type="text/javascript" src="view/javascript/jquery.blockUI.js"></script>
<script type="text/javascript" src="view/javascript/datepicker-vi.js"></script>
<script type="text/javascript">
    $(document).ajaxStop($.unblockUI);
    $(function() {
        // set Vietnamese language for datepicker
        $.datepicker.setDefaults($.datepicker.regional['vi']);

        // format number: convert 1234 -> 1,234
        Number.prototype.format = function(n, x) {
            var re = '(\\d)(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
            return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$1,');
        };

        // outerHTML technique
        jQuery.fn.outerHTML = function(s) {
            return s
                    ? this.before(s).remove()
                    : jQuery("<p>").append(this.eq(0).clone()).html();
        };

        var jsonElectricityNew = {};
        var jsonWaterNew = {};
        var jsonGarbageNew = {};

        var idNewestElectricity = 0;
        var idNewestWater = 0;
        var idNewestGarbage = 0;

        var electricityLatestUpdateDate;
        var electricityUpdateDateFrom;

        var waterLatestUpdateDate;
        var waterUpdateDateFrom;

        var garbageLatestUpdateDate;
        var garbageUpdateDateFrom;

        //==============================================================================================================
        // ELECTRICITY
        //==============================================================================================================
        function displayElectricityContent() {
            var current = new Date();
            var currentDate = new Date(current.getFullYear(), current.getMonth() + 1, current.getDay());
            // unblock Waiting icon....
            $('div.table_electricity').unblock();
            // display the content of .electricity_content element
            $('.electricity_content').show();
            // hide information line
            $('.electricity_content').find('p').show();
            // display Sửa & Xóa button
            $('.electricity_content').find('.com-edit-button-panel').hide();
            // hide Xác nhận & Hủy button
            $('#update-electricity-standard').find('.com-action-button-panel').show();
            // add content to #update-electricity-standard
            $('#from-date-electricity').val($.datepicker.formatDate('M, yy', currentDate));
            // auto setup first data line for each table
            //  electricity
            var $tbody_electricity = $('#update-electricity-standard').find('tbody');
            $tbody_electricity.append('<tr class="line">' +
                    '<td class="from"><input type="text" style="width: 74px;" disabled="true" value="0"/></td>' +
                    '<td class="to"><input type="text" style="width: 74px;" /></td>' +
                    '<td class="price"><input type="text" style="width: 74px;" /></td>' +
                    '<td class="remove"></td>' +
                    '</tr>' +
                    '<tr class="dummy-line">' +
                    '<td class="from" style="display: none;"><input style="width: 74px;" disabled="true" /></td>' +
                    '<td class="to" style="display: none;"><input style="width: 74px;" /></td>' +
                    '<td class="price" style="display: none;"><input style="width: 74px;" /></td>' +
                    '<td class="remove" style="display: none;"><img src="view/image/price/delete.png" height="16" width="16" /></td>' +
                    '</tr>' +
                    '<tr class="plus">' +
                    '<td><img src="view/image/price/add.png" height="16" width="16" /></td>' +
                    '<td></td>' +
                    '<td></td>' +
                    '<td></td>' +
                    '</tr>');
        }

        // get latest update date
        $('div.table_electricity').block({
            message: '<h3><span><img src="view/image/price/preloader.gif" height="16" width="16" /></span> Đang xử lý...</h3>',
            css: { width: '15em' }
        });
        $.ajax({
            url: 'index.php?route=price/edit/getLatestElectricityUpdateDate&token=<?php echo $token; ?>',
            dateType: 'json',
            type: 'post',
            success: function(json) {
                var obj = $.parseJSON(json);
                electricityLatestUpdateDate = new Date(obj['year'], obj['month'] - 1, 1);
                var currentDate = new Date();
                idNewestElectricity = obj['id'];
                if (electricityLatestUpdateDate > currentDate) {
                    $.ajax({
                        url: 'index.php?route=price/edit/loadElectricityStandardPrice&token=<?php echo $token; ?>',
                        data: { 'id' : idNewestElectricity },
                        dataType: 'json',
                        type: 'post',
                        success: function(json) {
                            // unblock Waiting icon....
                            $('div.table_electricity').unblock();
                            // hide Thêm button
                            $('#btnAddElectricity').hide();
                            // display the content of .electricity_content element
                            $('.electricity_content').show();
                            // replace content of #from-date-electricity with latest update date
                            $('#from-date-electricity').hide();
                            $('#from-date-electricity').after('<span class="input-date">' + $.datepicker.formatDate('M, yy', electricityLatestUpdateDate) + '</span>');
                            // hide information line
                            $('.electricity_content').find('p').hide();
                            // display Sửa & Xóa button
                            $('.electricity_content').find('.com-edit-button-panel').show();
                            // hide Xác nhận & Hủy button
                            $('#update-electricity-standard').find('.com-action-button-panel').hide();
                            // add content to #update-electricity-standard
                            var $edit = $('#update-electricity-standard').find('tbody');
                            // delete all current lines in the table
                            $edit.empty();
                            // loop all elements in a list of objects
                            for (var index in json['data']) {
                                var price = parseInt(json['data'][index]['Price']);
                                var to = json['data'][index]['To'];
                                if (to == -1) {
                                    to = '';
                                }
                                // add new lines represent the standard price corresponding to the inputted date
                                $edit.append('<tr class="line">' +
                                        '<td class="from">' + json['data'][index]['From'] + '</td>' +
                                        '<td class="to">' + to + '</td>' +
                                        '<td class="price">' + price.format() + '&nbsp₫</td>' + // format function: convert 1234 -> 1,234
                                        '</tr>');
                            }
                        }, // for debugging purpose
                        error: function(xhr) {
                            console.log(xhr);
                        }
                    });
                } else {
                    displayElectricityContent();
                }
            },
            error: function(xhr) {
                console.log(xhr);
            }
        });

        $('#update-electricity-standard').find('tbody').focusout(function(e) { // e: event object
            var $this = $(e.target).closest('.line'); // e.target points to the focus-lost element
            var $from = $this.children('.from').children();
            var $to = $this.children('.to').children();
            var $price = $this.children('.price').children();
            var to = $to.val();
            var from = $from.val();
            var price = $price.val();
            var isLastRow = $this.parent().is(':last-child');
            if (to == -1 && isLastRow) {

            } else if (to && parseInt(to) <= parseInt(from)) {
                alert ('Giá trị cột Đến kW phải lớn giá trị cột Từ kW');
                $to.focus().select();
            } else if (to && (!$.isNumeric(to) || parseInt(to) < 0)) {
                alert('Giá trị nhập vào không hợp lệ');
                $to.focus().select();
            } else if (price && (!$.isNumeric(price) || parseInt(price) < 0)) {
                alert('Giá trị nhập vào không hợp lệ');
                $price.focus().select();
            } else {
                // change value of From in the next row. From = (last row's To) + 1
                var $next = $this.next();
                if ($next) {
                    $next.children('.from').children().val(parseInt(to));
                }
            }
        });

        $('#update-electricity-standard').on('click', '.plus', function() {
            var $toCell = $('#update-electricity-standard').find('.line').last().children('.to').children();
            var $priceCell = $('#update-electricity-standard').find('.line').last().children('.price').children();
            var to = parseInt($toCell.val());
            var price = $priceCell.val();
            if (!to || !price) {
                alert('Bạn phải nhập giá trị cho dòng đầu tiên trước khi thêm dòng mới');
            } else if (to == -1) {
                alert('Bạn phải nhập giá trị khác -1 cho cột Đến kW/người dòng cuối cùng trước khi thêm dòng mới')
            } else {
                // select dummy-line
                $dummy = $('#update-electricity-standard').find('.dummy-line');
                // add a new dummy-line after the default dummy-line, change the default dummy-line into a `line` and make all its children visible
                // the new dummy-line become the default dummy-line
                $dummy.after($dummy.outerHTML()).removeClass("dummy-line").addClass("line")
                        .children().show() // show newly added row
                        .end().children('.from').children().val(to);
            }
        });

        $('#update-electricity-standard').on('click', '.remove', function() {
            var $this = $(this);
            console.log($this);
            if ($this.parent().is(':first-child')) {
                alert('Không thể xóa dòng này!');
            } else {
                // the number of elements inside obj object
                var $prevRow = $this.parent().prev().children('.to').children();
                var $nextRow = $this.parent().next().children('.from').children();
                $nextRow.val(parseInt($prevRow.val()));
                $this.parent().remove();
            }
        });

        $('#update-electricity-standard').on('click', '.btnCancel', function() {
            $('#dialog-confirm-cancellation-electricity').dialog('open');
        });

        $('#dialog-confirm-cancellation-electricity').dialog({
            autoOpen: false,
            draggable: false,
            resizable: false,
            position: 'center',
            modal: true,
            show: true,
            minHeight: 'auto', // auto expand height
            minWidth: 'auto',
            buttons: {
                "Chấp nhận": function() {
                    $('#from-date-electricity').val($.datepicker.formatDate('M, yy', electricityLatestUpdateDate));
                    var $tbody_electricity = $('#update-electricity-standard').find('tbody');
                    $tbody_electricity.empty();
                    $tbody_electricity.append('<tr class="line">' +
                            '<td class="from"><input type="text" style="width: 74px;" disabled="true" value="0"/></td>' +
                            '<td class="to"><input type="text" style="width: 74px;" /></td>' +
                            '<td class="price"><input type="text" style="width: 74px;" /></td>' +
                            '<td class="remove"></td>' +
                            '</tr>' +
                            '<tr class="dummy-line">' +
                            '<td class="from" style="display: none;"><input style="width: 74px;" disabled="true" /></td>' +
                            '<td class="to" style="display: none;"><input style="width: 74px;" /></td>' +
                            '<td class="price" style="display: none;"><input style="width: 74px;" /></td>' +
                            '<td class="remove" style="display: none;"><img src="view/image/price/delete.png" height="16" width="16" /></td>' +
                            '</tr>' +
                            '<tr class="plus">' +
                            '<td><img src="view/image/price/add.png" height="16" width="16" /></td>' +
                            '<td></td>' +
                            '<td></td>' +
                            '<td></td>' +
                            '</tr>');
                    $(this).dialog('close');
                },
                "Không chấp nhận": function() {
                    $( this ).dialog( "close" );
                }
            }
        });

        $('#update-electricity-standard').on('click', '.btnConfirm', function() {
            var $this = $(this);
            // check that all cells are inputted
            var checkFill = true;
            $('#update-electricity-standard input').each(function(i, e) {
                if ($(e).parent().parent().hasClass('line') && $(e).val() == '') {
                    checkFill = false;
                    return false;
                }
            });
            var $lastRow = $('#update-electricity-standard').find('.line').last();
            var to = $lastRow.children('.to').children().val();
            var price = $lastRow.children('.price').children().val();
            var currentDate = new Date();
            // In order to submit data, the last row must satisfy 2 conditions:
            // - To = -1
            // - There is no empty cell in the table
            if (currentDate < electricityUpdateDateFrom) {
                if (to == -1 && checkFill) {
                    jsonElectricityNew.electricity_new = {};
                    $('#update-electricity-standard').find('.line').each(function(index, element) {
                        jsonElectricityNew.electricity_new[index] = {};
                        jsonElectricityNew.electricity_new[index].from = $(element).children('.from').children().val();
                        jsonElectricityNew.electricity_new[index].to = $(element).children('.to').children().val();
                        jsonElectricityNew.electricity_new[index].price = $(element).children('.price').children().val();
                    });
                    var day = electricityUpdateDateFrom.getDate();
                    var month = electricityUpdateDateFrom.getMonth() + 1;
                    var year = electricityUpdateDateFrom.getFullYear();
                    var updateDate = year + '-' + month + '-' + day;
                    var prevDate = electricityUpdateDateFrom;
                    prevDate.setDate(0);
                    day = prevDate.getDate();
                    month = prevDate.getMonth() + 1;
                    year = prevDate.getFullYear();
                    var endDate = year + '-' + month + '-' + day;
                    $.ajax({
                        url: 'index.php?route=price/edit/loadNewestElectricityStandardPriceId&token=<?php echo $token; ?>',
                        dataType: 'json',
                        type: 'post',
                        success: function(json) {
                            idNewestElectricity = json['id'];
                            $.ajax({
                                url: 'index.php?route=price/edit/updateElectricityStandardPrice&token=<?php echo $token; ?>',
                                data: {
                                    'electricity_new_data': jsonElectricityNew,
                                    'update_date_from': updateDate,
                                    'old_end_date': endDate,
                                    'id': idNewestElectricity
                                },
                                dataType: 'json',
                                type: 'post',
                                success: function(json) {
                                    var arr = jsonElectricityNew.electricity_new;
                                    var $edit = $('#update-electricity-standard').find('tbody');
                                    // clear current content
                                    $('#update-electricity-standard')
                                            .find('p').hide()
                                            .end()
                                            .find('.com-action-button-panel').hide();
                                    $edit.empty();
                                    // update new content
                                    $('.table_electricity').find('.com-edit-button-panel')
                                            .css('display', 'inline')
                                            .show();
                                    $('#from-date-electricity')
                                            .before('<span class="input-date">' + $('#from-date-electricity').val() + '</span>')
                                            .hide();
                                    for (var index in arr) {
                                        var price = parseInt(arr[index].price);
                                        var to = parseInt(arr[index].to);
                                        if (to == -1) {
                                            to = '';
                                        }
                                        $edit.append('<tr class="line">' +
                                                '<td class="from">' + arr[index].from + '</td>' +
                                                '<td class="to">' + to + '</td>' +
                                                '<td class="price">' + price.format() + '&nbsp₫</td>' +
                                                '</tr>');
                                    }
                                    // replace edit element with display element

                                }, // for debugging purpose
                                error: function(xhr) {
                                    console.log(xhr);
                                }
                            });
                        },
                        error: function(xhr) {
                            console.log(xhr);
                        }
                    });
                } else {
                    alert('Bạn chưa nhập đủ dữ liệu');

                }
            } else {
                alert('Thời điểm bắt đầu phải sau ' + $.datepicker.formatDate('M, yy', currentDate));
            }
        });

        $('.table_electricity').find('.btnDelete').on('click', function() {
            $('#dialog-delete-current-standard-price-electricity').dialog('open');
        });

        $('.table_electricity').find('.btnEdit').on('click', function() {
            var $tbody = $('#update-electricity-standard').find('tbody');
            $tbody.empty();
            $('div.table_electricity').block({
                message: '<h3><span><img src="view/image/price/preloader.gif" height="16" width="16" /></span> Đang lấy dữ liệu...</h3>',
                css: { width: '15em' }
            });
            $.ajax({
                url: 'index.php?route=price/edit/getLatestElectricityUpdateDate&token=<?php echo $token; ?>',
                dataType: 'json',
                type: 'post',
                success: function(json) {
                    // Get latest update date
                    electricityLatestUpdateDate = new Date(json['year'], json['month'] - 1, 1);
                    idNewestElectricity = json['id'];
                    $.ajax({
                        url: 'index.php?route=price/edit/loadNewestElectricityStandardPrice&token=<?php echo $token; ?>',
                        dataType: 'json',
                        type: 'post',
                        success: function(json) {
                            // unblock Waiting icon....
                            $('div.table_electricity').unblock();
                            // open dialog after loading data successfully
                            for (var index in json['newest']) {
                                var to = json['newest'][index]['To'];
                                if (index == 0) {
                                    $tbody.append('<tr class="line">' +
                                            '<td class="from"><input type="text" style="width: 74px;" disabled="true" value="' + json['newest'][index]['From'] + '"/></td>' +
                                            '<td class="to"><input type="text" style="width: 74px;" value="' + to + '"/></td>' +
                                            '<td class="price"><input type="text" style="width: 74px;" value="' + json['newest'][index]['Price'] + '"/></td>' +
                                            '<td class="remove"></td>' +
                                            '</tr>');
                                } else {
                                    $tbody.append('<tr class="line">' +
                                            '<td class="from"><input type="text" style="width: 74px;" disabled="true" value="' + json['newest'][index]['From'] + '"/></td>' +
                                            '<td class="to"><input type="text" style="width: 74px;" value="' + to + '"/></td>' +
                                            '<td class="price"><input type="text" style="width: 74px;" value="' + json['newest'][index]['Price'] + '"/></td>' +
                                            '<td class="remove"><img src="view/image/price/delete.png" height="16" width="16" /></td>' +
                                            '</tr>');
                                }
                            }
                            $tbody.append('' +
                                    '<tr class="dummy-line">' +
                                    '<td class="from" style="display: none;"><input style="width: 74px;" disabled="true" /></td>' +
                                    '<td class="to" style="display: none;"><input style="width: 74px;" /></td>' +
                                    '<td class="price" style="display: none;"><input style="width: 74px;" /></td>' +
                                    '<td class="remove" style="display: none;"><img src="view/image/price/delete.png" height="16" width="16" /></td>' +
                                    '</tr>' +
                                    '<tr class="plus">' +
                                    '<td><img src="view/image/price/add.png" height="16" width="16" /></td>' +
                                    '<td></td>' +
                                    '<td></td>' +
                                    '<td></td>' +
                                    '</tr>');
                            $('.table_electricity').find('.input-date').remove();
                            $('.table_electricity').find('.com-edit-button-panel').hide();
                            $('#from-date-electricity').val($.datepicker.formatDate('M, yy', electricityLatestUpdateDate));
                            $('#from-date-electricity').show();
                            $('#update-electricity-standard')
                                    .find('p').show()
                                    .end()
                                    .find('.com-action-button-panel').show();
                        },
                        error: function(xhr) {
                            console.log(xhr);
                        }
                    });
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });
        });

        $('#dialog-delete-current-standard-price-electricity').dialog({
            autoOpen: false,
            draggable: false,
            resizable: false,
            position: 'center',
            modal: true,
            show: true,
            minHeight: 'auto', // auto expand height
            minWidth: 'auto',
            buttons: {
                "Đồng ý": function() {
                    console.log(idNewestElectricity);
                    $.ajax({
                        url: 'index.php?route=price/edit/loadNewestElectricityStandardPriceId&token=<?php echo $token; ?>',
                        dataType: 'json',
                        type: 'post',
                        success: function(json) {
                            idNewestElectricity = json['id'];
                            console.log(idNewestElectricity);
                            $.ajax({
                                url: 'index.php?route=price/edit/deleteCurrentElectricityStandardPrice&token=<?php echo $token; ?>',
                                data: { 'id': idNewestElectricity },
                                dataType: 'json',
                                type: 'post',
                                success: function(json) {
                                    var current = new Date();
                                    var currentDate = new Date(current.getFullYear(), current.getMonth() + 1, current.getDay());
                                    // unblock Waiting icon....
                                    $('div.table_electricity').unblock();
                                    // display the content of .electricity_content element
                                    $('.electricity_content').show();
                                    // hide information line
                                    $('.electricity_content').find('p').show();
                                    // display Sửa & Xóa button
                                    $('.electricity_content').find('.com-edit-button-panel').hide();
                                    // hide Xác nhận & Hủy button
                                    $('#update-electricity-standard').find('.com-action-button-panel').show();
                                    // clear tbody's content of #update-electricity-standard
                                    $('#update-electricity-standard').find('tbody').empty();
                                    // show datepicker input
                                    $('.input-date').remove();
                                    $('#from-date-electricity').val($.datepicker.formatDate('M, yy', electricityLatestUpdateDate));
                                    $('#from-date-electricity').show();
                                    // auto setup first data line for each table
                                    //  electricity
                                    var $tbody_electricity = $('#update-electricity-standard').find('tbody');
                                    $tbody_electricity.append('<tr class="line">' +
                                            '<td class="from"><input type="text" style="width: 74px;" disabled="true" value="0"/></td>' +
                                            '<td class="to"><input type="text" style="width: 74px;" /></td>' +
                                            '<td class="price"><input type="text" style="width: 74px;" /></td>' +
                                            '<td class="remove"></td>' +
                                            '</tr>' +
                                            '<tr class="dummy-line">' +
                                            '<td class="from" style="display: none;"><input style="width: 74px;" disabled="true" /></td>' +
                                            '<td class="to" style="display: none;"><input style="width: 74px;" /></td>' +
                                            '<td class="price" style="display: none;"><input style="width: 74px;" /></td>' +
                                            '<td class="remove" style="display: none;"><img src="view/image/price/delete.png" height="16" width="16" /></td>' +
                                            '</tr>' +
                                            '<tr class="plus">' +
                                            '<td><img src="view/image/price/add.png" height="16" width="16" /></td>' +
                                            '<td></td>' +
                                            '<td></td>' +
                                            '<td></td>' +
                                            '</tr>');
                                },
                                error: function(xhr) {
                                    console.log(xhr);
                                }
                            });
                        },
                        error: function(xhr) {
                            console.log(xhr);
                        }
                    });
                    $(this).dialog('close');
                },
                "Hủy bỏ": function() {
                    $(this).dialog('close');
                }
            }
        });

        var temp = new Date();
        electricityUpdateDateFrom = new Date(temp.getFullYear(), temp.getMonth() + 1, 1);

        $('#from-date-electricity').datepicker({
            dateFormat: 'M yy',
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            onClose: function(selectedDate) {
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                electricityUpdateDateFrom = new Date(year, month, 1);
                var currentDate = new Date();
                if (electricityUpdateDateFrom >= currentDate) {
                    $(this).val($.datepicker.formatDate('M, yy', electricityUpdateDateFrom));
                } else {
                    alert('Thời điểm bắt đầu phải sau ' + $.datepicker.formatDate('M, yy', currentDate));
                }
            }
        });

        $('#from-date-electricity').focus(function() {
            $(".ui-datepicker-calendar").hide();
            $("#ui-datepicker-div").position({
                my: "center top",
                at: "center bottom",
                of: $(this)
            });
        });

        $('#btnAddElectricity').on('click', function() {
            $(this).remove();
            $('.electricity_content').show();
        });

        $('#btnCurrentStandardPrice').click(function() {
            window.location.href="index.php?route=price/edit&token=<?php echo $token; ?>"
        });

        $('#btnHistoryStandardPrice').click(function() {
            window.location.href = "index.php?route=price/edit/historyStandardPriceView&token=<?php echo $token; ?>";
        });

        //==============================================================================================================
        // WATER
        //==============================================================================================================
        function displayWaterContent() {
            var current = new Date();
            var currentDate = new Date(current.getFullYear(), current.getMonth() + 1, current.getDay());
            // unblock Waiting icon....
            $('div.table_water').unblock();
            // display the content of .water_content element
            $('.water_content').show();
            // hide information line
            $('.water_content').find('p').show();
            // display Sửa & Xóa button
            $('.water_content').find('.com-edit-button-panel').hide();
            // hide Xác nhận & Hủy button
            $('#update-water-standard').find('.com-action-button-panel').show();
            // add content to #update-water-standard
            $('#from-date-water').val($.datepicker.formatDate('M, yy', currentDate));
            // auto setup first data line for each table
            //  water
            var $tbody_water = $('#update-water-standard').find('tbody');
            $tbody_water.append('<tr class="line">' +
                    '<td class="from"><input type="text" style="width: 74px;" disabled="true" value="0"/></td>' +
                    '<td class="to"><input type="text" style="width: 74px;" /></td>' +
                    '<td class="price"><input type="text" style="width: 74px;" /></td>' +
                    '<td class="remove"></td>' +
                    '</tr>' +
                    '<tr class="dummy-line">' +
                    '<td class="from" style="display: none;"><input style="width: 74px;" disabled="true" /></td>' +
                    '<td class="to" style="display: none;"><input style="width: 74px;" /></td>' +
                    '<td class="price" style="display: none;"><input style="width: 74px;" /></td>' +
                    '<td class="remove" style="display: none;"><img src="view/image/price/delete.png" height="16" width="16" /></td>' +
                    '</tr>' +
                    '<tr class="plus">' +
                    '<td><img src="view/image/price/add.png" height="16" width="16" /></td>' +
                    '<td></td>' +
                    '<td></td>' +
                    '<td></td>' +
                    '</tr>');
        }

        // get latest update date
        $('div.table_water').block({
            message: '<h3><span><img src="view/image/price/preloader.gif" height="16" width="16" /></span> Đang xử lý...</h3>',
            css: { width: '15em' }
        });
        $.ajax({
            url: 'index.php?route=price/edit/getLatestWaterUpdateDate&token=<?php echo $token; ?>',
            dateType: 'json',
            type: 'post',
            success: function(json) {
                var obj = $.parseJSON(json);
                waterLatestUpdateDate = new Date(obj['year'], obj['month'] - 1, 1);
                var currentDate = new Date();
                idNewestWater = obj['id'];
                if (waterLatestUpdateDate > currentDate) {
                    $.ajax({
                        url: 'index.php?route=price/edit/loadWaterStandardPrice&token=<?php echo $token; ?>',
                        data: { 'id' : idNewestWater },
                        dataType: 'json',
                        type: 'post',
                        success: function(json) {
                            // unblock Waiting icon....
                            $('div.table_water').unblock();
                            // hide Thêm button
                            $('#btnAddWater').hide();
                            // display the content of .water_content element
                            $('.water_content').show();
                            // replace content of #from-date-water with latest update date
                            $('#from-date-water').hide();
                            $('#from-date-water').after('<span class="input-date">' + $.datepicker.formatDate('M, yy', waterLatestUpdateDate) + '</span>');
                            // hide information line
                            $('.water_content').find('p').hide();
                            // display Sửa & Xóa button
                            $('.water_content').find('.com-edit-button-panel').show();
                            // hide Xác nhận & Hủy button
                            $('#update-water-standard').find('.com-action-button-panel').hide();
                            // add content to #update-water-standard
                            var $edit = $('#update-water-standard').find('tbody');
                            // delete all current lines in the table
                            $edit.empty();
                            // loop all elements in a list of objects
                            for (var index in json['data']) {
                                var price = parseInt(json['data'][index]['Price']);
                                var to = json['data'][index]['To'];
                                if (to == -1) {
                                    to = '';
                                }
                                // add new lines represent the standard price corresponding to the inputted date
                                $edit.append('<tr class="line">' +
                                        '<td class="from">' + json['data'][index]['From'] + '</td>' +
                                        '<td class="to">' + to + '</td>' +
                                        '<td class="price">' + price.format() + '&nbsp₫</td>' + // format function: convert 1234 -> 1,234
                                        '</tr>');
                            }
                        }, // for debugging purpose
                        error: function(xhr) {
                            console.log(xhr);
                        }
                    });
                } else {
                    displayWaterContent();
                }
            },
            error: function(xhr) {
                console.log(xhr);
            }
        });

        $('#update-water-standard').find('tbody').focusout(function(e) { // e: event object
            var $this = $(e.target).closest('.line'); // e.target points to the focus-lost element
            var $from = $this.children('.from').children();
            var $to = $this.children('.to').children();
            var $price = $this.children('.price').children();
            var to = $to.val();
            var from = $from.val();
            var price = $price.val();
            var isLastRow = $this.parent().is(':last-child');
            if (to == -1 && isLastRow) {

            } else if (to && parseInt(to) <= parseInt(from)) {
                alert ('Giá trị cột Đến kW phải lớn giá trị cột Từ kW');
                $to.focus().select();
            } else if (to && (!$.isNumeric(to) || parseInt(to) < 0)) {
                alert('Giá trị nhập vào không hợp lệ');
                $to.focus().select();
            } else if (price && (!$.isNumeric(price) || parseInt(price) < 0)) {
                alert('Giá trị nhập vào không hợp lệ');
                $price.focus().select();
            } else {
                // change value of From in the next row. From = (last row's To) + 1
                var $next = $this.next();
                if ($next) {
                    $next.children('.from').children().val(parseInt(to));
                }
            }
        });

        $('#update-water-standard').on('click', '.plus', function() {
            var $toCell = $('#update-water-standard').find('.line').last().children('.to').children();
            var $priceCell = $('#update-water-standard').find('.line').last().children('.price').children();
            var to = parseInt($toCell.val());
            var price = $priceCell.val();
            if (!to || !price) {
                alert('Bạn phải nhập giá trị cho dòng đầu tiên trước khi thêm dòng mới');
            } else if (to == -1) {
                alert('Bạn phải nhập giá trị khác -1 cho cột Đến kW/người dòng cuối cùng trước khi thêm dòng mới')
            } else {
                // select dummy-line
                $dummy = $('#update-water-standard').find('.dummy-line');
                // add a new dummy-line after the default dummy-line, change the default dummy-line into a `line` and make all its children visible
                // the new dummy-line become the default dummy-line
                $dummy.after($dummy.outerHTML()).removeClass("dummy-line").addClass("line")
                        .children().show() // show newly added row
                        .end().children('.from').children().val(to);
            }
        });

        $('#update-water-standard').on('click', '.remove', function() {
            var $this = $(this);
            console.log($this);
            if ($this.parent().is(':first-child')) {
                alert('Không thể xóa dòng này!');
            } else {
                // the number of elements inside obj object
                var $prevRow = $this.parent().prev().children('.to').children();
                var $nextRow = $this.parent().next().children('.from').children();
                $nextRow.val(parseInt($prevRow.val()));
                $this.parent().remove();
            }
        });

        $('#update-water-standard').on('click', '.btnCancel', function() {
            $('#dialog-confirm-cancellation-water').dialog('open');
        });

        $('#dialog-confirm-cancellation-water').dialog({
            autoOpen: false,
            draggable: false,
            resizable: false,
            position: 'center',
            modal: true,
            show: true,
            minHeight: 'auto', // auto expand height
            minWidth: 'auto',
            buttons: {
                "Chấp nhận": function() {
                    $('#from-date-water').val($.datepicker.formatDate('M, yy', waterLatestUpdateDate));
                    var $tbody_water = $('#update-water-standard').find('tbody');
                    $tbody_water.empty();
                    $tbody_water.append('<tr class="line">' +
                            '<td class="from"><input type="text" style="width: 74px;" disabled="true" value="0"/></td>' +
                            '<td class="to"><input type="text" style="width: 74px;" /></td>' +
                            '<td class="price"><input type="text" style="width: 74px;" /></td>' +
                            '<td class="remove"></td>' +
                            '</tr>' +
                            '<tr class="dummy-line">' +
                            '<td class="from" style="display: none;"><input style="width: 74px;" disabled="true" /></td>' +
                            '<td class="to" style="display: none;"><input style="width: 74px;" /></td>' +
                            '<td class="price" style="display: none;"><input style="width: 74px;" /></td>' +
                            '<td class="remove" style="display: none;"><img src="view/image/price/delete.png" height="16" width="16" /></td>' +
                            '</tr>' +
                            '<tr class="plus">' +
                            '<td><img src="view/image/price/add.png" height="16" width="16" /></td>' +
                            '<td></td>' +
                            '<td></td>' +
                            '<td></td>' +
                            '</tr>');
                    $(this).dialog('close');
                },
                "Không chấp nhận": function() {
                    $( this ).dialog( "close" );
                }
            }
        });

        $('#update-water-standard').on('click', '.btnConfirm', function() {
            var $this = $(this);
            // check that all cells are inputted
            var checkFill = true;
            $('#update-water-standard input').each(function(i, e) {
                if ($(e).parent().parent().hasClass('line') && $(e).val() == '') {
                    checkFill = false;
                    return false;
                }
            });
            var $lastRow = $('#update-water-standard').find('.line').last();
            var to = $lastRow.children('.to').children().val();
            var price = $lastRow.children('.price').children().val();
            var currentDate = new Date();
            // In order to submit data, the last row must satisfy 2 conditions:
            // - To = -1
            // - There is no empty cell in the table
            if (currentDate < waterUpdateDateFrom) {
                if (to == -1 && checkFill) {
                    jsonWaterNew.water_new = {};
                    $('#update-water-standard').find('.line').each(function(index, element) {
                        jsonWaterNew.water_new[index] = {};
                        jsonWaterNew.water_new[index].from = $(element).children('.from').children().val();
                        jsonWaterNew.water_new[index].to = $(element).children('.to').children().val();
                        jsonWaterNew.water_new[index].price = $(element).children('.price').children().val();
                    });
                    var day = waterUpdateDateFrom.getDate();
                    var month = waterUpdateDateFrom.getMonth() + 1;
                    var year = waterUpdateDateFrom.getFullYear();
                    var updateDate = year + '-' + month + '-' + day;
                    var prevDate = waterUpdateDateFrom;
                    prevDate.setDate(0);
                    day = prevDate.getDate();
                    month = prevDate.getMonth() + 1;
                    year = prevDate.getFullYear();
                    var endDate = year + '-' + month + '-' + day;
                    $.ajax({
                        url: 'index.php?route=price/edit/loadNewestWaterStandardPriceId&token=<?php echo $token; ?>',
                        dataType: 'json',
                        type: 'post',
                        success: function(json) {
                            idNewestWater = json['id'];
                            $.ajax({
                                url: 'index.php?route=price/edit/updateWaterStandardPrice&token=<?php echo $token; ?>',
                                data: {
                                    'water_new_data': jsonWaterNew,
                                    'update_date_from': updateDate,
                                    'old_end_date': endDate,
                                    'id': idNewestWater
                                },
                                dataType: 'json',
                                type: 'post',
                                success: function(json) {
                                    var arr = jsonWaterNew.water_new;
                                    var $edit = $('#update-water-standard').find('tbody');
                                    // clear current content
                                    $('#update-water-standard')
                                            .find('p').hide()
                                            .end()
                                            .find('.com-action-button-panel').hide();
                                    $edit.empty();
                                    // update new content
                                    $('.table_water').find('.com-edit-button-panel')
                                            .css('display', 'inline')
                                            .show();
                                    $('#from-date-water')
                                            .before('<span class="input-date">' + $('#from-date-water').val() + '</span>')
                                            .hide();
                                    for (var index in arr) {
                                        var price = parseInt(arr[index].price);
                                        var to = parseInt(arr[index].to);
                                        if (to == -1) {
                                            to = '';
                                        }
                                        $edit.append('<tr class="line">' +
                                                '<td class="from">' + arr[index].from + '</td>' +
                                                '<td class="to">' + to + '</td>' +
                                                '<td class="price">' + price.format() + '&nbsp₫</td>' +
                                                '</tr>');
                                    }
                                    // replace edit element with display element

                                }, // for debugging purpose
                                error: function(xhr) {
                                    console.log(xhr);
                                }
                            });
                        },
                        error: function(xhr) {
                            console.log(xhr);
                        }
                    });
                } else {
                    alert('Bạn chưa nhập đủ dữ liệu');

                }
            } else {
                alert('Thời điểm bắt đầu phải sau ' + $.datepicker.formatDate('M, yy', currentDate));
            }
        });

        $('.table_water').find('.btnDelete').on('click', function() {
            $('#dialog-delete-current-standard-price-water').dialog('open');
        });

        $('.table_water').find('.btnEdit').on('click', function() {
            var $tbody = $('#update-water-standard').find('tbody');
            $tbody.empty();
            $('div.table_water').block({
                message: '<h3><span><img src="view/image/price/preloader.gif" height="16" width="16" /></span> Đang lấy dữ liệu...</h3>',
                css: { width: '15em' }
            });
            $.ajax({
                url: 'index.php?route=price/edit/getLatestWaterUpdateDate&token=<?php echo $token; ?>',
                dataType: 'json',
                type: 'post',
                success: function(json) {
                    // Get latest update date
                    waterLatestUpdateDate = new Date(json['year'], json['month'] - 1, 1);
                    idNewestWater = json['id'];
                    $.ajax({
                        url: 'index.php?route=price/edit/loadNewestWaterStandardPrice&token=<?php echo $token; ?>',
                        dataType: 'json',
                        type: 'post',
                        success: function(json) {
                            // unblock Waiting icon....
                            $('div.table_water').unblock();
                            // open dialog after loading data successfully
                            for (var index in json['newest']) {
                                var to = json['newest'][index]['To'];
                                if (index == 0) {
                                    $tbody.append('<tr class="line">' +
                                            '<td class="from"><input type="text" style="width: 74px;" disabled="true" value="' + json['newest'][index]['From'] + '"/></td>' +
                                            '<td class="to"><input type="text" style="width: 74px;" value="' + to + '"/></td>' +
                                            '<td class="price"><input type="text" style="width: 74px;" value="' + json['newest'][index]['Price'] + '"/></td>' +
                                            '<td class="remove"></td>' +
                                            '</tr>');
                                } else {
                                    $tbody.append('<tr class="line">' +
                                            '<td class="from"><input type="text" style="width: 74px;" disabled="true" value="' + json['newest'][index]['From'] + '"/></td>' +
                                            '<td class="to"><input type="text" style="width: 74px;" value="' + to + '"/></td>' +
                                            '<td class="price"><input type="text" style="width: 74px;" value="' + json['newest'][index]['Price'] + '"/></td>' +
                                            '<td class="remove"><img src="view/image/price/delete.png" height="16" width="16" /></td>' +
                                            '</tr>');
                                }
                            }
                            $tbody.append('' +
                                    '<tr class="dummy-line">' +
                                    '<td class="from" style="display: none;"><input style="width: 74px;" disabled="true" /></td>' +
                                    '<td class="to" style="display: none;"><input style="width: 74px;" /></td>' +
                                    '<td class="price" style="display: none;"><input style="width: 74px;" /></td>' +
                                    '<td class="remove" style="display: none;"><img src="view/image/price/delete.png" height="16" width="16" /></td>' +
                                    '</tr>' +
                                    '<tr class="plus">' +
                                    '<td><img src="view/image/price/add.png" height="16" width="16" /></td>' +
                                    '<td></td>' +
                                    '<td></td>' +
                                    '<td></td>' +
                                    '</tr>');
                            $('.table_water').find('.input-date').remove();
                            $('.table_water').find('.com-edit-button-panel').hide();
                            $('#from-date-water').val($.datepicker.formatDate('M, yy', waterLatestUpdateDate));
                            $('#from-date-water').show();
                            $('#update-water-standard')
                                    .find('p').show()
                                    .end()
                                    .find('.com-action-button-panel').show();
                        },
                        error: function(xhr) {
                            console.log(xhr);
                        }
                    });
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });
        });

        $('#dialog-delete-current-standard-price-water').dialog({
            autoOpen: false,
            draggable: false,
            resizable: false,
            position: 'center',
            modal: true,
            show: true,
            minHeight: 'auto', // auto expand height
            minWidth: 'auto',
            buttons: {
                "Đồng ý": function() {
                    console.log(idNewestWater);
                    $.ajax({
                        url: 'index.php?route=price/edit/loadNewestWaterStandardPriceId&token=<?php echo $token; ?>',
                        dataType: 'json',
                        type: 'post',
                        success: function(json) {
                            idNewestWater = json['id'];
                            console.log(idNewestWater);
                            $.ajax({
                                url: 'index.php?route=price/edit/deleteCurrentWaterStandardPrice&token=<?php echo $token; ?>',
                                data: { 'id': idNewestWater },
                                dataType: 'json',
                                type: 'post',
                                success: function(json) {
                                    var current = new Date();
                                    var currentDate = new Date(current.getFullYear(), current.getMonth() + 1, current.getDay());
                                    // unblock Waiting icon....
                                    $('div.table_water').unblock();
                                    // display the content of .water_content element
                                    $('.water_content').show();
                                    // hide information line
                                    $('.water_content').find('p').show();
                                    // display Sửa & Xóa button
                                    $('.water_content').find('.com-edit-button-panel').hide();
                                    // hide Xác nhận & Hủy button
                                    $('#update-water-standard').find('.com-action-button-panel').show();
                                    // clear tbody's content of #update-water-standard
                                    $('#update-water-standard').find('tbody').empty();
                                    // show datepicker input
                                    $('.input-date').remove();
                                    $('#from-date-water').val($.datepicker.formatDate('M, yy', waterLatestUpdateDate));
                                    $('#from-date-water').show();
                                    // auto setup first data line for each table
                                    //  water
                                    var $tbody_water = $('#update-water-standard').find('tbody');
                                    $tbody_water.append('<tr class="line">' +
                                            '<td class="from"><input type="text" style="width: 74px;" disabled="true" value="0"/></td>' +
                                            '<td class="to"><input type="text" style="width: 74px;" /></td>' +
                                            '<td class="price"><input type="text" style="width: 74px;" /></td>' +
                                            '<td class="remove"></td>' +
                                            '</tr>' +
                                            '<tr class="dummy-line">' +
                                            '<td class="from" style="display: none;"><input style="width: 74px;" disabled="true" /></td>' +
                                            '<td class="to" style="display: none;"><input style="width: 74px;" /></td>' +
                                            '<td class="price" style="display: none;"><input style="width: 74px;" /></td>' +
                                            '<td class="remove" style="display: none;"><img src="view/image/price/delete.png" height="16" width="16" /></td>' +
                                            '</tr>' +
                                            '<tr class="plus">' +
                                            '<td><img src="view/image/price/add.png" height="16" width="16" /></td>' +
                                            '<td></td>' +
                                            '<td></td>' +
                                            '<td></td>' +
                                            '</tr>');
                                },
                                error: function(xhr) {
                                    console.log(xhr);
                                }
                            });
                        },
                        error: function(xhr) {
                            console.log(xhr);
                        }
                    });
                    $(this).dialog('close');
                },
                "Hủy bỏ": function() {
                    $(this).dialog('close');
                }
            }
        });

        var temp = new Date();
        waterUpdateDateFrom = new Date(temp.getFullYear(), temp.getMonth() + 1, 1);

        $('#from-date-water').datepicker({
            dateFormat: 'M yy',
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            onClose: function(selectedDate) {
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                waterUpdateDateFrom = new Date(year, month, 1);
                var currentDate = new Date();
                if (waterUpdateDateFrom >= currentDate) {
                    $(this).val($.datepicker.formatDate('M, yy', waterUpdateDateFrom));
                } else {
                    alert('Thời điểm bắt đầu phải sau ' + $.datepicker.formatDate('M, yy', currentDate));
                }
            }
        });

        $('#from-date-water').focus(function() {
            $(".ui-datepicker-calendar").hide();
            $("#ui-datepicker-div").position({
                my: "center top",
                at: "center bottom",
                of: $(this)
            });
        });

        $('#btnAddWater').on('click', function() {
            $(this).remove();
            $('.water_content').show();
        });

        //==============================================================================================================
        // GARBAGE
        //==============================================================================================================
        function displayGarbageContent() {
            var current = new Date();
            var currentDate = new Date(current.getFullYear(), current.getMonth() + 1, current.getDay());
            // unblock Waiting icon....
            $('div.table_garbage').unblock();
            // display the content of .garbage_content element
            $('.garbage_content').show();
            // hide information line
            $('.garbage_content').find('p').show();
            // display Sửa & Xóa button
            $('.garbage_content').find('.com-edit-button-panel').hide();
            // hide Xác nhận & Hủy button
            $('#update-garbage-standard').find('.com-action-button-panel').show();
            // add content to #update-garbage-standard
            $('#from-date-garbage').val($.datepicker.formatDate('M, yy', currentDate));
            // auto setup first data line for each table
            //  garbage
            var $tbody_garbage = $('#update-garbage-standard').find('tbody');
            $tbody_garbage.append('<tr class="line">' +
                    '<td class="price"><input type="text" style="width: 74px;" /></td>' +
                    '</tr>');
        }

        // get latest update date
        $('div.table_garbage').block({
            message: '<h3><span><img src="view/image/price/preloader.gif" height="16" width="16" /></span> Đang xử lý...</h3>',
            css: { width: '15em' }
        });
        $.ajax({
            url: 'index.php?route=price/edit/getLatestGarbageUpdateDate&token=<?php echo $token; ?>',
            dateType: 'json',
            type: 'post',
            success: function(json) {
                var obj = $.parseJSON(json);
                garbageLatestUpdateDate = new Date(obj['year'], obj['month'] - 1, 1);
                var currentDate = new Date();
                idNewestGarbage = obj['id'];
                if (garbageLatestUpdateDate > currentDate) {
                    $.ajax({
                        url: 'index.php?route=price/edit/loadGarbageStandardPrice&token=<?php echo $token; ?>',
                        data: { 'id' : idNewestGarbage },
                        dataType: 'json',
                        type: 'post',
                        success: function(json) {
                            // unblock Waiting icon....
                            $('div.table_garbage').unblock();
                            // hide Thêm button
                            $('#btnAddGarbage').hide();
                            // display the content of .garbage_content element
                            $('.garbage_content').show();
                            // replace content of #from-date-garbage with latest update date
                            $('#from-date-garbage').hide();
                            $('#from-date-garbage').after('<span class="input-date">' + $.datepicker.formatDate('M, yy', garbageLatestUpdateDate) + '</span>');
                            // hide information line
                            $('.garbage_content').find('p').hide();
                            // display Sửa & Xóa button
                            $('.garbage_content').find('.com-edit-button-panel').show();
                            // hide Xác nhận & Hủy button
                            $('#update-garbage-standard').find('.com-action-button-panel').hide();
                            // add content to #update-garbage-standard
                            var $edit = $('#update-garbage-standard').find('tbody');
                            // delete all current lines in the table
                            $edit.empty();
                            // loop all elements in a list of objects
                            for (var index in json['data']) {
                                var price = parseInt(json['data'][index]['Price']);
                                // add new lines represent the standard price corresponding to the inputted date
                                $edit.append('<tr class="line">' +
                                        '<td class="price">' + price.format() + '&nbsp₫</td>' + // format function: convert 1234 -> 1,234
                                        '</tr>');
                            }
                        }, // for debugging purpose
                        error: function(xhr) {
                            console.log(xhr);
                        }
                    });
                } else {
                    displayGarbageContent();
                }
            },
            error: function(xhr) {
                console.log(xhr);
            }
        });

        $('#update-garbage-standard').find('tbody').focusout(function(e) { // e: event object
            var $this = $(e.target).closest('.line'); // e.target points to the focus-lost element
            var $from = $this.children('.from').children();
            var $to = $this.children('.to').children();
            var $price = $this.children('.price').children();
            var to = $to.val();
            var from = $from.val();
            var price = $price.val();
            var isLastRow = $this.parent().is(':last-child');

            if (price && (!$.isNumeric(price) || parseInt(price) < 0)) {
                alert('Giá trị nhập vào không hợp lệ');
                $price.focus().select();
            }
        });

        $('#update-garbage-standard').on('click', '.plus', function() {
            var $toCell = $('#update-garbage-standard').find('.line').last().children('.to').children();
            var $priceCell = $('#update-garbage-standard').find('.line').last().children('.price').children();
            var to = parseInt($toCell.val());
            var price = $priceCell.val();
            if (!to || !price) {
                alert('Bạn phải nhập giá trị cho dòng đầu tiên trước khi thêm dòng mới');
            } else if (to == -1) {
                alert('Bạn phải nhập giá trị khác -1 cho cột Đến kW/người dòng cuối cùng trước khi thêm dòng mới')
            } else {
                // select dummy-line
                $dummy = $('#update-garbage-standard').find('.dummy-line');
                // add a new dummy-line after the default dummy-line, change the default dummy-line into a `line` and make all its children visible
                // the new dummy-line become the default dummy-line
                $dummy.after($dummy.outerHTML()).removeClass("dummy-line").addClass("line")
                        .children().show() // show newly added row
                        .end().children('.from').children().val(to);
            }
        });

        $('#update-garbage-standard').on('click', '.btnCancel', function() {
            $('#dialog-confirm-cancellation-garbage').dialog('open');
        });

        $('#dialog-confirm-cancellation-garbage').dialog({
            autoOpen: false,
            draggable: false,
            resizable: false,
            position: 'center',
            modal: true,
            show: true,
            minHeight: 'auto', // auto expand height
            minWidth: 'auto',
            buttons: {
                "Chấp nhận": function() {
                    $('#from-date-garbage').val($.datepicker.formatDate('M, yy', garbageLatestUpdateDate));
                    var $tbody_garbage = $('#update-garbage-standard').find('tbody');
                    $tbody_garbage.empty();
                    $tbody_garbage.append('<tr class="line">' +
                            '<td class="price"><input type="text" style="width: 74px;" /></td>' +
                            '</tr>');
                    $(this).dialog('close');
                },
                "Không chấp nhận": function() {
                    $( this ).dialog( "close" );
                }
            }
        });

        $('#update-garbage-standard').on('click', '.btnConfirm', function() {
            var $this = $(this);
            // check that all cells are inputted
            var checkFill = true;
            $('#update-garbage-standard input').each(function(i, e) {
                if ($(e).parent().parent().hasClass('line') && $(e).val() == '') {
                    checkFill = false;
                    return false;
                }
            });
            var $lastRow = $('#update-garbage-standard').find('.line').last();
            var to = $lastRow.children('.to').children().val();
            var price = $lastRow.children('.price').children().val();
            var currentDate = new Date();
            // In order to submit data, the last row must satisfy 2 conditions:
            // - To = -1
            // - There is no empty cell in the table
            if (currentDate < garbageUpdateDateFrom) {
                if (to == -1 && checkFill) {
                    jsonGarbageNew.garbage_new = {};
                    $('#update-garbage-standard').find('.line').each(function(index, element) {
                        jsonGarbageNew.garbage_new[index] = {};
                        jsonGarbageNew.garbage_new[index].price = $(element).children('.price').children().val();
                    });
                    var day = garbageUpdateDateFrom.getDate();
                    var month = garbageUpdateDateFrom.getMonth() + 1;
                    var year = garbageUpdateDateFrom.getFullYear();
                    var updateDate = year + '-' + month + '-' + day;
                    var prevDate = garbageUpdateDateFrom;
                    prevDate.setDate(0);
                    day = prevDate.getDate();
                    month = prevDate.getMonth() + 1;
                    year = prevDate.getFullYear();
                    var endDate = year + '-' + month + '-' + day;
                    $.ajax({
                        url: 'index.php?route=price/edit/loadNewestGarbageStandardPriceId&token=<?php echo $token; ?>',
                        dataType: 'json',
                        type: 'post',
                        success: function(json) {
                            idNewestGarbage = json['id'];
                            $.ajax({
                                url: 'index.php?route=price/edit/updateGarbageStandardPrice&token=<?php echo $token; ?>',
                                data: {
                                    'garbage_new_data': jsonGarbageNew,
                                    'update_date_from': updateDate,
                                    'old_end_date': endDate,
                                    'id': idNewestGarbage
                                },
                                dataType: 'json',
                                type: 'post',
                                success: function(json) {
                                    var arr = jsonGarbageNew.garbage_new;
                                    var $edit = $('#update-garbage-standard').find('tbody');
                                    // clear current content
                                    $('#update-garbage-standard')
                                            .find('p').hide()
                                            .end()
                                            .find('.com-action-button-panel').hide();
                                    $edit.empty();
                                    // update new content
                                    $('.table_garbage').find('.com-edit-button-panel')
                                            .css('display', 'inline')
                                            .show();
                                    $('#from-date-garbage')
                                            .before('<span class="input-date">' + $('#from-date-garbage').val() + '</span>')
                                            .hide();
                                    for (var index in arr) {
                                        var price = parseInt(arr[index].price);
                                        $edit.append('<tr class="line">' +
                                                '<td class="price">' + price.format() + '&nbsp₫</td>' +
                                                '</tr>');
                                    }
                                    // replace edit element with display element

                                }, // for debugging purpose
                                error: function(xhr) {
                                    console.log(xhr);
                                }
                            });
                        },
                        error: function(xhr) {
                            console.log(xhr);
                        }
                    });
                } else {
                    alert('Bạn chưa nhập đủ dữ liệu');

                }
            } else {
                alert('Thời điểm bắt đầu phải sau ' + $.datepicker.formatDate('M, yy', currentDate));
            }
        });

        $('.table_garbage').find('.btnDelete').on('click', function() {
            $('#dialog-delete-current-standard-price-garbage').dialog('open');
        });

        $('.table_garbage').find('.btnEdit').on('click', function() {
            var $tbody = $('#update-garbage-standard').find('tbody');
            $tbody.empty();
            $('div.table_garbage').block({
                message: '<h3><span><img src="view/image/price/preloader.gif" height="16" width="16" /></span> Đang lấy dữ liệu...</h3>',
                css: { width: '15em' }
            });
            $.ajax({
                url: 'index.php?route=price/edit/getLatestGarbageUpdateDate&token=<?php echo $token; ?>',
                dataType: 'json',
                type: 'post',
                success: function(json) {
                    // Get latest update date
                    garbageLatestUpdateDate = new Date(json['year'], json['month'] - 1, 1);
                    idNewestGarbage = json['id'];
                    $.ajax({
                        url: 'index.php?route=price/edit/loadNewestGarbageStandardPrice&token=<?php echo $token; ?>',
                        dataType: 'json',
                        type: 'post',
                        success: function(json) {
                            // unblock Waiting icon....
                            $('div.table_garbage').unblock();
                            // open dialog after loading data successfully
                            for (var index in json['newest']) {
                                var to = json['newest'][index]['To'];
                                if (index == 0) {
                                    $tbody.append('<tr class="line">' +
                                            '<td class="price"><input type="text" style="width: 74px;" value="' + json['newest'][index]['Price'] + '"/></td>' +
                                            '</tr>');
                                } else {
                                    $tbody.append('<tr class="line">' +
                                            '<td class="price"><input type="text" style="width: 74px;" value="' + json['newest'][index]['Price'] + '"/></td>' +
                                            '</tr>');
                                }
                            }
                            $('.table_garbage').find('.input-date').remove();
                            $('.table_garbage').find('.com-edit-button-panel').hide();
                            $('#from-date-garbage').val($.datepicker.formatDate('M, yy', garbageLatestUpdateDate));
                            $('#from-date-garbage').show();
                            $('#update-garbage-standard')
                                    .find('p').show()
                                    .end()
                                    .find('.com-action-button-panel').show();
                        },
                        error: function(xhr) {
                            console.log(xhr);
                        }
                    });
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });
        });

        $('#dialog-delete-current-standard-price-garbage').dialog({
            autoOpen: false,
            draggable: false,
            resizable: false,
            position: 'center',
            modal: true,
            show: true,
            minHeight: 'auto', // auto expand height
            minWidth: 'auto',
            buttons: {
                "Đồng ý": function() {
                    console.log(idNewestGarbage);
                    $.ajax({
                        url: 'index.php?route=price/edit/loadNewestGarbageStandardPriceId&token=<?php echo $token; ?>',
                        dataType: 'json',
                        type: 'post',
                        success: function(json) {
                            idNewestGarbage = json['id'];
                            console.log(idNewestGarbage);
                            $.ajax({
                                url: 'index.php?route=price/edit/deleteCurrentGarbageStandardPrice&token=<?php echo $token; ?>',
                                data: { 'id': idNewestGarbage },
                                dataType: 'json',
                                type: 'post',
                                success: function(json) {
                                    var current = new Date();
                                    var currentDate = new Date(current.getFullYear(), current.getMonth() + 1, current.getDay());
                                    // unblock Waiting icon....
                                    $('div.table_garbage').unblock();
                                    // display the content of .garbage_content element
                                    $('.garbage_content').show();
                                    // hide information line
                                    $('.garbage_content').find('p').show();
                                    // display Sửa & Xóa button
                                    $('.garbage_content').find('.com-edit-button-panel').hide();
                                    // hide Xác nhận & Hủy button
                                    $('#update-garbage-standard').find('.com-action-button-panel').show();
                                    // clear tbody's content of #update-garbage-standard
                                    $('#update-garbage-standard').find('tbody').empty();
                                    // show datepicker input
                                    $('.input-date').remove();
                                    $('#from-date-garbage').val($.datepicker.formatDate('M, yy', garbageLatestUpdateDate));
                                    $('#from-date-garbage').show();
                                },
                                error: function(xhr) {
                                    console.log(xhr);
                                }
                            });
                        },
                        error: function(xhr) {
                            console.log(xhr);
                        }
                    });
                    $(this).dialog('close');
                },
                "Hủy bỏ": function() {
                    $(this).dialog('close');
                }
            }
        });

        var temp = new Date();
        garbageUpdateDateFrom = new Date(temp.getFullYear(), temp.getMonth() + 1, 1);

        $('#from-date-garbage').datepicker({
            dateFormat: 'M yy',
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            onClose: function(selectedDate) {
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                garbageUpdateDateFrom = new Date(year, month, 1);
                var currentDate = new Date();
                if (garbageUpdateDateFrom >= currentDate) {
                    $(this).val($.datepicker.formatDate('M, yy', garbageUpdateDateFrom));
                } else {
                    alert('Thời điểm bắt đầu phải sau ' + $.datepicker.formatDate('M, yy', currentDate));
                }
            }
        });

        $('#from-date-garbage').focus(function() {
            $(".ui-datepicker-calendar").hide();
            $("#ui-datepicker-div").position({
                my: "center top",
                at: "center bottom",
                of: $(this)
            });
        });

        $('#btnAddGarbage').on('click', function() {
            $(this).remove();
            $('.garbage_content').show();
        });
    });
</script>
</head>
<div id="content">
    <!-- Common dialogs -->
    <div id="dialog-confirm-cancellation-electricity" title="Xác nhận hủy bỏ">
        Bạn có muốn hủy bỏ dữ liệu đang nhập?
    </div>
    <div id="dialog-confirm-cancellation-water" title="Xác nhận hủy bỏ">
        Bạn có muốn hủy bỏ dữ liệu đang nhập?
    </div>
    <div id="dialog-confirm-cancellation-garbage" title="Xác nhận hủy bỏ">
        Bạn có muốn hủy bỏ dữ liệu đang nhập?
    </div>

    <div id="dialog-delete-current-standard-price-electricity" title="Xóa định mức hiện tại">
        Bạn có muốn xóa định mức hiện tại?
    </div>
    <div id="dialog-delete-current-standard-price-water" title="Xóa định mức hiện tại">
        Bạn có muốn xóa định mức hiện tại?
    </div>
    <div id="dialog-delete-current-standard-price-garbage" title="Xóa định mức hiện tại">
        Bạn có muốn xóa định mức hiện tại?
    </div>

    <div id="header"><h1><?php echo $header_new; ?></h1></div>

    <div class="com-button-panel">
        <input type="button" value="Lịch Sử" id="btnHistoryStandardPrice" />
        <input type="button" value="Hiện Tại" id="btnCurrentStandardPrice" />
    </div>
    <div style="clear: both;"></div>
    <div class="table_electricity">
        <?php echo '<h3>' . $description_electricity . '</h3>'; ?>
        <div class="electricity_content">
            <div>
                <?php echo $valid_date_range; ?>
                <input type="text" id="from-date-electricity" style="margin-left: 1em;"/>
                <div class="com-edit-button-panel">
                    <input type="button" value="Xóa" class="btnDelete" />
                    <input type="button" value="Sửa" class="btnEdit" />
                </div>
            </div>
            <div id="update-electricity-standard">
                <p><span style="color: red; font-weight: bold;">(*)</span> Nhập -1 vào cột Đến kW/người ở dòng cuối cùng để kết thúc bảng định mức</p>
                <table>
                    <thead>
                    <td><b><?php echo $text_electricity_from; ?></b></td>
                    <td><b><?php echo $text_electricity_to; ?></b></td>
                    <td><b><?php echo $text_electricity_price; ?></b</td>
                    <td></td>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div class="com-action-button-panel">
                    <input type="button" value="Hủy" class="btnCancel" />
                    <input type="button" value="Xác Nhận" class="btnConfirm" />
                </div>
            </div>
        </div>
    </div>
    <div class="table_water">
        <?php echo '<h3>' . $description_water . '</h3>'; ?>
        <div class="water_content">
            <div>
                <?php echo $valid_date_range; ?>
                <input type="text" id="from-date-water" style="margin-left: 1em;"/>
                <div class="com-edit-button-panel">
                    <input type="button" value="Xóa" class="btnDelete" />
                    <input type="button" value="Sửa" class="btnEdit" />
                </div>
            </div>
            <div id="update-water-standard">
                <p><span style="color: red; font-weight: bold;">(*)</span> Nhập -1 vào cột Đến kW/người ở dòng cuối cùng để kết thúc bảng định mức</p>
                <table>
                    <thead>
                    <td><b><?php echo $text_water_from; ?></b></td>
                    <td><b><?php echo $text_water_to; ?></b></td>
                    <td><b><?php echo $text_water_price; ?></b</td>
                    <td></td>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div class="com-action-button-panel">
                    <input type="button" value="Hủy" class="btnCancel" />
                    <input type="button" value="Xác Nhận" class="btnConfirm" />
                </div>
            </div>
        </div>
    </div>
    <div class="table_garbage">
        <?php echo '<h3>' . $description_garbage . '</h3>'; ?>
        <div class="garbage_content">
            <div>
                <?php echo $valid_date_range; ?>
                <input type="text" id="from-date-garbage" style="margin-left: 1em;"/>
                <div class="com-edit-button-panel">
                    <input type="button" value="Xóa" class="btnDelete" />
                    <input type="button" value="Sửa" class="btnEdit" />
                </div>
            </div>
            <div id="update-garbage-standard">
                <table>
                    <thead>
                    <td><b><?php echo $text_garbage_price; ?></b</td>
                    <td></td>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div class="com-action-button-panel">
                    <input type="button" value="Hủy" class="btnCancel" />
                    <input type="button" value="Xác Nhận" class="btnConfirm" />
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $footer; ?>