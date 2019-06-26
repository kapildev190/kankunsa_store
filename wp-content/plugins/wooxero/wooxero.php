<?php
/**
 * Plugin Name: WooXero
 * Plugin URI: https://wooxero.com/
 * Description: An eCommerce toolkit that helps you to link woocommerce with xero.
 * Version: 3.6.4
 * Author: Automattic
 * Author URI: https://wooxero.com
 * Text Domain: wooxero
 * Domain Path: /i18n/languages/
 *
 * @package WooXero
 */

/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/


add_action( 'user_new_form', 'crf_admin_registration_form' );
function crf_admin_registration_form( $operation ) {
    if ( 'add-new-user' !== $operation ) {
        // $operation may also be 'add-existing-user'
        return;
    }

    $paymentTerm = ! empty( $_POST['payment_term'] ) ? intval( $_POST['payment_term'] ) : '';
    
    $xeroCustomerId = ! empty( $_POST['xero_customer_id'] ) ? $_POST['xero_customer_id']  : '';

    ?>
    <h3><?php esc_html_e( 'Xero Custom Field', 'crf' ); ?></h3>

    <table class="form-table">
        <tr>
            <th><label for="payment_term"><?php esc_html_e( 'Payment term', 'crf' ); ?></label> <span class="description"><?php esc_html_e( '(required)', 'crf' ); ?></span></th>
            <td>
                <input type="text"
                   id="payment_term"
                   name="payment_term"
                   value="<?php echo esc_attr( $paymentTerm ); ?>"
                   class="regular-text"
                />
            </td>
        </tr>
        <tr>
            <th><label for="xero_customer_id"><?php esc_html_e( 'Xero customer id', 'crf' ); ?></label> <span class="description"><?php esc_html_e( '(required)', 'crf' ); ?></span></th>
            <td>
                <input type="text"
                   id="xero_customer_id"
                   name="xero_customer_id"
                   value="<?php echo esc_attr( $xeroCustomerId ); ?>"
                   class="regular-text"
                />
            </td>
        </tr>
    </table>
    <?php
}

