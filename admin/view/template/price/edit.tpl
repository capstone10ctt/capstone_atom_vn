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
    </style>
</head>
<?php echo $header; ?>
<head>
    <script type="text/javascript">
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

            $('.right_electricity_edit').click(function() {
                // replace texts with input fields
                $('.left_info .electricity_standard_price tbody tr td').not('.remove').each(function() {
                    var $this = $(this);
                    var input = $('<input type="text" style="width: 74px;" />')
                            .attr('value', $this.text().replace('₫', '').replace(',','').trim())
                            .wrap('<td></td>');
                    $this.html('');
                    $this.append(input);
                });
                $('.left_info .electricity_standard_price tbody tr').not('.dummy-line').children('.remove').show();
                $('.standard_price_edit .left_info .electricity_standard_price').append('' +
                        '<tr class="dummy-line">' +
                            '<td class="from" style="display: none;"><input style="width: 74px;" /></td>' +
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
                    // select dummy-line
                    $dummy = $('.standard_price_edit .left_info .electricity_standard_price .dummy-line');
                    // add a new dummy-line after the default dummy-line, change the default dummy-line into a `line` and make all its children visible
                    // the new dummy-line become the default dummy-line
                    $dummy.after($dummy.outerHTML()).removeClass("dummy-line").addClass("line").children().show();
                });
            });

            $('.standard_price_edit .left_info .electricity_standard_price').on('click', '.remove', function() {
                var $this = $(this);
                // get index of the current element, index starts from 0
                var index = $this.parent().index();
                // the number of elements inside obj object
                $this.parent().remove();
            });

            // input check
            $('.standard_price_edit').find('.from, .to, .price').on('focusout', function() {
                $this = $(this);
                var val = $this.children().attr('value');
                if (!$.isNumeric(val) || parseInt(val) < 0) {
                    alert('Giá trị nhập vào không hợp lệ!');
                    $this.children().css('background-color', '#FF0000');
                    $this.children().focus().select();
                } else {
                    $this.children().css('background-color', '#FAFAFA');
                }
            });

            $('.right_water_edit').click(function() {
                // replace texts with input fields
                $('.left_info .water_standard_price tbody tr td').not('.remove').each(function() {
                    var $this = $(this);
                    // use attr to change value of input. .val() cannot be used here
                    var input = $('<input type="text" style="width: 74px;" />')
                            .attr('value', $this.text().replace('₫', '').replace(',','').trim())
                            .wrap('<td></td>');
                    $this.html('');
                    $this.append(input);
                });
                $('.left_info .water_standard_price tbody tr').not('.dummy-line').children('.remove').show();
                $('.standard_price_edit .left_info .water_standard_price').append('' +
                        '<tr class="dummy-line">' +
                            '<td class="from" style="display: none;"><input style="width: 74px;" /></td>' +
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
                    // select dummy-line
                    $dummy = $('.standard_price_edit .left_info .water_standard_price .dummy-line');
                    // add a new dummy-line after the default dummy-line, change the default dummy-line into a `line` and make all its children visible
                    // the new dummy-line become the default dummy-line
                    $dummy.after($dummy.outerHTML()).removeClass("dummy-line").addClass("line").children().show();
                });
            });

            $('.standard_price_edit .left_info .water_standard_price').on('click', '.remove', function() {
                var $this = $(this);
                // get index of the current element, index starts from 0
                var index = $this.parent().index();
                // the number of elements inside obj object
                $this.parent().remove();
            });

            $('input[name="updateValue"]').click(function() {
                $('.remove').hide();
                $('.plus').hide();
                // build JSON objects
                $('.left_info .electricity_standard_price').each(function(index, element) {
                    jsonElectricityNew.electricity_new = {};
                    $(element).find('.line').each(function(index, element) {
                        jsonElectricityNew.electricity_new[index] = {};
                        /* there are 2 cases:
                            <td class="from">...</td> OR
                            <td class="from"><input style="width: 74px;" value="323" /></td>
                            use IF statement to check:
                            - undefined: 1st case
                            - ELSE: 2nd case
                         */
                        var f = $(element).children('.from').children().val();
                        var t = $(element).children('.to').children().val();
                        var p = $(element).children('.price').children().val();
                        if (typeof f === 'undefined') {
                            jsonElectricityNew.electricity_new[index].from =  $(element).children('.from').text().replace('₫', '').replace(',','').trim();
                        } else {
                            jsonElectricityNew.electricity_new[index].from = f;
                        }
                        if (typeof t === 'undefined') {
                            jsonElectricityNew.electricity_new[index].to =  $(element).children('.to').text().replace('₫', '').replace(',','').trim();
                        } else {
                            jsonElectricityNew.electricity_new[index].to = t;
                        }
                        if (typeof p === 'undefined') {
                            jsonElectricityNew.electricity_new[index].price =  $(element).children('.price').text().replace('₫', '').replace(',','').trim();
                        } else {
                            jsonElectricityNew.electricity_new[index].price = p;
                        }
                    });
                });
                $('.left_info .water_standard_price').each(function(index, element) {
                    jsonWaterNew.water_new = {};
                    $(element).find('.line').each(function(index, element) {
                        jsonWaterNew.water_new[index] = {};
                        var f = $(element).children('.from').children().val();
                        var t = $(element).children('.to').children().val();
                        var p = $(element).children('.price').children().val();
                        if (typeof f === 'undefined') {
                            jsonWaterNew.water_new[index].from =  $(element).children('.from').text().replace('₫', '').replace(',','').trim();
                        } else {
                            jsonWaterNew.water_new[index].from = f;
                        }
                        if (typeof t === 'undefined') {
                            jsonWaterNew.water_new[index].to =  $(element).children('.to').text().replace('₫', '').replace(',','').trim();
                        } else {
                            jsonWaterNew.water_new[index].to = t;
                        }
                        if (typeof p === 'undefined') {
                            jsonWaterNew.water_new[index].price =  $(element).children('.price').text().replace('₫', '').replace(',','').trim();
                        } else {
                            jsonWaterNew.water_new[index].price = p;
                        }
                    });
                });

                var today = new Date();
                var day = today.getDate();
                var month = today.getMonth() + 1;
                var year = today.getFullYear();
                var updateDate = year + '-' + month + '-' + day;
                var eModifiedDate = $('#electricity_modified_date').children('option').filter(':selected').text();
                var wModifiedDate = $('#water_modified_date').children('option').filter(':selected').text();

                $.ajax({
                    url: 'index.php?route=price/edit/updateStandardPrice&token=<?php echo $token; ?>',
                    data: {
                        'electricity_new_data': jsonElectricityNew,
                        'water_new_data': jsonWaterNew,
                        'update_date': updateDate,
                        'e_modified_date': eModifiedDate,
                        'w_modified_date': wModifiedDate
                    },
                    dataType: 'json',
                    type: 'post',
                    success: function(json) {
                        $('.standard_price_edit').find('.line').each(function(i, e) {
                            $this = $(e);
                            var f = $this.find('.from').children().val();
                            var t = $this.find('.to').children().val();
                            var p = $this.find('.price').children().val();
                            if (typeof f === 'undefined') {
                                $this.find('.from').text(f);
                            } else {
                                $this.find('.from').html('').text(f);
                            }
                            if (typeof t === 'undefined') {
                                $this.find('.to').text(t);
                            } else {
                                $this.find('.to').html('').text(t);
                            }
                            if (typeof p === 'undefined') {
                                p = $this.find('.price').text().replace('₫', '').replace(',','').trim() + ' ₫';
                                $this.find('.price').text(p);
                            } else {
                                $this.find('.price').html('').text(p + ' ₫');
                            }
                        });
                        // eObj is the electricity_standard_price element
                        var eObj = $('.standard_price_show .electricity_standard_price');
                        // remove all current rows in the table
                        eObj.find('.line').remove();
                        // start creating new content
                        eObj.append('<tbody>')
                        var eTemp = jsonElectricityNew.electricity_new;
                        // add updated values after editing
                        for (var i in eTemp) {
                            var tempPrice = parseInt(eTemp[i].price);
                            eObj.append('<tr class="line">' +
                                            '<td class="from">' + eTemp[i].from + '</td>' +
                                            '<td class="to">' + eTemp[i].to + '</td>' +
                                            '<td class="price">' + tempPrice.format() + '&nbsp₫</td>' +
                                        '</td>');
                        }
                        eObj.append('</tbody>');

                        // wObj is the water_standard_price element
                        var wObj = $('.standard_price_show .water_standard_price');
                        // remove all current rows in the table
                        wObj.find('.line').remove();
                        // start creating new content
                        wObj.append('<tbody>')
                        var wTemp = jsonWaterNew.water_new;
                        // add updated values after editing
                        for (var i in wTemp) {
                            var tempPrice = parseInt(wTemp[i].price);
                            wObj.append('<tr class="line">' +
                                    '<td class="from">' + wTemp[i].from + '</td>' +
                                    '<td class="to">' + wTemp[i].to + '</td>' +
                                    '<td class="price">' + tempPrice.format() + '&nbsp₫</td>' +
                                    '</td>');
                        }
                        wObj.append('</tbody>');
                    }, // for debugging purpose
                    error: function(xhr) {
                        console.log(xhr);
                    }
                });
            });

            $('#electricity_modified_date').change(function() {
                $.ajax({
                    url: 'index.php?route=price/edit/loadElectricityStandardPrice&token=<?php echo $token; ?>',
                    data: { 'e_date' : $(this).children('option').filter(':selected').text() },
                    dataType: 'json',
                    type: 'post',
                    success: function(json) {
                        // delete all current lines in the table
                        $('.standard_price_edit .electricity_standard_price .line').remove();
                        $table = $('.standard_price_edit .electricity_standard_price');
                        // loop all elements in a list of objects
                        for (var index in json['data']) {
                            var price = parseInt(json['data'][index]['Price']);
                            // add new lines represent the standard price corresponding to the inputted date
                            $table.append('<tr class="line">' +
                                                '<td class="from">' + json['data'][index]['From'] + '</td>' +
                                                '<td class="to">' + json['data'][index]['To'] + '</td>' +
                                                '<td class="price">' + price.format() + '&nbsp₫</td>' + // format function: convert 1234 -> 1,234
                                                '<td class="remove" style="display: none;"><img src="view/image/price/delete.png" height="16" width="16" /></td>' +
                                            '</tr>');
                        }
                    }, // for debugging purpose
                    error: function(xhr) {
                        console.log(xhr);
                    }
                });
            });

            $('#water_modified_date').change(function() {
                $.ajax({
                    url: 'index.php?route=price/edit/loadWaterStandardPrice&token=<?php echo $token; ?>',
                    data: { 'w_date' : $(this).children('option').filter(':selected').text() },
                    dataType: 'json',
                    type: 'post',
                    success: function(json) {
                        // delete all current lines in the table
                        $('.standard_price_edit .water_standard_price .line').remove();
                        $table = $('.standard_price_edit .water_standard_price');
                        // loop all elements in a list of objects
                        for (var index in json['data']) {
                            var price = parseInt(json['data'][index]['Price']);
                            // add new lines represent the standard price corresponding to the inputted date
                            $table.append('<tr class="line">' +
                                    '<td class="from">' + json['data'][index]['From'] + '</td>' +
                                    '<td class="to">' + json['data'][index]['To'] + '</td>' +
                                    '<td class="price">' + price.format() + '&nbsp₫</td>' + // format function: convert 1234 -> 1,234
                                    '<td class="remove" style="display: none;"><img src="view/image/price/delete.png" height="16" width="16" /></td>' +
                                    '</tr>');
                        }
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
                <td class="to"><?php echo $row['To']; ?></td>
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
                <td class="to"><?php echo $row['To']; ?></td>
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
        <input type="button" value="LƯU CHỈNH SỬA" name="updateValue"/>
        <div class="table_electricity">
            <?php echo $description_electricity; ?>
            <br />
            <?php echo $last_modified . " ". $electricity_last_modified ?>
            <div style="clear: both;"></div>
            Chọn ngày chỉnh sửa
            <select id="electricity_modified_date">
                <?php foreach ($electricity_last_modified_list as $row) { ?>
                    <option><?php echo $row; ?></option>
                <?php } ?>
            </select>
            <div class="left_info">
                <table class="electricity_standard_price">
                    <thead>
                        <td><b><?php echo $text_electricity_from; ?></b></td>
                        <td><b><?php echo $text_electricity_to; ?></b></td>
                        <td><b><?php echo $text_electricity_price; ?></b</td>
                        <td></td>
                    </thead>
                    <tbody>
                    <?php
                        if ($e_standard) {
                            foreach ($e_standard as $row) {
                        ?>
                    <tr class="line">
                        <td class="from"><?php echo $row['From']; ?></td>
                        <td class="to"><?php echo $row['To']; ?></td>
                        <td class="price"><?php echo number_format($row['Price']); ?>&nbsp₫</td>
                        <td class="remove" style="display: none;"><img src="view/image/price/delete.png" height="16" width="16" /></td>
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
            <div class="right_electricity_edit">
                <img src="view/image/price/edit.png" height="16" width="16" />
            </div>
        </div>

        <div class="table_water">
            <?php echo $description_water; ?>
            <?php echo $last_modified . " ". $water_last_modified ?>
            <div style="clear: both;"></div>
            Chọn ngày chỉnh sửa
            <select id="water_modified_date">
                <?php foreach ($water_last_modified_list as $row) { ?>
                <option><?php echo $row; ?></option>
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
                        <td class="to"><?php echo $row['To']; ?></td>
                        <td class="price"><?php echo number_format($row['Price']); ?>&nbsp₫</td>
                        <td class="remove" style="display: none;"><img src="view/image/price/delete.png" height="16" width="16" /></td>
                    </tr>
                    <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="right_water_edit">
                <img src="view/image/price/edit.png" height="16" width="16" />
            </div>
            <div style="clear: both;"></div>
        </div>
    </div>
</div>
<?php echo $footer; ?>