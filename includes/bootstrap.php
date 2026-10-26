<?php
if(session_status()!==PHP_SESSION_ACTIVE)session_start();
require_once __DIR__.'/../config/config.php';
function db():PDO{static $p=null;if($p instanceof PDO)return $p;$p=new PDO('mysql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME.';charset=utf8mb4',DB_USER,DB_PASS,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES=>false]);return $p;}
function e($v):string{return htmlspecialchars((string)$v,ENT_QUOTES,'UTF-8');}
function go($p):never{header('Location: '.$p);exit;}
function csrf():string{if(empty($_SESSION['csrf']))$_SESSION['csrf']=bin2hex(random_bytes(32));return $_SESSION['csrf'];}
function check_csrf():void{if(!hash_equals(csrf(),(string)($_POST['csrf']??''))){http_response_code(419);exit('Invalid form token. Go back and try again.');}}
function me():?array{return $_SESSION['user']??null;}
function need_login():void{if(!me())go('login.php');}
function need_admin():void{if(!me())go('../login.php');if((me()['role']??'')!=='admin'){http_response_code(403);exit('Admin only');}}
function flash($m,$type='success'):void{$_SESSION['flash']=['m'=>$m,'t'=>$type];}
