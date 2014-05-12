<?php
class ControllerFeeFee extends Controller {

    public function index() {
        $this->language->load('fee/fee');
        $this->load->model('fee/fee');
        $this->data['token'] = $this->session->data['token'];

        // load text
        $this->data['column_fee_name'] = $this->language->get('column_fee_name');
        $this->data['column_fee'] = $this->language->get('column_fee');
        $this->data['button_confirm'] = $this->language->get('button_confirm');
        $this->data['description_fee'] = $this->language->get('description_fee');

        $this->template = 'fee/fee.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );
        $this->response->setOutput($this->render());
    }

    public function loadFee() {
        $this->load->model('fee/fee');
        $json = array();

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $currentDate = date('Y-m-d H:i:s');
        $fee = $this->model_fee_fee->loadFee($currentDate);

        // set 'success' string in order to send back to the View
        $json['success'] = 'success';
        $json['fee'] = $fee;
        $this->response->setOutput(json_encode($json));
    }

    public function updateFee() {
        $this->load->model('fee/fee');

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $currentDate = date('Y-m-d H:i:s');
        $data = $this->request->post['fee_new'];
        $fee = $this->model_fee_fee->updateFee($currentDate, $data);
    }

    public function newAdmission() {
        $this->load->model('fee/fee');
        $this->load->language('fee/fee');
        $this->data['token'] = $this->session->data['token'];

        // load text
        $this->data['button_confirm'] = $this->language->get('button_confirm');
        $this->data['button_cancel'] = $this->language->get('button_cancel');
        $this->data['button_edit'] = $this->language->get('button_edit');

        $this->data['description_apply'] = $this->language->get('description_apply');
        $this->data['text_from_date'] = $this->language->get('text_from_date');
        $this->data['text_to_date'] = $this->language->get('text_to_date');

        $this->data['description_stay_time'] = $this->language->get('description_stay_time');
        $this->data['text_number_of_month'] = $this->language->get('text_number_of_month');

        $this->data['description_pay'] = $this->language->get('description_pay');
        $this->data['description_fee'] = $this->language->get('description_fee');
        $this->data['column_fee_name'] = $this->language->get('column_fee_name');
        $this->data['column_fee'] = $this->language->get('column_fee');

        $this->data['description_quantity'] = $this->language->get('description_quantity');
        $this->data['column_quantity_school'] = $this->language->get('column_quantity_school');
        $this->data['column_quantity_male'] = $this->language->get('column_quantity_male');
        $this->data['column_quantity_female'] = $this->language->get('column_quantity_female');

        $this->template = 'fee/new.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );
        $this->response->setOutput($this->render());
    }

    public function loadQuantity() {
        $this->load->model('fee/fee');

        $json = array();
        $json['quantity'] = $this->model_fee_fee->loadQuantity();
        $this->response->setOutput(json_encode($json));
    }

    public function updateFeeManagement() {
        $this->load->model('fee/fee');

        $applyFromDate = $this->request->post['apply-from-date'];
        $applyToDate = $this->request->post['apply-to-date'];
        $payFromDate = $this->request->post['pay-from-date'];
        $payToDate = $this->request->post['pay-to-date'];
        $numMonth = $this->request->post['num-of-month'];
        $this->model_fee_fee->updateFeeManagement($applyFromDate, $applyToDate, $payFromDate, $payToDate, $numMonth);
    }

    public function getApplyFromDate() {
        $this->load->model('fee/fee');
        $json = array();

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $currentDate = date('Y-m-d H:i:s');
        $json['apply-from-date'] = $this->model_fee_fee->getApplyFromDate($currentDate);
        $this->response->setOutput(json_encode($json));
    }

    public function getApplyToDate() {
        $this->load->model('fee/fee');
        $json = array();

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $currentDate = date('Y-m-d H:i:s');
        $json['apply-to-date'] = $this->model_fee_fee->getApplyToDate($currentDate);
        $this->response->setOutput(json_encode($json));
    }

    public function getPayFromDate() {
        $this->load->model('fee/fee');
        $json = array();

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $currentDate = date('Y-m-d H:i:s');
        $json['pay-from-date'] = $this->model_fee_fee->getPayFromDate($currentDate);
        $this->response->setOutput(json_encode($json));
    }

    public function getPayToDate() {
        $this->load->model('fee/fee');
        $json = array();

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $currentDate = date('Y-m-d H:i:s');
        $json['pay-to-date'] = $this->model_fee_fee->getPayToDate($currentDate);
        $this->response->setOutput(json_encode($json));
    }

    public function getNumberOfMonth() {
        $this->load->model('fee/fee');
        $json = array();

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $currentDate = date('Y-m-d H:i:s');
        $json['number-of-month'] = $this->model_fee_fee->getNumberOfMonth($currentDate);
        $this->response->setOutput(json_encode($json));
    }

    public function viewHistory() {
        $this->load->model('fee/fee');
        $this->load->language('fee/fee');
        $this->data['token'] = $this->session->data['token'];

        // load text
        $this->data['button_new'] = $this->language->get('button_new');
        $this->data['button_edit'] = $this->language->get('button_edit');

        $this->data['description_apply'] = $this->language->get('description_apply');
        $this->data['text_from_date'] = $this->language->get('text_from_date');
        $this->data['text_to_date'] = $this->language->get('text_to_date');

        $this->data['description_stay_time'] = $this->language->get('description_stay_time');
        $this->data['text_number_of_month'] = $this->language->get('text_number_of_month');

        $this->data['description_pay'] = $this->language->get('description_pay');
        $this->data['description_fee'] = $this->language->get('description_fee');
        $this->data['column_fee_name'] = $this->language->get('column_fee_name');
        $this->data['column_fee'] = $this->language->get('column_fee');

        $this->data['description_quantity'] = $this->language->get('description_quantity');
        $this->data['column_quantity_school'] = $this->language->get('column_quantity_school');
        $this->data['column_quantity_male'] = $this->language->get('column_quantity_male');
        $this->data['column_quantity_female'] = $this->language->get('column_quantity_female');

        $this->template = 'fee/history.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );
        $this->response->setOutput($this->render());
    }

    public function getPeriodList() {
        $this->load->model('fee/fee');

        $json = array();
        $json['period-list'] = $this->model_fee_fee->getPeriodList();;
        $this->response->setOutput(json_encode($json));
    }

    public function loadManagementInfo() {
        $this->load->model('fee/fee');

        $json = array();
        $period_id = $this->request->post['period_id'];
        if (sizeof($this->model_fee_fee->checkApply($period_id)) != 0) {
            $json['is_apply'] = 1;
        } else {
            $json['is_apply'] = 0;
        }
        $json['apply-from-date'] = $this->model_fee_fee->getApplyFromDateWithPeriodId($period_id);
        $json['apply-to-date'] = $this->model_fee_fee->getApplyToDateWithPeriodId($period_id);
        $json['pay-from-date'] = $this->model_fee_fee->getPayFromDateWithPeriodId($period_id);
        $json['pay-to-date'] = $this->model_fee_fee->getPayToDateWithPeriodId($period_id);
        $json['number-of-month'] = $this->model_fee_fee->getNumberOfMonthWithPeriodId($period_id);
        $json['fee-detail']= $this->model_fee_fee->loadFeeWithPeriodId($period_id);
        $json['quantity-detail'] = $this->model_fee_fee->loadQuantity();
        $this->response->setOutput(json_encode($json));
    }

    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'localisation/country')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 128)) {
            $this->error['name'] = $this->language->get('error_name');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

}
?>