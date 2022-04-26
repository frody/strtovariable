<?php
/*
 * Converter a string to variable
 *
 * @package   strtovar.php 0.0.1
 * @link      https://github.com/frody/strtovariable-php-
 * @author    ffrody@gmail.com
 * @copyright 2018 frody (Choi H S)
 * @license   http://opensource.org/licenses/MIT  MIT
 */

function strtovar($str){
	if( !preg_match("/^[$]/",$str) ) return $str;

	$rootstr = preg_replace("/^[$]/","",$str);
	$sprow = preg_split("/\-\>/",$rootstr);

	for( $i = 0 ; $i < count($sprow) ; $i++ ){
		if( !preg_match("/\[/",$sprow[$i]) ){ //sub variable is not Array
			if( $i ){
				$str = $str->{$sprow[$i]};
			}else{
				global ${$sprow[$i]};
				$str = ${$sprow[$i]};
			}
		}else{ //sub variable is Array
			$strhd = substr($sprow[$i],0,strpos($sprow[$i],"["));
			if( $i ){
				$str = $str->{$strhd};
			}else{
				global ${$strhd};
				$str = ${$strhd};
			}

			$matches = Array();
			preg_match_all("/\[[^\]]*\]/",$sprow[$i],$matches);
			foreach($matches[0] as $val){
				$str = $str[preg_replace("/[\[\]\"\']/","",$val)];
			}
		}
	}
	return $str;
}
