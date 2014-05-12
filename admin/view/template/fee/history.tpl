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

    .com-button-panel {
        margin-right: 5em;
    }

    input[type="button"] {
        float: right;
    }
</style>
<script src="view/javascript/jquery.blockUI.js"></script>
<script type="text/javascript" src="view/javascript/datepicker-vi.js"></script>
<script type="text/javascript">
$(document).ajaxStop($.unblockUI);
$(function() {
    var isApply = 0;

    function hideElements() {
        $('.apply-time').hide();
        $('.pay-time').hide();
        $('.stay-time').hide();
        $('.fee-detail').hide();
        $('.quantity-detail').hide();
    }

    hideElements();

    $('#period-list').block({message: '<h3><span><img src="view/image/price/preloader.gif" height="16" width="16" /></span> Đang xử lý...</h3>'});

    $.ajax({
        url: 'index.php?route=fee/fee/getPeriodList&token=<?php echo $token; ?>',
        dataType: 'json',
        type: 'post',
        success: function(json) {
            for (var index in json['period-list']) {
                var period_start = json['period-list'][index]['period_start'].substr(0, 10);
                var period_end = json['period-list'][index]['period_end'].substr(0, 10);
                $('#period-list').append('<option id="' + json['period-list'][index]['period_id'] + '">' + period_start + ' -> ' + period_end + '</option>');
            }
            $('#period-list').unblock();
        },
        error: function(xhr) {
            console.log(xhr);
        }
    });

    $('#period-list').change(function() {
        if ($(this).children('option').filter(':selected').attr('id') == -1) {
            $('#button-new').show();
            $('#button-edit').hide();
            $('.apply-time').hide();
            $('.pay-time').hide();
            $('.stay-time').hide();
            $('.fee-detail').hide();
            $('.quantity-detail').hide();
        } else {
            $.blockUI({ message: '<h3><span><img src="view/image/price/preloader.gif" height="16" width="16" /></span> Đang tải dữ liệu...</h3>' });
            $.ajax({
                url: 'index.php?route=fee/fee/loadManagementInfo&token=<?php echo $token; ?>',
                data: { 'period_id' : $(this).children('option').filter(':selected').attr('id') },
                dataType: 'json',
                type: 'post',
                success: function(json) {
                    if (json['is_apply'] == 1) {
                        $('#button-new').hide();
                        $('#button-edit').show();
                    } else {
                        $('#button-new').hide();
                        $('#button-edit').hide();
                    }
                    $('.apply-time').show();
                    $('.pay-time').show();
                    $('.stay-time').show();
                    $('.fee-detail').show();
                    $('.quantity-detail').show();

                    if ($('#apply-from-date').next().is('span')) {
                        $('#apply-from-date').next().remove();
                    }
                    if ($('#apply-to-date').next().is('span')) {
                        $('#apply-to-date').next().remove();
                    }
                    if ($('#pay-from-date').next().is('span')) {
                        $('#pay-from-date').next().remove();
                    }
                    if ($('#pay-to-date').next().is('span')) {
                        $('#pay-to-date').next().remove();
                    }
                    if ($('#number-of-month').next().is('span')) {
                        $('#number-of-month').next().remove();
                    }
                    $('.fee-detail').find('tbody').empty();
                    $('.quantity-detail').find('tbody').empty();

                    $('#apply-from-date').hide();
                    $('#apply-from-date').after('<span>' + json['apply-from-date'] + '</span>');
                    $('#apply-to-date').hide();
                    $('#apply-to-date').after('<span>' + json['apply-to-date'] + '</span>');
                    $('#pay-from-date').hide();
                    $('#pay-from-date').after('<span>' + json['pay-from-date'] + '</span>');
                    $('#pay-to-date').hide();
                    $('#pay-to-date').after('<span>' + json['pay-to-date'] + '</span>');
                    $('#number-of-month').hide();
                    $('#number-of-month').after('<span>' + json['number-of-month'] + '</span>');

                    var $tbody = $('.fee-detail').find('tbody');
                    for (var index in json['fee-detail']) {
                        var name = json['fee-detail'][index]['name'];
                        var price = parseInt(json['fee-detail'][index]['price']);
                        $tbody.append('<tr class="line">' +
                                '<td class="name">' + name + '</td>' +
                                '<td class="price">' + price + '</td>' +
                                '</tr>');
                    }

                    var $tbody = $('.quantity-detail').find('tbody');
                    for (var index in json['quantity-detail']) {
                        var school = json['quantity-detail'][index]['name'];
                        var male_qty = json['quantity-detail'][index]['male_qty'];
                        var female_qty = json['quantity-detail'][index]['female_qty'];
                        $tbody.append('<tr class="line">' +
                                '<td class="school">' + school + '</td>' +
                                '<td class="male_qty">' + male_qty + '</td>' +
                                '<td class="female_qty">' + female_qty + '</td>' +
                                '</tr>');
                    }
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });
        }
    });

    $('#button-new').click(function(){
        window.location.href = "index.php?route=fee/fee/newAdmission&token=<?php echo $token; ?>"
    });

    $('#button-edit').click(function() {
        $('#apply-to-date').show();
        $('#pay-from-date').show();
        $('#pay-to-date').show();
        $('#number-of-month').show();

        $('#apply-from-date').val($.datepicker.date($('#apply-from-date').next().val()));
        $('#apply-from-date').show();
        $('#apply-to-date').next().remove();
        $('#pay-from-date').next().remove();
        $('#pay-to-date').next().remove();
        $('#number-of-month').next().remove();

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

        $('#button-confirm').click(function() {
            var applyFromDate = $('#apply-from-date').datepicker({formatDate: 'mm-dd-yy'}).val();
            var applyToDate = $('#apply-to-date').datepicker({formatDate: 'mm-dd-yy'}).val();
            var payFromDate = $('#pay-from-date').datepicker({formatDate: 'mm-dd-yy'}).val();
            var payToDate = $('#pay-to-date').datepicker({formatDate: 'mm-dd-yy'}).val();
            var numMonth = $('#number-of-month').val();
            if (!applyFromDate || !applyToDate || !payFromDate || !payToDate || numMonth == '') {
                alert('Bạn chưa nhập dữ liệu');
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

});
</script>
</head>
<div id="content">
    <div class="com-button-panel">
        <input type="button" id="button-new" value="<?php echo $button_new; ?>" />
        <input type="button" id="button-edit" value="<?php echo $button_edit; ?>" />
    </div>
    <select id="period-list">
        <option id="-1">---</option>
    </select>
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