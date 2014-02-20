<?php
class ModelPriceStandard extends Model {

    public function getElectricityStandardPrice($e_date) {
        $query = $this->db->query('SELECT `From`, `To`, Price FROM e_standard WHERE date_added = "' . $e_date . '"');
        return $query->rows;
    }

    public function getWaterStandardPrice($w_date) {
        $query = $this->db->query('SELECT `From`, `To`, Price FROM w_standard WHERE date_added = "' . $w_date . '"');
        return $query->rows;
    }

    public function getWaterLastModified() {
        $query = $this->db->query("SELECT date_added FROM w_standard ORDER BY date_added DESC LIMIT 1");
        return $query->row;
    }

    public function getWaterLastModifiedList() {
        $query = $this->db->query("SELECT DISTINCT date_added FROM w_standard ORDER BY date_added DESC");
        return $query->rows;
    }

    public function getElectricityLastModified() {
        $query = $this->db->query("SELECT date_added FROM e_standard ORDER BY date_added DESC LIMIT 1");
        return $query->row;
    }

    public function getElectricityLastModifiedList() {
        $query = $this->db->query("SELECT DISTINCT date_added FROM e_standard ORDER BY date_added DESC");
        return $query->rows;
    }
}
?>