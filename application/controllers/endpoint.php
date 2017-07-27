<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Endpoint extends MY_Controller {

  private $_shop = '';
  private $_inputInfo = array();
  private $_message = '';
  private $_shopifydelay = 0.9;
  
  private $_log_file = false;
  private $_log_message = true;
      
  public function __construct() {
    parent::__construct();
    
    ini_set( 'max_execution_time', '40000' );
    
    // Shopify Delay
    $this->_shopifydelay = $this->_shopifydelay * 1000000;
    
    // Load Model    
    $this->load->model( 'Log_model' );
    
    // Define a header
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET");
    header('Content-Type: application/json');
    
    // Get the shop from the HTTP Header or private shop  
    $this->_shop = isset( $_SERVER['HTTP_X_SHOPIFY_SHOP_DOMAIN'] ) ? $_SERVER['HTTP_X_SHOPIFY_SHOP_DOMAIN'] : $this->config->item('PRIVATE_SHOP');

    // Get the Input Stream
    $this->_inputInfo = json_decode( file_get_contents('php://input') );

    if( !isset($this->_inputInfo->id ) )
    {
//      $strTemp = '{"id":6656143175,"title":"A046 360 Degrees Car Windscreen Holder Dashboard Mount Stand for Cell Phone GPS2","body_html":"\u003cdiv class=\"xxkkk\"\u003eLorem ipsum dolor sit amet, consectetuer adipiscing elit. Sed tempus diam non pede. Vivamus porttitor dui ac est fringilla porttitor. In luctus iaculis nunc. Praesent ac ligula. Cras rutrum cursus risus. Nunc tincidunt sapien dignissim massa. Nam facilisis. Mauris sit amet nisl a ante porta faucibus. Quisque commodo ante sed mauris. Integer ac dui. Curabitur varius lorem et tortor. Phasellus tristique turpis nec magna.\u003c\/div\u003e","vendor":"Chief Products","product_type":"Normal","created_at":"2016-05-19T20:44:56+10:00","handle":"a046-360-degrees-car-windscreen-holder-dashboard-mount-stand-for-cell-phone-gps","updated_at":"2016-07-16T00:44:51+10:00","published_at":"2016-05-19T20:44:00+10:00","template_suffix":null,"published_scope":"global","tags":"case, iphone","variants":[{"id":21168477383,"product_id":6656143175,"title":"HEAVY GRAY \/ Large \/ IRON","price":"12.00","sku":"159380902","position":1,"grams":95,"inventory_policy":"deny","compare_at_price":"1.40","fulfillment_service":"manual","inventory_management":"shopify","option1":"HEAVY GRAY","option2":"Large","option3":"IRON","created_at":"2016-05-19T20:44:56+10:00","updated_at":"2016-07-13T02:39:45+10:00","taxable":false,"barcode":"999999999","image_id":12708165575,"inventory_quantity":64,"weight":0.21,"weight_unit":"lb","old_inventory_quantity":64,"requires_shipping":true},{"id":21168477447,"product_id":6656143175,"title":"RED \/ Small \/ Summer","price":"13.25","sku":"159380901","position":2,"grams":206,"inventory_policy":"deny","compare_at_price":"1.40","fulfillment_service":"manual","inventory_management":"shopify","option1":"RED","option2":"Small","option3":"Summer","created_at":"2016-05-19T20:44:56+10:00","updated_at":"2016-07-13T02:13:51+10:00","taxable":false,"barcode":"","image_id":12708201671,"inventory_quantity":100,"weight":0.206,"weight_unit":"kg","old_inventory_quantity":100,"requires_shipping":true}],"options":[{"id":7986873735,"product_id":6656143175,"name":"Color","position":1,"values":["HEAVY GRAY","RED"]},{"id":9275480647,"product_id":6656143175,"name":"Size","position":2,"values":["Large","Small"]},{"id":9275485255,"product_id":6656143175,"name":"Materials","position":3,"values":["IRON","Summer"]}],"images":[{"id":12708165575,"product_id":6656143175,"position":1,"created_at":"2016-05-19T20:45:00+10:00","updated_at":"2016-05-19T20:45:00+10:00","src":"https:\/\/cdn.shopify.com\/s\/files\/1\/1154\/9496\/products\/1447796684602-P-3445015.jpeg?v=1463654700","variant_ids":[21168477383]},{"id":12708169735,"product_id":6656143175,"position":2,"created_at":"2016-05-19T20:45:06+10:00","updated_at":"2016-05-19T20:45:06+10:00","src":"https:\/\/cdn.shopify.com\/s\/files\/1\/1154\/9496\/products\/1447796684810-P-3445015.jpeg?v=1463654706","variant_ids":[]},{"id":12708172359,"product_id":6656143175,"position":3,"created_at":"2016-05-19T20:45:11+10:00","updated_at":"2016-05-19T20:45:11+10:00","src":"https:\/\/cdn.shopify.com\/s\/files\/1\/1154\/9496\/products\/1447796684751-P-3445015.jpeg?v=1463654711","variant_ids":[]},{"id":12708175175,"product_id":6656143175,"position":4,"created_at":"2016-05-19T20:45:16+10:00","updated_at":"2016-05-19T20:45:16+10:00","src":"https:\/\/cdn.shopify.com\/s\/files\/1\/1154\/9496\/products\/1447796684426-P-3445015.jpeg?v=1463654716","variant_ids":[]},{"id":12708177607,"product_id":6656143175,"position":5,"created_at":"2016-05-19T20:45:21+10:00","updated_at":"2016-05-19T20:45:21+10:00","src":"https:\/\/cdn.shopify.com\/s\/files\/1\/1154\/9496\/products\/1447796685962-P-3445015.jpeg?v=1463654721","variant_ids":[]},{"id":12708181639,"product_id":6656143175,"position":6,"created_at":"2016-05-19T20:45:26+10:00","updated_at":"2016-05-19T20:45:26+10:00","src":"https:\/\/cdn.shopify.com\/s\/files\/1\/1154\/9496\/products\/1447796685070-P-3445015.jpeg?v=1463654726","variant_ids":[]},{"id":12708183367,"product_id":6656143175,"position":7,"created_at":"2016-05-19T20:45:30+10:00","updated_at":"2016-05-19T20:45:30+10:00","src":"https:\/\/cdn.shopify.com\/s\/files\/1\/1154\/9496\/products\/1447796685980-P-3445015.jpeg?v=1463654730","variant_ids":[]},{"id":12708187335,"product_id":6656143175,"position":8,"created_at":"2016-05-19T20:45:36+10:00","updated_at":"2016-05-19T20:45:36+10:00","src":"https:\/\/cdn.shopify.com\/s\/files\/1\/1154\/9496\/products\/1447796685838-P-3445015.jpeg?v=1463654736","variant_ids":[]},{"id":12708191111,"product_id":6656143175,"position":9,"created_at":"2016-05-19T20:45:41+10:00","updated_at":"2016-05-19T20:45:41+10:00","src":"https:\/\/cdn.shopify.com\/s\/files\/1\/1154\/9496\/products\/1447796686966-P-3445015.jpeg?v=1463654741","variant_ids":[]},{"id":12708201671,"product_id":6656143175,"position":10,"created_at":"2016-05-19T20:45:59+10:00","updated_at":"2016-05-19T20:45:59+10:00","src":"https:\/\/cdn.shopify.com\/s\/files\/1\/1154\/9496\/products\/1447796594040-P-3445014.jpeg?v=1463654759","variant_ids":[21168477447]},{"id":12708204487,"product_id":6656143175,"position":11,"created_at":"2016-05-19T20:46:04+10:00","updated_at":"2016-05-19T20:46:04+10:00","src":"https:\/\/cdn.shopify.com\/s\/files\/1\/1154\/9496\/products\/1447796594769-P-3445014.jpeg?v=1463654764","variant_ids":[]},{"id":12708206919,"product_id":6656143175,"position":12,"created_at":"2016-05-19T20:46:08+10:00","updated_at":"2016-05-19T20:46:08+10:00","src":"https:\/\/cdn.shopify.com\/s\/files\/1\/1154\/9496\/products\/1447796595202-P-3445014.jpeg?v=1463654768","variant_ids":[]},{"id":12708210183,"product_id":6656143175,"position":13,"created_at":"2016-05-19T20:46:13+10:00","updated_at":"2016-05-19T20:46:13+10:00","src":"https:\/\/cdn.shopify.com\/s\/files\/1\/1154\/9496\/products\/1447796595991-P-3445014.jpeg?v=1463654773","variant_ids":[]},{"id":12708214343,"product_id":6656143175,"position":14,"created_at":"2016-05-19T20:46:18+10:00","updated_at":"2016-05-19T20:46:18+10:00","src":"https:\/\/cdn.shopify.com\/s\/files\/1\/1154\/9496\/products\/1447796595279-P-3445014.jpeg?v=1463654778","variant_ids":[]},{"id":12708217095,"product_id":6656143175,"position":15,"created_at":"2016-05-19T20:46:23+10:00","updated_at":"2016-05-19T20:46:23+10:00","src":"https:\/\/cdn.shopify.com\/s\/files\/1\/1154\/9496\/products\/1447796595770-P-3445014.jpeg?v=1463654783","variant_ids":[]},{"id":12708219335,"product_id":6656143175,"position":16,"created_at":"2016-05-19T20:46:27+10:00","updated_at":"2016-05-19T20:46:27+10:00","src":"https:\/\/cdn.shopify.com\/s\/files\/1\/1154\/9496\/products\/1447796595305-P-3445014.jpeg?v=1463654787","variant_ids":[]},{"id":12708223111,"product_id":6656143175,"position":17,"created_at":"2016-05-19T20:46:32+10:00","updated_at":"2016-05-19T20:46:32+10:00","src":"https:\/\/cdn.shopify.com\/s\/files\/1\/1154\/9496\/products\/1447796596084-P-3445014.jpeg?v=1463654792","variant_ids":[]},{"id":12708225223,"product_id":6656143175,"position":18,"created_at":"2016-05-19T20:46:37+10:00","updated_at":"2016-05-19T20:46:37+10:00","src":"https:\/\/cdn.shopify.com\/s\/files\/1\/1154\/9496\/products\/1447796596469-P-3445014.jpeg?v=1463654797","variant_ids":[]},{"id":12708227719,"product_id":6656143175,"position":19,"created_at":"2016-05-19T20:46:41+10:00","updated_at":"2016-05-19T20:46:41+10:00","src":"https:\/\/cdn.shopify.com\/s\/files\/1\/1154\/9496\/products\/1447796596106-P-3445014.jpeg?v=1463654801","variant_ids":[]}],"image":{"id":12708165575,"product_id":6656143175,"position":1,"created_at":"2016-05-19T20:45:00+10:00","updated_at":"2016-05-19T20:45:00+10:00","src":"https:\/\/cdn.shopify.com\/s\/files\/1\/1154\/9496\/products\/1447796684602-P-3445015.jpeg?v=1463654700","variant_ids":[21168477383]}}';
      $strTemp = '{"id":3745073799,"email":"denis.buhler@outlook.com","closed_at":null,"created_at":"2016-07-16T10:54:21+10:00","updated_at":"2016-07-16T10:56:22+10:00","number":27,"note":"","token":"fdb162880342c6176dfbf4b4dec7ee99","gateway":"Bank Deposit","test":false,"total_price":"73.21","subtotal_price":"63.21","total_weight":503,"total_tax":"0.91","taxes_included":true,"currency":"AUD","financial_status":"paid","confirmed":true,"total_discounts":"0.00","total_line_items_price":"63.21","cart_token":"431917b7277ea05887f42caa3781b56b","buyer_accepts_marketing":false,"name":"#1027","referring_site":"","landing_site":"\/","cancelled_at":null,"cancel_reason":null,"total_price_usd":"55.73","checkout_token":"bc86eca72eafa28a006129b60aa55d41","reference":null,"user_id":null,"location_id":null,"source_identifier":null,"source_url":null,"processed_at":"2016-07-16T10:54:21+10:00","device_id":null,"browser_ip":null,"landing_site_ref":null,"order_number":1027,"discount_codes":[],"note_attributes":[{"name":"What color are you prefer to","value":"Black"}],"payment_gateway_names":["Bank Deposit"],"processing_method":"manual","checkout_id":9429137607,"source_name":"web","fulfillment_status":null,"tax_lines":[{"title":"MwSt","price":"0.91","rate":0.1}],"tags":"","contact_email":"denis.buhler@outlook.com","order_status_url":"https:\/\/checkout.shopify.com\/11549496\/checkouts\/bc86eca72eafa28a006129b60aa55d41\/thank_you_token?key=9642fb35e8476430081810785e0a254e","line_items":[{"id":7092196167,"variant_id":21168134279,"title":"Baseus QI Wireless Charger Receiver for iPhone","quantity":3,"price":"5.07","grams":41,"sku":"168840702","variant_title":"FOR LIGHTNING INPUT DEVICE \/ LIGHT GRAY","vendor":"Ecango-CB","fulfillment_service":"manual","product_id":6656012551,"requires_shipping":true,"taxable":false,"gift_card":false,"name":"Baseus QI Wireless Charger Receiver for iPhone - FOR LIGHTNING INPUT DEVICE \/ LIGHT GRAY","variant_inventory_management":"shopify","properties":[],"product_exists":true,"fulfillable_quantity":3,"total_discount":"0.00","fulfillment_status":null,"tax_lines":[{"title":"MwSt","price":"0.00","rate":0.1}],"origin_location":{"id":876106887,"country_code":"AU","province_code":"QLD","name":"Chief Products","address1":"P.O. Box 278","address2":"","city":"Mudgeeraba","zip":"4213"},"destination_location":{"id":1705958343,"country_code":"DE","province_code":"","name":"denis buhler","address1":"werneuchener","address2":"","city":"Berlin","zip":"13055"}},{"id":7092196231,"variant_id":21168477383,"title":"A046 360 Degrees Car Windscreen Holder Dashboard Mount Stand for Cell Phone GPS2","quantity":4,"price":"12.00","grams":95,"sku":"159380902","variant_title":"HEAVY GRAY \/ Large \/ IRON","vendor":"Chief Products","fulfillment_service":"manual","product_id":6656143175,"requires_shipping":true,"taxable":false,"gift_card":false,"name":"A046 360 Degrees Car Windscreen Holder Dashboard Mount Stand for Cell Phone GPS2 - HEAVY GRAY \/ Large \/ IRON","variant_inventory_management":"shopify","properties":[],"product_exists":true,"fulfillable_quantity":4,"total_discount":"0.00","fulfillment_status":null,"tax_lines":[{"title":"MwSt","price":"0.00","rate":0.1}],"origin_location":{"id":876106887,"country_code":"AU","province_code":"QLD","name":"Chief Products","address1":"P.O. Box 278","address2":"","city":"Mudgeeraba","zip":"4213"},"destination_location":{"id":1705958343,"country_code":"DE","province_code":"","name":"denis buhler","address1":"werneuchener","address2":"","city":"Berlin","zip":"13055"}}],"shipping_lines":[{"id":3157854663,"title":"Standard Shipping","price":"10.00","code":"Standard Shipping","source":"shopify","phone":null,"delivery_category":null,"carrier_identifier":null,"tax_lines":[{"title":"MwSt","price":"0.91","rate":0.1}]}],"billing_address":{"first_name":"denis","address1":"werneuchener","phone":"15910963664","city":"Berlin","zip":"13055","province":null,"country":"Germany","last_name":"buhler","address2":"","company":null,"latitude":52.5405416,"longitude":13.4949562,"name":"denis buhler","country_code":"DE","province_code":null},"shipping_address":{"first_name":"denis","address1":"werneuchener","phone":"15910963664","city":"Berlin","zip":"13055","province":null,"country":"Germany","last_name":"buhler","address2":"","company":null,"latitude":52.5405416,"longitude":13.4949562,"name":"denis buhler","country_code":"DE","province_code":null},"fulfillments":[],"client_details":{"browser_ip":"104.237.91.157","accept_language":"en-US,en;q=0.8","user_agent":"Mozilla\/5.0 (Windows NT 10.0; WOW64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/51.0.2704.103 Safari\/537.36","session_hash":"e7052c1bb5643da2eb2d4480febd3540","browser_width":1920,"browser_height":955},"refunds":[],"customer":{"id":3929218311,"email":"denis.buhler@outlook.com","accepts_marketing":false,"created_at":"2016-07-08T00:37:00+10:00","updated_at":"2016-07-16T10:54:22+10:00","first_name":"denis","last_name":"buhler","orders_count":2,"state":"disabled","total_spent":"0.00","last_order_id":3745073799,"note":null,"verified_email":true,"multipass_identifier":null,"tax_exempt":false,"tags":"","last_order_name":"#1027","default_address":{"id":4293092359,"first_name":"denis","last_name":"buhler","company":null,"address1":"werneuchener","address2":"","city":"Berlin","province":null,"country":"Germany","zip":"13055","phone":"15910963664","name":"denis buhler","province_code":null,"country_code":"DE","country_name":"Germany","default":true}}}';
//      $strTemp = '{"rate":{"origin":{"country":"AU","postal_code":"4213","province":"QLD","city":"Mudgeeraba","name":null,"address1":"P.O. Box 278","address2":"","address3":null,"phone":"61755227340","fax":null,"address_type":null,"company_name":"KevShop"},"destination":{"country":"US","postal_code":"7000","province":"TAS","city":"Hobart","name":"Maree Anne  Davis","address1":"98 Argyle Street","address2":"","address3":null,"phone":"","fax":null,"address_type":null,"company_name":""},"items":[{"name":"Default","sku":"YO0625501","quantity":2,"grams":35,"price":1000,"vendor":"KevShop","requires_shipping":true,"taxable":true,"fulfillment_service":"manual","properties":null,"product_id":5309944903,"variant_id":16435836679},{"name":"Large","sku":"YO0625502","quantity":1,"grams":50,"price":2000,"vendor":"KevShop","requires_shipping":true,"taxable":true,"fulfillment_service":"manual","properties":null,"product_id":5309940615,"variant_id":16435812679}],"currency":"AUD"}}';
      
      $this->_inputInfo = json_decode( $strTemp );
    }

    // Log the request 
    if( $this->_log_file )   
    {
      $this->Log_model->add( 'Webhook', $this->_shop, $_SERVER['REQUEST_URI'] . json_encode( $this->_inputInfo ), '' );
    }
    
  }
  
  public function __destruct()
  {
  }
  
  // Load shopify model  
  private function _loadShopify()
  {
    // Define the model
    $this->load->model( 'Shopify_model' );
    $this->Shopify_model->setStore( $this->_shop, $this->_arrStoreList[$this->_shop]->app_id, $this->_arrStoreList[$this->_shop]->app_secret );
  }      
  
  // Get the Shop information
  private function _getShopInfo()
  {
    // Load the shopify model
    $this->_loadShopify();

    return $this->Shopify_model->accessAPI( 'shop.json' );
  }

  
  public function index(){
  }
  
  /** 
  * Checkout popup
  * 
  */
  public function order_create( $method = 'Order Created' )
  {
    // Load Model
    $this->load->model( 'Process_model' );
    
    // Log the system
    $this->Log_model->add( 'Webhook', $method, trim( $this->_inputInfo->name, '#'), $this->_shop );        

    // Access the Process
    $this->Process_model->order_create( $this->_inputInfo, $this->_arrStoreList[ $this->_shop ], $method );    
  }
  
  public function order_paid()
  {
    $this->order_create( 'Order Paid' );
  }
  
  public function order_update()
  {
    usleep( 10000000 );
    
    // Skip blank update within 10 seconds
    if( $this->_inputInfo->created_at == $this->_inputInfo->updated_at)  return;
    
    $created_at = strtotime( $this->_inputInfo->created_at ) + 0;
    $updated_at = strtotime( $this->_inputInfo->updated_at ) + 0;
    if( $updated_at - $created_at < 10 )  return;
    
    $this->order_create( 'Order Updated' );
  }
    
  public function order_cancel()
  {
    $this->Log_model->add( 'Webhook', 'Order Cancelled', $this->_inputInfo->name, '' );
    
    // Update the order status
    $this->load->model( 'Order_model' );
    $this->Order_model->rewriteParam( $this->_shop );
    $this->Order_model->updateStatus( $this->_inputInfo->id, array( 'status' => 'cancelled' ) );
  }

  public function product_create()
  {
    // Log
    $this->Log_model->add( 'Webhook', 'Product Create', $this->_inputInfo->id, '' );
        
    $this->load->model( 'Process_model' );
    $this->Process_model->product_create( $this->_inputInfo, $this->_arrStoreList[ $this->_shop ], 'Product Create' );        

  }
  
  public function product_update()
  {
    $this->load->model( 'Process_model' );
    $this->Process_model->product_create( $this->_inputInfo, $this->_arrStoreList[ $this->_shop ], 'Product Update' );        
  }

  public function product_delete()
  {
    // Log
    $this->Log_model->add( 'Webhook', 'Product Delete', $this->_inputInfo, '' );
    
    // Define the product model
    $this->load->model( 'Product_model' );
    $this->Product_model->rewriteParam( $this->_shop );
    
    // Delete Product
    $this->Product_model->deleteProduct( $this->_inputInfo );
  }
  
}
    
