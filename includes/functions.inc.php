<?php
/**
* custom function สร้างฟังก์ชั่นสำหรับทำงานเฉพาะ ที่ไม่มีใน php หรืออะไรก็ตาม
*/

function currentDir() {
	$output = dirname(__FILE__);
	return $output;
}// currentDir

function datediff($interval, $datefrom, $dateto, $using_timestamps = false) {
	/*
	from http://www.addedbytes.com/php/php-datediff-function
	$interval can be:
	yyyy - Number of full years
	q - Number of full quarters
	m - Number of full months
	y - Difference between day numbers
	(eg 1st Jan 2004 is "1", the first day. 2nd Feb 2003 is "33". The datediff is "-32".)
	d - Number of full days
	w - Number of full weekdays
	ww - Number of full weeks
	h - Number of full hours
	n - Number of full minutes
	s - Number of full seconds (default)
	*/
	if (!$using_timestamps) {
		$datefrom = strtotime($datefrom, 0);
		$dateto = strtotime($dateto, 0);
	}
	$difference = $dateto - $datefrom; // Difference in seconds
	switch($interval) {
	case 'yyyy': // Number of full years
	$years_difference = floor($difference / 31536000);
	if (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom), date("j", $datefrom), date("Y", $datefrom)+$years_difference) > $dateto) {
		$years_difference--;
	}
	if (mktime(date("H", $dateto), date("i", $dateto), date("s", $dateto), date("n", $dateto), date("j", $dateto), date("Y", $dateto)-($years_difference+1)) > $datefrom) {
		$years_difference++;
	}
	$datediff = $years_difference;
	break;
	case "q": // Number of full quarters
	$quarters_difference = floor($difference / 8035200);
	while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($quarters_difference*3), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
		$months_difference++;
	}
	$quarters_difference--;
	$datediff = $quarters_difference;
	break;
	case "m": // Number of full months
	$months_difference = floor($difference / 2678400);
	while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($months_difference), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
		$months_difference++;
	}
	$months_difference--;
	$datediff = $months_difference;
	break;
	case 'y': // Difference between day numbers
	$datediff = date("z", $dateto) - date("z", $datefrom);
	break;
	case "d": // Number of full days
	$datediff = floor($difference / 86400);
	break;
	case "w": // Number of full weekdays
	$days_difference = floor($difference / 86400);
	$weeks_difference = floor($days_difference / 7); // Complete weeks
	$first_day = date("w", $datefrom);
	$days_remainder = floor($days_difference % 7);
	$odd_days = $first_day + $days_remainder; // Do we have a Saturday or Sunday in the remainder?
	if ($odd_days > 7) { // Sunday
		$days_remainder--;
	}
	if ($odd_days > 6) { // Saturday
		$days_remainder--;
	}
	$datediff = ($weeks_difference * 5) + $days_remainder;
	break;
	case "ww": // Number of full weeks
	$datediff = floor($difference / 604800);
	break;
	case "h": // Number of full hours
	$datediff = floor($difference / 3600);
	break;
	case "n": // Number of full minutes
	$datediff = floor($difference / 60);
	break;
	default: // Number of full seconds (default)
	$datediff = $difference;
	break;
	}
	return $datediff;
}//datediff

//sorry this cannot be function
$explodePath = explode('/', $_SERVER['PHP_SELF']);

function http_referer() {
	//set server http_referer
	if (isset($_SERVER['HTTP_REFERER'])) {
		$output = $_SERVER['HTTP_REFERER'];
	} else {
		$output = $_SERVER['PHP_SELF'];
	}
	return $output;
}// http_referer

/**
* nl2br2
 * Convert \n to <br />
 *
 * @param string $string String to transform
 * @return string New string
 */
function nl2br2($string)
{
	return str_replace(array("\r\n", "\r", "\n"), '<br />', $string);
}//nl2br2

/**
* truncate string truncate_string($string, $maxlength)
* $string is string,
* $maxlength = maxlength
* from http://www.phpbuilder.com/board/showthread.php?t=10351273
*/
function truncate_string($string, $max_length){
    if (strlen($string) > $max_length) {
         $string = substr($string,0,$max_length);
         $string .= '...';
    }
return $string;
}//truncate_string

function user_ip() {
	//find user ip
	if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$output = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
		$output = $_SERVER['HTTP_CLIENT_IP'];
	} else {
		$output = $_SERVER['REMOTE_ADDR'];
	}
	return $output;
}// user_ip

?>