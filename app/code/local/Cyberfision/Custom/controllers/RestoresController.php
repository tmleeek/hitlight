<?php

class Cyberfision_Custom_RestoresController extends Mage_Core_Controller_Front_Action
{
    public function emailAction()
    {
        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        $write = Mage::getSingleton('core/resource')->getConnection('core_write');
        $orders = $read->fetchAll('select quote_id, increment_id,entity_id from sales_flat_order where customer_email is null');
        //echo '<pre>';print_r($orders);echo '</pre>'; 
        $k = 1;
		
		if(count($orders)){
			foreach ($orders as $order) {
				$sql = 'select email from sales_flat_order_address where parent_id=?';
				$email = $read->fetchOne($sql, array($order['entity_id']));
				if ($email) {
					$write->query('update sales_flat_order set customer_email=? where entity_id=?', array($email, $order['entity_id']));
					echo $k . '> id: ' . $order['entity_id'] . ' - number: ' . $order['increment_id'] . ' - email: ' . $email . '<br/>';
					$k++;
				} else {
					$paymentType = $read->fetchOne('select method from sales_flat_order_payment where parent_id=?', array($order['entity_id']));
					$sql = 'select additional_information from sales_flat_order_payment where parent_id=?';
					$addition = unserialize($read->fetchOne($sql, array($order['entity_id'])));
					//echo '<pre>';print_r($addition);echo '</pre>';
					//echo $paymentType.'<br/>';echo
					$email = $addition['paypal_payer_email'];
					
					if ($addition && in_array($paymentType, array('paypal_express', 'paypal_direct')) && $email) {
						$write->query('update sales_flat_order set customer_email=? where entity_id=?', array($email, $order['entity_id']));
						echo $k . '> id: ' . $order['entity_id'] . ' - number: ' . $order['increment_id'] . ' - email: ' . $email . '<br/>';
						$k++;
					}else{
						echo "Can not find email for order: {$order['increment_id']} <br/>";
					}
				}
			}
		}else{
			echo 'At the moment all our order have been assigned email.  ';
		}
        
    }
}