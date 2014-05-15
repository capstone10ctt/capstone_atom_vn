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

            var jsonLephiNew = {};
            var idApplyingLephiStandardPrice;
            var idNewestLephi = 0;

            $.ajax({
                url: 'index.php?route=lephi/lephi/loadApplyingLephiStandardId&token=<?php echo $token; ?>',
                dataType: 'json',
                type: 'post',
                success: function(json) {
                    idApplyingLephiStandardPrice = json['id'];
                    if ($('#lephi_modified_date').children('option').filter(':selected').val() == idApplyingLephiStandardPrice) {
                        $('#applyingLephiStandardPrice').show();
                        $('input[name="applyLephiStandard"]').prop('disabled', true);
                    } else {
                        $('#applyingLephiStandardPrice').hide();
                        $('input[name="applyLephiStandard"]').prop('disabled', false);
                    }
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });

            $('#dialog-update-lephi-standard').on('click', '.remove', function() {
                var $this = $(this);
                console.log($this);
                if ($this.parent().is(':first-child')) {
                    alert('Không thể xóa dòng này!');
                } else {
                    $this.parent().remove();
                }
            });

            $('#lephi_modified_date').change(function() {
                var $btnCreateNew = $('input[name="createNewLephiStandard"]');
                var $fromDate = $('#from-date-lephi');
                var $toDate = $('#to-date-lephi');
                if ($(this).children('option').filter(':selected').val() == idApplyingLephiStandardPrice) {
                    $('#applyingLephiStandardPrice').show();
                    $('input[name="applyLephiStandard"]').prop('disabled', true);
                } else {
                    $('#applyingLephiStandardPrice').hide();
                    $('input[name="applyLephiStandard"]').prop('disabled', false);
                }
                $.blockUI({ message: '<h3><span><img src="view/image/price/preloader.gif" height="16" width="16" /></span> Đang tải dữ liệu...</h3>' });
                $.ajax({
                    url: 'index.php?route=lephi/lephi/loadLephiStandardPrice&token=<?php echo $token; ?>',
                    data: { 'id' : $(this).children('option').filter(':selected').val() },
                    dataType: 'json',
                    type: 'post',
                    success: function(json) {
                        var $show = $('.standard_price_show').children('.lephi_standard_price').find('tbody');
                        var $edit = $('.standard_price_edit').find('.lephi_standard_price').find('tbody');
                        // delete all current lines in the table
                        $show.empty();
                        $edit.empty();
                        // loop all elements in a list of objects
                        for (var index in json['data']) {
                            var price = parseInt(json['data'][index]['price']);
                            // add new lines represent the standard price corresponding to the inputted date
                            $show.append('<tr class="line">' +
                                    '<td class="from">' + json['data'][index]['name'] + '</td>' +
                                    '<td class="price">' + price.format() + '&nbsp₫</td>' + // format function: convert 1234 -> 1,234
                                    '</tr>');
                            $edit.append('<tr class="line">' +
                                    '<td class="from">' + json['data'][index]['name'] + '</td>' +
                                    '<td class="price">' + price.format() + '&nbsp₫</td>' + // format function: convert 1234 -> 1,234
                                    '</tr>');
                        }
                    }, // for debugging purpose
                    error: function(xhr) {
                        console.log(xhr);
                    }
                });
            });

            $('#dialog-update-lephi-standard').dialog({
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
                    "Xác nhận": function() {
                        var $this = $(this);
                        // check that all cells are inputted
                        var checkFill = true;
                        $('#dialog-update-lephi-standard input').each(function(i, e) {
                            if ($(e).parent().parent().hasClass('line') && $(e).val() == '') {
                                checkFill = false;
                                return false;
                            }
                        });
                        var $lastRow = $('#dialog-update-lephi-standard').find('.line').last();
                        var price = $lastRow.children('.price').children().val();
                        if (price) {
                            jsonLephiNew.lephi_new = {};
                            $('#dialog-update-lephi-standard').find('.line').each(function(index, element) {
                                jsonLephiNew.lephi_new[index] = {};
                                jsonLephiNew.lephi_new[index].name = $(element).children('.name').children().val();
                                jsonLephiNew.lephi_new[index].price = $(element).children('.price').children().val();
                            });
                            var updateDateTo = '';
                            var frDate = $('#from-date-lephi').val();
                            var updateDateFrom = frDate.substr(6, 4) + '-' + frDate.substr(3, 2) + '-' + frDate.substr(0, 2);
                            if ($('#to-date-lephi').val()) {
                                var toDate = $('#to-date-lephi').val();
                                updateDateTo = toDate.substr(6, 4) + '-' + toDate.substr(3, 2) + '-' + toDate.substr(0, 2);
                            }
                            $.ajax({
                                url: 'index.php?route=lephi/lephi/updateLephiStandardPrice&token=<?php echo $token; ?>',
                                data: {
                                    'lephi_new_data': jsonLephiNew,
                                    'update_date_from': updateDateFrom,
                                    'update_date_to': updateDateTo,
                                    'id': idNewestLephi
                                },
                                dataType: 'json',
                                type: 'post',
                                success: function(json) {
                                    var arr = jsonLephiNew.lephi_new;
                                    var $show = $('.standard_price_show').children('.lephi_standard_price').find('tbody');
                                    var $edit = $('.standard_price_edit').find('.lephi_standard_price').find('tbody');
                                    $show.empty();
                                    $edit.empty();
                                    for (var index in arr) {
                                        var price = parseInt(arr[index].price);
                                        $show.append('<tr class="line">' +
                                                '<td class="name">' + arr[index].name + '</td>' +
                                                '<td class="price">' + price.format() + '&nbsp₫</td>' +
                                                '</tr>');
                                        $edit.append('<tr class="line">' +
                                                '<td class="name">' + arr[index].name + '</td>' +
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

            $('input[name="createNewLephiStandard"]').click(function() {
                if ($('#from-date-lephi').val()) {
                    var $tbody = $('#dialog-update-lephi-standard').find('tbody');
                    $tbody.empty();
                    // jQuery BlockUI (http://malsup.com/jquery/block/)
                    $.blockUI({ message: '<h3><span><img src="view/image/price/preloader.gif" height="16" width="16" /></span> Đang lấy dữ liệu...</h3>' });
                    $.ajax({
                        url: 'index.php?route=lephi/lephi/loadNewestLephiStandardPrice&token=<?php echo $token; ?>',
                        dataType: 'json',
                        type: 'post',
                        success: function(json) {
                            // open dialog after loading data successfully
                            $('#dialog-update-lephi-standard').dialog('open');
                            idNewestLephi = json['id'];
                            for (var index in json['newest']) {
                                $tbody.append('<tr class="line">' +
                                        '<td class="name"><input type="text" style="width: 74px;" value="' + json['newest'][index]['name'] + '"/></td>' +
                                        '<td class="price"><input type="text" style="width: 74px;" value="' + json['newest'][index]['price'] + '"/></td>' +
                                        '<td class="remove"><img src="view/image/price/delete.png" height="16" width="16" /></td>' +
                                        '</tr>');
                            }
                            $tbody.append('' +
                                    '<tr class="dummy-line">' +
                                    '<td class="name" style="display: none;"><input style="width: 74px;" /></td>' +
                                    '<td class="price" style="display: none;"><input style="width: 74px;" /></td>' +
                                    '<td class="remove" style="display: none;"><img src="view/image/price/delete.png" height="16" width="16" /></td>' +
                                    '</tr>' +
                                    '<tr class="plus">' +
                                    '<td><img src="view/image/price/add.png" height="16" width="16" /></td>' +
                                    '<td></td>' +
                                    '<td></td>' +
                                    '<td></td>' +
                                    '</tr>');
                            // input check
                            $('#dialog-update-lephi-standard').find('tbody').focusout(function(e) { // e: event object
                                var $this = $(e.target).closest('.line'); // e.target points to the focus-lost element
                                var $name = $this.children('.name').children();
                                var $price = $this.children('.price').children();
                                var name = $name.val();
                                var price = $price.val();
                                if (!name) {
                                    alert('Bạn phải nhập vào tên lệ phí');
                                    $name.focus().select();
                                } else if (price && (!$.isNumeric(price) || parseInt(price) < 0)) {
                                    alert('Giá trị nhập vào không hợp lệ');
                                    $price.focus().select();
                                }
                            });
                            $('.plus').on('click', function() {
                                // select dummy-line
                                $dummy = $('.dummy-line');
                                // add a new dummy-line after the default dummy-line, change the default dummy-line into a `line` and make all its children visible
                                // the new dummy-line become the default dummy-line
                                $dummy.after($dummy.outerHTML()).removeClass("dummy-line").addClass("line")
                                        .children().show(); // show newly added row
                            });
                        }, // for debugging purpose
                        error: function(xhr) {
                            console.log(xhr);
                        }
                    });
                } else {
                    alert('Bạn phải nhập ngày bắt đầu!');
                }
            });

            $('input[name="applyLephiStandard"]').click(function() {
                $('#dialog-apply-lephi-standard').dialog('open');
            });

            $('#dialog-apply-lephi-standard').dialog({
                autoOpen: false,
                draggable: true,
                resizable: false,
                position: 'center',
                modal: true,
                show: true,
                minHeight: 'auto', // auto expand height
                minWidth: 'auto',
                buttons: {
                    "Đồng ý": function() {
                        $.ajax({
                            url: 'index.php?route=lephi/lephi/applyLephiStandardPrice&token=<?php echo $token; ?>',
                            data: { 'id' : $('#lephi_modified_date').children('option').filter(':selected').val() },
                            dataType: 'json',
                            type: 'post',
                            success: function() {
                            },
                            error: function(xhr) {
                                console.log(xhr);
                            }
                        });
                        idApplyingLephiStandardPrice = $('#lephi_modified_date').children('option').filter(':selected').val();
                        $('#applyingLephiStandardPrice').show();
                        $('input[name="applyLephiStandard"]').prop('disabled', true);
                        $(this).dialog("close");
                    },
                    "Hủy bỏ": function() {
                        $(this).dialog("close");
                    }
                }
            });

            $('#from-date-lephi').datepicker({
                dateFormat: 'dd-mm-yy',
                onSelect: function(selectedDate) {
                    var dateFrom = $('#from-date-lephi').datepicker('getDate');
                    var dateTo = $('#to-date-lephi').datepicker('getDate');
                    if (dateFrom && dateTo && dateFrom > dateTo) {
                        alert('Ngày bắt đầu phải nhỏ hơn ngày kết thúc!');
                        if (!$(this).hasClass('invalid')) {
                            $(this).removeClass('valid');
                            $(this).addClass('invalid');
                        }
                    } else {
                        if (!$(this).hasClass('valid')) {
                            $(this).removeClass('invalid');
                            $(this).addClass('valid');
                        }
                    }
                    if (dateFrom < frDate) {
                        alert("Không thể chọn ngày bắt đầu trong quá khứ!");
                        if (!$(this).hasClass('invalid')) {
                            $(this).removeClass('valid');
                            $(this).addClass('invalid');
                        }
                    } else {
                        if (!$(this).hasClass('valid')) {
                            $(this).removeClass('invalid');
                            $(this).addClass('valid');
                        }
                    }
                }
            });

            $('#to-date-lephi').datepicker({
                dateFormat: 'dd-mm-yy',
                onSelect: function(selectedDate) {
                    var dateFrom = $('#from-date-lephi').datepicker('getDate');
                    var dateTo = $('#to-date-lephi').datepicker('getDate');
                    if (dateFrom && dateTo && dateFrom > dateTo) {
                        alert('Ngày bắt đầu phải nhỏ hơn ngày kết thúc!');
                        if (!$(this).hasClass('invalid')) {
                            $(this).removeClass('valid');
                            $(this).addClass('invalid');
                        }
                    } else {
                        if (!$(this).hasClass('valid')) {
                            $(this).removeClass('invalid');
                            $(this).addClass('valid');
                        }
                    }
                }
            });
            var frDate = new Date();
            //var updateDateFrom = frDate.substr(6, 4) + '-' + frDate.substr(3, 2) + '-' + frDate.substr(0, 2);
        });
    </script>
</head>
<div id="content">
    <div class="standard_price_edit" style="overflow: auto;">
        <h2>CHỈNH SỬA CÁC LOẠI PHÍ</h2>
        <div class="table_lephi">
            <?php echo '<h3>' . $description_lephi . '</h3>'; ?>
            <div id="dialog-update-lephi-standard" title="Cập nhật">
                <table>
                    <thead>
                        <td><b><?php echo $loaiphi_column; ?></b></td>
                        <td><b><?php echo $sotien_column; ?></b</td>
                        <td></td>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div>
                <?php echo $last_modified; ?>
                <select id="lephi_modified_date">
                    <?php
                    foreach ($lephi_last_modified_list as $row) {
                    $from = date("d-m-Y", strtotime($row['from']));
                    if (!empty($row['to'])) {
                        $to = date("d-m-Y", strtotime($row['to']));
                  ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $from; ?> -> <?php echo $to; ?></option>
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
                <input type="button" value="ÁP DỤNG" name="applyLephiStandard" style="float: none;" />
            </div>
            <div id="dialog-apply-lephi-standard" title="Áp dụng">
                <p>Bạn có muốn áp dụng định mức này?</p>
            </div>

            <div style="clear: both;"></div>
            <div style="width: 200px;">
                <div><p><?php echo $from_date; ?></p><input type="text" id="from-date-lephi"></div>
                <div style="clear: both;"></div>
                <div><p><?php echo $to_date; ?></p><input type="text" id="to-date-lephi"></div>
                <div style="clear: both;"></div>
            </div>
            <input type="button" value="CẬP NHẬT" name="createNewLephiStandard" style="float: none;" />
            <div class="left_info">
                <p id="applyingLephiStandardPrice" style="display: none;"><span style="color: #ff0000;">(*)</span> Bảng lệ phí đang áp dụng</p>
                <table class="lephi_standard_price">
                    <thead>
                        <td><b><?php echo $loaiphi_column; ?></b></td>
                        <td><b><?php echo $sotien_column; ?></b</td>
                    </thead>
                    <tbody>
                    <?php
                        if ($lephi) {
                            foreach ($lephi as $row) {
                        ?>
                    <tr class="line">
                        <td class="name"><?php echo $row['name']; ?></td>
                        <td class="price"><?php echo number_format($row['price']); ?>&nbsp₫</td>
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