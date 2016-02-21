<?php

include ELD_DOMAIN_RESELLER_DIR . 'classes/proxies/class-eld-domain-registrator-manager.php';

class EldDomainChooseModel{
	
	public static function getEnabledRegistrators(){
        $enabledRegistrators = array();

        $option = get_option('eld_zone_by_registrator_enabled_option');
        $zoneByEnabled = isset($option['eld_zone_by_registrator_enabled_checkbox']);
        if($zoneByEnabled){
            $enabledRegistrators[] = ZONE_BY_REGISTRATOR_ID;
        }

        return $enabledRegistrators;
    }

    public static function get_domains_availability($name, array $zones){
		global $REGISTRATORS;
				
		$domains_set = array();
		foreach ( $zones as $zone ){
			
			try {
				$registrator_id = self::get_registrator_id_by_zone( $zone );
				
				if( $registrator_id ){
					$registrator = Eld_Domain_Registrator_Manager::get_registrator( $registrator_id );
					
					if ( $registrator ){
						$full_domain_name = $name . '.' . $zone;
						
						$another_domain = $registrator->check_domain_name( $full_domain_name );
						$another_domain['price'] = self::get_zone_price( $zone );
						$another_domain['currency'] = $REGISTRATORS[ ZONE_BY_REGISTRATOR_ID ]['main_currency'];
						$domains_set[] = $another_domain;
						
					}
				}
			} catch ( Exception $e ) {
				//TODO обработать 
			}
		}
		
		return $domains_set;
		
		//TODO обработать ошибки
		
    }
    
    private static function get_registrator_id_by_zone($zone){
		global $REGISTRATORS;
		
		foreach ( $REGISTRATORS as $registrator_id => $registrator_data ) {
			if ( array_search( $zone, $registrator_data['zones']) !== false ) {
				return $registrator_id;
			}
		}
		
		return false;
	}
	
	private static function get_zone_price( $zone ) {
		$zone_id = str_replace('.' , '_', $zone);
		$option_name = "eld_zone_by_registrator_{$zone_id}_zone_price_option";
		$field_name = "eld_zone_by_registrator_{$zone_id}_zone_price_field";
		
		$option = get_option( $option_name );
		return isset( $option[ $field_name ] ) ? $option[ $field_name ] : null;
	}

}