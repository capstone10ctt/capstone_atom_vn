<?php
class ControllerPriceEdit extends Controller {
    public function index() {
        $this->language->load('price/standard');
        $this->load->model('price/standard');
        $this->data['token'] = $this->session->data['token'];

        // load current apply id
        $electricityCurrentApplyId = $this->model_price_standard->getCurrentApplyIdElectricity();
        $waterCurrentApplyId = $this->model_price_standard->getCurrentApplyIdWater();
        $garbageCurrentApplyId = $this->model_price_standard->getCurrentApplyIdGarbage();
        // load standard price based on the provided id
        $this->loadElectricityStandardPrice($electricityCurrentApplyId);
        $this->loadWaterStandardPrice($waterCurrentApplyId);
        $this->loadGarbageStandardPrice($garbageCurrentApplyId);
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
        $this->data['valid_date_range'] = $this->language->get('valid_date_range');
        $this->data['header_current'] = $this->language->get('header_current');
        // set default page for view
        $this->template = 'price/main.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );
        $this->response->setOutput($this->render());
    }

    public function newStandardPriceView() {
        $this->language->load('price/standard');
        $this->data['token'] = $this->session->data['token'];

        // load language values
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
        $this->data['valid_date_range'] = $this->language->get('valid_date_range');
        $this->data['header_new'] = $this->language->get('header_new');
        $this->data['button_add'] = $this->language->get('button_add');
        // load view
        $this->template = 'price/new.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );
        $this->response->setOutput($this->render());
    }

    public function historyStandardPriceView() {
        $this->language->load('price/standard');
        $this->load->model('price/standard');
        $this->data['token'] = $this->session->data['token'];

        // load necessary data
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
        // load language values
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
        $this->data['valid_date_range'] = $this->language->get('valid_date_range');
        $this->data['header_history'] = $this->language->get('header_history');
        // load view
        $this->template = 'price/history.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );
        $this->response->setOutput($this->render());
    }

