﻿<!DOCTYPE html>
<?php $version = "1.4.0";
$ic_required ='6.1.0';

if ( isset($_GET['phpinfo']) ) {
	phpinfo();
	exit ;
}
?>
<html lang="ru">
<head>
<meta charset="UTF-8" />
<title>Скрипт для проверки системы v<?php echo $version; ?></title>
<style>
	body, div, td {
		font-size: 13px;
		font-family: verdana, helvetica, arial;
		color: #555555;
	}
	#container {
		width: 100%;
	}
	#content {
		width: 800px;
		margin: 20px auto;
		left: 50%;
		right: 50%;
		background: #FFFFFF;
		border: 1px solid #ccc;
		-moz-border-radius: 5px;
		-webkit-border-radius: 5px;
		border-radius: 5px;
		-moz-box-shadow: 0px 0px 4px #ccc;
		-webkit-box-shadow: 0px 0px 4px #ccc;
		box-shadow: 0px 0px 4px #ccc;
		min-height: 450px;
		padding: 20px;
	}
	#content table {
		border-collapse: collapse;
		margin: 0px;
		text-align: left;
		width: 100%;
	}
	#content table thead th {
		background-color: #F6F6F6;
		padding: 8px;
		border: 1px solid #CCCCCC;
		font-size: 11px;
		font-weight: 700;
	}
	#content table td {
		background-color: #fff;
		border: 1px solid #CCCCCC;
		padding: 8px;
	}
	#content table td.center {
		text-align: center;
	}
</style>
</head>
<body>
<?php
if ( (PHP_VERSION_ID >= 50310) && (PHP_VERSION_ID < 50700) ) {
	$phpversion_str = '<font color="green">' . phpversion() . '</font>';
	$status_phpversion_str = '<b><font color="green">OK</font></b>';
} elseif ( (PHP_VERSION_ID >= 70000) && (PHP_VERSION_ID < 72000) ) {
	$phpversion_str = '<font color="green">' . phpversion() . '</font>';
	$status_phpversion_str = '<b><font color="green">OK</font></b>';
}else {
	$phpversion_str = '<font color="red">' . phpversion() . '</font>';
	$status_phpversion_str = '<b><font color="red">Off</font></b>';
}

if(!extension_loaded('openssl') || !function_exists('openssl_decrypt')) {
	$openssl = 0;
	$openssl_status = '<b><font color="red">OFF</font></b>';
	$openssl_installed = '<font color="red">disabled</font>';
} else {
	$openssl = 1;
	$openssl_status = '<b><font color="green">OK</font></b>';
	$openssl_installed = '<font color="green">enabled</font>';
}

$ioncube_loader_version = ioncube_loader_version_array();//print_r($ioncube_loader_version);
if ( $ioncube_loader_version ) {
	$ic_php = $ioncube_loader_version['version'];
	if ( ((PHP_VERSION_ID >= 50310) && (PHP_VERSION_ID < 50600)) OR ((PHP_VERSION_ID >= 50600) && (PHP_VERSION_ID < 50700)) OR (PHP_VERSION_ID >= 70000) && (PHP_VERSION_ID < 72000) ) {
		
		if ( version_compare($ic_php, $ic_required) >= 0 ) {
			$ioncube_version_str = '<font color="green">Installed, ver. ' . $ioncube_loader_version['version'] . '</font>';
			$status_ioncube_str = '<b><font color="green">OK</font></b>';
		} else {
			$ioncube_version_str = '<font color="red">Installed, ver. ' . $ioncube_loader_version['version'] . '</font>';
			$status_ioncube_str = '<b><font color="red">Off</font></b>';
		}

	} else {
		$ioncube_version_str = '<font color="red">Not supported by this version of PHP</font>';
		$status_ioncube_str = '<b><font color="red">Off</font></b>';
	}
} else {
	$ioncube_version_str = '<font color="red">Not Installed</font>';
	$status_ioncube_str = '<b><font color="red">Off</font></b>';
}

$server_settings = server_settings();

