<?php

include_once ELD_DOMAIN_RESELLER_DIR . '/classes/models/DomainChooseModel.php';
include_once ELD_DOMAIN_RESELLER_DIR . '/classes/views/DomainChooseView.php';

class EldDomainChooseController{
    const CHECKBOX_PREFIX = 'enabled_';

    public static function execute(){
		return EldDomainChooseView::display();
    }

    public static function getAvailableDomains(){

        $zones = array();
        foreach ($ZONES[ZONE_BY_REGISTRATOR_NAME] as $zone){
            if(isset($_POST[CHECKBOX_PREFIX . $zone])){
                $zones[] = $zone;
            }
		}

        $name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : null;

        if (!(empty($zones) || empty($name))){
            echo json_encode(DomainChooseModel::getAvailableDomains($name, $zones));
        }else{
            echo 'err'; //TODO сформировать сообщение об ошибке
        }
    }
}