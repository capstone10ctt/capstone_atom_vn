<?php
class ModelLephiLephi extends Model {

    public function getLephiStandardPrice($id) {
        $query = $this->db->query('SELECT `name`, `price` FROM lephi_standard WHERE id = "' . $id . '"');
        return $query->rows;
    }

    public function getLephiLastModified() {
        $query = $this->db->query("SELECT `id` FROM lephi_lifetime ORDER BY `id` DESC LIMIT 1");
        return $query->row;
    }

    public function getLephiLastModifiedList() {
        $query = $this->db->query("SELECT DISTINCT `id`, `from`, `to` FROM lephi_lifetime ORDER BY `id` DESC");
        return $query->rows;
    }
}
?>