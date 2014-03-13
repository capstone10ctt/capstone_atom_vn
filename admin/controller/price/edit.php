<?php
class ControllerPriceEdit extends Controller {

    public function index() {
        $this->language->load('price/standard');
        $this->load->model('price/standard');
        $this->data['token'] = $this->session->data['token'];
        // add CSS
        $this->document->addStyle('view/stylesheet/price/style.css');

        $electricity_last_modified = $this->model_price_standard->getElectricityLastModified();
        $electricity_last_modified_list = $this->model_price_standard->getElectricityLastModifiedList();
        $water_last_modified = $this->model_price_standard->getWaterLastModified();
        $water_last_modified_list = $this->model_price_standard->getWaterLastModifiedList();
        // put modified date list into variable 'electricity_last_modified_list' & `water_last_modified_list`
        $this->data['electricity_last_modified_list'] = $electricity_last_modified_list;
        $this->data['water_last_modified_list'] = $water_last_modified_list;
        // load electricity standard price based on the provided date
        $this->loadElectricityStandardPrice($electricity_last_modified['id']);
        $this->loadWaterStandardPrice($water_last_modified['id']);
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

    public function loadNewestElectricityStandardPrice() {
        // remember to put this line or $this->model_price_standard will be NULL when call this function from ajax for the 2nd time
        $this->load->model('price/standard');
        $json = array();

        $electricity_last_modified = $this->model_price_standard->getElectricityLastModified();
        $json['id'] = $electricity_last_modified['id'];
        $temp = $this->model_price_standard->getElectricityStandardPrice($electricity_last_modified['id']);
        foreach ($temp as $row) {
            $json['newest'][] = array(
                'From' => $row['From'],
                'To'       => $row['To'],
                'Price' => $row['Price']
            );
        }

        $json['success'] = 'success';
        $this->response->setOutput(json_encode($json));
    }

    public function loadElectricityStandardPrice($id = '') {
        // remember to put this line or $this->model_price_standard will be NULL when call this function from ajax for the 2nd time
        $this->load->model('price/standard');

        $json = array();
        if (!empty($this->request->post['id'])) {
            $id = $this->request->post['id'];
        }
        $e_standard = $this->model_price_standard->getElectricityStandardPrice($id);
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

    public function updateElectricityStandardPrice() {
        $json = array();
        if (!empty($this->request->post['update_date']) &&
            !empty($this->request->post['electricity_new_data']) &&
            !empty($this->request->post['id'])) {
            // retrieve passed data from View and stores it in variables
            $updateDate = $this->request->post['update_date'];
            $nextUpdateDate = date('Y-m-d', strtotime('+1 day', strtotime($updateDate)));
            $electricity_new_data = $this->request->post['electricity_new_data'];
            $id = $this->request->post['id'];
            // get the last From
            $temp = $this->db->query('SELECT `from` FROM e_lifetime ORDER BY `id` DESC LIMIT 1')->row;
            // update table
            // check if update in the same day
            if (strtotime($nextUpdateDate) > strtotime($temp['from'])) { // update in different days
                $this->db->query('UPDATE e_lifetime SET `to` = "' . $updateDate . '" WHERE `id` = "' . $id . '"');
                $this->db->query('INSERT INTO e_lifetime (`from`, `to`) VALUES ("'. $nextUpdateDate . '", null)');
                $newestId = $this->db->query('SELECT id FROM e_lifetime WHERE `from` = "' . $nextUpdateDate . '"')->row;
                foreach ($electricity_new_data['electricity_new'] as $data) {
                    $this->db->query('INSERT INTO e_standard (`id`, `From`, `To`, `Price`) VALUES ("' . $newestId['id'] . '", "' . $data['from'] . '", "' . $data['to'] . '", "' . $data['price'] .'")');
                }
            } else { // update in the same day
                // get Id of the day
                $newestId = $this->db->query('SELECT id FROM e_lifetime WHERE `from` = "' . $nextUpdateDate . '"')->row;
                // delete previous same-day-inputted data
                $this->db->query('DELETE FROM e_standard WHERE `id` = "' . $newestId['id'] . '"');
                // insert updated data
                foreach ($electricity_new_data['electricity_new'] as $data) {
                    $this->db->query('INSERT INTO e_standard (`id`, `From`, `To`, `Price`) VALUES ("' . $newestId['id'] . '", "' . $data['from'] . '", "' . $data['to'] . '", "' . $data['price'] .'")');
                }
            }
            // set 'success' string in order to send back to the View
            $json['success'] = 'success';
        }
        $this->response->setOutput(json_encode($json));
    }

    public function loadNewestWaterStandardPrice() {
        // remember to put this line or $this->model_price_standard will be NULL when call this function from ajax for the 2nd time
        $this->load->model('price/standard');
        $json = array();

        $water_last_modified = $this->model_price_standard->getWaterLastModified();
        $json['id'] = $water_last_modified['id'];
        $temp = $this->model_price_standard->getWaterStandardPrice($water_last_modified['id']);
        foreach ($temp as $row) {
            $json['newest'][] = array(
                'From' => $row['From'],
                'To'       => $row['To'],
                'Price' => $row['Price']
            );
        }
        $json['success'] = 'success';
        $this->response->setOutput(json_encode($json));
    }

    public function loadWaterStandardPrice($id = '') {
        // remember to put this line or $this->model_price_standard will be NULL when call this function from ajax for the 2nd time
        $this->load->model('price/standard');

        $json = array();
        if (!empty($this->request->post['id'])) {
            $id = $this->request->post['id'];
        }
        $w_standard = $this->model_price_standard->getWaterStandardPrice($id);
        foreach ($w_standard as $row) {
            $this->data['w_standard'][] = array(
                'From' => $row['From'],
                'To'       => $row['To'],
                'Price' => $row['Price']
            );
        }
        // set 'success' string in order to send back to the View
        $json['success'] = 'success';
        $json['data'] = $w_standard;
        $this->response->setOutput(json_encode($json));
    }

    public function updateWaterStandardPrice() {
        $json = array();
        if (!empty($this->request->post['update_date']) &&
            !empty($this->request->post['water_new_data']) &&
            !empty($this->request->post['id'])) {
            // retrieve passed data from View and stores it in variables
            $updateDate = $this->request->post['update_date'];
            $nextUpdateDate = date('Y-m-d', strtotime('+1 day', strtotime($updateDate)));
            $water_new_data = $this->request->post['water_new_data'];
            $id = $this->request->post['id'];
            // get the last From
            $temp = $this->db->query('SELECT `from` FROM w_lifetime ORDER BY `id` DESC LIMIT 1')->row;
            // update table
            // check if update in the same day
            if (strtotime($nextUpdateDate) > strtotime($temp['from'])) { // update in different days
                $this->db->query('UPDATE w_lifetime SET `to` = "' . $updateDate . '" WHERE `id` = "' . $id . '"');
                $this->db->query('INSERT INTO w_lifetime (`from`, `to`) VALUES ("'. $nextUpdateDate . '", null)');
                $newestId = $this->db->query('SELECT id FROM w_lifetime WHERE `from` = "' . $nextUpdateDate . '"')->row;
                foreach ($water_new_data['water_new'] as $data) {
                    $this->db->query('INSERT INTO w_standard (`id`, `From`, `To`, `Price`) VALUES ("' . $newestId['id'] . '", "' . $data['from'] . '", "' . $data['to'] . '", "' . $data['price'] .'")');
                }
            } else { // update in the same day
                // get Id of the day
                $newestId = $this->db->query('SELECT id FROM w_lifetime WHERE `from` = "' . $nextUpdateDate . '"')->row;
                // delete previous same-day-inputted data
                $this->db->query('DELETE FROM w_standard WHERE `id` = "' . $newestId['id'] . '"');
                // insert updated data
                foreach ($water_new_data['water_new'] as $data) {
                    $this->db->query('INSERT INTO w_standard (`id`, `From`, `To`, `Price`) VALUES ("' . $newestId['id'] . '", "' . $data['from'] . '", "' . $data['to'] . '", "' . $data['price'] .'")');
                }
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