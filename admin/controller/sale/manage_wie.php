<?php
class ControllerSaleManageWie extends Controller {
	private $error = array();
 
	public function index() {
		$this->language->load('sale/manage_wie');
 
		$this->document->setTitle($this->language->get('heading_title'));
		
 		$this->load->model('setting/setting');
		
		$this->data['action'] = $this->url->link('sale/manage_wie', 'token=' . $this->session->data['token'], 'SSL');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$this->model_setting_setting->editSetting('manage_wie', $this->request->post);		
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('sale/manage_wie', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->load->model('sale/manage_wie');
		
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
		
		$alldays = array();
		for($i = 1; $i < 32; $i ++) {
			$alldays[] = $i;
		}
		
		if ($this->config->get('default_deadline_wie')) {
			$this->data['default_deadline_wie'] = $this->config->get('default_deadline_wie');
		} else {
			$this->data['default_deadline_wie'] = 15;
		}
		
		$allyears = array();
		for($i = date("Y"); $i >2000; $i --) {
			$allyears[] = $i;
		}
		
		$block_id = 1;
		$this->load->model('sale/manage_wie');
		
		$rooms_input = $this->model_sale_manage_wie->getCustomerGroups();
		$floors_input = $this->model_sale_manage_wie->getFloors($block_id);
		
		$cur_year = date('Y');
		$cur_month = date('m');
		
		/*//floors and room
		$block_id = 1;
		$this->load->model('sale/manage_wie');
		$rooms_input = $this->model_sale_manage_wie->getCustomerGroups();
		$floors_input = $this->model_sale_manage_wie->getFloors($block_id);
		
		//get electric and water limit data
		$this->load->model('price/standard');
		$w_standard = $this->model_price_standard->getWaterStandardPrice();
        $e_standard = $this->model_price_standard->getElectricityStandardPrice();
		
		$cur_year = date('Y');
		$cur_month = date('m');
		
		$billing_wie_classified = array();
		
		foreach($floors_input as $floor_idx => $floor) {
			$data = array('floor' => $floor['floor_id']);
			$results = $this->model_sale_manage_wie->getCustomerGroups($data);
			
			foreach ($results as $result) {
				$totalmoney = 0;
				$elec = $this->model_sale_manage_wie->getElectricLogByRoomId($result['customer_group_id']);
				//echo '<br/>dien:<br/>'.print_r($elec);
				if(isset($elec)) {
					$billing_wie_classified[$result['customer_group_id']]['elec'] = $elec;
					if(isset($elec['End']) && isset($elec['Start'])) {
						$e_usage = (int)$elec['End'] - (int)$elec['Start'];
					}
					else {
						$e_usage = 0;
					}
					$billing_wie_classified[$result['customer_group_id']]['elec']['Usage'] = $e_usage;
					$money = $this->model_sale_manage_wie->calculate_money($e_standard, $e_usage);
					$billing_wie_classified[$result['customer_group_id']]['elec']['Money'] = $money;
					$totalmoney += $money;
				}
				
				$water = $this->model_sale_manage_wie->getWaterLogByRoomId($result['customer_group_id']);					
				//echo '<br/>nuoc:<br/>'.print_r($water);
				if(isset($water)) {
					$billing_wie_classified[$result['customer_group_id']]['water'] = $water ;
					if(isset($water['End']) && isset($water['Start'])) {
						$w_usage = (int)$water['End'] - (int)$water['Start'];
					}
					else {
						$w_usage = 0;
					}
					
					$billing_wie_classified[$result['customer_group_id']]['water']['Usage'] = $w_usage;
					$money = $this->model_sale_manage_wie->calculate_money($w_standard, $w_usage);
					$billing_wie_classified[$result['customer_group_id']]['water']['Money'] = $money;
					$totalmoney += $money;
				}
				
				setlocale(LC_MONETARY, 'en_US');
				$billing_wie_classified[$result['customer_group_id']]['totalmoney'] = str_replace('$','',money_format('%.0n',$totalmoney));
				$billing_wie_classified[$result['customer_group_id']]['inword'] = $this->model_sale_manage_wie->convert_number_to_words((int)$totalmoney). ' đồng';
				
				$floors_input[$floor_idx]['rooms'][] = array(
						'customer_group_id' => $result['customer_group_id'],
						'floor_id' => $result['floor_id'],
						'name'              => $result['name'] . (($result['customer_group_id'] == $this->config->get('config_manage_wie_id')) ? $this->language->get('text_default') : null),
						'sort_order'        => $result['sort_order'],
						'selected'          => isset($this->request->post['selected']) && in_array($result['manage_wie_id'], $this->request->post['selected']),
						'room_data'			=> ((isset($billing_wie_classified[$result['customer_group_id']])) ? $billing_wie_classified[$result['customer_group_id']] : null)
					);
			}	
		}
		
		
		$filter_data = array();
		if(isset($this->request->get['filter_floor'])) {
			$filter_data = array('floor' => $this->request->get['filter_floor']);
			$this->data['filter_floor'] = $this->request->get['filter_floor'];
		}
		else {
			$this->data['filter_floor'] = '';
		}
		
		if(isset($this->request->get['filter_room'])) {
			$this->data['filter_room'] = $this->request->get['filter_room'];
		}
		else {
			$this->data['filter_room'] = '';
		}
		
		
		$rooms_filter = $this->model_sale_manage_wie->getCustomerGroups($filter_data);
		$floors_filter = $this->model_sale_manage_wie->getFloors($block_id);
		
		$filtered_floor = $floors_input;
		if(isset($this->request->get['filter_floor'])) {
			$filtered_floor = array();
			foreach($floors_input as $key => $floor) {
				if((int)$floor['floor_id'] == (int)$this->request->get['filter_floor']) {
					$filtered_floor[$key] = $floor;
				}
			}
		}
		if(isset($this->request->get['filter_room'])) {
			$filtered_floor = array();
			foreach($floors_input as $key => $floor) {
				if(isset($floor['rooms'])) {
					foreach($floor['rooms'] as $ridx => $room) {
						if((int)$room['customer_group_id'] == (int)$this->request->get['filter_room']) {
							$filtered_floor[$key] = $floor;
							$filtered_floor[$key]['rooms'] = array();
							$filtered_floor[$key]['rooms'][$ridx] = $room;
						}
					}
				}
			}
		}*/
		
		$this->data['allmonths'] = $allmonths;
		$this->data['allyears'] = $allyears;
		$this->data['alldays'] = $alldays;
		//$this->data['floors_wie'] = $filtered_floor;
		//$this->data['floors_filter'] = $floors_input;
//		$this->data['rooms_filter'] = $rooms_input;
		$this->data['floors_input'] = $floors_input;
		$this->data['rooms_input'] = $rooms_input;
		$this->data['cur_year'] = $cur_year;
		$this->data['cur_month'] = $cur_month;
		$this->data['token'] = $this->session->data['token'];
		
		$this->data['text_electric_start'] = $this->language->get('text_electric_start');
		$this->data['text_water_start'] = $this->language->get('text_water_start');
		$this->data['text_deadline'] = $this->language->get('text_deadline');
		$this->data['text_save'] = $this->language->get('text_save');
		$this->data['text_edit'] = $this->language->get('text_edit');
		$this->data['text_tool'] = $this->language->get('text_tool');
		
		$this->data['text_green'] = $this->language->get('text_green');
		$this->data['text_red'] = $this->language->get('text_red');
		$this->data['text_confirm'] = $this->language->get('text_confirm');
		$this->data['text_start_num'] = $this->language->get('text_start_num');
		$this->data['text_end_num'] = $this->language->get('text_end_num');
		$this->data['text_paid'] = $this->language->get('text_paid');
		$this->data['text_late'] = $this->language->get('text_late');
		$this->data['text_refresh'] = $this->language->get('text_refresh');
		
		$this->data['text_floor'] = $this->language->get('text_floor');
		$this->data['text_room'] = $this->language->get('text_room');
		$this->data['text_totalmoney'] = $this->language->get('text_totalmoney');
		$this->data['error_input'] = $this->language->get('error_input');
		$this->data['text_success'] = $this->language->get('text_success');
		$this->data['text_title'] = $this->language->get('text_title');
		$this->data['text_start_num_electric'] = $this->language->get('text_start_num_electric');
		$this->data['text_start_num_water'] = $this->language->get('text_start_num_water');
		$this->data['text_usage_elec'] = $this->language->get('text_usage_elec');
		$this->data['text_usage_water'] = $this->language->get('text_usage_water');
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
	
	public function filterRoomByFloorView() {
		$json = array();
		
		$this->load->model('sale/manage_wie');
		$data = array();
		if(isset($this->request->post['floor_id']) && (int)$this->request->post['floor_id'] != -1) {
			$data['filter_floor'] = (int)$this->request->post['floor_id'];
		}
		if(isset($this->request->post['room_id']) && (int)$this->request->post['room_id'] != -1) {
			$data['filter_room'] = (int)$this->request->post['room_id'];
		}
		
		//$json['filter_floor'] = (int)$this->request->post['floor_id'];
		$json['floors_filtered'] = $this->model_sale_manage_wie->getCustomerGroupsView($data);
		
		$this->response->setOutput(json_encode($json));
	}
	
	public function filterRoomByFloorInput() {
		$json = array();
		
		$this->load->model('sale/manage_wie');
		$data = array();
		if(isset($this->request->post['floor_id']) && (int)$this->request->post['floor_id'] != -1) {
			$data['floor'] = (int)$this->request->post['floor_id'];
		}
		
		$json['rooms'] = $this->model_sale_manage_wie->getCustomerGroupsForInput($data);
		
		$this->response->setOutput(json_encode($json));
	}	
	
	public function filterRoomByFloorSelView() {
		$json = array();
		
		$this->load->model('sale/manage_wie');
		$data = array();
		if(isset($this->request->post['floor_id']) && (int)$this->request->post['floor_id'] != -1) {
			$data['floor'] = (int)$this->request->post['floor_id'];
		}
		
		$json['rooms'] = $this->model_sale_manage_wie->getCustomerGroups($data);
		
		$this->response->setOutput(json_encode($json));
	}	
	
	public function filterRoomByRoomIDInput() {
		$json = array();
		
		$rooms = array();
		$this->load->model('sale/manage_wie');
		if(isset($this->request->post['room_id']) && (int)$this->request->post['room_id'] != -1) {
			 $rooms[] = $this->model_sale_manage_wie->getCustomerGroupForInput((int)$this->request->post['room_id']);
		}
		
		$json['rooms'] = $rooms;
		$this->response->setOutput(json_encode($json));
	}
	
	public function inputUsage() {
		$json = array();
		
		$this->load->model('sale/manage_wie');
		$return_data = $this->model_sale_manage_wie->inputUsage($this->request->post);
		
				
		$json['success'] = $return_data;
		
		$this->response->setOutput(json_encode($json));
	}	
	
	public function confirmRoomElec() {
		$json = array();
		
		$this->load->model('sale/manage_wie');
		$result = $this->model_sale_manage_wie->confirmRoomElec($this->request->post);
		
				
		$json['success'] = $result;
		
		$this->response->setOutput(json_encode($json));
	}	
	
	public function confirmRoomWater() {
		$json = array();
		
		$this->load->model('sale/manage_wie');
		$result =  $this->model_sale_manage_wie->confirmRoomWater($this->request->post);
		
				
		$json['success'] = $result;
		
		$this->response->setOutput(json_encode($json));
	}	
	
	public function elec_charged() {
		$json = array();
		
		$this->load->model('sale/manage_wie');
		$this->model_sale_manage_wie->elec_charged((int)$this->request->post['room_id']);
		
		$json['success'] = 'yes';
		
		$this->response->setOutput(json_encode($json));
	}
	
	public function water_charged() {
		$json = array();
		
		$this->load->model('sale/manage_wie');
		$this->model_sale_manage_wie->water_charged((int)$this->request->post['room_id']);
		
		$json['success'] = 'yes';
		
		$this->response->setOutput(json_encode($json));
	}
	
	public function saveEditWie() {
		$json = array();
		
		$this->load->model('sale/manage_wie');
		$this->model_sale_manage_wie->saveEditWie($this->request->post);
		
		$json['success'] = 'yes';
		
		$this->response->setOutput(json_encode($json));
	}
}
?>