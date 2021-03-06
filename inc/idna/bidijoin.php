<?php

include_once("idna-consts.php");
include_once("shaping-table.php");
require_once("utf-8.php");

function joining_type($c)
{
	global $joining_table;
	if (array_key_exists ($c, $joining_table)) {
		return $joining_table[$c];
	}
	else
		return 1;
}

function glyph_sequence($a)
{
	global $ignorables, $persian_digits, $shaping_table;

	$isstr = is_string($a);
	if ($isstr)  {
		$a = utf8_decompose($a);
	}

	$has_rtl = false;

	// compute shapes
	$sh = array();
	$l = count($a);
	for ($i = 0; $i < $l; ++$i) {

		switch (joining_type ($a[$i])) {

			case NONJOINING:
				$sh[$i] = 1;
				break;

			case RIGHTJOINING:
				$has_rtl = true;
				$sh[$i] = ($i > 0 and joining_type ($a[$i-1]) == DUALJOINING) ? 1 : 0;
				break;

			case DUALJOINING:
				$has_rtl = true;
				$sh[$i] = (($i > 0 and joining_type ($a[$i-1]) == DUALJOINING) ? 1 : 0)
					  + (($i < $l-1 and joining_type ($a[$i+1]) >= RIGHTJOINING) ? 2 : 0);

			default:
				// XXX
				break;

		}
	}

	// Lam-Alef ligature
	$lig = array_fill(0, $l, false);
	for ($i = 0; $i < $l-1; ++$i) {
		if ($a[$i] == LAM and $sh[$i] >= INIT and $sh[$i+1] == FINA
				and ($a[$i+1] == ALEF or $a[$i+1] == ALEFHAMZE or $a[$i+1] == ALEFMAD)) {
			$lig[$i] = true;
		}
	}

	// remove ZWJ and ZWNJ	
	$b = array();
	$sh2 = array();
	$lig2 = array();
	for ($i = 0, $j = 0; $i < $l; ++$i) {

		if (in_array ($a[$i], $ignorables)) {
			continue;
		}

		else {
			$b[$j] = $a[$i];
			$sh2[$j] = $sh[$i];
			$lig2[$j] = $lig[$i];
			++$j;
		}

	}
	$a = $b; $sh = $sh2; $lig = $lig2; $l = count($a);

	// bidi
	$i = 0;

	while ($i < $l) {
		if (in_array ($a[$i], $persian_digits)) {
			$j = $i;

			do {
				++$j;
			} while ($j < $l and in_array ($a[$j], $persian_digits));

			--$j;

			for ($ip = $i, $jp = $j; $ip < $jp; ++$ip, --$jp) {
				$t = $a[$ip]; $a[$ip] = $a[$jp]; $a[$jp] = $t;
			}

			$i = $j + 1;
		}

		else {
			++$i;
		}
	}

	$r = array();
	for ($i = 0, $j = 0; $i < $l; ++$i, ++$j) {

		if ($lig[$i]) {
			$r[$j] = hexdec($shaping_table[hex($a[$i])." ".hex($a[$i+1])][$sh[$i]-2]);
			++$i;
		}

		/*
		elseif ($a[$i] == TIREMENHA) {
			$r[$j] = TIRE;
		}
		*/

		elseif (joining_type($a[$i]) == 1) {
			$r[$j] = $a[$i];
		}

		else {
			$r[$j] = hexdec($shaping_table[hex($a[$i])][$sh[$i]]);
		}
	}

	// XXX

	/* Method 1 * // No need, as fribidi works fine!
	if ($has_rtl) {
		$r = array_reverse ($r);
	}
	/* */

	/* Method 2 */
	$r = utf8_compose($r);
	$r = fribidi_log2vis ($r, FRIBIDI_AUTO, FRIBIDI_CHARSET_UTF8);
	/* */

	if (!$isstr) {
		$r = utf8_decompose($r);
	}

	return $r;
}
?>
