<?php 
class ControllerBossblogArticles extends Controller {
	private $error = array(); 
     
  	public function index() {
		$this->load->language('bossblog/articles');
        
        $this->load->model('bossblog/articles');
    	
		$this->document->setTitle($this->language->get('heading_title')); 
        
        $this->document->addStyle('view/stylesheet/bossblog.css');
        
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
		
		$this->getList();
  	}
  
  	public function insert() {
    	$this->load->language('bossblog/articles');

    	$this->document->setTitle($this->language->get('heading_title')); 
		
		$this->load->model('bossblog/articles');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
    	   
			$this->model_bossblog_articles->addArticle($this->request->post);
	  		
			$this->session->data['success'] = $this->language->get('text_success');
	  
			$url = '';
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}
						
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
					
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('bossblog/articles', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}
	
    	$this->getForm();
  	}

  	public function update() {
    	$this->load->language('bossblog/articles');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('bossblog/articles');
	
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_bossblog_articles->editArticle($this->request->get['blog_article_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}	
		
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
					
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('bossblog/articles', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->getForm();
  	}

  	public function delete() {
    	$this->load->language('bossblog/articles');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('bossblog/articles');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $article_id) {
				$this->model_bossblog_articles->deletearticle($article_id);
	  		}

			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}
		
			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}
			
			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}	
		
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
					
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('bossblog/articles', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->getList();
  	}
	
  	private function getList() {				
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'bad.name';
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
						
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
						
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
			'href'      => $this->url->link('module/bossblog', 'token=' . $this->session->data['token'], 'SSL'),
			'text'      => $this->language->get('heading_bossblog'),
			'separator' => ' :: '
		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('bossblog/articles', 'token=' . $this->session->data['token'] . $url, 'SSL'),       		
      		'separator' => ' :: '
   		);
		
		$this->data['insert'] = $this->url->link('bossblog/articles/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');	
		$this->data['delete'] = $this->url->link('bossblog/articles/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
    	
		$this->data['articles'] = array();

		$data = array(
			'filter_name'	  => $filter_name, 
			'filter_status'   => $filter_status,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'           => $this->config->get('config_admin_limit')
		);
		
		$this->load->model('tool/image');
        
        $this->load->model('bossblog/articles');
		
		$article_total = $this->model_bossblog_articles->getTotalArticles($data);
			
		$results = $this->model_bossblog_articles->getArticles($data);
				    	
		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('bossblog/articles/update', 'token=' . $this->session->data['token'] . '&blog_article_id=' . $result['blog_article_id'] . $url, 'SSL')
			);
			
			if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
			}
	
      		$this->data['articles'][] = array(
				'blog_article_id' => $result['blog_article_id'],
				'name'       => $result['name'],
				'date_added'      => $result['date_added'],
				'date_modified'      => $result['date_modified'],
				'image'      => $image,
				'sort_order'   => $result['sort_order'],
				'status'     => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'selected'   => isset($this->request->post['selected']) && in_array($result['blog_article_id'], $this->request->post['selected']),
				'action'     => $action
			);
    	}
		
		$this->data['heading_title'] = $this->language->get('heading_title');		
				
		$this->data['text_inherited'] = $this->language->get('text_inherited');	
        $this->data['text_enabled'] = $this->language->get('text_enabled');		
		$this->data['text_disabled'] = $this->language->get('text_disabled');		
		$this->data['text_no_results'] = $this->language->get('text_no_results');		
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');		
			
		$this->data['column_image'] = $this->language->get('column_image');		
		$this->data['column_name'] = $this->language->get('column_name');		
		$this->data['column_date_added'] = $this->language->get('column_date_added');		
		$this->data['column_sort_oder'] = $this->language->get('column_sort_oder');		
		$this->data['column_date_modified'] = $this->language->get('column_date_modified');		
		$this->data['column_status'] = $this->language->get('column_status');		
		$this->data['column_action'] = $this->language->get('column_action');		
				
		$this->data['button_copy'] = $this->language->get('button_copy');		
		$this->data['button_insert'] = $this->language->get('button_insert');		
		$this->data['button_delete'] = $this->language->get('button_delete');		
		$this->data['button_filter'] = $this->language->get('button_filter');
		 
 		$this->data['token'] = $this->session->data['token'];
		
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

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
								
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
					
		$this->data['sort_name'] = $this->url->link('bossblog/articles', 'token=' . $this->session->data['token'] . '&sort=bad.name' . $url, 'SSL');
		$this->data['sort_model'] = $this->url->link('bossblog/articles', 'token=' . $this->session->data['token'] . '&sort=p.model' . $url, 'SSL');
		$this->data['sort_price'] = $this->url->link('bossblog/articles', 'token=' . $this->session->data['token'] . '&sort=p.price' . $url, 'SSL');
		$this->data['sort_quantity'] = $this->url->link('bossblog/articles', 'token=' . $this->session->data['token'] . '&sort=p.quantity' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('bossblog/articles', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, 'SSL');
		$this->data['sort_order'] = $this->url->link('bossblog/articles', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
				
		$pagination = new Pagination();
		$pagination->total = $article_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('bossblog/articles', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
	
		$this->data['filter_name'] = $filter_name;
		$this->data['filter_status'] = $filter_status;
		
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'bossblog/articles_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
  	}

  	private function getForm() {
  	 
        
        $this->document->addStyle('view/stylesheet/bossblog.css');
        
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
        
    	$this->data['heading_title'] = $this->language->get('heading_title');
 
    	$this->data['text_enabled'] = $this->language->get('text_enabled');
        $this->data['text_inherited'] = $this->language->get('text_inherited');	
    	$this->data['text_disabled'] = $this->language->get('text_disabled');
    	$this->data['text_none'] = $this->language->get('text_none');
    	$this->data['text_yes'] = $this->language->get('text_yes');
    	$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_select_all'] = $this->language->get('text_select_all');
		$this->data['text_unselect_all'] = $this->language->get('text_unselect_all');
		$this->data['text_plus'] = $this->language->get('text_plus');
		$this->data['text_minus'] = $this->language->get('text_minus');
		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');
		$this->data['text_option'] = $this->language->get('text_option');
		$this->data['text_option_value'] = $this->language->get('text_option_value');
		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_percent'] = $this->language->get('text_percent');
		$this->data['text_amount'] = $this->language->get('text_amount');

		$this->data['entry_name'] = $this->language->get('entry_name');
        $this->data['entry_author'] = $this->language->get('entry_author');
        $this->data['entry_title'] = $this->language->get('entry_title');
        $this->data['entry_article_intro'] = $this->language->get('entry_article_intro');
		$this->data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$this->data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$this->data['entry_content'] = $this->language->get('entry_content');
		$this->data['entry_store'] = $this->language->get('entry_store');
		$this->data['entry_keyword'] = $this->language->get('entry_keyword');
        $this->data['entry_date_available'] = $this->language->get('entry_date_available');
    	$this->data['entry_image'] = $this->language->get('entry_image');
        $this->data['entry_allow_comment'] = $this->language->get('entry_allow_comment');
        $this->data['entry_need_approval'] = $this->language->get('entry_need_approval');
    	$this->data['entry_category'] = $this->language->get('entry_category');
		$this->data['entry_related'] = $this->language->get('entry_related');
        $this->data['entry_related_product'] = $this->language->get('entry_related_product');
		$this->data['entry_required'] = $this->language->get('entry_required');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_tag'] = $this->language->get('entry_tag');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
        $this->data['entry_date_modified'] = $this->language->get('entry_date_modified');
				
    	$this->data['button_save'] = $this->language->get('button_save');
    	$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_image'] = $this->language->get('button_add_image');
		$this->data['button_remove'] = $this->language->get('button_remove');

    	$this->data['tab_general'] = $this->language->get('tab_general');
    	$this->data['tab_data'] = $this->language->get('tab_data');
        $this->data['tab_meta'] = $this->language->get('tab_meta');
        $this->data['tab_related'] = $this->language->get('tab_related');
        $this->data['tab_related_product'] = $this->language->get('tab_related_product');
		$this->data['tab_design'] = $this->language->get('tab_design');
		 
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
        
        if (isset($this->error['date_modified'])) {
			$this->data['date_modified'] = $this->error['date_modified'];
		} else {
			$this->data['date_modified'] = '';
		}

   		if (isset($this->error['author'])) {
			$this->data['error_author'] = $this->error['author'];
		} else {
			$this->data['error_author'] = '';
		}		
     	
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
								
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
			'href'      => $this->url->link('module/bossblog', 'token=' . $this->session->data['token'], 'SSL'),
			'text'      => $this->language->get('heading_bossblog'),
			'separator' => ' :: '
		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('bossblog/articles', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
									
		if (!isset($this->request->get['blog_article_id'])) {
			$this->data['action'] = $this->url->link('bossblog/articles/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('bossblog/articles/update', 'token=' . $this->session->data['token'] . '&blog_article_id=' . $this->request->get['blog_article_id'] . $url, 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('bossblog/articles', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['blog_article_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$article_info = $this->model_bossblog_articles->getArticle($this->request->get['blog_article_id']);
    	}

		$this->data['token'] = $this->session->data['token'];
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (isset($this->request->post['article_description'])) {
			$this->data['article_description'] = $this->request->post['article_description'];
		} elseif (isset($this->request->get['blog_article_id'])) {
			$this->data['article_description'] = $this->model_bossblog_articles->getArticleDescriptions($this->request->get['blog_article_id']);
		} else {
			$this->data['article_description'] = array();
		}
        
       if (isset($this->request->post['date_modified'])) {
       		$this->data['date_modified'] = $this->request->post['date_modified'];
		} elseif (!empty($article_info)) {
			$this->data['date_modified'] = date('Y-m-d', strtotime($article_info['date_modified']));
		} else {
			$this->data['date_modified'] = date('Y-m-d', time() - 86400);
		}	
		
		if (isset($this->request->post['author'])) {
      		$this->data['author'] = $this->request->post['author'];
    	} elseif (!empty($article_info)) {
			$this->data['author'] = $article_info['author'];
		} else {
      		$this->data['author'] = '';
    	}

		$this->load->model('setting/store');
		
		$this->data['article_stores'] = $this->model_setting_store->getStores();
		
		if (isset($this->request->post['article_store'])) {
			$this->data['article_store'] = $this->request->post['article_store'];
		} elseif (isset($this->request->get['blog_article_id'])) {
			$this->data['article_store'] = $this->model_bossblog_articles->getArticleStores($this->request->get['blog_article_id']);
		} else {
			$this->data['article_store'] = array(0);
		}	
        
       	if (isset($this->request->post['keyword'])) {
			$this->data['keyword'] = $this->request->post['keyword'];
		} elseif (!empty($article_info)) {
			$this->data['keyword'] = $article_info['keyword'];
		} else {
			$this->data['keyword'] = '';
		}
		
		if (isset($this->request->post['image'])) {
			$this->data['image'] = $this->request->post['image'];
		} elseif (!empty($article_info)) {
			$this->data['image'] = $article_info['image'];
		} else {
			$this->data['image'] = '';
		}
		
		$this->load->model('tool/image');
		
		if (isset($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
			$this->data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($article_info) && $article_info['image'] && file_exists(DIR_IMAGE . $article_info['image'])) {
			$this->data['thumb'] = $this->model_tool_image->resize($article_info['image'], 100, 100);
		} else {
			$this->data['thumb'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
        
        $this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		
		if (isset($this->request->post['sort_order'])) {
      		$this->data['sort_order'] = $this->request->post['sort_order'];
    	} elseif (!empty($article_info)) {
      		$this->data['sort_order'] = $article_info['sort_order'];
    	} else {
			$this->data['sort_order'] = 0;
		}

        
        if (isset($this->request->post['allow_comment'])) {
      		$this->data['allow_comment'] = $this->request->post['allow_comment'];
    	} elseif (!empty($article_info)) {
			$this->data['allow_comment'] = $article_info['allow_comment'];
		} else {
      		$this->data['allow_comment'] = 2;
    	}
        
        if (isset($this->request->post['need_approval'])) {
      		$this->data['need_approval'] = $this->request->post['need_approval'];
    	} elseif (!empty($article_info)) {
			$this->data['need_approval'] = $article_info['need_approval'];
		} else {
      		$this->data['need_approval'] = 2;
    	}
				
    	if (isset($this->request->post['status'])) {
      		$this->data['status'] = $this->request->post['status'];
    	} elseif (!empty($article_info)) {
			$this->data['status'] = $article_info['status'];
		} else {
      		$this->data['status'] = 1;
    	}
        
		$this->load->model('bossblog/category');
				
		$this->data['article_categories'] = $this->model_bossblog_category->getCategories(0);
		
		if (isset($this->request->post['article_category'])) {
			$this->data['article_category'] = $this->request->post['article_category'];
		} elseif (isset($this->request->get['blog_article_id'])) {
			$this->data['article_category'] = $this->model_bossblog_articles->getArticleCategories($this->request->get['blog_article_id']);
		} else {
			$this->data['article_category'] = array();
		}		
		
		if (isset($this->request->post['article_related'])) {
			$articles = $this->request->post['article_related'];
		} elseif (isset($this->request->get['blog_article_id'])) {		
			$articles = $this->model_bossblog_articles->getArticleRelated($this->request->get['blog_article_id']);
		} else {
			$articles = array();
		}
	
		$this->data['article_relateds'] = array();
		
		foreach ($articles as $article_id) {
			$related_info = $this->model_bossblog_articles->getArticle($article_id);
			
			if ($related_info) {
				$this->data['article_relateds'][] = array(
					'blog_article_id' => $related_info['blog_article_id'],
					'name'       => $related_info['name']
				);
			}
		}
        
        if (isset($this->request->post['product_related'])) {
			$products = $this->request->post['product_related'];
		} elseif (isset($this->request->get['blog_article_id'])) {		
			$products = $this->model_bossblog_articles->getBlogProductRelated($this->request->get['blog_article_id']);
		} else {
			$products = array();
		}
		$this->load->model('catalog/product');
        
        $this->data['product_relateds'] = array();
		
		foreach ($products as $product_id) {
			$related_info = $this->model_catalog_product->getProduct($product_id);
			
			if ($related_info) {
				$this->data['product_relateds'][] = array(
					'product_id' => $related_info['product_id'],
					'name'       => $related_info['name']
				);
			}
		}
        
		if (isset($this->request->post['article_layout'])) {
			$this->data['article_layout'] = $this->request->post['article_layout'];
		} elseif (isset($this->request->get['blog_article_id'])) {
			$this->data['article_layout'] = $this->model_bossblog_articles->getArticleLayouts($this->request->get['blog_article_id']);
		} else {
			$this->data['article_layout'] = array();
		}

		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
										
		$this->template = 'bossblog/articles_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
  	} 
	
  	private function validateForm() { 
    	if (!$this->user->hasPermission('modify', 'bossblog/articles')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}

    	foreach ($this->request->post['article_description'] as $language_id => $value) {
      		if ((utf8_strlen($value['name']) < 1) || (utf8_strlen($value['name']) > 255)) {
        		$this->error['name'][$language_id] = $this->language->get('error_name');
      		}
    	}
		
    	if ((utf8_strlen($this->request->post['author']) < 1) || (utf8_strlen($this->request->post['author']) > 64)) {
      		$this->error['author'] = $this->language->get('error_author');
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
	
  	private function validateDelete() {
    	if (!$this->user->hasPermission('modify', 'bossblog/articles')) {
      		$this->error['warning'] = $this->language->get('error_permission');  
    	}
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}
    
    public function autocomplete() {
		$json = array();
		
		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_category_id'])) {
			$this->load->model('bossblog/articles');
			
			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}
				
			if (isset($this->request->get['filter_category_id'])) {
				$filter_category_id = $this->request->get['filter_category_id'];
			} else {
				$filter_category_id = '';
			}
			
			if (isset($this->request->get['filter_sub_category'])) {
				$filter_sub_category = $this->request->get['filter_sub_category'];
			} else {
				$filter_sub_category = '';
			}
			
			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];	
			} else {
				$limit = 20;	
			}			
						
			$data = array(
				'filter_name'         => $filter_name,
				'filter_category_id'  => $filter_category_id,
				'filter_sub_category' => $filter_sub_category,
				'start'               => 0,
				'limit'               => $limit
			);
			
			$results = $this->model_bossblog_articles->getArticles($data);
			
			foreach ($results as $result) {	
				$json[] = array(
					'blog_article_id' => $result['blog_article_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);	
			}
		}

		$this->response->setOutput(json_encode($json));
	}
    
    	public function productauto() {
		$json = array();
		
		if (isset($this->request->get['filter_name'])) {
			$this->load->model('catalog/product');
			
			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}
				
			$data = array(
				'filter_name'         => $filter_name,
			);
			
			$results = $this->model_catalog_product->getProducts($data);
			
			foreach ($results as $result) {
				$json[] = array(
					'product_id' => $result['product_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);	
			}
		}

		$this->response->setOutput(json_encode($json));
	}
}
?>