add_action( 'show_user_profile', 'crf_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'crf_show_extra_profile_fields' );

function crf_show_extra_profile_fields( $user ) {
    $paymentTerm = get_the_author_meta( 'payment_term', $user->ID );
    $xeroCustomerId = get_the_author_meta( 'xero_customer_id', $user->ID );
    ?>
    <h3><?php esc_html_e( 'Xero Custom Field', 'crf' ); ?></h3>

    <table class="form-table">
        <tr>
            <th><label for="payment_term"><?php esc_html_e( 'payment term', 'crf' ); ?></label></th>
            <td>
                <input type="text"                   
                   id="payment_term"
                   name="payment_term"
                   value="<?php echo esc_attr( $paymentTerm ); ?>"
                   class="regular-text"
                />
            </td>
        </tr>
         <tr>
            <th><label for="xero_customer_id"><?php esc_html_e( 'Xero customer id', 'crf' ); ?></label></th>
            <td>
                <input type="text"                   
                   id="xero_customer_id"
                   name="xero_customer_id"
                   value="<?php echo esc_attr( $xeroCustomerId ); ?>"
                   class="regular-text"
                />
            </td>
        </tr>
    </table>
    <?php
}

add_action( 'user_profile_update_errors', 'crf_user_profile_update_errors', 10, 3 );
function crf_user_profile_update_errors( $errors, $update, $user ) {
    if ( ! $update ) {
        return;
    }

    if ( empty( $_POST['payment_term'] ) ) {
        $errors->add( 'payment_term_error', __( '<strong>ERROR</strong>: Please enter your payment term.', 'crf' ) );
    }

    if ( ! empty( $_POST['payment_term'] ) && intval( $_POST['payment_term'] ) > 365 ) {
        $errors->add( 'payment_term_error', __( '<strong>ERROR</strong>: You must be between 1 to 365.', 'crf' ) );
    }

    if ( empty( $_POST['xero_customer_id'] ) ) {
        $errors->add( 'xero_customer_id_error', __( '<strong>ERROR</strong>: Please enter your Xero customer id.', 'crf' ) );
    }
}



add_action( 'user_register', 'crf_add_profile_fields', 10, 1 );

function crf_add_profile_fields( $user_id ) {    

    if ( ! empty( $_POST['payment_term'] ) ) {
       
        add_user_meta( $user_id, 'payment_term', intval( $_POST['payment_term'] ) );
        
    }

    if ( ! empty( $_POST['xero_customer_id'] ) ) {

        add_user_meta( $user_id, 'xero_customer_id',  $_POST['xero_customer_id']  );
        
    }     

}

add_action( 'personal_options_update', 'crf_update_profile_fields' );
add_action( 'edit_user_profile_update', 'crf_update_profile_fields' );

function crf_update_profile_fields( $user_id ) {

    if ( ! current_user_can( 'edit_user', $user_id ) ) {
        return false;
    }

    if ( ! empty( $_POST['payment_term'] ) && intval( $_POST['payment_term'] ) < 365 ) {
       
        update_user_meta( $user_id, 'payment_term', intval( $_POST['payment_term'] ) );
        
    }

    if ( ! empty( $_POST['xero_customer_id'] ) ) {
       
        update_user_meta( $user_id, 'xero_customer_id', $_POST['xero_customer_id'] );
        
    }
}




/*add_action( 'woocommerce_before_checkout_process', 'initiate_order' , 10, 1 );
function initiate_order($order_id){
    
}
*/

add_action('woocommerce_thankyou', 'order_compler', 10, 1);
function order_compler( $order_id ) {

    if ( ! $order_id )
        return;

    /*
        if($order->is_paid())
            $paid = 'yes';
        else
            $paid = 'no';
    */

      /*
        $xml = "<Invoices>
              <Invoice>
                <Type>ACCREC</Type>
                <Contact>
                  <Name>Kapil dev</Name>
                </Contact>
                <Date>2019-07-13T00:00:00</Date>
                <DueDate>2019-07-20T00:00:00</DueDate>
                <LineAmountTypes>Exclusive</LineAmountTypes>
                <LineItems>
                  <LineItem>
                    <Description>Monthly rental for property at 56a Wilkins Avenue</Description>
                    <Quantity>4.3400</Quantity>
                    <UnitAmount>395.00</UnitAmount>
                    <AccountCode>200</AccountCode>
                  </LineItem>
                </LineItems>
              </Invoice>
            </Invoices>";
    */

    include_once( plugin_dir_path( __FILE__ ). 'xero/private.php');      

    // Getting an instance of the order object
    $order = wc_get_order( $order_id );
    //echo "<pre>"; print($order); 

    $customer_id = get_current_user_id();

    if($customer_id == 0){
        // If non register user place order then create customer at xero
         
        $cus_first_name = $order->get_billing_first_name();
        $cus_last_name = $order->get_billing_last_name();
        $cus_email = $order->get_billing_email();
        $customerFullName = $cus_first_name.' '.$cus_last_name;

        # Create Xero Customer
        $xml = "<Contacts>
                    <Contact>
                        <Name>".$customerFullName."</Name>
                        <EmailAddress>".$cus_email."</EmailAddress>
                        <FirstName>".$cus_first_name."</FirstName>
                        <LastName>".$cus_last_name."</LastName>
                    </Contact>
                </Contacts>";

        $response = $XeroOAuth->request('POST', $XeroOAuth->url('Contacts', 'core'), array(), $xml);
        if ($XeroOAuth->response['code'] == 200) {
            $contact = $XeroOAuth->parseResponse($XeroOAuth->response['response'], $XeroOAuth->response['format']);
            //echo "<pre>";print_r($contact->Contacts);
            $xeroCustomerId = $contact->Contacts->Contact->ContactID;
        } else {
            outputError($XeroOAuth);
        }

         #Get Order Data
        $order_data = $order->get_data(); // The Order data
        //$order_date_created = $order_data['date_created']->date('Y-m-d H:i:s');
        $order_date_created = $order_data['date_created']->date('Y-m-d');


        #Invoice XML here
        $xml = "<Invoices>
            <Invoice>
            <Type>ACCREC</Type>
            <Contact>
              <Name>".$customerFullName."</Name>
            </Contact>
            <Date>".$order_date_created."</Date>
            <DueDate>".$order_date_created."</DueDate>
            <Status>AUTHORISED</Status>
            <LineAmountTypes>Exclusive</LineAmountTypes>
            <LineItems>";

        foreach ( $order->get_items() as $item_id => $item ) {

            //echo "<prE>"; print($item); echo "</pre>";

            if( $item['variation_id'] > 0 ){
                $product_id = $item['variation_id']; // variable product
            } else {
                $product_id = $item['product_id']; // simple product
            }

            // Get the product object
            $product = wc_get_product( $product_id );

            // Get the product name
            $product_name = $item['name'];
            // Get the product price
            $product_price = $product->get_price();
            // Get the item quantity
            $item_quantity = $order->get_item_meta($item_id, '_qty', true);
            // Get the item line total
            $item_total = $order->get_item_meta($item_id, '_line_total', true);

            // Displaying this data (to check)                
            //echo '<br> Product name: '.$product_name.' | Quantity: '.$item_quantity.' | Price: '.$product_price.' | Item total: '. $item_total;

            $xml .= "<LineItem>
                <Description>".$product_name."</Description>
                <Quantity>".$item_quantity."</Quantity>
                <UnitAmount>".$product_price."</UnitAmount>  
                <AccountCode>200</AccountCode>                  
                </LineItem>";
        }

        // Add shipping item into xero invocie
        $shipping_total = $order->get_shipping_total(); 
        $shipping_tax   = $order->get_shipping_tax(); 

        $xml .= "<LineItem>
            <Description>Shipping charge</Description>
            <Quantity>1</Quantity>
            <UnitAmount>".($shipping_total+$shipping_tax)."</UnitAmount>
            <AccountCode>200</AccountCode>                    
            </LineItem>";


        $xml .= "</LineItems>
        </Invoice>
        </Invoices>";

        try{
            # Create Xero Invocie
            $response = $XeroOAuth->request('POST', $XeroOAuth->url('Invoices', 'core'), array(), $xml);
            if ($XeroOAuth->response['code'] == 200) {
                $invoice = $XeroOAuth->parseResponse($XeroOAuth->response['response'], $XeroOAuth->response['format']);
                if (count($invoice->Invoices[0])>0) {
                    // echo "The first one is: </br>";
                    // pr($invoice->Invoices[0]->Invoice);
                }
            } else {
                // Xero Error handing here
            }
        }
        catch (\Exception $ex) {
            // Other exception handling here
            echo $ex->getMessage();
        }

    }else{

        //echo $customer_id;
        $paymentTerm = get_user_meta( $customer_id, 'payment_term', true );
        $xeroCustomerId = get_user_meta( $customer_id, 'xero_customer_id', true );

        if($xeroCustomerId != ''){
            #Get Order Data
            $order_data = $order->get_data(); // The Order data
            //$order_date_created = $order_data['date_created']->date('Y-m-d H:i:s');
            $order_date_created = $order_data['date_created']->date('Y-m-d');

            //echo date('Y-m-d', strtotime($Date. ' + 1 days'));

            if($paymentTerm != ''){
                $order_due_date = date('Y-m-d', strtotime($order_date_created. " + $paymentTerm days"));
            }else{
                $order_due_date = $order_date_created;
            }

            #Invoice XML here
            $xml = "<Invoices>
                        <Invoice>
                        <Type>ACCREC</Type>
                        <Contact>
                            <ContactID>".$xeroCustomerId."</ContactID>
                        </Contact>
                        <Date>".$order_date_created."</Date>
                        <DueDate>".$order_date_created."</DueDate>
                        <Status>AUTHORISED</Status>
                        <LineAmountTypes>Exclusive</LineAmountTypes>
                        <LineItems>";


            foreach ( $order->get_items() as $item_id => $item ) {

                //echo "<prE>"; print($item); echo "</pre>";

                if( $item['variation_id'] > 0 ){
                    $product_id = $item['variation_id']; // variable product
                } else {
                    $product_id = $item['product_id']; // simple product
                }

                // Get the product object
                $product = wc_get_product( $product_id );

                // Get the product name
                $product_name = $item['name'];
                // Get the product price
                $product_price = $product->get_price();
                // Get the item quantity
                $item_quantity = $order->get_item_meta($item_id, '_qty', true);
                // Get the item line total
                $item_total = $order->get_item_meta($item_id, '_line_total', true);

                // Displaying this data (to check)                
                //echo '<br> Product name: '.$product_name.' | Quantity: '.$item_quantity.' | Price: '.$product_price.' | Item total: '. $item_total;

                $xml .= "<LineItem>
                    <Description>".$product_name."</Description>
                    <Quantity>".$item_quantity."</Quantity>
                    <UnitAmount>".$product_price."</UnitAmount>  
                    <AccountCode>200</AccountCode>                  
                    </LineItem>";
            }

            // Add shipping item into xero invocie
            $shipping_total = $order->get_shipping_total(); 
            $shipping_tax   = $order->get_shipping_tax(); 

            $xml .= "<LineItem>
                <Description>Shipping charge</Description>
                <Quantity>1</Quantity>
                <UnitAmount>".($shipping_total+$shipping_tax)."</UnitAmount>
                <AccountCode>200</AccountCode>                    
                </LineItem>";


            $xml .= "</LineItems>
            </Invoice>
            </Invoices>";

            try{
                # Create Xero Invocie
                $response = $XeroOAuth->request('POST', $XeroOAuth->url('Invoices', 'core'), array(), $xml);
                if ($XeroOAuth->response['code'] == 200) {
                    $invoice = $XeroOAuth->parseResponse($XeroOAuth->response['response'], $XeroOAuth->response['format']);
                    if (count($invoice->Invoices[0])>0) {
                        // echo "The first one is: </br>";
                        // pr($invoice->Invoices[0]->Invoice);
                        $invoiceId = $invoice->Invoices[0]->Invoice->InvoiceID;
                        $invoiceAmt = $invoice->Invoices[0]->Invoice->AmountDue;

                        // <Date>".$order_date_created."T".date('h:i:s')."</Date>
                        // Add payment to invocie
                        $paymentxml = "<Payments>
                                  <Payment>
                                    <Invoice>
                                      <InvoiceID>".$invoiceId."</InvoiceID>
                                    </Invoice>
                                    <Account>
                                      <AccountID>562555F2-8CDE-4CE9-8203-0363922537A4</AccountID>
                                    </Account>
                                    <Date>2019-06-26</Date>
                                    <Amount>".$invoiceAmt."</Amount>
                                  </Payment>
                                </Payments>";


                        $response = $XeroOAuth->request('PUT', $XeroOAuth->url('payments', 'core'), array(), $paymentxml);
                        if ($XeroOAuth->response['code'] == 200) {
                            $payments = $XeroOAuth->parseResponse($XeroOAuth->response['response'], $XeroOAuth->response['format']);
                            //pr($payments->Payments[0]->Payment);
                            //die('------');
                        } else {
                            outputError($XeroOAuth);
                        }

                    }
                } else {
                    // Xero Error handing here
                }
            }
            catch (\Exception $ex) {
                // Other exception handling here
                echo $ex->getMessage();
            }
        }
           
        
    }
   
}
