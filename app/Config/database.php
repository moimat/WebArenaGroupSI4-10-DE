<?php
class DATABASE_CONFIG {

	/* réglage site web
         * public $default = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'root',
		'password' => '',
		'database' => 'webarena',
		'prefix' => '',
		//'encoding' => 'utf8',
	);*/
    public $default = array(
                'datasource' => 'Database/Mysql',
                'persistent' => false,
		'host' => 'localhost',
		'login' => 'root',
		'password' => '',
		'password' => '291293',
		'database' => 'webarena',
		'prefix' => '',
		//'encoding' => 'utf8',
	);

	public $test = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'user',
		'password' => 'password',
		'database' => 'test_database_name',
		'prefix' => '',
		//'encoding' => 'utf8',
	);
}
