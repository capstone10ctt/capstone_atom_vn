<?php
class ControllerBossblogSetting extends Controller {
        private $error = array();
        private $_name = 'blogconfig';
        public function index() { 
    	$this->load->language('bossblog/setting');
        
        $this->load->model('bossblog/bossblog');
 
    	$this->document->setTitle($this->language->get('heading_title'));
        
        $this->document->addStyle('view/stylesheet/bossblog.css');
        
       	$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
		  
          
			
			$this->model_setting_setting->editSetting($this->_name, $this->request->post);
            
            if (isset($this->request->post['keyword'])) {
                
                $this->model_bossblog_bossblog->editKeyword('bossblog',$this->request->post['keyword']);
    		} 
            
			if ($this->config->get('config_currency_auto')) {
				$this->load->model('localisation/currency');
		
				$this->model_localisation_currency->updateCurrencies();
			}
            
            	
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('bossblog/setting', 'token=' . $this->session->data['token'], 'SSL'));
		}

    	$this->data['heading_title'] = $this->language->get('heading_title');
        
        /*  New Boss Blog */
         $this->data['heading_title'] = $this->language->get('heading_title');
         $this->data['text_boss_catalog'] = $this->language->get('text_boss_catalog');   
         $this->data['text_boss_category'] = $this->language->get('text_boss_category'); 
         $this->data['text_boss_articles'] = $this->language->get('text_boss_articles'); 
         $this->data['text_boss_comments'] = $this->language->get('text_boss_comments');   
         $this->data['text_boss_settings'] = $this->language->get('text_boss_settings');  
         
         $this->data['boss_category'] = $this->url->link('bossblog/category', 'token=' . $this->session->data['token'], 'SSL');
         $this->data['boss_articles'] = $this->url->link('bossblog/articles', 'token=' . $this->session->data['token'], 'SSL');
         $this->data['boss_comments'] = $this->url->link('bossblog/comment', 'token=' . $this->session->data['token'], 'SSL');
         $this->data['boss_settings'] = $this->url->link('bossblog/setting', 'token=' . $this->session->data['token'], 'SSL');
        /* End New Boss Blog */
        
        //text
        $this->data['text_items'] = $this->language->get('text_items');
        $this->data['text_article'] = $this->language->get('text_article');
        $this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
        
        //button
        $this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
        
        //tab
        $this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['tab_option'] = $this->language->get('tab_option');
		$this->data['tab_image'] = $this->language->get('tab_image');
        
        //entry
        $this->data['entry_name'] = $this->language->get('entry_name');
        $this->data['entry_image_category'] = $this->language->get('entry_image_category');
		$this->data['entry_image_thumb'] = $this->language->get('entry_image_thumb');
		$this->data['entry_image_article'] = $this->language->get('entry_image_article');
		$this->data['entry_image_related'] = $this->language->get('entry_image_related');
        $this->data['entry_bossblog_limit'] = $this->language->get('entry_bossblog_limit');
		$this->data['entry_blog_admin_limit'] = $this->language->get('entry_blog_admin_limit');
        $this->data['entry_comment'] = $this->language->get('entry_comment');
        $this->data['entry_approval'] = $this->language->get('entry_approval');
        $this->data['entry_article_count'] = $this->language->get('entry_article_count');
        $this->data['entry_keyword'] = $this->language->get('entry_keyword');

		//$this->data['text_not_found'] = $this->language->get('text_not_found');
        
        if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
 		if (isset($this->error['blog_name'])) {
			$this->data['error_blog_name'] = $this->error['blog_name'];
		} else {
			$this->data['error_blog_name'] = '';
		}
        
        if (isset($this->error['blog_image_category'])) {
			$this->data['error_blog_image_category'] = $this->error['blog_image_category'];
		} else {
			$this->data['error_blog_image_category'] = '';
		}
				
 		if (isset($this->error['blog_image_article'])) {
			$this->data['error_blog_image_article'] = $this->error['blog_image_article'];
		} else {
			$this->data['error_blog_image_article'] = '';
		}
		
 		if (isset($this->error['blog_image_related'])) {
			$this->data['error_blog_image_related'] = $this->error['blog_image_related'];
		} else {
			$this->data['error_blog_image_related'] = '';
        }
        
        if (isset($this->error['bossblog_limit'])) {
			$this->data['error_bossblog_limit'] = $this->error['bossblog_limit'];
		} else {
			$this->data['error_bossblog_limit'] = '';
		}
		
		if (isset($this->error['blog_admin_limit'])) {
			$this->data['error_blog_admin_limit'] = $this->error['blog_admin_limit'];
		} else {
			$this->data['error_blog_admin_limit'] = '';
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
			'href'      => $this->url->link('module/bossblog', 'token=' . $this->session->data['token'], 'SSL'),
			'text'      => $this->language->get('heading_bossblog'),
			'separator' => ' :: '
		);
        
        $this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('bossblog/setting', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
        
        if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
        
        $this->data['action'] = $this->url->link('bossblog/setting', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('bossblog/setting', 'token=' . $this->session->data['token'], 'SSL');
		
	//	$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->post['config_blog_name'])) {
			$this->data['config_blog_name'] = $this->request->post['config_blog_name'];
		} else {
			$this->data['config_blog_name'] = $this->config->get('config_blog_name');
		}
        
        if (isset($this->request->post['config_bossblog_limit'])) {
			$this->data['config_bossblog_limit'] = $this->request->post['config_bossblog_limit'];
		} else {
			$this->data['config_bossblog_limit'] = $this->config->get('config_bossblog_limit');
		}	
						
		if (isset($this->request->post['config_blog_admin_limit'])) {
			$this->data['config_blog_admin_limit'] = $this->request->post['config_blog_admin_limit'];
		} else {
			$this->data['config_blog_admin_limit'] = $this->config->get('config_blog_admin_limit');
		}
        	
		if (isset($this->request->post['config_comment_status'])) {
			$this->data['config_comment_status'] = $this->request->post['config_comment_status'];
		} else {
			$this->data['config_comment_status'] = $this->config->get('config_comment_status');
		}
        
        if (isset($this->request->post['config_approval_status'])) {
			$this->data['config_approval_status'] = $this->request->post['config_approval_status'];
		} else {
			$this->data['config_approval_status'] = $this->config->get('config_approval_status');
		}
        
        $keyword = $this->model_bossblog_bossblog->getKeyword('bossblog');
        
        if (isset($this->request->post['keyword'])) {
			$this->data['keyword'] = $this->request->post['keyword'];
		} elseif (isset($keyword['keyword'])) {
			$this->data['keyword'] = $keyword['keyword'];
		} else {
			$this->data['keyword'] = '';
		}

        $this->load->model('tool/image');
        
        $this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);

		if (isset($this->request->post['config_blog_image_category_width'])) {
			$this->data['config_blog_image_category_width'] = $this->request->post['config_blog_image_category_width'];
		} else {
			$this->data['config_blog_image_category_width'] = $this->config->get('config_blog_image_category_width');
		}
		
		if (isset($this->request->post['config_blog_image_category_height'])) {
			$this->data['config_blog_image_category_height'] = $this->request->post['config_blog_image_category_height'];
		} else {
			$this->data['config_blog_image_category_height'] = $this->config->get('config_blog_image_category_height');
		}
        		
		if (isset($this->request->post['config_blog_image_article_width'])) {
			$this->data['config_blog_image_article_width'] = $this->request->post['config_blog_image_article_width'];
		} else {
			$this->data['config_blog_image_article_width'] = $this->config->get('config_blog_image_article_width');
		}
		
		if (isset($this->request->post['config_blog_image_article_height'])) {
			$this->data['config_blog_image_article_height'] = $this->request->post['config_blog_image_article_height'];
		} else {
			$this->data['config_blog_image_article_height'] = $this->config->get('config_blog_image_article_height');
		}
		
		if (isset($this->request->post['config_blog_image_related_width'])) {
			$this->data['config_blog_image_related_width'] = $this->request->post['config_blog_image_related_width'];
		} else {
			$this->data['config_blog_image_related_width'] = $this->config->get('config_blog_image_related_width');
		}
		
		if (isset($this->request->post['config_blog_image_related_height'])) {
			$this->data['config_blog_image_related_height'] = $this->request->post['config_blog_image_related_height'];
		} else {
			$this->data['config_blog_image_related_height'] = $this->config->get('config_blog_image_related_height');
		}

		$this->template = 'bossblog/setting.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());	
  	}
          
    private function validate() {
		if (!$this->request->post['config_blog_name']) {
			$this->error['blog_name'] = $this->language->get('error_blog_name');
		}	
	
		if (!$this->request->post['config_blog_image_category_height'] || !$this->request->post['config_blog_image_category_width']) {
			$this->error['blog_image_category'] = $this->language->get('error_blog_image_category');
		}	
		
		if (!$this->request->post['config_blog_image_article_height'] || !$this->request->post['config_blog_image_article_width']) {
			$this->error['blog_image_article'] = $this->language->get('error_blog_image_article');
		}			
		
		if (!$this->request->post['config_blog_image_related_height'] || !$this->request->post['config_blog_image_related_width']) {
			$this->error['blog_image_related'] = $this->language->get('error_blog_image_related');
		}
		
		
		if (!$this->request->post['config_blog_admin_limit']) {
			$this->error['blog_admin_limit'] = $this->language->get('error_limit');
		}
		
		if (!$this->request->post['config_bossblog_limit']) {
			$this->error['bossblog_limit'] = $this->language->get('error_limit');
		}
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
			
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
    
}
?>