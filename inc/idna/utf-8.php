<?php
function hex($c)
{
	return sprintf("%04X", $c);
}

// returns the UTF-8 string of a certain Unicode code
function to_utf8($u)
{
	if ((!is_int($u)) or $u < 0 or $u > 0x10FFFF)
		return to_utf8(0xFFFD);

	mb_substitute_character(0xFFFD);
	$t = chr($u & 0xFF).chr(($u >> 8) & 0xFF).chr($u >> 16).chr(0);
	$s = mb_convert_encoding ($t, "UTF-8", "UTF-32LE");
	return $s;
}

/*
function to_utf8($u)
{
	if ((!is_int($u)) or $u < 0 or $u > 0x10FFFF) {
		return to_utf8(0xFFFD);
	} elseif ($u <= 0xFF) {
		return chr($u);
	} else if ($u <= 0x7FF) {
		return chr(0xC0 | ($u >> 6))
                      .chr(0x80 | ($u & 0x3F));
	} else if ($u <= 0xFFFF) {
		return chr(0xE0 | ($u >> 12))
                      .chr(0x80 | (($u >> 6) & 0x3F))
                      .chr(0x80 | ($u & 0x3F));
	} else if ($u <= 0x10FFFF) {
		return chr(0xF0 | ($u >> 18))
                      .chr(0x80 | (($u >> 12) & 0x3F))
                      .chr(0x80 | (($u >> 6) & 0x3F))
                      .chr(0x80 | ($u & 0x3F));
	}
}
*/

// returns the unicode of the first UTF-8 character in the string.
// returns -1 if the first character is not valid UTF-8 or is U+FFFD.
function from_utf8($s)
{
	mb_substitute_character(0xFFFD);
	$t = mb_convert_encoding ($s, "UTF-32LE", "UTF-8");
	if (strlen($t) == 0)
		return -1;
	$r = ord($t{0}) | ord($t{1}) << 8 | ord($t{2}) << 16;
	if ($r == 0xFFFD)
		return -1;
	else
		return $r;
}
/*
function from_utf8($s)
{
	if (strlen($s) == 0)
		return -1;
	else
		$c0 = ord($s{0});
	if ($c0 <= 0x7F) {
		return $c0;
	} else {
		if (strlen($s) <= 1)
			return -1;
		else
			$c1 = ord($s{1});
		if (0xC2 <= $c0 and $c0 <= 0xDF and 0x80 <= $c1 and $c1 <= 0xBF) {
			return ((0x1F & $c0) << 6) | (0x3F & $c1);
		} else {
			if (strlen($s) <= 2)
				return -1;
			else
				$c2 = ord($s{2});
			if (($c0 == 0xE0 and 0xA0 <= $c1 and $c1 <= 0xBF and 0x80 <= $c2 and $c2 <= 0xBF) or
 			    (0xE1 <= $c0 and $c0 <= 0xEC and 0x80 <= $c1 and $c1 <= 0xBF and 0x80 <= $c2 and $c2 <= 0xBF) or
			    ($c0 == 0xED and 0x80 <= $c1 and $c1 <= 0x9F and 0x80 <= $c2 and $c2 <= 0xBF) or
			    (0xEE <= $c0 and $c0 <= 0xEF and 0x80 <= $c1 and $c1 <= 0xBF and 0x80 <= $c2 and $c2 <= 0xBF)) {
				return ((0x0F & $c0) << 12) | ((0x3F & $c1) << 6) | (0x3F & $c2);
			} else {
				if (strlen($s) <= 3)
					return -1;
				else
					$c3 = ord($s{3});
				if (($c0 == 0xF0 and 0x90 <= $c1 and $c1 <= 0xBF
						 and 0x80 <= $c2 and $c2 <= 0xBF
						 and 0x80 <= $c3 and $c3 <= 0xBF) or
				    		(0xF1 <= $c0 and $c0 <= 0xF3
				    		 and 0x80 <= $c1 and $c1 <= 0xBF
						 and 0x80 <= $c2 and $c2 <= 0xBF
						 and 0x80 <= $c3 and $c3 <= 0xBF) or
				    		($c0 == 0xF4 and 0x80 <= $c1 and $c1 <= 0x8F
						 and 0x80 <= $c2 and $c2 <= 0xBF
						 and 0x80 <= $c3 and $c3 <= 0xBF)) {
					return ((0x07 & $c0) << 18) | ((0x3F & $c1) << 12)
								    | ((0x3F & $c2) << 6)
								    | (0x3F & $c3);
				}
				else
					return -1;
			}
		}
	}
}
*/

//returns an array of Unicode codepoints for a given UTF-8 string.
function utf8_decompose($s)
{
	$r = array();
	$t = mb_convert_encoding ($s, "UTF-32LE", "UTF-8");
	for ($i = 0, $j = 0; $i < strlen($t); $j++, $i += 4) {
		$r[$j] = ord($t{$i}) | ord($t{$i+1}) << 8 | ord($t{$i+2}) << 16;
	}
	return $r;
}

//returns a UTF-8 string for an array of Unicode codepoints.
function utf8_compose($a)
{
	$t = '';
	for ($j = 0; $j < count($a); $j++) {
		$u = $a[$j];
		$t .= chr($u & 0xFF).chr(($u >> 8) & 0xFF).chr($u >> 16).chr(0);
	}
	$r = mb_convert_encoding ($t, "UTF-8", "UTF-32LE");
	return $r;
}

function persian_number($n)
{
	$n = (string) $n;
	$r = "";
	for ($i = 0; $i < strlen($n); ++$i) {
		$r .= to_utf8(0x06F0+ord($n[$i])-ord("0"));
	}
	return $r;
}

// $c must be a unicode character in UTF-8 form
function persian_printable($c)
{
	switch ($c) {
	case to_utf8(0x200C):
		return "فاصله‌ی مجازی";
	case to_utf8(0x200D):
		return "اتصال مجازی";		
	case "ه":
		return $c.to_utf8(0x200D);
	case "ك": case "ي":
		return $c." عربی";
	case "ک": case "ی":
		return $c." فارسی";
	case "1": case "2": case "3": case "4": case "5":
	case "6": case "7": case "8": case "9": case "0":
		return $c." اروپایی";
	case to_utf8(0x0660): case to_utf8(0x0661):
	case to_utf8(0x0662): case to_utf8(0x0663):
	case to_utf8(0x0664): case to_utf8(0x0665):
	case to_utf8(0x0666): case to_utf8(0x0667):
	case to_utf8(0x0668): case to_utf8(0x0669):
		return $c." عربی";
	case to_utf8(0x06F0): case to_utf8(0x06F1):
	case to_utf8(0x06F2): case to_utf8(0x06F3):
	case to_utf8(0x06F4): case to_utf8(0x06F5):
	case to_utf8(0x06F6): case to_utf8(0x06F7):
	case to_utf8(0x06F8): case to_utf8(0x06F9):
		return $c." فارسی";
	case "-":
		return "تیره‌منها";
	default:
		return $c;
	}
}

?>
