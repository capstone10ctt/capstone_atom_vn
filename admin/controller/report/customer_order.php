<?php
class ControllerReportCustomerOrder extends Controller {
	public function index() {     
		$this->language->load('report/customer_order');

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
		if($filter_date_start=='' || $filter_date_end=='')
		{
			$data = array(
				'month_start' => date('n'),
				'year_start' => date('Y'),
				'month_end' => date('n'),
				'year_end' => date('Y')
			);
			$floors = $this->model_sale_manage_wie->getFloorView($data); 

			
			$this->data['floors'] = $floors;
		} else
		{
			$data = array(
				'month_start' => date('n', strtotime($filter_date_start)),
				'year_start' => date('Y', strtotime($filter_date_start)),
				'month_end' => date('n', strtotime($filter_date_end)),
				'year_end' => date('Y', strtotime($filter_date_end))
			);
			$floors = $this->model_sale_manage_wie->getFloorView($data); 

			
			$this->data['floors'] = $floors;
		}


		
		 
 		$this->data['heading_title'] = $this->language->get('heading_title');
		 
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_all_status'] = $this->language->get('text_all_status');
		
		$this->data['column_floor'] = $this->language->get('column_floor');
		$this->data['column_paymoney'] = $this->language->get('column_paymoney');
		$this->data['column_receivedmoney'] = $this->language->get('column_receivedmoney');
		$this->data['column_total'] = $this->language->get('column_total');
		$this->data['column_water'] = $this->language->get('column_water');
		$this->data['column_electric'] = $this->language->get('column_electric');
		$this->data['column_diff'] = $this->language->get('column_diff');
		
		$this->data['entry_date_start'] = $this->language->get('entry_date_start');
		$this->data['entry_date_end'] = $this->language->get('entry_date_end');
		$this->data['entry_status'] = $this->language->get('entry_status');

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

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}
				
		$pagination = new Pagination();
		
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('report/customer_order', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
		
		$this->data['filter_date_start'] = $filter_date_start;
		$this->data['filter_date_end'] = $filter_date_end;		
		//$this->data['filter_order_status_id'] = $filter_order_status_id;
				 
		$this->template = 'report/customer_order.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
}
?>