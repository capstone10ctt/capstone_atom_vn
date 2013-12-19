<?php
class ControllerModuleBlogTagCloud extends Controller {
	
	protected function index($setting) {
		static $module = 0;
		
		$this->load->language('module/blogtagcloud');

		$this->data['heading_title'] = $setting['title'][$this->config->get('config_language_id')];
		
		$this->data['text_notags'] = $this->language->get('text_notags');

        if (file_exists('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/bossblog.css')) {
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/bossblog.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/bossblog.css');
		}
        		
		$this->load->model('bossblog/blogtagcloud');
		
		$this->data['blogtagcloud'] = $this->model_bossblog_blogtagcloud->getRandomTags(
			$setting['limit'],
			(int)$setting['min_font_size'],
			(int)$setting['max_font_size'],
			$setting['font_weight']
		);
		
		$this->data['module'] = $module++;

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/blogtagcloud.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/module/blogtagcloud.tpl';
			} else {
				$this->template = 'default/template/module/blogtagcloud.tpl';
			}
			
		$this->render();
	}
}
?>