    public function editStandardPriceView() {
        $this->language->load('price/standard');
        $this->load->model('price/standard');
        $this->data['token'] = $this->session->data['token'];

        $electricity_last_modified = $this->model_price_standard->getElectricityLastModified();
        $electricity_last_modified_list = $this->model_price_standard->getElectricityLastModifiedList();
        // put modified date list into variable 'electricity_last_modified_list' & `water_last_modified_list`
        $this->data['electricity_last_modified_list'] = $electricity_last_modified_list;
        // load electricity standard price based on the provided date
        $this->loadElectricityStandardPrice($electricity_last_modified['id']);
        // load language values
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
        $this->data['valid_date_range'] = $this->language->get('valid_date_range');
        $this->data['header_edit'] = $this->language->get('header_edit');
        // load view
        $this->template = 'price/edit.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );
        $this->response->setOutput($this->render());
    }
    //==================================================================================================================
    public function loadNewestElectricityStandardPriceId() {
        // remember to put this line or $this->model_price_standard will be NULL when call this function from ajax for the 2nd time
        $this->load->model('price/standard');
        $json = array();

        $electricity_last_modified = $this->model_price_standard->getElectricityLastModified();
        if (empty($electricity_last_modified)) {
            $json['id'] = -1;
        } else {
            $json['id'] = $electricity_last_modified['id'];
        }
        $this->response->setOutput(json_encode($json));
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
            // update the future standard price
            $temp = $this->db->query('SELECT `from` FROM e_lifetime WHERE id = "' . $id . '"')->row;
            $currentDate = date('Y-m-d');
            date_default_timezone_set('UTC');
            if (date(strtotime($temp['from'])) >= date(strtotime($currentDate))) {
                // update To_date
                $currentPriceId = $this->db->query('SELECT `id` FROM e_lifetime WHERE id <> "' . $id . '" ORDER BY `id` DESC LIMIT 1')->row['id'];
                $handle = fopen("log.txt","w");
                fwrite($handle,var_export($currentPriceId,true));
                fclose($handle);
                $this->db->query('UPDATE e_lifetime SET `to` = "' . $oldEndDate . '" WHERE `id` = "' . $currentPriceId . '"');
                // update From_date
                $this->db->query('UPDATE e_lifetime SET `from` = "' . $updateDateFrom . '" WHERE id = "' . $id . '"');
                $this->db->query('DELETE FROM e_standard WHERE `id` = "' . $id . '"');
                foreach ($electricity_new_data['electricity_new'] as $data) {
                    $this->db->query('INSERT INTO e_standard (`id`, `From`, `To`, `Price`) VALUES ("' . $id . '", "' . $data['from'] . '", "' . $data['to'] . '", "' . $data['price'] .'")');
                }
            } else { // add new standard price
                // update the end date of old standard price
                $this->db->query('UPDATE e_lifetime SET `to`= "' . $oldEndDate . '" WHERE id = "' . $id . '"');
                // update table
                $this->db->query('INSERT INTO e_lifetime (`from`, `to`) VALUES ("'. $updateDateFrom . '", NULL)');
                $newestId = $this->db->query('SELECT id FROM e_lifetime WHERE `from` = "' . $updateDateFrom . '" AND `to` IS NULL')->row;
                foreach ($electricity_new_data['electricity_new'] as $data) {
                    $this->db->query('INSERT INTO e_standard (`id`, `From`, `To`, `Price`) VALUES ("' . $newestId['id'] . '", "' . $data['from'] . '", "' . $data['to'] . '", "' . $data['price'] .'")');
                }
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
        if (empty($latestUpdateDate)) {
            date_default_timezone_set('UTC');
            $json['month'] = date('m') - 1;
            $json['year'] = date('Y');
        } else {
            $json['month'] = $latestUpdateDate['Month'];
            $json['year'] = $latestUpdateDate['Year'];
            $json['id'] = $latestUpdateDate['id'];
        }
        $this->response->setOutput(json_encode($json));
    }

    public function deleteCurrentElectricityStandardPrice() {
        $this->load->model('price/standard');

        if (!empty($this->request->post['id'])) {
            $id = $this->request->post['id'];
            $this->model_price_standard->deleteCurrentElectricityStandardPrice($id);
        }
    }

    public function getCurrentApplyDateElectricity() {
        // remember to put this line or $this->model_price_standard will be NULL when call this function from ajax for the 2nd time
        $this->load->model('price/standard');
        $json = array();

        $currentApplyDate = $this->model_price_standard->getCurrentApplyDateElectricity();
        $json['date'] = $currentApplyDate['From'];
        $this->response->setOutput(json_encode($json));
    }

    public function getCurrentApplyIdElectricity() {
        // remember to put this line or $this->model_price_standard will be NULL when call this function from ajax for the 2nd time
        $this->load->model('price/standard');
        $currentApplyDate = $this->model_price_standard->getCurrentApplyIdElectricity();
        return $currentApplyDate['id'];
    }

    public function updateApplyStandardElectricityPrice() {
        // remember to put this line or $this->model_price_standard will be NULL when call this function from ajax for the 2nd time
        $this->load->model('price/standard');
        $this->model_price_standard->updateApplyStandardElectricityPrice();
    }
    //==================================================================================================================
    public function loadNewestWaterStandardPriceId() {
        // remember to put this line or $this->model_pricw_standard will be NULL when call this function from ajax for the 2nd time
        $this->load->model('price/standard');
        $json = array();

        $water_last_modified = $this->model_price_standard->getWaterLastModified();
        if (empty($water_last_modified)) {
            $json['id'] = -1;
        } else {
            $json['id'] = $water_last_modified['id'];
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
        if (!empty($this->request->post['update_date_from']) && !empty($this->request->post['old_end_date']) &&
            !empty($this->request->post['water_new_data']) &&
            !empty($this->request->post['id'])) {
            // retrieve passed data from View and stores it in variables
            $updateDateFrom = $this->request->post['update_date_from'];
            $oldEndDate = $this->request->post['old_end_date'];
            $water_new_data = $this->request->post['water_new_data'];
            $id = $this->request->post['id'];
            // update the future standard price
            $temp = $this->db->query('SELECT `from` FROM w_lifetime WHERE id = "' . $id . '"')->row;
            $currentDate = date('Y-m-d');
            date_default_timezone_set('UTC');
            if (date(strtotime($temp['from'])) >= date(strtotime($currentDate))) {
                // update To_date
                $currentPriceId = $this->db->query('SELECT `id` FROM w_lifetime WHERE id <> "' . $id . '" ORDER BY `id` DESC LIMIT 1')->row['id'];
                $handle = fopen("log.txt","w");
                fwrite($handle,var_export($currentPriceId,true));
                fclose($handle);
                $this->db->query('UPDATE w_lifetime SET `to` = "' . $oldEndDate . '" WHERE `id` = "' . $currentPriceId . '"');
                // update From_date
                $this->db->query('UPDATE w_lifetime SET `from` = "' . $updateDateFrom . '" WHERE id = "' . $id . '"');
                $this->db->query('DELETE FROM w_standard WHERE `id` = "' . $id . '"');
                foreach ($water_new_data['water_new'] as $data) {
                    $this->db->query('INSERT INTO w_standard (`id`, `From`, `To`, `Price`) VALUES ("' . $id . '", "' . $data['from'] . '", "' . $data['to'] . '", "' . $data['price'] .'")');
                }
            } else { // add new standard price
                // update the end date of old standard price
                $this->db->query('UPDATE w_lifetime SET `to`= "' . $oldEndDate . '" WHERE id = "' . $id . '"');
                // update table
                $this->db->query('INSERT INTO w_lifetime (`from`, `to`) VALUES ("'. $updateDateFrom . '", NULL)');
                $newestId = $this->db->query('SELECT id FROM w_lifetime WHERE `from` = "' . $updateDateFrom . '" AND `to` IS NULL')->row;
                foreach ($water_new_data['water_new'] as $data) {
                    $this->db->query('INSERT INTO w_standard (`id`, `From`, `To`, `Price`) VALUES ("' . $newestId['id'] . '", "' . $data['from'] . '", "' . $data['to'] . '", "' . $data['price'] .'")');
                }
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
        if (empty($latestUpdateDate)) {
            date_default_timezone_set('UTC');
            $json['month'] = date('m') - 1;
            $json['year'] = date('Y');
        } else {
            $json['month'] = $latestUpdateDate['Month'];
            $json['year'] = $latestUpdateDate['Year'];
            $json['id'] = $latestUpdateDate['id'];
        }
        $this->response->setOutput(json_encode($json));
    }

    public function deleteCurrentWaterStandardPrice() {
        $this->load->model('price/standard');

        if (!empty($this->request->post['id'])) {
            $id = $this->request->post['id'];
            $this->model_price_standard->deleteCurrentWaterStandardPrice($id);
        }
    }

    public function getCurrentApplyDateWater() {
        // remember to put this line or $this->model_price_standard will be NULL when call this function from ajax for the 2nd time
        $this->load->model('price/standard');
        $json = array();

        $currentApplyDate = $this->model_price_standard->getCurrentApplyDateWater();
        $json['date'] = $currentApplyDate['From'];
        $this->response->setOutput(json_encode($json));
    }

    public function getCurrentApplyIdWater() {
        // remember to put this line or $this->model_price_standard will be NULL when call this function from ajax for the 2nd time
        $this->load->model('price/standard');
        $currentApplyDate = $this->model_price_standard->getCurrentApplyIdWater();
        return $currentApplyDate['id'];
    }

    public function updateApplyStandardWaterPrice() {
        // remember to put this line or $this->model_price_standard will be NULL when call this function from ajax for the 2nd time
        $this->load->model('price/standard');
        $this->model_price_standard->updateApplyStandardWaterPrice();
    }
    //==================================================================================================================
    public function loadNewestGarbageStandardPriceId() {
        // remember to put this line or $this->model_pricg_standard will be NULL when call this function from ajax for the 2nd time
        $this->load->model('price/standard');
        $json = array();

        $garbage_last_modified = $this->model_price_standard->getGarbageLastModified();
        if (empty($garbage_last_modified)) {
            $json['id'] = -1;
        } else {
            $json['id'] = $garbage_last_modified['id'];
        }
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
                'From' => $row['From'],
                'To'       => $row['To'],
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
        $handle = fopen("log.txt","w");
        fwrite($handle,var_export($g_standard,true));
        fclose($handle);
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
            // update the future standard price
            $temp = $this->db->query('SELECT `from` FROM g_lifetime WHERE id = "' . $id . '"')->row;
            $currentDate = date('Y-m-d');
            date_default_timezone_set('UTC');
            if (date(strtotime($temp['from'])) >= date(strtotime($currentDate))) {
                // update To_date
                $currentPriceId = $this->db->query('SELECT `id` FROM g_lifetime WHERE id <> "' . $id . '" ORDER BY `id` DESC LIMIT 1')->row['id'];
                $this->db->query('UPDATE g_lifetime SET `to` = "' . $oldEndDate . '" WHERE `id` = "' . $currentPriceId . '"');
                // update From_date
                $this->db->query('UPDATE g_lifetime SET `from` = "' . $updateDateFrom . '" WHERE id = "' . $id . '"');
                $this->db->query('DELETE FROM g_standard WHERE `id` = "' . $id . '"');
                foreach ($garbage_new_data['garbage_new'] as $data) {
                    $this->db->query('INSERT INTO g_standard (`id`, `From`, `To`, `Price`) VALUES ("' . $id . '", "' . $data['from'] . '", "' . $data['to'] . '", "' . $data['price'] .'")');
                }
            } else { // add new standard price
                // update the end date of old standard price
                $this->db->query('UPDATE g_lifetime SET `to`= "' . $oldEndDate . '" WHERE id = "' . $id . '"');
                // update table
                $this->db->query('INSERT INTO g_lifetime (`from`, `to`) VALUES ("'. $updateDateFrom . '", NULL)');
                $newestId = $this->db->query('SELECT id FROM g_lifetime WHERE `from` = "' . $updateDateFrom . '" AND `to` IS NULL')->row;
                foreach ($garbage_new_data['water_new'] as $data) {
                    $this->db->query('INSERT INTO g_standard (`id`, `From`, `To`, `Price`) VALUES ("' . $newestId['id'] . '", "' . $data['from'] . '", "' . $data['to'] . '", "' . $data['price'] .'")');
                }
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
        if (empty($latestUpdateDate)) {
            date_default_timezone_set('UTC');
            $json['month'] = date('m') - 1;
            $json['year'] = date('Y');
        } else {
            $json['month'] = $latestUpdateDate['Month'];
            $json['year'] = $latestUpdateDate['Year'];
            $json['id'] = $latestUpdateDate['id'];
        }
        $this->response->setOutput(json_encode($json));
    }

    public function deleteCurrentGarbageStandardPrice() {
        $this->load->model('price/standard');

        if (!empty($this->request->post['id'])) {
            $id = $this->request->post['id'];
            $this->model_price_standard->deleteCurrentGarbageStandardPrice($id);
        }
    }

    public function getCurrentApplyDateGarbage() {
        // remember to put this line or $this->model_price_standard will be NULL when call this function from ajax for the 2nd time
        $this->load->model('price/standard');
        $json = array();

        $currentApplyDate = $this->model_price_standard->getCurrentApplyDateGarbage();
        $json['date'] = $currentApplyDate['From'];
        $this->response->setOutput(json_encode($json));
    }

    public function getCurrentApplyIdGarbage() {
        // remember to put this line or $this->model_price_standard will be NULL when call this function from ajax for the 2nd time
        $this->load->model('price/standard');
        $currentApplyDate = $this->model_price_standard->getCurrentApplyIdGarbage();
        return $currentApplyDate['id'];
    }

    public function updateApplyStandardGarbagePrice() {
        // remember to put this line or $this->model_price_standard will be NULL when call this function from ajax for the 2nd time
        $this->load->model('price/standard');
        $this->model_price_standard->updateApplyStandardGarbagePrice();
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