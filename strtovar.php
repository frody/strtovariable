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
	if( !preg_match("/\[/",$sprow[0]) ){ //root variable is not Array
		$str = ${$sprow[0]};
	}else{ //root variable is Array
		$sprow_gloval = substr($sprow[0],0,strpos($sprow[0],"["));
		$str = ${$sprow_gloval};

		$matches = Array();
		preg_match_all("/\[[^\]]*\]/",$sprow[0],$matches);
		foreach($matches[0] as $val){
			$str = $str[(preg_replace("/[\[\]\"\']/","",$val))];
		}
	}

	if( count($sprow) > 1 ){ //root variable has sub objects
		for( $i = 1 ; $i < count($sprow) ; $i++ ){
			if( !preg_match("/\[/",$sprow[$i]) ){ //sub variable is not Array
				$str = $str->{$sprow[$i]};
			}else{ //sub variable is Array
				$strhd = substr($sprow[$i],0,strpos($sprow[$i],"["));
				$str = $str->{$strhd};

				$matches = Array();
				preg_match_all("/\[[^\]]*\]/",$sprow[$i],$matches);
				foreach($matches[0] as $val){
					$str = $str[preg_replace("/[\[\]\"\']/","",$val)];
				}
			}
		}
	}
	return $str;
}
