<?php

class trello_api
{
    private $key;
    private $token;

    public function __construct()
    {
        setKey();
        setToken();
    }

    public function request($type, $request, $args = false)
    {
        if (!$args) {
            $args = array();
        } elseif (!is_array($args)) {
            $args = array($args);
        }

        if (strstr($request, '?')) {
            $url = 'https://api.trello.com/1/' . $request . '&key=' . $this->key . '&token=' . $this->token;
        } else {
            $url = 'https://api.trello.com/1/' . $request . '?key=' . $this->key . '&token=' . $this->token;
        }

        $c = curl_init();
        curl_setopt($c, CURLOPT_HEADER, 0);
        curl_setopt($c, CURLOPT_VERBOSE, 0);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_URL, $url);
        curl_setopt($c, CURLOPT_CAINFO, dirname(__FILE__) .  '/trello.com.crt');

        if (count($args)) curl_setopt($c, CURLOPT_POSTFIELDS, http_build_query($args));

        switch ($type) {
            case 'POST':
                curl_setopt($c, CURLOPT_POST, 1);
                break;
            case 'GET':
                curl_setopt($c, CURLOPT_HTTPGET, 1);
                break;
            default:
                curl_setopt($c, CURLOPT_CUSTOMREQUEST, $type);
        }

        $data = curl_exec($c);
        echo curl_error($c);
        curl_close($c);

        return json_decode($data);
    }
    private function setKey()
    {
      $this->key ='e880f8007c7f91327a12d4b9ae02ed8a';
    }
    private function setToken()
    {
      $this->token = 'Th443254213343';
    }
}
