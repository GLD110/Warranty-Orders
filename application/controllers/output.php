<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Output extends MY_Controller {
    
    public function __construct() {
      parent::__construct();
      $this->load->model( 'Output_model' );
      
      // Define the search values
      $this->_searchConf  = array(
        'shop' => $this->_default_store,
      );
      $this->_searchSession = 'output';
    }
    
    public function index(){
      $this->is_logged_in();
      
      $this->manage();
    }
    
    public function manage( $page =  0 ){
      // Check the login
      $this->is_logged_in();

      // Init the search value
      $this->initSearchValue();

      // Get data
      $this->Output_model->rewriteParam($this->_searchVal['shop']);
      if(isset($this->Output_model->getList()->result()[0]))        
          $data['settings'] =  $this->Output_model->getList()->result()[0];
      else
          $data['settings'] = null;
        
      // Define the rendering data
      $data = $data + $this->setRenderData();

      // Store List    
      $arr = array();
      foreach( $this->_arrStoreList as $shop => $row ) $arr[ $shop ] = $shop;
      $data['arrStoreList'] = $arr;

      $this->load->view('view_header');
      $this->load->view('view_output', $data );
      $this->load->view('view_footer');
    }
    
    public function save( )
    {
      // Check the login
      $this->is_logged_in();
        
      //Get Post data    
      $input = $this->input->post();    
        
      // Init the search value
      $this->initSearchValue();
        
        //var_dump($this->input->post()['in_shop']);exit;
        
      // save and update the output settings
      if($input['vendor_mail'] != '' || $input['ftp_uri'] != ''){    
          $arrList = $this->Output_model->save($input);
      }
      
      $this->manage();
    }   
    
    public function order_output($shop=''){
        
        $shop = $this->_default_store;
        $this->load->model( 'Order_model' );
        $created_at = date('m/d/Y');

        $arrCondition =  array(                    
           'created_at' => date('m/d/Y')         
        );        
        $this->Order_model->rewriteParam($shop);
        
        //var_dump($arrCondition);exit;
        
        $data['query'] =  $this->Order_model->getList( $arrCondition );
        $result = $data['query']->result();
        
        $this->send_csv_mail($result, "This is a text");
    }
    
    /*
        Create csv from database and send it as attachment
    */
    
    function create_csv_string($data) {

        // Open temp file pointer
        if (!$fp = fopen('php://temp', 'w+')) return FALSE;

        fputcsv($fp, array('No', 'Order Name', 'Order ID', 'Product Name', 'Customer', 'Total', 'Products', 'Country', 'Fulfillment Status', 'Checkout Date', 'Financial Status', 'SKU'));

        // Loop data and write to file pointer
        $i = 1;
        foreach($data as $line){
            
            $row = array($i, $line->order_id, $line->order_name, $line->created_at, $line->customer_name, $line->amount, $line->fulfillment_status, $line->num_products, $line->country, $line->product_name, $line->financial_status, $line->sku);
            
            fputcsv($fp, $row);
            $i++;
        }

        // Place stream pointer at beginning
        rewind($fp);

        // Return the data
        return stream_get_contents($fp);

    }

    function send_csv_mail($csvData, $body, $to = '', $subject = 'Order Report', $from = 'noreply@test.com') {

        // This will provide plenty adequate entropy
        $multipartSep = '-----'.md5(time()).'-----';

        // Arrays are much more readable
        $headers = array(
            "From: $from",
            "Reply-To: $from",
            "Content-Type: multipart/mixed; boundary=\"$multipartSep\""
        );

        // Make the attachment
        $attachment = chunk_split(base64_encode($this->create_csv_string($csvData)));

        // Make the body of the message
        $body = "--$multipartSep\r\n"
            . "Content-Type: text/plain; charset=ISO-8859-1; format=flowed\r\n"
            . "Content-Transfer-Encoding: 7bit\r\n"
            . "\r\n"
            . "$body\r\n"
            . "--$multipartSep\r\n"
            . "Content-Type: text/csv\r\n"
            . "Content-Transfer-Encoding: base64\r\n"
            . "Content-Disposition: attachment; filename=\"Website-Report-" . date("F-j-Y") . ".csv\"\r\n"
            . "\r\n"
            . "$attachment\r\n"
            . "--$multipartSep--";

        // Send the email, return the result
        return @mail($to, $subject, $body, implode("\r\n", $headers));
    }       
}

