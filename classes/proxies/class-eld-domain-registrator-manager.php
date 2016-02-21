<?php

	class Eld_Domain_Registrator_Manager {
		
		private static $registrators = array();
		
		public static function get_registrator( $registrator_id ) {
			if ( !isset( $registrators[ $registrator_id ] ) ) {
				self::create_proxy_object ( $registrator_id );
			}
			
			return self::$registrators[ $registrator_id ];
		}
		
		private static function create_proxy_object( $registrator_id ) {
			global $REGISTRATORS;
			
			if ( !is_array( $REGISTRATORS[ $registrator_id ] ) ) {
				return;
			}
			
			$registrator_class = $REGISTRATORS[ $registrator_id ]['proxy_class_name'];
			$class_file_name = 'class-' . str_replace('_', '-', strtolower( $registrator_class ) ) . '.php';
			
			include_once ELD_DOMAIN_RESELLER_DIR . "classes/proxies/$class_file_name";
			
			self::$registrators[ $registrator_id ] = new $registrator_class();
		}
}