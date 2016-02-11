<?php

    include ELD_DOMAIN_RESELLER_DIR . '/eld-config.php';

    function eld_domain_reseller_admin_menu_setup() {
        add_submenu_page(
            'options-general.php',
            'Настройки Domain Reseller',
            'Domain Reseller',
            'manage_options',
            'eld_domain_resseler_menu',
            'eld_domain_reseller_display_menu'
        );
    }

    function eld_domain_reseller_display_menu() {
        global $submenu;

        $page_data = array();

        foreach ($submenu['options-general.php'] as $i => $menu_item) {
            if ($submenu['options-general.php'][$i][2] == 'eld_domain_resseler_menu') {
                $page_data = $submenu['options-general.php'][$i];
            }
        }
    ?>
        <div class="wrap">
            <?php screen_icon(); ?>
            <h2><?php echo $page_data[3]; ?></h2>
            <form id="eld_domain_reseller_options" action="options.php" method="post">
                <?php
                settings_fields('eld_domain_reseller_options');
                do_settings_sections('eld_domain_resseler_menu');
                submit_button('Сохранить', 'primary', 'eld_domain_reseller_submit');
                ?>
            </form>
        </div>
        <?php
    }

    function eld_domain_reseller_add_settings_link($links) {

        echo "HUJ";

        $mylinks = array(
            '<a href="' . admin_url( 'options-general.php?page=eld_domain_resseler_menu' ) . '">Настройки</a>',
        );

        return array_unshift( $links, $mylinks );
    }


    function eld_domain_reseller_admin_init() {
        register_setting(
            'eld_domain_reseller_options',
            'eld_zone_by_registrator_enabled_option'
        );

        register_setting(
            'eld_domain_reseller_options',
            'eld_zone_by_registrator_login_option',
            'eld_zone_by_registrator_login_field_sanitize'
        );
        register_setting(
            'eld_domain_reseller_options',
            'eld_zone_by_registrator_password_option',
            'eld_zone_by_registrator_password_field_sanitize'
        );

        add_settings_section(
            'eld_zone_by_registrator_settings_section',
            "Белорусские домены",
            'eld_zone_by_registrator_section_filler',
            'eld_domain_resseler_menu'
        );

        add_settings_field(
            'eld_zone_by_registrator_enabled_checkbox',
            'Регистрация включена:',
            'eld_zone_by_registrator_enabled_checkbox_filler',
            'eld_domain_resseler_menu',
            'eld_zone_by_registrator_settings_section'
        );

        add_settings_field(
            'eld_zone_by_registrator_login_field',
            'Логин:',
            'eld_zone_by_registrator_login_field_filler',
            'eld_domain_resseler_menu',
            'eld_zone_by_registrator_settings_section'
        );

        add_settings_field(
            'eld_zone_by_registrator_password_field',
            'Пароль:',
            'eld_zone_by_registrator_password_field_filler',
            'eld_domain_resseler_menu',
            'eld_zone_by_registrator_settings_section'
        );

    }

    function eld_zone_by_registrator_section_filler(){
        echo "<p>Настройки регистратора белорусских доменов " . ZONE_BY_REGISTRATOR_NAME . "</p>";
    }

    function eld_zone_by_registrator_enabled_checkbox_filler(){
        $options = get_option('eld_zone_by_registrator_enabled_option');
        $enabled = isset($options['eld_zone_by_registrator_enabled_checkbox']) ? $options['eld_zone_by_registrator_enabled_checkbox'] : '0';

        ?>
        <input id="eld_zone_by_registrator_enabled_checkbox" type="checkbox" name="eld_zone_by_registrator_enabled_option[eld_zone_by_registrator_enabled_checkbox]" value="1" <?php checked( $enabled, 1 ); ?> />
        <?php

    }

    function eld_zone_by_registrator_login_field_filler(){
        $options = get_option('eld_zone_by_registrator_login_option');
        $value = isset($options['eld_zone_by_registrator_login_field']) ? $options['eld_zone_by_registrator_login_field'] : '';

        ?>
        <input id="eld_zone_by_registrator_login_field" type="text" name="eld_zone_by_registrator_login_option[eld_zone_by_registrator_login_field]" maxlenght="24" required pattern="<?php echo ZONE_BY_REGISTRATOR_LOGIN_PATTERN; ?>" value="<?php echo $value;?>" />
        <?php
    }

     function eld_zone_by_registrator_password_field_filler(){
        $options = get_option('eld_zone_by_registrator_password_option');
        $value = isset($options['eld_zone_by_registrator_password_field']) ? $options['eld_zone_by_registrator_password_field'] : '';

        ?>
        <input id="eld_zone_by_registrator_password_field" type="password" name="eld_zone_by_registrator_password_option[eld_zone_by_registrator_password_field]" maxlenght="50" required pattern="<?php echo ZONE_BY_REGISTRATOR_PASSWORD_PATTERN; ?>" value="<?php echo $value;?>" />
        <?php
    }

    function eld_zone_by_registrator_login_field_sanitize($input){
        if(isset($input['eld_zone_by_registrator_login_field'])){
            $input['eld_zone_by_registrator_login_field'] = sanitize_user($input['eld_zone_by_registrator_login_field'], true);
        }

        return $input;
    }

    function eld_zone_by_registrator_password_field_sanitize($input){
        if(isset($input['eld_zone_by_registrator_password_field'])){
            $input['eld_zone_by_registrator_password_field'] = sanitize_user($input['eld_zone_by_registrator_password_field'], true);
        }

        return $input;
    }

    function eld_options_preset(){
        if(!get_option('eld_zone_by_registrator_enabled_option')){
            add_option('eld_zone_by_registrator_enabled_option', array('eld_zone_by_registrator_enabled_checkbox' => '1'));
        }
    }

    add_action('admin_menu', 'eld_domain_reseller_admin_menu_setup');
    add_action('admin_init', 'eld_domain_reseller_admin_init');
    add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'eld_domain_reseller_add_settings_link' );
