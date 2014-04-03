<?php
class ModelSaleManageWie extends Model {
	
	
	public function savelog($data){
		$this->db->query("INSERT INTO " . DB_PREFIX . "logs SET `action` = '" . $this->db->escape($data['action']) . "', `reason` = '" . $this->db->escape($data['reason']) . "', `date_added` = NOW(), `factor` = '" . $this->db->escape($data['factor']) . "'");
	}
	
	public function saveDeadline($data){
		//check exist first
		$cur_year = date('Y');
		$cur_month = date('m');
		$date = new DateTime();
		$date->setDate($cur_year, $cur_month, 1);
		$date_final = $date->format('Y-m-d');
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "deadline_total WHERE MONTH(period) = '" . (int)$cur_month . "' AND YEAR(period) = '" . (int)$cur_year . "'");
		
		if($query->num_rows) {
			$this->db->query("UPDATE " . DB_PREFIX . "deadline_total SET `deadline_charge` = '" . (int)$this->db->escape($data['deadline_charge']) . "', `deadline_edit` = '" . (int)$this->db->escape($data['deadline_edit']) . "', `deadline_supply` = '" . (int)$this->db->escape($data['deadline_supply']) . "' , `total_elec` = '" . $this->db->escape($data['total_elec']) . "' , `total_water` = '" . $this->db->escape($data['total_water']) . "', period = '" . $date_final . "' WHERE MONTH(period) = '" . (int)$cur_month . "' AND YEAR(period) = '" . (int)$cur_year . "'");		
		}
		else {
			$this->db->query("INSERT INTO " . DB_PREFIX . "deadline_total SET `deadline_charge` = '" . (int)$this->db->escape($data['deadline_charge']) . "', `deadline_edit` = '" . (int)$this->db->escape($data['deadline_edit']) . "', `deadline_supply` = '" . (int)$this->db->escape($data['deadline_supply']) . "' , `total_elec` = '" . $this->db->escape($data['total_elec']) . "' , `total_water` = '" . $this->db->escape($data['total_water']) . "', period = '" . $date_final . "'");
		}
	}
	
	public function getDeadline($period){
		//check exist first
		$array = explode('-',$period);
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "deadline_total WHERE MONTH(period) = '" . (int)$array[0] . "' AND YEAR(period) = '" . (int)$array[1] . "'");
		
		return $query->row;
	}
	
	public function getAllDeadlinePeriod(){
		//check exist first
		$cur_year = date('Y');
		$cur_month = date('m');
		
		$periods = array();
		
		$query = $this->db->query("SELECT DISTINCT period FROM " . DB_PREFIX . "deadline_total");
		
		if($query->num_rows) {
			foreach($query->rows as $row) {
				$month = date('m',strtotime($row['period']));
				$year = date('Y',strtotime($row['period']));
				
				$period = $month.'-'.$year;
				
				$periods[] = $period;
			}
		}
		
		return $periods;
	}
	
	public function deleteCustomerGroup($customer_group_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_group WHERE customer_group_id = '" . (int)$customer_group_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_group_description WHERE customer_group_id = '" . (int)$customer_group_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE customer_group_id = '" . (int)$customer_group_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE customer_group_id = '" . (int)$customer_group_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_reward WHERE customer_group_id = '" . (int)$customer_group_id . "'");
	}
	
	public function getCustomerGroupsView($filter){
		//floors and room
		$block_id = 1;
		$rooms_input = $this->getCustomerGroups();
		$floors_input = $this->getFloors($block_id);
		
		//get electric and water limit data
		$this->load->model('price/standard');
		$e_standard_idx = $this->model_price_standard->getElectricityLastestLifeTime();
		$e_standard = $this->model_price_standard->getElectricityStandardPrice((int)$e_standard_idx['id']);
		
		$w_standard_idx = $this->model_price_standard->getWaterLastestLifeTime();
		$w_standard = $this->model_price_standard->getWaterStandardPrice((int)$w_standard_idx['id']);
       
		
		$cur_year = date('Y');
		$cur_month = date('m');
		
		$billing_wie_classified = array();
		
		$d_year = date('Y');
		$d_month = date('m');
		$period = $d_month.'-'.$d_year;
		$deadline = $this->getDeadline($period);
		
		if ($deadline) {
			$dead_line = (int)$deadline['deadline_charge'];
		} else {
			$dead_line = 10;
		}
		
		foreach($floors_input as $floor_idx => $floor) {
			$data = array('floor' => $floor['floor_id']);
			$results = $this->getCustomerGroups($data);
			
			foreach ($results as $result) {
				$totalmoney = 0;
				$elec = $this->getElectricLogByRoomId($result['customer_group_id']);
				//echo '<br/>dien:<br/>'.print_r($elec);
				if(isset($elec)) {
					//$billing_wie_classified[$result['customer_group_id']]['elec'] = $elec;
					if(isset($elec['End']) && isset($elec['Start'])) {
						$e_usage = (int)$elec['End'] - (int)$elec['Start'];
					}
					else {
						$e_usage = 0;
					}
					
					$charge = 'no';
					if(isset($elec['charged']) && (int)$elec['charged'] == 1) {
						$day = date('d', strtotime($elec['charged_date']));
						
						if((int)$day <= (int)$dead_line) {
							$charge = 'yes';
						}
						else {
							$charge = 'late';
						}
					}
					else {
						$charge = 'no';
					}
					
					$billing_wie_classified[$result['customer_group_id']]['elec']['Usage'] = $e_usage;
					$money = $this->calculate_money_elec($e_standard, $e_usage);
					$billing_wie_classified[$result['customer_group_id']]['elec']['Money'] = $money;
					$billing_wie_classified[$result['customer_group_id']]['elec']['End'] = (isset($elec['End']) ? $elec['End'] : 0);
					$billing_wie_classified[$result['customer_group_id']]['elec']['Start'] = (isset($elec['Start']) ? $elec['Start'] : 0);
					$billing_wie_classified[$result['customer_group_id']]['elec']['Charged'] = $charge;
					$billing_wie_classified[$result['customer_group_id']]['elec']['ok'] = (($e_usage == 0) ? 'no' : 'yes');
					$totalmoney += $money;
				}
				
				$water = $this->getWaterLogByRoomId($result['customer_group_id']);					
				//echo '<br/>nuoc:<br/>'.print_r($water);
				if(isset($water)) {
					//$billing_wie_classified[$result['customer_group_id']]['water'] = $water ;
					if(isset($water['End']) && isset($water['Start'])) {
						$w_usage = (int)$water['End'] - (int)$water['Start'];
					}
					else {
						$w_usage = 0;
					}
					
					$charge = 'no';
					if(isset($water['charged']) && (int)$water['charged'] == 1) {
						$day = date('d', strtotime($water['charged_date']));
						
						if((int)$day <= (int)$dead_line) {
							$charge = 'yes';
						}
						else {
							$charge = 'late';
						}
					}
					else {
						$charge = 'no';
					}
					
					$billing_wie_classified[$result['customer_group_id']]['water']['Usage'] = $w_usage;
					//$billing_wie_classified[$result['customer_group_id']]['water']['w_standard'] = $w_standard;
					//$billing_wie_classified[$result['customer_group_id']]['water']['lifetime'] = $this->model_price_standard->getWaterLastestLifeTime();
					$money = $this->calculate_money_water($w_standard, $w_usage, $result['customer_group_id']);
					$billing_wie_classified[$result['customer_group_id']]['water']['Money'] = $money;
					$billing_wie_classified[$result['customer_group_id']]['water']['End'] = (isset($water['End']) ? $water['End'] : 0);
					$billing_wie_classified[$result['customer_group_id']]['water']['Start'] = (isset($water['Start']) ? $water['Start'] : 0);
					$billing_wie_classified[$result['customer_group_id']]['water']['Charged'] = $charge;
					$billing_wie_classified[$result['customer_group_id']]['water']['ok'] = (($w_usage == 0) ? 'no' : 'yes');
					
					//garbage
					$billing_wie_classified[$result['customer_group_id']]['garbage'] = (((int)$result['type_id'] == 3) ? $this->model_price_standard->getGarbageStandardPrice($this->model_price_standard->getGarbageLastModified()['id'])[0]['Price']: null);
					//late 3 times
					$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "wie_late_record WHERE room_id = '" . (int)$result['customer_group_id'] . "'");
			
					if($query->num_rows) {
						$billing_wie_classified[$result['customer_group_id']]['late_times'] = $query->row['times'];
					}
					else {
						$billing_wie_classified[$result['customer_group_id']]['late_times'] = 0;
					}
					//deadline edit 
					if ($deadline) {
						$deadline_edit = (int)$deadline['deadline_edit'];
					} else {
						$deadline_edit = 5;
					}
					
					$today = date('d');
						
					if((int)$today <= (int)$deadline_edit) {
						$canedit = 'yes';
					}
					else {
						$canedit = 'no';
					}
					$billing_wie_classified[$result['customer_group_id']]['can_edit'] = $canedit;
					//deadline supply
					if ($deadline) {
						$deadline_supply = (int)$deadline['deadline_supply'];
					} else {
						$deadline_supply = 5;
					}
					
					if((int)$today <= (int)$deadline_supply) {
						$supply = 'yes';
					}
					else {
						$supply = 'no';
					}	
					$billing_wie_classified[$result['customer_group_id']]['is_supply'] = $supply;
					
					$totalmoney += $money;
				}
				
				$billing_wie_classified[$result['customer_group_id']]['totalmoney'] = number_format($totalmoney,0);
				$billing_wie_classified[$result['customer_group_id']]['inword'] = $this->convert_number_to_words((int)$totalmoney). ' đồng';
				
				if($elec && $water) {
					$floors_input[$floor_idx]['rooms'][] = array(
						'customer_group_id' => $result['customer_group_id'],
						'floor_id' => $result['floor_id'],
						'pay_month' => $cur_month.'-'.substr($cur_year,2,2),
						'name'              => $result['name'] . (($result['customer_group_id'] == $this->config->get('config_manage_wie_id')) ? $this->language->get('text_default') : null),
						'sort_order'        => $result['sort_order'],
						'selected'          => isset($this->request->post['selected']) && in_array($result['manage_wie_id'], $this->request->post['selected']),
						'room_data'			=> ((isset($billing_wie_classified[$result['customer_group_id']])) ? $billing_wie_classified[$result['customer_group_id']] : null)
					);
				}
			}	
		}
		
		
		$filter_data = array();
		
		if(isset($filter['filter_floor'])) {
			$filter_data = array('floor' => $filter['filter_floor']);
		}
		
		if(isset($filter['filter_floor'])) {
			$filtered_floor = array();
			foreach($floors_input as $key => $floor) {
				if((int)$floor['floor_id'] == (int)$filter['filter_floor']) {
					$filtered_floor[$key] = $floor;
				}
			}
		}
		
		if(isset($filter['filter_room'])) {
			$filtered_floor = array();
			foreach($floors_input as $key => $floor) {
				if(isset($floor['rooms'])) {
					foreach($floor['rooms'] as $ridx => $room) {
						if((int)$room['customer_group_id'] == (int)$filter['filter_room']) {
							$filtered_floor[$key] = $floor;
							$filtered_floor[$key]['rooms'] = array();
							$filtered_floor[$key]['rooms'][] = $room;
						}
					}
				}
			}
		}
		
		if(isset($filter['filter_floor']) || isset($filter['filter_room'])) { 
			return $filtered_floor;
		}
		else {
			return $floors_input;
		}
	}
	
	public function getRoomView($filter){
		//floors and room
		$block_id = 1;
		$this->load->model('sale/manage_wie');
		$rooms_input = $this->model_sale_manage_wie->getCustomerGroups();
		$floors_input = $this->model_sale_manage_wie->getFloors($block_id);
		
		//get electric and water limit data
		$this->load->model('price/standard');
		$e_standard_idx = $this->model_price_standard->getElectricityLastestLifeTime();
		$e_standard = $this->model_price_standard->getElectricityStandardPrice((int)$e_standard_idx['id']);
		
		$w_standard_idx = $this->model_price_standard->getWaterLastestLifeTime();
		$w_standard = $this->model_price_standard->getWaterStandardPrice((int)$w_standard_idx['id']);
       
		$d_year = date('Y');
		$d_month = date('m');
		$period = $d_month.'-'.$d_year;
		$deadline = $this->getDeadline($period);
		if ($deadline) {
			$dead_line = (int)$deadline['deadline_charge'];
		} else {
			$dead_line = 10;
		}

		foreach($floors_input as $floor_idx => $floor) {
			$data = array('floor' => $floor['floor_id']);
			$floors_input[$floor_idx]['name']=$floors_input[$floor_idx]['floor_name'];
			$floors_input[$floor_idx]['wpay'] = 0;
			$floors_input[$floor_idx]['wpaid'] = 0;
			$floors_input[$floor_idx]['epay'] = 0;
			$floors_input[$floor_idx]['epaid'] = 0;
			$floors_input[$floor_idx]['delay'] = 0;


			for($yy = $filter['year_start']; $yy <= $filter['year_end']; $yy++)
			{

				if($yy<$filter['year_end'] && $yy==$filter['year_start'])
				{
					$mstart=$filter['month_start'];
					$mend=12;
				}
				else if($yy<$filter['year_end'] && $yy>$filter['year_start'])
				{
					$mstart=1;
					$mend=12;
				}
				else 
				{
					$mstart=$filter['month_start'];
					$mend=$filter['month_end'];
				}
				
				for($mm = $mstart; $mm <= $mend; $mm++)
				{					

					$results = $this->model_sale_manage_wie->getCustomerGroups($data);
				
					foreach ($results as $result) {

						$totalmoney = 0;
						$elec = $this->model_sale_manage_wie->getElectricLogByRoomIdDate($result['customer_group_id'],$mm, $yy);
						//echo '<br/>dien:<br/>'.print_r($elec);
						if(isset($elec)) {
							//$billing_wie_classified[$result['customer_group_id']]['elec'] = $elec;
							if(isset($elec['End']) && isset($elec['Start'])) {
								$e_usage = (int)$elec['End'] - (int)$elec['Start'];
							}
							else {
								$e_usage = 0;
							}
							
							$charge = 'no';
							if(isset($elec['charged']) && (int)$elec['charged'] == 1) {
								$day = date('d', strtotime($elec['charged_date']));
								
								if((int)$day <= (int)$dead_line) {
									$charge = 'yes';
								}
								else {
									$charge = 'late';
								}
							}
							else {
								$charge = 'no';
							}
							
							
							$money = $this->calculate_money_elec($e_standard, $e_usage);
							
							$floors_input[$floor_idx]['epay'] += $money;
							if($charge!='no')
							{
								$floors_input[$floor_idx]['epaid'] += $money;
							}
						}
						
						$water = $this->model_sale_manage_wie->getWaterLogByRoomIdDate($result['customer_group_id'],$mm, $yy);					
						//echo '<br/>nuoc:<br/>'.print_r($water);
						if(isset($water)) {
							//$billing_wie_classified[$result['customer_group_id']]['water'] = $water ;
							if(isset($water['End']) && isset($water['Start'])) {
								$w_usage = (int)$water['End'] - (int)$water['Start'];
							}
							else {
								$w_usage = 0;
							}
							
							$charge = 'no';
							if(isset($water['charged']) && (int)$water['charged'] == 1) {
								$day = date('d', strtotime($water['charged_date']));
								
								if((int)$day <= (int)$dead_line) {
									$charge = 'yes';
								}
								else {
									$charge = 'late';
								}
							}
							else {
								$charge = 'no';
							}
							
							$money = $this->calculate_money_water($w_standard, $w_usage, $result['customer_group_id']);
							$floors_input[$floor_idx]['wpay'] += $money;
							if($charge!='no')
							{
								$floors_input[$floor_idx]['wpaid'] += $money;
							}
						}
					}				
				}
			}	
		}
		
		
			return $floors_input;
		
	}

	public function getFloorView($filter){
		//floors and room
		$block_id = 1;
		$this->load->model('sale/manage_wie');
		$rooms_input = $this->model_sale_manage_wie->getCustomerGroups();
		$floors_input = $this->model_sale_manage_wie->getFloors($block_id);
		
		//get electric and water limit data
		$this->load->model('price/standard');
		$e_standard_idx = $this->model_price_standard->getElectricityLastestLifeTime();
		$e_standard = $this->model_price_standard->getElectricityStandardPrice((int)$e_standard_idx['id']);
		
		$w_standard_idx = $this->model_price_standard->getWaterLastestLifeTime();
		$w_standard = $this->model_price_standard->getWaterStandardPrice((int)$w_standard_idx['id']);
       	
		$d_year = date('Y');
		$d_month = date('m');
		$period = $d_month.'-'.$d_year;
		$deadline = $this->getDeadline($period);
		if ($deadline) {
			$dead_line = (int)$deadline['deadline_charge'];
		} else {
			$dead_line = 10;
		}
		
		foreach($floors_input as $floor_idx => $floor) {
			$data = array('floor' => $floor['floor_id']);
			$floors_input[$floor_idx]['name']=$floors_input[$floor_idx]['floor_name'];
			$floors_input[$floor_idx]['wpay'] = 0;
			$floors_input[$floor_idx]['wpaid'] = 0;
			$floors_input[$floor_idx]['epay'] = 0;
			$floors_input[$floor_idx]['epaid'] = 0;


			for($yy = $filter['year_start']; $yy <= $filter['year_end']; $yy++)
			{

				if($yy<$filter['year_end'] && $yy==$filter['year_start'])
				{
					$mstart=$filter['month_start'];
					$mend=12;
				}
				else if($yy<$filter['year_end'] && $yy>$filter['year_start'])
				{
					$mstart=1;
					$mend=12;
				}
				else 
				{
					$mstart=$filter['month_start'];
					$mend=$filter['month_end'];
				}
				for($mm = $mstart; $mm <= $mend; $mm++)
				{					

					$results = $this->model_sale_manage_wie->getCustomerGroups($data);
				
					foreach ($results as $result) {

						$totalmoney = 0;
						$elec = $this->model_sale_manage_wie->getElectricLogByRoomIdDate($result['customer_group_id'],$mm, $yy);
						//echo '<br/>dien:<br/>'.print_r($elec);
						if(isset($elec)) {
							//$billing_wie_classified[$result['customer_group_id']]['elec'] = $elec;
							if(isset($elec['End']) && isset($elec['Start'])) {
								$e_usage = (int)$elec['End'] - (int)$elec['Start'];
							}
							else {
								$e_usage = 0;
							}
							
							$charge = 'no';
							if(isset($elec['charged']) && (int)$elec['charged'] == 1) {
								$day = date('d', strtotime($elec['charged_date']));
								
								if((int)$day <= (int)$dead_line) {
									$charge = 'yes';
								}
								else {
									$charge = 'late';
								}
							}
							else {
								$charge = 'no';
							}
							
							
							$money = $this->calculate_money_elec($e_standard, $e_usage);
							
							$floors_input[$floor_idx]['epay'] += $money;
							if($charge!='no')
							{
								$floors_input[$floor_idx]['epaid'] += $money;
							}
						}
						
						$water = $this->model_sale_manage_wie->getWaterLogByRoomIdDate($result['customer_group_id'],$mm, $yy);					
						//echo '<br/>nuoc:<br/>'.print_r($water);
						if(isset($water)) {
							//$billing_wie_classified[$result['customer_group_id']]['water'] = $water ;
							if(isset($water['End']) && isset($water['Start'])) {
								$w_usage = (int)$water['End'] - (int)$water['Start'];
							}
							else {
								$w_usage = 0;
							}
							
							$charge = 'no';
							if(isset($water['charged']) && (int)$water['charged'] == 1) {
								$day = date('d', strtotime($water['charged_date']));
								
								if((int)$day <= (int)$dead_line) {
									$charge = 'yes';
								}
								else {
									$charge = 'late';
								}
							}
							else {
								$charge = 'no';
							}
							
							$money = $this->calculate_money_water($w_standard, $w_usage, $result['customer_group_id']);

							$floors_input[$floor_idx]['wpay'] += $money;
							if($charge!='no')
							{
								$floors_input[$floor_idx]['wpaid'] += $money;
							}
						}
					}				
				}
			}	
		}		
		return $floors_input;
		
	}

	public function getRoomViewById($filter){
		//floors and room
		$block_id = 1;
		$this->load->model('sale/manage_wie');
		
		$rooms_input = $this->model_sale_manage_wie->getCustomerGroups($filter);
		
		//get electric and water limit data
		$this->load->model('price/standard');
		$e_standard_idx = $this->model_price_standard->getElectricityLastestLifeTime();
		$e_standard = $this->model_price_standard->getElectricityStandardPrice((int)$e_standard_idx['id']);
		
		$w_standard_idx = $this->model_price_standard->getWaterLastestLifeTime();
		$w_standard = $this->model_price_standard->getWaterStandardPrice((int)$w_standard_idx['id']);
       
		$d_year = date('Y');
		$d_month = date('m');
		$period = $d_month.'-'.$d_year;
		$deadline = $this->getDeadline($period);
		if ($deadline) {
			$dead_line = (int)$deadline['deadline_charge'];
		} else {
			$dead_line = 10;
		}

		foreach($rooms_input as $room_idx => $room) {
			$rooms_input[$room_idx]['wpay'] = 0;
			$rooms_input[$room_idx]['wpaid'] = 0;
			$rooms_input[$room_idx]['epay'] = 0;
			$rooms_input[$room_idx]['epaid'] = 0;


			for($yy = $filter['year_start']; $yy <= $filter['year_end']; $yy++)
			{

				if($yy<$filter['year_end'] && $yy==$filter['year_start'])
				{
					$mstart=$filter['month_start'];
					$mend=12;
				}
				else if($yy<$filter['year_end'] && $yy>$filter['year_start'])
				{
					$mstart=1;
					$mend=12;
				}
				else 
				{
					$mstart=$filter['month_start'];
					$mend=$filter['month_end'];
				}
				for($mm = $mstart; $mm <= $mend; $mm++)
				{					

						$totalmoney = 0;
						$elec = $this->model_sale_manage_wie->getElectricLogByRoomIdDate($rooms_input[$room_idx]['customer_group_id'],$mm, $yy);
						//echo '<br/>dien:<br/>'.print_r($elec);
						if(isset($elec)) {
							//$billing_wie_classified[$result['customer_group_id']]['elec'] = $elec;
							if(isset($elec['End']) && isset($elec['Start'])) {
								$e_usage = (int)$elec['End'] - (int)$elec['Start'];
							}
							else {
								$e_usage = 0;
							}
							
							$charge = 'no';
							if(isset($elec['charged']) && (int)$elec['charged'] == 1) {
								$day = date('d', strtotime($elec['charged_date']));
								
								if((int)$day <= (int)$dead_line) {
									$charge = 'yes';
								}
								else {
									$charge = 'late';
								}
							}
							else {
								$charge = 'no';
							}
							
							
							$money = $this->calculate_money_elec($e_standard, $e_usage);
							
							$rooms_input[$room_idx]['epay'] += $money;
							if($charge!='no')
							{
								$rooms_input[$room_idx]['epaid'] += $money;
							}
						}
						
						$water = $this->model_sale_manage_wie->getWaterLogByRoomIdDate($rooms_input[$room_idx]['customer_group_id'],$mm, $yy);					
						//echo '<br/>nuoc:<br/>'.print_r($water);
						if(isset($water)) {
							//$billing_wie_classified[$result['customer_group_id']]['water'] = $water ;
							if(isset($water['End']) && isset($water['Start'])) {
								$w_usage = (int)$water['End'] - (int)$water['Start'];
							}
							else {
								$w_usage = 0;
							}
							
							$charge = 'no';
							if(isset($water['charged']) && (int)$water['charged'] == 1) {
								$day = date('d', strtotime($water['charged_date']));
								
								if((int)$day <= (int)$dead_line) {
									$charge = 'yes';
								}
								else {
									$charge = 'late';
								}
							}
							else {
								$charge = 'no';
							}
							
							$money = $this->calculate_money_water($w_standard, $w_usage, $rooms_input[$room_idx]['customer_group_id']);
							//echo "$w_usage: $money<br />";
							$rooms_input[$room_idx]['wpay'] += $money;
							if($charge!='no')
							{
								$rooms_input[$room_idx]['wpaid'] += $money;
							}
						}
									
				}
			}	
		}
		
		return $rooms_input;
		
	}

	public function getRoomStat($filter){
		//floors and room
		
		$this->load->model('sale/manage_wie');
		
		$rooms_input = $this->model_sale_manage_wie->getCustomerGroups($filter);
		
		//get electric and water limit data
		$roomstat=array();
		$roomstat[0]['wcount']=0;
		$roomstat[0]['wlist']='';
		$roomstat[0]['ecount']=0;
		$roomstat[0]['elist']='';
		$roomstat[1]['wcount']=0;
		$roomstat[1]['wlist']='';
		$roomstat[1]['ecount']=0;
		$roomstat[1]['elist']='';
		$roomstat[2]['wcount']=0;
		$roomstat[2]['wlist']='';
		$roomstat[2]['ecount']=0;
		$roomstat[2]['elist']='';
		
		$d_year = date('Y');
		$d_month = date('m');
		$period = $d_month.'-'.$d_year;
		$deadline = $this->getDeadline($period);
		if ($deadline) {
			$dead_line = (int)$deadline['deadline_charge'];
		} else {
			$dead_line = 10;
		}

		foreach($rooms_input as $room_idx => $room) {
			$wcount=0;
			$ecount=0;


			for($yy = $filter['year_start']; $yy <= $filter['year_end']; $yy++)
			{

				if($yy<$filter['year_end'] && $yy==$filter['year_start'])
				{
					$mstart=$filter['month_start'];
					$mend=12;
				}
				else if($yy<$filter['year_end'] && $yy>$filter['year_start'])
				{
					$mstart=1;
					$mend=12;
				}
				else 
				{
					$mstart=$filter['month_start'];
					$mend=$filter['month_end'];
				}
				for($mm = $mstart; $mm <= $mend; $mm++)
				{					

						
						$elec = $this->model_sale_manage_wie->getElectricLogByRoomIdDate($rooms_input[$room_idx]['customer_group_id'],$mm, $yy);
						//echo '<br/>dien:<br/>'.print_r($elec);
						if(isset($elec)) {
							//$billing_wie_classified[$result['customer_group_id']]['elec'] = $elec;
							if(isset($elec['charged']) && (int)$elec['charged'] == 1) {
								$day = date('d', strtotime($elec['charged_date']));
								
								if((int)$day <= (int)$dead_line) {
									
								}
								else {
									$ecount++;
								}
							}
							else {
								$ecount++;
							}
							
							
							
						}
						
						$water = $this->model_sale_manage_wie->getWaterLogByRoomIdDate($rooms_input[$room_idx]['customer_group_id'],$mm, $yy);					
						//echo '<br/>nuoc:<br/>'.print_r($water);
						if(isset($water)) {
							if(isset($water['charged']) && (int)$water['charged'] == 1) {
								$day = date('d', strtotime($water['charged_date']));
								
								if((int)$day <= (int)$dead_line) {
									
								}
								else {
									$wcount++;
								}
							}
							else {
								$wcount++;
							}
						}
									
				}
			}
			if($wcount==0)	
				$roomstat[0]['wcount']++;
			else if($wcount==1)	
			{
				$roomstat[1]['wcount']++;
				$roomstat[1]['wlist']=$roomstat[1]['wlist'].', '.$room['name'];
			}
			else
			{
				$roomstat[2]['wcount']++;
				$roomstat[2]['wlist']=$roomstat[2]['wlist'].', '.$room['name'];
			}

			if($ecount==0)	
				$roomstat[0]['ecount']++;
			else if($wcount==1)	
			{
				$roomstat[1]['ecount']++;
				$roomstat[1]['elist']=$roomstat[1]['elist'].', '.$room['name'];
			}
			else
			{
				$roomstat[2]['ecount']++;
				$roomstat[2]['elist']=$roomstat[2]['elist'].', '.$room['name'];
			}

		}
		if(strlen($roomstat[1]['wlist'])>0)
			$roomstat[1]['wlist'] = substr($roomstat[1]['wlist'], 2);
		if(strlen($roomstat[1]['elist'])>0)
			$roomstat[1]['elist'] = substr($roomstat[1]['elist'], 2);
		if(strlen($roomstat[2]['wlist'])>0)
			$roomstat[2]['wlist'] = substr($roomstat[2]['wlist'], 2);
		if(strlen($roomstat[2]['elist'])>0)
			$roomstat[2]['elist'] = substr($roomstat[2]['elist'], 2);

		return $roomstat;
		
	}
	
	public function inputUsage($data) {
		$date = new DateTime();
		$date->setDate($data['year'], $data['month'], 1);
		$date_final = $date->format('Y-m-d  H:i:s');
		
		foreach($data['electric_usage'] as $key => $elec) {
			if(isset($elec['usage'])) {
				if(!$this->checkElectricInput($elec['room_id'], $data['year'], $data['month'])) {
					$last_usage_data = $this->getLastUsageElec($elec['room_id'],$data['month'], $data['year']);
					if($last_usage_data != -1) {
						$last_usage =  (int)$last_usage_data['End'] + 1;
					}
					else {
						$last_usage =  1;
					}
					
					if((int)$elec['usage'] > (int)$last_usage) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "e_record SET date_added = '" . $date_final . "', RoomID = '" . (int)$elec['room_id'] . "', Start = '" . (int)$last_usage . "', End = '" . (int)$elec['usage'] . "', date_modified = NOW()");
						$data['electric_usage'][$key]['input'] = 1;
					}
					else {
						$data['electric_usage'][$key]['error'] = 1;
					}
				}
				else {
					$result = $this->checkElectricIfEditing($elec['room_id'], $data['year'], $data['month'], $elec['usage']);
					if($result == 'edit') {
						$data['electric_usage'][$key]['edit'] = 1;
					}
					else if($result == 'error') {
						$data['electric_usage'][$key]['error'] = 1;
					}
				}
			}
		}
		
		foreach($data['water_usage'] as $key => $water) {
			if(isset($water['usage'])) {
				if(!$this->checkWaterInput($water['room_id'], $data['year'], $data['month'])) {
					$last_usage_data = $this->getLastUsageWater($water['room_id'],$data['month'], $data['year']);
					if($last_usage_data != -1) {
						$last_usage =  (int)$last_usage_data['End'] + 1;
					}
					else {
						$last_usage =  1;
					}
					
					if((int)$water['usage'] > (int)$last_usage) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "w_record SET date_added = '" . $date_final . "', RoomID = '" . (int)$water['room_id'] . "', Start = '" . (int)$last_usage . "', End = '" . (int)$water['usage'] . "', date_modified = NOW()");
						$data['water_usage'][$key]['input'] = 1;
					}
					else {
						$data['water_usage'][$key]['error'] = 1;
					}
				}
				else {
					$result = $this->checkWaterIfEditing($water['room_id'], $data['year'], $data['month'], $water['usage']);
					if($result == 'edit') {
						$data['water_usage'][$key]['edit'] = 1;
					}
					else if($result == 'error') {
						$data['water_usage'][$key]['error'] = 1;
					}
				}
			}
		}
		
		return $data;
	}
	
	public function saveEditWie($data){
		$this->db->query("UPDATE " . DB_PREFIX . "e_record SET End = '" . (int)$data['end_elec'] . "', charged = " . (int)$data['check_paid'] . (((int)$data['check_paid'] == 1) ? " , charged_date = NOW() " : "") ." where RoomID = " . (int)$data['room_id']);
		$this->db->query("UPDATE " . DB_PREFIX . "w_record SET End = '" . (int)$data['end_water'] . "', charged = " . (int)$data['check_paid'] . (((int)$data['check_paid'] == 1) ? " , charged_date = NOW() " : "") . " where RoomID = " . (int)$data['room_id']);
	}
	
	public function elec_charged($room_id){
		$this->db->query("UPDATE " . DB_PREFIX . "e_record SET charged = 1, charged_date = NOW() where RoomID = " . $room_id);
	}
	
	public function water_charged($room_id){
		$this->db->query("UPDATE " . DB_PREFIX . "w_record SET charged = 1, charged_date = NOW() where RoomID = " . $room_id);
	}
	
	public function updateWIELateRecord($room_id) {
		$d_year = date('Y');
		$d_month = date('m');
		$period = $d_month.'-'.$d_year;
		$deadline = $this->getDeadline($period);
		if ($deadline) {
			$dead_line = (int)$deadline['deadline_charge'];
		} else {
			$dead_line = 10;
		}
		
		$day = date('d', strtotime(date('Y-m-d  H:i:s')));
						
		if((int)$day > (int)$dead_line) {
			$charge = 'late';
			
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "wie_late_record WHERE room_id = '" . $room_id . "'");
			
			if($query->num_rows) {
				$this->db->query("UPDATE " . DB_PREFIX . "wie_late_record SET `times` = '" . ((int)$query->row['times'] + 1) . "' WHERE `room_id` = '" . $room_id . "'");
			}
			else {
				$this->db->query("INSERT INTO " . DB_PREFIX . "wie_late_record SET `room_id` = '" . $room_id . "', `times` = '1'");
			}
		}
	}
	
	public function confirmRoomElec($data){
		$result = $this->checkElectricIfEditing($data['room_id'], $data['year'], $data['month'], $data['elec_val']);
		if($result == 'error') {
			return $result;
		}
		else if($result != 'no') {
			$this->db->query("UPDATE " . DB_PREFIX . "e_record SET End = '" . (int)$data['elec_val'] . "', date_modified = NOW() WHERE RoomID = '" . (int)$data['room_id'] . "' AND MONTH(date_added) = " . (int)$data['month'] . " AND YEAR(date_added) = " . (int)$data['year']);
			return 'yes';
		}
	}
	
	public function confirmRoomWater($data){
		$result = $this->checkWaterIfEditing($data['room_id'], $data['year'], $data['month'], $data['water_val']);
		if($result == 'error') {
			return $result;
		}
		else if($result != 'no') {
			$this->db->query("UPDATE " . DB_PREFIX . "w_record SET End = '" . (int)$data['water_val'] . "', date_modified = NOW() WHERE RoomID = '" . (int)$data['room_id'] . "' AND MONTH(date_added) = " . (int)$data['month'] . " AND YEAR(date_added) = " . (int)$data['year']);
			return 'yes';
		}
	}
	
	public function checkElectricIfEditing($room_id, $year, $month, $new_val){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "e_record WHERE RoomID = '" . (int)$room_id . "' AND MONTH(date_added) = " . (int)$month . " AND YEAR(date_added) = " . (int)$year);
		
		if($query->num_rows) {
			$last_query = $this->db->query("SELECT MAX(date_added), End FROM " . DB_PREFIX . "e_record WHERE RoomID = '" . (int)$room_id . "' GROUP BY RoomID");
			$last_value =  $last_query->row;
			$result = $query->row;
			if((int)$result['End'] == (int)$new_val) {
				return 'no';
			}
			else if($last_query->num_rows && (int)$last_value['End'] >= (int)$new_val) {
				return 'error';
			}
			else if((int)$result['End'] != (int)$new_val) {
				return 'edit';
			}
			
		}
		return 'yes';
	}
	
	public function checkWaterIfEditing($room_id, $year, $month, $new_val){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "w_record WHERE RoomID = '" . (int)$room_id . "' AND MONTH(date_added) = " . (int)$month . " AND YEAR(date_added) = " . (int)$year);
		
		if($query->num_rows) {
			$last_query = $this->db->query("SELECT MAX(date_added), End FROM " . DB_PREFIX . "w_record WHERE RoomID = '" . (int)$room_id . "' GROUP BY RoomID");
			$last_value =  $last_query->row;
			$result = $query->row;
			if((int)$result['End'] == (int)$new_val) {
				return 'no';
			}
			else if($last_query->num_rows && (int)$last_value['End'] >= (int)$new_val) {
				return 'error';
			}
			else if((int)$result['End'] != (int)$new_val) {
				return 'edit';
			}			
		}
		return 'yes';
	}
	
	public function countStudentInRoom($room_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE customer_group_id = '" . (int)$room_id . "'");
		
		return $query->row['total'];
	}
	
	public function getStudentIDFromCardID($card_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "card_id_to_student_id WHERE card_id = '" . trim($card_id) . "'");
		
		if($query->num_rows) {
			$student_id =  $query->row['student_id'];
			
			$query2 = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE student_id = '" . (int)$student_id . "'");
			
			if($query2->num_rows) {
				$query3 = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_group WHERE customer_group_id = '" . (int)$query2->row['customer_group_id'] . "'");
					
				if($query3->num_rows) {
					$temp = $query2->row;
					$temp['room_lead'] = $query3->row;
				}
				
				return $temp;
			}
		}
		
		return null;
	}
	
	public function getRoomEmails($room_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_group_id = '" . $room_id . "'");
		
		return $query->rows;
	}
	
	public function checkElectricInput($room_id, $year, $month) {
		$date = new DateTime();
		$date->setDate($year, $month, 1);
		$date_final = $date->format('Y-m-d  H:i:s');
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "e_record WHERE RoomID = '" . (int)$room_id . "' AND MONTH(date_added) = " . (int)$month . " AND YEAR(date_added) = " . (int)$year);
		
		if($query->num_rows) {
			return true;
		}
		return false;
	}
	
	public function checkWaterInput($room_id, $year, $month) {
		$date = new DateTime();
		$date->setDate($year, $month, 1);
		$date_final = $date->format('Y-m-d  H:i:s');
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "w_record WHERE RoomID = '" . (int)$room_id . "' AND MONTH(date_added) = " . (int)$month . " AND YEAR(date_added) = " . (int)$year);
		
		if($query->num_rows) {
			return true;
		}
		return false;
	}
	
	public function getLastUsageElec($room_id, $month, $year) {
		$query = $this->db->query("SELECT End FROM " . DB_PREFIX . "e_record WHERE RoomID = '" . (int)$room_id . "' AND MONTH(date_added) = " . (int)$month . " AND YEAR(date_added) = " . (int)$year);
		if(!$query->num_rows) {
			return -1;
		}
		return $query->row;
	}
	
	public function getLastUsageWater($room_id, $month, $year) {
		$query = $this->db->query("SELECT End FROM " . DB_PREFIX . "w_record WHERE RoomID = '" . (int)$room_id . "' AND MONTH(date_added) = " . (int)$month . " AND YEAR(date_added) = " . (int)$year);
		if(!$query->num_rows) {
			return -1;	
		}
		return $query->row;
	}
	
	public function getElectricLogByRoomIdDate($room_id, $month, $year) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "e_record WHERE `RoomID` = '" . (int)$room_id . "' AND MONTH(date_added) = '" . (int)$month . "' AND YEAR(date_added) = '" . (int)$year . "'");
		
		return $query->row;
	}
	
	public function getWaterLogByRoomIdDate($room_id, $month, $year) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "w_record WHERE `RoomID` = '" . (int)$room_id . "' AND MONTH(date_added) = '" . (int)$month . "' AND YEAR(date_added) = '" . (int)$year . "'");
		
		return $query->row;
	}

	
	public function getElectricLogByRoomId($room_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "e_record WHERE `RoomID` = '" . (int)$room_id . "' AND MONTH(date_added) = '" . date('m') . "' AND YEAR(date_added) = '" . date('Y') . "'");
		
		return $query->row;
	}
	
	public function getWaterLogByRoomId($room_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "w_record WHERE `RoomID` = '" . (int)$room_id . "' AND MONTH(date_added) = '" . date('m') . "' AND YEAR(date_added) = '" . date('Y') . "'");
		
		return $query->row;
	}
	
	public function getElectricLogPreviousMonthByRoomId($room_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "e_record WHERE `RoomID` = '" . (int)$room_id . "' AND MONTH(date_added) = '" . ((int)date('m') - 1) . "' AND YEAR(date_added) = '" . date('Y') . "'");
		
		return $query->row;
	}
	
	public function getWaterLogPreviousMonthByRoomId($room_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "w_record WHERE `RoomID` = '" . (int)$room_id . "' AND MONTH(date_added) = '" . ((int)date('m') - 1) . "' AND YEAR(date_added) = '" . date('Y') . "'");
		
		return $query->row;
	}
	
	public function getMonthHasData($room_id) {
		$query = $this->db->query("SELECT MONTH(date_added) as month, YEAR(date_added) as year FROM " . DB_PREFIX . "w_record WHERE `RoomID` = '" . $room_id . "' GROUP BY month, year  ORDER BY date_added desc");
		
		return $query->rows;
	}
		
	public function getFloors($block) {
		$sql = "SELECT * FROM " . DB_PREFIX . "floor f LEFT JOIN " . DB_PREFIX . "floor_description fd ON(f.floor_id = fd.floor_id) WHERE fd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND block_id=". $block;
		
		$query = $this->db->query($sql);
		
		return $query->rows;
	}
	
	public function getCustomerGroup($customer_group_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customer_group cg LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (cg.customer_group_id = cgd.customer_group_id) LEFT JOIN " . DB_PREFIX . "room_type rt ON ( cg.type_id = rt.type_id AND cgd.language_id = rt.language_id ) WHERE cg.customer_group_id = '" . (int)$customer_group_id . "' AND cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		return $query->row;
	}
	
	public function getCustomerGroupForInput($customer_group_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customer_group cg LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (cg.customer_group_id = cgd.customer_group_id) LEFT JOIN " . DB_PREFIX . "room_type rt ON ( cg.type_id = rt.type_id AND cgd.language_id = rt.language_id ) WHERE cg.customer_group_id = '" . (int)$customer_group_id . "' AND cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		//get electric and water limit data
		$this->load->model('price/standard');
		$e_standard_idx = $this->model_price_standard->getElectricityLastestLifeTime();
		$e_standard = $this->model_price_standard->getElectricityStandardPrice((int)$e_standard_idx['id']);
		
		$w_standard_idx = $this->model_price_standard->getWaterLastestLifeTime();
		$w_standard = $this->model_price_standard->getWaterStandardPrice((int)$w_standard_idx['id']);
		
		//get data also
		$result = $query->row;
		$billing_wie_classified = array();
		$output = array();
		
		$cur_elec = $this->getElectricLogByRoomId($result['customer_group_id']);				
		$cur_water = $this->getWaterLogByRoomId($result['customer_group_id']);
		
		$pre_elec = $this->getElectricLogPreviousMonthByRoomId($result['customer_group_id']);
		$pre_water = $this->getWaterLogPreviousMonthByRoomId($result['customer_group_id']);
		
		if(!($cur_elec && $cur_water)) {
			$output = array(
					'customer_group_id' => $result['customer_group_id'],
					'floor_id' => $result['floor_id'],
					'name'              => $result['name'] . (($result['customer_group_id'] == $this->config->get('config_manage_wie_id')) ? $this->language->get('text_default') : null),
					'sort_order'        => $result['sort_order'],
					'selected'          => isset($this->request->post['selected']) && in_array($result['manage_wie_id'], $this->request->post['selected']),
					'last_elec' => (($pre_elec) ? (int)$pre_elec['End'] + 1 : 0),
					'last_water' => (($pre_water) ? (int)$pre_water['End'] + 1: 0),
				);
		}
		//end get data
		
		return $output;
	}
	
	public function getCustomerGroups($data = array()) {
		$sql = "SELECT *, (SELECT COUNT( * ) FROM " . DB_PREFIX . "customer c WHERE c.customer_group_id = cg.customer_group_id) AS assigned FROM " . DB_PREFIX . "customer_group cg LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (cg.customer_group_id = cgd.customer_group_id) LEFT JOIN " . DB_PREFIX . "room_type rt ON ( cg.type_id = rt.type_id AND cgd.language_id = rt.language_id ) WHERE cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
		$sort_data = array(
			'cg.name',
			'cg.sort_order'
		);	
		if (isset($data['floor']))
		{
			$sql .= " AND floor_id = " . $data['floor'];	
		}
			
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY cg.name";	
		}
			
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}
		
			
		$query = $this->db->query($sql);
		
		return $query->rows;
	}

	public function getCustomerGroupsForInput($data = array()) {
		$sql = "SELECT *, (SELECT COUNT( * ) FROM " . DB_PREFIX . "customer c WHERE c.customer_group_id = cg.customer_group_id) AS assigned FROM " . DB_PREFIX . "customer_group cg LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (cg.customer_group_id = cgd.customer_group_id) LEFT JOIN " . DB_PREFIX . "room_type rt ON ( cg.type_id = rt.type_id AND cgd.language_id = rt.language_id ) WHERE cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
		$sort_data = array(
			'cg.name',
			'cg.sort_order'
		);	
		if (isset($data['floor']))
		{
			$sql .= " AND floor_id = " . $data['floor'];	
		}
			
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY cg.name";	
		}
			
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}
		
			
		$query = $this->db->query($sql);
		
		//get electric and water limit data
		$this->load->model('price/standard');
		$e_standard_idx = $this->model_price_standard->getElectricityLastestLifeTime();
		$e_standard = $this->model_price_standard->getElectricityStandardPrice((int)$e_standard_idx['id']);
		
		$w_standard_idx = $this->model_price_standard->getWaterLastestLifeTime();
		$w_standard = $this->model_price_standard->getWaterStandardPrice((int)$w_standard_idx['id']);
		
		//get data also
		$results = $query->rows;
		$billing_wie_classified = array();
		$output = array();
		foreach ($results as $result) {
			$cur_elec = $this->getElectricLogByRoomId($result['customer_group_id']);				
			$cur_water = $this->getWaterLogByRoomId($result['customer_group_id']);
			
			$pre_elec = $this->getElectricLogPreviousMonthByRoomId($result['customer_group_id']);
			$pre_water = $this->getWaterLogPreviousMonthByRoomId($result['customer_group_id']);
			
			if(!($cur_elec && $cur_water)) {
				$output[] = array(
						'customer_group_id' => $result['customer_group_id'],
						'floor_id' => $result['floor_id'],
						'name'              => $result['name'] . (($result['customer_group_id'] == $this->config->get('config_manage_wie_id')) ? $this->language->get('text_default') : null),
						'sort_order'        => $result['sort_order'],
						'selected'          => isset($this->request->post['selected']) && in_array($result['manage_wie_id'], $this->request->post['selected']),
						'last_elec' => (($pre_elec) ? (int)$pre_elec['End'] + 1 : 0),
						'last_water' => (($pre_water) ? (int)$pre_water['End'] + 1: 0),
						'cur_elec' => (($cur_elec) ? (int)$cur_elec['End'] : 0),
						'cur_water' => (($cur_water) ? (int)$cur_water['End'] : 0),
					);
			}
		}
		//end get data
		
		return $output;
	}
	
	public function convert_number_to_words($number) { 
		$hyphen      = ' '; 
		$conjunction = '  '; 
		$separator   = ' '; 
		$negative    = 'negative '; 
		$decimal     = ' point '; 
		$dictionary  = array( 
		0                   => 'không', 
		1                   => 'một', 
		2                   => 'hai', 
		3                   => 'ba', 
		4                   => 'bốn', 
		5                   => 'năm', 
		6                   => 'sáu', 
		7                   => 'bảy', 
		8                   => 'tám', 
		9                   => 'chín', 
		10                  => 'mười', 
		11                  => 'mười một', 
		12                  => 'mười hai', 
		13                  => 'mười ba', 
		14                  => 'mười bốn', 
		15                  => 'mười năm', 
		16                  => 'mười sáu', 
		17                  => 'mười bảy', 
		18                  => 'mười tám', 
		19                  => 'mười chín', 
		20                  => 'hai mươi', 
		30                  => 'ba mươi', 
		40                  => 'bốn mươi', 
		50                  => 'năm mươi', 
		60                  => 'sáu mươi', 
		70                  => 'bảy mươi', 
		80                  => 'tám mươi', 
		90                  => 'chín mươi', 
		100                 => 'trăm', 
		1000                => 'ngàn', 
		1000000             => 'triệu', 
		1000000000          => 'tỷ', 
		1000000000000       => 'nghìn tỷ', 
		1000000000000000    => 'ngàn triệu triệu', 
		1000000000000000000 => 'tỷ tỷ' 
		); 
		
		if (!is_numeric($number)) { 
			return false; 
		} 
		if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) { 
		// overflow 
		trigger_error( 
			'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, 
			E_USER_WARNING 
		); 
			return false; 
		} 
		if ($number < 0) { 
			return $negative . $this->convert_number_to_words(abs($number)); 
		} 
		
		$string = $fraction = null; 
		
		if (strpos($number, '.') !== false) { 
			list($number, $fraction) = explode('.', $number); 
		} 
		
		switch (true) { 
			case $number < 21: 
			$string = $dictionary[$number]; 
			break; 
		case $number < 100: 
			$tens   = ((int) ($number / 10)) * 10; 
			$units  = $number % 10; 
			$string = $dictionary[$tens]; 
			if ($units) { 
			$string .= $hyphen . $dictionary[$units]; 
			} 
			break; 
		case $number < 1000: 
			$hundreds  = $number / 100; 
			$remainder = $number % 100; 
			$string = $dictionary[$hundreds] . ' ' . $dictionary[100]; 
			if ($remainder) { 
			$string .= $conjunction . $this->convert_number_to_words($remainder); 
			} 
			break; 
		default: 
			$baseUnit = pow(1000, floor(log($number, 1000))); 
			$numBaseUnits = (int) ($number / $baseUnit); 
			$remainder = $number % $baseUnit; 
			$string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit]; 
			if ($remainder) { 
			$string .= $remainder < 100 ? $conjunction : $separator; 
			$string .= $this->convert_number_to_words($remainder); 
			} 
			break; 
		} 
	
		if (null !== $fraction && is_numeric($fraction)) { 
		$string .= $decimal; 
		$words = array(); 
		foreach (str_split((string) $fraction) as $number) { 
			$words[] = $dictionary[$number]; 
		} 
			$string .= implode(' ', $words); 
		} 
		
		return $string; 
	}
	
	public function calculate_money_elec($e,$e_usage)
	{
		$money = 0;
		foreach ($e as $z)
		{
			if($z['To']!=-1 && $e_usage > $z['To'])
			{
				$money += $z['Price']*($z['To']-$z['From']);
			}
			else
			{
				$money += $z['Price']*($e_usage - $z['From']);
				return $money;
			}
		}
	}
	
	public function calculate_money_water($w,$w_usage, $room_id)
	{
		if($w_usage == 0)
			return 0;
		$total_student = $this->countStudentInRoom($room_id);
		if($total_student == 0) {
			$total_student = 1;
		}

		
		$money = 0;
		$temp = 0;
		foreach ($w as $z)
		{
			$money += $z['Price']*$total_student;
			if($z['To']==-1 || $w_usage < $z['To'])
			{
				$money += $z['Price']*$total_student;
			}
			else
				break;
		}
		return $money;
	}
	
	public function getCustomerGroupDescriptions($customer_group_id) {
		$customer_group_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_group_description cgd LEFT JOIN customer_group ON(cgd.customer_group_id = cg.customer_group_id) WHERE cgd.customer_group_id = '" . (int)$customer_group_id . "'");
				
		foreach ($query->rows as $result) {
			$customer_group_data[$result['language_id']] = array(
				'name'        => $result['name'],
				'description' => $result['description']
			);
		}
		
		return $customer_group_data;
	}
		
	public function getTotalCustomerGroups() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer_group");
		
		return $query->row['total'];
	}
}
?>