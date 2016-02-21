<?php

include_once ELD_DOMAIN_RESELLER_DIR . '/eld-config.php';
include_once ELD_DOMAIN_RESELLER_DIR . '/classes/controllers/DomainChooseController.php';
include_once ELD_DOMAIN_RESELLER_DIR . '/classes/models/DomainChooseModel.php';

class EldDomainChooseView{
	
	const CHECKBOX_IN_COLUMN_COUNT = 3;

    public static function display() { 
	
		global $REGISTRATORS;
		
		$enabledRegistrators = EldDomainChooseModel::getEnabledRegistrators();
            
		if(!empty($enabledRegistrators)){

			$zonesForChoiceCount = 1;
			$checkboxGroupHTML = '<ul style="display: inline-block; list-style: none;">';
			foreach($enabledRegistrators as $enabledRegistrator){
				foreach($REGISTRATORS[$enabledRegistrator]['zones'] as $zone){
					
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

		$consts = get_defined_constants();
		$form = <<<FORM
		<form id="check_domain_name_form" name="check_domain_name_form" method="post" action="{$consts['ELD_ADMIN_AJAX_URL']}">
		 <input type="hidden" name="action" value="check_domain_name"/>
        <input class="input-side animate-on-scroll scroll-animation-init fadeInLeft" name="name" type="text" placeholder="имя домена" pattern="{$consts['DOMAIN_NAME_PATTERN']}" minlength="{$consts['DOMAIN_NAME_MINLEN']}" maxlength="{$consts['DOMAIN_NAME_MAXLEN']}" title="{$consts['DOMAIN_NAME_INCORRECT_MSG']}" required data-scrollanimation="fadeInLeft"><br>
		$checkboxGroupHTML
		<input id="eld_check_domain_submit_button" class="btn-side animate-on-scroll scroll-animation-init fadeInRight" style="width: 170px; margin-bottom: 40px;" type="submit" value="Проверить" data-scrollanimation="fadeInRight">
		<div id='eld_spinner' class="spinner">
			<div class="rect1"></div>
			<div class="rect2"></div>
			<div class="rect3"></div>
			<div class="rect4"></div>
			<div class="rect5"></div>
		</div>

		</form>
		
		<div id="eld_result_holder" style="display:none">
			   <form id="choose_domain_name_form" name="choose_domain_name_form" method="post">
				<div class="eld_duration_currency_block">
						<div id="eld_currency_block" class="eld_currency_right">
							<span>Валюта:</span>
								<select name="eld_currency_list" id="eld_currency_list" class="eld_currency_list">
									<option selected="selected" value="1">Белорусский рубль</option>
								</select>

						</div>
						<div class="eld_duration_block">
							Период: 
							<select id="eld_period_select" name="eld_duration_list" onchange="onPeriodChanged(this)">
								<option value="1">1 год</option>
								<option value="2">2 года</option>

							</select>
						</div>
					</div>
					<div class="eld_domains_block">
						<table id="eld_domains_table">
						</table>
					</div>
					<div class="eld_action_buttons">
						<input class="btn-side animate-on-scroll scroll-animation-init fadeInRight" style="width: 180px; margin-bottom: 30px; margin-top: 40px" type="submit" value="Продолжить" data-scrollanimation="fadeInRight">
					</div>
				</form>
		</div>
FORM;

	
		return $form;
		
    }
    
}