if ( return_bytes($server_settings['memory_limit']) >= 128 * 1024 * 1024 ) {
	$settings['memory_limit'] = '<font color="green">' . $server_settings['memory_limit'] . '</font>';
	$status['memory_limit'] = '<b><font color="green">OK</font></b>';
} else {
	$settings['memory_limit'] = '<font color="gray">' . $server_settings['memory_limit'] . '</font>';
	$status['memory_limit'] = '<b><font color="gray">Off</font></b>';
}
if ( return_bytes($server_settings['post_max_size']) >= 16 * 1024 * 1024 ) {
	$settings['post_max_size'] = '<font color="green">' . $server_settings['post_max_size'] . '</font>';
	$status['post_max_size'] = '<b><font color="green">OK</font></b>';
} else {
	$settings['post_max_size'] = '<font color="gray">' . $server_settings['post_max_size'] . '</font>';
	$status['post_max_size'] = '<b><font color="gray">Off</font></b>';
}
if ( return_bytes($server_settings['upload_max_filesize']) >= 16 * 1024 * 1024 ) {
	$settings['upload_max_filesize'] = '<font color="green">' . $server_settings['upload_max_filesize'] . '</font>';
	$status['upload_max_filesize'] = '<b><font color="green">OK</font></b>';
} else {
	$settings['upload_max_filesize'] = '<font color="gray">' . $server_settings['upload_max_filesize'] . '</font>';
	$status['upload_max_filesize'] = '<b><font color="gray">Off</font></b>';
}
if ( return_bytes($server_settings['post_max_size']) >= 16 * 1024 * 1024 ) {
	$settings['post_max_size'] = '<font color="green">' . $server_settings['post_max_size'] . '</font>';
	$status['post_max_size'] = '<b><font color="green">OK</font></b>';
} else {
	$settings['post_max_size'] = '<font color="gray">' . $server_settings['post_max_size'] . '</font>';
	$status['post_max_size'] = '<b><font color="gray">Off</font></b>';
}
// max_execution_time
if ( $server_settings['max_execution_time'] == 0 || $server_settings['max_execution_time'] >= 300 ) {
	$settings['max_execution_time'] = '<font color="green">' . $server_settings['max_execution_time'] . '</font>';
	$status['max_execution_time'] = '<b><font color="green">OK</font></b>';
} else {
	$settings['max_execution_time'] = '<font color="gray">' . $server_settings['max_execution_time'] . '</font>';
	$status['max_execution_time'] = '<b><font color="gray">Off</font></b>';
}
?>
<div id="container">
<div id="content">
    <div style="text-align:center"><strong>Скрипт для проверки системы v<?php echo $version; ?></strong></div>
    <p><?php echo intro(); ?></p>
    	<p>&nbsp;</p>
	<p align="center">
	OpenCart Version: <b><?php echo get_opencart_version();?></b><br />
	Config Server Name: <b><?php echo get_cfg_sever_name();?></b><br />
	Host Server Name: <b><?php echo $_SERVER['SERVER_NAME'];?></b>
	<p>
	<p>&nbsp;</p>
	<p><strong>Обязательные настройки:</strong></p>
      <table>
          <thead>
            <tr>
              <th width="35%" align="left">Настройки Вашего сервера</th>
                <th width="25%" align="left">Текущие настройки</th>
                <th width="25%" align="left">Необходимые настройки</th>
                <th width="15%" align="center">Состояние</th>
            </tr>
        <thead>
        <tr>
          <td>PHP Version:</td>
          <td><?php echo $phpversion_str; ?></td>
          <td>5.3.x, 5.4.x, 5.4.x, 5.6.x, 7.0.x, 7.1.x, 7.2.x</td>
          <td class="center"><?php echo $status_phpversion_str; ?></td>
        </tr>
        <tr>
          <td>ionCube PHP Loader:</td>
          <td><?php echo $ioncube_version_str; ?></td>
          <td><?php echo $ic_required;?>+
        </td>
          <td class="center"><?php echo $status_ioncube_str; ?></td>
        </tr>
        <tr>
          <td>OpenSSL support:</td>
          <td><?php echo $openssl_installed; ?></td>
          <td>enabled</td>
          <td class="center"><?php echo $openssl_status; ?></td>
        </tr>
	</table>
	<p>&nbsp;</p>
	<p><strong>Дополнительные настройки:</strong></p>
	<table>
          <thead>
            <tr>
              <th width="35%" align="left">Настройки Вашего сервера</th>
                <th width="25%" align="left">Текущие настройки</th>
                <th width="25%" align="left">Рекомендуемые настройки</th>
                <th width="15%" align="center">Состояние</th>
            </tr>
        <thead>
	<tr>
          <td>max_execution_time</td>
          <td><?php echo $settings['max_execution_time']; ?></td>
          <td>300+</td>
          <td class="center"><?php echo $status['max_execution_time']; ?></td>
        </tr>
	<tr>
          <td>memory_limit</td>
          <td><?php echo $settings['memory_limit']; ?></td>
          <td>128M+</td>
          <td class="center"><?php echo $status['memory_limit']; ?></td>
        </tr>
	<tr>
          <td>post_max_size</td>
          <td><?php echo $settings['post_max_size']; ?></td>
          <td>16M+</td>
          <td class="center"><?php echo $status['post_max_size']; ?></td>
        </tr>
	<tr>
          <td>upload_max_filesize</td>
          <td><?php echo $settings['upload_max_filesize']; ?></td>
          <td>16M+</td>
          <td class="center"><?php echo $status['upload_max_filesize']; ?></td>
        </tr>
	<tr>
          <td>post_max_size</td>
          <td><?php echo $settings['post_max_size']; ?></td>
          <td>16M+</td>
          <td class="center"><?php echo $status['post_max_size']; ?></td>
        </tr>
	
      </table>
      <p>&nbsp;</p>
      <div style="text-align:center; margin-top:20px;"><?php echo server_info(); ?></div>
	  <div style="text-align:center; margin-top:20px;">
			<a href="http://www.opencartlabs.ru" target="blank">www.opencartlabs.ru</a>
	  </div>
