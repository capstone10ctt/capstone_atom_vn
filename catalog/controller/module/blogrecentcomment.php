<?php
class ControllerModuleBlogRecentComment extends Controller {
	protected function index($setting) {
		$this->load->model('bossblog/article');
        
        if (file_exists('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/bossblog.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/bossblog.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/bossblog.css');
		}
		
		$results = array();
		$results_data = $this->model_bossblog_article->getRecentCommentArticles($setting['limit']);
		$this->data['heading_title'] = $setting['title'][$this->config->get('config_language_id')];
		$this->data['articles'] = array();
		foreach ($results_data as $data) {
			$author = $data['author'];
			$comment = mb_substr(strip_tags(html_entity_decode($data['text'], ENT_QUOTES, 'UTF-8')), 0, 50) . '...';
            $date_added = $data['date_added'];
			$result = $this->model_bossblog_article->getArticle($data['blog_article_id']);	
			$this->data['articles'][] = array(
				'blog_article_id' => $result['blog_article_id'],
				'name'    	 => $result['name'],
                'author'     => $author,
                'comment'    => $comment,
                'date_added' => $date_added,
				'href'    	 => $this->url->link('bossblog/article', 'blog_article_id=' . $result['blog_article_id']),
			);
		}

		$this->data['template'] = $this->config->get('config_template');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/blogrecentcomment.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/blogrecentcomment.tpl';
		} else {
			$this->template = 'default/template/module/blogrecentcomment.tpl';
		}

		$this->render();
	}
}
?>