<?php
define("ZWNJ", 0x200C);
define("ZWJ", 0x200D);
define("LRM", 0x200E);
define("RLM", 0x200F);
define("LAM", 0x0644);
define("ALEF", 0x0627);
define("ALEFHAMZE", 0x0623);
define("ALEFMAD", 0x0622);
define("LAMALEF", 0xFEFB);
define("LAMALEFHAMZE", 0xFEF7);
define("LAMALEFMAD", 0xFEF5);
define("TIREMENHA", 0x002D);
define("TIRE", 0x2010);

define("ISOL", 0);
define("FINA", 1);
define("INIT", 2);
define("MEDI", 3);

define("DUALJOINING", 4);
define("RIGHTJOINING", 2);
define("NONJOINING", 1);

$letters_perm = array(0x0622, // AA
		 0x0627, // ALEF
		 0x0621, // HAMZE
		 0x0623, // ALEF-HAMZE
		 0x0628, // BE
		 0x067E, // PE
		 0x062A, // TE
		 0x062B, // SE
		 0x062C, // JIM
		 0x0686, // CHE
		 0x062D, // HE (HOTTI)
		 0x062E, // KHE
		 0x062F, // DAL
		 0x0630, // ZAL
		 0x0631, // RE
		 0x0632, // ZE
		 0x0698, // ZHE
		 0x0633, // SIN
		 0x0634, // SHIN
		 0x0635, // SAD
		 0x0636, // ZAD
		 0x0637, // TA
		 0x0638, // ZA
		 0x0639, // EYN
		 0x063A, // GHEYN
		 0x0641, // FE
		 0x0642, // GHAF
		 0x06A9, // KAF
		 0x06AF, // GAF
		 0x0644, // LAM
		 0x0645, // MIM
		 0x0646, // NOON
		 0x0648, // VAV
		 0x0624, // VAV-HAMZE
		 0x0647, // HE (HAVVAZ)
		 0x0629, // TE GERD
		 0x06CC, // YE
		 0x0626, // YE-HAMZE
);

$digits_perm = array(0x06F0, // 0
		0x06F1, // 1
		0x06F2, // 2
		0x06F3, // 3
		0x06F4, // 4
		0x06F5, // 5
		0x06F6, // 6
		0x06F7, // 7
		0x06F8, // 8
		0x06F9, // 9
);

$other_perm = array(0x002D); //TIRE-MENHA

$ignorables = array(
	0x200C,	// FASELE-YE MAJAZI
        0x200D, // ETTESAL-E MAJAZI
);

$permitted = array_merge($letters_perm, $digits_perm, $other_perm, $ignorables);

$normalization_table = array(
	0x0643 => 0x06A9, // KAF-E ARABI
	0x064A => 0x06CC, // YE-YE ARABIC
	0x0030 => 0x06F0, // 0-E OROOPAI
	0x0031 => 0x06F1, // 1-E OROOPAI
	0x0032 => 0x06F2, // 2-E OROOPAI
	0x0033 => 0x06F3, // 3-E OROOPAI
	0x0034 => 0x06F4, // 4-E OROOPAI
	0x0035 => 0x06F5, // 5-E OROOPAI
	0x0036 => 0x06F6, // 6-E OROOPAI
	0x0037 => 0x06F7, // 7-E OROOPAI
	0x0038 => 0x06F8, // 8-E OROOPAI
	0x0039 => 0x06F9, // 9-E OROOPAI
	0x0660 => 0x06F0, // 0-E ARABI
	0x0661 => 0x06F1, // 1-E ARABI
	0x0662 => 0x06F2, // 2-E ARABI
	0x0663 => 0x06F3, // 3-E ARABI
	0x0664 => 0x06F4, // 4-E ARABI
	0x0665 => 0x06F5, // 5-E ARABI
	0x0666 => 0x06F6, // 6-E ARABI
	0x0667 => 0x06F7, // 7-E ARABI
	0x0668 => 0x06F8, // 8-E ARABI
	0x0669 => 0x06F9, // 9-E ARABI
);

