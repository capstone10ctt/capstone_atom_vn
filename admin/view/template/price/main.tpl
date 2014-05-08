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

        /* Set width values for 3 tables */
        .electricity_standard_price, .water_standard_price, {
            width: 85%;
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
    </style>
    <script type="text/javascript">
        $(function() {
            $('#btnNewStandardPrice').click(function() {
                window.location.href="index.php?route=price/edit/newStandardPriceView&token=<?php echo $token; ?>"
            });

            $('#btnHistoryStandardPrice').click(function() {
                window.location.href = "index.php?route=price/edit/historyStandardPriceView&token=<?php echo $token; ?>"
            });


            $.ajax({
                url: 'index.php?route=price/edit/updateApplyStandardElectricityPrice&token=<?php echo $token; ?>',
                dataType: 'json',
                type: 'post',
                success: function(json) {
                    $.ajax({
                        url: 'index.php?route=price/edit/getCurrentApplyDateElectricity&token=<?php echo $token; ?>',
                        dataType: 'json',
                        type: 'post',
                        success: function(json) {
                            var date = new Date(json['date']);
                            $('.electricity_apply_date').text(date.getUTCDate() + '/' + (date.getUTCMonth() + 1) + '/' + date.getUTCFullYear());
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

            $.ajax({
                url: 'index.php?route=price/edit/getCurrentApplyDateWater&token=<?php echo $token; ?>',
                dataType: 'json',
                type: 'post',
                success: function(json) {
                    var date = new Date(json['date']).toString('dd/MM/yyyy');
                    $('.water_apply_date').text(date);
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });

            $.ajax({
                url: 'index.php?route=price/edit/getCurrentApplyDateGarbage&token=<?php echo $token; ?>',
                dataType: 'json',
                type: 'post',
                success: function(json) {
                    var date = new Date(json['date']).toString('dd/MM/yyyy');
                    $('.garbage_apply_date').text(date);
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });
        });
    </script>
</head>
<div id="content">
    <div id="header"><h1><?php echo $header_current; ?></h1></div>
    <div class="com-button-panel">
        <input type="button" value="Lịch Sử" id="btnHistoryStandardPrice" />
        <input type="button" value="Thêm Mới" id="btnNewStandardPrice" />
    </div>
    <div style="clear: both;"></div>
    <div class="table_electricity">
        <?php echo '<h3>' . $description_electricity . '</h3>'; ?>
        <?php echo $valid_date_range; ?>
        <span class="electricity_apply_date"></span>
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
    </div>
    <div class="table_water">
        <?php echo '<h3>' . $description_water . '</h3>'; ?>
        <?php echo $valid_date_range; ?>
        <span class="water_apply_date"></span>
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
    </div>
    <div class="table_garbage">
        <?php echo '<h3>' . $description_garbage . '</h3>'; ?>
        <?php echo $valid_date_range; ?>
        <span class="garbage_apply_date"></span>
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
    </div>
</div>
<?php echo $footer; ?>