<?php  
class ControllerModuleBossQuickshop extends Controller {
	protected function index($setting) {
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$this->data['base'] = $this->config->get('config_ssl');
		} else {
			$this->data['base'] = $this->config->get('config_url');
		}
		
		$this->document->addScript('catalog/view/javascript/bossthemes/fancybox/jquery.fancybox.js');
	
		if (file_exists('catalog/view/javascript/bossthemes/fancybox/jquery.fancybox.css')) {
			$this->document->addStyle('catalog/view/javascript/bossthemes/fancybox/jquery.fancybox.css');
		}  
	
		$this->data['config'] = $this->config->get('config_template');
		
		$this->data['selecters'] = array();
		
		$this->data['selecters'] = explode(",", html_entity_decode($setting['array_class_selected'], ENT_QUOTES, 'UTF-8'));
		
		$this->load->model('tool/image'); 
				
		if ($setting['text'][$this->config->get('config_language_id')]) {
			$this->data['text'] = $setting['text'][$this->config->get('config_language_id')];
		} else {
			$this->data['text'] = '';
		}		
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/boss_quickshop.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/boss_quickshop.tpl';
		} else {
			$this->template = 'default/template/module/boss_quickshop.tpl';
		}

		$this->render(); 
	}
	public function getProductId_bySeokeyword(){
	
		$json = array();
		
		if (isset($this->request->post['keyword'])) {
			$keyword = $this->request->post['keyword'];
		} else {
			$keyword = '';
		}
		if ($keyword) {	
			$querys = $this->db->query("SELECT `query`  FROM `" . DB_PREFIX . "url_alias` WHERE `keyword` = '" . $this->db->escape($keyword) . "'");
			foreach ($querys->rows as $query) {
				if(preg_match("/product_id/i", $query['query'])){
					$json['success'] = $query['query'];
					break;
				}
			}
		}
		
		$this->response->setOutput(json_encode($json));		
	}	
}
?>