<?php

class EldDomainChooseModel{

    public static function getEnabledRegistrators(){
        $enabledRegistrators = array();

        $option = get_option('eld_zone_by_registrator_enabled_option');
        $zoneByEnabled = isset($option['eld_zone_by_registrator_enabled_checkbox']);
        if($zoneByEnabled){
            $enabledRegistrators[] = ZONE_BY_REGISTRATOR_NAME;
        }

        return $enabledRegistrators;
    }

    public static function checkDomain($name, array $zones){
    }

}