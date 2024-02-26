<?php

namespace Sms;

use InvalidArgumentException;

class Http
{
    public function __construct(
        public string $urlBase,
        public int $timeout,
        public array $headers
    ){ }

    public function getBasedURL($uri, $params = null)
    {
        if (!$uri && !$params) {
            throw new InvalidArgumentException("function needs at least one argument");
        }

        $url = rtrim($this->urlBase, '/');

        $url .= '/' . ltrim($uri, '/');

        if ($params) {
            $query = http_build_query($params);
            $url .= "?" . $query;
        }

        return $url;
    }

    public function request(string $method = 'GET', string $url = '', array $data = [], array $params = [], array $headers = [])
    {
        if( !$headers || count( $headers ) < 1 ){
            $headers = ['Accept: application/json', 'Content-Type: application/json'];
        }
        $headers = array_merge($this->headers, $headers);

        $handler = curl_init();
        curl_setopt($handler, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($handler, CURLOPT_HEADER, false);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handler, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($handler, CURLOPT_CONNECTTIMEOUT, $this->timeout);
        curl_setopt($handler, CURLOPT_URL, $this->getBasedURL($url, $params));

        if( $method == 'POST' ){
            curl_setopt($handler, CURLOPT_POST, true);
            curl_setopt($handler, CURLOPT_POSTFIELDS, json_encode($data));
        }
        else{
            curl_setopt($handler, CURLOPT_HTTPGET, true);
        }
        $response = curl_exec($handler);
        if ($response === false)
            throw new \HttpException(curl_error($handler));

        curl_close($handler);

        return $response;
    }

    public function get(string $url, array $params = [], $headers = [])
    {
        return $this->request(url: $url, params: $params, headers: $headers);
    }

    public function post(string $url, array $data = [], $headers = [])
    {
        return $this->request(method: 'POST', url: $url, data: $data, headers: $headers);
    }
}