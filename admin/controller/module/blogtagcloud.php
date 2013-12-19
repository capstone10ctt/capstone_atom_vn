<?php
class ControllerModuleBlogTagCloud extends Controller {
	private $error = array();
    
	public function index() {
		$this->load->language('module/blogtagcloud');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting('blogtagcloud', $this->request->post);		
			
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
		$this->data['text_normal'] = $this->language->get('text_normal');
		$this->data['text_bold'] = $this->language->get('text_bold');
		$this->data['text_limit'] = $this->language->get('text_limit');
		$this->data['text_module_settings'] = $this->language->get('text_module_settings');
		
		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_yes'] = $this->language->get('entry_yes'); 
		$this->data['entry_no']	= $this->language->get('entry_no');
		
		$this->data['entry_template'] = $this->language->get('entry_template');
		
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_limit'] = $this->language->get('entry_limit');
		$this->data['entry_min_font_size'] = $this->language->get('entry_min_font_size');
		$this->data['entry_max_font_size'] = $this->language->get('entry_max_font_size');
		$this->data['entry_font_weight'] = $this->language->get('entry_font_weight');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
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
			'href'      => $this->url->link('module/blogtagcloud', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/blogtagcloud', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
        
        $this->data['font_weights'] = array();
			
		$this->data['font_weights'][] = array(
			'font_weight' => 'normal',
			'title'    => $this->language->get('text_normal')
		);

		$this->data['font_weights'][] = array(
			'font_weight' => 'bold',
			'title'    => $this->language->get('text_bold')
		);
		
        //module
		$this->data['modules'] = array();
		
		if (isset($this->request->post['blogtagcloud_module'])) {
			$this->data['modules'] = $this->request->post['blogtagcloud_module'];
		} elseif ($this->config->get('blogtagcloud_module')) { 
			$this->data['modules'] = $this->config->get('blogtagcloud_module');
		}				
		
		$this->load->model('design/layout');
		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		$this->load->model('localisation/language');
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		$this->template = 'module/blogtagcloud.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/blogtagcloud')) {
			$this->error['warning'] = $this->language->get('error_permission');
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
		$this->load->language('module/blogtagcloud');
       
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
			$array_description0{$language['language_id']} = 'Blog Tag Cloud';
		}
		$blogtagcloud = array('blogtagcloud_module' => array ( 
		0 => array ( 'limit' => 20, 'title' => $array_description0, 'font_weight' => 'normal','layout_id' => $this->getIdLayout("Boss Blog"), 'position' => 'column_right', 'min_font_size' => 9, 'max_font_size' => 25, 'status' => 1, 'sort_order' => 3)
		));
		
		$this->model_setting_setting->editSetting('blogtagcloud', $blogtagcloud);		
	}
    
}
?>
