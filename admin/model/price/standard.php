<?php
class ModelPriceStandard extends Model {

    public function getWaterStandardPrice() {
        $query = $this->db->query("SELECT `From`, `To`, Price FROM w_standard");
        return $query->rows;
    }

    public function getElectricityStandardPrice() {
        $query = $this->db->query("SELECT `From`, `To`, Price FROM e_standard");
        return $query->rows;
    }

}
?>