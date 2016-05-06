<?php

class Cache
{
    public $path;

    public function __construct()
    {
        $this->path = __DIR__.'/../cache/';
    }

    public function array_to_key($array = array())
    {
        return serialize($array);
    }

    public function get($key)
    {
        // Convert to string
        if(is_array($key))
            $key = $this->array_to_key($key);

        $key  = md5($key);
        $path = $this->path.$key;

        // Test file
        if(file_exists($path))
        {
            $content = file_get_contents($path);
            return json_decode($content);
        }

        return false;
    }

    public function set($key, $value)
    {
        // Convert to string
        if(is_array($key))
            $key = $this->array_to_key($key);

        $key  = md5($key);
        $path = $this->path.$key;
        $value = json_encode($value);

        file_put_contents($path, $value);

        return true;
    }
}
