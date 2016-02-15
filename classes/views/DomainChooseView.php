<?php

include_once ELD_DOMAIN_RESELLER_DIR . '/eld-config.php';
include_once ELD_DOMAIN_RESELLER_DIR . '/classes/controllers/DomainChooseController.php';
include_once ELD_DOMAIN_RESELLER_DIR . '/classes/models/DomainChooseModel.php';

class EldDomainChooseView{
	
	const CHECKBOX_IN_COLUMN_COUNT = 3;

    public static function display(){ 
	
		global $ZONES;
		
		$enabledRegistrators = EldDomainChooseModel::getEnabledRegistrators();
            
		if(!empty($enabledRegistrators)){

			$zonesForChoiceCount = 1;
			$checkboxGroupHTML = '<ul style="display: inline-block; list-style: none;">';
			foreach($enabledRegistrators as $enabledRegistrator){
				foreach($ZONES[$enabledRegistrator] as $zone){
					
					$checkboxGroupHTML .= '<li style="padding-right:5px"><input name="' . EldDomainChooseController::CHECKBOX_PREFIX . $zone . '" type="checkbox" value="1" checked="checked">' . $zone . '</li>';
					
					if(0 == $zonesForChoiceCount++ % self::CHECKBOX_IN_COLUMN_COUNT){
						$checkboxGroupHTML .= '</ul><ul style="display: inline-block; list-style: none;">';
					}
				}
			}
			
			$checkboxGroupHTML .= '</ul><br>';
		}else{
			//TODO вывести уведомление о том, что регистрация отключена.
		}

		$form = <<<FORM
		<form method="post">

        <input class="input-side animate-on-scroll scroll-animation-init fadeInLeft" name="name" type="text" placeholder="имя домена" data-scrollanimation="fadeInLeft"><br>
		$checkboxGroupHTML
		<input class="btn-side animate-on-scroll scroll-animation-init fadeInRight" style="width: 170px; margin-bottom: 30px;" type="submit" value="Проверить" data-scrollanimation="fadeInRight">

		</form>
FORM;

	
		return $form;
		
    }
    
//     private static function loadStyles(){
// 		
// 		function eld_load_styles() {
// 			$myStyleUrl = ELD_DOMAIN_RESELLER_DIR . '/myPlugin/style.css';
// 			$myStyleFile = WP_PLUGIN_DIR . '/myPlugin/style.css';
// 			if ( file_exists($myStyleFile) ) {
// 				wp_register_style('myStyleSheets', $myStyleUrl);
// 				wp_enqueue_style( 'myStyleSheets');
// 			}
// 		}
// 		
// 		add_action('wp_print_styles', 'eld_load_styles');
//     
// 	}

}