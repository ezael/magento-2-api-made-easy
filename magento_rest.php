<?php
/**
* Magento2 REST API
* Easy use of the new Magento 2 REST API ;)
*
* HOWTO use it :
* 1/ open a connexion with API
* $api = new maRest("www.mywebsite.com"); 
*
* 2/ connect with your credentials
* $api->connect('myuser','mypassword');
*
* 3/ use it :
* - to call a GET method, WITHOUT search criteria : 
*   $return = $api->get("products/MYSKU");
*
* - to call a GET method, WITH search criteria : u hav to pass a multi dimensions array
*   $search = array(
*      array ("entity_id", "eq", "859"),
*   );
*   $return = $api->get("products", $search);
*
* @Author: Thierry HAY
* test git kraken xxx222
*/

 class maRest 
 {
    public  $url;  
    public  $token;
    public  $user;
    public  $password;
    public  $headers;

    public function __construct($theurl)
    {
        $theurl =           str_replace("http://", "", $theurl);
        $theurl =           trim($theurl, "/");
        
        $this->url =        "http://".$theurl."/rest/V1/";
    }
    
    public function connect($theuser, $thepass)
    {
        $this->user =       $theuser;
        $this->password =   $thepass;
        
        $data_string =      json_encode(array("username" => $this->user, "password" => $this->password));                                                             
        $ch =               curl_init($this->url.'integration/admin/token');

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($data_string))                                                                       
        );      

        $this->token =      json_decode(curl_exec($ch));
        $this->headers =    array("Authorization: Bearer ".$this->token); 
    }
     
    public function get($theurl, $thesearch="")
    {
        if ($thesearch != "")
        {
            $temp = "";
            $iter = 0;
            
            foreach ($thesearch as $value)
            {            
                $temp .= "searchCriteria[filter_groups][0][filters][$iter][field]=".$value[0]."&";
                $temp .= "searchCriteria[filter_groups][0][filters][$iter][value]=".$value[2]."&";
                $temp .= "searchCriteria[filter_groups][0][filters][$iter][condition_type]=".$value[1]."&";
                
                $iter++;
            }
            
            $temp = trim($temp, "&");
            
            $ch = curl_init($this->url.$theurl."?".$temp); 
        }
        else
            $ch = curl_init($this->url.$theurl); 
        
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");    
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);   

        $result = json_decode(curl_exec($ch));

        return $result;
    }
     
    public function getValue($theurl, $thevalue1="", $thevalue2="", $thevalue3="")
    {
        $ch = curl_init($this->url.$theurl); 
        
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");    
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);   

        $result = (array)json_decode(curl_exec($ch));

        if ($thevalue3 != "")
            return $result["$thevalue1"]["$thevalue2"]["$thevalue3"];
        elseif ($thevalue2 != "")
            return $result["$thevalue1"]["$thevalue2"];
        elseif ($thevalue1 != "")
            return $result["$thevalue1"];
        else
            return $result;
    }
     
     
    public function post($theurl, $thedata)
    {
        $productData = json_encode($thedata);

        $ch = curl_init($this->url.$theurl); 
         
        $setHeaders = array('Content-Type:application/json','Authorization: Bearer '.$this->token);
        
        curl_setopt($ch,CURLOPT_POSTFIELDS, $productData);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
        curl_setopt($ch, CURLOPT_HTTPHEADER, $setHeaders); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);   

        $result = json_decode(curl_exec($ch));

        return $result;
    }
     
    public function put($theurl, $thedata)
    {
        $productData = json_encode($thedata);

        $ch = curl_init($this->url.$theurl); 
         
        $setHeaders = array('Content-Type:application/json','Authorization: Bearer '.$this->token);
        
        curl_setopt($ch,CURLOPT_POSTFIELDS, $productData);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");    
        curl_setopt($ch, CURLOPT_HTTPHEADER, $setHeaders); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);   

        $result = json_decode(curl_exec($ch));

        return $result;
    }
     
    public function delete($theurl)
    {
        //change space to %20 for url
        $theurl = str_replace(" ", "%20", $theurl);
        
        $ch = curl_init($this->url.$theurl); 
        
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");    
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
        
        $result = json_decode(curl_exec($ch));

        return $result;
    }
     
    public function token()
    {
        return $this->token;
    }
     
    public function url()
    {
        return $this->url;
    }
}
