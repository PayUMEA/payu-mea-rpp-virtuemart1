<?php
if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
class ps_payuRedirectPaymentPage
{
    var $classname = 'ps_payuRedirectPaymentPage';
    var $payment_code = 'payuRedirect';

    /**
     * show_configuration
     *
     * Show all configuration parameters for this payment method
     *
     * @returns boolean False when the Payment method has no configration
     */
    function show_configuration()
	{
		// Variable initialization
        global $VM_LANG;
        $db = new ps_DB();

        // Read current Configuration
        include_once( CLASSPATH .'payment/'. $this->classname .'.cfg.php' );

        require_once('library.payu/inc.joomla/config.virtuemart.php');
        
        $textBoxReadonly = '';
        
        $app =& JFactory::getApplication();
         
        
        $payuOptions = array();        
        $payuOptions['payuRedirectPaymentPage_safekey'] = '';
        $payuOptions['payuRedirectPaymentPage_username'] = '';
        $payuOptions['payuRedirectPaymentPage_password'] = '';
        
        $payuOptions['payuRedirectPaymentPage_payTitle'] = 'Credit Card (Processed securely by PayU)';
        $payuOptions['payuRedirectPaymentPage_transactionType'] = 'PAYMENT';
        $payuOptions['payuRedirectPaymentPage_paymentMethod'] = 'CREDITCARD';
        $payuOptions['payuRedirectPaymentPage_selectedCurrency'] = 'ZAR';
        $payuOptions['payuRedirectPaymentPage_defaultOrderNumberPrepend'] = $app->getCfg('sitename')." Order number";
        $payuOptions['payuRedirectPaymentPage_returnURL'] = SECUREURL . "index.php?option=com_virtuemart&orderid=&page=checkout.payuRedirectPaymentPage";
        $payuOptions['payuRedirectPaymentPage_cancelURL'] = SECUREURL . "index.php?option=com_virtuemart&orderid=&page=checkout.payuRedirectPaymentPage";
        
        $payuOptions['payuRedirectPaymentPage_successorder_status'] = 'C';
        $payuOptions['payuRedirectPaymentPage_preorder_status'] = 'P';
        $payuOptions['payuRedirectPaymentPage_failorder_status'] = 'X';
        
        $payuOptions['payuRedirectPaymentPage_safekey_production'] = "";
        $payuOptions['payuRedirectPaymentPage_username_production'] = "";
        $payuOptions['payuRedirectPaymentPage_password_production'] = "";
        
        
        
        if(defined('payuRedirectPaymentPage_safekey')) {
            $payuOptions['payuRedirectPaymentPage_safekey'] = payuRedirectPaymentPage_safekey;
        }
        if(defined('payuRedirectPaymentPage_username')) {
            $payuOptions['payuRedirectPaymentPage_username'] = payuRedirectPaymentPage_username;
        }        
        if(defined('payuRedirectPaymentPage_password')) {
            $payuOptions['payuRedirectPaymentPage_password'] = payuRedirectPaymentPage_password;
        }
        
        if(defined('payuRedirectPaymentPage_transactionType')) {
            $payuOptions['payuRedirectPaymentPage_transactionType'] = payuRedirectPaymentPage_transactionType;
        }
        if(defined('payuRedirectPaymentPage_paymentMethod')) {
            $payuOptions['payuRedirectPaymentPage_paymentMethod'] = payuRedirectPaymentPage_paymentMethod;
        }
        if(defined('payuRedirectPaymentPage_selectedCurrency')) {
            $payuOptions['payuRedirectPaymentPage_selectedCurrency'] = payuRedirectPaymentPage_selectedCurrency;
        }
        
        if(defined('payuRedirectPaymentPage_defaultOrderNumberPrepend') && (payuRedirectPaymentPage_defaultOrderNumberPrepend != '') ) {        
            $payuOptions['payuRedirectPaymentPage_defaultOrderNumberPrepend'] = payuRedirectPaymentPage_defaultOrderNumberPrepend;
        }
        
        if(defined('payuRedirectPaymentPage_returnURL') && (payuRedirectPaymentPage_returnURL != '') ) {
            $payuOptions['payuRedirectPaymentPage_returnURL'] = payuRedirectPaymentPage_returnURL;
        }
        
        if(defined('payuRedirectPaymentPage_cancelURL') && (payuRedirectPaymentPage_cancelURL != '') ) {
            $payuOptions['payuRedirectPaymentPage_cancelURL'] = payuRedirectPaymentPage_cancelURL;
        }
        
        if(defined('payuRedirectPaymentPage_successorder_status') && (payuRedirectPaymentPage_successorder_status != '') ) {        
            $payuOptions['payuRedirectPaymentPage_successorder_status'] = payuRedirectPaymentPage_successorder_status;
        }
        
        if(defined('payuRedirectPaymentPage_preorder_status') && (payuRedirectPaymentPage_preorder_status != '') ) {        
            $payuOptions['payuRedirectPaymentPage_preorder_status'] = payuRedirectPaymentPage_preorder_status;
        }
        
        if(defined('payuRedirectPaymentPage_failorder_status') && (payuRedirectPaymentPage_failorder_status != '') ) {
            $payuOptions['payuRedirectPaymentPage_failorder_status'] = payuRedirectPaymentPage_failorder_status;
        }
        
        if(defined('payuRedirectPaymentPage_safekey_production') && (payuRedirectPaymentPage_safekey_production != '') ) {        
            $payuOptions['payuRedirectPaymentPage_safekey_production'] = payuRedirectPaymentPage_safekey_production;
        }
        
        if(defined('payuRedirectPaymentPage_username_production') && (payuRedirectPaymentPage_username_production != '') ) {
            $payuOptions['payuRedirectPaymentPage_username_production'] = payuRedirectPaymentPage_username_production;
        }
        
        if(defined('payuRedirectPaymentPage_password_production') && (payuRedirectPaymentPage_password_production != '') ) {
            $payuOptions['payuRedirectPaymentPage_password_production'] = payuRedirectPaymentPage_password_production;
        }
        
        if(!defined('payuRedirectPaymentPage_systemToCall')) {
            define( 'payuRedirectPaymentPage_systemToCall', 'staging' );
        }
        
        if(defined('payuRedirectPaymentPage_systemToCall') && (payuRedirectPaymentPage_systemToCall == "staging") ) {
            $payuOptions['payuRedirectPaymentPage_safekey'] = $payuVirtueMartConfig['PayuRedirectPaymentPage']['payuRedirectPaymentPage_safekey'];
            $payuOptions['payuRedirectPaymentPage_username'] = $payuVirtueMartConfig['PayuRedirectPaymentPage']['payuRedirectPaymentPage_username'];
            $payuOptions['payuRedirectPaymentPage_password'] = $payuVirtueMartConfig['PayuRedirectPaymentPage']['payuRedirectPaymentPage_password'];
            $textBoxReadonly = 'readonly="readonly"';
        }
        ?>

        <input type="hidden" name="payuRedirectPaymentPage_safekey_production" value="<?php echo $payuOptions['payuRedirectPaymentPage_safekey_production']; ?>" />
        <input type="hidden" name="payuRedirectPaymentPage_username_production" value="<?php echo $payuOptions['payuRedirectPaymentPage_username_production']; ?>" />
        <input type="hidden" name="payuRedirectPaymentPage_password_production" value="<?php echo $payuOptions['payuRedirectPaymentPage_password_production']; ?>" />        
        

        <input type="hidden" id="payuRedirect_safekey_production_id" name="_hidden_payuRedirect_safekey" value="<?php echo $payuOptions['payuRedirectPaymentPage_safekey_production']; ?>" />
        <input type="hidden" id="payuRedirect_safekey_staging_id" name="_hidden_payuRedirect_safekey_staging" value="<?php echo $payuVirtueMartConfig['PayuRedirectPaymentPage']['payuRedirectPaymentPage_safekey']; ?>" />

        <input type="hidden" id="payuRedirect_username_production_id" name="_hidden_payuRedirect_username_production" value="<?php echo $payuOptions['payuRedirectPaymentPage_username_production']; ?>" />
        <input type="hidden" id="payuRedirect_username_staging_id" name="_hidden_payuRedirect_username_staging" value="<?php echo $payuVirtueMartConfig['PayuRedirectPaymentPage']['payuRedirectPaymentPage_username']; ?>" />

        <input type="hidden" id="payuRedirect_password_production_id"name="_hidden_payuRedirect_password_production" value="<?php echo $payuOptions['payuRedirectPaymentPage_password_production']; ?>" />
        <input type="hidden" id="payuRedirect_password_staging_id" name="_hidden_payuRedirect_password_staging" value="<?php echo $payuVirtueMartConfig['PayuRedirectPaymentPage']['payuRedirectPaymentPage_password']; ?>" />

        <script type="text/javascript">
            function whichSystemToCallOnChange(nameOfSystem) {
                var nameOfSystemLower = nameOfSystem.toLowerCase();
                document.getElementById("payuRedirect_safekey_id").value = document.getElementById("payuRedirect_safekey_"+nameOfSystemLower+"_id").value;
                document.getElementById("payuRedirect_username_id").value = document.getElementById("payuRedirect_username_"+nameOfSystemLower+"_id").value;
                document.getElementById("payuRedirect_password_id").value = document.getElementById("payuRedirect_password_"+nameOfSystemLower+"_id").value;

                if(nameOfSystemLower == "staging") {
                    document.getElementById("payuRedirect_safekey_id").readOnly = true;
                    document.getElementById("payuRedirect_username_id").readOnly = true;
                    document.getElementById("payuRedirect_password_id").readOnly = true;
                }                        
                else {
                    document.getElementById("payuRedirect_safekey_id").readOnly = false;
                    document.getElementById("payuRedirect_username_id").readOnly = false;
                    document.getElementById("payuRedirect_password_id").readOnly = false;
                }
            }
        </script>
                

        <table class="adminform">            
            
            <tr class="row1">
            	<td><strong>Production/Staging</strong></td>
                <td>
                    <select name="payuRedirectPaymentPage_systemToCall" class="inputbox" onChange="whichSystemToCallOnChange(this.options[selectedIndex].value);" >
                        <option value="staging" <?php if(payuRedirectPaymentPage_systemToCall == 'staging') { echo 'selected'; } ?> >Staging</option>
                        <option value="production" <?php if(payuRedirectPaymentPage_systemToCall == 'production') { echo 'selected'; } ?>>Production</option>
                    </select>
                </td>
                <td>Dropdown indicating which PayU environment to use for transactions (Staging: used testing and integration, Production: used for live/real transactions)</td>
            </tr>
            
            <tr class="row1">
            	<td><strong>Safe Key</strong></td>
                <td><input type="text" id="payuRedirect_safekey_id" name="payuRedirectPaymentPage_safekey" class="inputbox" style="width: 180px;" value="<?php  echo $payuOptions['payuRedirectPaymentPage_safekey']; ?>" <?php echo $textBoxReadonly; ?> ></td>
                <td>SafeKey in {XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX} format: (Production value is provided by PayU, Staging value is entered already and can't be updated)</td>
            </tr>
            
            <tr class="row1">
            	<td><strong>Soap Username</strong></td>
                <td><input type="text" id="payuRedirect_username_id" name="payuRedirectPaymentPage_username" class="inputbox" style="width: 180px;" value="<?php  echo $payuOptions['payuRedirectPaymentPage_username']; ?>" <?php echo $textBoxReadonly; ?>></td>
                <td>SOAP API Username used in transactions (Production value is provided by PayU, Staging value is entered already and can't be updated)</td>
            </tr>

            <tr class="row1">
            	<td><strong>Soap Password</strong></td>
                <td><input type="text" id="payuRedirect_password_id" name="payuRedirectPaymentPage_password" class="inputbox" style="width: 180px;" value="<?php  echo $payuOptions['payuRedirectPaymentPage_password']; ?>" <?php echo $textBoxReadonly; ?>></td>
                <td>SOAP API Password used in transactions (Production value is provided by PayU, Staging value is entered already and can't be updated)</td>
            </tr>
                        
            <tr class="row1">
            	<td><strong>Transaction Type</strong></td>
                <td><input type="text" name="payuRedirectPaymentPage_transactionType" class="inputbox" style="width: 180px;" value="<?php  echo $payuOptions['payuRedirectPaymentPage_transactionType']; ?>"  <?php echo $textBoxReadonly; ?>></td>
                <td>Transaction type used for transactions (Only the 'PAYMENT' transaction type is currently supported in the Virtuemart plugin/extension and value cannot be altered)</td>
            </tr>

            <tr class="row1">
            	<td><strong>Payment Methods</strong></td>
                <td><input type="text" name="payuRedirectPaymentPage_paymentMethod" class="inputbox" style="width: 180px;" value="<?php  echo $payuOptions['payuRedirectPaymentPage_paymentMethod']; ?>"  <?php echo $textBoxReadonly; ?>></td>
                <td>Username used for transactions (Only the 'CREDITCARD' payment method is currently supported in the OpenCart plugin/extension and value cannot be altered)</td>
            </tr>

            <tr class="row1">
            	<td><strong>Billing Currency</strong></td>
                <td><input type="text" name="payuRedirectPaymentPage_selectedCurrency" class="inputbox" style="width: 180px;" value="<?php  echo $payuOptions['payuRedirectPaymentPage_selectedCurrency']; ?>"  <?php echo $textBoxReadonly; ?>></td>
                <td>The currency used for transactions (Only the 'ZAR' currency is currently supported in the OpenCart plugin/extension and value cannot be altered)</td>
            </tr>

            <tr class="row1">
            	<td><strong>PayU Invoice description Prepend</strong></td>
                <td><input type="text" name="payuRedirectPaymentPage_defaultOrderNumberPrepend" class="inputbox" style="width: 180px;" value="<?php  echo $payuOptions['payuRedirectPaymentPage_defaultOrderNumberPrepend']; ?>"></td>
                <td>This value is added before theorder number and sent to PayU with transactions and will display in invoices</td>
            </tr>
            
            <tr class="row1">
            	<td><strong>Return URL</strong></td>
                <td><input type="text" name="payuRedirectPaymentPage_returnURL" class="inputbox" style="width: 180px;" value="<?php  echo $payuOptions['payuRedirectPaymentPage_returnURL']; ?>"></td>
                <td>This is the URL the browser will be redirected to once a payment has been made on the PayU payments page</td>
            </tr>

            <tr class="row1">
            	<td><strong>Cancel URL</strong></td>
                <td><input type="text" name="payuRedirectPaymentPage_cancelURL" class="inputbox" style="width: 180px;" value="<?php  echo $payuOptions['payuRedirectPaymentPage_cancelURL']; ?>"></td>
                <td>This is the URL the browser will be redirected if a user cancels a payment on the PayU payments page</td>
            </tr>
            
            
            <?php            
                $q = "SELECT order_status_name,order_status_code FROM #__{vm}_order_status ORDER BY list_order";
                $db->query($q);
                $order_status_code = Array();
                $order_status_name = Array();

                while( $db->next_record() )
                {
                    $order_status_code[] = $db->f( 'order_status_code' );
                    $order_status_name[] = $db->f( 'order_status_name' );
                }            
            ?>
        
            <tr class="row0">
                <td><strong>Order Status for Successful Payments</strong></td>
                <td>
                    <select name="payuRedirectPaymentPage_successorder_status" class="inputbox" >
                    <?php
                    for( $i = 0; $i < sizeof( $order_status_code ); $i++ )
    				{
    					echo "<option value=\"" . $order_status_code[$i];
    					if ($payuOptions['payuRedirectPaymentPage_successorder_status'] == $order_status_code[$i])
    						echo "\" selected=\"selected\">";
    					else
    						echo "\">";
    					echo $order_status_name[$i] . "</option>\n";
                    }
    				?>
    				</select>
                </td>
                <td>Status to use when payment has been confirmed</td>
            </tr>
            <!-- Order Status - Pending -->
            <tr class="row1">
                <td><strong>Order Status for Pending Payments</strong></td>
                <td>
                    <select name="payuRedirectPaymentPage_preorder_status" class="inputbox" >
                    <?php
                    for( $i = 0; $i < sizeof( $order_status_code ); $i++ )
    				{
    					echo "<option value=\"" . $order_status_code[$i];
    					if ($payuOptions['payuRedirectPaymentPage_preorder_status'] == $order_status_code[$i])
    						echo "\" selected=\"selected\">";
    					else
    						echo "\">";
    					echo $order_status_name[$i] . "</option>\n";
                    }
    				?>
                    </select>
                </td>
                <td>Status to use for pending/incomplete payments</td>
            </tr>
            <!-- Order Status - Failed -->
            <tr class="row1">
                <td><strong>Order Status for Failed/Cancelled Payments</strong></td>
                <td>
                    <select name="payuRedirectPaymentPage_failorder_status" class="inputbox" >
                    <?php
    				for( $i = 0; $i < sizeof( $order_status_code ); $i++ )
    				{
    					echo "<option value=\"" . $order_status_code[$i];
    					if ($payuOptions['payuRedirectPaymentPage_failorder_status'] == $order_status_code[$i])
    						echo "\" selected=\"selected\">";
    					else
    						echo "\">";
    					echo $order_status_name[$i] . "</option>\n";
                    }
    				?>
                    </select>
                </td>
                <td>Status to use for failed/cancelled payments</td>
            </tr>
           
        </table>
    <?php
    }

	/**
     * has_configuration
     */
    function has_configuration()
	{
      // return false if there's no configuration
      return true;
	}

  	/**
	 * configfile_writeable
	 *
	 * Returns the "is_writeable" status of the configuration file
	 *
	 * @param void
	 * @returns boolean True when the configuration file is writeable, false when not
	 */
	function configfile_writeable() {
		return is_writeable( CLASSPATH .'payment/'. $this->classname .'.cfg.php' );
	}

	/**
	 * configfile_readable
	 *
	 * Returns the "is_readable" status of the configuration file
	 *
	 * @param void
	 * @returns boolean True when the configuration file is readable, false when not
	 */
	function configfile_readable()	{
		return is_readable( CLASSPATH .'payment/'. $this->classname .'.cfg.php' );
	}

	/**
	 * write_configuration
	 *
	 * Writes the configuration file
	 *
	 * @param array An array of objects
	 * @returns boolean True when writing was successful
	 */
	function write_configuration( &$d )
	{
	    // If payment method is not newly added
        // - without this, errors would be displayed
	    if( isset( $d['payuRedirectPaymentPage_successorder_status'] ) )
	    {
    		// Set the initial content of the file
    		$config =
    			"<?php\n".
    			"if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );\n".
                'require ("library.payu/classes/class.PayuRedirectPaymentPage.php");'."\r\n".
    			"/**\n".
     			" * ps_payuRedirectPaymentPage.cfg.php\n".
     			" *\n".
     			" * This file contains the payment module configuration settings. It must be\n".
    			" * writeable on the web server.*/\n";
            
            $configLineArray = array();
            foreach( $d as $key => $value ) {
                if( (!is_array($value))  ) {
                    $tempArray = explode('_',$key,2);
                    if($tempArray[0] == 'payuRedirectPaymentPage') {                
                        $configLineArray[$key] = "if(!defined('".addslashes($key)."')) { define( '".addslashes($key)."', '".addslashes($value)."' ); }\n";
                        $keyWhichSystem = $key."_".$d['payuRedirectPaymentPage_systemToCall'];
                        $configLineArray[$keyWhichSystem]  = "if(!defined('".addslashes($keyWhichSystem)."')) { define( '".addslashes($keyWhichSystem)."', '".addslashes($value)."' ); }\n";                        
                    }            
                }                
            }            
    		
            
            foreach($configLineArray as $thisLine) {
                $config .= $thisLine;
            }
            $config .= "?>";
            
            // Write the configuration to file
    		if( $fp = fopen( CLASSPATH .'payment/'. $this->classname .'.cfg.php', "w" ) )
    		{
    			fputs( $fp, $config, strlen( $config ) );
    			fclose( $fp );
    			return true;
    		}
    		else
    			return false;
    	}
	}

	/**
	 * process_payment
	 *
	 * @returns boolean True
	 */
	function process_payment( $order_number, $order_total, &$d ) {
		return true;
	}
}