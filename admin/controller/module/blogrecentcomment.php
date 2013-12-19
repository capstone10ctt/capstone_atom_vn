<?php
class ControllerModuleBlogRecentComment extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('module/blogrecentcomment');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('blogrecentcomment', $this->request->post);		
			
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
        $this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');
		
		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_limit'] = $this->language->get('entry_limit');
		$this->data['entry_image'] = $this->language->get('entry_image');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_use_scrolling_panel'] = $this->language->get('entry_use_scrolling_panel');	
		$this->data['entry_scroll'] = $this->language->get('entry_scroll');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');
			
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		if (isset($this->error['limmit'])) {
			$this->data['error_limit'] = $this->error['limit'];
		} else {
			$this->data['error_limit'] = array();
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
			'href'      => $this->url->link('module/blogrecentcomment', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/blogrecentcomment', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		//module
		$this->data['modules'] = array();
		
		if (isset($this->request->post['blogrecentcomment_module'])) {
			$this->data['modules'] = $this->request->post['blogrecentcomment_module'];
		} elseif ($this->config->get('blogrecentcomment_module')) { 
			$this->data['modules'] = $this->config->get('blogrecentcomment_module');
		}				
		
		$this->load->model('design/layout');
		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		$this->load->model('localisation/language');
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		$this->template = 'module/blogrecentcomment.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/blogrecentcomment')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (isset($this->request->post['blogrecentcomment_module'])) {
			foreach ($this->request->post['blogrecentcomment_module'] as $key => $value) {
				if (!$value['limit']) {
					$this->error['limit'][$key] = $this->language->get('error_limit');
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
	

	public function install() 
	{
	    $this->load->language('module/blogrecentcomment');
       
        $this->load->model('bossblog/bossblog');
        
        $status = $this->model_bossblog_bossblog->checkBlogCode('module','bossblog');
				
		if ($status==0) {		
			
			$this->session->data['error'] = $this->language->get('text_fail');
		
		} 
        
		$this->load->model('setting/setting');
		
		$this->load->model('localisation/language');
			
		$languages = $this->model_localisation_language->getLanguages();
		
		$array_description0 = array();
						
		foreach($languages as $language){
			$array_description0{$language['language_id']} = 'Blog Recent Comment';
		}
		$blogrecentcomment = array('blogrecentcomment_module' => array ( 
		0 => array ( 'limit' => 5, 'title' => $array_description0, 'layout_id' => $this->getIdLayout("Boss Blog"), 'position' => 'column_right', 'status' => 1, 'sort_order' => 4)
		));
		
		$this->model_setting_setting->editSetting('blogrecentcomment', $blogrecentcomment);		
	}

}
?>