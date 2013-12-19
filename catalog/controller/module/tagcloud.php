<?php
class ControllerModuleTagCloud extends Controller {

	private $_name = 'tagcloud';
	protected function index($setting) {
		static $module = 0;
		
		$this->load->language('module/tagcloud');

		$this->data['heading_title'] = $setting['title'][$this->config->get('config_language_id')];
		
		$this->data['text_notags'] = $this->language->get('text_notags');
		
		$this->load->model('module/tagcloud');
		
		$this->data['tagcloud'] = $this->model_module_tagcloud->getRandomTags(
			$setting['limit'],
			(int)$setting['min_font_size'],
			(int)$setting['max_font_size'],
			$setting['font_weight']
		);
		
		$this->data['module'] = $module++;

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/tagcloud.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/module/tagcloud.tpl';
			} else {
				$this->template = 'default/template/module/tagcloud.tpl';
			}
			
		$this->render();
	}
}
?>
