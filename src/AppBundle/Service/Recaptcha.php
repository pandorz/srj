<?php

namespace AppBundle\Service;

class Recaptcha
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $environnement;

    /**
     * Code of captach fail
     */
    const EXCEPTION_CODE_GOOGLE_RECAPTCHA_FAILED = 100;

    /**
     * Recaptcha constructor.
     * @param string $url
     * @param string $token
     * @param string $environnement
     */
    public function __construct($url, $token, $environnement)
    {
        $this->url           = $url;
        $this->token         = $token;
        $this->environnement = $environnement;
    }

    /**
     * @param $response
     * @return bool
     * @throws \Exception
     */
    public function check($response)
    {
        if (!hash_equals($this->environnement, 'prod')) {
            return true;
        }

        if (empty($response)) {
            throw new \Exception('Error on recaptcha response');
        }

        $params = array('secret'    => $this->token,
                        'response'  => $response);

        $url = $this->url.'?'. http_build_query($params);


        if (function_exists('curl_version')) {
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt(
                $curl,
                CURLOPT_USERAGENT,
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.12; rv:52.0) Gecko/20100101 Firefox/52.0'
            );

            $response = curl_exec($curl);
        } else {
            $response = file_get_contents($url);
        }

        $json = json_decode($response);

        if (empty($json)) {
            throw new \Exception('Error on recaptcha verify curl');
        }

        if ($json->success == false) {
            throw new \Exception('Detected as robot', self::EXCEPTION_CODE_GOOGLE_RECAPTCHA_FAILED);
        }

        return true;
    }

    /**
     * @return int
     */
    public function getCodeRecaptchaFailed()
    {
        return self::EXCEPTION_CODE_GOOGLE_RECAPTCHA_FAILED;
    }
}
