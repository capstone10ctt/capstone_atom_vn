<?php
class ModelSaleCustomer extends Model {
	/////////////////////// Modification//////////////////////
  // ID: 1051015        
  // Name: Luu Minh Tan           
  // Class: 10CTT
  // Date created: 25/12/2013
  // Description: Change update database func, insert database func
  // Date modified: 1/1/2014
  ////////////////////////////////////////////////////////////// 
	public function addCustomer($data) {
		//start LMT
		$this->load->model('catalog/category');
		$NKUniversity = $this->model_catalog_category->NKUniversity();
		$inputdate = date("Y-m-d", strtotime($data['iddate']));

		// start LMT
		$date_of_birth = date("Y-m-d", strtotime($data['date_of_birth']));
		$check_exist = $this->db->query("SELECT COUNT(*) AS Total FROM " . DB_PREFIX . "customer WHERE student_id = '". $data['student_id'] ."'");
      	// LMT 11:36 18/03/2014
      	if ((int)$check_exist->row['Total'][0] == 0){
      		$this->db->query("INSERT INTO " . DB_PREFIX . "customer SET firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', gender = '" . $this->db->escape($data['gender_id']) . "', id_num = '" . $this->db->escape($data['idnum']) . "', id_date = '" . $this->db->escape($inputdate) . "',date_of_birth = '" . $this->db->escape($date_of_birth) . "', id_location = '" . $this->db->escape($data['id_location']) . "',university = '" . $this->db->escape($data['university_id']) . "',faculty = '" . $this->db->escape($data['faculty_id']) . "',student_id = '" . $this->db->escape($data['student_id']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', newsletter = '" . (int)$data['newsletter'] . "', customer_group_id = '" . (int)$data['customer_group_id'] . "',bed = '" . (int)$data['bed_id'] . "',  salt = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "', status = '" . (int)$data['status'] . "', date_added = NOW()");
      		
      		// end LMT
	      	$customer_id = $this->db->getLastId();
			//update NK University
			if((int)$data['university_id'] == (int)$NKUniversity) {
				$this->db->query("UPDATE " . DB_PREFIX . "customer SET student_id = 'NK" . (int)$customer_id . "' WHERE customer_id = '" . (int)$customer_id . "'");
			}
	      	//end LMT
	      	if (isset($data['address'])) {		
	      		foreach ($data['address'] as $address) {	
	      			$this->db->query("INSERT INTO " . DB_PREFIX . "address SET customer_id = '" . (int)$customer_id . "', firstname = '" . $this->db->escape($address['firstname']) . "', lastname = '" . $this->db->escape($address['lastname']) . "', company = '" . $this->db->escape($address['company']) . "', company_id = '" . $this->db->escape($address['company_id']) . "', tax_id = '" . $this->db->escape($address['tax_id']) . "', address_1 = '" . $this->db->escape($address['address_1']) . "', address_2 = '" . $this->db->escape($address['address_2']) . "', city = '" . $this->db->escape($address['city']) . "', postcode = '" . $this->db->escape($address['postcode']) . "', country_id = '" . (int)$address['country_id'] . "', zone_id = '" . (int)$address['zone_id'] . "'");
					
					if (isset($address['default'])) {
						$address_id = $this->db->getLastId();
						
						$this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . $address_id . "' WHERE customer_id = '" . (int)$customer_id . "'");
					}
				}
			}

      		return 1;
      	}
      	return 0;
	}
	
	public function editCustomer($customer_id, $data) {
		//start LMT
		$this->load->model('catalog/category');
		$NKUniversity = $this->model_catalog_category->NKUniversity();
		$inputdate = date("Y-m-d", strtotime($data['iddate']));

		// start LMT
		$date_of_birth = date("Y-m-d", strtotime($data['date_of_birth']));

		//$this->db->query("UPDATE " . DB_PREFIX . "customer SET firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', gender = '" . $this->db->escape($data['gender_id']) . "', id_num = '" . $this->db->escape($data['idnum']) . "', id_date = '" . $this->db->escape($inputdate) . "', id_location = '" . $this->db->escape($data['id_location']) . "',university = '" . $this->db->escape($data['university_id']) . "',faculty = '" . $this->db->escape($data['faculty_id']) . "',student_id = '" . $this->db->escape($data['student_id']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', newsletter = '" . (int)$data['newsletter'] . "', customer_group_id = '" . (int)$data['customer_group_id'] . "', status = '" . (int)$data['status'] . "' WHERE customer_id = '" . (int)$customer_id . "'");
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', gender = '" . $this->db->escape($data['gender_id']) . "', id_num = '" . $this->db->escape($data['idnum']) . "', id_date = '" . $this->db->escape($inputdate) . "',date_of_birth = '" . $this->db->escape($date_of_birth) . "',  id_location = '" . $this->db->escape($data['id_location']) . "',university = '" . $this->db->escape($data['university_id']) . "',faculty = '" . $this->db->escape($data['faculty_id']) . "',student_id = '" . $this->db->escape($data['student_id']) . "', telephone = '" . $this->db->escape($data['telephone']) . "',  newsletter = '" . (int)$data['newsletter'] . "', customer_group_id = '" . (int)$data['customer_group_id'] . "', bed = '" . (int)$data['bed_id'] . "', status = '" . (int)$data['status'] . "' WHERE customer_id = '" . (int)$customer_id . "'");
		// end LMT
		//update NK University
		if((int)$data['university_id'] == (int)$NKUniversity) {
			$this->db->query("UPDATE " . DB_PREFIX . "customer SET student_id = 'NK" . (int)$customer_id . "' WHERE customer_id = '" . (int)$customer_id . "'");
			
		}
      	//end LMT
		
      	if ($data['password']) {
        	$this->db->query("UPDATE " . DB_PREFIX . "customer SET salt = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "' WHERE customer_id = '" . (int)$customer_id . "'");
      	}
      	
      	$this->db->query("DELETE FROM " . DB_PREFIX . "address WHERE customer_id = '" . (int)$customer_id . "'");
      	
      	if (isset($data['address'])) {
      		foreach ($data['address'] as $address) {
      			// start LMT
				//$this->db->query("INSERT INTO " . DB_PREFIX . "address SET address_id = '" . (int)$address['address_id'] . "', customer_id = '" . (int)$customer_id . "', firstname = '" . $this->db->escape($address['firstname']) . "', lastname = '" . $this->db->escape($address['lastname']) . "', company = '" . $this->db->escape($address['company']) . "', company_id = '" . $this->db->escape($address['company_id']) . "', tax_id = '" . $this->db->escape($address['tax_id']) . "', address_1 = '" . $this->db->escape($address['address_1']) . "', address_2 = '" . $this->db->escape($address['address_2']) . "', city = '" . $this->db->escape($address['city']) . "', postcode = '" . $this->db->escape($address['postcode']) . "', country_id = '" . (int)$address['country_id'] . "', zone_id = '" . (int)$address['zone_id'] . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "address SET address_id = '" . (int)$address['address_id'] . "', customer_id = '" . (int)$customer_id . "', address_1 = '" . $this->db->escape($address['address_1']) . "',    country_id = '" . (int)$address['country_id'] . "', zone_id = '" . (int)$address['zone_id'] . "'");
				
				if (isset($address['default'])) {
					$address_id = $this->db->getLastId();
						
					$this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . (int)$address_id . "' WHERE customer_id = '" . (int)$customer_id . "'");
				}
				// end LMT
			}
		}
	}

	public function editToken($customer_id, $token) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET token = '" . $this->db->escape($token) . "' WHERE customer_id = '" . (int)$customer_id . "'");
	}
	
