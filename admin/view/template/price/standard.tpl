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
    	<a href="<?php echo $edit; ?>"><?php echo $text_edit; ?></a><br/><br/>
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
                if (isset($w_standard)) {
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
     
    </div>
</div>
<?php echo $footer; ?>