<?php


$title	= "Punycode Converter";



#
# Functions
#

function remove_ignorables ($a) {
	global $ignorables;
	$isstr = is_string($a);
	if ($isstr) $a = utf8_decompose($a);

	$r = array();
	for ($i = 0, $j = 0; $i < count($a); ++$i) {
		if (in_array($a[$i], $ignorables))
			continue;
		else
			$r[$j++] = $a[$i];
	}

	if ($isstr) $r = utf8_compose($r);
	return $r;
}


function print_table ($unicode_ascii_list) {

	if (!isset($unicode_ascii_list[0]['unicode'])) {
		if (!isset($unicode_ascii_list['ascii'])) {
			$no_ascii = true;
		}
		$unicode_ascii_list = array ($unicode_ascii_list);
	}

	print '
	<table class="listing-table">

		<tr>
			<th>Unicode</th>
			<th>ASCII</th>
		</tr>
	';

	foreach ($unicode_ascii_list as $ua) {
		print "
		<tr class=\"listing-row-odd\">
			<td style=\"align: center; font-weight: bold; font-size: 14pt;\" class=\"primary-cell\">{$ua['unicode']}</td>
			<td style=\"align: left; font-weight: bold;\">{$ua['ascii']}</td>
		</tr>
		";
	}

	print '
	</table>
	';

}


#
# CGI
#

$DEBUG = false;
#$DEBUG = true;
if ($DEBUG) print "<pre>";

$error = false;

do {
	if (isset($_GET['name'])) {

		#########################
		# Back

		print '
		<p>
		  <a class="button-like" href="?">&lt; Back</a>
		</p>
		';


		#########################
		# Query

		$name = trim($_GET['name']);
		#if ($DEBUG) { print "trim: "; var_dump ($name); }

		print '<h2>Query</h2>
		<table class="listing-table horiz-listing-table">

			<tr class="listing-row-odd">
				<th><label for="name">Domain:</label></th>
				<td><b style="align: center; font-weight: bold; font-size: 14pt;">'.htmlentities($name, ENT_COMPAT, 'UTF-8').'</b></td>
			</tr>

		</table>
		';


		#########################
		# Type check

		mb_regex_encoding("utf-8");

		$p_i_label	= "[\w‌‍-]+";
		$p_label	= "^$p_i_label$";
		$p_i_domain	= "$p_i_label(\.$p_i_label)*";
		$p_domain	= "^$p_i_domain$";

		if (!mb_ereg($p_domain, $name)) {
			$error = "Syntax error";
			unset ($_GET['name']);
			break;
		}


		#########################
		# Unicode

		require_once '../inc/functions_idna.php';
		global $g_idna_conv;

		$labels = array();

		foreach (explode ('.', $name) as $l) {
			$u = $g_idna_conv->decode ($l);
			if ($u) {
				$labels[] = $u;
			}
			else {
				$labels[] = $l;
			}
		}

		$unicode = implode ('.', $labels);
		$unicode = remove_ignorables ($unicode);

		$g_idna_conv->_error = null;
		if ($DEBUG) { print "unicode: "; var_dump ($unicode); }


		#########################
		# ASCII

		$ascii   = $g_idna_conv->encode ($unicode);

		if ($g_idna_conv->_error or $ascii == false) {
			if ($g_idna_conv->_error) {
				$error = $g_idna_conv->_error;
			}
			unset ($_GET['name']);
			break;
		}

		if ($DEBUG) { print "ascii: "; var_dump ($ascii); }


		#########################
		# Original

		$original = array (
			'unicode' => $unicode,
			'ascii'   => $ascii,
		);

		print '
		<h2>Requested domain</h2>

		<p>The ignorable characters have been removed.
		(<a href="http://www.nic.ir/Allowable_Characters_dot-iran#Table_2">Allowable Characters, Table 2</a>)
		</p>
		';

		print_table ($original);


		#########################
		# Persian name

		$persian = array (
			'unicode' => persian_canonize ($unicode),
			'ascii'   => $g_idna_conv->encode (persian_canonize ($unicode)),
		);
		#if ($DEBUG) var_dump ($persian);

		print '
		<h2>Persian domain</h2>

		<p>Non-Persian characters have been replaced by Persian ones.
		(<a href="http://www.nic.ir/Allowable_Characters_dot-iran#Table_3">Allowable Characters, Table 3</a>)
		</p>
		';

		print_table ($persian);


		#########################
		# Bundle

		$bundle_list = array();
		foreach (make_bundle ($persian['unicode']) as $variant) {
			#if ($DEBUG) var_dump ($variant);
			$bundle_list[] = array (
				'unicode' => $variant,
				'ascii'   => $g_idna_conv->encode ($variant),
			);
		}
		#if ($DEBUG) var_dump ($bundle_list);

		print '
		<h2>Bundle of variants</h2>

		<p>Bundle of variants based on replacable charaters.</p>
		';

		print_table ($bundle_list);


	}
} while (false);

if ($DEBUG) print "</pre>";

#
# /CGI
#


#
# FORM
#

if (!isset($_GET['name'])) {

	if ($error) {
		print '
		<p class="bad-thing">
			<b>Error:</b> '.$error.'.
			<br/>
			<br/>
		</p>
		';
	}

	include '../templates/punycode_form.html';

}

#
# /FORM
#


include '../templates/footer.html';


#
# The End
#
