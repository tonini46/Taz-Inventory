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
?>
<table class="table table-bordered table-hover" id="dataTables-example">
    <thead ><!-- Table head -->
    <tr>
        <th class="active">Sl</th>
        <th class="active col-sm-5">Product</th>
        <th class="active ">Qty</th>
        <th class="active ">Unit Price</th>
        <th class="active">Total</th>
        <th class="active">Action</th>

    </tr>
    </thead><!-- / Table head -->
    <tbody><!-- / Table body -->
    <?php $cart = $this->cart->contents() ;
//    echo '<pre>';
//    print_r($cart);


    ?>
    <?php $counter =1 ; ?>
    <?php if (!empty($cart)): foreach ($cart as $item) : ?>

        <tr class="custom-tr">
            <td class="vertical-td">
                <?php echo  $counter ?>
            </td>
            <td class="vertical-td"><?php echo $item['name'] ?></td>
            <td class="vertical-td">

                <input  type="text" name="qty" value="<?php echo $item['qty'] ?>" onblur ="purchase(this);" id="<?php echo 'qty'.$item['rowid'] ?>" class="form-control">

            </td>
            <td class="vertical-td">

                <input  type="text" name="price" value="<?php echo currency($item['price']) ?>"  onblur ="purchase(this);" id="<?php echo 'pri'.$item['rowid'] ?>" class="form-control">

            </td>
            <td class="vertical-td"><?php echo  currency($item['subtotal']) ?></td>

            <td class="vertical-td">
                <?php echo btn_delete('admin/purchase/delete_cart_item/' . $item['rowid']); ?>
            </td>

        </tr>


        <?php
        $counter++;
    endforeach;
        ?><!--get all sub category if not this empty-->
        <tr>
            <td colspan="3" class="text-right active">
                <strong>Grand Total: </strong>
            </td>
            <td colspan="3" class="text-left active">
               <strong> <?php echo $currency.' '.$this->cart->format_number(currency($this->cart->total())); ?></strong>
            </td>
        </tr>
        <tr>
            <td colspan="3" class="text-right active">
                <strong>Country </strong>
            </td>
            <td colspan="3" class="text-left active">
                <select name="country_id" class="form-control col-sm-5">
                        <option value="">Select Country</option>
                            <?php 
                            foreach ($countries as $key) {?>
                                <option value="<?php echo $key->country_id; ?>" <?php
                            if(!empty($customer->country_id)){
                            echo $customer->country_id==$key->country_id ?'selected':'';
                            } ?>><?php echo $key->name; ?></option>
                            <?php } ?>
                </select>
            </td>
        </tr>

        <tr>
            <td colspan="3" class="text-right active">
                <strong>Purchase Reference</strong>
            </td>
            <td colspan="3" class="text-left active">
                <input type="text" name="purchase_ref" class="form-control">
            </td>
        </tr>

        <tr>
            <td colspan="3" class="text-right active">
                <strong>Payment Method </strong>
            </td>
            <td colspan="3" class="text-left active">
                <select name="payment_method" class="form-control" id="payment_type">
                    <option value="cash">Cash Payment</option>
                    <option value="cheque">Cheque Payment</option>
                    <option value="card">Credit Card</option>
                </select>
            </td>
        </tr>
       <tr class="" id="payment" style="display:none">
           <td colspan="3" class="text-right active">
               <strong>Payment Reference(cheque/card)</strong>
           </td>
           <td colspan="3" class="text-left active">
              <input type="text" name="payment_ref" class="form-control" >
           </td>
       </tr>

        <tr>
            <td colspan="3" class="text-right active">

            </td>
            <td colspan="3" class="text-left active">
                <button type="submit" id="btn_purchase" class="btn bg-navy btn-block " type="submit">Purchase
                </button>
            </td>
        </tr>

    <?php else : ?> <!--get error message if this empty-->
        <td colspan="6">
            <strong>There is no record for display</strong>
        </td><!--/ get error message if this empty-->
    <?php endif; ?>
    </tbody><!-- / Table body -->
</table> <!-- / Table -->
<script src="<?php echo base_url(); ?>asset/js/ajax.js"></script>