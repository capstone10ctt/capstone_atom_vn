<?php
class ControllerToolImport extends Controller {
	private $error = array();

	
 
	public function index() {

		$this->language->load('tool/import');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('tool/import');
		

		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_filedata'] = $this->language->get('text_filedata');
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_upload'] = $this->language->get('text_upload');
		
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),     		
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('tool/import', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->data['error'] = "";
   		$this->data['error'] = "";
   		$this->data['col_id']="";
		$this->data['col_name']="";
		$this->data['col_birthday']="";
		$this->data['col_faculty']="";
		$this->data['col_room']="";
		$this->data['col_bed']="";
		$this->data['col_race']="";
		$this->data['col_address']="";
		$this->data['col_estart']="";
		$this->data['col_esend']="";
		$this->data['col_wstart']="";
		$this->data['col_wend']="";
		$this->data['col_inputdate']="";
		$this->data['file_type']="";
		$this->data['sheetData']="";

   		if (isset($_FILES["file"]))
		{
			if($_FILES["file"]["error"] > 0)
			{
			   $error= $_FILES["file"]["error"] . "<br>";
			}
		  	else{
				include 'PHPExcel/IOFactory.php';
				if (isset($_FILES["file"]["tmp_name"]) && (($_FILES["file"]["type"]=="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") || ($_FILES["file"]["type"]=="application/vnd.ms-excel")))
				{
					$inputFileName = $_FILES["file"]["tmp_name"];  // File to read
					//echo 'Loading file ',pathinfo($inputFileName,PATHINFO_BASENAME),' using IOFactory to identify the format<br />';
					try {
						$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
						$this->data['sheetData'] = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

			
						foreach($this->data['sheetData'][1] as $key => $value)
						{	
							switch(trim(strtolower($this->utf8_to_ascii($this->data['sheetData'][1][$key])))){
								case "mssv": 
									$this->data['col_id'] = $key;
									break;
								case "ho va ten": 
									$this->data['col_name'] = $key;
									break;
								case "ngay sinh": 
									$this->data['col_birthday'] = $key;
									break;
								case "nganh": 
									$this->data['col_$faculty'] = $key;
									break;
								case "phong": 
									$this->data['col_room'] = $key;
									break;
								case "so giuong": 
									$this->data['col_bed'] = $key;
									break;
								case "dan toc": 
									$this->data['col_race'] = $key;
									break;
								case "dia chi": 
									$this->data['col_address'] = $key;
									break;
								case "dien cu":
									$this->data['col_estart'] = $key;
									break;
								case "dien moi":
									$this->data['col_eend'] = $key;
									break;
								case "nuoc cu":
									$this->data['col_wstart'] = $key;
									break;
								case "nuoc moi":
									$this->data['col_wend'] = $key;
									break;
								case "ngay nhap":
									$this->data['col_inputdate'] = $key;
									break;
							}
						}
						if($this->data['col_id']!='' && $this->data['col_name']!='' && $this->data['col_room']!='0')
						{
							$this->data['file_type']="student";
						} else if($this->data['col_room']!='' && ($this->data['col_estart']!='' || $this->data['col_eend']!='' || $this->data['col_wstart']!='' || $this->data['col_wend']!=''))
						{
							$this->data['file_type']="watere";
						}

					} catch(Exception $e) {
						die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
					}
				}
			}
		}


		
		
		//$this->data['restore'] = $this->url->link('tool/import', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['import'] = $this->url->link('tool/import/import', 'token=' . $this->session->data['token'], 'SSL');

		//$this->data['tables'] = $this->model_tool_import->getTables();

		$this->template = 'tool/import.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}

	private function utf8_to_ascii($str){
        if(!$str) return false;
        $unicode = array(
		'a' => 'A|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ|á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
		'b' =>  'B',
		'c' =>  'C',
		'd' => 'D|Đ|đ',
		'e' => 'E|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ|é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
		'f' => 'F',
		'g' => 'G',
		'h' => 'H',
		'i' => 'I|Í|Ì|Ỉ|Ĩ|Ị|í|ì|ỉ|ĩ|ị',
		'j' => 'J',
		'k' => 'K',
		'l' => 'L',
		'm' => 'M',
		'n' => 'N',
		'o' => 'O|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ|ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
		'p' => 'P',
		'q' => 'Q',
		'r' => 'R',
		's' => 'S',
		't' => 'T',
		'u' => 'U|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự|ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
		'v' => 'V',
		'w' => 'W',
		'x' => 'X',
		'y' => 'Y|Ý|Ỳ|Ỷ|Ỹ|Ỵ|ý|ỳ|ỷ|ỹ|ỵ',
		'z' => 'Z'
		        );
		foreach($unicode as $nonUnicode=>$uni) $str = preg_replace("/($uni)/i",$nonUnicode,$str);
		return $str;
	}
	
	public function import() {
		$this->language->load('tool/import');
		
		if (!isset($this->request->post['import'])) {
			$this->session->data['error'] = $this->language->get('error_import');
			
			$this->redirect($this->url->link('tool/import', 'token=' . $this->session->data['token'], 'SSL'));
		} elseif ($this->user->hasPermission('modify', 'tool/import')) {
			$this->response->addheader('Pragma: public');
			$this->response->addheader('Expires: 0');
			$this->response->addheader('Content-Description: File Transfer');
			$this->response->addheader('Content-Type: application/octet-stream');
			$this->response->addheader('Content-Disposition: attachment; filename=' . date('Y-m-d_H-i-s', time()).'_import.sql');
			$this->response->addheader('Content-Transfer-Encoding: binary');
			
			$this->load->model('tool/import');
			
			$this->response->setOutput($this->model_tool_import->import($this->request->post['import']));
		} else {
			$this->session->data['error'] = $this->language->get('error_permission');
			
			$this->redirect($this->url->link('tool/import', 'token=' . $this->session->data['token'], 'SSL'));			
		}
	}
	
}
?>