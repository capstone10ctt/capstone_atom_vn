<?php
class ControllerSaleCustomerGroup extends Controller {
	private $error = array();
 
	public function index() {
		$this->language->load('sale/customer_group');
 
		$this->document->setTitle($this->language->get('heading_title'));
 		
		$this->load->model('sale/customer_group');


		$this->getList();

		
	}

	public function insert() {
		$this->language->load('sale/customer_group');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('sale/customer_group');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_customer_group->addCustomerGroup($this->request->post);
			
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
			
			$this->redirect($this->url->link('sale/customer_group', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$floor_name='';
		if(isset($this->request->get['floor'])){
			$floor_name = $this->model_sale_customer_group->getFloor($this->request->get['floor']);
		}
		$this->data['heading_title'] = $this->language->get('insert_title').' '.$floor_name;
		$this->getForm();
	}

	public function update() {
		$this->language->load('sale/customer_group');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('sale/customer_group');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_customer_group->editCustomerGroup($this->request->get['customer_group_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';
			
			$this->redirect($this->url->link('sale/customer_group', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$floor_name='';
		if(isset($this->request->get['customer_group_id'])){
			$floor_name = $this->model_sale_customer_group->getFloorByRoom($this->request->get['customer_group_id']);
		}
		$this->data['heading_title'] = $this->language->get('edit_title').' '.$floor_name;
		$this->getForm();
	}

	public function delete() { 
		$this->language->load('sale/customer_group');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('sale/customer_group');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
      		foreach ($this->request->post['selected'] as $customer_group_id) {
				$this->model_sale_customer_group->deleteCustomerGroup($customer_group_id);	
			}
						
			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';
			
			$this->redirect($this->url->link('sale/customer_group', 'token=' . $this->session->data['token'] . $url, 'SSL'));
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
			'href'      => $this->url->link('sale/customer_group', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
							
		$this->data['insert'] = $this->url->link('sale/customer_group/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('sale/customer_group/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');	
		
		$this->data['blocks'] = array();
		$this->data['list_floors'] = array();
		$this->data['rooms'] = array();
			
		$blocks = $this->model_sale_customer_group->getBlocks();

		foreach ($blocks as $block) {
		
			$this->data['blocks'][] = array(
				'id' => $block['block_id'],
				'name'  => $block['block_name'] 
			);
		}



		$filter_block=0;
		$filter_floor=0;
		$filter_status=0;
		$filter_type=0;


		
		if (isset($this->request->get['filter_block'])) {
			$filter_block=$this->request->get['filter_block'];
		}
		if (isset($this->request->get['filter_floor'])) {
			$filter_floor=$this->request->get['filter_floor'];
		}
		if (isset($this->request->get['filter_status'])) {
			$filter_status=$this->request->get['filter_status'];
		}
		if (isset($this->request->get['filter_type'])) {
			$filter_type=$this->request->get['filter_type'];
		}

		if($filter_block>0)
		{
			$this->data['block_info'] = $this->model_sale_customer_group->getBlockInfo($filter_block);
		}

		$floors = $this->model_sale_customer_group->getFloors($filter_block);
		foreach ($floors as $floor) {
		
			$this->data['list_floors'][$floor['floor_id']] = $floor['floor_name'];
		}

		$data = array(
			'filter_floor'  => $filter_floor,
			'filter_status'  => $filter_status,
			'filter_type' => $filter_type
			);
		$this->data['room_types'] = $this->model_sale_customer_group->getTypes();
		$results = $this->model_sale_customer_group->getCustomerGroups($data);
		$rooms = array();
		foreach ($results as $room) {

				$action = array();
			
				$action[] = array(
				'href' => $this->url->link('sale/customer', 'token=' . $this->session->data['token'] . '&filter_customer_group_id=' . $room['customer_group_id'] . $url, 'SSL')
				);

				$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('sale/customer_group/update', 'token=' . $this->session->data['token'] . '&customer_group_id=' . $room['customer_group_id'] . $url, 'SSL')
				);		
				if (!array_key_exists($room['floor_id'], $rooms))
				{

					$rooms[$room['floor_id']] = array();
				}
				$rooms[$room['floor_id']][] = array(
					'room_id' 			=> $room['customer_group_id'],
					'name'              => $room['name'],
					'max_student'  		=> $room['max_student'],
					'type_id'  			=> $room['type_id'],
					'type'  			=> $room['type_name'],
					'assigned'  		=> $room['assigned'],
					'selected'          => isset($this->request->post['selected']) && in_array($room['customer_group_id'], $this->request->post['selected']),
					'action'            => $action
				);
			

		}

		$this->data['rooms']= $rooms;
	
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_block'] = $this->language->get('text_block');
		$this->data['text_floor'] = $this->language->get('text_floor');
		$this->data['text_room'] = $this->language->get('text_room');
		$this->data['text_status'] = $this->language->get('text_status');
		$this->data['text_view'] = $this->language->get('text_view');
		$this->data['text_info'] = $this->language->get('text_info');
		$this->data['text_numroom'] = $this->language->get('text_numroom');
		$this->data['text_numstudent'] = $this->language->get('text_numstudent');
		$this->data['text_from'] = $this->language->get('text_from');
		$this->data['text_to'] = $this->language->get('text_to');
		$this->data['text_filter'] = $this->language->get('text_filter');
		$this->data['text_numfloor'] = $this->language->get('text_numfloor');
		$this->data['text_numassigned'] = $this->language->get('text_numassigned');
		$this->data['text_numunassigned'] = $this->language->get('text_numunassigned');
		$this->data['text_numassignedboy'] = $this->language->get('text_numassignedboy');
		$this->data['text_numassignedgirl'] = $this->language->get('text_numassignedgirl');
		$this->data['text_numunassignedboy'] = $this->language->get('text_numunassignedboy');
		$this->data['text_numunassignedgirl'] = $this->language->get('text_numunassignedgirl');
		$this->data['text_all'] = $this->language->get('text_all');
		$this->data['text_full'] = $this->language->get('text_full');
		$this->data['text_notfull'] = $this->language->get('text_notfull');
		$this->data['text_empty'] = $this->language->get('text_empty');

		$this->data['column_type'] = $this->language->get('column_type');
		$this->data['column_total'] = $this->language->get('column_total');
		$this->data['column_assigned'] = $this->language->get('column_assigned');
		$this->data['column_unassigned'] = $this->language->get('column_unassigned');
		$this->data['column_detail'] = $this->language->get('column_detail');
		

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

		$this->data['sort_name'] = $this->url->link('sale/customer_group', 'token=' . $this->session->data['token'] . '&sort=cgd.name' . $url, 'SSL');
		$this->data['sort_sort_order'] = $this->url->link('sale/customer_group', 'token=' . $this->session->data['token'] . '&sort=cg.sort_order' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
				
		//$pagination = new Pagination();
		//$pagination->total = $customer_group_total;
		//$pagination->page = $page;
		//$pagination->limit = $this->config->get('config_admin_limit');
		//$pagination->text = $this->language->get('text_pagination');
		//$pagination->url = $this->url->link('sale/customer_group', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
		
		//$this->data['pagination'] = $pagination->render();				

		$this->data['sort'] = $sort; 
		$this->data['order'] = $order;

		$this->data['link'] = $this->url->link('sale/customer_group', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->template = 'sale/customer_group_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
 	}

	protected function getForm() {
		
		$this->data['text_room'] = $this->language->get('text_room');
		$this->data['text_roomleader'] = $this->language->get('text_roomleader');
		$this->data['column_type'] = $this->language->get('column_type');
		$this->data['column_total'] = $this->language->get('column_total');
				
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_description'] = $this->language->get('entry_description');
		
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
			'href'      => $this->url->link('sale/customer_group', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
			
		if (!isset($this->request->get['customer_group_id'])) {
			$this->data['action'] = $this->url->link('sale/customer_group/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('sale/customer_group/update', 'token=' . $this->session->data['token'] . '&customer_group_id=' . $this->request->get['customer_group_id'] . $url, 'SSL');
		}
		  
    	$this->data['cancel'] = $this->url->link('sale/customer_group', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['customer_group_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$customer_group_info = $this->model_sale_customer_group->getCustomerGroup($this->request->get['customer_group_id']);
		}
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (isset($this->request->post['customer_group_description'])) {
			$this->data['customer_group_description'] = $this->request->post['customer_group_description'];
		} elseif (isset($this->request->get['customer_group_id'])) {
			$this->data['customer_group_description'] = $this->model_sale_customer_group->getCustomerGroupDescriptions($this->request->get['customer_group_id']);
			$this->data['customer_group'] = $this->model_sale_customer_group->getCustomerGroup($this->request->get['customer_group_id']);
		} else {
			$this->data['customer_group_description'] = array();
		}	
		
		if (isset($this->request->post['approval'])) {
			$this->data['approval'] = $this->request->post['approval'];
		} elseif (!empty($customer_group_info)) {
			$this->data['approval'] = $customer_group_info['approval'];
		} else {
			$this->data['approval'] = '';
		}	
					
		
		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($customer_group_info)) {
			$this->data['sort_order'] = $customer_group_info['sort_order'];
		} else {
			$this->data['sort_order'] = '';
		}	
									
		$this->template = 'sale/customer_group_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->data['room_types'] = $this->model_sale_customer_group->getTypes();
		if(isset($this->request->get['customer_group_id']))
			$this->data['students'] = $this->model_sale_customer_group->getRoomStudents($this->request->get['customer_group_id']);
				
		$this->response->setOutput($this->render()); 
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'sale/customer_group')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		foreach ($this->request->post['customer_group_description'] as $language_id => $value) {
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
		if (!$this->user->hasPermission('modify', 'sale/customer_group')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		$this->load->model('setting/store');
		$this->load->model('sale/customer');
      	
		foreach ($this->request->post['selected'] as $customer_group_id) {
    		if ($this->config->get('config_customer_group_id') == $customer_group_id) {
	  			$this->error['warning'] = $this->language->get('error_default');	
			}  
			
			$store_total = $this->model_setting_store->getTotalStoresByCustomerGroupId($customer_group_id);

			if ($store_total) {
				$this->error['warning'] = sprintf($this->language->get('error_store'), $store_total);
			}
			
			$customer_total = $this->model_sale_customer->getTotalCustomersByCustomerGroupId($customer_group_id);

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
}
?>