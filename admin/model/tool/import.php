<?php
class ModelToolImport extends Model {
	public function restore($sql) {
		foreach (explode(";\n", $sql) as $sql) {
    		$sql = trim($sql);
    		
			if ($sql) {
      			$this->db->query($sql);
    		}
  		}
		
		$this->cache->delete('*');
	}
	
	
}
?>