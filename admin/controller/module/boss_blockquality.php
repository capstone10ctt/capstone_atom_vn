<?php
class ControllerModuleBossBlockquality extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->language->load('module/boss_blockquality');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('boss_blockquality', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('module/boss_blockquality', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_browse'] = $this->language->get('text_browse');
        $this->data['text_clear'] = $this->language->get('text_clear');
        $this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');
		$this->data['text_default'] = $this->language->get('text_default');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');
		$this->data['button_add_new_block'] = $this->language->get('button_add_new_block');
		
		$this->data['entry_content'] = $this->language->get('entry_content');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_store'] = $this->language->get('entry_store');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		//tab
		$this->data['tab_content'] = $this->language->get('tab_content');
		$this->data['tab_footer'] = $this->language->get('tab_footer');
		$this->data['tab_footer_1'] = $this->language->get('tab_footer_1');
		
		$this->data['tab_block'] = $this->language->get('tab_block');
		
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
			'href'      => $this->url->link('module/boss_blockquality', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/boss_blockquality', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['token'] = $this->session->data['token'];
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		$this->data['B_Block_Header_Top'] = array();
		
		if (isset($this->request->post['B_Block_Header_Top'])) {
            $B_Block_Header_Top = $this->request->post['B_Block_Header_Top'];
		} elseif ($this->config->get('B_Block_Header_Top')) { 
            $B_Block_Header_Top = $this->config->get('B_Block_Header_Top');
		} else{
			$B_Block_Header_Top = '';
		}
		
		$this->data['B_Block_Header_Top'] = $B_Block_Header_Top;
		
		$this->data['B_Block_Header_Bottom'] = array();
		
		if (isset($this->request->post['B_Block_Header_Bottom'])) {
            $B_Block_Header_Bottom = $this->request->post['B_Block_Header_Bottom'];
		} elseif ($this->config->get('B_Block_Header_Bottom')) { 
            $B_Block_Header_Bottom = $this->config->get('B_Block_Header_Bottom');
		}else{
			$B_Block_Header_Bottom = '';
		}
		
		$this->data['B_Block_Header_Bottom'] = $B_Block_Header_Bottom;
		
		$this->data['B_Block_Footer_1'] = array();
		
		if (isset($this->request->post['B_Block_Footer_1'])) {
            $B_Block_Footer_1 = $this->request->post['B_Block_Footer_1'];
		} elseif ($this->config->get('B_Block_Footer_1')) { 
            $B_Block_Footer_1 = $this->config->get('B_Block_Footer_1');
		} else{
			$B_Block_Footer_1 = '';
		}
		
		$this->data['B_Block_Footer_1'] = $B_Block_Footer_1;
		
		$this->data['B_Block_Footer_2'] = array();
		
		if (isset($this->request->post['B_Block_Footer_2'])) {
            $B_Block_Footer_2 = $this->request->post['B_Block_Footer_2'];
		} elseif ($this->config->get('B_Block_Footer_2')) { 
            $B_Block_Footer_2 = $this->config->get('B_Block_Footer_2');
		}else{
			$B_Block_Footer_2 = '';
		}
		
		$this->data['B_Block_Footer_2'] = $B_Block_Footer_2;
		
		$this->data['B_Block_Footer_3'] = array();
		
		if (isset($this->request->post['B_Block_Footer_3'])) {
            $B_Block_Footer_3 = $this->request->post['B_Block_Footer_3'];
		} elseif ($this->config->get('B_Block_Footer_3')) { 
            $B_Block_Footer_3 = $this->config->get('B_Block_Footer_3');
		}else{
			$B_Block_Footer_3 = '';
		}
		
		$this->data['B_Block_Footer_3'] = $B_Block_Footer_3;

		$this->data['modules'] = array();
		
		if (isset($this->request->post['boss_blockquality_module'])) {
			$this->data['modules'] = $this->request->post['boss_blockquality_module'];
		} elseif ($this->config->get('boss_blockquality_module')) { 
			$this->data['modules'] = $this->config->get('boss_blockquality_module');
		}	
		
		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
		
		$this->load->model('setting/store');
		
		$this->data['stores'] = $this->model_setting_store->getStores();
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
						
		$this->template = 'module/boss_blockquality.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/boss_blockquality')) {
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
		$this->load->model('setting/setting');
		
		$this->load->model('localisation/language');
			
		$languages = $this->model_localisation_language->getLanguages();
		
		$array_description_footer_0 = array();
		$array_description0 = array();
		$array_description1 = array();
		$array_description2 = array();
						
		foreach($languages as $language){
			$array_description_footer_0{$language['language_id']} = '&lt;div class=&quot;about-des&quot;&gt;&lt;a class=&quot;footer_logo&quot; href=&quot;#&quot; tilte=&quot;TopWear&quot;&gt;Topwear&lt;/a&gt;
&lt;p class=&quot;f_color_3&quot;&gt;Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.&lt;/p&gt;
&lt;a class=&quot;read-more&quot; href=&quot;#&quot;&gt;Read more&lt;/a&gt;&lt;/div&gt;';
			$array_description0{$language['language_id']} = '&lt;div class=&quot;static-home-link&quot;&gt;&lt;a href=&quot;#&quot;&gt;&lt;img alt=&quot;facebook&quot; src=&quot;http://192.168.1.101/31_TopWear/trunk/site/image/data/bt_topwear/facebook.jpg&quot; title=&quot;facebook&quot; /&gt;&lt;/a&gt;&lt;a href=&quot;#&quot;&gt;&lt;img alt=&quot;twitter&quot; src=&quot;http://192.168.1.101/31_TopWear/trunk/site/image/data/bt_topwear/twitter.jpg&quot; title=&quot;twitter&quot; /&gt;&lt;/a&gt;&lt;a href=&quot;#&quot;&gt;&lt;img alt=&quot;RSS&quot; src=&quot;http://192.168.1.101/31_TopWear/trunk/site/image/data/bt_topwear/RSS.jpg&quot; title=&quot;RSS&quot; /&gt;&lt;/a&gt;&lt;/div&gt;';
			$array_description1{$language['language_id']} = '&lt;div class=&quot;static-home-banner-1&quot;&gt;&lt;a href=&quot;#&quot;&gt;&lt;img alt=&quot;banner&quot; src=&quot;http://192.168.1.101/31_TopWear/trunk/site/image/data/bt_topwear/banner1.jpg&quot; title=&quot;banner&quot; /&gt;&lt;/a&gt; &lt;a href=&quot;#&quot;&gt;&lt;img alt=&quot;banner&quot; src=&quot;http://192.168.1.101/31_TopWear/trunk/site/image/data/bt_topwear/banner2.jpg&quot; title=&quot;banner&quot; /&gt;&lt;/a&gt;&lt;/div&gt;';
			$array_description2{$language['language_id']} = '&lt;div class=&quot;static-home-banner-2&quot;&gt;
&lt;ul&gt;
	&lt;li&gt;&lt;a href=&quot;#&quot;&gt;&lt;img alt=&quot;banner&quot; src=&quot;http://192.168.1.101/31_TopWear/trunk/site/image/data/bt_topwear/banner3.jpg&quot; title=&quot;banner&quot; /&gt;&lt;/a&gt;&lt;/li&gt;
	&lt;li&gt;&lt;a href=&quot;#&quot;&gt;&lt;img alt=&quot;banner&quot; src=&quot;http://192.168.1.101/31_TopWear/trunk/site/image/data/bt_topwear/banner4.jpg&quot; title=&quot;banner&quot; /&gt;&lt;/a&gt;&lt;/li&gt;
&lt;/ul&gt;
&lt;/div&gt;';
		}
		$boss_blockquality = array(
			'B_Block_Footer_1' =>array('content' => $array_description_footer_0, 'status' => 1, 'store_id' => array(0=>0)),
			'boss_blockquality_module' => array(
				0 => array ( 'description' => $array_description0, 'layout_id' => $this->getIdLayout("home"), 'store_id' => array(0=>0), 'position' => 'content_top', 'status' => 1, 'sort_order' => 1),
				1 => array ( 'description' => $array_description1, 'layout_id' => $this->getIdLayout("home"), 'store_id' => array(0=>0), 'position' => 'content_top', 'status' => 1, 'sort_order' => 3),
				2 => array ( 'description' => $array_description2, 'layout_id' => $this->getIdLayout("home"), 'store_id' => array(0=>0), 'position' => 'content_top', 'status' => 1, 'sort_order' => 6)
			)
		);

		$this->model_setting_setting->editSetting('boss_blockquality', $boss_blockquality);		
	}	
	


	
	
}
?>