$letter_bundle_table = array(
	0x06A9 => 0x0643, // KAF-E ARABI
	0x06CC => 0x064A, // YE-YE ARABIC
);

$arabic_digit_bundle_table = array(
	0x06F0 => 0x0660, // 0-E ARABI
	0x06F1 => 0x0661, // 1-E ARABI
	0x06F2 => 0x0662, // 2-E ARABI
	0x06F3 => 0x0663, // 3-E ARABI
	0x06F4 => 0x0664, // 4-E ARABI
	0x06F5 => 0x0665, // 5-E ARABI
	0x06F6 => 0x0666, // 6-E ARABI
	0x06F7 => 0x0667, // 7-E ARABI
	0x06F8 => 0x0668, // 8-E ARABI
	0x06F9 => 0x0669, // 9-E ARABI
);

$european_digit_bundle_table = array(
	0x06F0 => 0x0030, // 0-E OROOPAI
	0x06F1 => 0x0031, // 1-E OROOPAI
	0x06F2 => 0x0032, // 2-E OROOPAI
	0x06F3 => 0x0033, // 3-E OROOPAI
	0x06F4 => 0x0034, // 4-E OROOPAI
	0x06F5 => 0x0035, // 5-E OROOPAI
	0x06F6 => 0x0036, // 6-E OROOPAI
	0x06F7 => 0x0037, // 7-E OROOPAI
	0x06F8 => 0x0038, // 8-E OROOPAI
	0x06F9 => 0x0039, // 9-E OROOPAI
);

$bundle_map = array(
	$letter_bundle_table,
	$european_digit_bundle_table,
	$letter_bundle_table + $european_digit_bundle_table,
	$arabic_digit_bundle_table,
	$letter_bundle_table + $arabic_digit_bundle_table,
);

$joining_table = array(
		 0x0622 => 2, // AA
		 0x0627 => 2, // ALEF
		 0x0621 => 1, // HAMZE
		 0x0623 => 2, // ALEF-HAMZE
		 0x0628 => 4, // BE
		 0x067E => 4, // PE
		 0x062A => 4, // TE
		 0x062B => 4, // SE
		 0x062C => 4, // JIM
		 0x0686 => 4, // CHE
		 0x062D => 4, // HE (HOTTI)
		 0x062E => 4, // KHE
		 0x062F => 2, // DAL
		 0x0630 => 2, // ZAL
		 0x0631 => 2, // RE
		 0x0632 => 2, // ZE
		 0x0698 => 2, // ZHE
		 0x0633 => 4, // SIN
		 0x0634 => 4, // SHIN
		 0x0635 => 4, // SAD
		 0x0636 => 4, // ZAD
		 0x0637 => 4, // TA
		 0x0638 => 4, // ZA
		 0x0639 => 4, // EYN
		 0x063A => 4, // GHEYN
		 0x0641 => 4, // FE
		 0x0642 => 4, // GHAF
		 0x06A9 => 4, // KAF
		 0x06AF => 4, // GAF
		 0x0644 => 4, // LAM
		 0x0645 => 4, // MIM
		 0x0646 => 4, // NOON
		 0x0648 => 2, // VAV
		 0x0624 => 2, // VAV-HAMZE
		 0x0647 => 4, // HE (HAVVAZ)
		 0x0629 => 2, // TE GERD
		 0x06CC => 4, // YE
		 0x0626 => 4, // YE-HAMZE
		 0x200C => 1, // FASELE-YE MAJAZI
        	 0x200D => 4, // ETTESAL-E MAJAZI
		 LAMALEF => 2,
		 LAMALEFHAMZE => 2,
		 LAMALEFMAD => 2,
);

$joining_name = array(
	0 => 'isol',
	1 => 'fina',
	2 => 'init',
	3 => 'medi',
);

$persian_digits = $digits_perm;

?>
