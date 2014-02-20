<?php
class ControllerPriceStandard extends Controller {

    public function index() {
        $this->language->load('price/standard');
        $this->load->model('price/standard');

        $this->getStandardPrice();
    }

    protected function getStandardPrice() {
        $electricity_last_modified = $this->model_price_standard->getElectricityLastModified();
        $electricity_last_modified_list = $this->model_price_standard->getElectricityLastModifiedList();

        $water_last_modified = $this->model_price_standard->getWaterLastModified();
        $water_last_modified_list = $this->model_price_standard->getWaterLastModifiedList();

        // put modified date list into variable 'electricity_last_modified_list' & `water_last_modified_list`
        foreach ($electricity_last_modified_list as $row) {
            foreach ($row as $r) {
                $this->data['electricity_last_modified_list'][] = $r;
            }
        }
        foreach ($water_last_modified_list as $row) {
            foreach ($row as $r) {
                $this->data['water_last_modified_list'][] = $r;
            }
        }

        // load electricity standard price based on the provided date
        $this->loadElectricityStandardPrice($electricity_last_modified['date_added']);
        $this->loadWaterStandardPrice($water_last_modified['date_added']);
        // store values for display purpose in View part
        $this->data['text_electricity_from'] = $this->language->get('text_electricity_from');
        $this->data['text_electricity_to'] = $this->language->get('text_electricity_to');
        $this->data['text_electricity_price'] = $this->language->get('text_electricity_price');
        $this->data['text_water_from'] = $this->language->get('text_water_from');
        $this->data['text_water_to'] = $this->language->get('text_water_to');
        $this->data['text_water_price'] = $this->language->get('text_water_price');
        $this->data['note_1'] = $this->language->get('note_1');
        $this->data['description_electricity'] = $this->language->get('description_electricity');
        $this->data['description_water'] = $this->language->get('description_water');

        // set default page for view
        $this->template = 'price/standard.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    public function loadElectricityStandardPrice($e_date = '') {
        // remember to put this line or $this->model_price_standard will be NULL when call this function from ajax for the 2nd time
        $this->load->model('price/standard');

        $e_standard = $this->model_price_standard->getElectricityStandardPrice($e_date);
        foreach ($e_standard as $row) {
            $this->data['e_standard'][] = array(
                'From' => $row['From'],
                'To'       => $row['To'],
                'Price' => $row['Price']
            );
        }
    }

    public function loadWaterStandardPrice($w_date = '') {
        // remember to put this line or $this->model_price_standard will be NULL when call this function from ajax for the 2nd time
        $this->load->model('price/standard');

        $w_standard = $this->model_price_standard->getWaterStandardPrice($w_date);
        foreach ($w_standard as $row) {
            $this->data['w_standard'][] = array(
                'From' => $row['From'],
                'To' => $row['To'],
                'Price' => $row['Price']
            );
        }
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