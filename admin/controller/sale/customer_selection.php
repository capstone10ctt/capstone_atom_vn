<?php    
class ControllerSaleCustomerselection extends Controller { 
	private $error = array();
  
  	public function index() {
		$this->language->load('sale/customer_selection');
		 
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('sale/customer');
		
    	$this->getList();
  	}
  
	
	public function select() {
		$this->language->load('sale/customer_selection');
    	
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('sale/customer');
		
		if (!$this->user->hasPermission('modify', 'sale/customer')) {
			$this->error['warning'] = $this->language->get('error_permission');
		} elseif (isset($this->request->post['selected'])) {
			$selected = 0;
			
			foreach ($this->request->post['selected'] as $customer_id) {
				$this->model_sale_customer->confirmStudent($customer_id,3);
					
					$selected++;
			} 
			
			$this->session->data['success'] = sprintf($this->language->get('text_selected'), $selected);	
			
			$url = '';
		
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}
		
			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_customer_group_id'])) {
				$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
			}
		
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
			
			if (isset($this->request->get['filter_valid'])) {
				$url .= '&filter_valid=' . $this->request->get['filter_valid'];
			}

			if (isset($this->request->get['filter_resident'])) {
				$url .= '&filter_resident=' . $this->request->get['filter_resident'];
			}
				
