<?php
if (!defined('THINKSNS_INSTALL'))
{
	exit ('Access Denied');
}
function str_parcate($cate, &$str_parcate, $startID = 0)
{
	if (!$cate[$startID]['cup']) return;
	foreach ($cate as $key => $value)
	{
		if ($value['cup'] == $startID)
		{
			$str_parcate .= $value['cid'].',';
			str_parcate($cate, $str_parcate, $value['cid']);
		}
	}
}

function str_subcate($cate, &$str_subcate, $startID = 0)
{
	foreach ($cate as $key => $value)
	{
		if ($value['cup'] == $startID)
		{
			$str_subcate .= $value['cid'].',';
			str_subcate($cate, $str_subcate, $value['cid']);
		}
	}
}
function addS(&$array)
{
	if (is_array($array))
	{
		foreach ($array as $key => $value)
		{
			 addS($array[$key]);
		}
	}
	elseif (is_string($array))
	{
		$array = addslashes($array);
	}
}
function result($result = 1, $output = 1)
{
	if($result)
	{
		$text = ' ... <span class="blue">OK</span>';
		if(!$output)
		{
			return $text;
		}
		echo $text;
	}
	else
	{
		$text = ' ... <span class="red">Failed</span>';
		if(!$output)
		{
			return $text;
		}
		echo $text;
	}
}
function createtable($sql, $db_charset)
{
	$db_charset = (strpos($db_charset, '-') === FALSE) ? $db_charset : str_replace('-', '', $db_charset);
	$type = strtoupper(preg_replace("/^\s*CREATE TABLE\s+.+\s+\(.+?\).*(ENGINE|TYPE)\s*=\s*([a-z]+?).*$/isU", "\\2", $sql));
	$type = in_array($type, array("MYISAM", "HEAP")) ? $type : "MYISAM";
	return preg_replace("/^\s*(CREATE TABLE\s+.+\s+\(.+?\)).*$/isU", "\\1", $sql).
		(mysql_get_server_info() > "4.1" ? " ENGINE=$type DEFAULT CHARSET=$db_charset" : " TYPE=$type");
}
function getip()
{
	if (isset ($_SERVER['HTTP_X_FORWARDED_FOR']))
	{
		$onlineip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	elseif (isset ($_SERVER['HTTP_CLIENT_IP']))
	{
		$onlineip = $_SERVER['HTTP_CLIENT_IP'];
	}
	else
	{
		$onlineip = $_SERVER['REMOTE_ADDR'];
	}
	$onlineip = preg_match('/[\d\.]{7,15}/', addslashes($onlineip), $onlineipmatches);
	return $onlineipmatches[0] ? $onlineipmatches[0] : 'unknown';
}
function writable($var)
{
	$writeable = FALSE;
	$var = THINKSNS_ROOT.$var;
	if(!is_dir($var))
	{
		@mkdir($var, 0777,true);
	}
	if (is_dir($var))
	{
		$var .= '/temp.txt';
		if (($fp = @fopen($var, 'w')) && (fwrite($fp, 'thinksns')))
		{
			fclose($fp);
			@unlink($var);
			$writeable = TRUE;
		}
	}
	return $writeable;
}
function PWriteFile($filename, $content, $mode = 'ab')
{
	if (strpos($filename, '..') !== FALSE)
	{
		return FALSE;
	}
	$path = dirname($filename);
	if (!is_dir($path))
	{
		if (!mkdir($path, 0777))
		{
			return FALSE;
		}
	}
	$fp = @ fopen($filename, $mode);
	if ($fp)
	{
		flock($fp, LOCK_EX);
		fwrite($fp, $content);
		fclose($fp);
		@ chmod($filename, 0777);
		return TRUE;
	}
	return FALSE;
}
function random($length, $isNum = FALSE)
{
	$random = '';
	$str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	$num = '0123456789';
	if ($isNum)
	{
		$sequece = 'num';
	}
	else
	{
		$sequece = 'str';
	}
	$max = strlen($$sequece) - 1;
	for ($i = 0; $i < $length; $i++)
	{
		$random .= ${$sequece}{mt_rand(0, $max)};
	}
	return $random;
}

function dump($var, $echo=true,$label=null, $strict=true)
{
    $label = ($label===null) ? '' : rtrim($label) . ' ';
    if(!$strict) {
        if (ini_get('html_errors')) {
            $output = print_r($var, true);
            $output = '<pre style="text-align:left">'.$label.htmlspecialchars($output,ENT_QUOTES).'</pre>';
        } else {
            $output = $label . " : " . print_r($var, true);
        }
    }else {
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        if(!extension_loaded('xdebug')) {
            $output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
            $output = '<pre style="text-align:left">'. $label. htmlspecialchars($output, ENT_QUOTES). '</pre>';
        }
    }
    if ($echo) {
        echo($output);
        return null;
    }else
        return $output;
}


?>