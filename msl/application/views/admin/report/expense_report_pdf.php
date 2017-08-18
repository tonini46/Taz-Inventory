<?php
$info = $this->session->userdata('business_info');
if(!empty($info->currency))
{
    $currency = $this->session->userdata('currency_code');
    if($currency == 'USD'){
        $currency = '$';
    }
}else
{
    $currency = '$';
}
$base_url = 'http://127.0.0.1:55055/';
?>

<?php
//company logo
if(!empty($info->logo)){
    $logo = $info->logo;
}else{
    $logo = 'img/uploads/Kenya.png';
}


//company details
if(!empty($info->company_name)){
    $company_name = $info->company_name;
}else{
    $company_name = 'Your Company Name';
}
//company phone
if(!empty($info->phone)){
    $company_phone = $info->phone;
}else{
    $company_phone = 'Company Phone';
}
//company email
if(!empty($info->email)){
    $company_email = $info->email;
}else{
    $company_email = 'Company Email';
}
//company address
if(!empty($info->address)){
    $address = $info->address;
}else{
    $address = 'Company Address';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<style>

body {
    position: relative;
    width: 19cm;
    height: 29.7cm;
    margin: 0 auto;
    color: #555555;
    background: #FFFFFF;
    font-family: Arial, sans-serif;
    font-size: 14px;
    font-family: SourceSansPro;
}

header {
    padding: 10px 0;
    margin-bottom: 20px;
    border-bottom: 1px solid #AAAAAA;
}


.clearfix:after {
    content: "";
    display: table;
    clear: both;
}

a {
    color: #0087C3;
    text-decoration: none;
}


#logo {
    _float: left;
    margin-top: 8px;
    display: inline-block;
    _width: 40%;
}

#logo img {
    height: auto;
    width: auto;
}

#company {
    float: right;
    text-align: right;
    display: inline-block;
    width: 60%;
}


#details {
    margin-bottom: 50px;
}

#client {
    padding-left: 6px;
    border-left: 6px solid #0087C3;
    display: inline-block;
    width: 29%;
    float: left;

}

#shipping {
    padding-left: 6px;
    display: inline-block;
    width: 29%;
    float: left;
}

#client .to {
    color: #777777;
}

h2.name {
    font-size: 1.4em;
    font-weight: normal;
    margin: 0;
}

#invoice {
    display: inline-block;
    text-align: right;
    width: 37%;
    float: right;
}

#invoice h1 {
    color: #0087C3;
    font-size: 2.4em;
    line-height: 1em;
    font-weight: normal;
    margin: 0  0 10px 0;
}

#invoice .date {
    font-size: 1.1em;
    color: #777777;
}

table {
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
    margin-bottom: 20px;
}

table th,
table td {
    padding: 0px 5px;
    /*background: #EEEEEE;*/
    text-align: center;
    border-bottom: 1px solid #ccc;
}

table th {
    white-space: nowrap;
    font-weight: normal;
}

table td {
    text-align: right;
}

table td h3{
    color: #000;
    font-size: 1.2em;
    font-weight: normal;
    margin: 0 0 0.2em 0;
}

table .no {
    color: #000;
    font-size: 1.1em;
    /*background: #C4CBC2;*/
}

table .desc {
    text-align: left;
    _font-size: 0px;
}

table .unit {
    /*background: #DDDDDD;*/
}

table .qty {
}

table .total {
    /*background: #DDD;*/
    color: #000;
}


table td.unit,
table td.qty,
table td.total{
    font-size: 1.0em;
}
table td.unit,
table td.qty,
table td.total,
table th.unit,
table th.qty,
table th.total {
    text-align: right;
}

table tbody tr:last-child td {
    border: none;
}

table tfoot td {
    padding: 1px 5px 1px;
    background: #FFFFFF;
    border-bottom: none;
    font-size: 1.2em;
    white-space: nowrap;
    border-top: 1px solid #AAAAAA;
}

table tfoot tr:first-child td {
    border-top: none;
    /*border-bottom: none;*/

}

