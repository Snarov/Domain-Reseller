<?php
    /*
    Plugin Name: Domain Reseller
    Description: Предоставляет совокупность форм для организации посреднической деятельности при регистрации доменных имен.
    Version: 1.0
    Author: Ваня Кискин
    */

    /*
    Copyright 2016  Ваня Кискин  (email: snarovivan@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define('ELD_DOMAIN_RESELLER_DIR', plugin_dir_path(__FILE__));
define('ELD_DOMAIN_RESELLER_URL', plugin_dir_url(__FILE__));

include(ELD_DOMAIN_RESELLER_DIR . '/eld-admin.php');
include_once(ELD_DOMAIN_RESELLER_DIR . '/classes/controllers/DomainChooseController.php');

function eld_domain_reseller_activation(){
    eld_options_preset();
}

function eld_init(){
	add_shortcode( 'domain_choose', array('EldDomainChooseController', 'execute') );
 }

register_activation_hook(__FILE__, 'eld_domain_reseller_activation');
add_action( 'init', 'eld_init');

