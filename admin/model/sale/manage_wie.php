<?php
class ModelSaleManageWie extends Model {
	public function addCustomerGroup($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "customer_group SET approval = '" . (int)$data['approval'] . "', company_id_display = '" . (int)$data['company_id_display'] . "', company_id_required = '" . (int)$data['company_id_required'] . "', tax_id_display = '" . (int)$data['tax_id_display'] . "', tax_id_required = '" . (int)$data['tax_id_required'] . "', sort_order = '" . (int)$data['sort_order'] . "'");
	
		$customer_group_id = $this->db->getLastId();
		
		foreach ($data['customer_group_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "customer_group_description SET customer_group_id = '" . (int)$customer_group_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}	
	}
	
	public function editCustomerGroup($customer_group_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer_group SET approval = '" . (int)$data['approval'] . "', company_id_display = '" . (int)$data['company_id_display'] . "', company_id_required = '" . (int)$data['company_id_required'] . "', tax_id_display = '" . (int)$data['tax_id_display'] . "', tax_id_required = '" . (int)$data['tax_id_required'] . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE customer_group_id = '" . (int)$customer_group_id . "'");
	
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_group_description WHERE customer_group_id = '" . (int)$customer_group_id . "'");

		foreach ($data['customer_group_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "customer_group_description SET customer_group_id = '" . (int)$customer_group_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}
	}
	
	public function deleteCustomerGroup($customer_group_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_group WHERE customer_group_id = '" . (int)$customer_group_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_group_description WHERE customer_group_id = '" . (int)$customer_group_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE customer_group_id = '" . (int)$customer_group_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE customer_group_id = '" . (int)$customer_group_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_reward WHERE customer_group_id = '" . (int)$customer_group_id . "'");
	}
	
	public function inputElectricHistory($data) {
		$date = new DateTime();
		$date->setDate($data['year'], $data['month'], 1);
		$date_final = $date->format('Y-m-d');
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "e_record SET date_added = '" . $date_final . "', RoomID = '" . (int)$data['room_id'] . "', Start = '" . (int)$data['start_num'] . "', End = '" . (int)$data['end_num'] . "', date_modified = NOW()");
	}
	
	public function inputWaterHistory($data) {
		$date = new DateTime();
		$date->setDate($data['year'], $data['month'], 1);
		$date_final = $date->format('Y-m-d');
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "w_record SET date_added = '" . $date_final . "', RoomID = '" . (int)$data['room_id'] . "', Start = '" . (int)$data['start_num'] . "', End = '" . (int)$data['end_num'] . "', date_modified = NOW()");
	}
	
	public function getElectricLogByRoomId($month, $year, $room_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "e_record WHERE `RoomID` = '" . (int)$room_id . "' AND MONTH(date_added) = '" . $month . "' AND YEAR(date_added) = '" . $year . "'");
		
		return $query->rows;
	}
	
	public function getWaterLogByRoomId($month, $year,$room_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "w_record WHERE `RoomID` = '" . (int)$room_id . "' AND MONTH(date_added) = '" . $month . "' AND YEAR(date_added) = '" . $year . "'");
		
		return $query->rows;
	}
	
	public function getMonthHasData($room_id) {
		$query = $this->db->query("SELECT MONTH(date_added) as month, YEAR(date_added) as year FROM " . DB_PREFIX . "w_record WHERE `RoomID` = '" . $room_id . "' GROUP BY month, year  ORDER BY date_added desc");
		
		return $query->rows;
	}
		
	public function getCustomerGroup($customer_group_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customer_group cg LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (cg.customer_group_id = cgd.customer_group_id) WHERE cg.customer_group_id = '" . (int)$customer_group_id . "' AND cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row;
	}
	
	public function getCustomerGroups($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "customer_group cg LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (cg.customer_group_id = cgd.customer_group_id) WHERE cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
		$sort_data = array(
			'cgd.name',
			'cg.sort_order'
		);	
			
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY cgd.name";	
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
	
	public function getCustomerGroupDescriptions($customer_group_id) {
		$customer_group_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_group_description WHERE customer_group_id = '" . (int)$customer_group_id . "'");
				
		foreach ($query->rows as $result) {
			$customer_group_data[$result['language_id']] = array(
				'name'        => $result['name'],
				'description' => $result['description']
			);
		}
		
		return $customer_group_data;
	}
		
	public function getTotalCustomerGroups() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer_group");
		
		return $query->row['total'];
	}
}
?>