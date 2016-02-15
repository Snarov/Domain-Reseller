<?php

define('ZONE_BY_REGISTRATOR_NAME', 'Domain.by');
define('ZONE_BY_REGISTRATOR_LOGIN_PATTERN', '^[a-zA-Z0-9._\-]{6,24}');
define('ZONE_BY_REGISTRATOR_PASSWORD_PATTERN', '^[a-zA-Z0-9._\-]{6,50}$');

$ZONES = array(ZONE_BY_REGISTRATOR_NAME => array('by', 'bel', 'minsk.by', 'com.by', 'net.by', 'at.by'));
