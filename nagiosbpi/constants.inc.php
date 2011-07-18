<?php //constants.inc.php  file for nagios bpi addon 

//grab config info for server and directory from globals.conf file, see read_conf.php for function details

define('DIRBASE', dirname(__FILE__)); //assigns current directory as root 

define('VERSION','1.3'); 

$globals = fetch_globals();

//get server web address 
$SERVER_BASE = isset($_SERVER['SERVER_NAME']) ? 
                      $_SERVER['SERVER_NAME'] : $_SERVER['SERVER_ADDR'];
 
$PROTO = isset($_SERVER['HTTPS']) ? 'https' : 'http';
$base = $PROTO.'://'.$SERVER_BASE;
define('SERVERBASE', $base);


//assign constants if they've been set correctly 
if(isset( 	$globals['STATUSFILE'], $globals['OBJECTSFILE'], 
			$globals['CONFIGFILE'], $globals['CONFIGBACKUP']
			))
{
	define('CONFIGBACKUP', $globals['CONFIGBACKUP']);
	define('CONFIGFILE', $globals['CONFIGFILE']);
	

	//data files for building main arrays 
	define("STATUSFILE", $globals['STATUSFILE']); //status.dat file generated by nagios 
	define("OBJECTSFILE", $globals['OBJECTSFILE']); //main object configuration file generated by nagios

}
else
{
	print "<p class='error'>Missing global configuration(s), check 'constants.conf' file.</p>";
	die();
}

if(isset($globals['XMLOUTPUT']))
{
	define('XMLOUTPUT', trim($globals['XMLOUTPUT']));
}




if($globals['XI']==1 || file_exists(dirname(__FILE__).'/../componenthelper.inc.php')) //if installation is Nagios XI 
{
	//nagiosxi 
	//print "version is XI<br />";
	define('NAGIOSURL', SERVERBASE.'/nagiosxi/');
	define('HOSTDETAIL', NAGIOSURL.'/includes/components/xicore/status.php?show=hostdetail&host=');
	define('SERVICEDETAIL', NAGIOSURL.'/includes/components/xicore/status.php?show=servicedetail&host=');
	//if(!defined('NAGV')) 
	@define('NAGV', 'XI'); 
}
else
{
	//print "version is core<br />";
	define('NAGIOSURL', SERVERBASE.'/nagios/');
	define('NAGV', 'CORE');
	define('HOSTDETAIL', NAGIOSURL.'/cgi-bin/extinfo.cgi?type=1&host=');
	define('SERVICEDETAIL', NAGIOSURL.'/cgi-bin/extinfo.cgi?type=2&host=');
}








?>