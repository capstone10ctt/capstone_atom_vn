<?php
class ControllerModuleBlogRecentPost extends Controller {
	protected function index($setting) {
				
		$this->load->model('bossblog/article');
		
        $this->data['heading_title'] = $setting['title'][$this->config->get('config_language_id')];
        
        if (file_exists('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/bossblog.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/bossblog.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/bossblog.css');
		}
        
		$this->data['articles'] = array();
		
		$data = array(
			'sort'  => 'p.date_added',
			'order' => 'DESC',
			'start' => 0,
			'limit' => $setting['limit']
		);

		$results = $this->model_bossblog_article->getArticles($data);

		foreach ($results as $result) {					

			$this->data['articles'][] = array(
				'blog_article_id' => $result['blog_article_id'],
				'name'    	 => $result['name'],
                'title' => utf8_substr(strip_tags(html_entity_decode($result['title'], ENT_QUOTES, 'UTF-8')), 0, 50) . '...',
                'date_added' => $result['date_added'],
                'author'     => $result['author'],
				'href'    	 => $this->url->link('bossblog/article', 'blog_article_id=' . $result['blog_article_id']),
			);
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/blogrecentpost.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/blogrecentpost.tpl';
		} else {
			$this->template = 'default/template/module/blogrecentpost.tpl';
		}

		$this->render();
	}
}
?>