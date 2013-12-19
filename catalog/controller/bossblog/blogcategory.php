<?php 
class ControllerBossblogBlogcategory extends Controller {  
	public function index() { 
		$this->language->load('bossblog/blogcategory');
		
		$this->load->model('bossblog/blogcategory');
		
		$this->load->model('bossblog/article');
		
		$this->load->model('tool/image'); 
		
		$this->document->addScript('catalog/view/javascript/jquery/jquery.total-storage.min.js');
		
		if (file_exists('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/bossblog.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/bossblog.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/bossblog.css');
		}
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'ba.sort_order';
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
        
        if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = $this->config->get('config_bossblog_limit');
		}
					
		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
       		'separator' => false
   		);
        
        $this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_bossblog'),
			'href'      => $this->url->link('bossblog/bossblog'),
       		'separator' => $this->language->get('text_separator')
   		);	
			
		if (isset($this->request->get['path'])) {
			$path = '';
		
			$parts = explode('_', (string)$this->request->get['path']);
		
			foreach ($parts as $path_id) {
				if (!$path) {
					$path = (int)$path_id;
				} else {
					$path .= '_' . (int)$path_id;
				}
									
				$blogcategory_info = $this->model_bossblog_blogcategory->getBlogCategory($path_id);
				
				if ($blogcategory_info) {
	       			$this->data['breadcrumbs'][] = array(
   	    				'text'      => $blogcategory_info['name'],
						'href'      => $this->url->link('bossblog/blogcategory', 'path=' . $path),
        				'separator' => $this->language->get('text_separator')
        			);
				}
			}		
		
			$blog_category_id = (int)array_pop($parts);
            
		} else {
			$blog_category_id = 0;
		}
                
		$blogcategory_info = $this->model_bossblog_blogcategory->getBlogCategory($blog_category_id);
	
		if ($blogcategory_info) {
	  		$this->document->setTitle($blogcategory_info['name']);
			$this->document->setDescription($blogcategory_info['meta_description']);
			$this->document->setKeywords($blogcategory_info['meta_keyword']);
			
			$this->data['heading_title'] = $blogcategory_info['name'];
			
			$this->data['text_empty'] = $this->language->get('text_empty');
            $this->data['text_sort'] = $this->language->get('text_sort');
            $this->data['text_limit'] = $this->language->get('text_limit');
            $this->data['text_sub_category'] = $this->language->get('text_sub_category');
            $this->data['text_display'] = $this->language->get('text_display');
            $this->data['text_list'] = $this->language->get('text_list');
            $this->data['text_grid'] = $this->language->get('text_grid');
					
			if ($blogcategory_info['image']) {
				$this->data['thumb'] = $this->model_tool_image->resize($blogcategory_info['image'], $this->config->get('config_blog_image_category_width'), $this->config->get('config_blog_image_category_height'));
			} else {
				$this->data['thumb'] = '';
			}
									
			$this->data['description'] = html_entity_decode($blogcategory_info['description'], ENT_QUOTES, 'UTF-8');
            
            $url = '';
								
			$this->data['blogcategories'] = array();
			
			$results = $this->model_bossblog_blogcategory->getBlogCategories($blog_category_id);
			
			foreach ($results as $result) {
				$data = array(
					'filter_category_id'  => $result['blog_category_id'],
					'filter_sub_category' => true
				);
				
				$article_total = $this->model_bossblog_article->getTotalArticles($data);				
				
				$this->data['blogcategories'][] = array(
					'name'  => $result['name'] . ($this->config->get('config_article_count') ? ' (' . $article_total . ')' : ''),
					'href'  => $this->url->link('bossblog/blogcategory', 'path=' . $this->request->get['path'] . '_' . $result['blog_category_id'] . $url)
				);
			}
            
			$url = '';
			
    		if (isset($this->request->get['sort'])) {
    		  $url .= '&sort=' . $this->request->get['sort'];
    		}	
    
            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
    			}	
    			
            if (isset($this->request->get['limit'])) {
    				$url .= '&limit=' . $this->request->get['limit'];
    			}
            
            $this->data['articles'] = array();
            
            $data = array(
                'filter_category_id' => $blog_category_id, 
                'sort'               => $sort,
                'order'              => $order,
    			'start' => ($page - 1) * $limit,
    			'limit' => $limit
    		);
					
			$article_total = $this->model_bossblog_article->getTotalArticles($data); 
			
			$results = $this->model_bossblog_article->getArticles($data);
			
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_blog_image_article_width'), $this->config->get('config_blog_image_article_height'));
				} else {
					$image = false;
				}
                
                $this->load->model('bossblog/comment');
								
				$this->data['articles'][] = array(
					'blog_article_id'  => $result['blog_article_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
                    'date_modified'       => $result['date_modified'],
                    'comment'     => $this->model_bossblog_comment->getTotalCommentsByArticleId($result['blog_article_id']),
                    'author'          => $result['author'],
                    'title' => strip_tags(html_entity_decode($result['title'], ENT_QUOTES, 'UTF-8')) . '..',
					'href'        => $this->url->link('bossblog/article','path=' . $this->request->get['path'] . '&blog_article_id=' . $result['blog_article_id'])
				);
			}
            
           $url = '';
	
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
							
			$this->data['sorts'] = array();
			
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_default'),
				'value' => 'ba.sort_order-ASC',
				'href'  => $this->url->link('bossblog/blogcategory','path=' . $this->request->get['path'] . '&sort=ba.sort_order&order=ASC' . $url)
			);
			
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'bad.name-ASC',
				'href'  => $this->url->link('bossblog/blogcategory','path=' . $this->request->get['path'] . '&sort=bad.name&order=ASC' . $url)
			);

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'bad.name-DESC',
				'href'  => $this->url->link('bossblog/blogcategory','path=' . $this->request->get['path'] . '&sort=bad.name&order=DESC' . $url)
			);

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_date_asc'),
				'value' => 'ba.date_added-ASC',
				'href'  => $this->url->link('bossblog/blogcategory','path=' . $this->request->get['path'] . '&sort=ba.date_added&order=ASC' . $url)
			); 

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_date_desc'),
				'value' => 'ba.date_added-DESC',
				'href'  => $this->url->link('bossblog/blogcategory','path=' . $this->request->get['path'] . '&sort=ba.date_added&order=DESC' . $url)
			); 
			
				$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_comment_desc'),
					'value' => 'comment-DESC',
					'href'  => $this->url->link('bossblog/blogcategory','path=' . $this->request->get['path'] . '&sort=comment&order=DESC' . $url)
				); 
				
				$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_comment_asc'),
					'value' => 'comment-ASC',
					'href'  => $this->url->link('bossblog/blogcategory','path=' . $this->request->get['path'] . '&sort=comment&order=ASC' . $url)
				);
			
			$url = '';
	
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}	

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$this->data['limits'] = array();
			
			$this->data['limits'][] = array(
				'text'  => $this->config->get('config_bossblog_limit'),
				'value' => $this->config->get('config_bossblog_limit'),
				'href'  => $this->url->link('bossblog/blogcategory','path=' . $this->request->get['path'] . $url . '&limit=' .$this->config->get('config_bossblog_limit'))
			);
						
			$this->data['limits'][] = array(
				'text'  => 10,
				'value' => 10,
				'href'  => $this->url->link('bossblog/blogcategory','path=' . $this->request->get['path'] . $url . '&limit=10')
			);
			
			$this->data['limits'][] = array(
				'text'  => 15,
				'value' => 15,
				'href'  => $this->url->link('bossblog/blogcategory','path=' . $this->request->get['path'] . $url . '&limit=15')
			);

			$this->data['limits'][] = array(
				'text'  => 20,
				'value' => 20,
				'href'  => $this->url->link('bossblog/blogcategory','path=' . $this->request->get['path'] . $url . '&limit=20')
			);
			
			$this->data['limits'][] = array(
				'text'  => 30,
				'value' => 30,
				'href'  => $this->url->link('bossblog/blogcategory','path=' . $this->request->get['path'] . $url . '&limit=30')
			);
						
			$url = '';
	
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}	

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
	
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			} 
            
                        
            /*************RSS FEED***************/ 
            
            $link_rss=$this->url->link('bossblog/blogcategory', 'path=' . $this->request->get['path']. '&rss=blogcategory');
            
            $this->data['link_rss'] = $link_rss;
            
            $rss = isset($this->request->get["rss"]) ? $this->request->get["rss"] : "";
            if ($rss=="blogcategory") {    
                $output = "<?xml version='1.0' encoding='UTF-8' ?>";
                $output .= "<rss version='2.0'>";
                $output .= "<channel>";
                $output .= '<title>' . $blogcategory_info['name'] . '</title>';
                $output .= '<description>' . html_entity_decode($blogcategory_info['description'], ENT_QUOTES, 'UTF-8') . '</description>';
                $output .= '<link>' . HTTP_SERVER . '</link>';
                foreach ($results as $result) {
                    $title = $result["name"];
                    $link = HTTP_SERVER . "?route=bossblog/article&blog_article_id=$result[blog_article_id]";
                    $image_url = $image;
                    $description = "";
                      $output .= "<item>";
                      $output .= '<title>' . $result['name'] . '</title>';
                      $output .= '<description>' . $result['title'] . '</description>';
                      $output .= '<link>' . $this->url->link('bossblog/article', 'blog_article_id=' . $result['blog_article_id']) . '</link>';
                      $output .= "<pubDate>" . date("D, d M Y H:i:s O", strtotime($result["date_modified"])) . "</pubDate>";
                      $output .= "</item>";
                  }
                  $output .= "</channel>";
                  $output .= "</rss>";
        
                  header("Content-Type: application/rss+xml");
                  echo "$output"; die();
              
              } 
                       
            /************* END RSS FEED***************/
					
			$pagination = new Pagination();
			$pagination->total = $article_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->url->link('bossblog/blogcategory', 'path=' . $this->request->get['path'] . $url . '&page={page}');
		
			$this->data['pagination'] = $pagination->render();
            
            $this->data['sort'] = $sort;
			$this->data['order'] = $order;
			$this->data['limit'] = $limit;

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/bossblog/blogcategory.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/bossblog/blogcategory.tpl';
			} else {
				$this->template = 'default/template/bossblog/blogcategory.tpl';
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
			
			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}
				
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
						
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_error'),
				'href'      => $this->url->link('bossblog/blogcategory', $url),
				'separator' => $this->language->get('text_separator')
			);
				
			$this->document->setTitle($this->language->get('text_error'));

      		$this->data['heading_title'] = $this->language->get('text_error');

      		$this->data['text_error'] = $this->language->get('text_error');

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
}
?>