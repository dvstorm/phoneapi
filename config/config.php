<?php

Config::set('DB_NAME', 'clients');
Config::set('DB_USER', 'korky');
Config::set('DB_PASS', '');

// Config::set('NO_SAVE_PERIOD', 24*60*60);
Config::set('NO_SAVE_PERIOD', 0);

Config::set('MAX_NAME_SIZE', 50);
Config::set('MAX_EMAIL_SIZE', 50);

Config::set('default_controller', 'page404controller');
Config::set('default_action', 'index');
Config::set('default_params', 'Default params');

