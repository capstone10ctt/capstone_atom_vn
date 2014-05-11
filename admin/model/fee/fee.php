<?php
class ModelFeeFee extends Model {

    public function loadFee($currentDate) {
        $query = $this->db->query('SELECT `name`, `price` FROM fee t1 INNER JOIN student_receive_period_detail t2 ON t1.fee_id = t2.fee_id INNER JOIN student_receive_period t3 ON t2.student_receive_period_id = t3.period_id WHERE t3.period_start <= "'. $currentDate . '" AND "' . $currentDate . '" <= t3.period_end');
        return $query->rows;
    }

    public function updateFee($currentDate, $data) {
        // get fee_id
        $feeId = $this->db->query('SELECT t1.fee_id FROM student_receive_period_detail t1 INNER JOIN student_receive_period t2 ON t1.student_receive_period_id = t2.period_id WHERE t2.period_start <= "'. $currentDate . '" AND "' . $currentDate . '" <= t2.period_end')->row['fee_id'];
        $this->db->query('DELETE FROM fee WHERE fee_id = ' . $feeId);
        foreach ($data as $row) {
            $this->db->query('INSERT INTO fee(fee_id,name,price) VALUES (' . $feeId . ', "' . $row['name'] . '", ' . $row['price'] . ')');
        }
    }
}
?>