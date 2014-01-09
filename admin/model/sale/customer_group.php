<?php
class ModelSaleCustomerGroup extends Model {
	public function addCustomerGroup($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "customer_group SET floor_id = '" . (int)$data['floor'] . "', max_student = '" . (int)$data['max_student'] . "', type_id = '" . (int)$data['type_id'] . "'");
	
		$customer_group_id = $this->db->getLastId();
		
		foreach ($data['customer_group_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "customer_group_description SET customer_group_id = '" . (int)$customer_group_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "'");		
		}	
	}
	
	public function editCustomerGroup($customer_group_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer_group SET max_student = '" . (int)$data['max_student'] . "', type_id = '" . (int)$data['type_id'] . "' WHERE customer_group_id = '" . (int)$customer_group_id . "'");
	
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_group_description WHERE customer_group_id = '" . (int)$customer_group_id . "'");

		foreach ($data['customer_group_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "customer_group_description SET customer_group_id = '" . (int)$customer_group_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}
	}
	
	public function deleteCustomerGroup($customer_group_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_group WHERE customer_group_id = '" . (int)$customer_group_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_group_description WHERE customer_group_id = '" . (int)$customer_group_id . "'");
	}
	
	public function getCustomerGroup($customer_group_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customer_group cg LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (cg.customer_group_id = cgd.customer_group_id) LEFT JOIN " . DB_PREFIX . "room_type rt ON ( cg.type_id = rt.type_id AND cgd.language_id = rt.language_id ) WHERE cg.customer_group_id = '" . (int)$customer_group_id . "' AND cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row;
	}

	
	public function getCustomerGroups($data = array()) {
		$sql = "SELECT *, (SELECT COUNT( * ) FROM " . DB_PREFIX . "customer c WHERE c.customer_group_id = cg.customer_group_id) AS assigned FROM " . DB_PREFIX . "customer_group cg LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (cg.customer_group_id = cgd.customer_group_id) LEFT JOIN " . DB_PREFIX . "room_type rt ON ( cg.type_id = rt.type_id AND cgd.language_id = rt.language_id ) WHERE cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
		$sort_data = array(
			'cgd.name',
			'cg.sort_order'
		);	
		if (isset($data['floor']))
		{
			$sql .= " AND floor_id=" . $data['floor'];	
		}
			
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

	public function getBlocks() {
		$sql = "SELECT * FROM " . DB_PREFIX . "block b LEFT JOIN " . DB_PREFIX . "block_description bd ON(b.block_id = bd.block_id) WHERE bd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
		$query = $this->db->query($sql);
		
		return $query->rows;
	}

	public function getFloors($block) {
		$sql = "SELECT * FROM " . DB_PREFIX . "floor f LEFT JOIN " . DB_PREFIX . "floor_description fd ON(f.floor_id = fd.floor_id) WHERE fd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND block_id=". $block;
		
		$query = $this->db->query($sql);
		
		return $query->rows;
	}

	public function getFloor($floor_id) {
		$sql = "SELECT * FROM " . DB_PREFIX . "floor_description fd WHERE fd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND floor_id=". $floor_id;
		
		$query = $this->db->query($sql);
		
		$result = $query->row;
		return $result['floor_name'];
	}

	public function getFloorByRoom($room_id) {
		$sql = "SELECT * FROM " . DB_PREFIX . "floor_description fd LEFT JOIN " . DB_PREFIX . "customer_group cg ON(fd.floor_id=cg.floor_id) WHERE fd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND customer_group_id=". $room_id;
		
		$query = $this->db->query($sql);
		
		$result = $query->row;
		return $result['floor_name'];
	}

	public function getTypes() {
		$sql = "SELECT * FROM " . DB_PREFIX . "room_type WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
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