<?php

namespace spresnac\logcrawlerclient\Handler;

class CurlRequest
{
    const API_LOG_ROUTE = '/api/log';
    const CURL_TIME_OUT = 10;
    const CURL_USER_AGENT = 'Laravel/Logcrawler';

    /** @var string */
    private $key;

    /** @var string */
    private $host;

    /**
     * @param string $key
     * @param string $host
     */
    public function __construct(string $key, string $host)
    {
        $this->key = $key;
        $this->host = $host;
    }

    public function postToApi(array $data)
    {
        if (count($data) <= 0) {
            return;
        }
        if ($this->key === null) {
            return;
        }
        $dataEncoded = json_encode($data);
        $curlHandle = curl_init($this->host . self::API_LOG_ROUTE);
        curl_setopt($curlHandle, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Content-Type: application/json',
            'x-lc-key: ' . $this->key,
        ]);
        curl_setopt($curlHandle, CURLOPT_USERAGENT, 'Laravel/Logcrawler');
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_TIMEOUT, 10);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curlHandle, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curlHandle, CURLOPT_ENCODING, '');
        curl_setopt($curlHandle, CURLINFO_HEADER_OUT, true);
        curl_setopt($curlHandle, CURLOPT_POST, true);
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $dataEncoded);
        curl_exec($curlHandle);
    }
}
