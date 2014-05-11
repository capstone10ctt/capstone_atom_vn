<?php echo $header; ?>
<head>
    <style>
        #content {
            width: 100%;
        }

        .fee-detail {
            width: 50%;
            margin: 0 auto;
        }

        #btnConfirm {
            display: none;
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
            // outerHTML technique
            jQuery.fn.outerHTML = function(s) {
                return s
                        ? this.before(s).remove()
                        : jQuery("<p>").append(this.eq(0).clone()).html();
            };

            var jsonFeeNew = {};

            $('.fee-detail > table').block({
                message: '<h3><span><img src="view/image/price/preloader.gif" height="16" width="16" /></span> Đang xử lý...</h3>',
                css: { width: '15em' }
            });

            loadFee();

            $('.fee-detail').find('tbody').focusout(function(e) { // e: event object
                $('#btnConfirm').show();
                var $this = $(e.target).closest('.line'); // e.target points to the focus-lost element
                var $price = $this.children('.price').children();
                var price = $price.val();
                if (price && (!$.isNumeric(price) || parseInt(price) < 0)) {
                    alert('Giá trị nhập vào không hợp lệ');
                    $price.focus().select();
                }
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
                            if (index == 0) {
                                $tbody.append('<tr class="line">' +
                                        '<td class="name"><input type="text" style="width: 74px;" value="' + name + '"/></td>' +
                                        '<td class="price"><input type="text" style="width: 74px;" value="' + price + '"/>&nbsp₫</td>' + // format function: convert 1234 -> 1,234
                                        '<td class="remove"></td>' +
                                        '</tr>');
                            } else {
                                $tbody.append('<tr class="line">' +
                                        '<td class="name"><input type="text" style="width: 74px;" value="' + name + '"/></td>' +
                                        '<td class="price"><input type="text" style="width: 74px;" value="' + price + '"/>&nbsp₫</td>' + // format function: convert 1234 -> 1,234
                                        '<td class="remove"><img src="view/image/price/delete.png" height="16" width="16" /></td>' +
                                        '</tr>');
                            }
                        }
                        $tbody.append('' +
                                '<tr class="dummy-line">' +
                                '<td class="name" style="display: none;"><input style="width: 74px;"/></td>' +
                                '<td class="price" style="display: none;"><input style="width: 74px;" /></td>' +
                                '<td class="remove" style="display: none;"><img src="view/image/price/delete.png" height="16" width="16" /></td>' +
                                '</tr>' +
                                '<tr class="plus">' +
                                '<td><img src="view/image/price/add.png" height="16" width="16" /></td>' +
                                '<td></td>' +
                                '<td></td>' +
                                '<td></td>' +
                                '</tr>');
                        $('.fee-detail > table').unblock();
                    },
                    error: function(xhr) {
                        console.log(xhr);
                    }
                });
            }

            $('.fee-detail').on('click', '.plus', function() {
                // if there are any changes, display Confirm button
                $('#btnConfirm').show();
                var $nameCell = $('.fee-detail').find('.line').last().children('.name').children();
                var $priceCell = $('.fee-detail').find('.line').last().children('.price').children();
                var name = $nameCell.val();
                var price = $priceCell.val();
                if (!name || !price) {
                    alert('Bạn phải nhập giá trị cho dòng đầu tiên trước khi thêm dòng mới');
                } else {
                    // select dummy-line
                    $dummy = $('.fee-detail').find('.dummy-line');
                    // add a new dummy-line after the default dummy-line, change the default dummy-line into a `line` and make all its children visible
                    // the new dummy-line become the default dummy-line
                    $dummy.after($dummy.outerHTML()).removeClass("dummy-line").addClass("line")
                            .children().show(); // show newly added row
                }
            });

            $('.fee-detail').on('click', '#btnConfirm', function() {
                $('.fee-detail > table').block({
                    message: '<h3><span><img src="view/image/price/preloader.gif" height="16" width="16" /></span> Đang xử lý...</h3>',
                    css: { width: '15em' }
                });
                var $this = $(this);
                jsonFeeNew.fee_new = {};
                $('.fee-detail').find('.line').each(function(index, element) {
                    jsonFeeNew.fee_new[index] = {};
                    jsonFeeNew.fee_new[index].name = $(element).children('.name').children().val();
                    jsonFeeNew.fee_new[index].price = $(element).children('.price').children().val();
                });

                $.ajax({
                    url: 'index.php?route=fee/fee/updateFee&token=<?php echo $token; ?>',
                    data: {
                        'fee_new': jsonFeeNew.fee_new
                    },
                    dataType: 'json',
                    type: 'post',
                    success: function(json) {
                        $('#btnConfirm').hide();
                        $('.fee-detail').find('tbody').empty();
                        loadFee();
                    },
                    error: function(xhr) {
                        console.log(xhr);
                    }
                });

            });

            $('.fee-detail').on('click', '.remove', function() {
                var $this = $(this);
                console.log($this);
                if (!$this.parent().is(':first-child')) {
                    $this.parent().remove();
                }
            });

        });
    </script>
</head>
<div id="content">
    <div class="fee-detail">
        <?php echo '<h3>' . $description_fee . '</h3>'; ?>
        <input type="button" id="btnConfirm" value="<?php echo $button_confirm; ?>" />
        <table>
            <thead>
                <td><b><?php echo $column_fee_name; ?></b></td>
                <td><b><?php echo $column_fee; ?></b</td>
                <td></td>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<?php echo $footer; ?>