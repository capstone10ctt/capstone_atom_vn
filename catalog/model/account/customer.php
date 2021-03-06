<?php
class ModelAccountCustomer extends Model {
	// start changing: 
	public function checkStudentID($student_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE student_id = '" . (int)$student_id . "'");
		if($query->num_rows) {
			return false;
		}
		
		return true;
	}
        public function checkIDNum($id_num) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE id_num = '" . (int)$id_num . "'");
		if($query->num_rows) {
			return false;
		}
		
		return true;
	}
	public function NKUniversity() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_description WHERE name like '%Nang Khieu%'");
		if($query->row) {
			return $query->row['category_id'];
		}
		
		return 0;
	}
	//end changing
	
	
	public function replaceApplicationMailData($data = array()) {
		$this->load->model('catalog/template_email');
		$templateMailData = $this->model_catalog_template_email->getTemplateEmail("mail_5")['description'][1];
		$templateMail = $templateMailData['description'];
		$mailTitle = $templateMailData['name'];

		$completeMailTitle = $mailTitle;
		$completeMailBody = $this->format($templateMail, 
			$data['full_name'],							//0 fullname
			$data['student_id'],						//1 student id
			$data['dob'],								//2 date of birth
			$data['race'],								//3 dan toc
			$data['sex'],								//4
			$data['id'],								//5 cmnd
			$data['address_temp'],						//6 dia chi thuong tru
			$data['address_real'],						//7 dia chi thuong tru
			$data['phone'],								//8 
			$data['email'],								//9
			$data['area'],								//10 sv thuoc dien ?
			$data['area_detail'],						//11 dien doi tuong
			$data['family_background'],					//12 hoan canh gia dinh


			date("d"),									//13
			date("m"),									//14
			date("Y"),								//15
			$data['full_name'],							//16 fullname
			$data['family_background_cont']);					//17 hoan canh gia dinh);


		$mailMinistry = array("title" => $completeMailTitle, "body" => $completeMailBody);
		return $mailMinistry;
	}

	function format() {
	    $args = func_get_args();
	    if (count($args) == 0) {
	        return;
	    }
	    if (count($args) == 1) {
	        return $args[0];
	    }
	    
	    $str = array_shift($args);
	    $str = preg_replace_callback('/\\{(0|[1-9]\\d*)\\}/', create_function('$match', '$args = '.var_export($args, true).'; return isset($args[$match[1]]) ? $args[$match[1]] : $match[0];'), $str);
	    return $str;
	}
	
	public function getFields()
	{
		$query = $this->db->query( "SELECT DISTINCT field_id, field_name FROM " . DB_PREFIX . "field_description WHERE language_id = '" . (int)$this->config->get('config_language_id') ."'");

		return $query->rows;
	}
	
	public function addCustomer($data) {
		if (isset($data['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($data['customer_group_id'], $this->config->get('config_customer_group_display'))) {
			$customer_group_id = $data['customer_group_id'];
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}
		
		$this->load->model('account/customer_group');
		
		$customer_group_info = $this->model_account_customer_group->getCustomerGroup($customer_group_id);
		
		
		
		// start changing:
		$NKUniversity = $this->NKUniversity();
		/*$inputdate = date("Y-m-d", strtotime($data['iddate']));		*/

		//kah2914
	    $data['date_of_birth'] = (string)$data['monthbirth'].'/'.(string)$data['datebirth'].'/'.(string)$data['yearbirth'];
		$inputdateofbirth = date("Y-m-d", strtotime($data['date_of_birth']));
		//kah2914

      	$this->db->query("INSERT INTO " . DB_PREFIX . "customer SET store_id = '" . (int)$this->config->get('config_store_id') . "', firstname = '" . $this->db->escape($data['fullname']) . "', ethnic = '" . $this->db->escape($data['ethnic']). "', religion = '" . $this->db->escape($data['religion'])/*. $this->db->escape($data['firstname']) *//*. "', lastname = '" . $this->db->escape($data['lastname']) */. "', email = '" . $this->db->escape($data['email']). "', emailuniversity = '" . $this->db->escape($data['emailuniversity']) . "', gender = '" . $this->db->escape($data['gender_id']) . "', id_num = '" . $this->db->escape($data['id_num']) . /*"', id_date = '" . $this->db->escape($inputdate) . */"', date_of_birth = '" . $this->db->escape($inputdateofbirth) . /*"', id_location = '" . $this->db->escape($data['id_location']) . /*"',university = '" . $this->db->escape($data['university_id']) . "',faculty = '" . $this->db->escape($data['faculty_id']) */"',student_id = '" . $this->db->escape($data['student_id']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', salt = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "', newsletter = '" . (isset($data['newsletter']) ? (int)$data['newsletter'] : 0) . "', customer_group_id = '" . (int)$customer_group_id . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) ."', field = '" . (int)$data['policy'] ./*"', diencs1 = '" . (bool)$data['agree1']."', diencs2 = '" . (bool)$data['agree2']."', diencs3 = '" . (bool)$data['agree3']."', diencs4 = '" . (bool)$data['agree4']."', diencs5 = '" . (bool)$data['agree5']."', diencs6 = '" . (bool)$data['agree6']."', diencs7 = '" . (bool)$data['agree7']."', diencs8 = '" . (bool)$data['agree8'] .*/"', reason = '" . $this->db->escape($data['reason'])."', portrait = '" . $this->db->escape($data['portrait']). "', status = '1', approved = '" . (int)!$customer_group_info['approval'] . "', date_added = NOW()");
		
		$customer_id = $this->db->getLastId();
		
		//update NK University
		if((int)$data['university_id'] == (int)$NKUniversity) {
			$this->db->query("UPDATE " . DB_PREFIX . "customer SET student_id = 'NK" . (int)$customer_id . "' WHERE customer_id = '" . (int)$customer_id . "'");
		}
      	// end changing
		
			
      	$this->db->query("INSERT INTO " . DB_PREFIX . "address SET customer_id = '" . (int)$customer_id . "', firstname = '" . $this->db->escape($data['fullname'])/*$this->db->escape($data['firstname'])*/ /*. "', lastname = '" . $this->db->escape($data['lastname']) . "', sonha1 = '" . $this->db->escape($data['address_0']) ."', duong1 = '" . $this->db->escape($data['address_1'])*/ ."', diachi1 = '" . $this->db->escape($data['address_1']). "', phuongxa1 = '" . $this->db->escape($data['address_2']) . "', quanhuyen1 = '" . $this->db->escape($data['address_3']) . "', thanhpho1 = '" . $this->db->escape($data['address_4']) /*. "', sonha2 = '" . $this->db->escape($data['address_5']) ."', duong2 = '" . $this->db->escape($data['address_6']) ."', diachi2 = '" . $this->db->escape($data['address_6']) . "', phuongxa2 = '" . $this->db->escape($data['address_7']) . "', quanhuyen2 = '" . $this->db->escape($data['address_8']) . "', thanhpho2 = '" . $this->db->escape($data['address_9'])*/ ."', country_id = '" . (int)$data['country_id'] . /*"', zone_id = '" . (int)$data['zone_id'] .*/ "'");
		
		$address_id = $this->db->getLastId();

      	$this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . (int)$address_id . "' WHERE customer_id = '" . (int)$customer_id . "'");
		
		//random barcode
		$random_barcode = rand(1000000000, 9999999999);
		
		$customer = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "'");
		
		$student_id = $customer->row['student_id'];
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "file_to_student SET student_id = '" . $student_id . "' AND file_code = '" . $random_barcode . "'");
		//end barcode

        //student receive
        $period = $this->db->query("SELECT * FROM " . DB_PREFIX . "student_receive_period WHERE `is_apply` = '1'");
        $this->db->query("INSERT INTO " . DB_PREFIX . "student_receive SET student_id = '" . $student_id . "', `student_status` = '0', `recurring` = '0', `period` = '" . $period->row['period_id'] . "'");
		
		$this->language->load('mail/customer');
		
		$subject = sprintf($this->language->get('text_subject'), $this->config->get('config_name'));
		
		$message = sprintf($this->language->get('text_welcome'), $this->config->get('config_name')) . "\n\n";
		
		if (!$customer_group_info['approval']) {
			$message .= $this->language->get('text_login') . "\n";
		} else {
			$message .= $this->language->get('text_approval') . "\n";
		}
		
		$message .= $this->url->link('account/login', '', 'SSL') . "\n\n";
		$message .= $this->language->get('text_services') . "\n\n";
		$message .= $this->language->get('text_thanks') . "\n";
		$message .= $this->config->get('config_name');
		
		$mail = new Mail();
		$mail->protocol = $this->config->get('config_mail_protocol');
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->hostname = $this->config->get('config_smtp_host');
		$mail->username = $this->config->get('config_smtp_username');
		$mail->password = $this->config->get('config_smtp_password');
		$mail->port = $this->config->get('config_smtp_port');
		$mail->timeout = $this->config->get('config_smtp_timeout');				
		$mail->setTo($data['email']);
		$mail->setFrom($this->config->get('config_email'));
		$mail->setSender($this->config->get('config_name'));
		$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
		$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
		$mail->send();
		
		// Send to main admin email if new account email is enabled
		if ($this->config->get('config_account_mail')) {
			$message  = $this->language->get('text_signup') . "\n\n";
			$message .= $this->language->get('text_website') . ' ' . $this->config->get('config_name') . "\n";
			$message .= $this->language->get('text_firstname') . ' ' . $data['firstname'] . "\n";
			$message .= $this->language->get('text_lastname') . ' ' . $data['lastname'] . "\n";
			$message .= $this->language->get('text_customer_group') . ' ' . $customer_group_info['name'] . "\n";
			
			if ($data['company']) {
				$message .= $this->language->get('text_company') . ' '  . $data['company'] . "\n";
			}
			
			$message .= $this->language->get('text_email') . ' '  .  $data['email'] . "\n";
			$message .= $this->language->get('text_telephone') . ' ' . $data['telephone'] . "\n";
			
			$mail->setTo($this->config->get('config_email'));
			$mail->setSubject(html_entity_decode($this->language->get('text_new_customer'), ENT_QUOTES, 'UTF-8'));
			$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
			$mail->send();
			
			// Send to additional alert emails if new account email is enabled
			$emails = explode(',', $this->config->get('config_alert_emails'));
			
			foreach ($emails as $email) {
				if (strlen($email) > 0 && preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $email)) {
					$mail->setTo($email);
					$mail->send();
				}
			}
		}
	}
	
	public function editCustomer($data) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "' WHERE customer_id = '" . (int)$this->customer->getId() . "'");
	}

	public function editPassword($email, $password) {
      	$this->db->query("UPDATE " . DB_PREFIX . "customer SET salt = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($password)))) . "' WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
	}

	public function editNewsletter($newsletter) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET newsletter = '" . (int)$newsletter . "' WHERE customer_id = '" . (int)$this->customer->getId() . "'");
	}
					
	public function getCustomer($customer_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "'");
		
		return $query->row;
	}
	
	public function getCustomerByEmail($email) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
		
		return $query->row;
	}
		
	public function getCustomerByToken($token) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE token = '" . $this->db->escape($token) . "' AND token != ''");
		
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET token = ''");
		
		return $query->row;
	}
		
	public function getCustomers($data = array()) {
		$sql = "SELECT *, CONCAT(c.firstname, ' ', c.lastname) AS name, cg.name AS customer_group FROM " . DB_PREFIX . "customer c LEFT JOIN " . DB_PREFIX . "customer_group cg ON (c.customer_group_id = cg.customer_group_id) ";

		$implode = array();
		
		if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
			$implode[] = "LCASE(CONCAT(c.firstname, ' ', c.lastname)) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
		}
		
		if (isset($data['filter_email']) && !is_null($data['filter_email'])) {
			$implode[] = "LCASE(c.email) = '" . $this->db->escape(utf8_strtolower($data['filter_email'])) . "'";
		}
		
		if (isset($data['filter_customer_group_id']) && !is_null($data['filter_customer_group_id'])) {
			$implode[] = "cg.customer_group_id = '" . $this->db->escape($data['filter_customer_group_id']) . "'";
		}	
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "c.status = '" . (int)$data['filter_status'] . "'";
		}	
		
		if (isset($data['filter_approved']) && !is_null($data['filter_approved'])) {
			$implode[] = "c.approved = '" . (int)$data['filter_approved'] . "'";
		}	
			
		if (isset($data['filter_ip']) && !is_null($data['filter_ip'])) {
			$implode[] = "c.customer_id IN (SELECT customer_id FROM " . DB_PREFIX . "customer_ip WHERE ip = '" . $this->db->escape($data['filter_ip']) . "')";
		}	
				
		if (isset($data['filter_date_added']) && !is_null($data['filter_date_added'])) {
			$implode[] = "DATE(c.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}
		
		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}
		
		$sort_data = array(
			'name',
			'c.email',
			'customer_group',
			'c.status',
			'c.ip',
			'c.date_added'
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
		
	public function getTotalCustomersByEmail($email) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
		
		return $query->row['total'];
	}
	
	public function getIps($customer_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer_ip` WHERE customer_id = '" . (int)$customer_id . "'");
		
		return $query->rows;
	}	
	
	public function isBanIp($ip) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer_ban_ip` WHERE ip = '" . $this->db->escape($ip) . "'");
		
		return $query->num_rows;
	}	
}
?>
