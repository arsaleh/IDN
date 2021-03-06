<?php


$title	= "IRNIC Tools Server";


#
# HTTP Header
#

foreach (file('../templates/header_0.http') as $l) { header ($l); }

print "\n";


#
# HTML Header
#

include '../templates/header_1.html';

print "<title>$title - IRNIC</title>\n";


#
# HTML Body
#

include '../templates/header_2.html';

print "<h1>$title</h1>\n";


#
# CGI
#

?>


<!-- *** -->
<h2>
<a href="DNSSEC_Zone_Signing">DNSSEC Zone Signing</a>
</h2>

<p>
    You may create a signed zone file via this page,
    providing the plain zone file and your private keys.
</p>

<ul>

  <li>
    For general information about the DNSSEC technology
    and the IRNIC testbed for DNSSEC please refer to
    <a href="http://www.nic.ir/DNSSEC">www.nic.ir/DNSSEC</a>.
  </li>

  <li>
    You can find the technical manual about DNSSEC
    and how to generate KSK and ZSK keys on UNIX systems using BIND on
    <a href="http://www.nic.ir/applications/IRNIC_DNSSEC_Tech_Manual.pdf">IRNIC DNSSEC Tech Manual (PDF)</a>
    manual.
  </li>

</ul>

<p>
</p>

<ul lang="fa" class="lang_fa">

  <li>
    برای کسب اطلاعات اولیه در مورد فناوری DNSSEC
    و بستر آزمایشی ایرنیک، لطفاً به
    <a href="http://www.nic.ir/DNSSEC">www.nic.ir/DNSSEC</a>
    مراجعه نمایید.
  </li>

  <li>
    راهنمای فنی در مورد DNSSEC
    و چگونگی تولید کلیدهای KSK و ZSK را می‌توانید در
    <a href="http://www.nic.ir/applications/IRNIC_DNSSEC_Tech_Manual.pdf">IRNIC DNSSEC Tech Manual (PDF)‎</a>
    بیابید.
  </li>

</ul>


<!-- *** -->
<h2>
<a href="Punycode_Converter"> Punycode Converter </a>
</h2>

<p>
    Converts between Unicode form and Punycode (ACE) form of Internationalized Domains Names.
</p>


<!-- *** -->
<h2>
<a href="IDN_Config_Generator"> IDN Config Generator </a>
</h2>

<p>
    Generates the Name Server configuration of the bundle of domain names
    allocated to a registered Persian domain name.
</p>


<!-- *** -->
<h2>
<a href="Query_Whois_Server"> Query Whois Server </a>
</h2>

<p>
Use the following form to perform a query exclusively on the 
<a href="http://www.nic.ir/">IRNIC</a> domain database.
Not only can you determine whether a domain name you desire is already
in use, but you can find contacts names, e-mail addresses, postal 
addresses, and telephone numbers.
</p>


<!-- *** -->
<h2>
<a href="Query_DNS_Server"> Query DNS Server  </a>
</h2>

<p>
Use this page to perform a query on the primary Domain Name Server of
<a href="http://www.nic.ir/">IRNIC</a>.
</p>


<?php

include '../templates/footer.html';


#
# The End
#
