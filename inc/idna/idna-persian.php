<?php

include_once("utf-8.php");
include_once("idna-consts.php");

$idna_persian_error = 0;

function persian_normalize($a)
{
	global $normalization_table;

	$isstr = is_string($a);
	if ($isstr) 
		$a = utf8_decompose($a);

	$r = array();
	foreach ($a as $c) {
		if (array_key_exists($c, $normalization_table))
			$r[] = $normalization_table[$c];
		else
			$r[] = $c;
	}

	if ($isstr)
		$r = utf8_compose($r);

	return $r;
}

$persian_error = 0;
$persian_error_index = -1;

function persian_isvalid($a)
{
	global $permitted, $letters_perm, $persian_error, $persian_error_index;

	$isstr = is_string($a);
	if ($isstr) 
		$a = utf8_decompose($a);

	$a = persian_normalize($a);

	if (count($a) == 0) {
		$persian_error = 1;
		return false;
	}

	if (!in_array($a[0], $letters_perm)) {
		$persian_error = 2;
		$persian_error_index = 0;
		return false;
	}
	if (!in_array($a[count($a)-1], $letters_perm)) {
		$persian_error = 3;
		$persian_error_index = count($a)-1;
		return false;
	}

	for ($i = 0; $i < count($a); ++$i) {
		if (!in_array($a[$i], $permitted)) {
			$persian_error = 4;
			$persian_error_index = $i;
			return false;
		}
	}

	return true;
}

function persian_canonize($a)
{
	global $ignorables;

	$isstr = is_string($a);
	if ($isstr) 
		$a = utf8_decompose($a);

	$a = persian_normalize($a);

	$r = array();
	for ($i = 0, $j = 0; $i < count($a); ++$i) {
		if (in_array($a[$i], $ignorables))
			continue;
		else
			$r[$j++] = $a[$i];
	}

	if ($isstr)
		$r = utf8_compose($r);

	return $r;
}

// assumes $s is already canonized.
function make_bundle($a)
{
	global $bundle_map;

	$isstr = is_string($a);
	if ($isstr) 
		$a = utf8_decompose($a);

	$r = array($a); $l = 1;
	foreach ($bundle_map as $map) {
		$t = array();
		for ($i = 0; $i < count($a); ++$i) {
			if (array_key_exists($a[$i], $map))
				$t[$i] = $map[$a[$i]];
			else
				$t[$i] = $a[$i];
		}
		if (!in_array($t, $r)) {
			$r[$l++] = $t;
		}
	}	

	if ($isstr) {
		for ($i = 0; $i < $l; ++$i) {
			$r[$i] = utf8_compose($r[$i]);
		}
	}

	return $r;
}

?>