table  tr:last-child {
    /*border-top: none;*/
    border-bottom: 1px solid #ccc;
}

table  tfoot tr:last-child {
    border-bottom: none;
}

table tfoot tr:last-child td {
    color: #000;
    font-size: 1.2em;
    border-top: 1px solid #ccc;

}

table tfoot tr td:first-child {
    border: none;
}

#thanks{
    font-size: 2em;
    margin-bottom: 30px;
}

#notices{
    padding-left: 6px;
    border-left: 6px solid #0087C3;
}

#notices .notice {
    font-size: 1.2em;
}



/*  SECTIONS  */
.section {
    clear: both;
    padding: 0px;
    margin: 0px;
}

/*  COLUMN SETUP  */
.col {
    display: block;
    float:left;
    margin: 1% 0 1% 1.6%;
}
.col:first-child { margin-left: 0; }

/*  GROUPING  */
.group:before,
.group:after { content:""; display:table; }
.group:after { clear:both;}
.group { zoom:1; /* For IE 6/7 */ }

/*  GRID OF FOUR  */
.span_4_of_4 {
    width: 100%;
}
.span_3_of_4 {
    width: 74.6%;
}
.span_2_of_4 {
    width: 49.2%;
}
.span_1_of_4 {
    width: 23.8%;
}

/*  GO FULL WIDTH BELOW 480 PIXELS */
@media only screen and (max-width: 480px) {
    .col {  margin: 1% 0 1% 0%; }
    .span_1_of_4, .span_2_of_4, .span_3_of_4, .span_4_of_4 { width: 100%; }
}


</style>


</head>
<body>

<header class="clearfix">
    <div id="logo">
        <img src="<?php echo $base_url; ?>asset/img/pdf_logo.jpg" class="img-thumbnail" style="" width="60%"/>
    </div>

</header>

<main class="invoice_report">

    <h4>Expense Report from: <strong><?php echo $start_date ?></strong> to <strong><?php echo $end_date ?></strong></h4>
    <span><b>Country: </b><?php echo country($inchi); ?></span>
    <br/>
    <br/>

    <?php
    $total_cost=0;
    $total_sell=0;
    $total_profit=0;
    ?>
    <table border="0" cellspacing="0" cellpadding="0">
                                        <thead>
                                        <tr style="background-color: #ECECEC">
                                            <th class="no" style="width:30px; text-align:left;">#</th>
                                            <th class="desc">Expense Code</th>
                                            <th class="desc">Expense Title</th>
                                            <th class="desc text-right">Expense Note</th>
                                            <th class="total text-right">Expense Date</th>
                                            <th class="total text-right ">TOTAL</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $k =1?>
                                    <?php if (!empty($expense_details)): foreach ($expense_details as $v_expense) : ?>
                                            <tr>
                                                <td class="no"  style="text-align:left;"><?php echo $k ?></td>
                                                <td class="desc"><?php
                                                    if(!empty($v_expense->expense_code))  {
                                                        echo $v_expense->expense_code;
                                                    }
                                                    ?></td>
                                                <td class="desc"><?php echo $v_expense->expense_name ?></td>
                                                <td class="desc"><?php echo $v_expense->expense_note ?></td>
                                                <td class="total"><?php echo $v_expense->expense_date  ?></td>
                                                <td class="total"><?php echo number_format(currency($v_expense->expense_amount,2)) ?></td>
                                            </tr>
                                        <?php $k++?>


                                        <?php
                                            endforeach;
                                            endif;
                                        ?>


                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="3"></td>
                                            <td colspan="2">Grand Total</td>
                                            <td><?php echo $currency.' '.number_format(currency( $grand_total[0]->total,2)) ?></td>
                                        </tr>
                                        </tfoot>


                                    </table>


</main>
<hr/>
<footer style="padding-top:10px; text-align:center;">
    <strong><?php echo $company_name?></strong>&nbsp;&nbsp;&nbsp;<?php echo $address ?>
</footer>




</body>
</html>