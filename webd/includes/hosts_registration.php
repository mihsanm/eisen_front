<?php
/**
 * Created by PhpStorm.
 * User: IT College
 * Date: 2015/11/18
 * Time: 23:03
 */
require_once __DIR__ . '/DbAction.php';
require_once __DIR__."/session.php";
require_once __DIR__."/restclient.php";

if(isset($_POST['submit'])){
    $host = htmlspecialchars($_POST["host"]);
    $groups = htmlspecialchars($_POST["groups"]);
}

$me = new Session();
$me->start_session();
$me->is_session_started();

$dba = new DbAction();
$dbh = $dba->Connect();
$user_id = $me->get_user_id();

$machine = $dba->MachineList($user_id,$dbh);
$module=$machine[0];
$ipaddress=$machine[1];
$port=$machine[2];
$username=$machine[3];
$password=$machine[4];

$rest = new restclient();
# TODO need to be fixed on the python side because the host
# is actually not registered yet
$hosts=$rest->host_register($ipaddress,$port,$username,$password,$host,$groups);
# debugging
var_dump($ipaddress,$port,$username,$password,$host,$groups);