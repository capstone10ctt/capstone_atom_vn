<?php
class ModelFeeFee extends Model {

    public function loadFee($currentDate) {
        $query = $this->db->query('SELECT `name`, `price` FROM fee t1 INNER JOIN student_receive_period_detail t2 ON t1.period_id = t2.student_receive_period_id INNER JOIN student_receive_period t3 ON t2.student_receive_period_id = t3.period_id WHERE t3.period_start <= "'. $currentDate . '" AND "' . $currentDate . '" <= t3.period_end');
        return $query->rows;
    }

    public function updateFee($currentDate, $data) {
        // get fee_id
        $feeId = $this->db->query('SELECT t1.fee_id FROM student_receive_period_detail t1 INNER JOIN student_receive_period t2 ON t1.student_receive_period_id = t2.period_id WHERE t2.period_start <= "'. $currentDate . '" AND "' . $currentDate . '" <= t2.period_end')->row['fee_id'];
        // delete existing data
        $this->db->query('DELETE FROM fee WHERE fee_id = ' . $feeId);
        // insert new data
        foreach ($data as $row) {
            $this->db->query('INSERT INTO fee(fee_id,name,price) VALUES (' . $feeId . ', "' . $row['name'] . '", ' . $row['price'] . ')');
        }
    }

    public function loadQuantity() {
        $query = $this->db->query('SELECT name, male_qty, female_qty FROM category_description');
        return $query->rows;
    }

    public function updateFeeManagement($applyFromDate, $applyToDate, $payFromDate, $payToDate, $numMonth) {
        $this->db->query('INSERT INTO student_receive_period(period_start, period_end, is_apply) VALUES ("' . date("Y-m-d H:i:s", strtotime($applyFromDate)) . '", "' . date("Y-m-d H:i:s", strtotime($payToDate)) . '", 0)');
        $this->db->query('INSERT INTO period_management(apply_from_date, apply_to_date, pay_from_date, pay_to_date, num_month) VALUES ("' . date("Y-m-d H:i:s", strtotime($applyFromDate)) . '", "' . date("Y-m-d H:i:s", strtotime($applyToDate)) . '", "' . date("Y-m-d H:i:s", strtotime($payFromDate)) . '", "' . date("Y-m-d H:i:s", strtotime($payToDate)) . '", ' . $numMonth . ')');
    }

    public function getApplyFromDate($currentDate) {
        $query = $this->db->query('SELECT apply_from_date FROM period_management t1 INNER JOIN student_receive_period t2 ON t1.period_id = t2.period_id WHERE t2.period_start <= "' . $currentDate . '" AND "' . $currentDate . '" <= t2.period_end');
        return $query->row['apply_from_date'];
    }

    public function getApplyToDate($currentDate) {
        $query = $this->db->query('SELECT apply_to_date FROM period_management t1 INNER JOIN student_receive_period t2 ON t1.period_id = t2.period_id WHERE t2.period_start <= "' . $currentDate . '" AND "' . $currentDate . '" <= t2.period_end');
        return $query->row['apply_to_date'];
    }

    public function getPayFromDate($currentDate) {
        $query = $this->db->query('SELECT pay_from_date FROM period_management t1 INNER JOIN student_receive_period t2 ON t1.period_id = t2.period_id WHERE t2.period_start <= "' . $currentDate . '" AND "' . $currentDate . '" <= t2.period_end');
        return $query->row['pay_from_date'];
    }

    public function getPayToDate($currentDate) {
        $query = $this->db->query('SELECT pay_to_date FROM period_management t1 INNER JOIN student_receive_period t2 ON t1.period_id = t2.period_id WHERE t2.period_start <= "' . $currentDate . '" AND "' . $currentDate . '" <= t2.period_end');
        return $query->row['pay_to_date'];
    }

    public function getNumberOfMonth($currentDate) {
        $query = $this->db->query('SELECT num_month FROM period_management t1 INNER JOIN student_receive_period t2 ON t1.period_id = t2.period_id WHERE t2.period_start <= "' . $currentDate . '" AND "' . $currentDate . '" <= t2.period_end');
        return $query->row['num_month'];
    }

    public function getPeriodList() {
        $query = $this->db->query('SELECT period_id, period_start, period_end, is_apply FROM student_receive_period');
        return $query->rows;
    }

    public function getApplyFromDateWithPeriodId($period_id) {
        $query = $this->db->query('SELECT apply_from_date FROM period_management t1 WHERE t1.period_id = ' . $period_id);
        return $query->row['apply_from_date'];
    }

    public function getApplyToDateWithPeriodId($period_id) {
        $query = $this->db->query('SELECT apply_to_date FROM period_management t1 WHERE t1.period_id = ' . $period_id);
        return $query->row['apply_to_date'];
    }

    public function getPayFromDateWithPeriodId($period_id) {
        $query = $this->db->query('SELECT pay_from_date FROM period_management t1 WHERE t1.period_id = ' . $period_id);
        return $query->row['pay_from_date'];
    }

    public function getPayToDateWithPeriodId($period_id) {
        $query = $this->db->query('SELECT pay_to_date FROM period_management t1 WHERE t1.period_id = ' . $period_id);
        return $query->row['pay_to_date'];
    }

    public function getNumberOfMonthWithPeriodId($period_id) {
        $query = $this->db->query('SELECT num_month FROM period_management t1 WHERE t1.period_id = ' . $period_id);
        return $query->row['num_month'];
    }

    public function checkApply($period_id) {
        $query = $this->db->query('SELECT COUNT(period_id) FROM student_receive_period WHERE is_apply = 1');
        return $query->row;
    }

    public function loadFeeWithPeriodId($period_id) {
        $query = $this->db->query('SELECT `name`, `price` FROM fee WHERE period_id = ' . $period_id);
        return $query->rows;
    }
}
?>