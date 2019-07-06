<?php
/*************************************************************************
 * home-api (MAIN)
 * Home Tools for private. Using IFTTT and Google Home etc
 *
 * PHP 5 or later
 *
 * @category  Home IoT
 * @author    Miki
 * @url       https://www.miki-ie.com/
 * @copyright 2019 (c) MIKI-IE All rights Reserved.
 * @license   https://opensource.org/licenses/mit-license.html MIT License
 * @version   1.0
*************************************************************************/
//コンフィグ読み込み
require_once("home-api-config.php");
//関数読み込み
require_once("home-api-functions.php");

//V1.0 functions
//function checkTime($startTime, $endTime) 
//function pushLINE($value1, $value2)
//function announce($api_url, $text)
//function shutdownPC($target_ip, $target_user, $target_pass)
//function WakeupPC($MAC)
//function logger($text, $level)

logger("Start API KEY=".$_POST['KEY'],"INFO");

if(isset($_POST['KEY']) && strcmp($_POST['APIKEY'], HOME_API_KEY) == 0) {
	if(isset($_POST['TEXT'])){
		$text = $_POST['TEXT'];
	}
	switch ($_POST['KEY']) {
	case 'ExecAnnounce1': //Living
		logger("Start ExecAnnounce1","INFO");
		if(checkTime('6:00','22:00')) {
			announce(GOOGLE_HOME_1, $text);
		}
		break;
	case 'ExecAnnounce2': //Son
		logger("Start ExecAnnounce2","INFO");
		if(checkTime('6:00','22:00')) {
			announce(GOOGLE_HOME_2, $text);
		}
		break;
	case 'ExecAnnounce3': //Doughter
		logger("Start ExecAnnounce3","INFO");
		if(checkTime('6:00','22:00')) {
			announce(GOOGLE_HOME_3, $text);
		}
		break;
	case 'TemperatureWarn':
		logger("Start TemperatureWarn","INFO");
		//Over 30
		pushLine('【リビング室温警告】',$text);
		shutdownPC(WINDOWS_IP, WINDOWS_USER, WINDOWS_PASS);
		break;
	case 'TransportationInfo':
		logger("Start TransportatioknInfo","INFO");
		//Delay warning
		$text = mb_substr($text,0,mb_strpos($text,'#',0,"UTF-8"),"UTF-8");
		pushLine('【公共交通機関情報】',$text);
		if(checkTime('6:00','22:00')) {
			announce(GOOGLE_HOME_1, $text);
		}
		if(checkTime('6:00','8:00')) {
			announce(GOOGLE_HOME_2, $text);
		}
		break;
	case 'Weather':
		logger("Start Weather","INFO");
		//Rain alert
		pushLine('【天気情報】',$text);
		if(checkTime('7:00','19:00')) {
			announce(GOOGLE_HOME_2, $text);
			announce(GOOGLE_HOME_3, $text);
		}
		if(checkTime('6:00','23:00')) {
			announce(GOOGLE_HOME_1, $text);
		}
		break;
	case 'UrgentInfo':
		logger("Start info from tweet","INFO");
		pushLine('【緊急通知】',$text);
		if(checkTime('7:00','19:00')) {
			announce(GOOGLE_HOME_2, $text);
			announce(GOOGLE_HOME_3, $text);
		}
		if(checkTime('6:00','23:00')) {
			announce(GOOGLE_HOME_1, $text);
		}
		break;
	case 'shutdownPC':
		logger("Start shutdownPC","INFO");
		shutdownPC(WINDOWS_IP, WINDOWS_USER, WINDOWS_PASS);
		break;
	case 'WakeupPC':
			logger("Start wakeupPC","INFO");
			WakeupPC(WINDOWS_MAC);
			break;
	default:
		logger("This is private API. (in Default)","ERROR");
	}
}else{
	logger("This is private API. (in else)","ERROR");
}

?>
