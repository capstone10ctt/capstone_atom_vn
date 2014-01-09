<?php 
class ControllerBossblogBossblog extends Controller {  
	private $error = array();
    
	public function index() { 
	   
       $this->language->load('bossblog/bossblog');
       
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
        	    	
		$this->document->setTitle($this->language->get('heading_title'));
	
		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),			
			'separator' => false
		);
        
        $this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('bossblog/bossblog'),			
			'separator' => $this->language->get('text_separator')
		);
               
        $this->data['heading_title'] = $this->language->get('heading_title');
        
        $this->data['text_empty'] = $this->language->get('text_empty');
        $this->data['text_sort'] = $this->language->get('text_sort');
		$this->data['text_limit'] = $this->language->get('text_limit');
        $this->data['text_display'] = $this->language->get('text_display');
		$this->data['text_list'] = $this->language->get('text_list');
		$this->data['text_grid'] = $this->language->get('text_grid');
        
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
            'sort'               => $sort,
            'order'              => $order,
			'start' => ($page - 1) * $limit,
			'limit' => $limit
		);
        
        $article_total = $this->model_bossblog_article->getTotalBossblogArticles($data);
        
        $results = $this->model_bossblog_article->getArticles($data);
        
        $this->load->model('bossblog/comment');
        foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_blog_image_article_width'), $this->config->get('config_blog_image_article_height'));
			} else {
				$image = false;
			}			
			$this->data['articles'][] = array(
				'blog_article_id'  => $result['blog_article_id'],
				'thumb'       => $image,
				'name'        => $result['name'],
                'comment'     => $this->model_bossblog_comment->getTotalCommentsByArticleId($result['blog_article_id']),
                'date_modified'        => $result['date_modified'],
				'title' => html_entity_decode($result['title'], ENT_QUOTES, 'UTF-8'),
				'author'      => $result['author'],
				'href'        => $this->url->link('bossblog/article', $url . '&blog_article_id=' . $result['blog_article_id'])
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
				'href'  => $this->url->link('bossblog/bossblog', '&sort=ba.sort_order&order=ASC' . $url)
			);
			
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'bad.name-ASC',
				'href'  => $this->url->link('bossblog/bossblog', '&sort=bad.name&order=ASC' . $url)
			);

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'bad.name-DESC',
				'href'  => $this->url->link('bossblog/bossblog','&sort=bad.name&order=DESC' . $url)
			);

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_date_asc'),
				'value' => 'ba.date_added-ASC',
				'href'  => $this->url->link('bossblog/bossblog','&sort=ba.date_added&order=ASC' . $url)
			); 

			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_date_desc'),
				'value' => 'ba.date_added-DESC',
				'href'  => $this->url->link('bossblog/bossblog', '&sort=ba.date_added&order=DESC' . $url)
			); 
			
				$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_comment_desc'),
					'value' => 'comment-DESC',
					'href'  => $this->url->link('bossblog/bossblog', '&sort=comment&order=DESC' . $url)
				); 
				
				$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_comment_asc'),
					'value' => 'comment-ASC',
					'href'  => $this->url->link('bossblog/bossblog', '&sort=comment&order=ASC' . $url)
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
				'href'  => $this->url->link('bossblog/bossblog',$url . '&limit=' .$this->config->get('config_bossblog_limit'))
			);
						
			$this->data['limits'][] = array(
				'text'  => 10,
				'value' => 10,
				'href'  => $this->url->link('bossblog/bossblog',$url . '&limit=10')
			);
			
			$this->data['limits'][] = array(
				'text'  => 15,
				'value' => 15,
				'href'  => $this->url->link('bossblog/bossblog',$url . '&limit=15')
			);

			$this->data['limits'][] = array(
				'text'  => 20,
				'value' => 20,
				'href'  => $this->url->link('bossblog/bossblog',$url . '&limit=20')
			);
			
			$this->data['limits'][] = array(
				'text'  => 30,
				'value' => 30,
				'href'  => $this->url->link('bossblog/bossblog',$url . '&limit=30')
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
        
        $pagination = new Pagination();
		$pagination->total = $article_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('bossblog/bossblog', $url . '&page={page}');
         
			
		$this->data['pagination'] = $pagination->render();
        
        $this->data['sort'] = $sort;
		$this->data['order'] = $order;
		$this->data['limit'] = $limit;         
            
        /*************RSS FEED***************/ 
        $link_rss = $this->url->link('bossblog/blogrss');
        $this->data['link_rss'] = $link_rss;
        $data = array(
            'sort'  => $sort,
            'order' => $order,
			'start' => ($page - 1) * 100,
			'limit' => 100
        );
        $results = $this->model_bossblog_article->getArticles($data);
        $rss = isset($this->request->get["rss"]) ? $this->request->get["rss"] : "";
        if ($rss=="bossblog") {    
            $output = "<?xml version='1.0' encoding='UTF-8' ?>";
            $output .= "<rss version='2.0'>";
            $output .= "<channel>";
            $output .= '<title>' .'Boss Blog'. '</title>';
            $output .= '<description>' . 'Blog is a good instrument for everybody to get closer to each other, and so does your business. It keeps you acknowledge of what clients are thinking about your products, and service. Moreover, your sales program, such as promotion, store news, upcoming products and other news come much easier and friendlier. This extension also brings you a win-win situation. Customers have better products and services as your responses, and you gain more and more potential clients through word of mouth' . '</description>';
            $output .= '<link>' . HTTP_SERVER . '</link>';
            foreach ($results as $result) {
                $title = $result["name"];
                $link = HTTP_SERVER . "?route=bossblog/bossblog";
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
              echo "$output";die();
              
        }
                           
        /************* END RSS FEED***************/       
	   
       	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/bossblog/bossblog.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/bossblog/bossblog.tpl';
			} else {
				$this->template = 'default/template/bossblog/bossblog.tpl';
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
?>