			if (isset($this->request->get['filter_ip'])) {
				$url .= '&filter_ip=' . $this->request->get['filter_ip'];
			}
						
			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}
						
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
	
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
							
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}	
	
			$this->redirect($this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . $url, 'SSL'));			
		}
		
		$this->getList();
	} 

	public function unselect() {
		$this->language->load('sale/customer_selection');
    	
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('sale/customer');
		
		if (!$this->user->hasPermission('modify', 'sale/customer')) {
			$this->error['warning'] = $this->language->get('error_permission');
		} elseif (isset($this->request->post['selected'])) {
			$unselected = 0;
			
			foreach ($this->request->post['selected'] as $customer_id) {
				$this->model_sale_customer->confirmStudent($customer_id,2);
					
					
					$unselected++;
				
			} 
			
			$this->session->data['success'] = sprintf($this->language->get('text_unselected'), $unselected);	
			
			$url = '';
		
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}
		
			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_customer_group_id'])) {
				$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
			}
		
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
			
			if (isset($this->request->get['filter_valid'])) {
				$url .= '&filter_valid=' . $this->request->get['filter_valid'];
			}

			if (isset($this->request->get['filter_resident'])) {
				$url .= '&filter_resident=' . $this->request->get['filter_resident'];
			}
				
			if (isset($this->request->get['filter_ip'])) {
				$url .= '&filter_ip=' . $this->request->get['filter_ip'];
			}
						
			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}
						
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
	
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
							
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}	
	
			$this->redirect($this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . $url, 'SSL'));			
		}
		
		$this->getList();
	} 
   
  /////////////////////// Modification//////////////////////
  // ID: 1051015        
  // Name: Luu Minh Tan           
  // Class: 10CTT
  // Date created: 22/12/2013
  // Description: Change get list function
  // Date modified: 2/1/2014
  ////////////////////////////////////////////////////////////// 

  	protected function getList() {
            
            // start LMT

  			if (isset($this->request->get['filter_id'])) {
				$filter_id = $this->request->get['filter_id'];
			} else {
				$filter_id = null;
			}

			if (isset($this->request->get['filter_field'])) {
				$filter_field = $this->request->get['filter_field'];
			} else {
				$filter_field = null;
			}
  		
            if (isset($this->request->get['filter_gender'])) {
				$filter_gender = $this->request->get['filter_gender'];
			} else {
				$filter_gender = null;
			}
			
			if (isset($this->request->get['filter_date_of_birth'])) {
				$filter_date_of_birth = $this->request->get['filter_date_of_birth'];
			} else {
				$filter_date_of_birth = null;
			}
			if (isset($this->request->get['filter_university'])) {
				$filter_university = $this->request->get['filter_university'];
			} else {
				$filter_university = null;
			}
			if (isset($this->request->get['filter_field'])) {
				$filter_field = $this->request->get['filter_field'];
			} else {
				$filter_field = null;
			}
			if (isset($this->request->get['filter_telephone'])) {
				$filter_telephone = $this->request->get['filter_telephone'];
			} else {
				$filter_telephone = null;
			}
			if (isset($this->request->get['filter_faculty'])) {
				$filter_faculty= $this->request->get['filter_faculty'];
			} else {
				$filter_faculty = null;
			}
			if (isset($this->request->get['filter_floor_id'])) {
				$filter_floor_id = $this->request->get['filter_floor_id'];
			} else {
				$filter_floor_id = null;
			}
            if (isset($this->request->get['filter_customer_group_id'])) {
				$filter_customer_group_id = $this->request->get['filter_customer_group_id'];
			} else {
				$filter_customer_group_id = null;
			}
			if (isset($this->request->get['filter_bed'])) {
				$filter_bed= $this->request->get['filter_bed'];
			} else {
				$filter_bed = null;
			}
			if (isset($this->request->get['filter_ethnic'])) {
				$filter_ethnic= $this->request->get['filter_ethnic'];
			} else {
				$filter_ethnic = null;
			}
			if (isset($this->request->get['filter_address_1'])) {
				$filter_address_1= $this->request->get['filter_address_1'];
			} else {
				$filter_address_1 = null;
			}

			$this->data['column_student_id'] = $this->language->get('column_student_id');
			$this->data['column_gender'] = $this->language->get('column_gender');
			$this->data['column_telephone'] = $this->language->get('column_telephone');
			$this->data['column_university'] = $this->language->get('column_university');
			$this->data['column_faculty'] = $this->language->get('column_faculty');
			$this->data['column_floor'] = $this->language->get('column_floor');
			$this->data['column_date_of_birth'] = $this->language->get('column_date_of_birth');
			$this->data['column_ethnic'] = $this->language->get('column_ethnic');
			$this->data['column_bed'] = $this->language->get('column_bed');
			$this->data['column_address_1'] = $this->language->get('column_address_1');

			$this->data['text_male'] = $this->language->get('text_male');
			$this->data['text_female'] = $this->language->get('text_female');

			$this->load->model('catalog/category');
			$universities = $this->model_catalog_category->getUniversityCategories();
			$this->data['universities'] = $universities;

			$NKUniversity = $this->model_catalog_category->NKUniversity();
			$this->data['NKUniversity'] = $NKUniversity;
			$this->data['text_finish'] = $this->language->get('text_finish');
			$this->data['text_unselect'] = $this->language->get('text_unselect');
			$this->data['text_none'] = $this->language->get('text_none');
			$this->data['text_not_valid'] = $this->language->get('text_not_valid');
			$this->data['text_valid'] = $this->language->get('text_valid');
			$this->data['text_resident'] = $this->language->get('text_resident');
			$this->data['text_not_resident'] = $this->language->get('text_not_resident');
			$this->data['text_report_field'] = $this->language->get('text_report_field');
			$this->data['text_unidentified_field'] = $this->language->get('text_unidentified_field');
			$this->data['text_report'] = $this->language->get('text_report');



			$genders = array(
					array('gender_id' => '1', 'gender_name' => $this->language->get('entry_male')),
					array('gender_id' => '0', 'gender_name' => $this->language->get('entry_female')),
					);
					
			$this->data['genders'] = $genders;

			$beds = array(
					array('bed_id' => '1', 'name' => $this->language->get('entry_bed_1')),
					array('bed_id' => '2', 'name' => $this->language->get('entry_bed_2')),
					array('bed_id' => '3', 'name' => $this->language->get('entry_bed_3')),
					array('bed_id' => '4', 'name' => $this->language->get('entry_bed_4')),
					array('bed_id' => '5', 'name' => $this->language->get('entry_bed_5')),
					array('bed_id' => '6', 'name' => $this->language->get('entry_bed_6')),
					array('bed_id' => '7', 'name' => $this->language->get('entry_bed_7')),
					array('bed_id' => '8', 'name' => $this->language->get('entry_bed_8')),
					);
					
			$this->data['beds'] = $beds;

            // end LMT
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}
		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = null;
		}
		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}
		
		if (isset($this->request->get['filter_valid'])) {
			$filter_valid = $this->request->get['filter_valid'];
		} else {
			$filter_valid = null;
		}

		if (isset($this->request->get['filter_resident'])) {
			$filter_resident = $this->request->get['filter_resident'];
		} else {
			$filter_resident = null;
		}
		
		if (isset($this->request->get['filter_ip'])) {
			$filter_ip = $this->request->get['filter_ip'];
		} else {
			$filter_ip = null;
		}
				
		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = null;
		}		
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name'; 
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
						
		$url = '';
		// start LMT
		if (isset($this->request->get['filter_gender'])) {
			$url .= '&filter_gender=' . $this->request->get['filter_gender'];
		}	

		if (isset($this->request->get['filter_id'])) {
			$url .= '&filter_id=' . $this->request->get['filter_id'];
		}

		if (isset($this->request->get['filter_field'])) {
			$url .= '&filter_field=' . $this->request->get['filter_field'];
		}	
		if (isset($this->request->get['filter_telephone'])) {
			$url .= '&filter_telephone=' . urlencode(html_entity_decode($this->request->get['filter_telephone'], ENT_QUOTES, 'UTF-8'));
		}	

		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}	
		if (isset($this->request->get['filter_date_of_birth'])) {
			$url .= '&filter_date_of_birth=' . $this->request->get['filter_date_of_birth'];
		}	
		if (isset($this->request->get['filter_university'])) {
			$url .= '&filter_university=' . $this->request->get['filter_university'];
		}
		if (isset($this->request->get['filter_faculty'])) {
			$url .= '&filter_faculty=' . $this->request->get['filter_faculty'];
		}
		if (isset($this->request->get['filter_floor_id'])) {
			$url .= '&filter_floor_id=' . $this->request->get['filter_floor_id'];
		}
		if (isset($this->request->get['filter_bed'])) {
			$url .= '&filter_bed=' . $this->request->get['filter_bed'];
		}
		if (isset($this->request->get['filter_ethnic'])) {
			$url .= '&filter_ethnic=' . urlencode(html_entity_decode($this->request->get['filter_ethnic'], ENT_QUOTES, 'UTF-8'));
		}
		if (isset($this->request->get['filter_address_1'])) {
			$url .= '&filter_address_1=' . $this->request->get['filter_address_1'];
		}
		
		// end LMT

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}
			
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
		
		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_approved'];
		}	
		
		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . $this->request->get['filter_ip'];
		}
					
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
						
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['select'] = $this->url->link('sale/customer_selection/select', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['unselect'] = $this->url->link('sale/customer_selection/unselect', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['insert'] = $this->url->link('sale/customer/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('sale/customer/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');


		$this->data['customers'] = array();

		$data = array(
            // start LMT
            'filter_university'              => $filter_university,
            'filter_faculty'              => $filter_faculty,
            'filter_floor_id'              => $filter_floor_id,
            'filter_date_of_birth' 		=> $filter_date_of_birth,

            'filter_bed'              => $filter_bed,
            'filter_ethnic'              => $filter_ethnic,
            'filter_address_1'              => $filter_address_1,

            'filter_id'            => $filter_id,
            'filter_field'            => $filter_field,
            'filter_telephone'            => $filter_telephone, 
            // end LMT
			'filter_name'              => $filter_name, 
			'filter_email'             => $filter_email, 
			'filter_customer_group_id' => $filter_customer_group_id, 
			'filter_status'            => $filter_status, 
			'filter_valid'            => $filter_valid, 
			'filter_resident'            => $filter_resident, 
			'filter_student_status'          => 2, 
			'filter_date_added'        => $filter_date_added,
			'filter_ip'                => $filter_ip,
			'sort'                     => $sort,
			'order'                    => $order,
			'start'                    => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                    => $this->config->get('config_admin_limit')
		);
		
		$customer_total = $this->model_sale_customer->getTotalStudentsByData($data);
	
		$results = $this->model_sale_customer->getStudents($data);
	
 
    	foreach ($results as $result) {
			$action = array();
		
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('sale/customer/update', 'token=' . $this->session->data['token'] . '&customer_id=' . $result['customer_id'] . $url, 'SSL')
			);
			
			// start LMT
			
			$this->load->model('catalog/category');
			$university = $this->model_catalog_category->getCategory($result['university']);
			$faculty = $this->model_catalog_category->getCategory($result['faculty']);
			$this->load->model('localisation/zone');
			$zone = $this->model_localisation_zone->getZone($result['id_location']);
			// $address = get address by id_location

			$this->data['customers'][] = array(
                 
				'customer_id'    => $result['customer_id'],
				'student_id'    => $result['student_id'],
				'name'           => $result['name'],
				'gender'          => ($result['gender'] ? $this->language->get('text_male') : $this->language->get('text_female')),
				'field'				=> $result['field'],
				'telephone'				=> $result['telephone'],
				'date_of_birth' 	=> date("d-m-Y", strtotime($result['date_of_birth'])),
				'bed'          => $result['bed'],
				'ethnic'          => $result['ethnic'],
				'status'         => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'valid'       => ($result['student_valid'] ? $this->language->get('text_valid') : $this->language->get('text_not_valid')),
				'resident'       => ($result['resident'] ? $this->language->get('text_resident') : $this->language->get('text_not_resident')),

				
				'selected'       => isset($this->request->post['selected']) && in_array($result['customer_id'], $this->request->post['selected']),
				'action'         => $action
                 // end LMT           
				
			);
		}	
					
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');	
		$this->data['text_select'] = $this->language->get('text_select');	
		$this->data['text_default'] = $this->language->get('text_default');		
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_verify'] = $this->language->get('text_verify');

		$this->data['column_field'] = $this->language->get('column_field');
		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_email'] = $this->language->get('column_email');
		$this->data['column_customer_group'] = $this->language->get('column_customer_group');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_approved'] = $this->language->get('column_approved');
		$this->data['column_ip'] = $this->language->get('column_ip');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_login'] = $this->language->get('column_login');
		$this->data['column_action'] = $this->language->get('column_action');		
		
		$this->data['button_finish'] = $this->language->get('button_finish');
		$this->data['button_unselect'] = $this->language->get('button_unselect');
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_filter'] = $this->language->get('button_filter');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		$url = '';

		// start LMT
		if (isset($this->request->get['filter_gender'])) {
			$url .= '&filter_gender=' . $this->request->get['filter_gender'];
		}	

		if (isset($this->request->get['filter_telephone'])) {
			$url .= '&filter_telephone=' . $this->request->get['filter_telephone'];
		}	
		
		if (isset($this->request->get['filter_university'])) {
			$url .= '&filter_university=' . $this->request->get['filter_university'];
		}
		if (isset($this->request->get['filter_date_of_birth'])) {
			$url .= '&filter_date_of_birth=' . $this->request->get['filter_date_of_birth'];
		}	
		if (isset($this->request->get['filter_faculty'])) {
			$url .= '&filter_faculty=' . $this->request->get['filter_faculty'];
		}
		if (isset($this->request->get['filter_floor_id'])) {
			$url .= '&filter_floor_id=' . $this->request->get['filter_floor_id'];
		}
		if (isset($this->request->get['filter_bed'])) {
			$url .= '&filter_bed=' . $this->request->get['filter_bed'];
		}
		if (isset($this->request->get['filter_ethnic'])) {
			$url .= '&filter_ethnic=' . urlencode(html_entity_decode($this->request->get['filter_ethnic'], ENT_QUOTES, 'UTF-8'));
		}
		if (isset($this->request->get['filter_address_1'])) {
			$url .= '&filter_address_1=' . $this->request->get['filter_address_1'];
		}
		// end LMT
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}
			
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
		
		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_approved'];
		}	
		
		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . $this->request->get['filter_ip'];
		}
				
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
			
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		// start LMT
		$this->data['sort_field'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=field' . $url, 'SSL');
		$this->data['sort_student_id'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=student_id' . $url, 'SSL');
		$this->data['sort_date_of_birth'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=date_of_birth' . $url, 'SSL');
		$this->data['sort_gender'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=gender' . $url, 'SSL');
		$this->data['sort_telephone'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=telephone' . $url, 'SSL');
		$this->data['sort_university'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=university' . $url, 'SSL');
		$this->data['sort_faculty'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=faculty' . $url, 'SSL');	
		$this->data['sort_floor'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=floor' . $url, 'SSL');	
		$this->data['sort_bed'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=bed' . $url, 'SSL');	
		$this->data['sort_ethnic'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=ethnic' . $url, 'SSL');	
		$this->data['sort_address_1'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=id_location' . $url, 'SSL');	
		// end LMT

		$this->data['sort_name'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
		$this->data['sort_email'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=c.email' . $url, 'SSL');
		$this->data['sort_customer_group'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=customer_group' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=c.status' . $url, 'SSL');
		$this->data['sort_valid'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=c.valid' . $url, 'SSL');
		$this->data['sort_resident'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=c.resident' . $url, 'SSL');
		$this->data['sort_ip'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=c.ip' . $url, 'SSL');
		$this->data['sort_date_added'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=c.date_added' . $url, 'SSL');
		$this->data['report_amount'] = $this->url->link('sale/customer_selection/report_amount', 'token=' . $this->session->data['token'] . '&sort=c.date_added' . $url, 'SSL');

		$url = '';

		// start LMT
		if (isset($this->request->get['filter_gender'])) {
			$url .= '&filter_gender=' . $this->request->get['filter_gender'];
		}

		if (isset($this->request->get['filter_telephone'])) {
			$url .= '&filter_telephone=' . $this->request->get['filter_telephone'];
		}

		if (isset($this->request->get['filter_university'])) {
			$url .= '&filter_university=' . $this->request->get['filter_university'];
		}	
		if (isset($this->request->get['filter_date_of_birth'])) {
			$url .= '&filter_date_of_birth=' . $this->request->get['filter_date_of_birth'];
		}
		if (isset($this->request->get['filter_faculty'])) {
			$url .= '&filter_faculty=' . $this->request->get['filter_faculty'];
		}
		if (isset($this->request->get['filter_floor_id'])) {
			$url .= '&filter_floor_id=' . $this->request->get['filter_floor_id'];
		}
		if (isset($this->request->get['filter_bed'])) {
			$url .= '&filter_bed=' . $this->request->get['filter_bed'];
		}
		if (isset($this->request->get['filter_ethnic'])) {
			$url .= '&filter_ethnic=' . urlencode(html_entity_decode($this->request->get['filter_ethnic'], ENT_QUOTES, 'UTF-8'));
		}
		if (isset($this->request->get['filter_address_1'])) {
			$url .= '&filter_address_1=' . $this->request->get['filter_address_1'];
		}
		// end LMT

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
		
		if (isset($this->request->get['filter_valid'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_valid'];
		}
		
		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . $this->request->get['filter_ip'];
		}
				
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
			
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $customer_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();

		// start LMT
		$this->data['filter_university'] = $filter_university;
		$this->data['filter_id'] = $filter_id;
		$this->data['filter_field'] = $filter_field;
		$this->data['filter_gender'] = $filter_gender;
		$this->data['filter_telephone'] = $filter_telephone;
		$this->data['filter_date_of_birth'] = $filter_date_of_birth;
		$this->data['filter_faculty'] = $filter_faculty;
		$this->data['filter_floor_id'] = $filter_floor_id;
		$this->data['filter_customer_group_id'] = $filter_customer_group_id;
		$this->data['filter_bed'] = $filter_bed;
		$this->data['filter_ethnic'] = $filter_ethnic;
		$this->data['filter_address_1'] = $filter_address_1;
		// end LMT

		$this->data['filter_name'] = $filter_name;
		$this->data['filter_email'] = $filter_email;
		$this->data['filter_status'] = $filter_status;
		$this->data['filter_valid'] = $filter_valid;
		$this->data['filter_ip'] = $filter_ip;
		$this->data['filter_date_added'] = $filter_date_added;
		
		$this->load->model('sale/customer_group');
		
    	$this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups(0);

    	// start LMT 
		$this->load->model('localisation/zone');

		$id_vn = 230;
        $this->data['regions'] = $this->model_localisation_zone->getZonesByCountryId($id_vn);

        $this->data['fields'] = $this->model_sale_customer->getFields();
		// end LMT

		$this->load->model('setting/store');
		
		$this->data['stores'] = $this->model_setting_store->getStores();
				
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		
		$this->template = 'sale/customer_list_selection.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
  	}

  	public function report_amount() {
            
            $this->language->load('sale/customer_selection');
		 
			$this->document->setTitle($this->language->get('text_report_amount'));
		
			$this->load->model('sale/customer');

			if (isset($this->request->get['filter_period'])) {
				$filter_period = $this->request->get['filter_period'];
			} else {
				$filter_period = null;
			}
  			if (isset($this->request->get['filter_id'])) {
				$filter_id = $this->request->get['filter_id'];
			} else {
				$filter_id = null;
			}

			if (isset($this->request->get['filter_field'])) {
				$filter_field = $this->request->get['filter_field'];
			} else {
				$filter_field = null;
			}
  		
            if (isset($this->request->get['filter_gender'])) {
				$filter_gender = $this->request->get['filter_gender'];
			} else {
				$filter_gender = null;
			}
			
			if (isset($this->request->get['filter_date_of_birth'])) {
				$filter_date_of_birth = $this->request->get['filter_date_of_birth'];
			} else {
				$filter_date_of_birth = null;
			}
			if (isset($this->request->get['filter_university'])) {
				$filter_university = $this->request->get['filter_university'];
			} else {
				$filter_university = null;
			}
			if (isset($this->request->get['filter_field'])) {
				$filter_field = $this->request->get['filter_field'];
			} else {
				$filter_field = null;
			}
			if (isset($this->request->get['filter_telephone'])) {
				$filter_telephone = $this->request->get['filter_telephone'];
			} else {
				$filter_telephone = null;
			}
			if (isset($this->request->get['filter_faculty'])) {
				$filter_faculty= $this->request->get['filter_faculty'];
			} else {
				$filter_faculty = null;
			}
			if (isset($this->request->get['filter_floor_id'])) {
				$filter_floor_id = $this->request->get['filter_floor_id'];
			} else {
				$filter_floor_id = null;
			}
            if (isset($this->request->get['filter_customer_group_id'])) {
				$filter_customer_group_id = $this->request->get['filter_customer_group_id'];
			} else {
				$filter_customer_group_id = null;
			}
			if (isset($this->request->get['filter_bed'])) {
				$filter_bed= $this->request->get['filter_bed'];
			} else {
				$filter_bed = null;
			}
			if (isset($this->request->get['filter_ethnic'])) {
				$filter_ethnic= $this->request->get['filter_ethnic'];
			} else {
				$filter_ethnic = null;
			}
			if (isset($this->request->get['filter_address_1'])) {
				$filter_address_1= $this->request->get['filter_address_1'];
			} else {
				$filter_address_1 = null;
			}

			$this->data['column_student_id'] = $this->language->get('column_student_id');
			$this->data['column_gender'] = $this->language->get('column_gender');
			$this->data['column_telephone'] = $this->language->get('column_telephone');
			$this->data['column_university'] = $this->language->get('column_university');
			$this->data['column_faculty'] = $this->language->get('column_faculty');
			$this->data['column_floor'] = $this->language->get('column_floor');
			$this->data['column_date_of_birth'] = $this->language->get('column_date_of_birth');
			$this->data['column_ethnic'] = $this->language->get('column_ethnic');
			$this->data['column_bed'] = $this->language->get('column_bed');
			$this->data['column_address_1'] = $this->language->get('column_address_1');

			$this->data['text_male'] = $this->language->get('text_male');
			$this->data['text_female'] = $this->language->get('text_female');

			$this->load->model('catalog/category');
			$universities = $this->model_catalog_category->getUniversityCategories();
			$this->data['universities'] = $universities;

			$NKUniversity = $this->model_catalog_category->NKUniversity();
			$this->data['NKUniversity'] = $NKUniversity;
			$this->data['text_finish'] = $this->language->get('text_finish');
			$this->data['text_unselect'] = $this->language->get('text_unselect');
			$this->data['text_none'] = $this->language->get('text_none');
			$this->data['text_not_valid'] = $this->language->get('text_not_valid');
			$this->data['text_valid'] = $this->language->get('text_valid');
			$this->data['text_resident'] = $this->language->get('text_resident');
			$this->data['text_not_resident'] = $this->language->get('text_not_resident');
			$this->data['text_report_field'] = $this->language->get('text_report_field');
			$this->data['text_unidentified_field'] = $this->language->get('text_unidentified_field');
			$this->data['text_report'] = $this->language->get('text_report');



			$genders = array(
					array('gender_id' => '1', 'gender_name' => $this->language->get('entry_male')),
					array('gender_id' => '0', 'gender_name' => $this->language->get('entry_female')),
					);
					
			$this->data['genders'] = $genders;

			$beds = array(
					array('bed_id' => '1', 'name' => $this->language->get('entry_bed_1')),
					array('bed_id' => '2', 'name' => $this->language->get('entry_bed_2')),
					array('bed_id' => '3', 'name' => $this->language->get('entry_bed_3')),
					array('bed_id' => '4', 'name' => $this->language->get('entry_bed_4')),
					array('bed_id' => '5', 'name' => $this->language->get('entry_bed_5')),
					array('bed_id' => '6', 'name' => $this->language->get('entry_bed_6')),
					array('bed_id' => '7', 'name' => $this->language->get('entry_bed_7')),
					array('bed_id' => '8', 'name' => $this->language->get('entry_bed_8')),
					);
					
			$this->data['beds'] = $beds;

            // end LMT
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}
		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = null;
		}
		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}
		
		if (isset($this->request->get['filter_valid'])) {
			$filter_valid = $this->request->get['filter_valid'];
		} else {
			$filter_valid = null;
		}

		if (isset($this->request->get['filter_resident'])) {
			$filter_resident = $this->request->get['filter_resident'];
		} else {
			$filter_resident = null;
		}
		
		if (isset($this->request->get['filter_ip'])) {
			$filter_ip = $this->request->get['filter_ip'];
		} else {
			$filter_ip = null;
		}
				
		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = null;
		}		
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name'; 
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
						
		$url = '';
		// start LMT
		if (isset($this->request->get['filter_gender'])) {
			$url .= '&filter_gender=' . $this->request->get['filter_gender'];
		}	

		if (isset($this->request->get['filter_id'])) {
			$url .= '&filter_id=' . $this->request->get['filter_id'];
		}

		if (isset($this->request->get['filter_field'])) {
			$url .= '&filter_field=' . $this->request->get['filter_field'];
		}	
		if (isset($this->request->get['filter_telephone'])) {
			$url .= '&filter_telephone=' . urlencode(html_entity_decode($this->request->get['filter_telephone'], ENT_QUOTES, 'UTF-8'));
		}	

		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}	
		if (isset($this->request->get['filter_date_of_birth'])) {
			$url .= '&filter_date_of_birth=' . $this->request->get['filter_date_of_birth'];
		}	
		if (isset($this->request->get['filter_university'])) {
			$url .= '&filter_university=' . $this->request->get['filter_university'];
		}
		if (isset($this->request->get['filter_faculty'])) {
			$url .= '&filter_faculty=' . $this->request->get['filter_faculty'];
		}
		if (isset($this->request->get['filter_floor_id'])) {
			$url .= '&filter_floor_id=' . $this->request->get['filter_floor_id'];
		}
		if (isset($this->request->get['filter_bed'])) {
			$url .= '&filter_bed=' . $this->request->get['filter_bed'];
		}
		if (isset($this->request->get['filter_ethnic'])) {
			$url .= '&filter_ethnic=' . urlencode(html_entity_decode($this->request->get['filter_ethnic'], ENT_QUOTES, 'UTF-8'));
		}
		if (isset($this->request->get['filter_address_1'])) {
			$url .= '&filter_address_1=' . $this->request->get['filter_address_1'];
		}
		
		// end LMT

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}
			
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
		
		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_approved'];
		}	
		
		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . $this->request->get['filter_ip'];
		}
					
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
						
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		if (isset($this->request->get['filter_period'])) {
			$url .= '&filter_period=' . $this->request->get['filter_period'];
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['select'] = $this->url->link('sale/customer_selection/select', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['unselect'] = $this->url->link('sale/customer_selection/unselect', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['insert'] = $this->url->link('sale/customer/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('sale/customer/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');


		$this->data['customers'] = array();

		$data = array(
            // start LMT
            'filter_university'              => $filter_university,
            'filter_faculty'              => $filter_faculty,
            'filter_floor_id'              => $filter_floor_id,
            'filter_date_of_birth' 		=> $filter_date_of_birth,

            'filter_bed'              => $filter_bed,
            'filter_ethnic'              => $filter_ethnic,
            'filter_address_1'              => $filter_address_1,

            'filter_id'            => $filter_id,
            'filter_field'            => $filter_field,
            'filter_telephone'            => $filter_telephone, 
            // end LMT
			'filter_name'              => $filter_name, 
			'filter_email'             => $filter_email, 
			'filter_customer_group_id' => $filter_customer_group_id, 
			'filter_status'            => $filter_status, 
			'filter_valid'            => $filter_valid, 
			'filter_resident'            => $filter_resident, 
			'filter_period'            => $filter_period, 
			'filter_student_status'          => 2, 
			'filter_date_added'        => $filter_date_added,
			'filter_ip'                => $filter_ip,
			'sort'                     => $sort,
			'order'                    => $order,
			'start'                    => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                    => $this->config->get('config_admin_limit')
		);
		
		$customer_total = $this->model_sale_customer->getTotalStudentsByData($data);
	
		$results = $this->model_sale_customer->getStudents($data);

		$this->data["periods"] = $this->model_sale_customer->getPeriods();
 
    	foreach ($results as $result) {
			$action = array();
		
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('sale/customer/update', 'token=' . $this->session->data['token'] . '&customer_id=' . $result['customer_id'] . $url, 'SSL')
			);
			
			// start LMT
			
			$this->load->model('catalog/category');
			$university = $this->model_catalog_category->getCategory($result['university']);
			$faculty = $this->model_catalog_category->getCategory($result['faculty']);
			$this->load->model('localisation/zone');
			$zone = $this->model_localisation_zone->getZone($result['id_location']);
			// $address = get address by id_location

			$this->data['customers'][] = array(
                 
				'customer_id'    => $result['customer_id'],
				'student_id'    => $result['student_id'],
				'name'           => $result['name'],
				'gender'          => ($result['gender'] ? $this->language->get('text_male') : $this->language->get('text_female')),
				'field'				=> $result['field'],
				'telephone'				=> $result['telephone'],
				'date_of_birth' 	=> date("d-m-Y", strtotime($result['date_of_birth'])),
				'university'          => $university['name'],
				'faculty'          => $faculty['name'],
				'floor'          => $result['floor_name'],
				'bed'          => $result['bed'],
				'ethnic'          => $result['ethnic'],
				'address_1'          => $zone['name'],
				'customer_group' => $result['customer_group'],
				'status'         => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'valid'       => ($result['student_valid'] ? $this->language->get('text_valid') : $this->language->get('text_not_valid')),
				'resident'       => ($result['resident'] ? $this->language->get('text_resident') : $this->language->get('text_not_resident')),

				
				'selected'       => isset($this->request->post['selected']) && in_array($result['customer_id'], $this->request->post['selected']),
				'action'         => $action
                 // end LMT           
				
			);
		}	
					
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');	
		$this->data['text_select'] = $this->language->get('text_select');	
		$this->data['text_default'] = $this->language->get('text_default');		
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_verify'] = $this->language->get('text_verify');

		$this->data['column_field'] = $this->language->get('column_field');
		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_email'] = $this->language->get('column_email');
		$this->data['column_customer_group'] = $this->language->get('column_customer_group');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_approved'] = $this->language->get('column_approved');
		$this->data['column_ip'] = $this->language->get('column_ip');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_login'] = $this->language->get('column_login');
		$this->data['column_action'] = $this->language->get('column_action');		
		
		$this->data['text_period'] = $this->language->get('text_period');
		$this->data['button_finish'] = $this->language->get('button_finish');
		$this->data['button_unselect'] = $this->language->get('button_unselect');
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_filter'] = $this->language->get('button_filter');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		$url = '';

		// start LMT
		if (isset($this->request->get['filter_gender'])) {
			$url .= '&filter_gender=' . $this->request->get['filter_gender'];
		}	

		if (isset($this->request->get['filter_telephone'])) {
			$url .= '&filter_telephone=' . $this->request->get['filter_telephone'];
		}	
		
		if (isset($this->request->get['filter_university'])) {
			$url .= '&filter_university=' . $this->request->get['filter_university'];
		}
		if (isset($this->request->get['filter_date_of_birth'])) {
			$url .= '&filter_date_of_birth=' . $this->request->get['filter_date_of_birth'];
		}	
		if (isset($this->request->get['filter_faculty'])) {
			$url .= '&filter_faculty=' . $this->request->get['filter_faculty'];
		}
		if (isset($this->request->get['filter_floor_id'])) {
			$url .= '&filter_floor_id=' . $this->request->get['filter_floor_id'];
		}
		if (isset($this->request->get['filter_bed'])) {
			$url .= '&filter_bed=' . $this->request->get['filter_bed'];
		}
		if (isset($this->request->get['filter_ethnic'])) {
			$url .= '&filter_ethnic=' . urlencode(html_entity_decode($this->request->get['filter_ethnic'], ENT_QUOTES, 'UTF-8'));
		}
		if (isset($this->request->get['filter_address_1'])) {
			$url .= '&filter_address_1=' . $this->request->get['filter_address_1'];
		}
		// end LMT
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}
			
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
		
		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_approved'];
		}	
		
		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . $this->request->get['filter_ip'];
		}
				
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
			
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		// start LMT
		$this->data['sort_field'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=field' . $url, 'SSL');
		$this->data['sort_student_id'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=student_id' . $url, 'SSL');
		$this->data['sort_date_of_birth'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=date_of_birth' . $url, 'SSL');
		$this->data['sort_gender'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=gender' . $url, 'SSL');
		$this->data['sort_telephone'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=telephone' . $url, 'SSL');
		$this->data['sort_university'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=university' . $url, 'SSL');
		$this->data['sort_faculty'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=faculty' . $url, 'SSL');	
		$this->data['sort_floor'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=floor' . $url, 'SSL');	
		$this->data['sort_bed'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=bed' . $url, 'SSL');	
		$this->data['sort_ethnic'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=ethnic' . $url, 'SSL');	
		$this->data['sort_address_1'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=id_location' . $url, 'SSL');	
		// end LMT

		$this->data['sort_name'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
		$this->data['sort_email'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=c.email' . $url, 'SSL');
		$this->data['sort_customer_group'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=customer_group' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=c.status' . $url, 'SSL');
		$this->data['sort_valid'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=c.valid' . $url, 'SSL');
		$this->data['sort_resident'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=c.resident' . $url, 'SSL');
		$this->data['sort_ip'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=c.ip' . $url, 'SSL');
		$this->data['sort_date_added'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=c.date_added' . $url, 'SSL');
		$this->data['report_amount'] = $this->url->link('sale/customer_selection/report_amount', 'token=' . $this->session->data['token'] . '&sort=c.date_added' . $url, 'SSL');
		$this->data['report_school'] = $this->url->link('sale/customer_selection/report_school', 'token=' . $this->session->data['token'] . '&sort=c.date_added' . $url, 'SSL');
		$this->data['report_area'] = $this->url->link('sale/customer_selection/report_area', 'token=' . $this->session->data['token'] . '&sort=c.date_added' . $url, 'SSL');

		$url = '';

		// start LMT
		if (isset($this->request->get['filter_gender'])) {
			$url .= '&filter_gender=' . $this->request->get['filter_gender'];
		}

		if (isset($this->request->get['filter_telephone'])) {
			$url .= '&filter_telephone=' . $this->request->get['filter_telephone'];
		}

		if (isset($this->request->get['filter_university'])) {
			$url .= '&filter_university=' . $this->request->get['filter_university'];
		}	
		if (isset($this->request->get['filter_date_of_birth'])) {
			$url .= '&filter_date_of_birth=' . $this->request->get['filter_date_of_birth'];
		}
		if (isset($this->request->get['filter_faculty'])) {
			$url .= '&filter_faculty=' . $this->request->get['filter_faculty'];
		}
		if (isset($this->request->get['filter_floor_id'])) {
			$url .= '&filter_floor_id=' . $this->request->get['filter_floor_id'];
		}
		if (isset($this->request->get['filter_bed'])) {
			$url .= '&filter_bed=' . $this->request->get['filter_bed'];
		}
		if (isset($this->request->get['filter_ethnic'])) {
			$url .= '&filter_ethnic=' . urlencode(html_entity_decode($this->request->get['filter_ethnic'], ENT_QUOTES, 'UTF-8'));
		}
		if (isset($this->request->get['filter_address_1'])) {
			$url .= '&filter_address_1=' . $this->request->get['filter_address_1'];
		}
		// end LMT

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
		
		if (isset($this->request->get['filter_valid'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_valid'];
		}
		
		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . $this->request->get['filter_ip'];
		}
				
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
			
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $customer_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();

		// start LMT
		$this->data['filter_university'] = $filter_university;
		$this->data['filter_id'] = $filter_id;
		$this->data['filter_field'] = $filter_field;
		$this->data['filter_gender'] = $filter_gender;
		$this->data['filter_telephone'] = $filter_telephone;
		$this->data['filter_date_of_birth'] = $filter_date_of_birth;
		$this->data['filter_faculty'] = $filter_faculty;
		$this->data['filter_floor_id'] = $filter_floor_id;
		$this->data['filter_customer_group_id'] = $filter_customer_group_id;
		$this->data['filter_bed'] = $filter_bed;
		$this->data['filter_ethnic'] = $filter_ethnic;
		$this->data['filter_address_1'] = $filter_address_1;
		// end LMT

		$this->data['filter_period'] = $filter_period;
		$this->data['filter_name'] = $filter_name;
		$this->data['filter_email'] = $filter_email;
		$this->data['filter_status'] = $filter_status;
		$this->data['filter_valid'] = $filter_valid;
		$this->data['filter_ip'] = $filter_ip;
		$this->data['filter_date_added'] = $filter_date_added;
		
		$this->load->model('sale/customer_group');
		
    	$this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups(0);

    	// start LMT 
		$this->load->model('localisation/zone');

		$id_vn = 230;
        $this->data['regions'] = $this->model_localisation_zone->getZonesByCountryId($id_vn);

        $this->data['fields'] = $this->model_sale_customer->getFields();
		// end LMT

		$this->load->model('setting/store');
		
		$this->data['stores'] = $this->model_setting_store->getStores();
				
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		
		$this->template = 'sale/customer_list_selection_report_amount.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
  	}


  	public function report_school() {
            
            $this->language->load('sale/customer_selection');
		 
			$this->document->setTitle($this->language->get('text_report_school'));
		
			$this->load->model('sale/customer');

			if (isset($this->request->get['filter_period'])) {
				$filter_period = $this->request->get['filter_period'];
			} else {
				$filter_period = null;
			}

  			if (isset($this->request->get['filter_id'])) {
				$filter_id = $this->request->get['filter_id'];
			} else {
				$filter_id = null;
			}

			if (isset($this->request->get['filter_field'])) {
				$filter_field = $this->request->get['filter_field'];
			} else {
				$filter_field = null;
			}
  		
            if (isset($this->request->get['filter_gender'])) {
				$filter_gender = $this->request->get['filter_gender'];
			} else {
				$filter_gender = null;
			}
			
			if (isset($this->request->get['filter_date_of_birth'])) {
				$filter_date_of_birth = $this->request->get['filter_date_of_birth'];
			} else {
				$filter_date_of_birth = null;
			}
			if (isset($this->request->get['filter_university'])) {
				$filter_university = $this->request->get['filter_university'];
			} else {
				$filter_university = null;
			}
			if (isset($this->request->get['filter_field'])) {
				$filter_field = $this->request->get['filter_field'];
			} else {
				$filter_field = null;
			}
			if (isset($this->request->get['filter_telephone'])) {
				$filter_telephone = $this->request->get['filter_telephone'];
			} else {
				$filter_telephone = null;
			}
			if (isset($this->request->get['filter_faculty'])) {
				$filter_faculty= $this->request->get['filter_faculty'];
			} else {
				$filter_faculty = null;
			}
			if (isset($this->request->get['filter_floor_id'])) {
				$filter_floor_id = $this->request->get['filter_floor_id'];
			} else {
				$filter_floor_id = null;
			}
            if (isset($this->request->get['filter_customer_group_id'])) {
				$filter_customer_group_id = $this->request->get['filter_customer_group_id'];
			} else {
				$filter_customer_group_id = null;
			}
			if (isset($this->request->get['filter_bed'])) {
				$filter_bed= $this->request->get['filter_bed'];
			} else {
				$filter_bed = null;
			}
			if (isset($this->request->get['filter_ethnic'])) {
				$filter_ethnic= $this->request->get['filter_ethnic'];
			} else {
				$filter_ethnic = null;
			}
			if (isset($this->request->get['filter_address_1'])) {
				$filter_address_1= $this->request->get['filter_address_1'];
			} else {
				$filter_address_1 = null;
			}

			$this->data['column_student_id'] = $this->language->get('column_student_id');
			$this->data['column_gender'] = $this->language->get('column_gender');
			$this->data['column_telephone'] = $this->language->get('column_telephone');
			$this->data['column_university'] = $this->language->get('column_university');
			$this->data['column_faculty'] = $this->language->get('column_faculty');
			$this->data['column_floor'] = $this->language->get('column_floor');
			$this->data['column_date_of_birth'] = $this->language->get('column_date_of_birth');
			$this->data['column_ethnic'] = $this->language->get('column_ethnic');
			$this->data['column_bed'] = $this->language->get('column_bed');
			$this->data['column_address_1'] = $this->language->get('column_address_1');

			$this->data['text_male'] = $this->language->get('text_male');
			$this->data['text_female'] = $this->language->get('text_female');

			$this->load->model('catalog/category');
			$universities = $this->model_catalog_category->getUniversityCategories();
			$this->data['universities'] = $universities;

			$NKUniversity = $this->model_catalog_category->NKUniversity();
			$this->data['NKUniversity'] = $NKUniversity;
			$this->data['text_finish'] = $this->language->get('text_finish');
			$this->data['text_unselect'] = $this->language->get('text_unselect');
			$this->data['text_none'] = $this->language->get('text_none');
			$this->data['text_not_valid'] = $this->language->get('text_not_valid');
			$this->data['text_valid'] = $this->language->get('text_valid');
			$this->data['text_resident'] = $this->language->get('text_resident');
			$this->data['text_not_resident'] = $this->language->get('text_not_resident');
			$this->data['text_report_field'] = $this->language->get('text_report_field');
			$this->data['text_unidentified_field'] = $this->language->get('text_unidentified_field');
			$this->data['text_report'] = $this->language->get('text_report');



			$genders = array(
					array('gender_id' => '1', 'gender_name' => $this->language->get('entry_male')),
					array('gender_id' => '0', 'gender_name' => $this->language->get('entry_female')),
					);
					
			$this->data['genders'] = $genders;

			$beds = array(
					array('bed_id' => '1', 'name' => $this->language->get('entry_bed_1')),
					array('bed_id' => '2', 'name' => $this->language->get('entry_bed_2')),
					array('bed_id' => '3', 'name' => $this->language->get('entry_bed_3')),
					array('bed_id' => '4', 'name' => $this->language->get('entry_bed_4')),
					array('bed_id' => '5', 'name' => $this->language->get('entry_bed_5')),
					array('bed_id' => '6', 'name' => $this->language->get('entry_bed_6')),
					array('bed_id' => '7', 'name' => $this->language->get('entry_bed_7')),
					array('bed_id' => '8', 'name' => $this->language->get('entry_bed_8')),
					);
					
			$this->data['beds'] = $beds;

            // end LMT
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}
		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = null;
		}
		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}
		
		if (isset($this->request->get['filter_valid'])) {
			$filter_valid = $this->request->get['filter_valid'];
		} else {
			$filter_valid = null;
		}

		if (isset($this->request->get['filter_resident'])) {
			$filter_resident = $this->request->get['filter_resident'];
		} else {
			$filter_resident = null;
		}
		
		if (isset($this->request->get['filter_ip'])) {
			$filter_ip = $this->request->get['filter_ip'];
		} else {
			$filter_ip = null;
		}
				
		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = null;
		}		
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name'; 
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
						
		$url = '';
		// start LMT
		if (isset($this->request->get['filter_gender'])) {
			$url .= '&filter_gender=' . $this->request->get['filter_gender'];
		}	

		if (isset($this->request->get['filter_id'])) {
			$url .= '&filter_id=' . $this->request->get['filter_id'];
		}

		if (isset($this->request->get['filter_field'])) {
			$url .= '&filter_field=' . $this->request->get['filter_field'];
		}	
		if (isset($this->request->get['filter_telephone'])) {
			$url .= '&filter_telephone=' . urlencode(html_entity_decode($this->request->get['filter_telephone'], ENT_QUOTES, 'UTF-8'));
		}	

		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}	
		if (isset($this->request->get['filter_date_of_birth'])) {
			$url .= '&filter_date_of_birth=' . $this->request->get['filter_date_of_birth'];
		}	
		if (isset($this->request->get['filter_university'])) {
			$url .= '&filter_university=' . $this->request->get['filter_university'];
		}
		if (isset($this->request->get['filter_faculty'])) {
			$url .= '&filter_faculty=' . $this->request->get['filter_faculty'];
		}
		if (isset($this->request->get['filter_floor_id'])) {
			$url .= '&filter_floor_id=' . $this->request->get['filter_floor_id'];
		}
		if (isset($this->request->get['filter_bed'])) {
			$url .= '&filter_bed=' . $this->request->get['filter_bed'];
		}
		if (isset($this->request->get['filter_ethnic'])) {
			$url .= '&filter_ethnic=' . urlencode(html_entity_decode($this->request->get['filter_ethnic'], ENT_QUOTES, 'UTF-8'));
		}
		if (isset($this->request->get['filter_address_1'])) {
			$url .= '&filter_address_1=' . $this->request->get['filter_address_1'];
		}
		
		// end LMT

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}
			
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
		
		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_approved'];
		}	
		
		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . $this->request->get['filter_ip'];
		}
					
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
						
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['filter_period'])) {
			$url .= '&filter_period=' . $this->request->get['filter_period'];
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['select'] = $this->url->link('sale/customer_selection/select', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['unselect'] = $this->url->link('sale/customer_selection/unselect', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['insert'] = $this->url->link('sale/customer/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('sale/customer/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');


		$this->data['customers'] = array();

		$data = array(
            // start LMT
            'filter_university'              => $filter_university,
            'filter_faculty'              => $filter_faculty,
            'filter_floor_id'              => $filter_floor_id,
            'filter_date_of_birth' 		=> $filter_date_of_birth,

            'filter_bed'              => $filter_bed,
            'filter_ethnic'              => $filter_ethnic,
            'filter_address_1'              => $filter_address_1,

            'filter_id'            => $filter_id,
            'filter_field'            => $filter_field,
            'filter_telephone'            => $filter_telephone, 
            // end LMT
			'filter_name'              => $filter_name, 
			'filter_email'             => $filter_email, 
			'filter_customer_group_id' => $filter_customer_group_id, 
			'filter_status'            => $filter_status, 
			'filter_valid'            => $filter_valid, 
			'filter_resident'            => $filter_resident, 
			'filter_period'            => $filter_period, 
			'filter_student_status'          => 2, 
			'filter_date_added'        => $filter_date_added,
			'filter_ip'                => $filter_ip,
			'sort'                     => $sort,
			'order'                    => $order,
			'start'                    => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                    => $this->config->get('config_admin_limit')
		);
		
		$customer_total = $this->model_sale_customer->getTotalStudentsByData($data);
	
		$results = $this->model_sale_customer->getStudents($data);

		$this->data["periods"] = $this->model_sale_customer->getPeriods();
 
    	foreach ($results as $result) {
			$action = array();
		
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('sale/customer/update', 'token=' . $this->session->data['token'] . '&customer_id=' . $result['customer_id'] . $url, 'SSL')
			);
			
			// start LMT
			
			$this->load->model('catalog/category');
			$university = $this->model_catalog_category->getCategory($result['university']);
			$faculty = $this->model_catalog_category->getCategory($result['faculty']);
			$this->load->model('localisation/zone');
			$zone = $this->model_localisation_zone->getZone($result['id_location']);
			// $address = get address by id_location

			$this->data['customers'][] = array(
                 
				'customer_id'    => $result['customer_id'],
				'student_id'    => $result['student_id'],
				'name'           => $result['name'],
				'gender'          => ($result['gender'] ? $this->language->get('text_male') : $this->language->get('text_female')),
				'field'				=> $result['field'],
				'telephone'				=> $result['telephone'],
				'date_of_birth' 	=> date("d-m-Y", strtotime($result['date_of_birth'])),
				'university'          => $university['name'],
				'faculty'          => $faculty['name'],
				'floor'          => $result['floor_name'],
				'bed'          => $result['bed'],
				'ethnic'          => $result['ethnic'],
				'address_1'          => $zone['name'],
				'customer_group' => $result['customer_group'],
				'status'         => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'valid'       => ($result['student_valid'] ? $this->language->get('text_valid') : $this->language->get('text_not_valid')),
				'resident'       => ($result['resident'] ? $this->language->get('text_resident') : $this->language->get('text_not_resident')),

				
				'selected'       => isset($this->request->post['selected']) && in_array($result['customer_id'], $this->request->post['selected']),
				'action'         => $action
                 // end LMT           
				
			);
		}	
					
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');	
		$this->data['text_select'] = $this->language->get('text_select');	
		$this->data['text_default'] = $this->language->get('text_default');		
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_verify'] = $this->language->get('text_verify');

		$this->data['column_field'] = $this->language->get('column_field');
		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_email'] = $this->language->get('column_email');
		$this->data['column_customer_group'] = $this->language->get('column_customer_group');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_approved'] = $this->language->get('column_approved');
		$this->data['column_ip'] = $this->language->get('column_ip');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_login'] = $this->language->get('column_login');
		$this->data['column_action'] = $this->language->get('column_action');		
		
		$this->data['text_period'] = $this->language->get('text_period');
		$this->data['button_finish'] = $this->language->get('button_finish');
		$this->data['button_unselect'] = $this->language->get('button_unselect');
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_filter'] = $this->language->get('button_filter');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		$url = '';

		// start LMT
		if (isset($this->request->get['filter_gender'])) {
			$url .= '&filter_gender=' . $this->request->get['filter_gender'];
		}	

		if (isset($this->request->get['filter_telephone'])) {
			$url .= '&filter_telephone=' . $this->request->get['filter_telephone'];
		}	
		
		if (isset($this->request->get['filter_university'])) {
			$url .= '&filter_university=' . $this->request->get['filter_university'];
		}
		if (isset($this->request->get['filter_date_of_birth'])) {
			$url .= '&filter_date_of_birth=' . $this->request->get['filter_date_of_birth'];
		}	
		if (isset($this->request->get['filter_faculty'])) {
			$url .= '&filter_faculty=' . $this->request->get['filter_faculty'];
		}
		if (isset($this->request->get['filter_floor_id'])) {
			$url .= '&filter_floor_id=' . $this->request->get['filter_floor_id'];
		}
		if (isset($this->request->get['filter_bed'])) {
			$url .= '&filter_bed=' . $this->request->get['filter_bed'];
		}
		if (isset($this->request->get['filter_ethnic'])) {
			$url .= '&filter_ethnic=' . urlencode(html_entity_decode($this->request->get['filter_ethnic'], ENT_QUOTES, 'UTF-8'));
		}
		if (isset($this->request->get['filter_address_1'])) {
			$url .= '&filter_address_1=' . $this->request->get['filter_address_1'];
		}
		// end LMT
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}
			
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
		
		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_approved'];
		}	
		
		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . $this->request->get['filter_ip'];
		}
				
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
			
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		// start LMT
		$this->data['sort_field'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=field' . $url, 'SSL');
		$this->data['sort_student_id'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=student_id' . $url, 'SSL');
		$this->data['sort_date_of_birth'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=date_of_birth' . $url, 'SSL');
		$this->data['sort_gender'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=gender' . $url, 'SSL');
		$this->data['sort_telephone'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=telephone' . $url, 'SSL');
		$this->data['sort_university'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=university' . $url, 'SSL');
		$this->data['sort_faculty'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=faculty' . $url, 'SSL');	
		$this->data['sort_floor'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=floor' . $url, 'SSL');	
		$this->data['sort_bed'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=bed' . $url, 'SSL');	
		$this->data['sort_ethnic'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=ethnic' . $url, 'SSL');	
		$this->data['sort_address_1'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=id_location' . $url, 'SSL');	
		// end LMT

		$this->data['sort_name'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
		$this->data['sort_email'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=c.email' . $url, 'SSL');
		$this->data['sort_customer_group'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=customer_group' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=c.status' . $url, 'SSL');
		$this->data['sort_valid'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=c.valid' . $url, 'SSL');
		$this->data['sort_resident'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=c.resident' . $url, 'SSL');
		$this->data['sort_ip'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=c.ip' . $url, 'SSL');
		$this->data['sort_date_added'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=c.date_added' . $url, 'SSL');
		$this->data['report_amount'] = $this->url->link('sale/customer_selection/report_amount', 'token=' . $this->session->data['token'] . '&sort=c.date_added' . $url, 'SSL');
		$this->data['report_school'] = $this->url->link('sale/customer_selection/report_school', 'token=' . $this->session->data['token'] . '&sort=c.date_added' . $url, 'SSL');
		$this->data['report_area'] = $this->url->link('sale/customer_selection/report_area', 'token=' . $this->session->data['token'] . '&sort=c.date_added' . $url, 'SSL');

		$url = '';

		// start LMT
		if (isset($this->request->get['filter_gender'])) {
			$url .= '&filter_gender=' . $this->request->get['filter_gender'];
		}

		if (isset($this->request->get['filter_telephone'])) {
			$url .= '&filter_telephone=' . $this->request->get['filter_telephone'];
		}

		if (isset($this->request->get['filter_university'])) {
			$url .= '&filter_university=' . $this->request->get['filter_university'];
		}	
		if (isset($this->request->get['filter_date_of_birth'])) {
			$url .= '&filter_date_of_birth=' . $this->request->get['filter_date_of_birth'];
		}
		if (isset($this->request->get['filter_faculty'])) {
			$url .= '&filter_faculty=' . $this->request->get['filter_faculty'];
		}
		if (isset($this->request->get['filter_floor_id'])) {
			$url .= '&filter_floor_id=' . $this->request->get['filter_floor_id'];
		}
		if (isset($this->request->get['filter_bed'])) {
			$url .= '&filter_bed=' . $this->request->get['filter_bed'];
		}
		if (isset($this->request->get['filter_ethnic'])) {
			$url .= '&filter_ethnic=' . urlencode(html_entity_decode($this->request->get['filter_ethnic'], ENT_QUOTES, 'UTF-8'));
		}
		if (isset($this->request->get['filter_address_1'])) {
			$url .= '&filter_address_1=' . $this->request->get['filter_address_1'];
		}
		// end LMT

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
		
		if (isset($this->request->get['filter_valid'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_valid'];
		}
		
		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . $this->request->get['filter_ip'];
		}
				
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
			
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $customer_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();

		// start LMT
		$this->data['filter_university'] = $filter_university;
		$this->data['filter_id'] = $filter_id;
		$this->data['filter_field'] = $filter_field;
		$this->data['filter_gender'] = $filter_gender;
		$this->data['filter_telephone'] = $filter_telephone;
		$this->data['filter_date_of_birth'] = $filter_date_of_birth;
		$this->data['filter_faculty'] = $filter_faculty;
		$this->data['filter_floor_id'] = $filter_floor_id;
		$this->data['filter_customer_group_id'] = $filter_customer_group_id;
		$this->data['filter_bed'] = $filter_bed;
		$this->data['filter_ethnic'] = $filter_ethnic;
		$this->data['filter_address_1'] = $filter_address_1;
		// end LMT

		$this->data['filter_period'] = $filter_period;
		$this->data['filter_name'] = $filter_name;
		$this->data['filter_email'] = $filter_email;
		$this->data['filter_status'] = $filter_status;
		$this->data['filter_valid'] = $filter_valid;
		$this->data['filter_ip'] = $filter_ip;
		$this->data['filter_date_added'] = $filter_date_added;
		
		$this->load->model('sale/customer_group');
		
    	$this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups(0);

    	// start LMT 
		$this->load->model('localisation/zone');

		$id_vn = 230;
        $this->data['regions'] = $this->model_localisation_zone->getZonesByCountryId($id_vn);

        $this->data['fields'] = $this->model_sale_customer->getFields();
		// end LMT

		$this->load->model('setting/store');
		
		$this->data['stores'] = $this->model_setting_store->getStores();
				
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		
		$this->template = 'sale/customer_list_selection_report_school.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
  	}

  	public function report_area() {
            
            $this->language->load('sale/customer_selection');
		 
			$this->document->setTitle($this->language->get('text_report_area'));
		
			$this->load->model('sale/customer');

			if (isset($this->request->get['filter_period'])) {
				$filter_period = $this->request->get['filter_period'];
			} else {
				$filter_period = null;
			}

  			if (isset($this->request->get['filter_id'])) {
				$filter_id = $this->request->get['filter_id'];
			} else {
				$filter_id = null;
			}

			if (isset($this->request->get['filter_field'])) {
				$filter_field = $this->request->get['filter_field'];
			} else {
				$filter_field = null;
			}
  		
            if (isset($this->request->get['filter_gender'])) {
				$filter_gender = $this->request->get['filter_gender'];
			} else {
				$filter_gender = null;
			}
			
			if (isset($this->request->get['filter_date_of_birth'])) {
				$filter_date_of_birth = $this->request->get['filter_date_of_birth'];
			} else {
				$filter_date_of_birth = null;
			}
			if (isset($this->request->get['filter_university'])) {
				$filter_university = $this->request->get['filter_university'];
			} else {
				$filter_university = null;
			}
			if (isset($this->request->get['filter_field'])) {
				$filter_field = $this->request->get['filter_field'];
			} else {
				$filter_field = null;
			}
			if (isset($this->request->get['filter_telephone'])) {
				$filter_telephone = $this->request->get['filter_telephone'];
			} else {
				$filter_telephone = null;
			}
			if (isset($this->request->get['filter_faculty'])) {
				$filter_faculty= $this->request->get['filter_faculty'];
			} else {
				$filter_faculty = null;
			}
			if (isset($this->request->get['filter_floor_id'])) {
				$filter_floor_id = $this->request->get['filter_floor_id'];
			} else {
				$filter_floor_id = null;
			}
            if (isset($this->request->get['filter_customer_group_id'])) {
				$filter_customer_group_id = $this->request->get['filter_customer_group_id'];
			} else {
				$filter_customer_group_id = null;
			}
			if (isset($this->request->get['filter_bed'])) {
				$filter_bed= $this->request->get['filter_bed'];
			} else {
				$filter_bed = null;
			}
			if (isset($this->request->get['filter_ethnic'])) {
				$filter_ethnic= $this->request->get['filter_ethnic'];
			} else {
				$filter_ethnic = null;
			}
			if (isset($this->request->get['filter_address_1'])) {
				$filter_address_1= $this->request->get['filter_address_1'];
			} else {
				$filter_address_1 = null;
			}

			$this->data['column_student_id'] = $this->language->get('column_student_id');
			$this->data['column_gender'] = $this->language->get('column_gender');
			$this->data['column_telephone'] = $this->language->get('column_telephone');
			$this->data['column_university'] = $this->language->get('column_university');
			$this->data['column_faculty'] = $this->language->get('column_faculty');
			$this->data['column_floor'] = $this->language->get('column_floor');
			$this->data['column_date_of_birth'] = $this->language->get('column_date_of_birth');
			$this->data['column_ethnic'] = $this->language->get('column_ethnic');
			$this->data['column_bed'] = $this->language->get('column_bed');
			$this->data['column_address_1'] = $this->language->get('column_address_1');

			$this->data['text_male'] = $this->language->get('text_male');
			$this->data['text_female'] = $this->language->get('text_female');

			$this->load->model('catalog/category');
			$universities = $this->model_catalog_category->getUniversityCategories();
			$this->data['universities'] = $universities;

			$NKUniversity = $this->model_catalog_category->NKUniversity();
			$this->data['NKUniversity'] = $NKUniversity;
			$this->data['text_finish'] = $this->language->get('text_finish');
			$this->data['text_unselect'] = $this->language->get('text_unselect');
			$this->data['text_none'] = $this->language->get('text_none');
			$this->data['text_not_valid'] = $this->language->get('text_not_valid');
			$this->data['text_valid'] = $this->language->get('text_valid');
			$this->data['text_resident'] = $this->language->get('text_resident');
			$this->data['text_not_resident'] = $this->language->get('text_not_resident');
			$this->data['text_report_field'] = $this->language->get('text_report_field');
			$this->data['text_unidentified_field'] = $this->language->get('text_unidentified_field');
			$this->data['text_report'] = $this->language->get('text_report');



			$genders = array(
					array('gender_id' => '1', 'gender_name' => $this->language->get('entry_male')),
					array('gender_id' => '0', 'gender_name' => $this->language->get('entry_female')),
					);
					
			$this->data['genders'] = $genders;

			$beds = array(
					array('bed_id' => '1', 'name' => $this->language->get('entry_bed_1')),
					array('bed_id' => '2', 'name' => $this->language->get('entry_bed_2')),
					array('bed_id' => '3', 'name' => $this->language->get('entry_bed_3')),
					array('bed_id' => '4', 'name' => $this->language->get('entry_bed_4')),
					array('bed_id' => '5', 'name' => $this->language->get('entry_bed_5')),
					array('bed_id' => '6', 'name' => $this->language->get('entry_bed_6')),
					array('bed_id' => '7', 'name' => $this->language->get('entry_bed_7')),
					array('bed_id' => '8', 'name' => $this->language->get('entry_bed_8')),
					);
					
			$this->data['beds'] = $beds;

            // end LMT
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}
		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = null;
		}
		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}
		
		if (isset($this->request->get['filter_valid'])) {
			$filter_valid = $this->request->get['filter_valid'];
		} else {
			$filter_valid = null;
		}

		if (isset($this->request->get['filter_resident'])) {
			$filter_resident = $this->request->get['filter_resident'];
		} else {
			$filter_resident = null;
		}
		
		if (isset($this->request->get['filter_ip'])) {
			$filter_ip = $this->request->get['filter_ip'];
		} else {
			$filter_ip = null;
		}
				
		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = null;
		}		
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name'; 
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
						
		$url = '';
		// start LMT
		if (isset($this->request->get['filter_gender'])) {
			$url .= '&filter_gender=' . $this->request->get['filter_gender'];
		}	

		if (isset($this->request->get['filter_id'])) {
			$url .= '&filter_id=' . $this->request->get['filter_id'];
		}

		if (isset($this->request->get['filter_field'])) {
			$url .= '&filter_field=' . $this->request->get['filter_field'];
		}	
		if (isset($this->request->get['filter_telephone'])) {
			$url .= '&filter_telephone=' . urlencode(html_entity_decode($this->request->get['filter_telephone'], ENT_QUOTES, 'UTF-8'));
		}	

		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}	
		if (isset($this->request->get['filter_date_of_birth'])) {
			$url .= '&filter_date_of_birth=' . $this->request->get['filter_date_of_birth'];
		}	
		if (isset($this->request->get['filter_university'])) {
			$url .= '&filter_university=' . $this->request->get['filter_university'];
		}
		if (isset($this->request->get['filter_faculty'])) {
			$url .= '&filter_faculty=' . $this->request->get['filter_faculty'];
		}
		if (isset($this->request->get['filter_floor_id'])) {
			$url .= '&filter_floor_id=' . $this->request->get['filter_floor_id'];
		}
		if (isset($this->request->get['filter_bed'])) {
			$url .= '&filter_bed=' . $this->request->get['filter_bed'];
		}
		if (isset($this->request->get['filter_ethnic'])) {
			$url .= '&filter_ethnic=' . urlencode(html_entity_decode($this->request->get['filter_ethnic'], ENT_QUOTES, 'UTF-8'));
		}
		if (isset($this->request->get['filter_address_1'])) {
			$url .= '&filter_address_1=' . $this->request->get['filter_address_1'];
		}
		
		// end LMT

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}
			
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
		
		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_approved'];
		}	
		
		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . $this->request->get['filter_ip'];
		}
					
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
						
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		if (isset($this->request->get['filter_period'])) {
			$url .= '&filter_period=' . $this->request->get['filter_period'];
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['select'] = $this->url->link('sale/customer_selection/select', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['unselect'] = $this->url->link('sale/customer_selection/unselect', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['insert'] = $this->url->link('sale/customer/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('sale/customer/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');


		$this->data['customers'] = array();

		$data = array(
            // start LMT
            'filter_university'              => $filter_university,
            'filter_faculty'              => $filter_faculty,
            'filter_floor_id'              => $filter_floor_id,
            'filter_date_of_birth' 		=> $filter_date_of_birth,

            'filter_bed'              => $filter_bed,
            'filter_ethnic'              => $filter_ethnic,
            'filter_address_1'              => $filter_address_1,

            'filter_id'            => $filter_id,
            'filter_field'            => $filter_field,
            'filter_telephone'            => $filter_telephone, 
            // end LMT
			'filter_name'              => $filter_name, 
			'filter_email'             => $filter_email, 
			'filter_customer_group_id' => $filter_customer_group_id, 
			'filter_status'            => $filter_status, 
			'filter_valid'            => $filter_valid, 
			'filter_resident'            => $filter_resident, 
			'filter_period'            => $filter_period, 
			'filter_student_status'          => 2,
			'filter_date_added'        => $filter_date_added,
			'filter_ip'                => $filter_ip,
			'sort'                     => $sort,
			'order'                    => $order,
			'start'                    => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                    => $this->config->get('config_admin_limit')
		);
		
		$customer_total = $this->model_sale_customer->getTotalStudentsByData($data);
	
		$results = $this->model_sale_customer->getStudents($data);

		$this->data["periods"] = $this->model_sale_customer->getPeriods();
 
    	foreach ($results as $result) {
			$action = array();
		
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('sale/customer/update', 'token=' . $this->session->data['token'] . '&customer_id=' . $result['customer_id'] . $url, 'SSL')
			);
			
			// start LMT
			
			$this->load->model('catalog/category');
			$university = $this->model_catalog_category->getCategory($result['university']);
			$faculty = $this->model_catalog_category->getCategory($result['faculty']);
			$this->load->model('localisation/zone');
			$zone = $this->model_localisation_zone->getZone($result['id_location']);
			// $address = get address by id_location

			$this->data['customers'][] = array(
                 
				'customer_id'    => $result['customer_id'],
				'student_id'    => $result['student_id'],
				'name'           => $result['name'],
				'gender'          => ($result['gender'] ? $this->language->get('text_male') : $this->language->get('text_female')),
				'field'				=> $result['field'],
				'telephone'				=> $result['telephone'],
				'date_of_birth' 	=> date("d-m-Y", strtotime($result['date_of_birth'])),
				'university'          => $university['name'],
				'faculty'          => $faculty['name'],
				'floor'          => $result['floor_name'],
				'bed'          => $result['bed'],
				'ethnic'          => $result['ethnic'],
				'address_1'          => $zone['name'],
				'customer_group' => $result['customer_group'],
				'status'         => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'valid'       => ($result['student_valid'] ? $this->language->get('text_valid') : $this->language->get('text_not_valid')),
				'resident'       => ($result['resident'] ? $this->language->get('text_resident') : $this->language->get('text_not_resident')),

				
				'selected'       => isset($this->request->post['selected']) && in_array($result['customer_id'], $this->request->post['selected']),
				'action'         => $action
                 // end LMT           
				
			);
		}	
					
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');	
		$this->data['text_select'] = $this->language->get('text_select');	
		$this->data['text_default'] = $this->language->get('text_default');		
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_verify'] = $this->language->get('text_verify');

		$this->data['column_field'] = $this->language->get('column_field');
		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_email'] = $this->language->get('column_email');
		$this->data['column_customer_group'] = $this->language->get('column_customer_group');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_approved'] = $this->language->get('column_approved');
		$this->data['column_ip'] = $this->language->get('column_ip');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_login'] = $this->language->get('column_login');
		$this->data['column_action'] = $this->language->get('column_action');		

		$this->data['text_period'] = $this->language->get('text_period');
		$this->data['button_finish'] = $this->language->get('button_finish');
		$this->data['button_unselect'] = $this->language->get('button_unselect');
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_filter'] = $this->language->get('button_filter');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		$url = '';

		// start LMT
		if (isset($this->request->get['filter_gender'])) {
			$url .= '&filter_gender=' . $this->request->get['filter_gender'];
		}	

		if (isset($this->request->get['filter_telephone'])) {
			$url .= '&filter_telephone=' . $this->request->get['filter_telephone'];
		}	
		
		if (isset($this->request->get['filter_university'])) {
			$url .= '&filter_university=' . $this->request->get['filter_university'];
		}
		if (isset($this->request->get['filter_date_of_birth'])) {
			$url .= '&filter_date_of_birth=' . $this->request->get['filter_date_of_birth'];
		}	
		if (isset($this->request->get['filter_faculty'])) {
			$url .= '&filter_faculty=' . $this->request->get['filter_faculty'];
		}
		if (isset($this->request->get['filter_floor_id'])) {
			$url .= '&filter_floor_id=' . $this->request->get['filter_floor_id'];
		}
		if (isset($this->request->get['filter_bed'])) {
			$url .= '&filter_bed=' . $this->request->get['filter_bed'];
		}
		if (isset($this->request->get['filter_ethnic'])) {
			$url .= '&filter_ethnic=' . urlencode(html_entity_decode($this->request->get['filter_ethnic'], ENT_QUOTES, 'UTF-8'));
		}
		if (isset($this->request->get['filter_address_1'])) {
			$url .= '&filter_address_1=' . $this->request->get['filter_address_1'];
		}
		// end LMT
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}
			
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
		
		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_approved'];
		}	
		
		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . $this->request->get['filter_ip'];
		}
				
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
			
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		// start LMT
		$this->data['sort_field'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=field' . $url, 'SSL');
		$this->data['sort_student_id'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=student_id' . $url, 'SSL');
		$this->data['sort_date_of_birth'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=date_of_birth' . $url, 'SSL');
		$this->data['sort_gender'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=gender' . $url, 'SSL');
		$this->data['sort_telephone'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=telephone' . $url, 'SSL');
		$this->data['sort_university'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=university' . $url, 'SSL');
		$this->data['sort_faculty'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=faculty' . $url, 'SSL');	
		$this->data['sort_floor'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=floor' . $url, 'SSL');	
		$this->data['sort_bed'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=bed' . $url, 'SSL');	
		$this->data['sort_ethnic'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=ethnic' . $url, 'SSL');	
		$this->data['sort_address_1'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=id_location' . $url, 'SSL');	
		// end LMT

		$this->data['sort_name'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
		$this->data['sort_email'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=c.email' . $url, 'SSL');
		$this->data['sort_customer_group'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=customer_group' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=c.status' . $url, 'SSL');
		$this->data['sort_valid'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=c.valid' . $url, 'SSL');
		$this->data['sort_resident'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=c.resident' . $url, 'SSL');
		$this->data['sort_ip'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=c.ip' . $url, 'SSL');
		$this->data['sort_date_added'] = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . '&sort=c.date_added' . $url, 'SSL');
		$this->data['report_amount'] = $this->url->link('sale/customer_selection/report_amount', 'token=' . $this->session->data['token'] . '&sort=c.date_added' . $url, 'SSL');
		$this->data['report_school'] = $this->url->link('sale/customer_selection/report_school', 'token=' . $this->session->data['token'] . '&sort=c.date_added' . $url, 'SSL');
		$this->data['report_area'] = $this->url->link('sale/customer_selection/report_area', 'token=' . $this->session->data['token'] . '&sort=c.date_added' . $url, 'SSL');

		$url = '';

		// start LMT
		if (isset($this->request->get['filter_gender'])) {
			$url .= '&filter_gender=' . $this->request->get['filter_gender'];
		}

		if (isset($this->request->get['filter_telephone'])) {
			$url .= '&filter_telephone=' . $this->request->get['filter_telephone'];
		}

		if (isset($this->request->get['filter_university'])) {
			$url .= '&filter_university=' . $this->request->get['filter_university'];
		}	
		if (isset($this->request->get['filter_date_of_birth'])) {
			$url .= '&filter_date_of_birth=' . $this->request->get['filter_date_of_birth'];
		}
		if (isset($this->request->get['filter_faculty'])) {
			$url .= '&filter_faculty=' . $this->request->get['filter_faculty'];
		}
		if (isset($this->request->get['filter_floor_id'])) {
			$url .= '&filter_floor_id=' . $this->request->get['filter_floor_id'];
		}
		if (isset($this->request->get['filter_bed'])) {
			$url .= '&filter_bed=' . $this->request->get['filter_bed'];
		}
		if (isset($this->request->get['filter_ethnic'])) {
			$url .= '&filter_ethnic=' . urlencode(html_entity_decode($this->request->get['filter_ethnic'], ENT_QUOTES, 'UTF-8'));
		}
		if (isset($this->request->get['filter_address_1'])) {
			$url .= '&filter_address_1=' . $this->request->get['filter_address_1'];
		}
		// end LMT

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
		
		if (isset($this->request->get['filter_valid'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_valid'];
		}
		
		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . $this->request->get['filter_ip'];
		}
				
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
			
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $customer_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('sale/customer_selection', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();

		// start LMT
		$this->data['filter_university'] = $filter_university;
		$this->data['filter_id'] = $filter_id;
		$this->data['filter_field'] = $filter_field;
		$this->data['filter_gender'] = $filter_gender;
		$this->data['filter_telephone'] = $filter_telephone;
		$this->data['filter_date_of_birth'] = $filter_date_of_birth;
		$this->data['filter_faculty'] = $filter_faculty;
		$this->data['filter_floor_id'] = $filter_floor_id;
		$this->data['filter_customer_group_id'] = $filter_customer_group_id;
		$this->data['filter_bed'] = $filter_bed;
		$this->data['filter_ethnic'] = $filter_ethnic;
		$this->data['filter_address_1'] = $filter_address_1;
		// end LMT

		$this->data['filter_period'] = $filter_period;
		$this->data['filter_name'] = $filter_name;
		$this->data['filter_email'] = $filter_email;
		$this->data['filter_status'] = $filter_status;
		$this->data['filter_valid'] = $filter_valid;
		$this->data['filter_ip'] = $filter_ip;
		$this->data['filter_date_added'] = $filter_date_added;
		
		$this->load->model('sale/customer_group');
		
    	$this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups(0);

    	// start LMT 
		$this->load->model('localisation/zone');

		$id_vn = 230;
        $this->data['regions'] = $this->model_localisation_zone->getZonesByCountryId($id_vn);

        $this->data['fields'] = $this->model_sale_customer->getFields();
		// end LMT

		$this->load->model('setting/store');
		
		$this->data['stores'] = $this->model_setting_store->getStores();
				
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		
		$this->template = 'sale/customer_list_selection_report_area.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
  	}
  /////////////////////// Modification//////////////////////
  // ID: 1051015        
  // Name: Luu Minh Tan           
  // Class: 10CTT
  // Date created: 22/12/2013
  // Description: Change get form function
  // Date modified: 2/1/2014
  ////////////////////////////////////////////////////////////// 
  	protected function getForm() {
		// start LMT
		$this->data['entry_university'] = $this->language->get('entry_university');
		$this->data['entry_faculty'] = $this->language->get('entry_faculty');
		$this->data['entry_student_id'] = $this->language->get('entry_student_id');
		$this->data['error_university'] = $this->language->get('error_university');
		$this->data['error_faculty'] = $this->language->get('error_faculty');
		$this->data['error_student_id'] = $this->language->get('error_student_id');
		
		$this->data['entry_idnum'] = $this->language->get('entry_idnum');
		$this->data['entry_iddate'] = $this->language->get('entry_iddate');
		$this->data['entry_idlocation'] = $this->language->get('entry_idlocation');
		$this->data['text_id'] = $this->language->get('text_id');
		$this->data['entry_gender'] = $this->language->get('entry_gender');

		$this->data['entry_floor'] = $this->language->get('entry_floor');
		$this->data['text_status'] = $this->language->get('text_status');
		$this->data['text_approve'] = $this->language->get('text_approve');
		$this->data['text_not_approve'] = $this->language->get('text_not_approve');
		$this->data['text_receive'] = $this->language->get('text_receive');
		$this->data['text_not_receive'] = $this->language->get('text_not_receive');

		$this->load->model('catalog/category');
		$universities = $this->model_catalog_category->getUniversityCategories();
		$this->data['universities'] = $universities;

		$NKUniversity = $this->model_catalog_category->NKUniversity();
		$this->data['NKUniversity'] = $NKUniversity;

		$this->load->model('sale/customer');
        $this->data['floors'] = $this->model_sale_customer->getAllFloors();
		
		$genders = array(
					array('gender_id' => '1', 'gender_name' => $this->language->get('entry_male')),
					array('gender_id' => '0', 'gender_name' => $this->language->get('entry_female')),
					);
					
		$this->data['genders'] = $genders;
		// start LMT
		$beds = array(
					array('bed_id' => '1', 'name' => $this->language->get('entry_bed_1')),
					array('bed_id' => '2', 'name' => $this->language->get('entry_bed_2')),
					array('bed_id' => '3', 'name' => $this->language->get('entry_bed_3')),
					array('bed_id' => '4', 'name' => $this->language->get('entry_bed_4')),
					array('bed_id' => '5', 'name' => $this->language->get('entry_bed_5')),
					array('bed_id' => '6', 'name' => $this->language->get('entry_bed_6')),
					array('bed_id' => '7', 'name' => $this->language->get('entry_bed_7')),
					array('bed_id' => '8', 'name' => $this->language->get('entry_bed_8')),
					);
					
			$this->data['beds'] = $beds;

		$this->data['error_bed'] = $this->language->get('error_bed');

		// end LMT
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
		if (isset($this->error['idnum'])) {
			$this->data['error_idnum'] = $this->error['idnum'];
		} else {
			$this->data['error_idnum'] = '';
		}
		if (isset($this->error['iddate'])) {
			$this->data['error_iddate'] = $this->error['iddate'];
		} else {
			$this->data['error_iddate'] = '';
		}

		// start LMT
		if (isset($this->error['date_of_birth'])) {
			$this->data['error_date_of_birth'] = $this->error['date_of_birth'];
		} else {
			$this->data['error_date_of_birth'] = '';
		}
		if (isset($this->error['bed'])) {
			$this->data['error_bed'] = $this->error['bed'];
		} else {
			$this->data['error_bed'] = '';
		}

		// end LMT

		if (isset($this->error['id_location'])) {
			$this->data['error_id_location'] = $this->error['id_location'];
		} else {
			$this->data['error_id_location'] = '';
		}
		if (isset($this->error['university'])) {
			$this->data['error_university'] = $this->error['university'];
		} else {
			$this->data['error_university'] = '';
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

		// end LMT
		
    	$this->data['heading_title'] = $this->language->get('heading_title');
 
    	// start LMT 
    	$this->data['text_basic_info'] = $this->language->get('text_basic_info');
    	$this->data['text_contact'] = $this->language->get('text_contact');
    	$this->data['text_identity'] = $this->language->get('text_identity');
    	$this->data['text_university'] = $this->language->get('text_university');
    	$this->data['text_password'] = $this->language->get('text_password');
    	$this->data['text_campus'] = $this->language->get('text_campus');

    	$this->data['entry_date_of_birth'] = $this->language->get('entry_date_of_birth');
    	$this->data['entry_bed'] = $this->language->get('entry_bed');
    	// end LMT

    	$this->data['text_enabled'] = $this->language->get('text_enabled');
    	$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['text_none'] = $this->language->get('text_none');
    	$this->data['text_wait'] = $this->language->get('text_wait');
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_add_ban_ip'] = $this->language->get('text_add_ban_ip');
		$this->data['text_remove_ban_ip'] = $this->language->get('text_remove_ban_ip');
		
		$this->data['column_ip'] = $this->language->get('column_ip');
		$this->data['column_total'] = $this->language->get('column_total');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_action'] = $this->language->get('column_action');
		
    	$this->data['entry_firstname'] = $this->language->get('entry_firstname');
    	$this->data['entry_lastname'] = $this->language->get('entry_lastname');
    	$this->data['entry_email'] = $this->language->get('entry_email');
    	$this->data['entry_telephone'] = $this->language->get('entry_telephone');
    	$this->data['entry_fax'] = $this->language->get('entry_fax');
    	$this->data['entry_password'] = $this->language->get('entry_password');
    	$this->data['entry_confirm'] = $this->language->get('entry_confirm');
		$this->data['entry_newsletter'] = $this->language->get('entry_newsletter');
    	$this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_company'] = $this->language->get('entry_company');
		$this->data['entry_company_id'] = $this->language->get('entry_company_id');
		$this->data['entry_tax_id'] = $this->language->get('entry_tax_id');
		$this->data['entry_address_1'] = $this->language->get('entry_address_1');
		$this->data['entry_address_2'] = $this->language->get('entry_address_2');
		$this->data['entry_city'] = $this->language->get('entry_city');
		$this->data['entry_postcode'] = $this->language->get('entry_postcode');
		$this->data['entry_zone'] = $this->language->get('entry_zone');
		$this->data['entry_country'] = $this->language->get('entry_country');
		$this->data['entry_default'] = $this->language->get('entry_default');
		$this->data['entry_comment'] = $this->language->get('entry_comment');
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_amount'] = $this->language->get('entry_amount');
		$this->data['entry_points'] = $this->language->get('entry_points');
 
		$this->data['button_save'] = $this->language->get('button_save');
    	$this->data['button_cancel'] = $this->language->get('button_cancel');
    	$this->data['button_add_address'] = $this->language->get('button_add_address');
		$this->data['button_add_history'] = $this->language->get('button_add_history');
		$this->data['button_add_transaction'] = $this->language->get('button_add_transaction');
		$this->data['button_add_reward'] = $this->language->get('button_add_reward');
    	$this->data['button_remove'] = $this->language->get('button_remove');
	
		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['tab_address'] = $this->language->get('tab_address');
		$this->data['tab_history'] = $this->language->get('tab_history');
		$this->data['tab_transaction'] = $this->language->get('tab_transaction');
		$this->data['tab_reward'] = $this->language->get('tab_reward');
		$this->data['tab_ip'] = $this->language->get('tab_ip');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->get['customer_id'])) {
			$this->data['customer_id'] = $this->request->get['customer_id'];
		} else {
			$this->data['customer_id'] = 0;
		}

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['firstname'])) {
			$this->data['error_firstname'] = $this->error['firstname'];
		} else {
			$this->data['error_firstname'] = '';
		}

 		if (isset($this->error['lastname'])) {
			$this->data['error_lastname'] = $this->error['lastname'];
		} else {
			$this->data['error_lastname'] = '';
		}
		
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
		
		if (isset($this->error['address_firstname'])) {
			$this->data['error_address_firstname'] = $this->error['address_firstname'];
		} else {
			$this->data['error_address_firstname'] = '';
		}

 		if (isset($this->error['address_lastname'])) {
			$this->data['error_address_lastname'] = $this->error['address_lastname'];
		} else {
			$this->data['error_address_lastname'] = '';
		}
		
  		if (isset($this->error['address_tax_id'])) {
			$this->data['error_address_tax_id'] = $this->error['address_tax_id'];
		} else {
			$this->data['error_address_tax_id'] = '';
		}
				
		if (isset($this->error['address_address_1'])) {
			$this->data['error_address_address_1'] = $this->error['address_address_1'];
		} else {
			$this->data['error_address_address_1'] = '';
		}
		
		if (isset($this->error['address_city'])) {
			$this->data['error_address_city'] = $this->error['address_city'];
		} else {
			$this->data['error_address_city'] = '';
		}
		
		if (isset($this->error['address_postcode'])) {
			$this->data['error_address_postcode'] = $this->error['address_postcode'];
		} else {
			$this->data['error_address_postcode'] = '';
		}
		
		if (isset($this->error['address_country'])) {
			$this->data['error_address_country'] = $this->error['address_country'];
		} else {
			$this->data['error_address_country'] = '';
		}
		
		if (isset($this->error['address_zone'])) {
			$this->data['error_address_zone'] = $this->error['address_zone'];
		} else {
			$this->data['error_address_zone'] = '';
		}
		
		$url = '';
		
		// start LMT
		if (isset($this->request->get['filter_bed'])) {
			$url .= '&filter_bed=' . $this->request->get['filter_bed'];
		}
		if (isset($this->request->get['student_id'])) {
			$url .= '&student_id=' . $this->request->get['student_id'];
		}
		if (isset($this->request->get['filter_floor_id'])) {
			$url .= '&filter_floor_id=' . $this->request->get['filter_floor_id'];
		}
		// end LMT

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
		
		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_approved'];
		}	
		
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
						
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('sale/customer', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);

		if (!isset($this->request->get['customer_id'])) {
			$this->data['action'] = $this->url->link('sale/customer/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('sale/customer/update', 'token=' . $this->session->data['token'] . '&customer_id=' . $this->request->get['customer_id'] . $url, 'SSL');
		}
		  
    	$this->data['cancel'] = $this->url->link('sale/customer', 'token=' . $this->session->data['token'] . $url, 'SSL');

    	if (isset($this->request->get['customer_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$customer_info = $this->model_sale_customer->getCustomer($this->request->get['customer_id']);
    	}
		
		//start LMT
		if (isset($this->request->post['idnum'])) {
      		$this->data['idnum'] = $this->request->post['idnum'];
		} elseif (!empty($customer_info)) { 
			$this->data['idnum'] = $customer_info['id_num'];
		} else {
      		$this->data['idnum'] = '';
    	}
		if (isset($this->request->post['iddate'])) {
      		$this->data['iddate'] = $this->request->post['iddate'];
		} elseif (!empty($customer_info)) { 
			$this->data['iddate'] = date('d-m-Y',strtotime($customer_info['id_date']));
		} else {
      		$this->data['iddate'] = '';
    	}
    	 
		if (isset($this->request->post['date_of_birth'])) {
      		$this->data['date_of_birth'] = $this->request->post['date_of_birth'];
		} elseif (!empty($customer_info)) { 
			$this->data['date_of_birth'] = date('d-m-Y',strtotime($customer_info['date_of_birth']));
		} else {
      		$this->data['date_of_birth'] = '';
    	}
    	

		if (isset($this->request->post['id_location'])) {
      		$this->data['id_location'] = $this->request->post['id_location'];
		} elseif (!empty($customer_info)) { 
			$this->data['id_location'] = $customer_info['id_location'];
		} else {
      		$this->data['id_location'] = '';
    	}
		if (isset($this->request->post['university_id'])) {
      		$this->data['university_id'] = $this->request->post['university_id'];
		} elseif (!empty($customer_info)) { 
			$this->data['university_id'] = $customer_info['university'];
		} else {
      		$this->data['university_id'] = '';
    	}
		if (isset($this->request->post['faculty_id'])) {
      		$this->data['faculty_id'] = $this->request->post['faculty_id'];
		} elseif (!empty($customer_info)) { 
			$this->data['faculty_id'] = $customer_info['faculty'];
		} else {
      		$this->data['faculty_id'] = '';
    	}
    	if (isset($this->request->post['floor_id'])) {
      		$this->data['floor_id'] = $this->request->post['floor_id'];
		} elseif (!empty($customer_info)) { 
			$this->data['floor_id'] = $customer_info['floor_id'];
		} else {
      		$this->data['floor_id'] = '';
    	}
		if (isset($this->request->post['student_id'])) {
      		$this->data['student_id'] = $this->request->post['student_id'];
		} elseif (!empty($customer_info)) { 
			$this->data['student_id'] = $customer_info['student_id'];
		} else {
      		$this->data['student_id'] = '';
    	}
		if (isset($this->request->post['gender_id'])) {
      		$this->data['gender_id'] = $this->request->post['gender_id'];
		} elseif (!empty($customer_info)) { 
			$this->data['gender_id'] = $customer_info['gender'];
		} else {
      		$this->data['gender_id'] = '';
    	}
    	if (isset($this->request->post['bed_id'])) {
      		$this->data['bed_id'] = $this->request->post['bed_id'];
		} elseif (!empty($customer_info)) { 
			$this->data['bed_id'] = $customer_info['bed'];
		} else {
      		$this->data['bed_id'] = '';
    	}
		
		//end LMT
    	if (isset($this->request->post['firstname'])) {
      		$this->data['firstname'] = $this->request->post['firstname'];
		} elseif (!empty($customer_info)) { 
			$this->data['firstname'] = $customer_info['firstname'];
		} else {
      		$this->data['firstname'] = '';
    	}

    	if (isset($this->request->post['lastname'])) {
      		$this->data['lastname'] = $this->request->post['lastname'];
    	} elseif (!empty($customer_info)) { 
			$this->data['lastname'] = $customer_info['lastname'];
		} else {
      		$this->data['lastname'] = '';
    	}

    	if (isset($this->request->post['email'])) {
      		$this->data['email'] = $this->request->post['email'];
    	} elseif (!empty($customer_info)) { 
			$this->data['email'] = $customer_info['email'];
		} else {
      		$this->data['email'] = '';
    	}

    	if (isset($this->request->post['telephone'])) {
      		$this->data['telephone'] = $this->request->post['telephone'];
    	} elseif (!empty($customer_info)) { 
			$this->data['telephone'] = $customer_info['telephone'];
		} else {
      		$this->data['telephone'] = '';
    	}

    	if (isset($this->request->post['fax'])) {
      		$this->data['fax'] = $this->request->post['fax'];
    	} elseif (!empty($customer_info)) { 
			$this->data['fax'] = $customer_info['fax'];
		} else {
      		$this->data['fax'] = '';
    	}

    	if (isset($this->request->post['newsletter'])) {
      		$this->data['newsletter'] = $this->request->post['newsletter'];
    	} elseif (!empty($customer_info)) { 
			$this->data['newsletter'] = $customer_info['newsletter'];
		} else {
      		$this->data['newsletter'] = '';
    	}
		
		$this->load->model('sale/customer_group');
			
		$this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups(0);

		// start LMT 
		$this->load->model('localisation/zone');

		$id_vn = 230;
        $this->data['regions'] = $this->model_localisation_zone->getZonesByCountryId($id_vn);
		// end LMT

    	if (isset($this->request->post['customer_group_id'])) {
      		$this->data['customer_group_id'] = $this->request->post['customer_group_id'];
    	} elseif (!empty($customer_info)) { 
			$this->data['customer_group_id'] = $customer_info['customer_group_id'];
		} else {
      		$this->data['customer_group_id'] = $this->config->get('config_customer_group_id');
    	}
		
    	if (isset($this->request->post['status'])) {
      		$this->data['status'] = $this->request->post['status'];
    	} elseif (!empty($customer_info)) { 
			$this->data['status'] = $customer_info['status'];
		} else {
      		$this->data['status'] = 1;
    	}

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
		
		$this->load->model('localisation/country');

		
		$this->data['countries'] = $this->model_localisation_country->getCountries();
			
		if (isset($this->request->post['address'])) { 
      		$this->data['addresses'] = $this->request->post['address'];
		} elseif (isset($this->request->get['customer_id'])) {
			$this->data['addresses'] = $this->model_sale_customer->getAddresses($this->request->get['customer_id']);
		} else {
			$this->data['addresses'] = array();
    	}

    	if (isset($this->request->post['address_id'])) {
      		$this->data['address_id'] = $this->request->post['address_id'];
    	} elseif (!empty($customer_info)) { 
			$this->data['address_id'] = $customer_info['address_id'];
		} else {
      		$this->data['address_id'] = '';
    	}
		
		$this->data['ips'] = array();
    	
		if (!empty($customer_info)) {
			$results = $this->model_sale_customer->getIpsByCustomerId($this->request->get['customer_id']);
		
			foreach ($results as $result) {
				$ban_ip_total = $this->model_sale_customer->getTotalBanIpsByIp($result['ip']);
				
				$this->data['ips'][] = array(
					'ip'         => $result['ip'],
					'total'      => $this->model_sale_customer->getTotalCustomersByIp($result['ip']),
					'date_added' => date('d/m/y', strtotime($result['date_added'])),
					'filter_ip'  => $this->url->link('sale/customer', 'token=' . $this->session->data['token'] . '&filter_ip=' . $result['ip'], 'SSL'),
					'ban_ip'     => $ban_ip_total
				);
			}
		}		
		
		$this->template = 'sale/customer_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
			
	/////////////////////// Modification//////////////////////
	  // ID: 1051015        
	  // Name: Luu Minh Tan           
	  // Class: 10CTT
	  // Date created: 22/12/2013
	  // Description: Change validate form function
	  // Date modified: 2/1/2014
	  //////////////////////////////////////////////////////////////  
  	protected function validateForm() {
    	if (!$this->user->hasPermission('modify', 'sale/customer')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}

		// start LMT
		if ((utf8_strlen($this->request->post['idnum']) != 9)) {
      		$this->error['idnum'] = $this->language->get('error_idnum');
    	}
		if ((utf8_strlen($this->request->post['university_id']) == '')) {
      		$this->error['university'] = $this->language->get('error_university');
    	}
		if ((utf8_strlen($this->request->post['faculty_id']) == '')) {
      		$this->error['faculty'] = $this->language->get('error_faculty');
    	}
		if ((utf8_strlen($this->request->post['student_id'])) == ''|| !$this->checkStudentID($this->request->post['student_id'])) {
      		$this->error['student_id'] = $this->language->get('error_student_id');
    	}
		if (!$this->checkdateDDMMYYYY($this->request->post['iddate'])) {
      		$this->error['iddate'] = $this->language->get('error_iddate');
    	}
		if ($this->request->post['gender_id'] == '') {
      		$this->error['gender'] = $this->language->get('error_gender');
    	}
		if ($this->request->post['id_location'] == '') {
      		$this->error['id_location'] = $this->language->get('error_id_location');
    	}
		// end LMT
		
		// start LMT
		if (!$this->checkdateDDMMYYYY($this->request->post['date_of_birth'])) {
      		$this->error['date_of_birth'] = $this->language->get('error_date_of_birth');
    	}
		// end LMT
    	if ((utf8_strlen($this->request->post['firstname']) < 1) || (utf8_strlen($this->request->post['firstname']) > 32)) {
      		$this->error['firstname'] = $this->language->get('error_firstname');
    	}

    	if ((utf8_strlen($this->request->post['lastname']) < 1) || (utf8_strlen($this->request->post['lastname']) > 32)) {
      		$this->error['lastname'] = $this->language->get('error_lastname');
    	}

		if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
      		$this->error['email'] = $this->language->get('error_email');
    	}
		
		$customer_info = $this->model_sale_customer->getCustomerByEmail($this->request->post['email']);
		
		if (!isset($this->request->get['customer_id'])) {
			if ($customer_info) {
				$this->error['warning'] = $this->language->get('error_exists');
			}
		} else {
			if ($customer_info && ($this->request->get['customer_id'] != $customer_info['customer_id'])) {
				$this->error['warning'] = $this->language->get('error_exists');
			}
		}
		
    	if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
      		$this->error['telephone'] = $this->language->get('error_telephone');
    	}

    	if ($this->request->post['password'] || (!isset($this->request->get['customer_id']))) {
      		if ((utf8_strlen($this->request->post['password']) < 4) || (utf8_strlen($this->request->post['password']) > 20)) {
        		$this->error['password'] = $this->language->get('error_password');
      		}
	
	  		if ($this->request->post['password'] != $this->request->post['confirm']) {
	    		$this->error['confirm'] = $this->language->get('error_confirm');
	  		}
    	}

		if (isset($this->request->post['address'])) {
			foreach ($this->request->post['address'] as $key => $value) {
				// start LMT
				/*
				if ((utf8_strlen($value['firstname']) < 1) || (utf8_strlen($value['firstname']) > 32)) {
					$this->error['address_firstname'][$key] = $this->language->get('error_firstname');
				}
				
				if ((utf8_strlen($value['lastname']) < 1) || (utf8_strlen($value['lastname']) > 32)) {
					$this->error['address_lastname'][$key] = $this->language->get('error_lastname');
				}	
				*/
				// end LMT
				if ((utf8_strlen($value['address_1']) < 3) || (utf8_strlen($value['address_1']) > 128)) {
					$this->error['address_address_1'][$key] = $this->language->get('error_address_1');
				}
				
				//start LMT
				/*if ((utf8_strlen($value['address_2']) < 3) || (utf8_strlen($value['address_2']) > 128)) {
					$this->error['address_2'] = $this->language->get('error_address_1');
				}
				if ((utf8_strlen($value['city']) < 2) || (utf8_strlen($value['city']) > 128)) {
					$this->error['address_city'][$key] = $this->language->get('error_city');
				} 
				
	
				$this->load->model('localisation/country');
				
				$country_info = $this->model_localisation_country->getCountry($value['country_id']);
						
				if ($country_info) {
					if ($country_info['postcode_required'] && (utf8_strlen($value['postcode']) < 2) || (utf8_strlen($value['postcode']) > 10)) {
						$this->error['address_postcode'][$key] = $this->language->get('error_postcode');
					}
					
					// VAT Validation
					$this->load->helper('vat');
					
					if ($this->config->get('config_vat') && $value['tax_id'] && (vat_validation($country_info['iso_code_2'], $value['tax_id']) == 'invalid')) {
						$this->error['address_tax_id'][$key] = $this->language->get('error_vat');
					}
				}
				*/
				//end LMT
				if ($value['country_id'] == '') {
					$this->error['address_country'][$key] = $this->language->get('error_country');
				}
				
				if (!isset($value['zone_id']) || $value['zone_id'] == '') {
					$this->error['address_zone'][$key] = $this->language->get('error_zone');
				}	
			}
		}
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}    

  	protected function validateDelete() {
    	if (!$this->user->hasPermission('modify', 'sale/customer')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}	
	  	 
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}  
  	} 
	
	public function login() {
		$json = array();
		
		if (isset($this->request->get['customer_id'])) {
			$customer_id = $this->request->get['customer_id'];
		} else {
			$customer_id = 0;
		}
		
		$this->load->model('sale/customer');
		
		$customer_info = $this->model_sale_customer->getCustomer($customer_id);
				
		if ($customer_info) {
			$token = md5(mt_rand());
			
			$this->model_sale_customer->editToken($customer_id, $token);
			
			if (isset($this->request->get['store_id'])) {
				$store_id = $this->request->get['store_id'];
			} else {
				$store_id = 0;
			}
					
			$this->load->model('setting/store');
			
			$store_info = $this->model_setting_store->getStore($store_id);
			
			if ($store_info) {
				$this->redirect($store_info['url'] . 'index.php?route=account/login&token=' . $token);
			} else { 
				$this->redirect(HTTP_CATALOG . 'index.php?route=account/login&token=' . $token);
			}
		} else {
			$this->language->load('error/not_found');

			$this->document->setTitle($this->language->get('heading_title'));

			$this->data['heading_title'] = $this->language->get('heading_title');

			$this->data['text_not_found'] = $this->language->get('text_not_found');

			$this->data['breadcrumbs'] = array();

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_home'),
				'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => false
			);

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('heading_title'),
				'href'      => $this->url->link('error/not_found', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => ' :: '
			);
		
			$this->template = 'error/not_found.tpl';
			$this->children = array(
				'common/header',
				'common/footer'
			);
		
			$this->response->setOutput($this->render());
		}
	}
	
	public function history() {
    	$this->language->load('sale/customer');
		
		$this->load->model('sale/customer');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->user->hasPermission('modify', 'sale/customer')) { 
			$this->model_sale_customer->addHistory($this->request->get['customer_id'], $this->request->post['comment']);
				
			$this->data['success'] = $this->language->get('text_success');
		} else {
			$this->data['success'] = '';
		}
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && !$this->user->hasPermission('modify', 'sale/customer')) {
			$this->data['error_warning'] = $this->language->get('error_permission');
		} else {
			$this->data['error_warning'] = '';
		}		
		
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_comment'] = $this->language->get('column_comment');
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}  
		
		$this->data['histories'] = array();
			
		$results = $this->model_sale_customer->getHistories($this->request->get['customer_id'], ($page - 1) * 10, 10);
      		
		foreach ($results as $result) {
        	$this->data['histories'][] = array(
				'comment'     => $result['comment'],
        		'date_added'  => date($this->language->get('date_format_short'), strtotime($result['date_added']))
        	);
      	}			
		
		$transaction_total = $this->model_sale_customer->getTotalHistories($this->request->get['customer_id']);
			
		$pagination = new Pagination();
		$pagination->total = $transaction_total;
		$pagination->page = $page;
		$pagination->limit = 10; 
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('sale/customer/history', 'token=' . $this->session->data['token'] . '&customer_id=' . $this->request->get['customer_id'] . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();

		$this->template = 'sale/customer_history.tpl';		
		
		$this->response->setOutput($this->render());
	}
		
	public function transaction() {
    	$this->language->load('sale/customer');
		
		$this->load->model('sale/customer');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->user->hasPermission('modify', 'sale/customer')) { 
			$this->model_sale_customer->addTransaction($this->request->get['customer_id'], $this->request->post['description'], $this->request->post['amount']);
				
			$this->data['success'] = $this->language->get('text_success');
		} else {
			$this->data['success'] = '';
		}
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && !$this->user->hasPermission('modify', 'sale/customer')) {
			$this->data['error_warning'] = $this->language->get('error_permission');
		} else {
			$this->data['error_warning'] = '';
		}		
		
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_balance'] = $this->language->get('text_balance');
		
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_description'] = $this->language->get('column_description');
		$this->data['column_amount'] = $this->language->get('column_amount');
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}  
		
		$this->data['transactions'] = array();
			
		$results = $this->model_sale_customer->getTransactions($this->request->get['customer_id'], ($page - 1) * 10, 10);
      		
		foreach ($results as $result) {
        	$this->data['transactions'][] = array(
				'amount'      => $this->currency->format($result['amount'], $this->config->get('config_currency')),
				'description' => $result['description'],
        		'date_added'  => date($this->language->get('date_format_short'), strtotime($result['date_added']))
        	);
      	}			
		
		$this->data['balance'] = $this->currency->format($this->model_sale_customer->getTransactionTotal($this->request->get['customer_id']), $this->config->get('config_currency'));
		
		$transaction_total = $this->model_sale_customer->getTotalTransactions($this->request->get['customer_id']);
			
		$pagination = new Pagination();
		$pagination->total = $transaction_total;
		$pagination->page = $page;
		$pagination->limit = 10; 
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('sale/customer/transaction', 'token=' . $this->session->data['token'] . '&customer_id=' . $this->request->get['customer_id'] . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();

		$this->template = 'sale/customer_transaction.tpl';		
		
		$this->response->setOutput($this->render());
	}
			
	public function reward() {
    	$this->language->load('sale/customer');
		
		$this->load->model('sale/customer');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->user->hasPermission('modify', 'sale/customer')) { 
			$this->model_sale_customer->addReward($this->request->get['customer_id'], $this->request->post['description'], $this->request->post['points']);
				
			$this->data['success'] = $this->language->get('text_success');
		} else {
			$this->data['success'] = '';
		}
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && !$this->user->hasPermission('modify', 'sale/customer')) {
			$this->data['error_warning'] = $this->language->get('error_permission');
		} else {
			$this->data['error_warning'] = '';
		}	
				
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_balance'] = $this->language->get('text_balance');
		
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_description'] = $this->language->get('column_description');
		$this->data['column_points'] = $this->language->get('column_points');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}  
		
		$this->data['rewards'] = array();
			
		$results = $this->model_sale_customer->getRewards($this->request->get['customer_id'], ($page - 1) * 10, 10);
      		
		foreach ($results as $result) {
        	$this->data['rewards'][] = array(
				'points'      => $result['points'],
				'description' => $result['description'],
        		'date_added'  => date($this->language->get('date_format_short'), strtotime($result['date_added']))
        	);
      	}			
		
		$this->data['balance'] = $this->model_sale_customer->getRewardTotal($this->request->get['customer_id']);
		
		$reward_total = $this->model_sale_customer->getTotalRewards($this->request->get['customer_id']);
			
		$pagination = new Pagination();
		$pagination->total = $reward_total;
		$pagination->page = $page;
		$pagination->limit = 10; 
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('sale/customer/reward', 'token=' . $this->session->data['token'] . '&customer_id=' . $this->request->get['customer_id'] . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();

		$this->template = 'sale/customer_reward.tpl';		
		
		$this->response->setOutput($this->render());
	}
	
	public function addBanIP() {
		$this->language->load('sale/customer');
		
		$json = array();

		if (isset($this->request->post['ip'])) { 
			if (!$this->user->hasPermission('modify', 'sale/customer')) {
				$json['error'] = $this->language->get('error_permission');
			} else {
				$this->load->model('sale/customer');
				
				$this->model_sale_customer->addBanIP($this->request->post['ip']);
				
				$json['success'] = $this->language->get('text_success');
			}
		}
		
		$this->response->setOutput(json_encode($json));
	}
	
	public function removeBanIP() {
		$this->language->load('sale/customer');
		
		$json = array();

		if (isset($this->request->post['ip'])) { 
			if (!$this->user->hasPermission('modify', 'sale/customer')) {
				$json['error'] = $this->language->get('error_permission');
			} else {
				$this->load->model('sale/customer');
				
				$this->model_sale_customer->removeBanIP($this->request->post['ip']);
				
				$json['success'] = $this->language->get('text_success');
			}
		}
		
		$this->response->setOutput(json_encode($json));
	}

	public function autocomplete() {
		$json = array();
		
		if (isset($this->request->get['filter_name'])) {
			$this->load->model('sale/customer');
			
			$data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 20
			);
		
			$results = $this->model_sale_customer->getCustomers($data);
			
			foreach ($results as $result) {
				$json[] = array(
					'customer_id'       => $result['customer_id'], 
					'customer_group_id' => $result['customer_group_id'],
					'name'              => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'floor'   			=> $result['floor_name'],
					'customer_group'    => $result['customer_group'],
					'firstname'         => $result['firstname'],
					'lastname'          => $result['lastname'],
					'email'             => $result['email'],
					'telephone'         => $result['telephone'],
					'fax'               => $result['fax'],
					'address'           => $this->model_sale_customer->getAddresses($result['customer_id'])
				);					
			}
		}

		$sort_order = array();
	  
		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->setOutput(json_encode($json));
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
		
	public function address() {
		$json = array();
		
		if (!empty($this->request->get['address_id'])) {
			$this->load->model('sale/customer');
			
			$json = $this->model_sale_customer->getAddress($this->request->get['address_id']);
		}

		$this->response->setOutput(json_encode($json));		
	}
	
	// start LMT
	protected function checkdateDDMMYYYY($s)
	{
		
            if (preg_match('@^(\d\d)-(\d\d)-(\d\d\d\d)$@', $s, $m) == false) {
                if (preg_match('@^(\d\d)/(\d\d)/(\d\d\d\d)$@', $s, $m) == false) {
                    return false;
                }
            }
            if (checkdate($m[2], $m[1], $m[3]) == false) {
                return false;
            }
            return true;

	}
	protected function checkStudentID($student_id) {
		$this->load->model('catalog/category');
		
		if($this->model_catalog_category->checkStudentID($student_id)) {
			return true;
		}
		
		return true;
	}
	public function childcategory() {
		$json = array();

		// start LMT
		if (isset($this->request->get['university_id'])) {
				$university_id = $this->request->get['university_id'];
			} else {
				$university_id = null;
			}
		if (isset($this->request->get['filter_university'])) {
				$filter_university = $this->request->get['filter_university'];
			} else {
				$filter_university = null;
			}


		$this->load->model('catalog/category');
		$result = '';
		if ($university_id){
			$result = $this->model_catalog_category->getUniversityCategories($university_id);
		}
		elseif ($filter_university) {
			$result = $this->model_catalog_category->getUniversityCategories($filter_university);
		}
    	
    	// end LMT
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
	public function childfloor() {
		$json = array();

		// start LMT
		if (isset($this->request->get['floor_id'])) {
				$floor_id = $this->request->get['floor_id'];
			} else {
				$floor_id = null;
			}
		

		$this->load->model('sale/customer');
		$result = '';
		if ($floor_id){
			$result = $this->model_sale_customer->getCustomerGroupIdFromFloor($floor_id);
		}
		
    	
    	// end LMT
		$customer_groups = array();
		
		if ($result) {
			foreach($result as $customer_group) {
				$customer_groups[] = array(
					'customer_group_id'        => $customer_group['customer_group_id'],
					'name'              => $customer_group['name']
				);
			}
		}
		
		$json = $customer_groups;
		$this->response->setOutput(json_encode($json));
	}
	// end LMT
}
?>