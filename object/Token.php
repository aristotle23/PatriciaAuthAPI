<?php

class Token extends DbHandler
{
    public function __construct()
    {
        parent::__construct();

    }

    public function generateApiKey(){
        try {
            $key = base64_encode(random_bytes(42));
            $this->execute("insert into api (api_key) values (?)",array($key));
        } catch (Exception $e) {
            return false;
        }
        return $key;
    }
    public function is_valid($key){
        $api = $this->getAll("select api_key from api where api_key like ? ",array(substr($key,0,28)."%"));
        foreach ($api as $api_key){
            if(hash_equals($api_key['api_key'],$key)){
                return true;
            }
        }
        return false;
    }
}