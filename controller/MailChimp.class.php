<?php

/*
 * 
 * MailChimp Subscribe PHP Class Form 
 * 
 * Let public visitors to subscribe your newsletter 
 * 
 * PHP Version 5.x
 *
 * Author Tatwerat-Team 
 * 
 * Author-Account http://themeforest.net/user/tatwerat-team 
 * 
 * Version 1.0
 *
 */

class MailChimp_API extends AH_Model {

    public $Key;
    public $ListID;
    public $Error;
    public $Email;
    public $FName;
    public $LName;
    public $Status = 'subscribed';
    public $FullData;

    public function __construct($API_Key, $List_ID, $Full_Data = TRUE) {
        parent::__construct();
        $this->Key = $API_Key;
        $this->ListID = $List_ID;
        $this->FullData = $Full_Data;
        add_action('ajax', array($this, 'add_subscribe'));
    }

    public function add_subscribe() {
        if ($this->request->http_isset('add_subscribe', 'post')) {
            $this->subscribed('', '', $this->request->http_post('email'));
            echo $this->message();
        }
    }

    public function subscribed($fname, $lname, $email) {
        $this->FName = $fname;
        $this->LName = $lname;
        $this->Email = $email;
        $this->message();
        if (!$this->Error)
            $this->curlData($this->apiUrl(), $this->Key, $this->jsonData(), 'PUT');
    }

    public function list_count() {
        $apiKey = $this->Key;
        $listId = $this->ListID;
        $memberId = $memberId = md5(strtolower($this->Email));
        $getapi = substr($this->escape($apiKey), strpos($this->escape($apiKey), '-') + 1);
        return 'https://' . $this->escape($getapi) . '.api.mailchimp.com/3.0/lists/d3a1b91aa7/members?offset=5&count=10';
    }

    public function apiUrl() {
        $apiKey = $this->Key;
        $listId = $this->ListID;
        $memberId = $memberId = md5(strtolower($this->Email));
        $getapi = substr($this->escape($apiKey), strpos($this->escape($apiKey), '-') + 1);
        return 'https://' . $this->escape($getapi) . '.api.mailchimp.com/3.0/lists/' . $this->escape($listId) . '/members/' . $this->escape($memberId);
    }

    public function jsonData() {
        return json_encode(array(
            'email_address' => $this->escape($this->Email),
            'status' => $this->escape($this->Status),
            'merge_fields' => array(
                'FNAME' => $this->escape($this->FName),
                'LNAME' => $this->escape($this->LName)
            )
        ));
    }

    public function curlData($url, $apiKey, $json, $type, $get = FALSE) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($get)
            echo var_dump(json_decode($result));
        else
            $this->Error = ($httpCode != 200) ? "[error-" . $httpCode . "]" : '';
    }

    public function validate() {
        if (empty($this->FName) and $this->FullData) {
            $this->Error = __('First name required');
        } elseif (empty($this->LName) and $this->FullData) {
            $this->Error = __('Last name required');
        } elseif (empty($this->Email)) {
            $this->Error = __('Email required');
        } elseif (!filter_var($this->Email, FILTER_VALIDATE_EMAIL)) {
            $this->Error = __('Invalid your email');
        }
    }

    public function escape($string) {
        return htmlspecialchars(trim($string), ENT_QUOTES, 'UTF-8');
    }

    public function message() {
        $this->validate();
        if (empty($this->Error)) {
            return __('Thank you for subscribe our newsletter');
        } else {
            if ($this->Error == "[error-0]") {
                return __('Bad request');
            } elseif ($this->Error == "[error-400]") {
                return __('Invalid your email');
            } elseif ($this->Error == "[error-401]") {
                return __('Invalid API key');
            } elseif ($this->Error == "[error-404]") {
                return __('Invalid list ID');
            }
        }
    }

}

$MailChimp_API = new MailChimp_API(get_option('MailChimp_API_KEY'), get_option('MailChimp_List_ID'), FALSE);
