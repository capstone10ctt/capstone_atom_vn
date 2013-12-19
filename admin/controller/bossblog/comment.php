<?php
class ControllerBossblogComment extends Controller {
	private $error = array();
 
	public function index() {
		$this->load->language('bossblog/comment');
        
        $this->load->model('bossblog/comment');

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
		$this->load->language('bossblog/comment');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('bossblog/comment');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_bossblog_comment->addComment($this->request->post);
			
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
						
			$this->redirect($this->url->link('bossblog/comment', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$this->load->language('bossblog/comment');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('bossblog/comment');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_bossblog_comment->editComment($this->request->get['blog_comment_id'], $this->request->post);
			
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
						
			$this->redirect($this->url->link('bossblog/comment', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() { 
		$this->load->language('bossblog/comment');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('bossblog/comment');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $blog_comment_id) {
				$this->model_bossblog_comment->deleteComment($blog_comment_id);
			}

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
						
			$this->redirect($this->url->link('bossblog/comment', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	private function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'bc.date_added';
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
			'href'      => $this->url->link('module/bossblog', 'token=' . $this->session->data['token'], 'SSL'),
			'text'      => $this->language->get('heading_bossblog'),
			'separator' => ' :: '
		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('bossblog/comment', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
							
		$this->data['insert'] = $this->url->link('bossblog/comment/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('bossblog/comment/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');	

		$this->data['comments'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
        
        $this->load->model('bossblog/comment');
		
		$comment_total = $this->model_bossblog_comment->getTotalComments();
	
		$results = $this->model_bossblog_comment->getComments($data);
 
    	foreach ($results as $result) {
			$action = array();
						
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('bossblog/comment/update', 'token=' . $this->session->data['token'] . '&blog_comment_id=' . $result['blog_comment_id'] . $url, 'SSL')
			);
						
			$this->data['comments'][] = array(
				'blog_comment_id'  => $result['blog_comment_id'],
				'name'       => $result['name'],
				'author'     => $result['author'],
                'text' => utf8_substr(strip_tags(html_entity_decode($result['text'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
				'email'     => $result['email'],
				'status'     => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'selected'   => isset($this->request->post['selected']) && in_array($result['review_id'], $this->request->post['selected']),
				'action'     => $action
			);
		}	
	
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_article'] = $this->language->get('column_article');
		$this->data['column_author'] = $this->language->get('column_author');
		$this->data['column_email'] = $this->language->get('column_email');
        $this->data['column_comment'] = $this->language->get('column_comment');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
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
		
		$this->data['sort_article'] = $this->url->link('bossblog/comment', 'token=' . $this->session->data['token'] . '&sort=bad.name' . $url, 'SSL');
		$this->data['sort_author'] = $this->url->link('bossblog/comment', 'token=' . $this->session->data['token'] . '&sort=bc.author' . $url, 'SSL');
		$this->data['sort_email'] = $this->url->link('bossblog/comment', 'token=' . $this->session->data['token'] . '&sort=bc.email' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('bossblog/comment', 'token=' . $this->session->data['token'] . '&sort=bc.status' . $url, 'SSL');
		$this->data['sort_date_added'] = $this->url->link('bossblog/comment', 'token=' . $this->session->data['token'] . '&sort=bc.date_added' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $comment_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('bossblog/comment', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'bossblog/comment_list.tpl';
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
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_select'] = $this->language->get('text_select');

		$this->data['entry_article'] = $this->language->get('entry_article');
		$this->data['entry_author'] = $this->language->get('entry_author');
		$this->data['entry_email'] = $this->language->get('entry_email');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_comment'] = $this->language->get('entry_comment');
		//$this->data['entry_good'] = $this->language->get('entry_good');
		//$this->data['entry_bad'] = $this->language->get('entry_bad');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
 		
		if (isset($this->error['article'])) {
			$this->data['error_article'] = $this->error['article'];
		} else {
			$this->data['error_article'] = '';
		}
		
 		if (isset($this->error['author'])) {
			$this->data['error_author'] = $this->error['author'];
		} else {
			$this->data['error_author'] = '';
		}
		
 		if (isset($this->error['text'])) {
			$this->data['error_text'] = $this->error['text'];
		} else {
			$this->data['error_text'] = '';
		}
		
 		if (isset($this->error['email'])) {
			$this->data['error_email'] = $this->error['email'];
		} else {
			$this->data['error_email'] = '';
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
			'href'      => $this->url->link('module/bossblog', 'token=' . $this->session->data['token'], 'SSL'),
			'text'      => $this->language->get('heading_bossblog'),
			'separator' => ' :: '
		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('bossblog/comment', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
										
		if (!isset($this->request->get['blog_comment_id'])) { 
			$this->data['action'] = $this->url->link('bossblog/comment/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('bossblog/comment/update', 'token=' . $this->session->data['token'] . '&blog_comment_id=' . $this->request->get['blog_comment_id'] . $url, 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('bossblog/comment', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['blog_comment_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$comment_info = $this->model_bossblog_comment->getComment($this->request->get['blog_comment_id']);
		}
		
		$this->data['token'] = $this->session->data['token'];
			
		$this->load->model('bossblog/articles');
		
		if (isset($this->request->post['blog_article_id'])) {
			$this->data['blog_article_id'] = $this->request->post['blog_article_id'];
		} elseif (!empty($comment_info)) {
			$this->data['blog_article_id'] = $comment_info['blog_article_id'];
		} else {
			$this->data['blog_article_id'] = '';
		}

		if (isset($this->request->post['article'])) {
			$this->data['article'] = $this->request->post['article'];
		} elseif (!empty($comment_info)) {
			$this->data['article'] = $comment_info['article'];
		} else {
			$this->data['article'] = '';
		}
				
		if (isset($this->request->post['author'])) {
			$this->data['author'] = $this->request->post['author'];
		} elseif (!empty($comment_info)) {
			$this->data['author'] = $comment_info['author'];
		} else {
			$this->data['author'] = '';
		}

		if (isset($this->request->post['text'])) {
			$this->data['text'] = $this->request->post['text'];
		} elseif (!empty($comment_info)) {
			$this->data['text'] = $comment_info['text'];
		} else {
			$this->data['text'] = '';
		}

		if (isset($this->request->post['email'])) {
			$this->data['email'] = $this->request->post['email'];
		} elseif (!empty($comment_info)) {
			$this->data['email'] = $comment_info['email'];
		} else {
			$this->data['email'] = '';
		}

		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (!empty($comment_info)) {
			$this->data['status'] = $comment_info['status'];
		} else {
			$this->data['status'] = '';
		}

		$this->template = 'bossblog/comment_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'bossblog/comment')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['blog_article_id']) {
			$this->error['article'] = $this->language->get('error_article');
		}
		
		if ((utf8_strlen($this->request->post['author']) < 3) || (utf8_strlen($this->request->post['author']) > 64)) {
			$this->error['author'] = $this->language->get('error_author');
		}

		if (utf8_strlen($this->request->post['text']) < 1) {
			$this->error['text'] = $this->language->get('error_text');
		}
        
		if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
      		$this->error['email'] = $this->language->get('error_email');
    	}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'bossblog/comment')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}	
}
?>