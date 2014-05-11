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