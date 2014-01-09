<?php
class ControllerModuleBossBlog extends Controller {
	private $error = array();
    private $_name = 'blogconfig';
	public function index() {
		$this->load->language('module/bossblog');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
        
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
       		'text'      => $this->language->get('text_heading'),
			'href'      => $this->url->link('module/bossblog', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
        
        $this->data['modules'] = array();
		
		if (isset($this->request->post['bossblog_module'])) {
			$this->data['modules'] = $this->request->post['bossblog_module'];
		} elseif ($this->config->get('bossblog_module')) { 
			$this->data['modules'] = $this->config->get('bossblog_module');
		}	
		
		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
						
		$this->template = 'module/bossblog.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());

	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'module/bossblog')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
    
    public function addLayout($data) {
		$name=$this->db->escape($data['name']);
		$this->deleteLayout($name);
		$this->db->query("INSERT INTO " . DB_PREFIX . "layout SET name = '" . $this->db->escape($data['name']) . "'");
		
		$layout_id = $this->db->getLastId();
		
		if (isset($data['layout_route'])) {
			foreach ($data['layout_route'] as $layout_route) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "layout_route SET layout_id = '" . (int)$layout_id . "', store_id = '" . (int)$layout_route['store_id'] . "', route = '" . $this->db->escape($layout_route['route']) . "'");
			}	
		}
	}
    
    private function deleteLayout($layout_name) {
    	$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "layout WHERE name = '".$layout_name."'");
    	if($query->num_rows){
    		$layout_id = $query->row['layout_id'];
    		$this->db->query("DELETE FROM " . DB_PREFIX . "layout WHERE layout_id = '" . (int)$layout_id . "'");
    		$this->db->query("DELETE FROM " . DB_PREFIX . "layout_route WHERE layout_id = '" . (int)$layout_id . "'");
    		$this->db->query("DELETE FROM " . DB_PREFIX . "category_to_layout WHERE layout_id = '" . (int)$layout_id . "'");
    		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_layout WHERE layout_id = '" . (int)$layout_id . "'");
    		$this->db->query("DELETE FROM " . DB_PREFIX . "information_to_layout WHERE layout_id = '" . (int)$layout_id . "'");	
    		}
   	}
    
    public function install() {
        
        $this->load->model('user/user_group');
		
		$this->model_user_user_group->addPermission($this->user->getId(), 'access', 'bossblog/category');
		$this->model_user_user_group->addPermission($this->user->getId(), 'modify', 'bossblog/category');
        
        $this->model_user_user_group->addPermission($this->user->getId(), 'access', 'bossblog/articles');
		$this->model_user_user_group->addPermission($this->user->getId(), 'modify', 'bossblog/articles');
        
        $this->model_user_user_group->addPermission($this->user->getId(), 'access', 'bossblog/comment');
		$this->model_user_user_group->addPermission($this->user->getId(), 'modify', 'bossblog/comment');
        
        $this->model_user_user_group->addPermission($this->user->getId(), 'access', 'bossblog/setting');
		$this->model_user_user_group->addPermission($this->user->getId(), 'modify', 'bossblog/setting');
        
        $this->load->model('bossblog/articles');
        
        $this->model_bossblog_articles->checkBlogArticle();
        
        $this->load->model('bossblog/category');
        
       	$this->model_bossblog_category->checkBlogCategory();
        
        $this->load->model('bossblog/comment');
        
       	$this->model_bossblog_comment->checkBlogComment();
        
        $data = array(
            'config_blog_image_related_height'  =>100,
            'config_blog_image_related_width'   =>100,
            'config_blog_image_article_height'  =>100,
            'config_blog_image_article_width'   =>100,
            'config_blog_image_category_height' =>120,
            'config_blog_image_category_width' =>720,
            'config_approval_status'            =>0,
            'config_comment_status'             =>1,
            'config_blog_admin_limit'           =>5,
            'config_bossblog_limit'             =>5,
            'config_blog_name'                  =>'Blog'
                   
        );
        
        $this->load->model('setting/setting');
        
        $this->model_setting_setting->editSetting($this->_name, $data);
			
		$special= array ('name' => 'Boss Blog', 'layout_route' => array(
        0 => array ('store_id' => 0, 'route' => 'bossblog/')) );
        
        $this->addLayout($special);	
 	}
        
    public function uninstall() {
        
        $this->load->model('setting/setting');
        
        $this->model_setting_setting->deleteSetting($this->_name);
        
        $this->load->model('bossblog/bossblog');
        
        $this->model_bossblog_bossblog->dropBlog();
    }
}
?>
