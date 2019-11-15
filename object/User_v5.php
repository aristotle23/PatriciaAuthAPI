<?php

/**
 * Class User
 * This class handles user's registration and login
 * It extends DbHandler - DbHandler is a wrapper class for PHP PDO database connection and control (For more info check DbHandler Class)
 */
class User extends DbHandler
{
    private $userId ;
    private $db;
    public $err_message = null;
    public function __construct($userId = null)
    {
        $this->userId = $userId;
        parent::__construct();
    }
    public function registerUser($name, $email,$password,$phone,$term,$address,$sex,$appId){

        try {
            $this->startTransaction();
            $chckAppId = $this->getOne("select id from user where appid = ?",array($appId));
            if($chckAppId != null){
                $this->err_message = "Application ID already exist";
                return false;
            }
            $chckInfo = $this->getOne("select id from userinfo where  email = ? or phone = ?",array($email,$phone));
            if($chckInfo != null){
                $this->err_message = "Either email or phone number already exist";
                return false;
            }
            $hashPassword = sha1($password);

            $userInfoId = $this->executeGetId("insert into userinfo (name, email, password, phone, term, address, sex) VALUES (?,?,?,?,?,?,?)",
            array($name, $email, $hashPassword, $phone, $term, $address, $sex));

            $userId = $this->executeGetId("insert into user ( userinfo_id, appid) values (?,?)", array($userInfoId, $appId));

            $this->commitTransaction();

            return $userId;
        }catch (Exception $e){
            $this->rollBack();
            $this->err_message = "Unable to register new user";
            return false;
        }

    }

    /**
     * @param $email
     * @param $password
     * @param $appid
     * @return bool
     *
     */
    public function login($email, $password, $appid){

        $user = $this->getOne("select u.id, ui.password, appid from userinfo ui inner join user u on ui.id = u.userinfo_id where email = ?",array($email));
        if($user == null){
            $this->err_message = "Email does not exist";
            return false;
        }

        if(sha1($password) !== $user['password']){
            $this->err_message = "Incorrect password";
            return false;
        }

        $this->execute("update user set appid = ? where id = ?",array($appid,$user["id"]));
        return $user["id"];
    }


}