<?php echo $header; ?>
<head>
    <style>
        /* Layout 3 columns with equal width */
        #content {
            width: 100%;
        }

        .table_electricity, .table_water, .table_garbage {
            width: 33.33333%;
            float: left;
        }
        /*======================================*/

        /* Layout 2 buttons in com-button-panel */
        .com-button-panel {
            margin-right: 5em;
        }

        input[type="button"] {
            float: right;

        }
        /*=======================================*/

        /* Display vertical line among columns in tables */
        table.electricity_standard_price, table.water_standard_price {
            border-collapse: collapse;
        }

        tr {
            border: none;
        }

        .electricity_standard_price td, .water_standard_price td {
            padding-left: 2em;
            padding-right: 2em;
            border-right: solid 1px;
            border-left: solid 1px;
        }
        /*=======================================*/

        /* Display vertical line among columns in tables positioned in Compare section */
        table.compare-electricity_standard_price, table.compare-water_standard_price {
            border-collapse: collapse;
        }

        tr {
            border: none;
        }

        .compare-electricity_standard_price td, .compare-water_standard_price td{
            padding-left: 2em;
            padding-right: 2em;
            border-right: solid 1px;
            border-left: solid 1px;
        }
        /*=======================================*/

        h2 {
            color: #0000ff;
        }

        h3 {
            color: orangered;
        }

        .link-compare {
            width: 80%;
            text-align: center;
        }

        #header {
            text-align: center;
            color: cornflowerblue;
        }
    </style>
    <script src="view/javascript/jquery.blockUI.js"></script>
    <script type="text/javascript">
        $(document).ajaxStop($.unblockUI);
        $(function() {
            // format number: convert 1234 -> 1,234
            Number.prototype.format = function(n, x) {
                var re = '(\\d)(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
                return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$1,');
            };

            $('#btnCurrentStandardPrice').click(function() {
                window.location.href = "index.php?route=price/edit&token=<?php echo $token; ?>"
            });

            $('#btnNewStandardPrice').click(function() {
                window.location.href = "index.php?route=price/edit/newStandardPriceView&token=<?php echo $token; ?>"
            });

            $('#btnEditStandardPrice').click(function() {
                window.location.href = "index.php?route=price/edit/editStandardPriceView&token=<?php echo $token; ?>"
            });

            $('#electricity_modified_date').change(function() {
                $.blockUI({ message: '<h3><span><img src="view/image/price/preloader.gif" height="16" width="16" /></span> Đang tải dữ liệu...</h3>' });
                $.ajax({
                    url: 'index.php?route=price/edit/loadElectricityStandardPrice&token=<?php echo $token; ?>',
                    data: { 'id' : $(this).children('option').filter(':selected').val() },
                    dataType: 'json',
                    type: 'post',
                    success: function(json) {
                        var $edit = $('.electricity_standard_price').find('tbody');
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
            });

            $('#water_modified_date').change(function() {
                $.blockUI({ message: '<h3><span><img src="view/image/price/preloader.gif" height="16" width="16" /></span> Đang tải dữ liệu...</h3>' });
                $.ajax({
                    url: 'index.php?route=price/edit/loadWaterStandardPrice&token=<?php echo $token; ?>',
                    data: { 'id' : $(this).children('option').filter(':selected').val() },
                    dataType: 'json',
                    type: 'post',
                    success: function(json) {
                        var $edit = $('.water_standard_price').find('tbody');
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
            });

            $('#garbage_modified_date').change(function() {
                $.blockUI({ message: '<h3><span><img src="view/image/price/preloader.gif" height="16" width="16" /></span> Đang tải dữ liệu...</h3>' });
                $.ajax({
                    url: 'index.php?route=price/edit/loadGarbageStandardPrice&token=<?php echo $token; ?>',
                    data: { 'id' : $(this).children('option').filter(':selected').val() },
                    dataType: 'json',
                    type: 'post',
                    success: function(json) {
                        var $edit = $('.garbage_standard_price').find('tbody');
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
            });

            $('.content-compare').hide();

            $('.table_electricity > .link-compare > a').click(function() {
                $('.table_electricity > .content-compare').toggle();
            });

            $('.table_water > .link-compare > a').click(function() {
                $('.table_water > .content-compare').toggle();
            });

            $('.table_garbage > .link-compare > a').click(function() {
                $('.table_garbage > .content-compare').toggle();
            });

            $('#compare-electricity_modified_date').change(function() {
                $.blockUI({ message: '<h3><span><img src="view/image/price/preloader.gif" height="16" width="16" /></span> Đang tải dữ liệu...</h3>' });
                $.ajax({
                    url: 'index.php?route=price/edit/loadElectricityStandardPrice&token=<?php echo $token; ?>',
                    data: { 'id' : $(this).children('option').filter(':selected').val() },
                    dataType: 'json',
                    type: 'post',
                    success: function(json) {
                        var $edit = $('.compare-electricity_standard_price').find('tbody');
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
            });

            $('#compare-water_modified_date').change(function() {
                $.blockUI({ message: '<h3><span><img src="view/image/price/preloader.gif" height="16" width="16" /></span> Đang tải dữ liệu...</h3>' });
                $.ajax({
                    url: 'index.php?route=price/edit/loadWaterStandardPrice&token=<?php echo $token; ?>',
                    data: { 'id' : $(this).children('option').filter(':selected').val() },
                    dataType: 'json',
                    type: 'post',
                    success: function(json) {
                        var $edit = $('.compare-water_standard_price').find('tbody');
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
            });

            $('#compare-garbage_modified_date').change(function() {
                $.blockUI({ message: '<h3><span><img src="view/image/price/preloader.gif" height="16" width="16" /></span> Đang tải dữ liệu...</h3>' });
                $.ajax({
                    url: 'index.php?route=price/edit/loadGarbageStandardPrice&token=<?php echo $token; ?>',
                    data: { 'id' : $(this).children('option').filter(':selected').val() },
                    dataType: 'json',
                    type: 'post',
                    success: function(json) {
                        var $edit = $('.compare-garbage_standard_price').find('tbody');
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
            });
        });
    </script>
</head>
<div id="content">
    <div id="header"><h1><?php echo $header_history; ?></h1></div>
    <div class="com-button-panel">
        <input type="button" value="Hiện Tại" id="btnCurrentStandardPrice" />
        <input type="button" value="Chỉnh Sửa" id="btnEditStandardPrice" />
        <input type="button" value="Thêm Mới" id="btnNewStandardPrice" />
    </div>
    <div style="clear: both;"></div>
    <div class="table_electricity">
        <?php echo '<h3>' . $description_electricity . '</h3>'; ?>
        <?php echo $valid_date_range; ?>
        <select id="electricity_modified_date">
            <?php
                    foreach ($electricity_last_modified_list as $row) {
                    $from = date("m-Y", strtotime($row['from']));
                    if (!empty($row['to'])) {
                        $to = date("m-Y", strtotime($row['to']));
                  ?>
            <option value="<?php echo $row['id']; ?>">Từ <?php echo $from; ?> Đến <?php echo $to; ?></option>
            <?php
                    } else {
                  ?>
            <option value="<?php echo $row['id']; ?>">Từ <?php echo $from; ?> trở đi</option>
            <?php
                    }
                  ?>
            ?>
            <?php } ?>
        </select>
        <br />
        <br />
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
        <br />
        <div class="link-compare"><a>So Sánh</a></div>
        <br />
        <div class="content-compare">
            <?php echo $valid_date_range; ?>
            <select id="compare-electricity_modified_date">
                <?php
                    foreach ($electricity_last_modified_list as $row) {
                    $from = date("m-Y", strtotime($row['from']));
                    if (!empty($row['to'])) {
                        $to = date("m-Y", strtotime($row['to']));
                  ?>
                <option value="<?php echo $row['id']; ?>">Từ <?php echo $from; ?> Đến <?php echo $to; ?></option>
                <?php
                    } else {
                  ?>
                <option value="<?php echo $row['id']; ?>">Từ <?php echo $from; ?> trở đi</option>
                <?php
                    }
                  ?>
                ?>
                <?php } ?>
            </select>
            <br />
            <br />
            <table class="compare-electricity_standard_price">
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
        </div>
    </div>
    <div class="table_water">
        <?php echo '<h3>' . $description_water . '</h3>'; ?>
        <?php echo $valid_date_range; ?>
        <select id="water_modified_date">
            <?php
                    foreach ($water_last_modified_list as $row) {
                    $from = date("m-Y", strtotime($row['from']));
                    if (!empty($row['to'])) {
                        $to = date("m-Y", strtotime($row['to']));
                  ?>
            <option value="<?php echo $row['id']; ?>">Từ <?php echo $from; ?> Đến <?php echo $to; ?></option>
            <?php
                    } else {
                  ?>
            <option value="<?php echo $row['id']; ?>">Từ <?php echo $from; ?> trở đi</option>
            <?php
                    }
                  ?>
            ?>
            <?php } ?>
        </select>
        <br />
        <br />
        <table class="water_standard_price">
            <thead>
            <td><b><?php echo $text_water_from; ?></b></td>
            <td><b><?php echo $text_water_to; ?></b></td>
            <td><b><?php echo $text_water_price; ?></b</td>
            </thead>
            <tbody>
            <?php
                if ($w_standard) {
                    foreach ($w_standard as $row) {
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
        <div class="link-compare"><a>So Sánh</a></div>
        <br />
        <div class="content-compare">
            <?php echo $valid_date_range; ?>
            <select id="compare-water_modified_date">
                <?php
                    foreach ($water_last_modified_list as $row) {
                    $from = date("m-Y", strtotime($row['from']));
                    if (!empty($row['to'])) {
                        $to = date("m-Y", strtotime($row['to']));
                  ?>
                <option value="<?php echo $row['id']; ?>">Từ <?php echo $from; ?> Đến <?php echo $to; ?></option>
                <?php
                    } else {
                  ?>
                <option value="<?php echo $row['id']; ?>">Từ <?php echo $from; ?> trở đi</option>
                <?php
                    }
                  ?>
                ?>
                <?php } ?>
            </select>
            <br />
            <br />
            <table class="compare-water_standard_price">
                <thead>
                <td><b><?php echo $text_water_from; ?></b></td>
                <td><b><?php echo $text_water_to; ?></b></td>
                <td><b><?php echo $text_water_price; ?></b</td>
                </thead>
                <tbody>
                <?php
                if ($w_standard) {
                    foreach ($w_standard as $row) {
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
        </div>
    </div>
    <div class="table_garbage">
        <?php echo '<h3>' . $description_garbage . '</h3>'; ?>
        <?php echo $valid_date_range; ?>
        <select id="compare-garbage_modified_date">
            <?php
                    foreach ($garbage_last_modified_list as $row) {
                    $from = date("m-Y", strtotime($row['from']));
                    if (!empty($row['to'])) {
                        $to = date("m-Y", strtotime($row['to']));
                  ?>
            <option value="<?php echo $row['id']; ?>">Từ <?php echo $from; ?> Đến <?php echo $to; ?></option>
            <?php
                    } else {
                  ?>
            <option value="<?php echo $row['id']; ?>">Từ <?php echo $from; ?> trở đi</option>
            <?php
                    }
                  ?>
            ?>
            <?php } ?>
        </select>
        <br />
        <br />
        <table class="garbage_standard_price">
            <thead>
            <td><b><?php echo $text_garbage_price; ?></b</td>
            </thead>
            <tbody>
            <?php
                if ($g_standard) {
                    foreach ($g_standard as $row) {
                ?>
            <tr class="line">
                <td class="price"><?php echo number_format($row['Price']); ?>&nbsp₫</td>
            </tr>
            <?php
                    }
                }
                ?>
            </tbody>
        </table>
        <div class="link-compare"><a>So Sánh</a></div>
        <br />
        <div class="content-compare">
            <?php echo $valid_date_range; ?>
            <select id="compare-garbage_modified_date">
                <?php
                    foreach ($garbage_last_modified_list as $row) {
                    $from = date("m-Y", strtotime($row['from']));
                    if (!empty($row['to'])) {
                        $to = date("m-Y", strtotime($row['to']));
                  ?>
                <option value="<?php echo $row['id']; ?>">Từ <?php echo $from; ?> Đến <?php echo $to; ?></option>
                <?php
                    } else {
                  ?>
                <option value="<?php echo $row['id']; ?>">Từ <?php echo $from; ?> trở đi</option>
                <?php
                    }
                  ?>
                ?>
                <?php } ?>
            </select>
            <br />
            <br />
            <table class="compare-garbage_standard_price">
                <thead>
                <td><b><?php echo $text_garbage_price; ?></b</td>
                </thead>
                <tbody>
                <?php
                if ($g_standard) {
                    foreach ($g_standard as $row) {
                ?>
                <tr class="line">
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
<?php echo $footer; ?>