<?php
define('BASE_PATH', realpath(__DIR__));
define('UTILS_PATH', BASE_PATH . '/utils');
define('HANDLERS_PATH', BASE_PATH . '/handlers');
define('DATABASE_PATH', realpath(BASE_PATH . "/database"));
define('DUMMIES_PATH', realpath(BASE_PATH . "/staticDatas/dummies"));
define('TEMPLATES_PATH', realpath(BASE_PATH . '/components/templates'));
define('STATICDATAS_PATH', realpath(BASE_PATH . '/staticDatas'));
define('LAYOUTS_PATH', realpath(BASE_PATH . '/layouts'));
define('ERRORS_PATH', realpath(BASE_PATH . '/errors'));
define('PAGES_PATH', realpath(BASE_PATH . '/pages'));
chdir(BASE_PATH);