</div>
</div>
</body></html>
<?php
function intro() {
	return "Этот скрипт проверит, текушие настройки Вашего сервера.\n" . "Результаты проверки отображаются на экране <b><font color=\"green\">зеленым</font></b> или <b><font color=\"red\">красным</font></b> цветом.
	<br /><br />Необязательные параметры отображаются <b><font color=\"grey\">серым</font></b> цветом.
	<br /><br /><b>ВНИМАНИЕ!!! Все результаты проверки должны быть <font color=\"green\">зелёным цветом.</font></b>
	<br /><br /> Если некоторые необходимые значения отображаются <b><font color=\"red\">красным цветом</font></b>, пожалуйста, <br />выполните необходимые действия для устранения сами или обратитесь в техподдержку Вашего хостинг-провайдера, а затем запустите скрипт снова.";
}

function ioncube_loader_version_array() {
	if ( extension_loaded("ionCube Loader") ) {
		if ( function_exists('ioncube_loader_iversion') ) {
			// Mmmrr
			$ioncube_loader_iversion = ioncube_loader_iversion();
			if (version_compare($ioncube_loader_iversion, '100000') >= 0) {
				$ioncube_loader_version_major = (int)substr($ioncube_loader_iversion, 0, 2);
				$ioncube_loader_version_minor = (int)substr($ioncube_loader_iversion, 2, 2);
				$ioncube_loader_version_revision = (int)substr($ioncube_loader_iversion, 4, 2);
			} else {
				$ioncube_loader_version_major = (int)substr($ioncube_loader_iversion, 0, 1);
				$ioncube_loader_version_minor = (int)substr($ioncube_loader_iversion, 1, 2);
				$ioncube_loader_version_revision = (int)substr($ioncube_loader_iversion, 3, 2);
			}
			$ioncube_loader_version = "$ioncube_loader_version_major.$ioncube_loader_version_minor.$ioncube_loader_version_revision";
		} else {
			if (version_compare($ioncube_loader_iversion, '100000') >= 0) {
				$ioncube_loader_version = ioncube_loader_version();
				$ioncube_loader_version_major = (int)substr($ioncube_loader_version, 0, 2);
				$ioncube_loader_version_minor = (int)substr($ioncube_loader_version, 3, 1);
			} else {
				$ioncube_loader_version = ioncube_loader_version();
				$ioncube_loader_version_major = (int)substr($ioncube_loader_version, 0, 1);
				$ioncube_loader_version_minor = (int)substr($ioncube_loader_version, 2, 1);
			}
			$$ioncube_loader_version_revision = 0;
		}
		return array('version' => $ioncube_loader_version, 'major' => $ioncube_loader_version_major, 'minor' => $ioncube_loader_version_minor, 'revision' => $ioncube_loader_version_revision);
	} else {
		return false;
	}
}

function server_settings() {
	$result = array('safe_mode' => ini_get("safe_mode"), 'max_execution_time' => ini_get("max_execution_time"), 'memory_limit' => ini_get("memory_limit"), 'file_uploads' => ini_get('file_uploads'), 'post_max_size' => ini_get("post_max_size"), 'upload_max_filesize' => ini_get("upload_max_filesize"));
	return $result;
}

function get_opencart_version(){
	$oc_version = 'Unknown';
	if ( file_exists('index.php') ) {
		$f = file_get_contents('index.php');
		preg_match("/define\('VERSION', '([0-9]*\.[0-9]*\.[0-9]*\.[0-9]*)/i", $f, $matches);
		if ( isset($matches[1]) ) {
			$oc_version = $matches[1];
		}
	}
	return $oc_version;
}

function get_cfg_sever_name(){
	$oc_server_name = 'Unknown';
	if ( file_exists('config.php') ) {
		$f = file_get_contents('config.php');
		preg_match("/define\('HTTP_SERVER', '(https?:\/\/([^\/]+)\/*)/i", $f, $matches);
		if ( isset($matches[1]) ) {
			$parse = parse_url($matches[1]);
			$oc_server_name = $parse['host'];
		}
	}
	return $oc_server_name;
}

function server_info() {
	if ( isset($_SERVER['SERVER_SOFTWARE']) ) {
		$status = $_SERVER['SERVER_SOFTWARE'];
	} else if ( ($sf = getenv('SERVER_SOFTWARE')) ) {
		$status = $sf;
	} else {
		$status = 'n/a';
	}
	$oc_version = get_opencart_version();
	$oc_server_name = get_cfg_sever_name();
	$body = $status . "Server IP:" . $_SERVER['SERVER_ADDR'] . "<br /\n>" . "PHP info:</td><td><a href=\"" . $_SERVER['PHP_SELF'] . "?phpinfo=1\" target=\"_blank\">Click here</a><br /\n>";
	return $body;
}

function return_bytes($val) {
	$val = trim($val);
	$last = strtolower($val[strlen($val) - 1]);
	switch($last) {
		// Модификатор 'G' доступен, начиная с PHP 5.1.0
		case 'g' :
			$val = (int)$val * 1024;
		case 'm' :
			$val = (int)$val * 1024;
		case 'k' :
			$val = (int)$val *  1024;
	}

	return $val;
}
?>