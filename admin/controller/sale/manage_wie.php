<?php
class ControllerSaleManageWie extends Controller {
	private $error = array();
 
	public function index() {
		$this->language->load('sale/manage_wie');
 
		$this->document->setTitle($this->language->get('heading_title'));
 		
		$this->load->model('sale/manage_wie');
		
		$this->getList();
	}

	public function insert() {
		$this->language->load('sale/manage_wie');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('sale/manage_wie');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_manage_wie->addCustomerGroup($this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('sale/manage_wie', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('sale/manage_wie');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('sale/manage_wie');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_manage_wie->editCustomerGroup($this->request->get['manage_wie_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('sale/manage_wie', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() { 
		$this->language->load('sale/manage_wie');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('sale/manage_wie');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
      		foreach ($this->request->post['selected'] as $manage_wie_id) {
				$this->model_sale_manage_wie->deleteCustomerGroup($manage_wie_id);	
			}
						
			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('sale/manage_wie', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'cgd.name';
		}
		 
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		$url = '';
		
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}	
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
			
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('sale/manage_wie', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
							
		$this->data['insert'] = $this->url->link('sale/manage_wie/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('sale/manage_wie/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');	
	
		$this->data['manage_wies'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$manage_wie_total = $this->model_sale_manage_wie->getTotalCustomerGroups();
		
		$billing_types = array(
			0 => array(
				'value' => 0,
				'text' => $this->language->get('text_electric')
			),
			1 => array(
				'value' => 1,
				'text' => $this->language->get('text_water')
			),
		);
		
		$allmonths = array();
		for($i = 1; $i < 13; $i ++) {
			$allmonths[] = $i;
		}
		
		$allyears = array();
		for($i = date("Y"); $i >2000; $i --) {
			$allyears[] = $i;
		}
		//get electric and water limit data
		$this->load->model('price/standard');
		$w_standard = $this->model_price_standard->getWaterStandardPrice();
        $e_standard = $this->model_price_standard->getElectricityStandardPrice();
		/*
        foreach ($w_standard as $row) {
            $this->data['w_standard'][] = array(
                'From' => $row['From'],
                'To' => $row['To'],
                'Price' => $row['Price']
            );
        }

        foreach ($e_standard as $row) {
            $this->data['e_standard'][] = array(
                'From' => $row['From'],
                'To'       => $row['To'],
                'Price' => $row['Price']
            );
        }*/
		
		$billing_wie_classified = array();
		
		
		$results = $this->model_sale_manage_wie->getCustomerGroups($data);

		foreach ($results as $result) {
			$totalmoney = 0;
			$months = $this->model_sale_manage_wie->getMonthHasData($result['customer_group_id']);
			foreach($months as $month) {
				$elec = $this->model_sale_manage_wie->getElectricLogByRoomId($month['month'], $month['year'], $result['customer_group_id']);
				if(isset($elec)) {
					$billing_wie_classified[$result['customer_group_id']][$month['month'].'-'.$month['year']]['elec'] = $elec;
					foreach($elec as $key => $child) {
						$e_usage = (int)$elec[$key]['End'] - (int)$elec[$key]['Start'];
						$billing_wie_classified[$result['customer_group_id']][$month['month'].'-'.$month['year']]['elec'][$key]['Usage'] = $e_usage;
						$money = $this->calculate_money($e_standard, $e_usage);
						$billing_wie_classified[$result['customer_group_id']][$month['month'].'-'.$month['year']]['elec'][$key]['Money'] = $money;
						$totalmoney += $money;
					}
					
				}
				
				$water = $this->model_sale_manage_wie->getWaterLogByRoomId($month['month'], $month['year'], $result['customer_group_id']);
				if(isset($water)) {
					$billing_wie_classified[$result['customer_group_id']][$month['month'].'-'.$month['year']]['water'] = $water ;
					foreach($water as $key => $child) {
						$w_usage = (int)$water[$key]['End'] - (int)$water[$key]['Start'];
						$billing_wie_classified[$result['customer_group_id']][$month['month'].'-'.$month['year']]['water'][$key]['Usage'] = $w_usage;
						$money = $this->calculate_money($w_standard, $w_usage);
						$billing_wie_classified[$result['customer_group_id']][$month['month'].'-'.$month['year']]['water'][$key]['Money'] = $money;
						$totalmoney += $money;
					}
				}
				
				setlocale(LC_MONETARY, 'en_US');
				$billing_wie_classified[$result['customer_group_id']][$month['month'].'-'.$month['year']]['totalmoney'] = str_replace('$','',money_format('%.0n',$totalmoney));
				$billing_wie_classified[$result['customer_group_id']][$month['month'].'-'.$month['year']]['inword'] = $this->convert_number_to_words((int)$totalmoney). ' đồng';
			}
			
			
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('sale/manage_wie/update', 'token=' . $this->session->data['token'] . '&manage_wie_id=' . $result['customer_group_id'] . $url, 'SSL')
			);		
		
			$this->data['manage_wies'][] = array(
				'customer_group_id' => $result['customer_group_id'],
				'name'              => $result['name'] . (($result['customer_group_id'] == $this->config->get('config_manage_wie_id')) ? $this->language->get('text_default') : null),
				'sort_order'        => $result['sort_order'],
				'selected'          => isset($this->request->post['selected']) && in_array($result['manage_wie_id'], $this->request->post['selected']),
				'action'            => $action
			);
		}	
		
		$this->data['billing_wie'] = $billing_wie_classified;
		$this->data['billing_types'] = $billing_types;
		$this->data['allmonths'] = $allmonths;
		$this->data['allyears'] = $allyears;
		$this->data['token'] = $this->session->data['token'];
		
		$this->data['text_totalmoney'] = $this->language->get('text_totalmoney');
		$this->data['error_input'] = $this->language->get('error_input');
		$this->data['text_success'] = $this->language->get('text_success');
		$this->data['text_title'] = $this->language->get('text_title');
		$this->data['text_start_num'] = $this->language->get('text_start_num');
		$this->data['text_end_num'] = $this->language->get('text_end_num');
		$this->data['text_usage'] = $this->language->get('text_usage');
		$this->data['text_cost'] = $this->language->get('text_cost');
		$this->data['text_header'] = $this->language->get('text_header');
		$this->data['text_submit'] = $this->language->get('text_submit');
		
		$this->data['text_limit'] = $this->language->get('text_limit');
		$this->data['text_limit_text'] = $this->language->get('text_limit_text');
		$this->data['text_price'] = $this->language->get('text_price');
		$this->data['text_total'] = $this->language->get('text_total');
		
		$this->data['text_view'] = $this->language->get('text_view');
		$this->data['text_add'] = $this->language->get('text_add');
		$this->data['text_edit'] = $this->language->get('text_edit');
		$this->data['text_header_school'] = $this->language->get('text_header_school');
		$this->data['text_electric'] = $this->language->get('text_electric');
		$this->data['text_water'] = $this->language->get('text_water');
		$this->data['text_month'] = $this->language->get('text_month');
		$this->data['text_year'] = $this->language->get('text_year');
		$this->data['text_popup_header'] = $this->language->get('text_popup_header');
		$this->data['text_greeting'] = $this->language->get('text_greeting');
		$this->data['text_select'] = $this->language->get('text_select');

		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_sort_order'] = $this->language->get('column_sort_order');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
 
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['sort_name'] = $this->url->link('sale/manage_wie', 'token=' . $this->session->data['token'] . '&sort=cgd.name' . $url, 'SSL');
		$this->data['sort_sort_order'] = $this->url->link('sale/manage_wie', 'token=' . $this->session->data['token'] . '&sort=cg.sort_order' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
				
		$pagination = new Pagination();
		$pagination->total = $manage_wie_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('sale/manage_wie', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
		
		$this->data['pagination'] = $pagination->render();				

		$this->data['sort'] = $sort; 
		$this->data['order'] = $order;

		$this->template = 'sale/manage_wie_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
 	}

	protected function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
				
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_approval'] = $this->language->get('entry_approval');
		$this->data['entry_company_id_display'] = $this->language->get('entry_company_id_display');
		$this->data['entry_company_id_required'] = $this->language->get('entry_company_id_required');
		$this->data['entry_tax_id_display'] = $this->language->get('entry_tax_id_display');
		$this->data['entry_tax_id_required'] = $this->language->get('entry_tax_id_required');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = array();
		}

		$url = '';
			
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('sale/manage_wie', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
			
		if (!isset($this->request->get['manage_wie_id'])) {
			$this->data['action'] = $this->url->link('sale/manage_wie/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('sale/manage_wie/update', 'token=' . $this->session->data['token'] . '&manage_wie_id=' . $this->request->get['manage_wie_id'] . $url, 'SSL');
		}
		  
    	$this->data['cancel'] = $this->url->link('sale/manage_wie', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['manage_wie_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$manage_wie_info = $this->model_sale_manage_wie->getCustomerGroup($this->request->get['manage_wie_id']);
		}
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (isset($this->request->post['manage_wie_description'])) {
			$this->data['manage_wie_description'] = $this->request->post['manage_wie_description'];
		} elseif (isset($this->request->get['manage_wie_id'])) {
			$this->data['manage_wie_description'] = $this->model_sale_manage_wie->getCustomerGroupDescriptions($this->request->get['manage_wie_id']);
		} else {
			$this->data['manage_wie_description'] = array();
		}	
		
		if (isset($this->request->post['approval'])) {
			$this->data['approval'] = $this->request->post['approval'];
		} elseif (!empty($manage_wie_info)) {
			$this->data['approval'] = $manage_wie_info['approval'];
		} else {
			$this->data['approval'] = '';
		}	
					
		if (isset($this->request->post['company_id_display'])) {
			$this->data['company_id_display'] = $this->request->post['company_id_display'];
		} elseif (!empty($manage_wie_info)) {
			$this->data['company_id_display'] = $manage_wie_info['company_id_display'];
		} else {
			$this->data['company_id_display'] = '';
		}			
			
		if (isset($this->request->post['company_id_required'])) {
			$this->data['company_id_required'] = $this->request->post['company_id_required'];
		} elseif (!empty($manage_wie_info)) {
			$this->data['company_id_required'] = $manage_wie_info['company_id_required'];
		} else {
			$this->data['company_id_required'] = '';
		}		
		
		if (isset($this->request->post['tax_id_display'])) {
			$this->data['tax_id_display'] = $this->request->post['tax_id_display'];
		} elseif (!empty($manage_wie_info)) {
			$this->data['tax_id_display'] = $manage_wie_info['tax_id_display'];
		} else {
			$this->data['tax_id_display'] = '';
		}			
			
		if (isset($this->request->post['tax_id_required'])) {
			$this->data['tax_id_required'] = $this->request->post['tax_id_required'];
		} elseif (!empty($manage_wie_info)) {
			$this->data['tax_id_required'] = $manage_wie_info['tax_id_required'];
		} else {
			$this->data['tax_id_required'] = '';
		}	
		
		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($manage_wie_info)) {
			$this->data['sort_order'] = $manage_wie_info['sort_order'];
		} else {
			$this->data['sort_order'] = '';
		}	
									
		$this->template = 'sale/manage_wie_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render()); 
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'sale/manage_wie')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		foreach ($this->request->post['manage_wie_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 3) || (utf8_strlen($value['name']) > 32)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'sale/manage_wie')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		$this->load->model('setting/store');
		$this->load->model('sale/customer');
      	
		foreach ($this->request->post['selected'] as $manage_wie_id) {
    		if ($this->config->get('config_manage_wie_id') == $manage_wie_id) {
	  			$this->error['warning'] = $this->language->get('error_default');	
			}  
			
			$store_total = $this->model_setting_store->getTotalStoresByCustomerGroupId($manage_wie_id);

			if ($store_total) {
				$this->error['warning'] = sprintf($this->language->get('error_store'), $store_total);
			}
			
			$customer_total = $this->model_sale_customer->getTotalCustomersByCustomerGroupId($manage_wie_id);

			if ($customer_total) {
				$this->error['warning'] = sprintf($this->language->get('error_customer'), $customer_total);
			}
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
	
	protected function convert_number_to_words($number) { 
		$hyphen      = ' '; 
		$conjunction = '  '; 
		$separator   = ' '; 
		$negative    = 'negative '; 
		$decimal     = ' point '; 
		$dictionary  = array( 
		0                   => 'không', 
		1                   => 'một', 
		2                   => 'hai', 
		3                   => 'ba', 
		4                   => 'bốn', 
		5                   => 'năm', 
		6                   => 'sáu', 
		7                   => 'bảy', 
		8                   => 'tám', 
		9                   => 'chín', 
		10                  => 'mười', 
		11                  => 'mười một', 
		12                  => 'mười hai', 
		13                  => 'mười ba', 
		14                  => 'mười bốn', 
		15                  => 'mười năm', 
		16                  => 'mười sáu', 
		17                  => 'mười bảy', 
		18                  => 'mười tám', 
		19                  => 'mười chín', 
		20                  => 'hai mươi', 
		30                  => 'ba mươi', 
		40                  => 'bốn mươi', 
		50                  => 'năm mươi', 
		60                  => 'sáu mươi', 
		70                  => 'bảy mươi', 
		80                  => 'tám mươi', 
		90                  => 'chín mươi', 
		100                 => 'trăm', 
		1000                => 'ngàn', 
		1000000             => 'triệu', 
		1000000000          => 'tỷ', 
		1000000000000       => 'nghìn tỷ', 
		1000000000000000    => 'ngàn triệu triệu', 
		1000000000000000000 => 'tỷ tỷ' 
		); 
		
		if (!is_numeric($number)) { 
			return false; 
		} 
		if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) { 
		// overflow 
		trigger_error( 
			'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, 
			E_USER_WARNING 
		); 
			return false; 
		} 
		if ($number < 0) { 
			return $negative . $this->convert_number_to_words(abs($number)); 
		} 
		
		$string = $fraction = null; 
		
		if (strpos($number, '.') !== false) { 
			list($number, $fraction) = explode('.', $number); 
		} 
		
		switch (true) { 
			case $number < 21: 
			$string = $dictionary[$number]; 
			break; 
		case $number < 100: 
			$tens   = ((int) ($number / 10)) * 10; 
			$units  = $number % 10; 
			$string = $dictionary[$tens]; 
			if ($units) { 
			$string .= $hyphen . $dictionary[$units]; 
			} 
			break; 
		case $number < 1000: 
			$hundreds  = $number / 100; 
			$remainder = $number % 100; 
			$string = $dictionary[$hundreds] . ' ' . $dictionary[100]; 
			if ($remainder) { 
			$string .= $conjunction . $this->convert_number_to_words($remainder); 
			} 
			break; 
		default: 
			$baseUnit = pow(1000, floor(log($number, 1000))); 
			$numBaseUnits = (int) ($number / $baseUnit); 
			$remainder = $number % $baseUnit; 
			$string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit]; 
			if ($remainder) { 
			$string .= $remainder < 100 ? $conjunction : $separator; 
			$string .= $this->convert_number_to_words($remainder); 
			} 
			break; 
		} 
	
		if (null !== $fraction && is_numeric($fraction)) { 
		$string .= $decimal; 
		$words = array(); 
		foreach (str_split((string) $fraction) as $number) { 
			$words[] = $dictionary[$number]; 
		} 
			$string .= implode(' ', $words); 
		} 
		
		return $string; 
	}
	
	//added by Toan
	function calculate_money($w,$e)
	{
		$money = 0;
		foreach ($w as $z)
		{
			if($z['To']!=-1 && $e>$z['To'])
			{
				$money += $z['Price']*($z['To']-$z['From']);
			}
			else
			{
				$money += $z['Price']*($e-$z['From']);
				return $money;
			}
		}
	}
	
	public function inputHistory() {
		$json = array();
		
		$this->load->model('sale/manage_wie');
		if((int)$this->request->post['type'] == 0) {
			$this->model_sale_manage_wie->inputElectricHistory($this->request->post);
		}
		else if((int)$this->request->post['type'] == 1) {
			$this->model_sale_manage_wie->inputWaterHistory($this->request->post);
		}
		
				
		$json['success'] = 'yes';
		
		$this->response->setOutput(json_encode($json));
	}	
}
?>