<?php
/*************************************************************************
 * home-api (function)
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

function checkTime($startTime, $endTime) {
	$currentTime = date('H:i');
	if(strtotime($startTime) <= strtotime($currentTime) and strtotime($currentTime) <= strtotime($endTime)) {
		return true;
	}else{
		return false;
	}
}

function pushLINE($value1, $value2) {
	logger("Start pushLINE value1={$value1},value2={$value2}","INFO");
	$url = IFTTT_POST_API_BASE.IFTTT_LINE_KEY.IFTTT_POST_API_KEY;
	$data = array(
		'value1' => $value1,
		'value2' => $value2
	);
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_POST, TRUE);
	curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data)); // jsonデータを送信
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($curl);
	$result = json_decode($response, true);
	curl_close($curl);
	return $result;
}

function announce($api_url, $text) {
	logger("Start announce target={$api_url},text={$text}","INFO");
	$message = 'text='.$text;
	$data = array(
		'text' => "$text"
	);
	$path = '/google-home-notifier';
	$url = $api_url.$path;
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_POST, TRUE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 証明書の検証を行わない
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // curl_execの結果を文字列で返す
	curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data)); // jsonデータを送信
	$response = curl_exec($curl);
	$result = json_decode($response, true);
	curl_close($curl);
	return $result;
}

function shutdownPC($target_ip, $target_user, $target_pass) {
	logger("Start shutdown target_ip:".$target_ip." target_user:".$target_user,"INFO");
	$shutdown_time = 60;
	$comment = "シャットダウン開始します。キャンセル「－ａ」";
	$cmd = 'shutdown /s /f /t '.$shutdown_time.' /c '.$comment;
	$connection = ssh2_connect($target_ip);
	ssh2_auth_password($connection, $target_user, $target_pass);
    $stream = ssh2_exec($connection, $cmd);
    $errorstream = ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);
    stream_set_blocking($stream, true);
    stream_set_blocking($errorstream, true);
    $ok =  stream_get_contents($stream);
   $ng =  stream_get_contents($errorstream); //エラーがあれば表示
   echo $ok;
   echo $ng;
}

function WakeupPC($MAC) {
	logger("Start powerOn","INFO");
	$cmd = 'sudo /usr/sbin/etherwake '.$MAC;
	$output =  shell_exec($cmd);
}

function logger($text, $level) {
	$datetime = date('Y-m-d H:i:s');
	$date = date('Ym');
	$file_name = __DIR__ . "/log/log-home-{$date}.log";
	$text = "{$datetime} [{$level}] {$text}" . PHP_EOL;
	echo $text;
	if(!(file_exists($file_name))){
		touch($file_name);
		chmod($file_name, 0777);
	}
	return error_log(print_r($text, TRUE), 3, $file_name);
}
