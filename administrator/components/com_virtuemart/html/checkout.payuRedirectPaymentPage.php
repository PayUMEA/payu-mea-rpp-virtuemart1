<?php

require_once(  CLASSPATH ."payment/ps_payuRedirectPaymentPage.cfg.php");

/*//Uncomment to check request values
if (is_array($_REQUEST) && (sizeof($_REQUEST) > 0)) {
	reset($_REQUEST);
	while (list($key, $value) = each($_REQUEST)) {
		$$key = $value;
     echo $key . "-" . $value . "<br>";
	}
}*/


//Check for request variables
if (is_array($_REQUEST) && (sizeof($_REQUEST) > 0)) {

    //Orderid must be set to update order status
    if( !isset( $_REQUEST["orderid"] ) || empty( $_REQUEST["orderid"] )){
        ?>
        <span class="message"><?php echo $VM_LANG->_('PHPSHOP_PAYMENT_ERROR') ?></span>
        <?php
    }else {
        
        $order_number = isset($_REQUEST['orderid'])?$_REQUEST['orderid']:0;
        $qv = "SELECT order_id, order_total, order_number FROM #__{vm}_orders ";
        $qv .= "WHERE order_id='".$order_number."'";
        $dbbt = new ps_DB;
        $dbbt->query($qv);
        $dbbt->next_record();
        $d['order_id'] = $order_number;
        $order_total = $dbbt->f("order_total");
        
        if(isset($_GET['cancelled']) && (isset($_GET['payUReference']) && (!empty($_GET['payUReference']))) ) {
                $paymentCancelled = true;
        }
        else {        
            
            //Doign PayU check        
            $errorMessage = "No PayU Reference Specified";    
            if (isset($_GET['PayUReference']) && (!empty($_GET['PayUReference']))) {
            
                $errorMessage = "Invalid Gateway Reponse";    

                try {
                    //Creating get transaction soap data array
                    $getTransactionSoapDataArray = array();                
                    $getTransactionSoapDataArray['AdditionalInformation']['payUReference'] = $_GET['PayUReference'];

                    $constructorArray = array();        
                    $constructorArray['safeKey'] = payuRedirectPaymentPage_safekey;
                    $constructorArray['username'] = payuRedirectPaymentPage_username;
                    $constructorArray['password'] = payuRedirectPaymentPage_password;                
                    $constructorArray['extendedDebugEnable'] = true;
                    $checkLiveTransaction = false;
                    if(strtolower(payuRedirectPaymentPage_systemToCall) == 'production') {
                        $constructorArray['production'] = true;
                        $checkLiveTransaction = true;
                    }        

                    $payuRppInstance = new PayuRedirectPaymentPage($constructorArray);
                    $getTransactionResponse = $payuRppInstance->doGetTransactionSoapCall($getTransactionSoapDataArray); 
                    
                    //Checking the response from the SOAP call to see if successfull
                    if(isset($getTransactionResponse['soapResponse']['successful']) && ($getTransactionResponse['soapResponse']['successful']  === true)) {
                        if(isset($getTransactionResponse['soapResponse']['transactionType']) && (strtolower($getTransactionResponse['soapResponse']['transactionType']) == 'payment') ) {
                            if(isset($getTransactionResponse['soapResponse']['transactionState']) && (strtolower($getTransactionResponse['soapResponse']['transactionState']) == 'successful') ) {
                                if(isset($getTransactionResponse['soapResponse']['resultCode']) && ($getTransactionResponse['soapResponse']['resultCode']) == '00') {                        
                                    if( isset($getTransactionResponse['soapResponse']['merchantReference']) && !empty($getTransactionResponse['soapResponse']['merchantReference']) ) {                            
                                        $MerchantReferenceCallBack = $getTransactionResponse['soapResponse']['merchantReference'];
                                        $gatewayReference = $getTransactionResponse['soapResponse']['paymentMethodsUsed']['gatewayReference'];
                                        $paymentSuccess = true;
                                        $returnValue = true;
                                    }
                                    else {
                                        $errorMessage = "Invalid Merchant reference in response";
                                    }
                                }
                                else {
                                    $errorMessage = "Invalid result code from Payment Gateway ";
                                }
                            }                        
                        }
                        else {
                            $errorMessage = "Invalid transaction type from Payment Gateway ";
                        }
                    }

                    if(!isset($paymentSuccess)) {
                        if(isset($getTransactionResponse['soapResponse']['displayMessage'])) {
                            $errorMessage = $getTransactionResponse['soapResponse']['displayMessage'];
                        }
                    }
                }
                catch(Exception $e) {
                    $errorMessage = $e->getMessage();            
                }
            }
        }
        
        if(isset($paymentSuccess)) {
            ?> 
                <img src="<?php echo IMAGEURL ?>ps_image/button_ok.png" align="center" alt="Success" border="0" />
                <h2><?php echo $VM_LANG->_('PHPSHOP_PAYMENT_TRANSACTION_SUCCESS') ?></h2>
            <?php            
            $message = 'Payment Successful:'."\r\n";
            $message .= 'Order Id: ' . $order_number . "\r\n";
            $message .= 'PayU Reference: ' . $_GET['PayUReference'] . "\r\n";
            $message .= 'Sent Merchant Reference: ' . $MerchantReferenceCallBack . "\r\n";
            $message .= 'Gateway Reference: ' . $gatewayReference . "\r\n";

            $d['order_status'] = payuRedirectPaymentPage_successorder_status;
            $d['notify_customer'] = "Y";
            $d['include_comment'] = "Y";
            $d['order_comment'] = $message;
            require_once ( CLASSPATH . 'ps_order.php' );
            $ps_order= new ps_order;
            $ps_order->order_status_update($d);
            /*
            $db = new ps_DB;
            $dbv = new ps_DB;
            $q = "SELECT vendor_name,contact_email FROM #__{vm}_vendor ";
            $q .= "WHERE vendor_id='".$_SESSION['ps_vendor_id']."'";
            $dbv->query($q);
            $dbv->next_record();         
            $result2 = vmMail( $dbv->f("contact_email"),  $dbv->f("vendor_name"),
            $dbv->f("contact_email"), 'Order '. $order_number . ' Paid via PayU', $order_number . ' Paid via PayU', '' );
            */
        }
        elseif(isset($paymentCancelled)) {
            ?>
            <img src="<?php echo IMAGEURL ?>ps_image/button_cancel.png" align="center" alt="Failure" border="0" />
            <h2>Payment Cancelled</h2>
            <?php
            $d['order_status'] = payuRedirectPaymentPage_failorder_status;
            $d['include_comment'] = "Y"; 
            $d['notify_customer'] = "Y";
            $d['order_comment'] = "Payment cancelled by customer on PayU payment interface";
            require_once ( CLASSPATH . 'ps_order.php' );
            $ps_order= new ps_order;
            $ps_order->order_status_update($d);
        }         
        else {            
            ?>
            <img src="<?php echo IMAGEURL ?>ps_image/button_cancel.png" align="center" alt="Failure" border="0" />
            <h2><?php echo $VM_LANG->_('PHPSHOP_PAYMENT_ERROR') ?></h2>
            <?php
            $d['order_status'] = payuRedirectPaymentPage_failorder_status;
            $d['include_comment'] = "Y";            
            $d['order_comment'] = "Payment Error: $errorMessage";            
            require_once ( CLASSPATH . 'ps_order.php' );
            $ps_order= new ps_order;
            $ps_order->order_status_update($d);
        }
    }
?>
<br/>
<p><a href="<?php @$sess->purl( SECUREURL."index.php?option=com_virtuemart&page=account.order_details&order_id=$order_id" ) ?>">
<?php echo $VM_LANG->_('PHPSHOP_ORDER_LINK') ?></a>
</p>
<?php 
} ?>
