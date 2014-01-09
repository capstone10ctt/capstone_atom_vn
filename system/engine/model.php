<?php
/**
 * Controller
 *
 * Controller for module GermanLocalisation
 *
 * PHP VERSION 5.3
 *
 * @category File
 * @package  default
 * @author   Andreas Tangemann <a.tangemann@web.de>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://www.opencart.com/index.php?route=extension/extension/info&extension_id=4183
 */
/**
 * ModelTotalHandlingGerman
 *
 * Controller for module GermanLocalisation
 *
 * @category Model
 * @package  default
 * @author   Andreas Tangemann <a.tangemann@web.de>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://www.opencart.com/index.php?route=extension/extension/info&extension_id=4183
 */
abstract class Model {
	protected $registry;
	
	public function __construct($registry) {
		$this->registry = $registry;
	}
	
	public function __get($key) {
		return $this->registry->get($key);
	}
	
	public function __set($key, $value) {
		$this->registry->set($key, $value);
	}
}
?>