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
        $garbage_last_modified = $this->model_price_standard->getGarbageLastModified();
        $garbage_last_modified_list = $this->model_price_standard->getGarbageLastModifiedList();
        // put modified date list into variable 'electricity_last_modified_list' & `water_last_modified_list`
        $this->data['electricity_last_modified_list'] = $electricity_last_modified_list;
        $this->data['water_last_modified_list'] = $water_last_modified_list;
        $this->data['garbage_last_modified_list'] = $garbage_last_modified_list;
        // load electricity standard price based on the provided date
        $this->loadElectricityStandardPrice($electricity_last_modified['id']);
        $this->loadWaterStandardPrice($water_last_modified['id']);
        $this->loadGarbageStandardPrice($garbage_last_modified['id']);
        // store values for display purpose in View part
        $this->data['text_electricity_from'] = $this->language->get('text_electricity_from');
        $this->data['text_electricity_to'] = $this->language->get('text_electricity_to');
        $this->data['text_electricity_price'] = $this->language->get('text_electricity_price');
        $this->data['text_water_from'] = $this->language->get('text_water_from');
        $this->data['text_water_to'] = $this->language->get('text_water_to');
        $this->data['text_water_price'] = $this->language->get('text_water_price');
        $this->data['text_garbage_price'] = $this->language->get('text_garbage_price');
        $this->data['description_electricity'] = $this->language->get('description_electricity');
        $this->data['description_water'] = $this->language->get('description_water');
        $this->data['description_garbage'] = $this->language->get('description_garbage');
        $this->data['last_modified'] = $this->language->get('last_modified');
        $this->data['from_date'] = $this->language->get('from_date');
        $this->data['to_date'] = $this->language->get('to_date');
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
        if (!empty($this->request->post['update_date_from']) && !empty($this->request->post['old_end_date']) &&
            !empty($this->request->post['electricity_new_data']) &&
            !empty($this->request->post['id'])) {
            // retrieve passed data from View and stores it in variables
            $updateDateFrom = $this->request->post['update_date_from'];
            $oldEndDate = $this->request->post['old_end_date'];
            $electricity_new_data = $this->request->post['electricity_new_data'];
            $id = $this->request->post['id'];
            // update the end date of old standard price
            $this->db->query('UPDATE e_lifetime SET `to`= "' . $oldEndDate . '" WHERE id = "' . $id . '"');
            // update table
            $this->db->query('INSERT INTO e_lifetime (`from`, `to`) VALUES ("'. $updateDateFrom . '", NULL)');
            $newestId = $this->db->query('SELECT id FROM e_lifetime WHERE `from` = "' . $updateDateFrom . '" AND `to` IS NULL')->row;
            foreach ($electricity_new_data['electricity_new'] as $data) {
                $this->db->query('INSERT INTO e_standard (`id`, `From`, `To`, `Price`) VALUES ("' . $newestId['id'] . '", "' . $data['from'] . '", "' . $data['to'] . '", "' . $data['price'] .'")');
            }
            // set 'success' string in order to send back to the View
            $json['success'] = 'success';
        }
        $this->response->setOutput(json_encode($json));
    }

    public function getLatestElectricityUpdateDate() {
        $this->load->model('price/standard');

        $json = array();
        $latestUpdateDate = $this->model_price_standard->getLatestElectricityUpdateDate();
        $handle = fopen("log.txt","w");
        fwrite($handle,var_export($latestUpdateDate, true));
        fclose($handle);
        $json['month'] = $latestUpdateDate['Month'];
        $json['year'] = $latestUpdateDate['Year'];
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
        if (!empty($this->request->post['update_date_from']) && !empty($this->request->post['old_end_date']) &&
            !empty($this->request->post['water_new_data']) &&
            !empty($this->request->post['id'])) {
            // retrieve passed data from View and stores it in variables
            $updateDateFrom = $this->request->post['update_date_from'];
            $oldEndDate = $this->request->post['old_end_date'];
            $water_new_data = $this->request->post['water_new_data'];
            $id = $this->request->post['id'];
            // update the end date of old standard price
            $this->db->query('UPDATE w_lifetime SET `to`= "' . $oldEndDate . '" WHERE id = "' . $id . '"');
            // update table
            $this->db->query('INSERT INTO w_lifetime (`from`, `to`) VALUES ("'. $updateDateFrom . '", NULL)');
            $newestId = $this->db->query('SELECT id FROM w_lifetime WHERE `from` = "' . $updateDateFrom . '" AND `to` IS NULL')->row;
            foreach ($water_new_data['water_new'] as $data) {
                $this->db->query('INSERT INTO w_standard (`id`, `From`, `To`, `Price`) VALUES ("' . $newestId['id'] . '", "' . $data['from'] . '", "' . $data['to'] . '", "' . $data['price'] .'")');
            }
            // set 'success' string in order to send back to the View
            $json['success'] = 'success';
        }
        $this->response->setOutput(json_encode($json));
    }

    public function getLatestWaterUpdateDate() {
        $this->load->model('price/standard');

        $json = array();
        $latestUpdateDate = $this->model_price_standard->getLatestWaterUpdateDate();
        $json['month'] = $latestUpdateDate['Month'];
        $json['year'] = $latestUpdateDate['Year'];
        $this->response->setOutput(json_encode($json));
    }

    public function loadNewestGarbageStandardPrice() {
        // remember to put this line or $this->model_price_standard will be NULL when call this function from ajax for the 2nd time
        $this->load->model('price/standard');
        $json = array();

        $garbage_last_modified = $this->model_price_standard->getGarbageLastModified();
        $json['id'] = $garbage_last_modified['id'];
        $temp = $this->model_price_standard->getGarbageStandardPrice($garbage_last_modified['id']);
        foreach ($temp as $row) {
            $json['newest'][] = array(
                'Price' => $row['Price']
            );
        }
        $json['success'] = 'success';
        $this->response->setOutput(json_encode($json));
    }

    public function loadGarbageStandardPrice($id = '') {
        // remember to put this line or $this->model_price_standard will be NULL when call this function from ajax for the 2nd time
        $this->load->model('price/standard');

        $json = array();
        if (!empty($this->request->post['id'])) {
            $id = $this->request->post['id'];
        }
        $g_standard = $this->model_price_standard->getGarbageStandardPrice($id);
        foreach ($g_standard as $row) {
            $this->data['g_standard'][] = array(
                'Price' => $row['Price']
            );
        }
        // set 'success' string in order to send back to the View
        $json['success'] = 'success';
        $json['data'] = $g_standard;
        $this->response->setOutput(json_encode($json));
    }

    public function updateGarbageStandardPrice() {
        $json = array();
        if (!empty($this->request->post['update_date_from']) && !empty($this->request->post['old_end_date']) &&
            !empty($this->request->post['garbage_new_data']) &&
            !empty($this->request->post['id'])) {
            // retrieve passed data from View and stores it in variables
            $updateDateFrom = $this->request->post['update_date_from'];
            $oldEndDate = $this->request->post['old_end_date'];
            $garbage_new_data = $this->request->post['garbage_new_data'];
            $id = $this->request->post['id'];
            // update the end date of old standard price
            $this->db->query('UPDATE g_lifetime SET `to`= "' . $oldEndDate . '" WHERE id = "' . $id . '"');
            // update table
            $this->db->query('INSERT INTO g_lifetime (`from`, `to`) VALUES ("'. $updateDateFrom . '", NULL)');
            $newestId = $this->db->query('SELECT id FROM g_lifetime WHERE `from` = "' . $updateDateFrom . '" AND `to` IS NULL')->row;
            foreach ($garbage_new_data['garbage_new'] as $data) {
                $this->db->query('INSERT INTO g_standard (`id`, `Price`) VALUES ("' . $newestId['id'] . '", "' . $data['price'] .'")');
            }
            // set 'success' string in order to send back to the View
            $json['success'] = 'success';
        }
        $this->response->setOutput(json_encode($json));
    }

    public function getLatestGarbageUpdateDate() {
        $this->load->model('price/standard');

        $json = array();
        $latestUpdateDate = $this->model_price_standard->getLatestGarbageUpdateDate();
        $json['month'] = $latestUpdateDate['Month'];
        $json['year'] = $latestUpdateDate['Year'];
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