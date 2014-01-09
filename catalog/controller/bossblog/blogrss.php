<?php  
class ControllerBossblogBlogrss extends Controller {
	public function index() {
		$this->language->load('bossblog/blogrss');
		
    	$this->data['heading_title'] = $this->language->get('heading_title');
        
        if (file_exists('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/bossblog.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/bossblog.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/bossblog.css');
		}
		
		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}
		
		if (isset($parts[0])) {
			$this->data['blog_category_id'] = $parts[0];
		} else {
			$this->data['blog_category_id'] = 0;
		}
		
		if (isset($parts[1])) {
			$this->data['child_id'] = $parts[1];
		} else {
			$this->data['child_id'] = 0;
		}
							
		$this->load->model('bossblog/blogcategory');

		$this->load->model('bossblog/article');

		$this->data['categories'] = array();

		$categories = $this->model_bossblog_blogcategory->getBlogCategories(0);

		foreach ($categories as $category) {
			$total = $this->model_bossblog_article->getTotalArticles(array('filter_category_id'  => $category['blog_category_id']));

			$children_data = array();

			$children = $this->model_bossblog_blogcategory->getBlogCategories($category['blog_category_id']);

			foreach ($children as $child) {
				$data = array(
					'filter_category_id'  => $child['blog_category_id'],
					'filter_sub_category' => true
				);

				$children_data[] = array(
					'blog_category_id' => $child['blog_category_id'],
					'name'        => $child['name'],
					'href'        => $this->url->link('bossblog/blogcategory&rss=blogcategory', 'path=' . $category['blog_category_id'] . '_' . $child['blog_category_id'])	
				);		
			}

			$this->data['categories'][] = array(
				'blog_category_id' => $category['blog_category_id'],
				'name'        => $category['name'],
				'children'    => $children_data,
				'href'        => $this->url->link('bossblog/blogcategory&rss=blogcategory', 'path=' . $category['blog_category_id'])
			);	
		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/bossblog/blogrss.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/bossblog/blogrss.tpl';
		} else {
			$this->template = 'default/template/bossblog/blogrss.tpl';
		}
        
        $this->children = array(
				'common/column_left',
				'common/column_right',
				'common/footer',
				'common/header'
			);
		
		$this->response->setOutput($this->render());
  	}

}
?>