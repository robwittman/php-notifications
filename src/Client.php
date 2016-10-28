<?php

namespace Notifier;

use Notifier\Exception\InvalidAuthorizationException;
use Notifier\Exception\InvalidResponseException;

class Client {
    /**
     * Base URL of the server
     * @var string
     */
    protected $base_uri;

    /**
     * Authentication Token
     * @var string
     */
    protected $token;

    /**
     * Create a new Client
     * @param string $base_uri
     * @param string $token
     */
    public function __construct($base_uri, $token) {
        $this->base_uri = $base_uri;
        $this->token = $token;
    }

    /**
     * Mae a GET request
     * @param string $path
     * @return boolean
     */
    public function get($path) {
        return $this->call($path);
    }

    /**
     * Make a POST request
     * @param  string $path
     * @param  array $params
     * @param  array $headers
     * @return boolean
     */
    public function post($path, $params, $headers) {
        return $this->call($path, 'POST', $params, $headers);
    }

    /**
     * Make a PUT request
     * @param  string $path
     * @return boolean
     */
    public function put($path) {
        return $this->call($path, 'PUT');
    }

    /**
     * Wrapper method for using curl
     * @param  string $path
     * @param  string $method
     * @param  array $params
     * @param  array $headers
     * @return boolean
     */
    public function call($path, $method = 'GET', array $params = [], array $headers = []) {
        error_log(json_encode(func_get_args()));
        $full_path = "{$this->base_uri}/{$path}";//$this->base_uri.$path;
        $curl = curl_init($full_path);
        if($curl === FALSE) {
            throw new \Exception('cURL failed to initialize');
        }
        if($method === 'POST') {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
        } else if($method === 'PUT') {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        // Add our Auth token for all requests
        $headers['X-AUTH-TOKEN'] = $this->token;

        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->prepHeaders($headers));
        $res = curl_exec($curl);

        if($res === FALSE) {
            throw new \Exception(curl_error($curl), curl_errno($curl));
        }

        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        switch($code) {
            case 401:
                throw new InvalidAuthorizationException("X-AUTH-TOKEN header either missing or contains wrong key");
                break;
            case 400:
                throw new \Exception("There was an error wih your request");
                break;
            case 404:
                throw new \Exception("URL '{$full_path}' Not Found");
                break;
        }
        $result = json_decode($res);
        return is_null($result) ? true : $result;
    }

    /**
     * Preapre headers for a cURL request
     *
     * Takes an associative array and converts to '$key: $value'
     *
     * @param  array $headers Associative array of header values
     * @return array
     */
    protected function prepHeaders(array $headers = array()) {
        $new = [];

        foreach($headers as $key => $value) {
            $new[] = "{$key}: {$value}";
        };

        return $new;
    }

}
