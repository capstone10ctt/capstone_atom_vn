<?php echo $header; ?>
<head>
    <style>
        #content {
            width: 100%;
        }

        .invalid {
            border: 1px solid #CB000F;
            color: red
        }

        .valid {
            color: #000000;
        }

        #button-edit {
            display: none;
        }
    </style>
    <script src="view/javascript/jquery.blockUI.js"></script>
    <script type="text/javascript" src="view/javascript/datepicker-vi.js"></script>
    <script type="text/javascript">
        $(document).ajaxStop($.unblockUI);
        $(function() {
            $('#apply-from-date, #apply-to-date, #pay-from-date, #pay-to-date').datepicker({
                dateFormat: 'dd-mm-yy',
                onClose: function() {
                    var applyFromDate = $('#apply-from-date').datepicker('getDate');
                    var applyToDate = $('#apply-to-date').datepicker('getDate');
                    var payFromDate = $('#pay-from-date').datepicker('getDate');
                    var payToDate = $('#pay-to-date').datepicker('getDate');
                    if (applyFromDate && applyToDate && !(applyFromDate <= applyToDate)) {
                        alert('Ngày kết thúc phải lớn hơn ngày bắt đầu');
                        $('#apply-to-date').toggleClass('invalid');
                    } else {
                        $('#apply-to-date').removeClass('invalid');
                    }
                    if (payFromDate && payToDate && !(payFromDate <= payToDate)) {
                        alert('Ngày kết thúc phải lớn hơn ngày bắt đầu');
                        $('#pay-to-date').toggleClass('invalid');
                    } else {
                        $('#pay-to-date').removeClass('invalid');
                    }
                    if (applyToDate && payFromDate && !(applyToDate < payFromDate)) {
                        alert('Ngày bắt đầu đóng tiền phải sau ngày kết thúc nộp đơn');
                        $('#pay-from-date').toggleClass('invalid');
                    } else {
                        $('#pay-from-date').removeClass('invalid');
                    }
                }
            });

            $('.fee-detail > table').block({
                message: '<h3><span><img src="view/image/price/preloader.gif" height="16" width="16" /></span> Đang xử lý...</h3>',
                css: { width: '15em' }
            });

            $('.quantity-detail > table').block({
                message: '<h3><span><img src="view/image/price/preloader.gif" height="16" width="16" /></span> Đang xử lý...</h3>',
                css: { width: '15em' }
            });

            function loadFee() {
                $.ajax({
                    url: 'index.php?route=fee/fee/loadFee&token=<?php echo $token; ?>',
                    dataType: 'json',
                    type: 'post',
                    success: function(json) {
                        var $tbody = $('.fee-detail').find('tbody');
                        for (var index in json['fee']) {
                            var name = json['fee'][index]['name'];
                            var price = parseInt(json['fee'][index]['price']);
                            $tbody.append('<tr class="line">' +
                                    '<td class="name">' + name + '</td>' +
                                    '<td class="price">' + price + '&nbsp₫</td>' + // format function: convert 1234 -> 1,234
                                    '</tr>');
                        }
                        $('.fee-detail > table').unblock();
                    },
                    error: function(xhr) {
                        console.log(xhr);
                    }
                });
            }

            function loadQuantity() {
                $.ajax({
                    url: 'index.php?route=fee/fee/loadQuantity&token=<?php echo $token; ?>',
                    dataType: 'json',
                    type: 'post',
                    success: function(json) {
                        var $tbody = $('.quantity-detail').find('tbody');
                        for (var index in json['quantity']) {
                                $tbody.append('<tr class="line">' +
                                        '<td class="school">' + json['quantity'][index]['name'] + '</td>' +
                                        '<td class="male_qty">' + json['quantity'][index]['male_qty'] + '</td>' +
                                        '<td class="female_qty">' + json['quantity'][index]['female_qty'] + '</td>' +
                                        '</tr>');
                        }
                        $('.quantity-detail > table').unblock();
                    },
                    error: function(xhr) {
                        console.log(xhr);
                    }
                });
            }

            loadFee();
            loadQuantity();

            $('#button-confirm').click(function() {
                var applyFromDate = $('#apply-from-date').datepicker({formatDate: 'mm-dd-yy'}).val();
                var applyToDate = $('#apply-to-date').datepicker({formatDate: 'mm-dd-yy'}).val();
                var payFromDate = $('#pay-from-date').datepicker({formatDate: 'mm-dd-yy'}).val();
                var payToDate = $('#pay-to-date').datepicker({formatDate: 'mm-dd-yy'}).val();
                var numMonth = $('#number-of-month').val();
                if (!applyFromDate || !applyToDate || !payFromDate || !payToDate || numMonth == '') {
                    alert('B?n ch?a nh?p ?? d? li?u');
                } else {
                    $.blockUI({ message: '<h3><span><img src="view/image/price/preloader.gif" height="16" width="16" /></span> Đang xử lý...</h3>' });
                    $.ajax({
                        url: 'index.php?route=fee/fee/updateFeeManagement&token=<?php echo $token; ?>',
                        data: {
                            'apply-from-date': applyFromDate,
                            'apply-to-date': applyToDate,
                            'pay-from-date': payFromDate,
                            'pay-to-date': payToDate,
                            'num-of-month': numMonth
                        },
                        dataType: 'json',
                        type: 'post',
                        success: function(json) {
                            $.unblockUI();
                            // display Edit button
                            $('#button-edit').show();
                            // hide Confirm and Cancel button
                            $('#button-confirm').hide();
                            $('#button-cancel').hide();
                            // change from input textbox into text

                            $('#apply-from-date').hide();
                            $('#apply-from-date').after('<span>' + applyFromDate + '</span>');
                            $('#apply-to-date').hide();
                            $('#apply-to-date').after('<span>' + applyToDate + '</span>');
                            $('#pay-from-date').hide();
                            $('#pay-from-date').after('<span>' + payFromDate + '</span>');
                            $('#pay-to-date').hide();
                            $('#pay-to-date').after('<span>' + payToDate + '</span>');
                            $('#number-of-month').hide();
                            $('#number-of-month').after('<span>' + numMonth + '</span>');
                        },
                        error: function(xhr) {
                            console.log(xhr);
                        }
                    });
                }
            });

            $('#button-edit').click(function() {
                $('.apply-time').block({
                    message: '<h3><span><img src="view/image/price/preloader.gif" height="16" width="16" /></span> Đang xử lý...</h3>',
                    css: { width: '15em' }
                });
                $('.pay-time').block({
                    message: '<h3><span><img src="view/image/price/preloader.gif" height="16" width="16" /></span> Đang xử lý...</h3>',
                    css: { width: '15em' }
                });
                $('.stay-time').block({
                    message: '<h3><span><img src="view/image/price/preloader.gif" height="16" width="16" /></span> Đang xử lý...</h3>',
                    css: { width: '15em' }
                });

                $.ajax({
                    url: 'index.php?route=fee/fee/getApplyFromDate&token=<?php echo $token; ?>',
                    dataType: 'json',
                    type: 'post',
                    success: function(json) {
                        console.log(json['apply-from-date']);
                        $('#apply-from-date').next().remove();
                        $('#apply-from-date').val(json['apply-from-date']);
                        $('#apply-from-date').show();
                        $.ajax({
                            url: 'index.php?route=fee/fee/getApplyToDate&token=<?php echo $token; ?>',
                            dataType: 'json',
                            type: 'post',
                            success: function(json) {
                                $('#apply-to-date').next().remove();
                                $('#apply-to-date').val(json['apply-to-date']);
                                $('#apply-to-date').show();
                                $('.apply-time').unblock();

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
                    url: 'index.php?route=fee/fee/getPayFromDate&token=<?php echo $token; ?>',
                    dataType: 'json',
                    type: 'post',
                    success: function(json) {
                        $('#pay-from-date').next().remove();
                        $('#pay-from-date').val(json['pay-from-date']);
                        $('#pay-from-date').show();
                        $.ajax({
                            url: 'index.php?route=fee/fee/getPayToDate&token=<?php echo $token; ?>',
                            dataType: 'json',
                            type: 'post',
                            success: function(json) {
                                $('#pay-to-date').next().remove();
                                $('#pay-to-date').val(json['pay-to-date']);
                                $('#pay-to-date').show();
                                $('.pay-time').unblock();
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
                    url: 'index.php?route=fee/fee/getNumberOfMonth&token=<?php echo $token; ?>',
                    dataType: 'json',
                    type: 'post',
                    success: function(json) {
                        $('#number-of-month').next().remove();
                        $('#number-of-month').val(json['number-of-month']);
                        $('#number-of-month').show();
                        $('.stay-time').unblock();
                    },
                    error: function(xhr) {
                        console.log(xhr);
                    }
                });

                $('#button-confirm').show();
                $('#button-cancel').show();
                $('#button-edit').hide();
            });

            $('#button-cancel').click(function() {
                window.location.href = "index.php?route=fee/fee/viewHistory&token=<?php echo $token; ?>"
            });
        });
    </script>
</head>
<div id="content">
    <div class="com-button-panel">
        <input type="button" id="button-confirm" value="<?php echo $button_confirm; ?>" />
        <input type="button" id="button-cancel" value="<?php echo $button_cancel; ?>" />
        <input type="button" id="button-edit" value="<?php echo $button_edit; ?>" />
    </div>
    <div class="apply-time">
        <?php echo '<h3>' . $description_apply . '</h3>'; ?>
        <label for="apply-from-date"><?php echo $text_from_date; ?></label>
        <input type="text" id="apply-from-date" />
        <label for="apply-to-date"?><?php echo $text_to_date; ?></label>
        <input type="text" id="apply-to-date" />
    </div>
    <div class="pay-time">
        <?php echo '<h3>' . $description_pay . '</h3>'; ?>
        <label for="pay-from-date"><?php echo $text_from_date; ?></label>
        <input type="text" id="pay-from-date" />
        <label for="pay-to-date"><?php echo $text_to_date; ?></label>
        <input type="text" id="pay-to-date" />
    </div>
    <div class="stay-time">
        <?php echo '<h3>' . $description_stay_time . '</h3>'; ?>
        <label for="number-of-month"><?php echo $text_number_of_month; ?></label>
        <input type="text" id="number-of-month" />
    </div>
    <div class="fee-detail">
        <?php echo '<h3>' . $description_fee . '</h3>'; ?>
        <table>
            <thead>
            <td><b><?php echo $column_fee_name; ?></b></td>
            <td><b><?php echo $column_fee; ?></b</td>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div class="quantity-detail">
        <?php echo '<h3>' . $description_quantity . '</h3>'; ?>
        <table>
            <thead>
            <td><b><?php echo $column_quantity_school; ?></b></td>
            <td><b><?php echo $column_quantity_male; ?></b</td>
            <td><b><?php echo $column_quantity_female; ?></b></td>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<?php echo $footer; ?>