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
    </style>
</head>
<?php echo $header; ?>
<head>
    <script type="text/javascript">
        $(function() {
            var jsonElectricityOld = {}, jsonElectricityNew = {};
            var jsonWaterOld = {}, jsonWaterNew = {};

            // save old values before adjustment
            $('.left_info .electricity_standard_price').each(function(index, element) {
                jsonElectricityOld.electricity_old = {};
                $(element).find('.line').each(function(index, element) {
                    jsonElectricityOld.electricity_old[index] = {};
                    jsonElectricityOld.electricity_old[index].from = $(element).children('.from').text();
                    jsonElectricityOld.electricity_old[index].to = $(element).children('.to').text();
                    jsonElectricityOld.electricity_old[index].price = $(element).children('.price').text().replace('₫', '').replace(',','').trim();
                });
            });

            $('.left_info .water_standard_price').each(function(index, element) {
                jsonWaterOld.water_old = {};
                $(element).find('.line').each(function(index, element) {
                    jsonWaterOld.water_old[index] = {};
                    jsonWaterOld.water_old[index].from = $(element).children('.from').text();
                    jsonWaterOld.water_old[index].to = $(element).children('.to').text();
                    jsonWaterOld.water_old[index].price = $(element).children('.price').text().replace('₫', '').replace(',','').trim();
                });
            });

            $('.right_electricity_edit').click(function() {
                // replace texts with input fields
                $('.left_info .electricity_standard_price tbody tr td').each(function() {
                    $this = $(this);
                    var input = $('<input style="width: 74px;" />')
                            .attr('value', $this.text().replace('₫', '').replace(',','').trim())
                            .wrap('<td></td>');
                    $this.html('');
                    $this.append(input);
                });
            });

            $('.right_water_edit').click(function() {
                // replace texts with input fields
                $('.left_info .water_standard_price tbody tr td').each(function() {
                    $this = $(this);
                    // use attr to change value of input. .val() cannot be used here
                    var input = $('<input style="width: 74px;" />')
                            .attr('value', $this.text().replace('₫', '').replace(',','').trim())
                            .wrap('<td></td>');
                    $this.html('');
                    $this.append(input);
                });
            });

            $('input[name="updateValue"]').click(function() {
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

                $.ajax({
                    url: 'index.php?route=price/edit/updateStandardPrice&token=<?php echo $token; ?>',
                    data: {
                        'electricity_old_data': jsonElectricityOld,
                        'electricity_new_data': jsonElectricityNew,
                        'water_old_data': jsonWaterOld,
                        'water_new_data': jsonWaterNew
                    },
                    dataType: 'json',
                    type: 'post',
                    success: function(json) {
                        if (json['success']) {
                            console.log(json['success']);
                        } else {
                            console.log('ERROR!');
                        }
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
                        $('.standard_price_show').find('.line').each(function(i, e) {
                            $show = $(e);
                            $edit = $('.standard_price_edit').find('.line').eq(i);

                            var edit_f = $edit.find('.from').text();
                            var edit_t = $edit.find('.to').text();
                            var edit_p = $edit.find('.price').text().replace('₫', '').replace(',','').trim() + ' ₫';

                            $show.find('.from').text(edit_f);
                            $show.find('.to').text(edit_t);
                            $show.find('.price').text(edit_p);
                        })
                    },
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
            <td><b><?php echo $text_electricity_price; ?></b></td>
            </thead>
            <tbody>
            <?php
                if (isset($e_standard)) {
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
                if (isset($w_standard)) {
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
            <div class="left_info">
                <table class="electricity_standard_price">
                    <thead>
                        <td><b><?php echo $text_electricity_from; ?></b></td>
                        <td><b><?php echo $text_electricity_to; ?></b></td>
                        <td><b><?php echo $text_electricity_price; ?></b></td>
                    </thead>
                    <tbody>
                    <?php
                        if (isset($e_standard)) {
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
            </div>
            <div class="right_electricity_edit">
                <img src="view/image/price/edit.png" height="16" width="16" />
            </div>
        </div>

        <div class="table_water">
            <?php echo $description_water; ?>
            <div class="left_info">
                <table class="water_standard_price">
                    <thead>
                        <td><b><?php echo $text_water_from; ?></b></td>
                        <td><b><?php echo $text_water_to; ?></b></td>
                        <td><b><?php echo $text_water_price; ?></b></td>
                    </thead>
                    <tbody>
                    <?php
                        if (isset($w_standard)) {
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
            <div class="right_water_edit">
                <img src="view/image/price/edit.png" height="16" width="16" />
            </div>
            <div style="clear: both;"></div>
        </div>
    </div>
</div>
<?php echo $footer; ?>