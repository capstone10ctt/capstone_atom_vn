<?php
class ControllerPriceEdit extends Controller {

    public function index() {
        $this->language->load('price/standard');
        $this->load->model('price/standard');
        $this->data['token'] = $this->session->data['token'];

        $this->loadStandardPrice();
    }

    public function loadStandardPrice() {
        $w_standard = $this->model_price_standard->getWaterStandardPrice();
        $e_standard = $this->model_price_standard->getElectricityStandardPrice();

        foreach ($w_standard as $row) {
            $this->data['w_standard'][] = array(
                'From' => $row['From'],
                'To' => $row['To'],
                'Price' => $row['Price']
            );
        }

        foreach ($e_standard as $row) {
            $this->data['e_standard'][] = array(
                'From' => $row['From'],
                'To'       => $row['To'],
                'Price' => $row['Price']
            );
        }

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
        $this->template = 'price/edit.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    public function updateStandardPrice() {
        $json = array();
        if (!empty($this->request->post['electricity_old_data']) && !empty($this->request->post['electricity_new_data']) && !empty($this->request->post['water_old_data']) && !empty($this->request->post['water_new_data'])) {
            // retrieve passed data from View and stores it in variables
            $electricity_old_data = $this->request->post['electricity_old_data'];
            $electricity_new_data = $this->request->post['electricity_new_data'];
            $water_old_data = $this->request->post['water_old_data'];
            $water_new_data = $this->request->post['water_new_data'];
            $handle = fopen("log.txt","w");
            fwrite($handle,var_export($water_old_data,true));
            fclose($handle);
            // arrays used for storing values of 'From', 'To', 'Price' columns of Electricity and Water tables
            $fromOldElectricityArr = $fromOldWaterArr = array();
            $toOldElectricityArr = $toOldWaterArr = array();
            $priceOldElectricityArr = $priceOldWaterArr = array();
            $fromNewElectricityArr = $fromNewWaterArr = array();
            $toNewElectricityArr = $toNewWaterArr = array();
            $priceNewElectricityArr = $priceNewWaterArr = array();
            // push column of data into appropriate arrays
            foreach ($electricity_old_data['electricity_old'] as $data) {
                array_push($fromOldElectricityArr, $data['from']);
                array_push($toOldElectricityArr, $data['to']);
                array_push($priceOldElectricityArr, $data['price']);
            }
            foreach ($electricity_new_data['electricity_new'] as $data) {
                array_push($fromNewElectricityArr, $data['from']);
                array_push($toNewElectricityArr, $data['to']);
                array_push($priceNewElectricityArr, $data['price']);
            }
            foreach ($water_old_data['water_old'] as $data) {
                array_push($fromOldWaterArr, $data['from']);
                array_push($toOldWaterArr, $data['to']);
                array_push($priceOldWaterArr, $data['price']);
            }
            foreach ($water_new_data['water_new'] as $data) {
                array_push($fromNewWaterArr, $data['from']);
                array_push($toNewWaterArr, $data['to']);
                array_push($priceNewWaterArr, $data['price']);
            }
            // update table
            for ($i = 0; $i < count($fromOldElectricityArr); ++$i) {
                $this->db->query("UPDATE e_standard ".
                    "SET `From` = " . $fromNewElectricityArr[$i] . ", `To` = " . $toNewElectricityArr[$i] . ", Price = " . $priceNewElectricityArr[$i] .
                    " WHERE `From` = " . $fromOldElectricityArr[$i] . " AND `To` = " . $toOldElectricityArr[$i] . " AND Price = " . $priceOldElectricityArr[$i]);
            }
            for ($i = 0; $i < count($fromOldWaterArr); ++$i) {
                $this->db->query("UPDATE w_standard ".
                    "SET `From` = " . $fromNewWaterArr[$i] . ", `To` = " . $toNewWaterArr[$i] . ", Price = " . $priceNewWaterArr[$i] .
                    " WHERE `From` = " . $fromOldWaterArr[$i] . " AND `To` = " . $toOldWaterArr[$i] . " AND Price = " . $priceOldWaterArr[$i]);
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