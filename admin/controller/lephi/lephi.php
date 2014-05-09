<?php
class ControllerLephiLephi extends Controller {

    public function index() {
        $this->language->load('lephi/lephi');
        $this->load->model('lephi/lephi');
        $this->data['token'] = $this->session->data['token'];
        // add CSS
        $this->document->addStyle('view/stylesheet/lephi/style.css');

        $lephi_last_modified = $this->model_lephi_lephi->getLephiLastModified();
        $lephi_last_modified_list = $this->model_lephi_lephi->getLephiLastModifiedList();
        // put modified date list into variable 'electricity_last_modified_list' & `water_last_modified_list`
        $this->data['lephi_last_modified_list'] = $lephi_last_modified_list;
        // load electricity standard price based on the provided date
        $this->loadLephiStandardPrice($lephi_last_modified['id']);
        // store values for display purpose in View part
        $this->data['loaiphi_column'] = $this->language->get('loaiphi_column');
        $this->data['sotien_column'] = $this->language->get('sotien_column');
        $this->data['description_lephi'] = $this->language->get('description_lephi');
        $this->data['last_modified'] = $this->language->get('last_modified');
        $this->data['from_date'] = $this->language->get('from_date');
        $this->data['to_date'] = $this->language->get('to_date');
        // set default page for view
        $this->template = 'lephi/lephi.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );
        $this->response->setOutput($this->render());
    }

    public function loadNewestLephiStandardPrice() {
        // remember to put this line or $this->model_price_standard will be NULL when call this function from ajax for the 2nd time
        $this->load->model('lephi/lephi');
        $json = array();

        $lephi_last_modified = $this->model_lephi_lephi->getLephiLastModified();
        $json['id'] = $lephi_last_modified['id'];
        $temp = $this->model_lephi_lephi->getLephiStandardPrice($lephi_last_modified['id']);
        foreach ($temp as $row) {
            $json['newest'][] = array(
                'name' => $row['name'],
                'price' => $row['price']
            );
        }

        $json['success'] = 'success';
        $this->response->setOutput(json_encode($json));
    }

    public function loadLephiStandardPrice($id = '') {
        // remember to put this line or $this->model_price_standard will be NULL when call this function from ajax for the 2nd time
        $this->load->model('lephi/lephi');

        $json = array();
        if (!empty($this->request->post['id'])) {
            $id = $this->request->post['id'];
        }
        $lephi = $this->model_lephi_lephi->getLephiStandardPrice($id);
        foreach ($lephi as $row) {
            $this->data['lephi'][] = array(
                'name' => $row['name'],
                'price' => $row['price']
            );
        }
        // set 'success' string in order to send back to the View
        $json['success'] = 'success';
        $json['data'] = $lephi;
        $this->response->setOutput(json_encode($json));
    }

    public function updateLephiStandardPrice() {
        $json = array();
        if (!empty($this->request->post['update_date_from']) && !empty($this->request->post['update_date_to']) &&
            !empty($this->request->post['lephi_new_data']) &&
            !empty($this->request->post['id'])) {
            // retrieve passed data from View and stores it in variables
            // retrieve passed data from View and stores it in variables
            $updateDateFrom = $this->request->post['update_date_from'];
            $updateDateTo = $this->request->post['update_date_to'];
            $lephi_new_data = $this->request->post['lephi_new_data'];
            $id = $this->request->post['id'];
            // update table
            // check if update in the same day
            $this->db->query('INSERT INTO lephi_lifetime (`from`, `to`) VALUES ("'. $updateDateFrom . '", "' . $updateDateTo . '")');
            $newestId = $this->db->query('SELECT id FROM lephi_lifetime WHERE `from` = "' . $updateDateFrom . '" AND `to` = "' . $updateDateTo . '"')->row;
            foreach ($lephi_new_data['lephi_new'] as $data) {
                $this->db->query('INSERT INTO lephi_standard (`id`, `name`, `price`) VALUES ("' . $newestId['id'] . '", "' . $data['name'] . '", "' . $data['price'] .'")');
            }
            // set 'success' string in order to send back to the View
            $json['success'] = 'success';
        }
        $this->response->setOutput(json_encode($json));
    }

    public function applyLephiStandardPrice() {
        $json = array();
        if (!empty($this->request->post['id'])) {
            $id = $this->request->post['id'];
            $this->db->query('UPDATE lephi_lifetime SET `apply` = "0" WHERE `id` <> "'. $id . '"');
            $this->db->query('UPDATE lephi_lifetime SET `apply` = "1" WHERE `id` = "' . $id . '"');
            // set 'success' string in order to send back to the View
            $json['success'] = 'success';
        }
        $this->response->setOutput(json_encode($json));
    }

    public function loadApplyingLephiStandardId() {
        $json = array();
        $temp = $this->db->query('SELECT `id` FROM lephi_lifetime WHERE `apply` = 1')->row;
        $json['id'] = $temp['id'];
        $json['success'] = 'success';
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