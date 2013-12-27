<?php

class CalculatorBrain {
	
	private function in_same_province($from,$to){
		
		return false;
	
	}

	/* ZONES
	 *
	 *	1 = Within same province
	 *  2 = Within same community
	 *  3 = Mainland
	 *  4 = Mainland to Balears
	 *  5 = Mainland to Balears minor islands 
	 *  6 = Balears to Balears
	 *  7 = Mainland to Canaries
	 *  8 = Mainland to Canaries minor islands
	 *  8 = Canarias to Canaries
	 *  9 = Spain to Andorra
	 * 10 = Ceuta and Melilla
	 */
	
	private function get_zone($destination){
	
		$from = $destination[0];
		$to   = $destination[1];
		
		/* 1: Is it the same province? */
		if($from == $to) return 1;
		
		
		
		return $zone;
	
	}

	public function get_fare($service,$destination,$weight,$dimentions){
		
		$zone = $this->get_zone($destination);
		
		
		
		return true;
	}

}