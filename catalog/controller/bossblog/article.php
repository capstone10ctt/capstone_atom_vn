<?php  
class ControllerBossblogArticle extends Controller {
	private $error = array(); 
	
	public function index() { 
	   
       	if (!$this->customer->isLogged()) {
	  		$this->data['login'] = 0;
    	} else{
    	   $this->data['login'] = 1;
            $this->data['email']=$this->customer->getEmail();
            $this->data['username']=$this->customer->getFirstName().' '.$this->customer->getLastName();
    	}
       
       $this->language->load('bossblog/article');
	   
	   if (file_exists('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/bossblog.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/bossblog.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/bossblog.css');
		}
       
   		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),			
			'separator' => false
		);
        
        $this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_bossblog'),
			'href'      => $this->url->link('bossblog/bossblog'),			
			'separator' => $this->language->get('text_separator')
		);
        
        
       $this->load->model('bossblog/blogcategory');
       
       if (isset($this->request->get['path'])) {
			$path = '';
				
			foreach (explode('_', $this->request->get['path']) as $path_id) {
				if (!$path) {
					$path = $path_id;
				} else {
					$path .= '_' . $path_id;
				}
				$category_info = $this->model_bossblog_blogcategory->getBlogCategory($path_id);
				if ($category_info) {
					$this->data['breadcrumbs'][] = array(
						'text'      => $category_info['name'],
						'href'      => $this->url->link('bossblog/blogcategory', 'path=' . $path),
						'separator' => $this->language->get('text_separator')
					);
				}
			}
		}
        
        $comment_status = $this->config->get('config_comment_status');
        
        $approval_status = $this->config->get('config_approval_status');
	
        		
		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_tag'])) {
			$url = '';
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
						
			if (isset($this->request->get['filter_tag'])) {
				$url .= '&filter_tag=' . $this->request->get['filter_tag'];
			}
						
			if (isset($this->request->get['filter_content'])) {
				$url .= '&filter_content=' . $this->request->get['filter_content'];
			}
			
			if (isset($this->request->get['filter_category_id'])) {
				$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
			}	
						
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_search'),
				'href'      => $this->url->link('bossblog/blogsearch', $url),
				'separator' => $this->language->get('text_separator')
			); 	
		}
		
		if (isset($this->request->get['blog_article_id'])) {
			$blog_article_id = (int)$this->request->get['blog_article_id'];
		} else {
			$blog_article_id = 0;
		}
		
        $this->data['capcha']=1;
        
        
		$this->load->model('bossblog/article');
		
		$article_info = $this->model_bossblog_article->getArticle($blog_article_id);
		
		if ($article_info) {
			$url = '';
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
						
			if (isset($this->request->get['filter_tag'])) {
				$url .= '&filter_tag=' . $this->request->get['filter_tag'];
			}
			
			if (isset($this->request->get['filter_content'])) {
				$url .= '&filter_content=' . $this->request->get['filter_content'];
			}	
						
			if (isset($this->request->get['filter_category_id'])) {
				$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
			}
												
			$this->data['breadcrumbs'][] = array(
				'text'      => $article_info['name'],
				'href'      => $this->url->link('bossblog/article', $url . '&blog_article_id=' . $this->request->get['blog_article_id']),
				'separator' => $this->language->get('text_separator')
			);			
			
			$this->document->setTitle($article_info['name']);
			$this->document->setDescription($article_info['meta_description']);
			$this->document->setKeywords($article_info['meta_keyword']);
			$this->document->addLink($this->url->link('bossblog/article', 'blog_article_id=' . $this->request->get['blog_article_id']), 'canonical');
			
			$this->data['heading_title'] = $article_info['name'];
			
			$this->data['text_select'] = $this->language->get('text_select');
			$this->data['text_username'] = $this->language->get('text_username');	
			$this->data['text_email'] = $this->language->get('text_email');
			$this->data['text_required'] = $this->language->get('text_required');
			$this->data['text_tags'] = $this->language->get('text_tags');
			$this->data['text_write'] = $this->language->get('text_write');
			$this->data['text_note'] = $this->language->get('text_note');
			$this->data['text_wait'] = $this->language->get('text_wait');
			$this->data['text_comment'] = $this->language->get('text_comment');
			$this->data['text_tags'] = $this->language->get('text_tags');
            $this->data['text_product_related'] = $this->language->get('text_product_related');
			
			$this->data['entry_name'] = $this->language->get('entry_name');
			$this->data['entry_comment'] = $this->language->get('entry_comment');
			$this->data['entry_email'] = $this->language->get('entry_email');
	    	$this->data['entry_comment'] = $this->language->get('entry_comment');
			$this->data['entry_captcha'] = $this->language->get('entry_captcha');
            $this->data['view_comment'] = $this->language->get('view_comment');

			$this->data['button_submit'] = $this->language->get('button_submit');
            $this->data['button_cart'] = $this->language->get('button_cart');			
			$this->data['button_upload'] = $this->language->get('button_upload');
			$this->data['button_continue'] = $this->language->get('button_continue');
            $this->data['public_key'] = $this->language->get('public_key');
            $this->data['article_related'] = $this->language->get('article_related');
            
			
			$this->load->model('bossblog/comment');

			
			$this->data['blog_article_id'] = $this->request->get['blog_article_id'];
			$this->data['date_modified'] = $article_info['date_modified'];
            $this->data['comment_status'] = $comment_status;
            $this->data['approval_status'] = $approval_status;
			$this->data['comments'] = (int)$article_info['comments'];
            $this->data['allow_comment'] = (int)$article_info['allow_comment'];
            $this->data['need_approval'] = (int)$article_info['need_approval'];
			$this->data['content'] = html_entity_decode($article_info['content'], ENT_QUOTES, 'UTF-8');
            $this->data['title'] = html_entity_decode($article_info['title'], ENT_QUOTES, 'UTF-8');
            $this->data['name'] = html_entity_decode($article_info['name'], ENT_QUOTES, 'UTF-8');
            $this->data['author'] = html_entity_decode($article_info['author'], ENT_QUOTES, 'UTF-8');
            $this->data['href']  = $this->url->link('bossblog/article', 'blog_article_id=' . $article_info['blog_article_id']);
			
			$this->data['articles'] = array();
			
			$results = $this->model_bossblog_article->getArticleRelated($this->request->get['blog_article_id']);
            
            $this->load->model('tool/image');
			
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_related_width'), $this->config->get('config_image_related_height'));
				} else {
					$image = false;
				}
							
				$this->data['articles'][] = array(
					'blog_article_id' => $result['blog_article_id'],
					'thumb'   	 => $image,
					'name'    	 => $result['name'],
                    'content'    	 => $result['content'],
                    'date_modified'    	 => $result['date_modified'],
                    'title'    	 => $result['title'],
					'href'    	 => $this->url->link('bossblog/article', 'blog_article_id=' . $result['blog_article_id']),
				);
			}
            
            $this->load->model('catalog/product');
            
            $this->data['products'] = array();
			
			$results = $this->model_bossblog_article->getBlogProductRelated($this->request->get['blog_article_id']);
			
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_blog_image_related_width'), $this->config->get('config_blog_image_related_height'));
				} else {
					$image = false;
				}
				
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}
						
				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$special = false;
				}
				
				if ($this->config->get('config_review_status')) {
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}
							
				$this->data['products'][] = array(
					'product_id' => $result['product_id'],
					'thumb'   	 => $image,
					'name'    	 => $result['name'],
					'price'   	 => $price,
					'special' 	 => $special,
					'rating'     => $rating,
					'reviews'    => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
					'href'    	 => $this->url->link('product/product', 'product_id=' . $result['product_id']),
				);
			}	
			
			$this->data['tags'] = array();
					
			$tags = explode(',', $article_info['tag']);
			
			foreach ($tags as $tag) {
				$this->data['tags'][] = array(
					'tag'  => trim($tag),
					'href' => $this->url->link('bossblog/blogsearch', 'filter_tag=' . trim($tag))
				);
			}
			
			$this->model_bossblog_article->updateViewed($this->request->get['blog_article_id']);
			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/bossblog/article.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/bossblog/article.tpl';
			} else {
				$this->template = 'default/template/bossblog/article.tpl';
			}
			
			$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
			);
						
			$this->response->setOutput($this->render());
		} else {
			$url = '';
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}	
					
			if (isset($this->request->get['filter_tag'])) {
				$url .= '&filter_tag=' . $this->request->get['filter_tag'];
			}
							
			if (isset($this->request->get['filter_content'])) {
				$url .= '&filter_content=' . $this->request->get['filter_content'];
			}
					
			if (isset($this->request->get['filter_category_id'])) {
				$url .= '&filter_category_id=' . $this->request->get['filter_category_id'];
			}
								
      		$this->data['breadcrumbs'][] = array(
        		'text'      => $this->language->get('text_error'),
				'href'      => $this->url->link('bossblog/article', $url . '&blog_article_id=' . $blog_article_id),
        		'separator' => $this->language->get('text_separator')
      		);			
		
      		$this->document->setTitle($this->language->get('text_error'));

      		$this->data['heading_title'] = $this->language->get('text_error');

      		$this->data['text_error'] = $this->language->get('text_error');

      		$this->data['button_continue'] = $this->language->get('button_continue');

      		$this->data['continue'] = $this->url->link('common/home');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
			} else {
				$this->template = 'default/template/error/not_found.tpl';
			}
			
			$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
			);
						
			$this->response->setOutput($this->render());
    	}     
    }
    
    public function comment() {
    	$this->language->load('bossblog/article');
		
		$this->load->model('bossblog/comment');

		$this->data['text_on'] = $this->language->get('text_on');
		$this->data['text_no_comments'] = $this->language->get('text_no_comments');
        $this->data['view_comment'] = $this->language->get('view_comment');
        $this->data['text_comment_by'] = $this->language->get('text_comment_by');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}  
		
		$this->data['comments'] = array();
		
		$comment_total = $this->model_bossblog_comment->getTotalCommentsByArticleId($this->request->get['blog_article_id']);
			
		$results = $this->model_bossblog_comment->getCommentsByArticleId($this->request->get['blog_article_id'], ($page - 1) * 5, 5);
      		
		foreach ($results as $result) {
        	$this->data['comments'][] = array(
        		'author'     => $result['author'],
				'text'       => $result['text'],
				'email'      => $result['email'],
        		'date_added' => $result['date_added']
        	);
      	}			
			
		$pagination = new Pagination();
		$pagination->total = $comment_total;
		$pagination->page = $page;
		$pagination->limit = 5; 
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('bossblog/article/comment', 'blog_article_id=' . $this->request->get['blog_article_id'] . '&page={page}');
			
		$this->data['pagination'] = $pagination->render();
        
		$this->data['comment_total'] =$comment_total;
		
    	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/bossblog/comment.tpl')) {
    			$this->template = $this->config->get('config_template') . '/template/bossblog/comment.tpl';
    		} else {
    			$this->template = 'default/template/bossblog/comment.tpl';
    		}
    		
   		$this->response->setOutput($this->render());
	}
    
    public function write() {
		$this->language->load('bossblog/article');
		
		$this->load->model('bossblog/comment');
        
        $approval_status =  $this->request->get['approval_status'];
        $need_approval =  $this->request->get['need_approval'];
            if($need_approval!=0){
                if($approval_status==1||$need_approval==1){
                    $status = 0;
                } else {
                    $status = 1;
                }
            } else {
                $status = 1;
            }
        
		$json = array();                 
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            
			if ((utf8_strlen($this->request->post['username']) < 3) || (utf8_strlen($this->request->post['username']) > 25)) {
				$json['error'] = $this->language->get('error_name');
			}
			
			if ((utf8_strlen($this->request->post['comment_content']) < 25) || (utf8_strlen($this->request->post['comment_content']) > 1000)) {
				$json['error'] = $this->language->get('error_text');
			}
            
            if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
      		    $json['error'] = $this->language->get('error_email');
	        }
            
            if (empty($this->session->data['captcha']) || ($this->session->data['captcha'] != $this->request->post['captcha'])) {
				$json['error'] = $this->language->get('error_captcha');
			}
	
			if (!isset($json['error'])) {
				$this->model_bossblog_comment->addComment($this->request->get['blog_article_id'],$status, $this->request->post);
				if($status==1){
				$json['success'] = $this->language->get('text_success');
                } else {
                    $json['success'] = $this->language->get('text_approval');
                }
			}
		}
		
		$this->response->setOutput(json_encode($json));
	}
    
   	public function captcha() {
        $this->load->library('captcha');
		
		$captcha = new Captcha();
		
		$this->session->data['captcha'] = $captcha->getCode();
		
		$captcha->showImage();
	}
 }
 ?>