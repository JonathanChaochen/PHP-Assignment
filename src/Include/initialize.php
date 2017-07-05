<?php
// Define the core paths
// Define them as absolute paths to make sure that require_once works as expected

// DIRECTORY_SEPARATOR is a PHP pre-defined constant
// (\ for Windows, / for Unix)
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

defined('SITE_ROOT') ? null :
define('SITE_ROOT', DS.'Users'.DS.'chenchao'.DS.'Sites'.DS.'BCPR294_assign');

defined('Database_PATH') ? null : define('Database_PATH', SITE_ROOT.DS.'src'.DS.'Database');
defined('Class_PATH') ? null : define('Class_PATH', SITE_ROOT.DS.'src'.DS.'Entity Class');
defined('Function_PATH') ? null : define('Function_PATH', SITE_ROOT.DS.'src');



//load database
// require_once(Database_PATH . DS . 'MySQLDB.php');
require_once(Database_PATH . DS .'db.php');

//load basic function
require_once  (Function_PATH . DS . 'myFunctions.php');

//load interface
require_once  (Function_PATH . DS . 'Interfaces' .DS. 'interfaces.php');

//load language parser
require_once  (Function_PATH . DS . 'Language' .DS. 'LanguageParser.php');
// require_once  (Function_PATH . DS . 'Layout' .DS. 'LangSetting.php');

//load classes
require_once(Class_PATH . DS . 'session.php');
require_once(Class_PATH . DS . 'database_object.php');


