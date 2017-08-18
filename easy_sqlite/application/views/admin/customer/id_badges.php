<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN"
	"http://www.w3.org/TR/html4/loose.dtd">
<html>
<style>
 table.main { }
 tr.row {}
 td.cell {}
 div.block {}
 div.paragraph {}
 .font0 { font:8pt Arial, sans-serif; }
 .font1 { font:9pt Arial, sans-serif; }
 .font2 { font:10pt Arial, sans-serif; }
 .font3 { font:11pt Arial, sans-serif; }
 .font4 { font:12pt Arial, sans-serif; }
 .font5 { font:10pt Courier New, monospace; }
</style>
<body style=" width:250px; height:500px; text-align:center">
<table style="width:250px;  border:#000 dotted 1px; padding:5px;">
<tr><td style="text-align:center;padding:0pt;">
	<img src="http://localhost/inventory/easy_inventory/asset/img/logo.png" style="width:49pt;"/>
<p><span class="font3" style="font-weight:bold;">MEASUREMENT SYSTEMS LIMITED</span></p>
<p style="text-align:center;padding:0pt;"><span class="font2">CUSTOMER ID<br>REF: <?php echo '#'.$customer->customer_code ?></span></p>
</td>
</tr>
<tr>
<td style="text-align:left;">
<span class="font1" style="font-weight:bold;"><?php echo strtoupper($customer->customer_name) ?> </span>
<br><span class="font1">COUNTRY: </span><span class="font1" style="font-weight:bold;"><?php echo strtoupper(country($customer->country_id)) ?></span>
<br><br><span class="font1">is hereby a licensed Measurement Systems Customer. Please have this Customer ID when shopping at our stores.</span>
<h5 style="text-align:center;padding:10pt 0pt 0pt 0pt; border-top:#000 dotted 1px;">
<img src="http://localhost/inventory/easy_inventory/img/customer/barcode/<?php echo $customer->customer_code; ?>.jpg">
</h5>
<p style="text-align:center;"><span class="font0">Call: +254 735 445 622 | +254 728 909 641</span></p>
</tr>
</table>
</body>
</html>