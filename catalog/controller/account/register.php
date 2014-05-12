<?php 
// kah2914
//session_start();
// kah2914
class ControllerAccountRegister extends Controller {
	private $error = array();
	public $NKUniversity = 0;
	
  	public function index() {
		if ($this->customer->isLogged()) {
	  		$this->redirect($this->url->link('account/account', '', 'SSL'));
    	}

    	$this->language->load('account/register');
		
		$this->document->setTitle($this->language->get('heading_title'));
		$this->document->addScript('catalog/view/javascript/jquery/colorbox/jquery.colorbox-min.js');
		$this->document->addStyle('catalog/view/javascript/jquery/colorbox/colorbox.css');		
					
		$this->load->model('account/customer');

		//kah2914		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) 
    	{		
    		define ('SITE_ROOT', realpath('./'));
			$imagename = $_FILES['userfile']['name'].'_'.date('Y-m-d-H-i-s').'_'.uniqid().'.jpg';
			$this->request->post['portrait']=$imagename;
			move_uploaded_file($_FILES['userfile']['tmp_name'],SITE_ROOT.'\image\portrait\\'.$imagename);

			$this->model_account_customer->addCustomer($this->request->post);

			$this->customer->login($this->request->post['email'], $this->request->post['password']);
			
			unset($this->session->data['guest']);
							  	  
	  		$this->redirect($this->url->link('account/success'));
    	} 
	    //kah2914
      	$this->data['breadcrumbs'] = array();

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),        	
        	'separator' => false
      	); 

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_account'),
			'href'      => $this->url->link('account/account', '', 'SSL'),      	
        	'separator' => $this->language->get('text_separator')
      	);
		
      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_register'),
			'href'      => $this->url->link('account/register', '', 'SSL'),      	
        	'separator' => $this->language->get('text_separator')
      	);
		
    	$this->data['heading_title'] = $this->language->get('heading_title');

		//kah2914
		$this->data['url']=$this->config->get('config_url');
		//kah2914
		
		$this->data['text_account_already'] = sprintf($this->language->get('text_account_already'), $this->url->link('account/login', '', 'SSL'));
		$this->data['text_your_details'] = $this->language->get('text_your_details');
    	$this->data['text_your_address1'] = $this->language->get('text_your_address1');
    	$this->data['text_your_address2'] = $this->language->get('text_your_address2');
    	$this->data['text_your_studentinfo'] = $this->language->get('text_your_studentinfo');    	
    	$this->data['text_your_password'] = $this->language->get('text_your_password');
    	$this->data['text_your_special'] = $this->language->get('text_your_special');
		$this->data['text_newsletter'] = $this->language->get('text_newsletter');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['text_none'] = $this->language->get('text_none');
		
	/////////////////////// Modification//////////////////////
        //       ID: 1051018	 	 	 	 	
        //       Name: Tran Thanh Toan	 	 	 	 	
        // 	 Class: 10CTT 
        // 	 Date 1/1/2014
        // 	 Description: take data from language 
        // 	 Date modified: 1/1/2014 
        // 	 Last updated: list the change by line number and goal, ex: 
        //	 	 + line 289: optimize the operation
        /////////// Start “you-id” - “your-name” modifications/////////////
		$this->data['entry_university'] = $this->language->get('entry_university');
		$this->data['entry_date_of_birth'] = $this->language->get('entry_date_of_birth');
        $this->data['entry_ethnic'] = $this->language->get('entry_ethnic');
		$this->data['entry_faculty'] = $this->language->get('entry_faculty');
		$this->data['entry_student_id'] = $this->language->get('entry_student_id');
		$this->data['error_university'] = $this->language->get('error_university');
		$this->data['error_faculty'] = $this->language->get('error_faculty');
		$this->data['error_student_id'] = $this->language->get('error_student_id');
		$this->data['error_portrait'] = $this->language->get('error_portrait');	
		
		$this->data['entry_portrait'] = $this->language->get('entry_portrait');
		$this->data['entry_idnum'] = $this->language->get('entry_idnum');
		$this->data['entry_iddate'] = $this->language->get('entry_iddate');
		$this->data['entry_idlocation'] = $this->language->get('entry_idlocation');
		$this->data['text_id'] = $this->language->get('text_id');
		$this->data['entry_gender'] = $this->language->get('entry_gender');
		
		$this->load->model('catalog/category');
		$universities = $this->model_catalog_category->getCategories();
		$this->data['universities'] = $universities;

		
		$NKUniversity = $this->model_account_customer->NKUniversity();//lay trong database id cua truong nang khieu
		$this->data['NKUniversity'] = $NKUniversity;//set no ra ngoai view
		
		$genders = array(
					array('gender_id' => '1', 'gender' => $this->language->get('entry_male')),
					array('gender_id' => '0', 'gender' => $this->language->get('entry_female')),
					);
					
		$this->data['genders'] = $genders;
		
		//start vlmn modification
		$this->data['fields'] = $this->model_account_customer->getFields();
		//end vlmn modification
		
        //if (isset($this->error['university'])) {
		//	$this->data['error_university'] = $this->error['university'];
		//} else {
			//$this->data['error_university'] = '';
		//}
                if (isset($this->error['ethnic'])) {
			$this->data['error_ethnic'] = $this->error['ethnic'];
		} else {
			$this->data['error_ethnic'] = '';
		}

		if (isset($this->error['date_of_birth'])) {
			$this->data['error_date_of_birth'] = $this->error['date_of_birth'];
		} else {
			$this->data['error_date_of_birth'] = '';
		}
		if (isset($this->error['faculty'])) {
			$this->data['error_faculty'] = $this->error['faculty'];
		} else {
			$this->data['error_faculty'] = '';
		}
		if (isset($this->error['student_id'])) {
			$this->data['error_student_id'] = $this->error['student_id'];
		} else {
			$this->data['error_student_id'] = '';
		}
		if (isset($this->error['idnum'])) {
			$this->data['error_idnum'] = $this->error['idnum'];
		} else {
			$this->data['error_idnum'] = '';
		}
		/*if (isset($this->error['iddate'])) {
			$this->data['error_iddate'] = $this->error['iddate'];
		} else {
			$this->data['error_iddate'] = '';
		}*/
		if (isset($this->error['address_2'])) {
			$this->data['error_address_2'] = $this->error['address_2'];
		} else {
			$this->data['error_address_2'] = '';
		}
		if (isset($this->error['gender'])) {
			$this->data['error_gender'] = $this->error['gender'];
		} else {
			$this->data['error_gender'] = '';
		}
		if (isset($this->error['id_location'])) {
			$this->data['error_id_location'] = $this->error['id_location'];
		} else {
			$this->data['error_id_location'] = '';
		}
		
		
                if (isset($this->request->post['ethnic'])) {
                    $this->data['ethnic'] = $this->request->post['ethnic'];
		} else {
			$this->data['ethnic'] = '';
		}


		if (isset($this->request->post['datebirth'])) {
                    $this->data['datebirth'] = $this->request->post['datebirth'];
		} else {
			$this->data['datebirth'] = 0;
		}

		if (isset($this->request->post['monthbirth'])) {
                    $this->data['monthbirth'] = $this->request->post['monthbirth'];
		} else {
			$this->data['monthbirth'] = 0;
		}

		if (isset($this->request->post['yearbirth'])) {
                    $this->data['yearbirth'] = $this->request->post['yearbirth'];
		} else {
			$this->data['yearbirth'] = 0;
		}

		
        /*if (isset($this->request->post['date_of_birth'])) {
                    $this->data['date_of_birth'] = $this->request->post['date_of_birth'];
		} else {
			$this->data['date_of_birth'] = '';
		}*/
		if (isset($this->request->post['university_id'])) {
                    $this->data['university_id'] = $this->request->post['university_id'];
		} else {
			$this->data['university_id'] = '';
		}
		if (isset($this->request->post['faculty_id'])) {
    		$this->data['faculty_id'] = $this->request->post['faculty_id'];
		} else {
			$this->data['faculty_id'] = '';
		}
		if (isset($this->request->post['student_id'])) {
    		$this->data['student_id'] = $this->request->post['student_id'];
		} else {
			$this->data['student_id'] = '';
		}
		if (isset($this->request->post['gender_id'])) {
    		$this->data['gender_id'] = $this->request->post['gender_id'];
		} else {
			$this->data['gender_id'] = '';
		}
		if (isset($this->request->post['id_location'])) {
    		$this->data['id_location'] = $this->request->post['id_location'];
		} else {
			$this->data['id_location'] = '';
		}

		if (isset($this->request->post['address_4'])) {
    		$this->data['address_4'] = $this->request->post['address_4'];
		} else {
			$this->data['address_4'] = '';
		}

		if (isset($this->request->post['address_9'])) {
    		$this->data['address_9'] = $this->request->post['address_9'];
		} else {
			$this->data['address_9'] = '';
		}

		if (isset($this->request->post['id_num'])) {
    		$this->data['id_num'] = $this->request->post['id_num'];
		} else {
			$this->data['id_num'] = '';
		}
		/*if (isset($this->request->post['iddate'])) {
    		$this->data['iddate'] = $this->request->post['iddate'];
		} else {
			$this->data['iddate'] = '';
		}*/
		/////////// END “you-id” - “your-name” modifications/////////////
		
		$this->data['entry_fullname'] = $this->language->get('entry_fullname');
    	//$this->data['entry_firstname'] = $this->language->get('entry_firstname');
    	//$this->data['entry_lastname'] = $this->language->get('entry_lastname');
    	$this->data['entry_email'] = $this->language->get('entry_email');
    	$this->data['entry_telephone'] = $this->language->get('entry_telephone');
    	$this->data['entry_fax'] = $this->language->get('entry_fax');
		$this->data['entry_company'] = $this->language->get('entry_company');
		$this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$this->data['entry_company_id'] = $this->language->get('entry_company_id');
		$this->data['entry_tax_id'] = $this->language->get('entry_tax_id');
		$this->data['entry_address_0'] = $this->language->get('entry_address_0');
    	$this->data['entry_address_1'] = $this->language->get('entry_address_1');
    	$this->data['entry_address_2'] = $this->language->get('entry_address_2');
    	$this->data['entry_address_3'] = $this->language->get('entry_address_3');
    	$this->data['entry_address_4'] = $this->language->get('entry_address_4');
    	$this->data['entry_address_5'] = $this->language->get('entry_address_5');
    	$this->data['entry_address_6'] = $this->language->get('entry_address_6');
    	$this->data['entry_address_7'] = $this->language->get('entry_address_7');
    	$this->data['entry_address_8'] = $this->language->get('entry_address_8');
    	$this->data['entry_address_9'] = $this->language->get('entry_address_9');      
    	$this->data['entry_postcode'] = $this->language->get('entry_postcode');
    	$this->data['entry_city'] = $this->language->get('entry_city');
    	$this->data['entry_country'] = $this->language->get('entry_country');
    	$this->data['entry_zone'] = $this->language->get('entry_zone');
		$this->data['entry_newsletter'] = $this->language->get('entry_newsletter');
    	$this->data['entry_password'] = $this->language->get('entry_password');
    	$this->data['entry_confirm'] = $this->language->get('entry_confirm');

		$this->data['button_continue'] = $this->language->get('button_continue');
    
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['fullname'])) {
			$this->data['error_fullname'] = $this->error['fullname'];
		} else {
			$this->data['error_fullname'] = '';
		}	

		//kah2914
		if (isset($this->error['txtCaptcha'])) {
			$this->data['error_txtCaptcha'] = $this->error['txtCaptcha'];
		} else {
			$this->data['error_txtCaptcha'] = '';
		}	
		//kah2914

		//kah2914
		if (isset($this->error['portrait'])) {
			$this->data['error_portrait'] = $this->error['portrait'];
		} else {
			$this->data['error_portrait'] = '';
		}	
		//kah2914
		
		/*
		if (isset($this->error['firstname'])) {
			$this->data['error_firstname'] = $this->error['firstname'];
		} else {
			$this->data['error_firstname'] = '';
		}	
		
		if (isset($this->error['lastname'])) {
			$this->data['error_lastname'] = $this->error['lastname'];
		} else {
			$this->data['error_lastname'] = '';
		}*/		
	
		if (isset($this->error['email'])) {
			$this->data['error_email'] = $this->error['email'];
		} else {
			$this->data['error_email'] = '';
		}
		
		if (isset($this->error['telephone'])) {
			$this->data['error_telephone'] = $this->error['telephone'];
		} else {
			$this->data['error_telephone'] = '';
		}
		
		if (isset($this->error['password'])) {
			$this->data['error_password'] = $this->error['password'];
		} else {
			$this->data['error_password'] = '';
		}
		
 		if (isset($this->error['confirm'])) {
			$this->data['error_confirm'] = $this->error['confirm'];
		} else {
			$this->data['error_confirm'] = '';
		}
		
  		if (isset($this->error['company_id'])) {
			$this->data['error_company_id'] = $this->error['company_id'];
		} else {
			$this->data['error_company_id'] = '';
		}
		
  		if (isset($this->error['tax_id'])) {
			$this->data['error_tax_id'] = $this->error['tax_id'];
		} else {
			$this->data['error_tax_id'] = '';
		}

		if (isset($this->error['reason'])) {
			$this->data['error_reason'] = $this->error['reason'];
		} else {
			$this->data['error_reason'] = '';
		}
		
		if (isset($this->error['address_0'])) {
			$this->data['error_address_0'] = $this->error['address_0'];
		} else {
			$this->data['error_address_0'] = '';
		}						
  		if (isset($this->error['address_1'])) {
			$this->data['error_address_1'] = $this->error['address_1'];
		} else {
			$this->data['error_address_1'] = '';
		}
		if (isset($this->error['address_3'])) {
			$this->data['error_address_3'] = $this->error['address_3'];
		} else {
			$this->data['error_address_3'] = '';
		}
		if (isset($this->error['address_4'])) {
			$this->data['error_address_4'] = $this->error['address_4'];
		} else {
			$this->data['error_address_4'] = '';
		}
   		if (isset($this->error['address_5'])) {
			$this->data['error_address_5'] = $this->error['address_5'];
		} else {
			$this->data['error_address_5'] = '';
		}
		if (isset($this->error['address_6'])) {
			$this->data['error_address_6'] = $this->error['address_6'];
		} else {
			$this->data['error_address_6'] = '';
		}			
		if (isset($this->error['address_7'])) {
			$this->data['error_address_7'] = $this->error['address_7'];
		} else {
			$this->data['error_address_7'] = '';
		}			
		if (isset($this->error['address_8'])) {
			$this->data['error_address_8'] = $this->error['address_8'];
		} else {
			$this->data['error_address_8'] = '';
		}						
		if (isset($this->error['address_9'])) {
			$this->data['error_address_9'] = $this->error['address_9'];
		} else {
			$this->data['error_address_9'] = '';
		}						
		if (isset($this->error['city'])) {
			$this->data['error_city'] = $this->error['city'];
		} else {
			$this->data['error_city'] = '';
		}
		
		if (isset($this->error['postcode'])) {
			$this->data['error_postcode'] = $this->error['postcode'];
		} else {
			$this->data['error_postcode'] = '';
		}

		if (isset($this->error['country'])) {
			$this->data['error_country'] = $this->error['country'];
		} else {
			$this->data['error_country'] = '';
		}

		if (isset($this->error['zone'])) {
			$this->data['error_zone'] = $this->error['zone'];
		} else {
			$this->data['error_zone'] = '';
		}
		
    	$this->data['action'] = $this->url->link('account/register', '', 'SSL');

    	if (isset($this->request->post['fullname'])) {
    		$this->data['fullname'] = $this->request->post['fullname'];
		} else {
			$this->data['fullname'] = '';
		}
		
		/*if (isset($this->request->post['firstname'])) {
    		$this->data['firstname'] = $this->request->post['firstname'];
		} else {
			$this->data['firstname'] = '';
		}

		if (isset($this->request->post['lastname'])) {
    		$this->data['lastname'] = $this->request->post['lastname'];
		} else {
			$this->data['lastname'] = '';
		}*/
		
		if (isset($this->request->post['email'])) {
    		$this->data['email'] = $this->request->post['email'];
		} else {
			$this->data['email'] = '';
		}
		
		if (isset($this->request->post['telephone'])) {
    		$this->data['telephone'] = $this->request->post['telephone'];
		} else {
			$this->data['telephone'] = '';
		}
		
		if (isset($this->request->post['fax'])) {
    		$this->data['fax'] = $this->request->post['fax'];
		} else {
			$this->data['fax'] = '';
		}
		
		if (isset($this->request->post['company'])) {
    		$this->data['company'] = $this->request->post['company'];
		} else {
			$this->data['company'] = '';
		}

		$this->load->model('account/customer_group');
		
		$this->data['customer_groups'] = array();
		
		if (is_array($this->config->get('config_customer_group_display'))) {
			$customer_groups = $this->model_account_customer_group->getCustomerGroups();
			
			foreach ($customer_groups as $customer_group) {
				if (in_array($customer_group['customer_group_id'], $this->config->get('config_customer_group_display'))) {
					$this->data['customer_groups'][] = $customer_group;
				}
			}
		}
		
		if (isset($this->request->post['customer_group_id'])) {
    		$this->data['customer_group_id'] = $this->request->post['customer_group_id'];
		} else {
			$this->data['customer_group_id'] = $this->config->get('config_customer_group_id');
		}
		
		// Company ID
		if (isset($this->request->post['company_id'])) {
    		$this->data['company_id'] = $this->request->post['company_id'];
		} else {
			$this->data['company_id'] = '';
		}
		
		// Tax ID
		if (isset($this->request->post['tax_id'])) {
    		$this->data['tax_id'] = $this->request->post['tax_id'];
		} else {
			$this->data['tax_id'] = '';
		}
						

		if (isset($this->request->post['address_0'])) {
    		$this->data['address_0'] = $this->request->post['address_0'];
		} else {
			$this->data['address_0'] = '';
		}

		if (isset($this->request->post['address_1'])) {
    		$this->data['address_1'] = $this->request->post['address_1'];
		} else {
			$this->data['address_1'] = '';
		}

		if (isset($this->request->post['address_2'])) {
    		$this->data['address_2'] = $this->request->post['address_2'];
		} else {
			$this->data['address_2'] = '';
		}

		if (isset($this->request->post['address_3'])) {
    		$this->data['address_3'] = $this->request->post['address_3'];
		} else {
			$this->data['address_3'] = '';
		}

		if (isset($this->request->post['address_4'])) {
    		$this->data['address_4'] = $this->request->post['address_4'];		
    	} else {
			$this->data['address_4'] = '';
		}
		if (isset($this->request->post['address_5'])) {
    		$this->data['address_5'] = $this->request->post['address_5'];
		} else {
			$this->data['address_5'] = '';
		}

		if (isset($this->request->post['address_6'])) {
    		$this->data['address_6'] = $this->request->post['address_6'];
		} else {
			$this->data['address_6'] = '';
		}

		if (isset($this->request->post['address_7'])) {
    		$this->data['address_7'] = $this->request->post['address_7'];
		} else {
			$this->data['address_7'] = '';
		}

		if (isset($this->request->post['address_8'])) {
    		$this->data['address_8'] = $this->request->post['address_8'];
		} else {
			$this->data['address_8'] = '';
		}

		if (isset($this->request->post['address_9'])) {
    		$this->data['address_9'] = $this->request->post['address_9'];		
    	} else {
			$this->data['address_9'] = '';
		}
		if (isset($this->request->post['reason'])) {
    		$this->data['reason'] = $this->request->post['reason'];		
    	} else {
			$this->data['reason'] = '';
		}
		
		if (isset($this->request->post['postcode'])) {
    		$this->data['postcode'] = $this->request->post['postcode'];
		} elseif (isset($this->session->data['shipping_postcode'])) {
			$this->data['postcode'] = $this->session->data['shipping_postcode'];		
		} else {
			$this->data['postcode'] = '';
		}
		
		if (isset($this->request->post['city'])) {
    		$this->data['city'] = $this->request->post['city'];
		} else {
			$this->data['city'] = '';
		}

    	if (isset($this->request->post['country_id'])) {
      		$this->data['country_id'] = $this->request->post['country_id'];
		} elseif (isset($this->session->data['shipping_country_id'])) {
			$this->data['country_id'] = $this->session->data['shipping_country_id'];		
		} else {	
      		$this->data['country_id'] = $this->config->get('config_country_id');
    	}

    	if (isset($this->request->post['zone_id'])) {
      		$this->data['zone_id'] = $this->request->post['zone_id']; 	
		} elseif (isset($this->session->data['shipping_zone_id'])) {
			$this->data['zone_id'] = $this->session->data['shipping_zone_id'];			
		} else {
      		$this->data['zone_id'] = '';
    	}
		
		$this->load->model('localisation/country');
		
    	$this->data['countries'] = $this->model_localisation_country->getCountries();
		
		if (isset($this->request->post['password'])) {
    		$this->data['password'] = $this->request->post['password'];
		} else {
			$this->data['password'] = '';
		}
		
		if (isset($this->request->post['confirm'])) {
    		$this->data['confirm'] = $this->request->post['confirm'];
		} else {
			$this->data['confirm'] = '';
		}
		
		if (isset($this->request->post['newsletter'])) {
    		$this->data['newsletter'] = $this->request->post['newsletter'];
		} else {
			$this->data['newsletter'] = '';
		}	

		if ($this->config->get('config_account_id')) {
			$this->load->model('catalog/information');
			
			$information_info = $this->model_catalog_information->getInformation($this->config->get('config_account_id'));
			
			if ($information_info) {
				$this->data['text_agree'] = sprintf($this->language->get('text_agree'), $this->url->link('information/information/info', 'information_id=' . $this->config->get('config_account_id'), 'SSL'), $information_info['title'], $information_info['title']);
			} else {
				$this->data['text_agree'] = '';
			}
		} else {
			$this->data['text_agree'] = '';
		}
		$this->data['text_agree0']=$this->language->get('text_agree0');
		$this->data['text_agree1']=$this->language->get('text_agree1');
		$this->data['text_agree2']=$this->language->get('text_agree2');
		$this->data['text_agree3']=$this->language->get('text_agree3');
		$this->data['text_agree4']=$this->language->get('text_agree4');
		$this->data['text_agree5']=$this->language->get('text_agree5');
		$this->data['text_agree6']=$this->language->get('text_agree6');
		$this->data['text_agree7']=$this->language->get('text_agree7');
		$this->data['text_agree8']=$this->language->get('text_agree8');
		$this->data['entry_reason']=$this->language->get('entry_reason');
		
		///////////////////////

		if (isset($this->request->post['agree'])) {
      		$this->data['agree'] = $this->request->post['agree'];
		} else {
			$this->data['agree'] = false;
		}
		if (isset($this->request->post['policy'])) {
      		$this->data['policy'] = $this->request->post['policy'];
		} else {
			$this->data['policy'] = 8;
		}
		/*
		if (isset($this->request->post['agree1'])) {
      		$this->data['agree1'] = $this->request->post['agree1'];
		} else {
			$this->data['agree1'] = false;
		}

		if (isset($this->request->post['agree2'])) {
      		$this->data['agree2'] = $this->request->post['agree2'];
		} else {
			$this->data['agree2'] = false;
		}
		
		if (isset($this->request->post['agree3'])) {
      		$this->data['agree3'] = $this->request->post['agree3'];
		} else {
			$this->data['agree3'] = false;
		}
		
		if (isset($this->request->post['agree4'])) {
      		$this->data['agree4'] = $this->request->post['agree4'];
		} else {
			$this->data['agree4'] = false;
		}
		
		if (isset($this->request->post['agree5'])) {
      		$this->data['agree5'] = $this->request->post['agree5'];
		} else {
			$this->data['agree5'] = false;
		}
		
		if (isset($this->request->post['agree6'])) {
      		$this->data['agree6'] = $this->request->post['agree6'];
		} else {
			$this->data['agree6'] = false;
		}
		
		if (isset($this->request->post['agree7'])) {
      		$this->data['agree7'] = $this->request->post['agree7'];
		} else {
			$this->data['agree7'] = false;
		}
		
		if (isset($this->request->post['agree8'])) {
      		$this->data['agree8'] = $this->request->post['agree8'];
		} else {
			$this->data['agree8'] = false;
		}
		*/
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/register.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/register.tpl';
		} else {
			$this->template = 'default/template/account/register.tpl';
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
	
  	protected function validate() {
  		// kah2914
  		if ($_FILES['userfile']['name']==""){
  			$this->error['portrait'] = $this->language->get('error_portrait');
  		}
  		// kah2914

  		// kah2914
		if ($this->request->post['txtCaptcha'] != $_SESSION["security_code"])
		{			
			$this->error['txtCaptcha'] = $this->language->get('error_txtCaptcha');
		}
		// kah2914    		



  		if ((utf8_strlen($this->request->post['fullname']) < 1) || (utf8_strlen($this->request->post['fullname']) > 32)) {
      		$this->error['fullname'] = $this->language->get('error_fullname');
    	}

    	/*if ((utf8_strlen($this->request->post['firstname']) < 1) || (utf8_strlen($this->request->post['firstname']) > 32)) {
      		$this->error['firstname'] = $this->language->get('error_firstname');
    	}

    	if ((utf8_strlen($this->request->post['lastname']) < 1) || (utf8_strlen($this->request->post['lastname']) > 32)) {
      		$this->error['lastname'] = $this->language->get('error_lastname');
    	}*/

    	if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
      		$this->error['email'] = $this->language->get('error_email');
    	}

    	if ($this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {
      		$this->error['warning'] = $this->language->get('error_exists');
    	}
		
    	if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
      		$this->error['telephone'] = $this->language->get('error_telephone');
    	}
		
	/////////////////////// Modification//////////////////////
        //       ID: 1051018	 	 	 	 	
        //       Name: Tran Thanh Toan	 	 	 	 	
        // 	 Class: 10CTT 
        // 	 Date 1/1/2014
        // 	 Description: check for input error
        // 	 Date modified: 1/1/2014 
        // 	 Last updated: list the change by line number and goal, ex: 
        //	 	 + line 289: optimize the operation
        /////////// Start “you-id” - “your-name” modifications/////////////
        if ((utf8_strlen($this->request->post['ethnic']) >= 9)) {
      		$this->error['ethnic'] = $this->language->get('error_ethnic');
    	}
		if ((utf8_strlen($this->request->post['id_num']) != 9)) {
      		$this->error['idnum'] = $this->language->get('error_idnum');
    	}
		//if ((int)$this->request->post['university_id'] == -1) {
      		//$this->error['university'] = $this->language->get('error_university');
    	//}
		/*if ((int)$this->request->post['faculty_id'] == -1) {
      		$this->error['faculty'] = $this->language->get('error_faculty');
    	}*/		
		if ($this->request->post['student_id'] == '' || !$this->checkStudentID($this->request->post['student_id'])) {
      		$this->error['student_id'] = $this->language->get('error_student_id');
    	}
		
		if ($this->request->post['reason'] == '' || strlen($this->request->post['reason']) < 15) {
      		$this->error['reason'] = $this->language->get('error_reason');
    	}
        //kah2914
        if (is_null(utf8_strlen($this->request->post['id_num'])) || !$this->checkIDNum($this->request->post['id_num'])) {
      		//$this->error['error_idnum'] = $this->language->get('error_idnum');
      		$this->error['idnum'] = $this->language->get('error_idnum');
    	}
    	//kah2914
				//check input date satisfy dd/mm/yyyy
		/*if (!$this->checkdateDDMMYYYY($this->request->post['iddate'])) {
      		$this->error['iddate'] = $this->language->get('error_iddate');
    	}*/
    	if (!$this->checkdateofbirth($this->request->post['datebirth'],$this->request->post['monthbirth'],$this->request->post['yearbirth'])) {
      		$this->error['date_of_birth'] = $this->language->get('error_date_of_birth');
    	}
        /*if (!$this->checkdateDDMMYYYY($this->request->post['date_of_birth'])) {
      		$this->error['date_of_birth'] = $this->language->get('error_date_of_birth');
    	}*/
        /////////// END “you-id” - “your-name” modifications/////////////
		
		// Customer Group
		$this->load->model('account/customer_group');
		
		if (isset($this->request->post['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($this->request->post['customer_group_id'], $this->config->get('config_customer_group_display'))) {
			$customer_group_id = $this->request->post['customer_group_id'];
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}

		$customer_group = $this->model_account_customer_group->getCustomerGroup($customer_group_id);
			
		if ($customer_group) {	
			// Company ID
			if ($customer_group['company_id_display'] && $customer_group['company_id_required'] && empty($this->request->post['company_id'])) {
				$this->error['company_id'] = $this->language->get('error_company_id');
			}
			
			// Tax ID 
			if ($customer_group['tax_id_display'] && $customer_group['tax_id_required'] && empty($this->request->post['tax_id'])) {
				$this->error['tax_id'] = $this->language->get('error_tax_id');
			}						
		}
		
    	if ((utf8_strlen($this->request->post['address_0']) < 1) || (utf8_strlen($this->request->post['address_0']) > 128)) {
      		$this->error['address_0'] = $this->language->get('error_address_0');
    	}
    	if ((utf8_strlen($this->request->post['address_1']) < 1) || (utf8_strlen($this->request->post['address_1']) > 128)) {
      		$this->error['address_1'] = $this->language->get('error_address_1');
    	}
    	if ((utf8_strlen($this->request->post['address_3']) < 1) || (utf8_strlen($this->request->post['address_3']) > 128)) {
      		$this->error['address_3'] = $this->language->get('error_address_3');
    	}

    	if ($this->request->post['address_4'] == '') {
      		$this->error['address_4'] = $this->language->get('error_address_4');
    	}

    	if ((utf8_strlen($this->request->post['address_5']) < 1) || (utf8_strlen($this->request->post['address_5']) > 128)) {
      		$this->error['address_5'] = $this->language->get('error_address_5');
    	}
    	if ((utf8_strlen($this->request->post['address_6']) < 1) || (utf8_strlen($this->request->post['address_6']) > 128)) {
      		$this->error['address_6'] = $this->language->get('error_address_6');
    	}
    	if ((utf8_strlen($this->request->post['address_7']) < 1) || (utf8_strlen($this->request->post['address_7']) > 128)) {
      		$this->error['address_7'] = $this->language->get('error_address_7');
    	}
    	if ((utf8_strlen($this->request->post['address_8']) < 1) || (utf8_strlen($this->request->post['address_8']) > 128)) {
      		$this->error['address_8'] = $this->language->get('error_address_8');
    	}
		if ($this->request->post['address_9'] == '') {
      		$this->error['address_9'] = $this->language->get('error_address_9');
    	}



	/////////////////////// Modification//////////////////////
        //       ID: 1051018	 	 	 	 	
        //       Name: Tran Thanh Toan	 	 	 	 	
        // 	 Class: 10CTT 
        // 	 Date 1/1/2014
        // 	 Description: check for input error (contiunue)
        // 	 Date modified: 1/1/2014 
        // 	 Last updated: list the change by line number and goal, ex: 
        //	 	 + line 289: optimize the operation
        /////////// Start “you-id” - “your-name” modifications/////////////
		if ((utf8_strlen($this->request->post['address_2']) < 1) || (utf8_strlen($this->request->post['address_2']) > 128)) {
      		$this->error['address_2'] = $this->language->get('error_address_2');
    	}
		if ($this->request->post['gender_id'] == '') {
      		$this->error['gender'] = $this->language->get('error_gender');
    	}
		/*if ($this->request->post['id_location'] == '') {
      		$this->error['id_location'] = $this->language->get('error_id_location');
    	}*/
    	/*if ((utf8_strlen($this->request->post['city']) < 2) || (utf8_strlen($this->request->post['city']) > 128)) {
      		$this->error['city'] = $this->language->get('error_city');
    	}*/
		/////////// END “you-id” - “your-name” modifications/////////////

		$this->load->model('localisation/country');
		
		$country_info = $this->model_localisation_country->getCountry(300);//$this->request->post['country_id']);
		
		if ($country_info) {
			// VAT Validation
			$this->load->helper('vat');
			
			if ($this->config->get('config_vat') && $this->request->post['tax_id'] && (vat_validation($country_info['iso_code_2'], $this->request->post['tax_id']) == 'invalid')) {
				$this->error['tax_id'] = $this->language->get('error_vat');
			}
		}
		
    	//if ($this->request->post['country_id'] == '') {
      		//$this->error['country'] = $this->language->get('error_country');
    	//}
		
    	//if (!isset($this->request->post['zone_id']) || $this->request->post['zone_id'] == '') {
      	//	$this->error['zone'] = $this->language->get('error_zone');
    	//}

    	if ((utf8_strlen($this->request->post['password']) < 4) || (utf8_strlen($this->request->post['password']) > 20)) {
      		$this->error['password'] = $this->language->get('error_password');
    	}

    	if ($this->request->post['confirm'] != $this->request->post['password']) {
      		$this->error['confirm'] = $this->language->get('error_confirm');
    	}
		
		if ($this->config->get('config_account_id')) {
			$this->load->model('catalog/information');
			
			$information_info = $this->model_catalog_information->getInformation($this->config->get('config_account_id'));
			
			if ($information_info && !isset($this->request->post['agree'])) {
      			$this->error['warning'] = sprintf($this->language->get('error_agree'), $information_info['title']);
			}
		}
		
    	if (!$this->error) {
      		return true;
    	} else {
      		return false;
    	}
  	}
	
	public function country() {
		$json = array();
		
		$this->load->model('localisation/country');

    	$country_info = $this->model_localisation_country->getCountry($this->request->get['country_id']);
		
		if ($country_info) {
			$this->load->model('localisation/zone');

			$json = array(
				'country_id'        => $country_info['country_id'],
				'name'              => $country_info['name'],
				'iso_code_2'        => $country_info['iso_code_2'],
				'iso_code_3'        => $country_info['iso_code_3'],
				'address_format'    => $country_info['address_format'],
				'postcode_required' => $country_info['postcode_required'],
				'zone'              => $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']),
				'status'            => $country_info['status']		
			);
		}
		
		$this->response->setOutput(json_encode($json));
	}	
	
	/////////////////////// Modification//////////////////////
        //       ID: 1051018	 	 	 	 	
        //       Name: Tran Thanh Toan	 	 	 	 	
        // 	 Class: 10CTT 
        // 	 Date 1/1/2014
        // 	 Description: check for input error (contiunue): date
        // 	 Date modified: 1/1/2014 
        // 	 Last updated: list the change by line number and goal, ex: 
        //	 	 + line 289: optimize the operation
        /////////// Start “you-id” - “your-name” modifications/////////////
	protected function checkdateDDMMYYYY($s)
	{
            if (preg_match('@^(\d\d)/(\d\d)/(\d\d\d\d)$@', $s, $m) == false) {
                if (preg_match('@^(\d)/(\d\d)/(\d\d\d\d)$@', $s, $m) == false) {
                    if (preg_match('@^(\d\d)/(\d)/(\d\d\d\d)$@', $s, $m) == false) {
                        if (preg_match('@^(\d)/(\d)/(\d\d\d\d)$@', $s, $m) == false) {
                            return false;
                        }
                    }
                }
            }
            if (checkdate($m[2], $m[1], $m[3]) == false) {
                return false;
            }
            return true;
	}
	protected function checkdateofbirth($a,$b,$c)
	{
            if (($a==0)||($b==0)||($c==0)) return false;
            if ((($c % 4)!=0)&&($b==2)&&($a==29)) return false;
            if ((($b==4)||($b==6)||($b==9)||($b==11))&&($a==31) )return false;
            if (($b==2)&&(($a==31)||($a==30)))return false;            
            return true;
	}
        /////////// END “you-id” - “your-name” modifications/////////////
        /////////////////////// Modification//////////////////////
        //       ID: 1051018	 	 	 	 	
        //       Name: Tran Thanh Toan	 	 	 	 	
        // 	 Class: 10CTT 
        // 	 Date 1/1/2014
        // 	 Description: check if a student id exist
        // 	 Date modified: 1/1/2014 
        // 	 Last updated: list the change by line number and goal, ex: 
        //	 	 + line 289: optimize the operation
        /////////// Start “you-id” - “your-name” modifications/////////////
	protected function checkStudentID($student_id) {
		$this->load->model('account/customer');
		
		if($this->model_account_customer->checkStudentID($student_id)) {
			return true;
		}
		
		return false;
	}
        protected function checkIDNum($id_num) {
		$this->load->model('account/customer');
		
		if($this->model_account_customer->checkIDNum($id_num)) {
			return true;
		}
		
		return false;
	}
	public function childcategory() {
		$json = array();
		
		$this->load->model('catalog/category');

    	$result = $this->model_catalog_category->getCategories($this->request->get['university_id']);
		$universities = array();
		
		if ($result) {
			foreach($result as $university) {
				$universities[] = array(
					'faculty_id'        => $university['category_id'],
					'name'              => $university['name']
				);
			}
		}
		
		$json = $universities;
		$this->response->setOutput(json_encode($json));
	}
	/////////// END “you-id” - “your-name” modifications/////////////

/////////////////////// Modification//////////////////////
//   ID: 1051009	 	 	 	 	
//   Name: Nguyen Dang Khoa	 	 	 	 	
// 	 Class: 10CTT 
// 	 Date 17/3/2014
// 	 Description: Fix Register page 
// 	 Date modified: 17/1/2014 
//////////////////////////////////////////////////////////

}
?>