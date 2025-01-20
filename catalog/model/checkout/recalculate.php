<?php 
class ModelCheckoutRecalculate extends Model {
	public function getDopShipping($methods = array(), $address) {
		if (file_exists(DIR_SYSTEM . 'library/simple/filterit.php')) {
			if (!$this->filterit && (method_exists($this->load, 'library') || get_class($this->load) == 'agooLoader')) {
				$this->load->library('simple/filterit');
			}
			if (!$this->filterit) {
				$this->filterit = new Simple\Filterit($this->registry);
			}
			$methods = $this->filterit->filterShipping($methods, $address);
		}
		
		return $methods;
	}
	
	public function getDopPayment($methods = array(), $address) {
		if (file_exists(DIR_SYSTEM . 'library/simple/filterit.php')) {
			if (!$this->filterit && (method_exists($this->load, 'library') || get_class($this->load) == 'agooLoader')) {
				$this->load->library('simple/filterit');
			}
			if (!$this->filterit) {
				$this->filterit = new Simple\Filterit($this->registry);
			}
			$methods = $this->filterit->filterPayment($methods, $address);
		}
		
		return $methods;
	}
	
	
	
	
	
	
	
	
	
	
}