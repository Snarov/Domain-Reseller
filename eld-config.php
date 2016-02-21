<?php

define('ELD_DEBUG', 1);

define( 'ELD_DOMAIN_RESELLER_DIR', plugin_dir_path(__FILE__) );
define( 'ELD_DOMAIN_RESELLER_URL', plugin_dir_url(__FILE__) );
define( 'ELD_ADMIN_AJAX_URL', esc_url( admin_url ('admin-ajax.php' ) ) );

define('ZONE_BY_REGISTRATOR_ID', 'zone_by_domain_registrator');
define('ZONE_BY_REGISTRATOR_NAME', 'Domain.by');
define('ZONE_BY_REGISTRATOR_API_URL', 'https://dms1.ok.by/api/v1/json-rpc');
define('ZONE_BY_REGISTRATOR_LOGIN_PATTERN', '^[a-zA-Z0-9._\-]{6,24}');
define('ZONE_BY_REGISTRATOR_PASSWORD_PATTERN', '^[a-zA-Z0-9._\-]{6,50}$');
define('DOMAIN_NAME_PATTERN' , '^((?!xn--)[a-zA-Z0-9]([a-zA-Z0-9-]{0,61}[a-zA-Z0-9]))|([а-ўЎ-ЯёЁіІ0-9]([а-ўЎ-ЯёЁіІ0-9-ʼ]{0,61}[а-ўЎ-ЯёЁіІ0-9]))$');
define('DOMAIN_NAME_MAXLEN', 63);
define('DOMAIN_NAME_MINLEN', 2);
define('DOMAIN_NAME_INCORRECT_MSG', 'Неверный формат доменного имени'); //TODO заполнить шпаргалку для доменного имени


$REGISTRATORS = array(
					  ZONE_BY_REGISTRATOR_ID => array(
													'name' => ZONE_BY_REGISTRATOR_NAME,
													'zones' => array('by', 'бел', 'minsk.by', 'com.by', 'net.by', 'at.by'),
													'main_currency' => "BYR",
													'proxy_class_name' => 'Eld_Zone_By_Domain_Registrator',
													),
					);
