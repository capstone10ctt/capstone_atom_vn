<?php
class ModelPriceStandard extends Model {
    
    //start vlmn modification
	public function getElectricityLastestLifeTime() {
        $query1 = $this->db->query('SELECT MAX(`from`) as `from` FROM e_lifetime');
		$query2 = $this->db->query("SELECT * FROM e_lifetime WHERE `from` = '" . $query1->row['from']. "'");
        return $query2->row;
    }
	//end vlmn modification
    
    public function getElectricityStandardPrice($id) {
        $query = $this->db->query('SELECT `From`, `To`, Price FROM e_standard WHERE id = "' . $id . '"');
        return $query->rows;
    }

    public function getElectricityLastModified() {
        $query = $this->db->query("SELECT `id` FROM e_lifetime ORDER BY `id` DESC LIMIT 1");
        return $query->row;
    }

    public function getElectricityLastModifiedList() {
        $query = $this->db->query("SELECT DISTINCT `id`, `from`, `to` FROM e_lifetime ORDER BY `id` DESC");
        return $query->rows;
    }

    public function getLatestElectricityUpdateDate() {
        $query = $this->db->query("SELECT MONTH(`from`) AS Month, YEAR(`from`) AS Year FROM e_lifetime ORDER BY YEAR(`from`) DESC, MONTH(`from`) DESC LIMIT 1");
        return $query->row;
    }

    public function deleteCurrentElectricityStandardPrice($id) {
        $this->db->query('DELETE FROM e_standard WHERE `id` = "' . $id . '"');
        $this->db->query('DELETE FROM e_lifetime WHERE `id` = "' . $id . '"');
        $lastRow = $this->db->query('SELECT `id` FROM e_lifetime ORDER BY `id` DESC LIMIT 1')->row;
        $this->db->query('UPDATE e_lifetime SET `to` = null WHERE `id` = "' . $lastRow['id'] . '"');
    }

    public function getCurrentApplyDateElectricity() {
        $query = $this->db->query('SELECT `From` FROM e_lifetime WHERE `apply` = "1"');
        return $query->row;
    }
    //==================================================================================================================
    //start vlmn modification
	public function getWaterLastestLifeTime() {
        $query1 = $this->db->query('SELECT MAX(`from`) as `from` FROM w_lifetime');
		$query2 = $this->db->query("SELECT * FROM w_lifetime WHERE `from` = '" . $query1->row['from'] . "'");
		
        return $query2->row;
    }
	//end vlmn modification
    public function getWaterStandardPrice($id) {
        $query = $this->db->query('SELECT `From`, `To`, Price FROM w_standard WHERE id = "' . $id . '"');
        return $query->rows;
    }

    public function getWaterLastModified() {
        $query = $this->db->query("SELECT `id` FROM w_lifetime ORDER BY `id` DESC LIMIT 1");
        return $query->row;
    }

    public function getWaterLastModifiedList() {
        $query = $this->db->query("SELECT DISTINCT `id`, `from`, `to` FROM w_lifetime ORDER BY `id` DESC");
        return $query->rows;
    }

    public function getLatestWaterUpdateDate() {
        $query = $this->db->query("SELECT MONTH(`from`) AS Month, YEAR(`from`) AS Year FROM w_lifetime ORDER BY YEAR(`from`) DESC, MONTH(`from`) DESC LIMIT 1");
        return $query->row;
    }

    public function deleteCurrentWaterStandardPrice($id) {
        $this->db->query('DELETE FROM w_standard WHERE `id` = "' . $id . '"');
        $this->db->query('DELETE FROM w_lifetime WHERE `id` = "' . $id . '"');
        $lastRow = $this->db->query('SELECT `id` FROM w_lifetime ORDER BY `id` DESC LIMIT 1')->row;
        $this->db->query('UPDATE w_lifetime SET `to` = null WHERE `id` = "' . $lastRow['id'] . '"');
    }

    public function getCurrentApplyDateWater() {
        $query = $this->db->query('SELECT `From` FROM w_lifetime WHERE `apply` = "1"');
        return $query->row;
    }
    //==================================================================================================================
    public function getGarbageStandardPrice($id) {
        $query = $this->db->query('SELECT Price FROM g_standard WHERE id = "' . $id . '"');
        return $query->rows;
    }

    public function getGarbageLastModified() {
        $query = $this->db->query("SELECT `id` FROM g_lifetime ORDER BY `id` DESC LIMIT 1");
        return $query->row;
    }

    public function getGarbageLastModifiedList() {
        $query = $this->db->query("SELECT DISTINCT `id`, `from`, `to` FROM g_lifetime ORDER BY `id` DESC");
        return $query->rows;
    }

    public function getLatestGarbageUpdateDate() {
        $query = $this->db->query("SELECT MONTH(`from`) AS Month, YEAR(`from`) AS Year FROM g_lifetime ORDER BY YEAR(`from`) DESC, MONTH(`from`) DESC LIMIT 1");
        return $query->row;
    }

    public function deleteCurrentGarbageStandardPrice($id) {
        $this->db->query('DELETE FROM g_standard WHERE `id` = "' . $id . '"');
        $this->db->query('DELETE FROM g_lifetime WHERE `id` = "' . $id . '"');
        $lastRow = $this->db->query('SELECT `id` FROM g_lifetime ORDER BY `id` DESC LIMIT 1')->row;
        $this->db->query('UPDATE g_lifetime SET `to` = null WHERE `id` = "' . $lastRow['id'] . '"');
    }

    public function getCurrentApplyDateGarbage() {
        $query = $this->db->query('SELECT `From` FROM g_lifetime WHERE `apply` = "1"');
        return $query->row;
    }
}
?>