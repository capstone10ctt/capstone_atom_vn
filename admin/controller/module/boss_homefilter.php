<?php
class ControllerModuleBossHomefilter extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('module/boss_homefilter');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
		
			$this->model_setting_setting->editSetting('boss_homefilter', $this->request->post);		
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$this->data['text_home'] = $this->language->get('text_home');
		$this->data['tab_text_color_1'] = $this->language->get('tab_text_color_1');
		$this->data['tab_text_color_2'] = $this->language->get('tab_text_color_2');
		$this->data['tab_text_color_3'] = $this->language->get('tab_text_color_3');
		
		$this->data['entry_image'] = $this->language->get('entry_image');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_limit'] = $this->language->get('entry_limit');
		$this->data['entry_scroll'] = $this->language->get('entry_scroll');
		$this->data['entry_use_scrolling_panel'] = $this->language->get('entry_use_scrolling_panel');
		$this->data['entry_tab'] = $this->language->get('entry_tab');
		
		$this->data['tab_add_tab'] = $this->language->get('tab_add_tab');
		$this->data['tab_title'] = $this->language->get('tab_title');
		$this->data['tab_color'] = $this->language->get('tab_color');
		$this->data['tab_get_products_from'] = $this->language->get('tab_get_products_from');
		$this->data['tab_popular_products'] = $this->language->get('tab_popular_products');
		$this->data['tab_special_products'] = $this->language->get('tab_special_products');
		$this->data['tab_best_seller_products'] = $this->language->get('tab_best_seller_products');
		$this->data['tab_latest_products'] = $this->language->get('tab_latest_products');
		$this->data['tab_choose_a_category'] = $this->language->get('tab_choose_a_category');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');
		$this->data['button_add_image'] = $this->language->get('button_add_image');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		if (isset($this->error['category'])) {
			$this->data['error_category'] = $this->error['category'];
		} else {
			$this->data['error_category'] = array();
		}
		if (isset($this->error['numproduct'])) {
			$this->data['error_numproduct'] = $this->error['numproduct'];
		} else {
			$this->data['error_numproduct'] = array();
		}
		if (isset($this->error['scroll'])) {
			$this->data['scroll'] = $this->error['scroll'];
		} else {
			$this->data['scroll'] = array();
		}
		if (isset($this->error['image'])) {
			$this->data['error_image'] = $this->error['image'];
		} else {
			$this->data['error_image'] = array();
		}
		
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/boss_homefilter', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/boss_homefilter', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['token'] = $this->session->data['token'];
		
		// tab
		$this->data['tabs'] = array();
		
		if (isset($this->request->post['boss_homefilter_tab'])) {
			$this->data['tabs'] = $this->request->post['boss_homefilter_tab'];
		} elseif ($this->config->get('boss_homefilter_tab')) { 
			$this->data['tabs'] = $this->config->get('boss_homefilter_tab');
		}	
	
		$this->load->model('catalog/category');
		$this->data['categories'] = $this->model_catalog_category->getCategories(0);
		
		//module		
		$this->data['modules'] = array();
		
		if (isset($this->request->post['boss_homefilter_module'])) {
			$this->data['modules'] = $this->request->post['boss_homefilter_module'];
		} elseif ($this->config->get('boss_homefilter_module')) { 
			$this->data['modules'] = $this->config->get('boss_homefilter_module');
		}					
		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
		
		$this->load->model('localisation/language');
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		$this->template = 'module/boss_homefilter.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);		
		$this->response->setOutput($this->render());
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/boss_homefilter')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (isset($this->request->post['boss_homefilter_tab'])) {
			foreach ($this->request->post['boss_homefilter_tab'] as $key => $value) {
				if ($value['filter_type'] == 'category' && !isset($value['filter_type_category'])) {
					$this->error['category'][$key] = $this->language->get('error_category');
				}
			}
		}
		if (isset($this->request->post['boss_homefilter_module'])) {
			foreach ($this->request->post['boss_homefilter_module'] as $key => $value) {
				if (!$value['limit']) {
					$this->error['numproduct'][$key] = $this->language->get('error_numproduct');
				}
				if (!$value['scroll']) {
					$this->error['scroll'][$key] = $this->language->get('error_scroll');
				}
				if (!$value['image_width'] || !$value['image_height']) {
					$this->error['image'][$key] = $this->language->get('error_image');
				}
			}
		}
				
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
	
	private function getIdLayout($layout_name) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "layout WHERE LOWER(name) = LOWER('".$layout_name."')");
		return (int)$query->row['layout_id'];
	}
	
	//boss_homefilter
	public function install() 
	{
		$this->load->model('setting/setting');
		
		$this->load->model('localisation/language');
		
		$languages = $this->model_localisation_language->getLanguages();
		
		$array_title0 = array();
		$array_title1 = array();
		$array_title2  = array();		
		
		foreach($languages as $language){
			$array_title0{$language['language_id']} = 'Popular Products';
			$array_title1{$language['language_id']} = 'New Arrival';
		}
		
		$boss_homefilter = array('boss_homefilter_tab' => array ( 
			0 => array ('title' => $array_title0, 'color' =>'t_block_color_bg_2', 'filter_type' => 'popular'),
			1 => array ('title' => $array_title1, 'color' =>'t_block_color_bg_3',  'filter_type' => 'lastest')
		),'boss_homefilter_module' => array ( 
			0 => array ('image_width' => 175, 'image_height' => 216, 'limit' => 20, 'use_scrolling_panel' => 1, 'scroll' => 6, 'use_tab' => 0, 'layout_id' => $this->getIdLayout("home"), 'position' => 'content_top', 'status' => 1, 'sort_order' => 5))
		);

		$this->model_setting_setting->editSetting('boss_homefilter', $boss_homefilter);		
	}	
	
}
?>