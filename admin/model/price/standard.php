<?php
class ModelPriceStandard extends Model {

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
    //==================================================================================================================
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
}
?>