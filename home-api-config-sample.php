<?php
/*************************************************************************
 * home-api (config)
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
//サンプルファイル名を変更して利用下さい。 home-api-config.php　に変更。
//@HOME_API_LOG_NAME@　ログファイル名、書き込み権限が必要です
//@HOME_API_KEY@　POST受信時の簡易的なAPI-KEYのトークン確認を行います
//@IFTTT_POST_API_KEY@　IFTTTのWebhooks用API-KEY
//@GOOGLE_HOME_1@ http://192.168.0.200:9081 などgoogle home notifier向けのURL
//@GOOGLE_HOME_2@ google home notifier向けのURL
//@GOOGLE_HOME_3@ google home notifier向けのURL
//@WINDOWS_IP@ WindowsのIPアドレス
//@WINDOWS_USER@ Windowsのユーザー名
//@WINDOWS_PASS@ Windowsのパスワード
//@WINDOWS_MAC@　WindowsのMACアドレス

//各種設定
//ログのファイル名
define("HOME_API_LOG_NAME","@HOME_API_LOG_NAME@");
//home-api-key
define("HOME_API_KEY","@HOME_API_KEY@");
//IFTTT用webhookパラメータ
define("IFTTT_POST_API_KEY","/with/key/@IFTTT_POST_API_KEY@");
define("IFTTT_POST_API_BASE","https://maker.ifttt.com/trigger/");
//IFTTT用puchLINE
define("IFTTT_LINE_KEY","pushLINE");

//google-home-notifier
define("GOOGLE_HOME_1",'@GOOGLE_HOME_1@');
define("GOOGLE_HOME_2",'@GOOGLE_HOME_2@');
define("GOOGLE_HOME_3",'@GOOGLE_HOME_3@');

//Windows PC
define("WINDOWS_IP","@WINDOWS_IP@");
define("WINDOWS_USER","@WINDOWS_USER@");
define("WINDOWS_PASS","@WINDOWS_PASS@");
define("WINDOWS_MAC","@WINDOWS_MAC@");

?>
