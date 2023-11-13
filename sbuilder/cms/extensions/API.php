<?php
class API
{
    private $curl;

    private $curlOptions;

    public function __construct()
    {
        $this->curl = curl_init();

        $this->curlOptions = [
            CURLOPT_URL            => '{API_URL}',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_USERPWD        => '{USERPWD}',
        ];
    }

    public static function make()
    {
        return new self;
    }

    private function setupCurlOptions()
    {
        curl_setopt_array($this->curl, $this->curlOptions);
    }

    public function exec()
    {
        $this->setupCurlOptions();
        $response = curl_exec($this->curl);
        curl_close($this->curl);

        return $response;
    }
}
