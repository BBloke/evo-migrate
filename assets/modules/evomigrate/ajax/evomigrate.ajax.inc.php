<?php
// Created: 7/12/22
// Update: 7/12/22
// Rev: 1

// Can we check the string and get everything before assets?
$strpos = strpos($_SERVER['PHP_SELF'], 'manager');
$baseurl = substr($_SERVER['PHP_SELF'], 0, strpos($_SERVER['PHP_SELF'], 'assets'));

define('MODX_API_MODE', true);
include_once($_SERVER["DOCUMENT_ROOT"] . $baseurl . 'index.php');

$modx->db->connect();
if (empty ($modx->config)) {
    $modx->getSettings();
}

if ( substr($modx->config['settings_version'],0,1) < 2 ) {
	include_once($_SERVER["DOCUMENT_ROOT"] . $baseurl . 'assets/cache/siteManager.php');
	require_once($_SERVER["DOCUMENT_ROOT"] . $baseurl . 'manager/includes/protect.inc.php');
}

// Crude way of restricting access.  This is not using the web groups permission but should
// Die if we are not logged in.  
// Prevents spamming to get email addresses or errors!
// if( ! defined('IN_MANAGER_MODE') || IN_MANAGER_MODE !== true ) { die("not allowed!"); }

$modx->invokeEvent("OnWebPageInit");

if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')){
        $modx->sendErrorPage();
}


include_once $modx->getConfig('base_path') . 'assets/modules/evomigrate/evomigrate.class.inc.php';

//$config = array();
//$evoMigrate = new evoMigrate( $config );

if ( $_REQUEST['action'] == "deactivatePlugins" ) echo evoMigrate::deactivatePlugins();
if ( $_REQUEST['action'] == "activatePlugins" ) echo evoMigrate::activatePlugins();
if ( $_REQUEST['action'] == "checkUsers" ) echo evoMigrate::checkUsers();
if ( $_REQUEST['action'] == 'installTables' ) echo evoMigrate::installTables();
if ( $_REQUEST['action'] == 'systemEvents' ) echo evoMigrate::systemEvents();
if ( $_REQUEST['action'] == 'migrateUsers' ) echo evoMigrate::migrateUsers();
if ( $_REQUEST['action'] == 'installv3' ) echo evoMigrate::installv3();
