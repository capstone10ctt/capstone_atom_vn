<?php
class ControllerReportCustomerOrder2 extends Controller {
	public function index() {     
		$this->language->load('report/customer_order2');

		$this->document->setTitle($this->language->get('heading_title'));
		
		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = '';
		}

		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = '';
		}
				
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';
		
		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}
		
		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
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
			'href'      => $this->url->link('report/customer_order', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);		
		
		$this->load->model('sale/manage_wie');
		$this->load->model('sale/customer_group');
		
		$this->data['floors'] = array();
		$this->data['rooms'] = array();
		$this->data['roomstat'] = array();
		if($filter_date_start=='' || $filter_date_end=='')
		{
			if (isset($this->request->get['filter_floor'])) {
				$data = array(
					'floor' => $this->request->get['filter_floor'],
					'month_start' => '1',
					'year_start' => '2000',
					'month_end' => date('n'),
					'year_end' => date('Y'),
					'datetime_start' => '2000-01-01 00:00:00',
					'datetime_end' => date("Y-m-d H:i:s")
				);				
			}
			else
			{
				$data = array(
					'month_start' => '1',
					'year_start' => '2000',
					'month_end' => date('n'),
					'year_end' => date('Y'),
					'datetime_start' => '2000-01-01 00:00:00',
					'datetime_end' => date("Y-m-d H:i:s")
				);			
			}
			
		} else
		{
			if (isset($this->request->get['filter_floor'])) {
				$data = array(
					'floor' => $this->request->get['filter_floor'],
					'month_start' => date('n', strtotime($filter_date_start)),
					'year_start' => date('Y', strtotime($filter_date_start)),
					'month_end' => date('n', strtotime($filter_date_end)),
					'year_end' => date('Y', strtotime($filter_date_end)),
					'datetime_start' => $filter_date_start,
					'datetime_end' => $filter_date_end
				);							
			}
			else
			{
				$data = array(
					'month_start' => date('n', strtotime($filter_date_start)),
					'year_start' => date('Y', strtotime($filter_date_start)),
					'month_end' => date('n', strtotime($filter_date_end)),
					'year_end' => date('Y', strtotime($filter_date_end)),
					'datetime_start' => $filter_date_start,
					'datetime_end' => $filter_date_end
				);
			}
		}
		$rooms = $this->model_sale_manage_wie->getChargedRoomViewById($data); 
		$this->data['rooms'] = $rooms;
		 
 		$this->data['heading_title'] = $this->language->get('heading_title');
		 
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_all'] = $this->language->get('text_all');
		
		$this->data['column_floor'] = $this->language->get('column_floor');
		$this->data['column_room'] = $this->language->get('column_room');
		$this->data['column_collectedmoney'] = $this->language->get('column_collectedmoney');
		$this->data['column_notcollectedmoney'] = $this->language->get('column_notcollectedmoney');
		$this->data['column_total'] = $this->language->get('column_total');
		$this->data['column_water'] = $this->language->get('column_water');
		$this->data['column_electric'] = $this->language->get('column_electric');
		$this->data['column_garbage'] = $this->language->get('column_garbage');
		$this->data['column_diff'] = $this->language->get('column_diff');
		$this->data['column_count'] = $this->language->get('column_count');
		$this->data['column_roomdetail'] = $this->language->get('column_roomdetail');
		$this->data['column_total_money'] = $this->language->get('column_total_money');
		$this->data['column_total_money_paid'] = $this->language->get('column_total_money_paid');
		$this->data['column_total_money_remain'] = $this->language->get('column_total_money_remain');
		$this->data['charged_date'] = $this->language->get('charged_date');
		$this->data['total_sum'] = $this->language->get('total_sum');

		$this->data['entry_date_start'] = $this->language->get('entry_date_start');
		$this->data['entry_date_end'] = $this->language->get('entry_date_end');
		$this->data['entry_floor'] = $this->language->get('entry_floor');
		$this->data['entry_room'] = $this->language->get('entry_room');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_ontime'] = $this->language->get('entry_ontime');
		$this->data['entry_late1'] = $this->language->get('entry_late1');
		$this->data['entry_late2'] = $this->language->get('entry_late2');

		$this->data['button_filter'] = $this->language->get('button_filter');
				
		$this->data['token'] = $this->session->data['token'];
		
		$this->load->model('localisation/order_status');
		
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
			
		$url = '';
						
		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}
		
		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}
		$this->data['floor_name'] = "";
		$this->data['floorlist'] = $this->model_sale_customer_group->getFloors(0);
		if (isset($this->request->get['filter_floor'])) {
			$url .= '&filter_floor=' . $this->request->get['filter_floor']; 
			
		}
				
		$pagination = new Pagination();
		
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('report/customer_order2', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
		
		$this->data['filter_date_start'] = $filter_date_start;
		$this->data['filter_date_end'] = $filter_date_end;		
				 
		$this->template = 'report/customer_order2.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
}
?>