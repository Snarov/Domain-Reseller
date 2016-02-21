<?php

include_once ELD_DOMAIN_RESELLER_DIR . 'classes/models/DomainChooseModel.php';
include_once ELD_DOMAIN_RESELLER_DIR . 'classes/views/DomainChooseView.php';

class EldDomainChooseController{
    const CHECKBOX_PREFIX = 'enabled_';

    public static function execute(){
// 		self::register_form_handlers();
		add_action( 'wp_footer', array(__CLASS__, 'loadScripts'));
		add_action('wp_footer', array(__CLASS__, 'loadStyles'));
		
		return EldDomainChooseView::display();
    }

    public static function check_domain_name(){
		
		global $REGISTRATORS;
		
        $zones = array();
        foreach ($REGISTRATORS[ZONE_BY_REGISTRATOR_ID]['zones'] as $zone){
			if( isset( $_POST[ self::CHECKBOX_PREFIX . str_replace('.', '_', $zone) ] ) ) {
                $zones[] = $zone;
            }
		}
		
		$name = ($_POST['name']) ? htmlspecialchars($_POST['name']) : null;
		
        if (!(empty($zones) || empty($name))){
            echo json_encode(EldDomainChooseModel::get_domains_availability($name, $zones));
        }else{
            echo 'err'; //TODO сформировать сообщение об ошибке
			
			if(ELD_DEBUG){
				echo "zones:\n";
				var_dump($zones);
				echo "\nname:\n";
				var_dump($name);
				echo "\n";
			}
        }
    }
    
    public static function loadScripts() {
		wp_enqueue_script('check_domain_name', ELD_DOMAIN_RESELLER_URL . 'js/check-domain-name.js', array('jquery'), false, true);
	}
	
	 public static function loadStyles() {
		wp_enqueue_style( 'eld_result', ELD_DOMAIN_RESELLER_URL . 'css/eld-result.css' );
		wp_enqueue_style('eld_loading_animation', ELD_DOMAIN_RESELLER_URL . 'css/eld-loading-animation.css');
	}
	
	private static function register_form_handlers() {
		echo 'handlers registered';
		add_action( 'wp_ajax_nopriv_check_domain_name', array('EldDomainChooseController', 'check_domain_name' ) );
		add_action( 'wp_ajax_check_domain_name', array('EldDomainChooseController', 'check_domain_name' ) );
	}
	
}