<?php
//Heading
$_['heading_title']         = 'Template email';
$_['heading_title_install'] = 'Install Template email';

//Text
$_['text_success']          = 'Success: The changes have been saved!';
$_['text_success_install']  = 'Success: Module is already installed!';
$_['text_delete_success']   = 'Success: Some emails have been deleted!';
$_['text_cron_link']        = '<div style="background: yellow; margin-top: 5px;">Cron command: <b>wget %s -O /dev/null</b></div>';
$_['text_to']               = 'to';
$_['text_count_orders']     = '%s orders';

//Column
$_['column_template_email'] = 'E-mail subject';
$_['column_action']         = 'Action';
$_['column_id']             = 'ID';

//Tab
$_['tab_type1'] = 'Order statuses';
$_['tab_type2'] = 'Return statuses';
$_['tab_type3'] = 'Customer service';
$_['tab_type4'] = 'Mail';

//Button
$_['button_mail'] = 'New template';

//Entry
$_['entry_cron']                    = 'Cron:';
$_['entry_template_name']           = 'E-mail Subject:';
$_['entry_template_description']    = 'Message:';
$_['entry_template_status']         = 'check to not use this template:';
$_['entry_template_promo']          = 'Text promo: <span class="help">maximum 200 characters.</span>';
$_['entry_template_track']          = 'Track emails for this status:';
$_['entry_thumbnail_image_product'] = 'Thumbnail image product:';
$_['entry_generate_invoice']        = 'Generate the invoice number when you change the order status:';
$_['entry_generate_invoice_status'] = 'or if status is:';
$_['entry_send_invoice']            = 'Attach PDF invoice in email template when update order status:';
$_['entry_cron_send_invoice']             = 'Send the invoice PDF only if the order has the invoice number:';
$_['entry_cron_send_invoice_from']        = 'The Orders status completed of date from';
$_['entry_cron_send_invoice_date_empty']  = '(you can to leave fields empty or fill any field)';
$_['entry_statuses_to_admin']             = 'Notify admin using the templates:';
$_['entry_template_special']              = 'Number of products included in the e-mail promotion (0 as default):';
$_['entry_template_shortcode']         = '<b>SHORT CODE</b><table class="list"><tr><td>{firstname}</td><td>the name of the client</td></tr><tr><td>{lastname}</td><td>the last name of the client</td></tr><tr><td>{delivery_address}</td><td>delivery address</td></tr><tr><td>{shipping_address}</td><td>alias to delivery address</td></tr><tr><td>{payment_address}</td><td>payment address</td></tr><tr><td>{order_date}</td><td>date of order</td></tr><tr><td><b>{product:start}</b><br />{product_image}<br />{product_name}<br />{product_model}<br />{product_quantity}<br />{product_price}<br />{product_price_gross}<br />{product_sku}<br />{product_upc}<br />{product_tax}<br />{product_attribute}<br />{product_option}<br />{product_total}<br />{product_total_gross}<br /><b>{product:stop}</b></td><td>purchased products</td></tr><tr><td><b>{total:start}</b><br />{total_title}<br />{total_value}<br /><b>{total:stop}</b></td><td>order totals</td></tr><tr><td>{special}</td><td>in promotion</td></tr><tr><td>{date}</td><td>date of sending notice</td></tr><tr><td>{payment}</td><td>method of payment</td></tr><tr><td>{shipment}</td><td>the method of shipment</td></tr><tr><td>{order_id}</td><td>order number</td></tr><tr><td>{invoice_number}</td><td>the invoice number</td></tr><tr><td>{total}</td><td>the total for the order</td></tr><tr><td>{order_href}</td><td>link to order</td></tr><tr><td>{comment}</td><td>additional comments added in the history</td></tr><tr><td>{promo}</td><td>promo text</td></tr><tr><td>{telephone}</td><td>telephone to the customer</td></tr><tr><td>{sub_total}</td><td>the sub-total for the order</td></tr><tr><td>{shipping_cost}</td><td>shipping cost</td></tr><tr><td>{email}</td><td>client email</td></tr><tr><td>{client_comment}</td><td>comment which a customer can fill in at checkout</td></tr><tr><td><b>{tax:start}</b><br />{tax_title}<br />{tax_value}<br /><b>{tax:stop}</b></td><td>taxes</td></tr><tr><td>{tax_amount}</td><td>amount of all taxes</td></tr><tr><td>{carrier}</td><td>carrier name<br />(if you use extension Package Tracking Service)</td></tr><tr><td>{tracking_number}</td><td>tracking number<br />(if you use extension Package Tracking Service)</td></tr><tr><td>{carrier_href}</td><td>href to traking number<br />(if you use extension Package Tracking Service)</td></tr></table>';
$_['entry_template_default_shortcode'] = '<b>SHORT CODE</b><table class="list"><tr><td>{firstname}</td><td>the name of the client</td></tr><tr><td>{lastname}</td><td>the last name of the client</td></tr><tr><td>{payment_address}</td><td>payment address</td></tr><tr><td>{shipping_address}</td><td>shipping address</td></tr><tr><td>{order_date}</td><td>date of order</td></tr><tr><td><b>{product:start}</b><br />{product_image}<br />{product_name}<br />{product_model}<br />{product_quantity}<br />{product_price}<br />{product_price_gross}<br />{product_sku}<br />{product_upc}<br />{product_tax}<br />{product_attribute}<br />{product_option}<br />{product_total}<br />{product_total_gross}<br /><b>{product:stop}</b></td><td>purchased products</td></tr><tr><td><b>{total:start}</b><br />{total_title}<br />{total_value}<br /><b>{total:stop}</b></td><td>order totals</td></tr><tr><td>{special}</td><td>in promotion</td></tr><tr><td>{date}</td><td>date of sending notice</td></tr><tr><td>{payment}</td><td>method of payment</td></tr><tr><td>{shipment}</td><td>the method of shipment</td></tr><tr><td>{download}</td><td>link to downloads</td></tr><tr><td>{order_id}</td><td>order number</td></tr><tr><td>{order_href}</td><td>link to order</td></tr><tr><td>{comment}</td><td>additional comments added in the history</td></tr><tr><td>{status_name}</td><td>status name</td></tr><tr><td>{store_name}</td><td>store name</td></tr><tr><td>{ip}</td><td>client IP</td></tr><tr><td>{email}</td><td>client email</td></tr><tr><td>{telephone}</td><td>telephone to the customer</td></tr><tr><td>{store_url}</td><td>store url</td></tr><tr><td>{logo}</td><td>store logo</td></tr><tr><td>{promo}</td><td>promo text</td></tr><tr><td>{total}</td><td>the total for the order</td></tr><tr><td>{sub_total}</td><td>the sub-total for the order</td></tr><tr><td>{shipping_cost}</td><td>shipping cost</td></tr><tr><td>{client_comment}</td><td>comment which a customer can fill in at checkout</td></tr><tr><td><b>{tax:start}</b><br />{tax_title}<br />{tax_value}<br /><b>{tax:stop}</b></td><td>taxes</td></tr><tr><td>{tax_amount}</td><td>amount of all taxes</td></tr></table>';
$_['entry_template_customer_register_shortcode']            = '<b>SHORT CODE</b><table class="list"><tr><td>{firstname}</td><td>firstname</td></tr><tr><td>{lastname}</td><td>lastname</td></tr><tr><td>{date}</td><td>date of sending notice</td></tr><tr><td>{store_name}</td><td>store name</td></tr><tr><td>{email}</td><td>email</td></tr><tr><td>{password}</td><td>password</td></tr><tr><td>{account_href}</td><td>link to login</td></tr><tr><td>{activate_href}</td><td>link to activate account<br />(if you use extension Account Activation by Email)</td></tr><td>{special}</td><td>in promotion</td></tr></table>';
$_['entry_template_customer_register_approval_shortcode']   = '<b>SHORT CODE</b><table class="list"><tr><td>{firstname}</td><td>firstname</td></tr><tr><td>{lastname}</td><td>lastname</td></tr><tr><td>{date}</td><td>date of sending notice</td></tr><tr><td>{store_name}</td><td>store name</td></tr><tr><td>{email}</td><td>email</td></tr><tr><td>{password}</td><td>password<br />(shortcode not work if you use Account Activation by Email)</td></tr><tr><td>{account_href}</td><td>link to login</td></tr><tr><td>{special}</td><td>in promotion</td></tr></table>';
$_['entry_template_customer_password_reset_shortcode']      = '<b>SHORT CODE</b><table class="list"><tr><td>{firstname}</td><td>firstname</td></tr><tr><td>{lastname}</td><td>lastname</td></tr><tr><td>{date}</td><td>date of sending notice</td></tr><tr><td>{store_name}</td><td>store name</td></tr><tr><td>{email}</td><td>email</td></tr><tr><td>{password}</td><td>new password</td></tr><tr><td>{account_href}</td><td>link to login</td></tr><tr><td>{special}</td><td>in promotion</td></tr></table>';
$_['entry_template_customer_approve_shortcode']             = '<b>SHORT CODE</b><table class="list"><tr><td>{firstname}</td><td>firstname</td></tr><tr><td>{lastname}</td><td>lastname</td></tr><tr><td>{date}</td><td>date of sending notice</td></tr><tr><td>{store_name}</td><td>store name</td></tr><tr><td>{email}</td><td>email</td></tr><tr><td>{account_href}</td><td>link to login</td></tr><tr><td>{special}</td><td>in promotion</td></tr></table>';
$_['entry_template_customer_voucher_shortcode']             = '<b>SHORT CODE</b><table class="list"><tr><td>{recip_name}</td><td>recipient</td></tr><tr><td>{recip_email}</td><td>recipient email</td></tr><tr><td>{date}</td><td>date of sending notice</td></tr><tr><td>{store_name}</td><td>store name</td></tr><tr><td>{name}</td><td>sender</td></tr><tr><td>{amount}</td><td>value of the gift voucher</td></tr><tr><td>{message}</td><td>additional message</td></tr><tr><td>{store_href}</td><td>link to store</td></tr><tr><td>{image}</td><td>voucher theme</td></tr><tr><td>{code}</td><td>code</td></tr><tr><td>{special}</td><td>in promotion</td></tr></table>';
$_['entry_template_affiliate_register_shortcode']           = '<b>SHORT CODE</b><table class="list"><tr><td>{firstname}</td><td>firstname</td></tr><tr><td>{lastname}</td><td>lastname</td></tr><tr><td>{date}</td><td>date of sending notice</td></tr><tr><td>{store_name}</td><td>store name</td></tr><tr><td>{email}</td><td>email</td></tr><tr><td>{password}</td><td>password</td></tr><tr><td>{affiliate_code}</td><td>code tracking</td></tr><tr><td>{account_href}</td><td>link to affiliate login</td></tr><tr><td>{special}</td><td>in promotion</td></tr></table>';
$_['entry_template_affiliate_password_reset_shortcode']     = '<b>SHORT CODE</b><table class="list"><tr><td>{firstname}</td><td>firstname</td></tr><tr><td>{lastname}</td><td>lastname</td></tr><tr><td>{date}</td><td>date of sending notice</td></tr><tr><td>{store_name}</td><td>store name</td></tr><tr><td>{password}</td><td>new password</td></tr><tr><td>{account_href}</td><td>link to login</td></tr><tr><td>{special}</td><td>in promotion</td></tr></table>';
$_['entry_template_affiliate_approve_shortcode']            = '<b>SHORT CODE</b><table class="list"><tr><td>{firstname}</td><td>firstname</td></tr><tr><td>{lastname}</td><td>lastname</td></tr><tr><td>{date}</td><td>date of sending notice</td></tr><tr><td>{store_name}</td><td>store name</td></tr><tr><td>{email}</td><td>email</td></tr><tr><td>{account_href}</td><td>link to login</td></tr></table>';
$_['entry_template_affiliate_add_transaction_shortcode']    = '<b>SHORT CODE</b><table class="list"><tr><td>{firstname}</td><td>firstname</td></tr><tr><td>{lastname}</td><td>lastname</td></tr><tr><td>{date}</td><td>date of sending notice</td></tr><tr><td>{store_name}</td><td>store name</td></tr><tr><td>{description}</td><td>additional description</td></tr><tr><td>{order_id}</td><td>order ID</td></tr><tr><td>{amount}</td><td>commission of the order</td></tr><tr><td>{total}</td><td>total commission of orders</td></tr><tr><td>{account_href}</td><td>link to login</td></tr></table>';
$_['entry_template_affiliate_order_shortcode']              = '<b>SHORT CODE</b><table class="list"><tr><td>{firstname}</td><td>firstname</td></tr><tr><td>{lastname}</td><td>lastname</td></tr><tr><td>{date}</td><td>date of sending notice</td></tr><tr><td>{store_name}</td><td>store name</td></tr><tr><td>{commission}</td><td>commission of the order</td></tr><tr><td>{account_href}</td><td>link to login</td></tr></table>';
$_['entry_template_contact_confirmation_shortcode']         = '<b>SHORT CODE</b><table class="list"><tr><td>{firstname}</td><td>firstname</td></tr><tr><td>{email}</td><td>email</td></tr><tr><td>{date}</td><td>date of sending notice</td></tr><tr><td>{enquiry}</td><td>enquiry from user</td></tr><tr><td>{special}</td><td>in promotion</td></tr></table>';
$_['entry_template_reviews_added_shortcode']                = '<b>SHORT CODE</b><table class="list"><tr><td>{author}</td><td>author</td></tr><tr><td>{review}</td><td>review</td></tr><tr><td>{date}</td><td>date added</td></tr><tr><td>{rating}</td><td>rating</td></tr><tr><td>{product}</td><td>product name (link)</td></tr></table>';
$_['entry_template_mail_shortcode']                         = '';
$_['entry_template_cron_invoice_shortcode']                 = '<b>SHORT CODE</b><table class="list"><tr><td>{firstname}</td><td>the name of the client</td></tr><tr><td>{lastname}</td><td>the last name of the client</td></tr><tr><td>{order_date}</td><td>date of order</td></tr><tr><td>{order_id}</td><td>order number</td></tr><tr><td>{invoice_number}</td><td>the invoice number</td></tr><tr><td>{special}</td><td>in promotion</td></tr></table>';

//Error
$_['error_permission'] = 'Note: do not have permission to modify the email templates';
$_['error_warning']    = 'Note: Check the form for errors';
$_['error_name']       = 'E-mail title should have 2-180 characters';
$_['error_status_id']  = 'NOTE: The ID number is invalid';


$_['sms'] = '1';
$_['name'] = '1';
?>