	public function deleteCustomer($customer_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_reward WHERE customer_id = '" . (int)$customer_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_transaction WHERE customer_id = '" . (int)$customer_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_ip WHERE customer_id = '" . (int)$customer_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "address WHERE customer_id = '" . (int)$customer_id . "'");
	}
	
	public function getCustomer($customer_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customer c LEFT JOIN " . DB_PREFIX . "customer_group cg ON(c.customer_group_id = cg.customer_group_id) WHERE c.customer_id = '" . (int)$customer_id . "'");
	
		return $query->row;
	}
	
	public function getCustomerByEmail($email) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customer WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
	
		return $query->row;
	}
	/////////////////////// Modification//////////////////////
  // ID: 1051015        
  // Name: Luu Minh Tan           
  // Class: 10CTT
  // Date created: 25/12/2013
  // Description: Change update database func, insert database func
  // Date modified: 1/1/2014
  ////////////////////////////////////////////////////////////// 
	public function getFloors()
	{
		$query = $this->db->query( "SELECT DISTINCT fd.floor_name, fd.floor_id FROM " . DB_PREFIX . "customer c LEFT JOIN " . DB_PREFIX . "customer_group cg ON (c.customer_group_id = cg.customer_group_id) LEFT JOIN ". DB_PREFIX . "customer_group_description cgd ON (c.customer_group_id = cgd.customer_group_id) LEFT JOIN ". DB_PREFIX . "floor_description fd ON (cg.floor_id = fd.floor_id AND fd.language_id = cgd.language_id ) WHERE cgd.language_id = '" . (int)$this->config->get('config_language_id') ."'");

		return $query->rows;
	}
	public function getAllFloors()
	{
		$query = $this->db->query( "SELECT * FROM " . DB_PREFIX . "floor_description fd WHERE fd.language_id = '" . (int)$this->config->get('config_language_id') ."'");

		return $query->rows;
	}

	public function getFields()
	{
		$query = $this->db->query( "SELECT DISTINCT field_id, field_name FROM " . DB_PREFIX . "field_description WHERE language_id = '" . (int)$this->config->get('config_language_id') ."'");

		return $query->rows;
	}
	public function getCustomerGroupIdFromFloor($parent_id = 0)
	{
		$query = $this->db->query( "SELECT cgd.customer_group_id, cg.name FROM " . DB_PREFIX . "customer_group cg LEFT JOIN ". DB_PREFIX ."customer_group_description cgd ON(cg.customer_group_id = cgd.customer_group_id) WHERE cgd.language_id = '" . (int)$this->config->get('config_language_id') ."' AND cg.floor_id = '" . (int)$parent_id . "'");

		return $query->rows;
	}
	
	public function getCustomers($data = array()) {
		$sql = "SELECT *, CONCAT(c.lastname, ' ', c.firstname) AS name, cg.name AS customer_group FROM " . DB_PREFIX . "customer c LEFT JOIN " . DB_PREFIX . "customer_group cg ON (c.customer_group_id = cg.customer_group_id) LEFT JOIN ". DB_PREFIX . "customer_group_description cgd ON (c.customer_group_id = cgd.customer_group_id) LEFT JOIN ". DB_PREFIX . "floor_description fd ON (cg.floor_id = fd.floor_id AND fd.language_id = cgd.language_id ) WHERE cgd.language_id = '" . (int)$this->config->get('config_language_id') ."'";
		//$sql = "SELECT *, CONCAT(c.firstname, ' ', c.lastname) AS name, cg.name AS customer_group FROM " . DB_PREFIX . "customer c LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (c.customer_group_id = cgd.customer_group_id) WHERE cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		$implode = array();
		// start LMT

		if (!empty($data['filter_id'])) {
			$implode[] = "student_id LIKE '%" . $this->db->escape($data['filter_id']) . "%'";
		}

		if (!empty($data['filter_field'])) {
			$implode[] = "field = '" . (int)$data['filter_field'] . "'";
		}

		if (isset($data['filter_gender']) && !is_null($data['filter_gender'])) {
			$implode[] = "c.gender = '" . (int)$data['filter_gender'] . "'";
		}

		if (!empty($data['filter_telephone'])) {
			$implode[] = "c.telephone LIKE '%" . $this->db->escape($data['filter_telephone']) . "%'";
		}
		if (!empty($data['filter_date_of_birth'])) {
			$implode[] = "c.date_of_birth LIKE '%" . $this->db->escape(date("Y-m-d", strtotime($data['filter_date_of_birth']))) . "%'";
		}
		if (isset($data['filter_bed']) && !is_null($data['filter_bed'])) {
			$implode[] = "c.bed = '" . (int)$data['filter_bed'] . "'";
		}
		/*
		if (isset($data['filter_floor']) && !is_null($data['filter_floor'])) {
			$implode[] = "fd.floor_name LIKE '%" .  $this->db->escape($data['filter_floor']) . "%'";
		}
		*/
		if (!empty($data['filter_floor_id']) && !is_null($data['filter_floor_id'])) {
			$implode[] = "cg.floor_id = '" . (int)$data['filter_floor_id'] . "'";
		}
		
		if (!empty($data['filter_ethnic'])) {
			$implode[] = "c.ethnic LIKE '%" . $this->db->escape($data['filter_ethnic']) . "%'";
		}
		if (!empty($data['filter_university'])) {
			$implode[] = "c.university LIKE '%" . $this->db->escape($data['filter_university']) . "%'";
		}
		if (!empty($data['filter_faculty'])) {
			$implode[] = "c.faculty LIKE '%" . $this->db->escape($data['filter_faculty']) . "%'";
		}
		if (!empty($data['filter_address_1'])) {
			$implode[] = "c.id_location LIKE '%" . $this->db->escape($data['filter_address_1']) . "%'";
		}
		// end LMT
		if (!empty($data['filter_name'])) {
			$implode[] = "CONCAT(c.firstname, ' ', c.lastname) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}
		
		if (!empty($data['filter_email'])) {
			$implode[] = "c.email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
		}

		if (isset($data['filter_newsletter']) && !is_null($data['filter_newsletter'])) {
			$implode[] = "c.newsletter = '" . (int)$data['filter_newsletter'] . "'";
		}	
				
		if (!empty($data['filter_customer_group_id'])) {
			$implode[] = "c.customer_group_id = '" . (int)$data['filter_customer_group_id'] . "'";
		}	
			
		if (!empty($data['filter_ip'])) {
			$implode[] = "c.customer_id IN (SELECT customer_id FROM " . DB_PREFIX . "customer_ip WHERE ip = '" . $this->db->escape($data['filter_ip']) . "')";
		}	
				
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "c.status = '" . (int)$data['filter_status'] . "'";
		}	
		
		if (isset($data['filter_approved']) && !is_null($data['filter_approved'])) {
			$implode[] = "c.approved = '" . (int)$data['filter_approved'] . "'";
		}	
				
		if (isset($data['filter_student_status']) && !is_null($data['filter_student_status'])) {
			$implode[] = "c.student_status = '" . (int)$data['filter_student_status'] . "'";
		}	

		if (isset($data['filter_valid']) && !is_null($data['filter_valid'])) {
			$implode[] = "student_valid = '" . (int)$data['filter_valid'] . "'";
		}		

		if (isset($data['filter_resident']) && !is_null($data['filter_resident'])) {
			$implode[] = "resident = '" . (int)$data['filter_resident'] . "'";
		}		
				
		if (!empty($data['filter_date_added'])) {
			$implode[] = "DATE(c.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}
		
		if ($implode) {
			$sql .= " AND " . implode(" AND ", $implode);
		}
		
		$sort_data = array(
			// start LMT
			'student_id',
			'name',
			'field',
			'gender',
			'date_of_birth',
			'university',
			'faculty',
			'c.email',
			'customer_group',
			'floor_name',
			'floor_id',
			'bed',
			'ethnic',
			'address_1',
			'c.status',
			'c.student_valid',
			'c.resident',
			'c.ip',
			'c.date_added'
			// end LMT
		);	
			
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY name";	
		}
			
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}
		
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}			

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	
			
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}		
		
		$query = $this->db->query($sql);
		
		return $query->rows;	
	}

    public function getStudents($data = array()) {
        $ouput = array();

        $period = $this->db->query("SELECT * FROM " . DB_PREFIX . "student_receive_period WHERE `is_apply` = '1'");
        $student_receive = $this->db->query("SELECT * FROM " . DB_PREFIX . "student_receive  WHERE student_status = '" . (int)$data['filter_student_status'] . "'");

        foreach($student_receive->rows as $student) {
            $sql = "SELECT *, CONCAT(c.lastname, ' ', c.firstname) AS name, cg.name AS customer_group FROM " . DB_PREFIX . "customer c LEFT JOIN " . DB_PREFIX . "customer_group cg ON (c.customer_group_id = cg.customer_group_id) LEFT JOIN ". DB_PREFIX . "customer_group_description cgd ON (c.customer_group_id = cgd.customer_group_id) LEFT JOIN ". DB_PREFIX . "floor_description fd ON (cg.floor_id = fd.floor_id AND fd.language_id = cgd.language_id ) WHERE cgd.language_id = '" . (int)$this->config->get('config_language_id') ."'";
            //$sql = "SELECT *, CONCAT(c.firstname, ' ', c.lastname) AS name, cg.name AS customer_group FROM " . DB_PREFIX . "customer c LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (c.customer_group_id = cgd.customer_group_id) WHERE cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
            $implode = array();
            // start LMT

            if (!empty($data['filter_id'])) {
                $implode[] = "student_id LIKE '%" . $this->db->escape($data['filter_id']) . "%'";
            }

            if (!empty($data['filter_field'])) {
                $implode[] = "field = '" . (int)$data['filter_field'] . "'";
            }

            if (isset($data['filter_gender']) && !is_null($data['filter_gender'])  && (int)$data['filter_gender'] != -1) {
                $implode[] = "c.gender = '" . (int)$data['filter_gender'] . "'";
            }

            if (!empty($data['filter_telephone'])) {
                $implode[] = "c.telephone LIKE '%" . $this->db->escape($data['filter_telephone']) . "%'";
            }
            if (!empty($data['filter_date_of_birth'])) {
                $implode[] = "c.date_of_birth LIKE '%" . $this->db->escape(date("Y-m-d", strtotime($data['filter_date_of_birth']))) . "%'";
            }
            if (isset($data['filter_bed']) && !is_null($data['filter_bed'])) {
                $implode[] = "c.bed = '" . (int)$data['filter_bed'] . "'";
            }
            /*
            if (isset($data['filter_floor']) && !is_null($data['filter_floor'])) {
                $implode[] = "fd.floor_name LIKE '%" .  $this->db->escape($data['filter_floor']) . "%'";
            }
            */
            if (!empty($data['filter_floor_id']) && !is_null($data['filter_floor_id'])) {
                $implode[] = "cg.floor_id = '" . (int)$data['filter_floor_id'] . "'";
            }

            if (!empty($data['filter_ethnic'])) {
                $implode[] = "c.ethnic LIKE '%" . $this->db->escape($data['filter_ethnic']) . "%'";
            }
            if (!empty($data['filter_university'])) {
                $implode[] = "c.university LIKE '%" . $this->db->escape($data['filter_university']) . "%'";
            }
            if (!empty($data['filter_faculty'])) {
                $implode[] = "c.faculty LIKE '%" . $this->db->escape($data['filter_faculty']) . "%'";
            }
            if (!empty($data['filter_address_1'])) {
                $implode[] = "c.id_location LIKE '%" . $this->db->escape($data['filter_address_1']) . "%'";
            }
            // end LMT
            if (!empty($data['filter_name'])) {
                $implode[] = "CONCAT(c.firstname, ' ', c.lastname) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
            }

            if (!empty($data['filter_email'])) {
                $implode[] = "c.email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
            }

            if (isset($data['filter_newsletter']) && !is_null($data['filter_newsletter'])) {
                $implode[] = "c.newsletter = '" . (int)$data['filter_newsletter'] . "'";
            }

            if (!empty($data['filter_customer_group_id'])) {
                $implode[] = "c.customer_group_id = '" . (int)$data['filter_customer_group_id'] . "'";
            }

            if (!empty($data['filter_ip'])) {
                $implode[] = "c.customer_id IN (SELECT customer_id FROM " . DB_PREFIX . "customer_ip WHERE ip = '" . $this->db->escape($data['filter_ip']) . "')";
            }

            if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
                $implode[] = "c.status = '" . (int)$data['filter_status'] . "'";
            }

            if (isset($data['filter_approved']) && !is_null($data['filter_approved'])) {
                $implode[] = "c.approved = '" . (int)$data['filter_approved'] . "'";
            }

            if (isset($data['filter_valid']) && !is_null($data['filter_valid'])) {
                $implode[] = "student_valid = '" . (int)$data['filter_valid'] . "'";
            }

            if (isset($data['filter_resident']) && !is_null($data['filter_resident'])) {
                $implode[] = "resident = '" . (int)$data['filter_resident'] . "'";
            }

            if (!empty($data['filter_date_added'])) {
                $implode[] = "DATE(c.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
            }

            if ($implode) {
                $sql .= " AND " . implode(" AND ", $implode);
            }

            $sql .= " AND `student_id` = " . (int)$student['student_id'];

            $sort_data = array(
                // start LMT
                'student_id',
                'name',
                'field',
                'gender',
                'date_of_birth',
                'university',
                'faculty',
                'c.email',
                'customer_group',
                'floor_name',
                'floor_id',
                'bed',
                'ethnic',
                'address_1',
                'c.status',
                'c.student_valid',
                'c.resident',
                'c.ip',
                'c.date_added'
                // end LMT
            );

            if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
                $sql .= " ORDER BY " . $data['sort'];
            } else {
                $sql .= " ORDER BY name";
            }

            if (isset($data['order']) && ($data['order'] == 'DESC')) {
                $sql .= " DESC";
            } else {
                $sql .= " ASC";
            }

            if (isset($data['start']) || isset($data['limit'])) {
                if ($data['start'] < 0) {
                    $data['start'] = 0;
                }

                if ($data['limit'] < 1) {
                    $data['limit'] = 20;
                }

                $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
            }

            $stu = $this->db->query($sql);

            if($stu->num_rows) {
                $ouput[] = $stu->row;
            }
        }

        return $ouput;
    }
	
	public function approve($customer_id, $value) {
		$customer_info = $this->getCustomer($customer_id);

		if ($customer_info) {
			$this->db->query("UPDATE " . DB_PREFIX . "customer SET student_status = '" . (int)$value . "' WHERE customer_id = '" . (int)$customer_id . "'");
			/*
			$this->language->load('mail/customer');
			
			$this->load->model('setting/store');
						
			$store_info = $this->model_setting_store->getStore($customer_info['store_id']);
			
			if ($store_info) {
				$store_name = $store_info['name'];
				$store_url = $store_info['url'] . 'index.php?route=account/login';
			} else {
				$store_name = $this->config->get('config_name');
				$store_url = HTTP_CATALOG . 'index.php?route=account/login';
			}
	
			$message  = sprintf($this->language->get('text_approve_welcome'), $store_name) . "\n\n";
			$message .= $this->language->get('text_approve_login') . "\n";
			$message .= $store_url . "\n\n";
			$message .= $this->language->get('text_approve_services') . "\n\n";
			$message .= $this->language->get('text_approve_thanks') . "\n";
			$message .= $store_name;
	
			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->hostname = $this->config->get('config_smtp_host');
			$mail->username = $this->config->get('config_smtp_username');
			$mail->password = $this->config->get('config_smtp_password');
			$mail->port = $this->config->get('config_smtp_port');
			$mail->timeout = $this->config->get('config_smtp_timeout');							
			$mail->setTo($customer_info['email']);
			$mail->setFrom($this->config->get('config_email'));
			$mail->setSender($store_name);
			$mail->setSubject(html_entity_decode(sprintf($this->language->get('text_approve_subject'), $store_name), ENT_QUOTES, 'UTF-8'));
			$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
			$mail->send();*/
		}		
	}

	public function unapprove($customer_id) {
		$customer_info = $this->getCustomer($customer_id);

		if ($customer_info) {
			$this->db->query("UPDATE " . DB_PREFIX . "customer SET approved = '0' WHERE customer_id = '" . (int)$customer_id . "'");
		}		
	}
		
	public function getAddress($address_id) {
		$address_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "address WHERE address_id = '" . (int)$address_id . "'");

		if ($address_query->num_rows) {
			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$address_query->row['country_id'] . "'");
			
			if ($country_query->num_rows) {
				$country = $country_query->row['name'];
				$iso_code_2 = $country_query->row['iso_code_2'];
				$iso_code_3 = $country_query->row['iso_code_3'];
				$address_format = $country_query->row['address_format'];
			} else {
				$country = '';
				$iso_code_2 = '';
				$iso_code_3 = '';	
				$address_format = '';
			}
			
			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$address_query->row['zone_id'] . "'");
			
			if ($zone_query->num_rows) {
				$zone = $zone_query->row['name'];
				$zone_code = $zone_query->row['code'];
			} else {
				$zone = '';
				$zone_code = '';
			}		
		
			return array(
				'address_id'     => $address_query->row['address_id'],
				'customer_id'    => $address_query->row['customer_id'],
				'firstname'      => $address_query->row['firstname'],
				'lastname'       => $address_query->row['lastname'],
				'company'        => $address_query->row['company'],
				'company_id'     => $address_query->row['company_id'],
				'tax_id'         => $address_query->row['tax_id'],
				'address_1'      => $address_query->row['address_1'],
				'address_2'      => $address_query->row['address_2'],
				'postcode'       => $address_query->row['postcode'],
				'city'           => $address_query->row['city'],
				'zone_id'        => $address_query->row['zone_id'],
				'zone'           => $zone,
				'zone_code'      => $zone_code,
				'country_id'     => $address_query->row['country_id'],
				'country'        => $country,	
				'iso_code_2'     => $iso_code_2,
				'iso_code_3'     => $iso_code_3,
				'address_format' => $address_format
			);
		}
	}
	
	public function getAddresses($customer_id) {
		$address_data = array();
		
		$query = $this->db->query("SELECT address_id FROM " . DB_PREFIX . "address WHERE customer_id = '" . (int)$customer_id . "'");
	
		foreach ($query->rows as $result) {
			$address_info = $this->getAddress($result['address_id']);
		
			if ($address_info) {
				$address_data[$result['address_id']] = $address_info;
			}
		}		
		
		return $address_data;
	}
				
	public function getTotalCustomers($data = array()) {
      	$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer";
		
		$implode = array();
		
		if (!empty($data['filter_id'])) {
			$implode[] = "student_id LIKE '%" . $this->db->escape($data['filter_id']) . "%'";
		}

		if (!empty($data['filter_field'])) {
			$implode[] = "field = '" . (int)$data['filter_field'] . "'";
		}

		if (!empty($data['filter_name'])) {
			$implode[] = "CONCAT(firstname, ' ', lastname) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}
		
		if (!empty($data['filter_email'])) {
			$implode[] = "email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
		}
		
		if (isset($data['filter_newsletter']) && !is_null($data['filter_newsletter'])) {
			$implode[] = "newsletter = '" . (int)$data['filter_newsletter'] . "'";
		}
				
		if (!empty($data['filter_customer_group_id'])) {
			$implode[] = "customer_group_id = '" . (int)$data['filter_customer_group_id'] . "'";
		}	
		
		if (!empty($data['filter_ip'])) {
			$implode[] = "customer_id IN (SELECT customer_id FROM " . DB_PREFIX . "customer_ip WHERE ip = '" . $this->db->escape($data['filter_ip']) . "')";
		}	
						
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "status = '" . (int)$data['filter_status'] . "'";
		}	
		
		if (isset($data['filter_approved']) && !is_null($data['filter_approved'])) {
			$implode[] = "approved = '" . (int)$data['filter_approved'] . "'";
		}	

		if (isset($data['filter_student_status']) && !is_null($data['filter_student_status'])) {
			$implode[] = "student_status = '" . (int)$data['filter_student_status'] . "'";
		}
		
		if (isset($data['filter_valid']) && !is_null($data['filter_valid'])) {
			$implode[] = "student_valid = '" . (int)$data['filter_valid'] . "'";
		}		


		if (isset($data['filter_resident']) && !is_null($data['filter_resident'])) {
			$implode[] = "resident = '" . (int)$data['filter_resident'] . "'";
		}		
				
		if (!empty($data['filter_date_added'])) {
			$implode[] = "DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}
		
		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}
				
		$query = $this->db->query($sql);
				
				
		return $query->row['total'];
	}
		
	public function getTotalCustomersAwaitingApproval() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE status = '0' OR approved = '0'");

		return $query->row['total'];
	}
	
	public function getTotalAddressesByCustomerId($customer_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "address WHERE customer_id = '" . (int)$customer_id . "'");
		
		return $query->row['total'];
	}
	
	public function getTotalAddressesByCountryId($country_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "address WHERE country_id = '" . (int)$country_id . "'");
		
		return $query->row['total'];
	}	
	
	public function getTotalAddressesByZoneId($zone_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "address WHERE zone_id = '" . (int)$zone_id . "'");
		
		return $query->row['total'];
	}
	
	public function getTotalCustomersByCustomerGroupId($customer_group_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE customer_group_id = '" . (int)$customer_group_id . "'");
		
		return $query->row['total'];
	}

	public function addHistory($customer_id, $comment) {
      	$this->db->query("INSERT INTO " . DB_PREFIX . "customer_history SET customer_id = '" . (int)$customer_id . "', comment = '" . $this->db->escape(strip_tags($comment)) . "', date_added = NOW()");
	}	
	
	public function getHistories($customer_id, $start = 0, $limit = 10) { 
		if ($start < 0) {
			$start = 0;
		}
		
		if ($limit < 1) {
			$limit = 10;
		}	
		
		$query = $this->db->query("SELECT comment, date_added FROM " . DB_PREFIX . "customer_history WHERE customer_id = '" . (int)$customer_id . "' ORDER BY date_added DESC LIMIT " . (int)$start . "," . (int)$limit);
	
		return $query->rows;
	}	

	public function getTotalHistories($customer_id) {
	  	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer_history WHERE customer_id = '" . (int)$customer_id . "'");

		return $query->row['total'];
	}	
			
	public function addTransaction($customer_id, $description = '', $amount = '', $order_id = 0) {
		$customer_info = $this->getCustomer($customer_id);
		
		if ($customer_info) { 
			$this->db->query("INSERT INTO " . DB_PREFIX . "customer_transaction SET customer_id = '" . (int)$customer_id . "', order_id = '" . (int)$order_id . "', description = '" . $this->db->escape($description) . "', amount = '" . (float)$amount . "', date_added = NOW()");

			$this->language->load('mail/customer');
			
			if ($customer_info['store_id']) {
				$this->load->model('setting/store');
		
				$store_info = $this->model_setting_store->getStore($customer_info['store_id']);
				
				if ($store_info) {
					$store_name = $store_info['name'];
				} else {
					$store_name = $this->config->get('config_name');
				}	
			} else {
				$store_name = $this->config->get('config_name');
			}
						
			$message  = sprintf($this->language->get('text_transaction_received'), $this->currency->format($amount, $this->config->get('config_currency'))) . "\n\n";
			$message .= sprintf($this->language->get('text_transaction_total'), $this->currency->format($this->getTransactionTotal($customer_id)));
								
			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->hostname = $this->config->get('config_smtp_host');
			$mail->username = $this->config->get('config_smtp_username');
			$mail->password = $this->config->get('config_smtp_password');
			$mail->port = $this->config->get('config_smtp_port');
			$mail->timeout = $this->config->get('config_smtp_timeout');
			$mail->setTo($customer_info['email']);
			$mail->setFrom($this->config->get('config_email'));
			$mail->setSender($store_name);
			$mail->setSubject(html_entity_decode(sprintf($this->language->get('text_transaction_subject'), $this->config->get('config_name')), ENT_QUOTES, 'UTF-8'));
			$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
			$mail->send();
		}
	}
	
	public function deleteTransaction($order_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_transaction WHERE order_id = '" . (int)$order_id . "'");
	}
	
	public function getTransactions($customer_id, $start = 0, $limit = 10) {
		if ($start < 0) {
			$start = 0;
		}
		
		if ($limit < 1) {
			$limit = 10;
		}	
				
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_transaction WHERE customer_id = '" . (int)$customer_id . "' ORDER BY date_added DESC LIMIT " . (int)$start . "," . (int)$limit);
	
		return $query->rows;
	}

	public function getTotalTransactions($customer_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total  FROM " . DB_PREFIX . "customer_transaction WHERE customer_id = '" . (int)$customer_id . "'");
	
		return $query->row['total'];
	}
			
	public function getTransactionTotal($customer_id) {
		$query = $this->db->query("SELECT SUM(amount) AS total FROM " . DB_PREFIX . "customer_transaction WHERE customer_id = '" . (int)$customer_id . "'");
	
		return $query->row['total'];
	}
	
	public function getTotalTransactionsByOrderId($order_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer_transaction WHERE order_id = '" . (int)$order_id . "'");
	
		return $query->row['total'];
	}	
				
	public function addReward($customer_id, $description = '', $points = '', $order_id = 0) {
		$customer_info = $this->getCustomer($customer_id);
			
		if ($customer_info) { 
			$this->db->query("INSERT INTO " . DB_PREFIX . "customer_reward SET customer_id = '" . (int)$customer_id . "', order_id = '" . (int)$order_id . "', points = '" . (int)$points . "', description = '" . $this->db->escape($description) . "', date_added = NOW()");

			$this->language->load('mail/customer');
			
			if ($order_id) {
				$this->load->model('sale/order');
		
				$order_info = $this->model_sale_order->getOrder($order_id);
				
				if ($order_info) {
					$store_name = $order_info['store_name'];
				} else {
					$store_name = $this->config->get('config_name');
				}	
			} else {
				$store_name = $this->config->get('config_name');
			}		
				
			$message  = sprintf($this->language->get('text_reward_received'), $points) . "\n\n";
			$message .= sprintf($this->language->get('text_reward_total'), $this->getRewardTotal($customer_id));
				
			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->hostname = $this->config->get('config_smtp_host');
			$mail->username = $this->config->get('config_smtp_username');
			$mail->password = $this->config->get('config_smtp_password');
			$mail->port = $this->config->get('config_smtp_port');
			$mail->timeout = $this->config->get('config_smtp_timeout');
			$mail->setTo($customer_info['email']);
			$mail->setFrom($this->config->get('config_email'));
			$mail->setSender($store_name);
			$mail->setSubject(html_entity_decode(sprintf($this->language->get('text_reward_subject'), $store_name), ENT_QUOTES, 'UTF-8'));
			$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
			$mail->send();
		}
	}

	public function deleteReward($order_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_reward WHERE order_id = '" . (int)$order_id . "'");
	}
	
	public function getRewards($customer_id, $start = 0, $limit = 10) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_reward WHERE customer_id = '" . (int)$customer_id . "' ORDER BY date_added DESC LIMIT " . (int)$start . "," . (int)$limit);
	
		return $query->rows;
	}
	
	public function getTotalRewards($customer_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer_reward WHERE customer_id = '" . (int)$customer_id . "'");
	
		return $query->row['total'];
	}
			
	public function getRewardTotal($customer_id) {
		$query = $this->db->query("SELECT SUM(points) AS total FROM " . DB_PREFIX . "customer_reward WHERE customer_id = '" . (int)$customer_id . "'");
	
		return $query->row['total'];
	}		
	
	public function getTotalCustomerRewardsByOrderId($order_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer_reward WHERE order_id = '" . (int)$order_id . "'");
	
		return $query->row['total'];
	}
	
	public function getIpsByCustomerId($customer_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_ip WHERE customer_id = '" . (int)$customer_id . "'");

		return $query->rows;
	}	
	
	public function getTotalCustomersByIp($ip) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer_ip WHERE ip = '" . $this->db->escape($ip) . "'");

		return $query->row['total'];
	}
	
	public function addBanIp($ip) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "customer_ban_ip` SET `ip` = '" . $this->db->escape($ip) . "'");
	}
		
	public function removeBanIp($ip) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "customer_ban_ip` WHERE `ip` = '" . $this->db->escape($ip) . "'");
	}
			
	public function getTotalBanIpsByIp($ip) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "customer_ban_ip` WHERE `ip` = '" . $this->db->escape($ip) . "'");
				 
		return $query->row['total'];
	}	
	public function getLocationList(){
		$query = $this->db->query("SELECT z.zone_id, z.name FROM " . DB_PREFIX . "zone z WHERE country_id = '230'");
		
		return $query->rows;
		}

	public function getFacultyList(){
		$query = $this->db->query("SELECT cd.category_id, cd.name FROM " . DB_PREFIX . "category_description cd");

		return $query->rows;
	}

    //start vlmn modification
    public function getTotalStudentsByData($data) {
        $ouput = array();

        $period = $this->db->query("SELECT * FROM " . DB_PREFIX . "student_receive_period WHERE `is_apply` = '1'");
        if((int)$data['filter_student_status'] != 0) {
            $student_receive = $this->db->query("SELECT * FROM " . DB_PREFIX . "student_receive  WHERE student_status = '" . (int)$data['filter_student_status'] . "' AND `period` = '" . (int)$period->row['period_id'] . "'");
        }
       else {
           $student_receive = $this->db->query("SELECT * FROM " . DB_PREFIX . "student_receive WHERE `period` = '" . (int)$period->row['period_id'] . "'");
       }

        foreach($student_receive->rows as $student) {
            $sql = "SELECT *, CONCAT(c.lastname, ' ', c.firstname) AS name, cg.name AS customer_group FROM " . DB_PREFIX . "customer c LEFT JOIN " . DB_PREFIX . "customer_group cg ON (c.customer_group_id = cg.customer_group_id) LEFT JOIN ". DB_PREFIX . "customer_group_description cgd ON (c.customer_group_id = cgd.customer_group_id) LEFT JOIN ". DB_PREFIX . "floor_description fd ON (cg.floor_id = fd.floor_id AND fd.language_id = cgd.language_id ) WHERE cgd.language_id = '" . (int)$this->config->get('config_language_id') ."'";
            //$sql = "SELECT *, CONCAT(c.firstname, ' ', c.lastname) AS name, cg.name AS customer_group FROM " . DB_PREFIX . "customer c LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (c.customer_group_id = cgd.customer_group_id) WHERE cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
            $implode = array();
            // start LMT

            if (!empty($data['filter_id'])) {
                $implode[] = "student_id LIKE '%" . $this->db->escape($data['filter_id']) . "%'";
            }

            if (!empty($data['filter_field'])) {
                $implode[] = "field = '" . (int)$data['filter_field'] . "'";
            }

            if (isset($data['filter_gender']) && !is_null($data['filter_gender']) && (int)$data['filter_gender'] != -1) {
                $implode[] = "c.gender = '" . (int)$data['filter_gender'] . "'";
            }

            if (!empty($data['filter_telephone'])) {
                $implode[] = "c.telephone LIKE '%" . $this->db->escape($data['filter_telephone']) . "%'";
            }
            if (!empty($data['filter_date_of_birth'])) {
                $implode[] = "c.date_of_birth LIKE '%" . $this->db->escape(date("Y-m-d", strtotime($data['filter_date_of_birth']))) . "%'";
            }
            if (isset($data['filter_bed']) && !is_null($data['filter_bed'])) {
                $implode[] = "c.bed = '" . (int)$data['filter_bed'] . "'";
            }
            /*
            if (isset($data['filter_floor']) && !is_null($data['filter_floor'])) {
                $implode[] = "fd.floor_name LIKE '%" .  $this->db->escape($data['filter_floor']) . "%'";
            }
            */
            if (!empty($data['filter_floor_id']) && !is_null($data['filter_floor_id'])) {
                $implode[] = "cg.floor_id = '" . (int)$data['filter_floor_id'] . "'";
            }

            if (!empty($data['filter_ethnic'])) {
                $implode[] = "c.ethnic LIKE '%" . $this->db->escape($data['filter_ethnic']) . "%'";
            }
            if (!empty($data['filter_university'])) {
                $implode[] = "c.university LIKE '%" . $this->db->escape($data['filter_university']) . "%'";
            }
            if (!empty($data['filter_faculty'])) {
                $implode[] = "c.faculty LIKE '%" . $this->db->escape($data['filter_faculty']) . "%'";
            }
            if (!empty($data['filter_address_1'])) {
                $implode[] = "c.id_location LIKE '%" . $this->db->escape($data['filter_address_1']) . "%'";
            }
            // end LMT
            if (!empty($data['filter_name'])) {
                $implode[] = "CONCAT(c.firstname, ' ', c.lastname) LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
            }

            if (!empty($data['filter_email'])) {
                $implode[] = "c.email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
            }

            if (isset($data['filter_newsletter']) && !is_null($data['filter_newsletter'])) {
                $implode[] = "c.newsletter = '" . (int)$data['filter_newsletter'] . "'";
            }

            if (!empty($data['filter_customer_group_id'])) {
                $implode[] = "c.customer_group_id = '" . (int)$data['filter_customer_group_id'] . "'";
            }

            if (!empty($data['filter_ip'])) {
                $implode[] = "c.customer_id IN (SELECT customer_id FROM " . DB_PREFIX . "customer_ip WHERE ip = '" . $this->db->escape($data['filter_ip']) . "')";
            }

            if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
                $implode[] = "c.status = '" . (int)$data['filter_status'] . "'";
            }

            if (isset($data['filter_approved']) && !is_null($data['filter_approved'])) {
                $implode[] = "c.approved = '" . (int)$data['filter_approved'] . "'";
            }

            if (isset($data['filter_valid']) && !is_null($data['filter_valid'])) {
                $implode[] = "student_valid = '" . (int)$data['filter_valid'] . "'";
            }

            if (isset($data['filter_resident']) && !is_null($data['filter_resident'])) {
                $implode[] = "resident = '" . (int)$data['filter_resident'] . "'";
            }

            if (!empty($data['filter_date_added'])) {
                $implode[] = "DATE(c.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
            }

            if ($implode) {
                $sql .= " AND " . implode(" AND ", $implode);
            }

            $sql .= " AND `student_id` = " . (int)$student['student_id'];

            $sort_data = array(
                // start LMT
                'student_id',
                'name',
                'field',
                'gender',
                'date_of_birth',
                'university',
                'faculty',
                'c.email',
                'customer_group',
                'floor_name',
                'floor_id',
                'bed',
                'ethnic',
                'address_1',
                'c.status',
                'c.student_valid',
                'c.resident',
                'c.ip',
                'c.date_added'
                // end LMT
            );

            if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
                $sql .= " ORDER BY " . $data['sort'];
            } else {
                $sql .= " ORDER BY name";
            }

            if (isset($data['order']) && ($data['order'] == 'DESC')) {
                $sql .= " DESC";
            } else {
                $sql .= " ASC";
            }

            if (isset($data['start']) || isset($data['limit'])) {
                if ($data['start'] < 0) {
                    $data['start'] = 0;
                }

                if ($data['limit'] < 1) {
                    $data['limit'] = 20;
                }

                $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
            }

            $stu = $this->db->query($sql);

            if($stu->num_rows) {
                $ouput[] = $stu->row;
            }
        }

        return count($ouput);
    }
    public function getStudentByStudentId($student_id) {
        $query2 = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE student_id = '" . (int)$student_id . "'");

        if($query2->num_rows) {
            $query3 = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_group WHERE customer_group_id = '" . (int)$query2->row['customer_group_id'] . "'");

            $query4 = $this->db->query("SELECT * FROM " . DB_PREFIX . "address WHERE customer_id = '" . (int)$query2->row['customer_id'] . "'");

            if($query3->num_rows) {
                $temp = $query2->row;
                $temp['address'] = (($query4->num_rows) ? $query4->rows: null);
                $temp['room_lead'] =(($query3->num_rows) ? $query3->row : null) ;
            }

            return $temp;
        }
    }

    function confirmStudent($student_id) {
        $this->db->query("UPDATE " . DB_PREFIX . "student_receive SET `student_status` = '1' WHERE student_id = '" . (int)$student_id . "'");
    }

    public function getStudentIDFromBarcode($card_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "file_to_student WHERE file_code = '" . trim($card_id) . "'");

        if($query->num_rows) {
            $student_id =  $query->row['student_id'];

            $query2 = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE student_id = '" . (int)$student_id . "'");

            if($query2->num_rows) {
                $query3 = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_group WHERE customer_group_id = '" . (int)$query2->row['customer_group_id'] . "'");

                $query4 = $this->db->query("SELECT * FROM " . DB_PREFIX . "address WHERE customer_id = '" . (int)$query2->row['customer_id'] . "'");

                if($query3->num_rows) {
                    $temp = $query2->row;
                    $temp['address'] = (($query4->num_rows) ? $query4->rows: null);
                    $temp['room_lead'] =(($query3->num_rows) ? $query3->row : null) ;
                }

                return $temp;
            }
        }

        return null;
    }
    //end vlmn modification
}
?>
