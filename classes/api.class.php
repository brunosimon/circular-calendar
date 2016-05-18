<?php

require_once __DIR__.'/cache.class.php';

class Api
{
    public $cache_active = false;

    private $cache = null;
    public  $token = null;

    public function __construct($cache_active = false)
    {
        $this->cache_active = $cache_active;
        $this->cache        = new Cache();
    }

    public function call($url,$parameters = array(),$post = false,$auth = null)
    {
        $data = null;

        // Cache
        if($this->cache_active)
        {
            $cache_key = array($url,$parameters,$post,$auth);
            $data      = $this->cache->get($cache_key);

            if($data)
                return $data;
        }

        // Add token
        if($this->token != null && empty($parameters['token']))
            $parameters['access_token'] = $this->token;

        // No cache
        if(!$data)
        {
            // Add GET parameters
            if(!$post)
                $url = $url.'?'.http_build_query($parameters);

            // Init curl
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

            // Set post
            if( $post )
            {
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($parameters));
            }

            // Set oauth
            if($auth != null)
            {
                curl_setopt($curl, CURLOPT_USERPWD, $auth);
                curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            }

            // Execute curl
            $data = curl_exec($curl);
            curl_close($curl);

            // Json decode
            $data = json_decode($data);

            // Save in cache
            if($this->cache_active)
                $this->cache->set($cache_key,$data);

            // Return
            return $data;
        }
    }
}
