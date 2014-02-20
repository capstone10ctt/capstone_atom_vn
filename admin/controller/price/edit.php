<?php
class ControllerPriceEdit extends Controller {

    public function index() {
        $this->language->load('price/standard');
        $this->load->model('price/standard');
        $this->data['token'] = $this->session->data['token'];

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

        // store date_added values for display purpose in View part
        $this->data['electricity_last_modified'] = $electricity_last_modified['date_added'];
        $this->data['water_last_modified'] = $water_last_modified['date_added'];
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
        $this->data['last_modified'] = $this->language->get('last_modified');
        // set default page for view
        $this->template = 'price/edit.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );
        $this->response->setOutput($this->render());
    }

    public function loadElectricityStandardPrice($e_date = '') {
        // remember to put this line or $this->model_price_standard will be NULL when call this function from ajax for the 2nd time
        $this->load->model('price/standard');

        $json = array();
        if (!empty($this->request->post['e_date'])) {
            $e_date = $this->request->post['e_date'];
        }
        $e_standard = $this->model_price_standard->getElectricityStandardPrice($e_date);
        foreach ($e_standard as $row) {
            $this->data['e_standard'][] = array(
                'From' => $row['From'],
                'To'       => $row['To'],
                'Price' => $row['Price']
            );
        }
        // set 'success' string in order to send back to the View
        $json['success'] = 'success';
        $json['data'] = $e_standard;
        $this->response->setOutput(json_encode($json));
    }

    public function loadWaterStandardPrice($w_date = '') {
        // remember to put this line or $this->model_price_standard will be NULL when call this function from ajax for the 2nd time
        $this->load->model('price/standard');

        $json = array();
        if (!empty($this->request->post['w_date'])) {
            $w_date = $this->request->post['w_date'];
        }
        $w_standard = $this->model_price_standard->getWaterStandardPrice($w_date);
        foreach ($w_standard as $row) {
            $this->data['w_standard'][] = array(
                'From' => $row['From'],
                'To' => $row['To'],
                'Price' => $row['Price']
            );
        }
        // set 'success' string in order to send back to the View
        $json['success'] = 'success';
        $json['data'] = $w_standard;
        $this->response->setOutput(json_encode($json));
    }

    public function updateStandardPrice() {
        $json = array();
        if (!empty($this->request->post['update_date']) &&
            !empty($this->request->post['e_modified_date']) &&
            !empty($this->request->post['electricity_new_data']) &&
            !empty($this->request->post['w_modified_date']) &&
            !empty($this->request->post['water_new_data'])) {
            // retrieve passed data from View and stores it in variables
            $updateDate = $this->request->post['update_date'];
            $eModifiedDate = $this->request->post['e_modified_date'];
            $electricity_new_data = $this->request->post['electricity_new_data'];
            $wModifiedDate = $this->request->post['w_modified_date'];
            $water_new_data = $this->request->post['water_new_data'];
            // update table
            $this->db->query('DELETE FROM e_standard WHERE `date_added` = "' . $eModifiedDate . '"');
            foreach ($electricity_new_data['electricity_new'] as $data) {
                $this->db->query('INSERT INTO e_standard (`date_added`, `From`, `To`, `Price`) VALUES ("' . $updateDate . '", "' . $data['from'] . '", "' . $data['to'] . '", "' . $data['price'] .'")');
            }

            $this->db->query('DELETE FROM w_standard WHERE `date_added` = "' . $wModifiedDate . '"');
            foreach ($water_new_data['water_new'] as $data) {
                $this->db->query('INSERT INTO w_standard (`date_added`, `From`, `To`, `Price`) VALUES ("' . $updateDate . '", "' . $data['from'] . '", "' . $data['to'] . '", "' . $data['price'] .'")');
            }
            // set 'success' string in order to send back to the View
            $json['success'] = 'success';
        }
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