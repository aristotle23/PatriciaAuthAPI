<?php

class Token extends DbHandler
{
    private $db  = null;
    public function __construct()
    {
        parent::__construct();

    }

    /**
     * @return bool|string
     * generate the API Key;
     */
    public function generateApiKey(){
        try {
            $key = sha1("MyIce");
            $this->execute("insert into api (api_key) values (?)",array($key));
        } catch (Exception $e) {
            return false;
        }
        return $key;
    }

    /**
     * @param $key
     * @return bool
     * check if the API request key is valid key
     */
    public function is_valid($key){
        $api = $this->getAll("select api_key from api where api_key like ? ",array(substr($key,0,18)."%"));
        foreach ($api as $api_key){
            if($api_key['api_key'] === $key){
                return true;
            }
        }
        return false;
    }
}