<?php
class ControllerToolImport extends Controller {
	private $error = array();

	
 
	public function index() {

		$this->language->load('tool/import');


		
		$this->load->model('sale/customer_group');
		

		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_filedata'] = $this->language->get('text_filedata');
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_upload'] = $this->language->get('text_upload');
		
		$this->data['entry_studentid'] = $this->language->get('entry_studentid');
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_faculty'] = $this->language->get('entry_faculty');
		$this->data['entry_birthday'] = $this->language->get('entry_birthday');
		$this->data['entry_room'] = $this->language->get('entry_room');
		$this->data['entry_bed'] = $this->language->get('entry_bed');
		$this->data['entry_ethnic'] = $this->language->get('entry_ethnic');
		$this->data['entry_address'] = $this->language->get('entry_address');
		$this->data['entry_comment'] = $this->language->get('entry_comment');
		$this->data['entry_estart'] = $this->language->get('entry_estart');
		$this->data['entry_eend'] = $this->language->get('entry_eend');
		$this->data['entry_wstart'] = $this->language->get('entry_wstart');
		$this->data['entry_wend'] = $this->language->get('entry_wend');
		$this->data['entry_dateadded'] = $this->language->get('entry_dateadded');
		$this->data['entry_uploaddata'] = $this->language->get('entry_uploaddata');

		$this->data['button_upload'] = $this->language->get('button_upload');
		$this->data['button_import'] = $this->language->get('button_import');

		$this->data['error_namenotvalid'] = $this->language->get('error_namenotvalid');
		$this->data['error_facultynotvalid'] = $this->language->get('error_facultynotvalid');
		$this->data['error_locationnotvalid'] = $this->language->get('error_locationnotvalid');
		$this->data['error_roomnotfound'] = $this->language->get('error_roomnotfound');
		$this->data['error_upload'] = $this->language->get('error_upload');

		$this->data['error'] = "";
   		$this->session->data['col_id']="";
		$this->session->data['col_name']="";
		$this->session->data['col_birthday']="";
		$this->session->data['col_faculty']="";
		$this->session->data['col_room']="";
		$this->session->data['col_bed']="";
		$this->session->data['col_ethnic']="";
		$this->session->data['col_address']="";
		$this->session->data['col_estart']="";
		$this->session->data['col_esend']="";
		$this->session->data['col_wstart']="";
		$this->session->data['col_wend']="";
		$this->session->data['col_addeddate']="";
		$this->session->data['file_type']="";
		$this->session->data['sheetData']="";
		$this->data['uploaded']="";

		if (isset($this->request->post['upload']))
		{
	   		if (!empty($_FILES['file']['name']))
			{
				if($_FILES["file"]["error"] > 0)
				{
				   $error= $_FILES["file"]["error"] . "<br>";
				}
			  	else{
			  		$this->data['roomList'] =  $this->model_sale_customer_group->getRoomList();

					include 'PHPExcel/IOFactory.php';
					if (isset($_FILES["file"]["tmp_name"]) && (($_FILES["file"]["type"]=="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") || ($_FILES["file"]["type"]=="application/vnd.ms-excel")))
					{
						$inputFileName = $_FILES["file"]["tmp_name"];  // File to read
						//echo 'Loading file ',pathinfo($inputFileName,PATHINFO_BASENAME),' using IOFactory to identify the format<br />';
						try {
							$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
							$this->session->data['sheetData'] = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

				
							foreach($this->session->data['sheetData'][1] as $key => $value)
							{	
								switch($this->cleanString($this->session->data['sheetData'][1][$key])){
									case "mssv": 
										$this->session->data['col_id'] = $key;
										break;
									case "ho va ten": 
										$this->session->data['col_name'] = $key;
										break;
									case "ngay sinh": 
										$this->session->data['col_birthday'] = $key;
										break;
									case "nganh": 
										$this->session->data['col_faculty'] = $key;
										break;
									case "phong": 
										$this->session->data['col_room'] = $key;
										break;
									case "so giuong": 
										$this->session->data['col_bed'] = $key;
										break;
									case "dan toc": 
										$this->session->data['col_ethnic'] = $key;
										break;
									case "dia chi": 
										$this->session->data['col_address'] = $key;
										break;
									case "dien cu":
										$this->session->data['col_estart'] = $key;
										break;
									case "dien moi":
										$this->session->data['col_eend'] = $key;
										break;
									case "nuoc cu":
										$this->session->data['col_wstart'] = $key;
										break;
									case "nuoc moi":
										$this->session->data['col_wend'] = $key;
										break;
									case "ngay nhap":
										$this->session->data['col_addeddate'] = $key;
										break;
								}
							}
							$this->data['uploaded'] = "yes";
							if($this->session->data['col_id']!='' && $this->session->data['col_name']!='' && $this->session->data['col_room']!='0')
							{
								$this->session->data['file_type']="student";

							} else if($this->session->data['col_room']!='' && ($this->session->data['col_estart']!='' || $this->session->data['col_eend']!='' || $this->session->data['col_wstart']!='' || $this->session->data['col_wend']!=''))
							{
								$this->session->data['file_type']="watere";
							}
							else
								$this->session->data['uploaded']="";


						} catch(Exception $e) {
							die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
						}
					}
				}
			}
			else {
				$this->data['error'] = $this->data['error_upload'];
			}
		}
		
		if($this->data['uploaded']=="")
		{
			$this->session->data['col_id']="";
			$this->session->data['col_name']="";
			$this->session->data['col_birthday']="";
			$this->session->data['col_faculty']="";
			$this->session->data['col_room']="";
			$this->session->data['col_bed']="";
			$this->session->data['col_ethnic']="";
			$this->session->data['col_address']="";
			$this->session->data['col_estart']="";
			$this->session->data['col_esend']="";
			$this->session->data['col_wstart']="";
			$this->session->data['col_wend']="";
			$this->session->data['col_addeddate']="";
			$this->session->data['file_type']="";
			$this->session->data['sheetData']="";
		}

		if (isset($this->session->data['error'])) {
			$this->data['error'] = $this->session->data['error'];
		
			unset($this->session->data['error']);
		} 
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
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
		
		$this->load->model('sale/customer');
		$this->data['facultyList'] = $this->model_sale_customer->getFacultyList();
		$this->data['locationList'] = $this->model_sale_customer->getLocationList();
		//$this->data['restore'] = $this->url->link('tool/import', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['upload'] = $this->url->link('tool/import', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['import'] = $this->url->link('tool/import/import', 'token=' . $this->session->data['token'], 'SSL');
		//$this->data['tables'] = $this->model_tool_import->getTables();

		$this->template = 'tool/import.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}

	public function cleanString($str){
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
		return trim(strtolower($str));
	}
	
	public function import() {
		$this->language->load('tool/import');


		if (!isset($this->request->post['import'])) {
			$this->session->data['error'] = $this->language->get('error_upload');
			
			$this->redirect($this->url->link('tool/import', 'token=' . $this->session->data['token'], 'SSL'));
		} elseif ($this->user->hasPermission('modify', 'tool/import')) {
			
			$this->load->model('sale/customer_group');
			$this->load->model('sale/customer');
			$facultyList = $this->model_sale_customer->getFacultyList();
			$locationList = $this->model_sale_customer->getLocationList();


			$roomList =  $this->model_sale_customer_group->getRoomList();
			$count = 0;
			if($this->session->data['file_type'] == 'student')
			{
				$this->load->model('sale/customer');
				for ($i = 2; $i <= count($this->session->data['sheetData']); $i++)
			    {
			      //check condition
			    	$id_location=-1;
			    	$id_faculty=-1;
			    	if($this->session->data['col_address']!='')
			    	{
				    	foreach($locationList as $location){
						  if($this->cleanString($location['name'])==$this->cleanString($this->session->data['sheetData'][$i][$this->session->data['col_address']])){
						   $id_location=$location['zone_id'];
						   break;
						  }
						}
					}

					if($this->session->data['col_faculty']!='')
					{
						foreach($facultyList as $faculty){
						  if($this->cleanString($faculty['name'])==$this->cleanString($this->session->data['sheetData'][$i][$this->session->data['col_faculty']])){
						   $id_faculty=$faculty['category_id'];
						   echo $id_faculty;
						   break;
						  }
						}
					}

			      if (in_array($this->session->data['sheetData'][$i][$this->session->data['col_room']], $roomList) && ($id_location!=-1) && ($id_faculty!=-1))
			      {
			      	$student = array(
			      		'firstname' 	=> '',
			      		'approved'     => '1',
			      		'lastname' 	=> '',
			      		'address' 	=> array(),
			      		'id_location' 	=> $id_location,
			      		'email' 	=> '',
			      		'gender_id' 	=> '0',
			      		'id_num' 	=> '',
			      		'university_id' 	=> '33',
			      		'faculty_id' 	=> $id_faculty,
			      		'idnum' 	=> '',
			      		'student_id' 	=> '',
			      		'telephone' 	=> '',
			      		'newsletter' 	=> '',
			      		'customer_group_id' 	=> '',
			      		'bed_id' 	=> '',
			      		'password' 	=> '',
			      		'status' 	=> '',
			      		'iddate' 	=> '',
			      		'date_of_birth' 	=> '',
			      		'customer_group_id' 	=> ''
			      	);
			      	
			      	if($this->session->data['col_name']!='')
			      	{
			      		
			      		$name = trim($this->session->data['sheetData'][$i][$this->session->data['col_name']]);
			      		$student['lastname'] = substr($name, 0, strpos($name, " "));  
			      		$student['firstname'] = substr($name, strpos($name, " ")+1); 
			      	}

			      	if($this->session->data['col_id']!='')
			        	$student['student_id'] = $this->session->data['sheetData'][$i][$this->session->data['col_id']];
			      
			      	if($this->session->data['col_birthday']!='')
			      	{
			      		$input = $this->session->data['sheetData'][$i][$this->session->data['col_birthday']];
				        if(strpos($input, '/'))
				          $a = explode('/',$input);
				        else if(strpos($input, '-'))
				          $a = explode('-',$input);
				        else if(strpos($input, '.'))
				          $a = explode('.',$input);
				        if(isset($a[2]))
				          $result = $a[1].'/'.$a[0].'/'.$a[2];
				        else if(isset($a[1]))
				            $result = $a[0].'/1/'.$a[1].'/'.$a[2];
				        else if(isset($a[0]))
				          $result = '1/1/'.$a[0];
				        else
				          $result='';
			        	$student['date_of_birth'] = $result;
			      	}
			      
			      	//if($this->session->data['col_faculty']!='')
			        //	$student['faculty_id'] = $this->session->data['sheetData'][$i][$this->session->data['col_faculty']];
			      
			      	if($this->session->data['col_room']!='')
			      	{
			        	$student['customer_group_id'] = $this->model_sale_customer_group->getRoomId($this->session->data['sheetData'][$i][$this->session->data['col_room']]);
			      	}
			      
			      	if($this->session->data['col_bed']!='')
			      	{
			      		$bed = $this->session->data['sheetData'][$i][$this->session->data['col_bed']];
				        if(strpos($bed, '.'))
				          $bed = substr($bed, strrpos($bed, ".")+1);  

			        	$student['bed_id'] = $bed;;
			      	}
			      
			      	if($this->session->data['col_ethnic']!='')
			        	$student['ethnic'] = $this->session->data['sheetData'][$i][$this->session->data['col_ethnic']];
			      
			      	//if($this->session->data['col_address']!='')
			        //	$student['address'] = $this->session->data['sheetData'][$i][$this->session->data['col_address']];
			        $this->model_sale_customer->addCustomer($student);
			      	$count++;
			      }
			    } 
			} else if($this->session->data['file_type'] == 'watere')
			{
				$this->load->model('sale/manage_wie');
				$data['electric_usage'] = array();
				$data['water_usage'] = array();
				
				$data['year'] = date('Y');
				$data['month'] = date('m');
		
				for ($i = 2; $i <= count($this->session->data['sheetData']); $i++)
			    {
			      
			      if (in_array($this->session->data['sheetData'][$i][$this->session->data['col_room']], $roomList))
			      {
					$temp_elec = array();
					$temp_water = array();
					
					$temp_elec['input'] = 0;
					
					$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_group WHERE name = '" . $this->session->data['sheetData'][$i][$this->session->data['col_room']] . "'");
					
			      	if($this->session->data['col_room']!='')
			        	$temp_elec['room_id'] = $query->row['customer_group_id'];
						$temp_water['room_id'] = $query->row['customer_group_id'];
			      
			      	if($this->session->data['col_estart']!='')
			        	$temp_elec['Start'] = $this->session->data['sheetData'][$i][$this->session->data['col_estart']];
			      
			      	if($this->session->data['col_eend']!='')
			        	$temp_elec['usage'] = $this->session->data['sheetData'][$i][$this->session->data['col_eend']];
				  	
					$temp_water['input'] = 0;
					
			      	if($this->session->data['col_wstart']!='')
			      	{
			        	$temp_water['Start'] = $this->session->data['sheetData'][$i][$this->session->data['col_wstart']];
			      	}
			      
			      	if($this->session->data['col_wend']!='')
			        	$temp_water['usage'] = $this->session->data['sheetData'][$i][$this->session->data['col_wend']];
						
					
					$data['electric_usage'][] = $temp_elec;
					$data['water_usage'][] = $temp_water;
				
			        
			      	$count++;
			      }
			    } 
				
				$this->model_sale_manage_wie->inputUsage($data);
			}


			$this->session->data['success'] = $count." " . $this->session->data['file_type'] . " has been imported!";
			$this->redirect($this->url->link('tool/import', 'token=' . $this->session->data['token'], 'SSL'));
			//$this->response->setOutput($this->model_tool_import->import($this->request->post['import']));
		} else {
			$this->session->data['error'] = $this->language->get('error_permission');
			
			$this->redirect($this->url->link('tool/import', 'token=' . $this->session->data['token'], 'SSL'));			
		}
	}
	
}
?>