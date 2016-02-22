<?php

	include_once ELD_DOMAIN_RESELLER_DIR . 'classes/proxies/class-eld-i-domain-registrator.php';
	include_once ELD_DOMAIN_RESELLER_DIR . 'lib/JsonRPC/Client.php';
	
	use JsonRPC\Client as Json_RPC_Client;

	class Eld_Zone_By_Domain_Registrator implements Eld_I_Domain_Registrator {
		
		const TRANSLIT_TABLE = array(
   
            'а' => 'a',   'б' => 'b',   'в' => 'v',
  
            'г' => 'g',   'д' => 'd',   'е' => 'e',
  
            'ё' => 'yo',   'ж' => 'zh',  'з' => 'z',
  
            'і' => 'i',   'й' => 'j',   'к' => 'k',
  
            'л' => 'l',   'м' => 'm',   'н' => 'n',
  
            'о' => 'o',   'п' => 'p',   'р' => 'r',
  
            'с' => 's',   'т' => 't',   'у' => 'u',
  
            'ф' => 'f',   'х' => 'x',   'ц' => 'c',
  
            'ч' => 'ch',  'ш' => 'sh', 'ў' => 'u',
  
            'ь' => '\'',  'ы' => 'y',   '\'' => '\'\'',
  
            'э' => 'e\'',   'ю' => 'yu',  'я' => 'ya',
  
        );
		
		private $registrator_client;
		private $fictiveCallDone = false;
		
		public function __construct(){
			$this->registrator_client = new Json_RPC_Client(ZONE_BY_REGISTRATOR_API_URL);
			
			$option = get_option('eld_zone_by_registrator_login_option');
			$login = isset($option['eld_zone_by_registrator_login_field']) ? $option['eld_zone_by_registrator_login_field'] : null;
			$option = get_option('eld_zone_by_registrator_password_option');
			$password = isset($option['eld_zone_by_registrator_password_field']) ? $option['eld_zone_by_registrator_password_field'] : null;
			
			if(is_null($password) || is_null($login)){
				throw Exception("Аутентификация на сервере регистратора невозможна: реквизиты не указаны");
			}
			
			$this->registrator_client->authentication($login, $password);
			
			if(ELD_DEBUG){
				$this->registrator_client->debug = true;
				$this->registrator_client->ssl_verify_peer = false;
			}
		}
		
		public function check_domain_name( $name ) {
			if ( ! $fictiveCallDone ){	//	так избавляемся от бага, при котором первая попытка соединения всегда неудачная
				try{
					$this->registrator_client->CheckDomain( ['domain' => self::sanitize_name( $name ) ] );
				} catch ( Exception $e ) {} finally {
					$this->fictiveCallDone = true;
				}
			}
			
			return $this->registrator_client->CheckDomain( ['domain' => self::sanitize_name( $name ) ] );
		}
		
		private static function sanitize_name( $name ) {
			$name = strtolower( $name );
			
			if ( preg_match( '/^[а-ўЎ-ЯёЁіІ0-9]([а-ўЎ-ЯёЁіІ0-9-ʼ]{0,61}[а-ўЎ-ЯёЁіІ0-9])\.[a-zA]+$/' , $name ) ) {
				return strtr( $name, self::TRANSLIT_TABLE );
			} else if ( preg_match( '/^(?!xn--)[a-zA-Z0-9]([a-zA-Z0-9-]{0,61}[a-zA-Z0-9])\.бел$/', $name ) ) {
				return strtr( $name, array_flip( self::TRANSLIT_TABLE ) );
			} else {
				return $name;
			}
				
		}

	}