<head>
    <style type="text/css">
        #content {
            width: inherit;
        }
        .standard_price_show {
            width: 238px;
            position: absolute;
            padding: 6px;
        }
        .standard_price_edit {
            margin-left: 260px;
            padding: 6px;
            width: auto;
        }
        .standard_price_show, .standard_price_edit{
            margin-top: 15px;
            -webkit-box-shadow: 1px 0px 1px 1px rgba(232,232,232,1);
            -moz-box-shadow: 1px 0px 1px 1px rgba(232,232,232,1);
            box-shadow: 1px 0px 1px 1px rgba(232,232,232,1);
        }
        .electricity_standard_price, .water_standard_price  {
            width: 224px;
        }
        h2 {
            color: #0000ff;
        }
        input {
            float: right;
        }
        .table_electricity, .table_water {
            width: 250px;
        }
        .left_info {
            float: left;
            width: 230px;
        }
        .right_electricity_edit, .right_water_edit {
            margin-left: 235px;
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

        .dlg-no-title .ui-dialog-titlebar {
            display: none;
        }
    </style>
</head>
<?php echo $header; ?>
<head>
    <script src="view/javascript/jquery.blockUI.js"></script>
    <script type="text/javascript">
        $(document).ajaxStop($.unblockUI);
        $(function() {
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

            jsonElectricityNew = {};
            jsonWaterNew = {};

            idNewestElectricity = 0;
            idNewestWater = 0;

            $('#dialog-update-electricity-standard').on('click', '.remove', function() {
                var $this = $(this);
                console.log($this);
                if ($this.parent().is(':first-child')) {
                    alert('Không thể xóa dòng này!');
                } else {
                    // the number of elements inside obj object
                    var $prevRow = $this.parent().prev().children('.to').children();
                    var $nextRow = $this.parent().next().children('.from').children();
                    $nextRow.val(parseInt($prevRow.val()) + 1);
                    $this.parent().remove();
                }
            });

            $('#electricity_modified_date').change(function() {
                $.ajax({
                    url: 'index.php?route=price/edit/loadElectricityStandardPrice&token=<?php echo $token; ?>',
                    data: { 'id' : $(this).children('option').filter(':selected').val() },
                    dataType: 'json',
                    type: 'post',
                    success: function(json) {
                        var $show = $('.standard_price_show').children('.electricity_standard_price').find('tbody');
                        var $edit = $('.standard_price_edit').find('.electricity_standard_price').find('tbody');
                        // delete all current lines in the table
                        $show.empty();
                        $edit.empty();
                        // loop all elements in a list of objects
                        for (var index in json['data']) {
                            var price = parseInt(json['data'][index]['Price']);
                            var to = json['data'][index]['To'];
                            if (to == '0') {
                                to = '';
                            }
                            // add new lines represent the standard price corresponding to the inputted date
                            $show.append('<tr class="line">' +
                                                '<td class="from">' + json['data'][index]['From'] + '</td>' +
                                                '<td class="to">' + to + '</td>' +
                                                '<td class="price">' + price.format() + '&nbsp₫</td>' + // format function: convert 1234 -> 1,234
                                            '</tr>');
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
            });

            $('#dialog-update-electricity-standard').dialog({
                autoOpen: false,
                draggable: false,
                resizable: false,
                position: 'center',
                modal: true,
                show: true,
                minHeight: 'auto', // auto expand height
                minWidth: 'auto',
                dialogClass: 'dlg-no-title',
                buttons: {
                    "Cập nhật": function() {
                        var $this = $(this);
                        $lastRow = $('#dialog-update-electricity-standard').find('.line').last();
                        to = $lastRow.children('.to').children().val();
                        price = $lastRow.children('.price').children().val();
                        if (!to) {
                            jsonElectricityNew.electricity_new = {};
                            $('#dialog-update-electricity-standard').find('.line').each(function(index, element) {
                                jsonElectricityNew.electricity_new[index] = {};
                                jsonElectricityNew.electricity_new[index].from = $(element).children('.from').children().val();
                                jsonElectricityNew.electricity_new[index].to = $(element).children('.to').children().val();
                                jsonElectricityNew.electricity_new[index].price = $(element).children('.price').children().val();
                            });
                            var today = new Date();
                            var day = today.getDate();
                            var month = today.getMonth() + 1;
                            var year = today.getFullYear();
                            var updateDate = year + '-' + month + '-' + day;
                            $.ajax({
                                url: 'index.php?route=price/edit/updateElectricityStandardPrice&token=<?php echo $token; ?>',
                                data: {
                                    'electricity_new_data': jsonElectricityNew,
                                    'update_date': updateDate,
                                    'id': idNewestElectricity
                                },
                                dataType: 'json',
                                type: 'post',
                                success: function(json) {
                                    var arr = jsonElectricityNew.electricity_new;
                                    var $show = $('.standard_price_show').children('.electricity_standard_price').find('tbody');
                                    var $edit = $('.standard_price_edit').find('.electricity_standard_price').find('tbody');
                                    $show.empty();
                                    $edit.empty();
                                    for (var index in arr) {
                                        var price = parseInt(arr[index].price);
                                        $show.append('<tr class="line">' +
                                                        '<td class="from">' + arr[index].from + '</td>' +
                                                        '<td class="to">' + arr[index].to + '</td>' +
                                                        '<td class="price">' + price.format() + '&nbsp₫</td>' +
                                                    '</tr>');
                                        $edit.append('<tr class="line">' +
                                                '<td class="from">' + arr[index].from + '</td>' +
                                                '<td class="to">' + arr[index].to + '</td>' +
                                                '<td class="price">' + price.format() + '&nbsp₫</td>' +
                                                '</tr>');
                                    }
                                    $this.dialog('close');
                                }, // for debugging purpose
                                error: function(xhr) {
                                    console.log(xhr);
                                }
                            });
                        } else {
                            alert('Bạn chưa nhập đủ dữ liệu');
                        }
                    }
                }
            });

            $('input[name="createNewElectricityStandard"]').click(function() {
                $tbody = $('#dialog-update-electricity-standard').find('tbody');
                $tbody.empty();
                // jQuery BlockUI (http://malsup.com/jquery/block/)
                $.blockUI({ message: '<h3><span><img src="view/image/price/preloader.gif" height="16" width="16" /></span> Đang lấy dữ liệu...</h3>' });
                $.ajax({
                    url: 'index.php?route=price/edit/loadNewestElectricityStandardPrice&token=<?php echo $token; ?>',
                    dataType: 'json',
                    type: 'post',
                    success: function(json) {
                        // open dialog after loading data successfully
                        $('#dialog-update-electricity-standard').dialog('open');
                        idNewestElectricity = json['id'];
                        for (var index in json['newest']) {
                            var to = json['newest'][index]['To'];
                            if (to == 0) {
                                to = '';
                            }
                            $tbody.append('<tr class="line">' +
                                                '<td class="from"><input type="text" style="width: 74px;" disabled="true" value="' + json['newest'][index]['From'] + '"/></td>' +
                                                '<td class="to"><input type="text" style="width: 74px;" value="' + to + '"/></td>' +
                                                '<td class="price"><input type="text" style="width: 74px;" value="' + json['newest'][index]['Price'] + '"/></td>' +
                                                '<td class="remove"><img src="view/image/price/delete.png" height="16" width="16" /></td>' +
                                            '</tr>');
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
                        $('.plus').on('click', function() {
                            $toCell = $('#dialog-update-electricity-standard').find('.line').last().children('.to').children();
                            to = parseInt($toCell.val());
                            if (to) {
                                // select dummy-line
                                $dummy = $('.dummy-line');
                                // get the To value of the last row
                                console.log(to);
                                // add a new dummy-line after the default dummy-line, change the default dummy-line into a `line` and make all its children visible
                                // the new dummy-line become the default dummy-line
                                $dummy.after($dummy.outerHTML()).removeClass("dummy-line").addClass("line")
                                        .children().show() // show newly added row
                                        .end().children('.from').children().val(to + 1); // From = (last To value) + 1
                                // input check
                                $('#dialog-update-electricity-standard').find('.line').focusout(function() {
                                    var $this = $(this);
                                    var $from = $this.children('.from').children();
                                    var $to = $this.children('.to').children();
                                    var $price = $this.children('.price').children();
                                    var to = $to.val();
                                    var from = $from.val();
                                    var price = $price.val();
                                    if (to && parseInt(to) <= parseInt(from)) {
                                        alert ('Giá trị cột Đến kW phải lớn hơn cột Từ kW');
                                        $to.focus().select();
                                    } else if (to && (!$.isNumeric(to) || parseInt(to) < 0)) {
                                        alert('Giá trị nhập vào không hợp lệ');
                                        $to.focus().select();
                                    } else if (!$.isNumeric(price) || parseInt(price) < 0) {
                                        alert('Giá trị nhập vào không hợp lệ');
                                         $price.focus().select();
                                    } else {
                                        // change value of From in the next row. From = (last row's To) + 1
                                        var $next = $this.next();
                                        if ($next) {
                                            $next.children('.from').children().val(parseInt(to) + 1);
                                        }
                                    }
                                });
                            } else {
                                // last row in Standard Price table
                                alert('Nhập giá trị cho cột Đến kW trước khi tạo dòng mới hoặc để trống và bấm Cập nhật');
                            }
                        });
                    }, // for debugging purpose
                    error: function(xhr) {
                        console.log(xhr);
                    }
                });
            });
            //==========================================================================================================
            $('#dialog-update-water-standard').on('click', '.remove', function() {
                var $this = $(this);
                console.log($this);
                if ($this.parent().is(':first-child')) {
                    alert('Không thể xóa dòng này!');
                } else {
                    // the number of elements inside obj object
                    var $prevRow = $this.parent().prev().children('.to').children();
                    var $nextRow = $this.parent().next().children('.from').children();
                    $nextRow.val(parseInt($prevRow.val()) + 1);
                    $this.parent().remove();
                }
            });

            $('#water_modified_date').change(function() {
                $.ajax({
                    url: 'index.php?route=price/edit/loadWaterStandardPrice&token=<?php echo $token; ?>',
                    data: { 'id' : $(this).children('option').filter(':selected').val() },
                    dataType: 'json',
                    type: 'post',
                    success: function(json) {
                        var $show = $('.standard_price_show').children('.water_standard_price').find('tbody');
                        var $edit = $('.standard_price_edit').find('.water_standard_price').find('tbody');
                        // delete all current lines in the table
                        $show.empty();
                        $edit.empty();
                        // loop all elements in a list of objects
                        for (var index in json['data']) {
                            var price = parseInt(json['data'][index]['Price']);
                            var to = json['data'][index]['To'];
                            if (to == '0') {
                                to = '';
                            }
                            // add new lines represent the standard price corresponding to the inputted date
                            $show.append('<tr class="line">' +
                                    '<td class="from">' + json['data'][index]['From'] + '</td>' +
                                    '<td class="to">' + to + '</td>' +
                                    '<td class="price">' + price.format() + '&nbsp₫</td>' + // format function: convert 1234 -> 1,234
                                    '</tr>');
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
            });

            $('#dialog-update-water-standard').dialog({
                autoOpen: false,
                draggable: false,
                resizable: false,
                position: 'center',
                modal: true,
                show: true,
                minHeight: 'auto', // auto expand height
                minWidth: 'auto',
                dialogClass: 'dlg-no-title',
                buttons: {
                    "Cập nhật": function() {
                        var $this = $(this);
                        $lastRow = $('#dialog-update-water-standard').find('.line').last();
                        to = $lastRow.children('.to').children().val();
                        price = $lastRow.children('.price').children().val();
                        if (!to) {
                            jsonWaterNew.water_new = {};
                            $('#dialog-update-water-standard').find('.line').each(function(index, element) {
                                jsonWaterNew.water_new[index] = {};
                                jsonWaterNew.water_new[index].from = $(element).children('.from').children().val();
                                jsonWaterNew.water_new[index].to = $(element).children('.to').children().val();
                                jsonWaterNew.water_new[index].price = $(element).children('.price').children().val();
                            });
                            var today = new Date();
                            var day = today.getDate();
                            var month = today.getMonth() + 1;
                            var year = today.getFullYear();
                            var updateDate = year + '-' + month + '-' + day;
                            $.ajax({
                                url: 'index.php?route=price/edit/updateWaterStandardPrice&token=<?php echo $token; ?>',
                                data: {
                                    'water_new_data': jsonWaterNew,
                                    'update_date': updateDate,
                                    'id': idNewestWater
                                },
                                dataType: 'json',
                                type: 'post',
                                success: function(json) {
                                    var arr = jsonWaterNew.water_new;
                                    var $show = $('.standard_price_show').children('.water_standard_price').find('tbody');
                                    var $edit = $('.standard_price_edit').find('.water_standard_price').find('tbody');
                                    $show.empty();
                                    $edit.empty();
                                    for (var index in arr) {
                                        var price = parseInt(arr[index].price);
                                        $show.append('<tr class="line">' +
                                                '<td class="from">' + arr[index].from + '</td>' +
                                                '<td class="to">' + arr[index].to + '</td>' +
                                                '<td class="price">' + price.format() + '&nbsp₫</td>' +
                                                '</tr>');
                                        $edit.append('<tr class="line">' +
                                                '<td class="from">' + arr[index].from + '</td>' +
                                                '<td class="to">' + arr[index].to + '</td>' +
                                                '<td class="price">' + price.format() + '&nbsp₫</td>' +
                                                '</tr>');
                                    }
                                    $this.dialog('close');
                                }, // for debugging purpose
                                error: function(xhr) {
                                    console.log(xhr);
                                }
                            });
                        } else {
                            alert('Bạn chưa nhập đủ dữ liệu');
                        }
                    }
                }
            });

            $('input[name="createNewWaterStandard"]').click(function() {
                $tbody = $('#dialog-update-water-standard').find('tbody');
                $tbody.empty();
                // jQuery BlockUI (http://malsup.com/jquery/block/)
                $.blockUI({ message: '<h3><span><img src="view/image/price/preloader.gif" height="16" width="16" /></span> Đang lấy dữ liệu...</h3>' });
                $.ajax({
                    url: 'index.php?route=price/edit/loadNewestWaterStandardPrice&token=<?php echo $token; ?>',
                    dataType: 'json',
                    type: 'post',
                    success: function(json) {
                        // open dialog after loading data successfully
                        $('#dialog-update-water-standard').dialog('open');
                        idNewestWater = json['id'];
                        for (var index in json['newest']) {
                            var to = json['newest'][index]['To'];
                            if (to == 0) {
                                to = '';
                            }
                            $tbody.append('<tr class="line">' +
                                    '<td class="from"><input type="text" style="width: 74px;" disabled="true" value="' + json['newest'][index]['From'] + '"/></td>' +
                                    '<td class="to"><input type="text" style="width: 74px;" value="' + to + '"/></td>' +
                                    '<td class="price"><input type="text" style="width: 74px;" value="' + json['newest'][index]['Price'] + '"/></td>' +
                                    '<td class="remove"><img src="view/image/price/delete.png" height="16" width="16" /></td>' +
                                    '</tr>');
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
                        $('.plus').on('click', function() {
                            $toCell = $('#dialog-update-water-standard').find('.line').last().children('.to').children();
                            to = parseInt($toCell.val());
                            if (to) {
                                // select dummy-line
                                $dummy = $('.dummy-line');
                                // get the To value of the last row
                                console.log(to);
                                // add a new dummy-line after the default dummy-line, change the default dummy-line into a `line` and make all its children visible
                                // the new dummy-line become the default dummy-line
                                $dummy.after($dummy.outerHTML()).removeClass("dummy-line").addClass("line")
                                        .children().show() // show newly added row
                                        .end().children('.from').children().val(to + 1); // From = (last To value) + 1
                                // input check
                                $('#dialog-update-water-standard').find('.line').focusout(function() {
                                    var $this = $(this);
                                    var $from = $this.children('.from').children();
                                    var $to = $this.children('.to').children();
                                    var $price = $this.children('.price').children();
                                    var to = $to.val();
                                    var from = $from.val();
                                    var price = $price.val();
                                    if (to && parseInt(to) <= parseInt(from)) {
                                        alert ('Giá trị cột Đến kW phải lớn hơn cột Từ kW');
                                        $to.focus().select();
                                    } else if (to && (!$.isNumeric(to) || parseInt(to) < 0)) {
                                        alert('Giá trị nhập vào không hợp lệ');
                                        $to.focus().select();
                                    } else if (!$.isNumeric(price) || parseInt(price) < 0) {
                                        alert('Giá trị nhập vào không hợp lệ');
                                        $price.focus().select();
                                    } else {
                                        // change value of From in the next row. From = (last row's To) + 1
                                        var $next = $this.next();
                                        if ($next) {
                                            $next.children('.from').children().val(parseInt(to) + 1);
                                        }
                                    }
                                });
                            } else {
                                // last row in Standard Price table
                                alert('Nhập giá trị cho cột Đến kW trước khi tạo dòng mới hoặc để trống và bấm Cập nhật');
                            }
                        });
                    }, // for debugging purpose
                    error: function(xhr) {
                        console.log(xhr);
                    }
                });
            });
        });
    </script>
</head>
<div id="content">
    <div class="standard_price_show">
        <h2>BẢNG GIÁ ĐIỆN - NƯỚC</h2>
        <?php echo $description_electricity; ?>
        <table class="electricity_standard_price">
            <thead>
            <td><b><?php echo $text_electricity_from; ?></b></td>
            <td><b><?php echo $text_electricity_to; ?></b></td>
            <td><b><?php echo $text_electricity_price; ?></b</td>
            </thead>
            <tbody>
            <?php
                if ($e_standard) {
                    foreach ($e_standard as $row) {
                ?>
            <tr class="line">
                <td class="from"><?php echo $row['From']; ?></td>
                <td class="to"><?php if ($row['To'] != '-1') echo $row['To']; ?></td>
                <td class="price"><?php echo number_format($row['Price']); ?>&nbsp₫</td>
            </tr>
            <?php
                    }
                }
                ?>
            </tbody>
        </table>
        <?php echo $note_1; ?>
        <br /><br />
        <?php echo $description_water; ?>
        <table class="water_standard_price">
            <thead>
                <td><b><?php echo $text_water_from; ?></b></td>
                <td><b><?php echo $text_water_to; ?></b></td>
                <td><b><?php echo $text_water_price; ?></b></td>
            </thead>
            <tbody>
            <?php
                if ($w_standard) {
                    foreach ($w_standard as $row) {
                ?>
            <tr class="line">
                <td class="from"><?php echo $row['From']; ?></td>
                <td class="to"><?php if ($row['To'] != '-1') echo $row['To']; ?></td>
                <td class="price"><?php echo number_format($row['Price']); ?>&nbsp₫</td>
            </tr>
            <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="standard_price_edit">
        <h2>CHỈNH SỬA ĐỊNH MỨC GIÁ ĐIỆN - NƯỚC</h2>
        <div class="table_electricity">
            <?php echo $description_electricity; ?>
            <br />
            <input type="button" value="CẬP NHẬT" name="createNewElectricityStandard" />
            <div id="dialog-update-electricity-standard" title="Cập nhật">
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
            </div>
            Lịch sử chỉnh sửa
            <select id="electricity_modified_date">
                <?php foreach ($electricity_last_modified_list as $row) {
                $from = date("F jS, Y", strtotime($row['from']));
                if (!empty($row['to'])) {
                    $to = date("F jS, Y", strtotime($row['to']));
              ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $from; ?> - <?php echo $to; ?></option>
                <?php
                } else {
              ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $from; ?></option>
                <?php
                }
              ?>
                ?>
                <?php } ?>
            </select>
            <div class="left_info">
                <table class="electricity_standard_price">
                    <thead>
                        <td><b><?php echo $text_electricity_from; ?></b></td>
                        <td><b><?php echo $text_electricity_to; ?></b></td>
                        <td><b><?php echo $text_electricity_price; ?></b</td>
                    </thead>
                    <tbody>
                    <?php
                        if ($e_standard) {
                            foreach ($e_standard as $row) {
                        ?>
                    <tr class="line">
                        <td class="from"><?php echo $row['From']; ?></td>
                        <td class="to"><?php if ($row['To'] != -1) echo $row['To']; ?></td>
                        <td class="price"><?php echo number_format($row['Price']); ?>&nbsp₫</td>
                    </tr>
                    <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <?php echo $note_1; ?>
                <br /><br />
            </div>
        </div>

        <div class="table_water">
            <?php echo $description_water; ?>
            <br />
            <input type="button" value="CẬP NHẬT" name="createNewWaterStandard" />
            <div id="dialog-update-water-standard" title="Cập nhật">
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
            </div>
            Lịch sử chỉnh sửa
            <select id="water_modified_date">
                <?php foreach ($water_last_modified_list as $row) {
                $from = date("F jS, Y", strtotime($row['from']));
                if (!empty($row['to'])) {
                    $to = date("F jS, Y", strtotime($row['to']));
              ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $from; ?> - <?php echo $to; ?></option>
                <?php
                } else {
              ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $from; ?></option>
                <?php
                }
              ?>
                ?>
                <?php } ?>
            </select>
            <div class="left_info">
                <table class="water_standard_price">
                    <thead>
                        <td><b><?php echo $text_water_from; ?></b></td>
                        <td><b><?php echo $text_water_to; ?></b></td>
                        <td><b><?php echo $text_water_price; ?></b></td>
                        <td></td>
                    </thead>
                    <tbody>
                    <?php
                        if ($w_standard) {
                            foreach ($w_standard as $row) {
                        ?>
                    <tr class="line">
                        <td class="from"><?php echo $row['From']; ?></td>
                        <td class="to"><?php if ($row['To'] != '-1') echo $row['To']; ?></td>
                        <td class="price"><?php echo number_format($row['Price']); ?>&nbsp₫</td>
                    </tr>
                    <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php echo $footer; ?>