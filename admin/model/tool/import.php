<?php
class ModelToolImport extends Model {
	public function getRoomList() {
		$query = $this->db->query("SELECT DISTINCT name FROM " . DB_PREFIX . "customer_group");
		$list = array();
		foreach($query->rows as $row) {
    		$list[] =  $row['name'];  
		}

		return $list;
	}
}
?>