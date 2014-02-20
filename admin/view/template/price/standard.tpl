<head>
    <style type="text/css">
        #content {
            width: 100%;
            overflow: hidden;
        }
        .standard_price {
            width: 238px;
            position: absolute;
        }
        .bill {
            margin-left: 238px;
        }
        .electricity_standard_price, .water_standard_price  {
            width: 224px;
            margin: 7px;
        }
    </style>
</head>
<?php echo $header; ?>
<div id="content">
    <div class="standard_price">
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
                <tr>
                    <td><?php echo $row['From']; ?></td>
                    <td><?php echo $row['To']; ?></td>
                    <td><?php echo number_format($row['Price']); ?>&nbsp₫</td>
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
            <tr>
                <td><?php echo $row['From']; ?></td>
                <td><?php echo $row['To']; ?></td>
                <td><?php echo number_format($row['Price']); ?>&nbsp₫</td>
            </tr>
            </tr>
            <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="bill">
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vel leo justo. Ut non dictum dolor, sodales suscipit velit. Etiam ut vestibulum est, ut blandit sem. Vivamus egestas orci feugiat, semper eros sit amet, accumsan metus. Nunc ac purus quis mauris posuere pharetra. Nam tincidunt auctor lobortis. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Phasellus vel aliquam augue. Vivamus eget ipsum at sapien porta hendrerit. Curabitur porttitor tortor fermentum tortor gravida vehicula. Quisque facilisis bibendum quam in mattis. Aenean vel nisl pellentesque nunc ornare laoreet rutrum eget mi. Aliquam erat volutpat.</p>
        <p>Etiam molestie sem a turpis sodales facilisis. Integer volutpat vehicula nisi. Ut a est metus. Aliquam ut ante et nisl dapibus adipiscing. Vestibulum mollis turpis dapibus urna pretium euismod. In hac habitasse platea dictumst. Sed id rhoncus tortor, sed viverra augue. Aliquam malesuada hendrerit nibh ac pharetra.</p>
        <p>Curabitur et pretium mi, non pellentesque arcu. Pellentesque condimentum justo ligula, et ornare turpis pellentesque vitae. Aliquam a nulla tortor. Vestibulum eget sollicitudin lectus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nunc id risus ac lacus vestibulum malesuada quis at ligula. Nullam a arcu varius, facilisis diam nec, auctor nibh. Quisque convallis lorem vel ligula rutrum vulputate.</p>
    </div>
</div>
<?php echo $footer; ?>