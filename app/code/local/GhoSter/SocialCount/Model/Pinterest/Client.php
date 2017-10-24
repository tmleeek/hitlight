<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 8/18/16
 * Time: 9:15 AM
 */
class GhoSter_SocialCount_Model_Pinterest_Client
{
    const COUNT_SERVICE_URI = 'https://api.pinterest.com/v1/urls/count.json';

    protected $url = null;

    protected $shareCount = null;

    protected $callBack = 'countShare';


    /**
     * Create Count Url
     *
     * @return string
     */
    public function createCountUrl()
    {
        $url =
            self::COUNT_SERVICE_URI . '?'.
            http_build_query(
                array(
                    'url' => Mage::getUrl('', array(
                        '_current' => true,
                        '_use_rewrite' => true
                    )),
                    'callback' => $this->callBack
                )
            );

        return $url;
    }

    /**
     * Get Share Count Json
     *
     * @param $_url |string
     * @return mixed|string|void
     */
    public function getShareCount($_url)
    {

        if (empty($this->url)) {
            $this->url = $_url;
        }


        if (empty($this->shareCount)) {
            $this->fetchShareCount();
        }

        return json_encode($this->shareCount);
    }

    /**
     * Fetch Share Count
     *
     * @throws Exception
     */
    protected function fetchShareCount()
    {

        $response = $this->_httpRequest(
            self::COUNT_SERVICE_URI,
            'GET',
            array(
                'callback' => $this->callBack,
                'url' => $this->url,
            )
        );


        $response->created = time();

        $this->shareCount = $response;
    }


    /**
     * HTTP Request
     *
     * @param $url
     * @param string $method
     * @param array $params
     * @return array|mixed|object
     * @throws Exception
     * @throws GhoSter_SocialCount_Model_Pinterest_Exception
     */
    protected function _httpRequest($url, $method = 'GET', $params = array())
    {

        $client = new Zend_Http_Client($url, array('timeout' => 60));

        switch ($method) {
            case 'GET':
                $client->setParameterGet($params);
                break;
            case 'POST':
                $client->setParameterPost($params);
                break;
            case 'DELETE':
                break;
            default:
                throw new Exception(
                    Mage::helper('ghoster_socialcount')
                        ->__('Required HTTP method is not supported.')
                );
        }

        $response = $client->request($method);


        GhoSter_SocialCount_Helper_Data::log($response->getStatus() . ' - ' . $response->getBody());

        $body = preg_replace( '/^'. $this->callBack .'\((.*)\)$/', '\\1', $response->getBody() );

        $decodedResponse = json_decode($body);

        if ($response->isError()) {
            $status = $response->getStatus();
            if (($status == 400 || $status == 401)) {
                if (isset($decodedResponse->error->message)) {
                    $message = $decodedResponse->error->message;
                } else {
                    $message = Mage::helper('ghoster_socialcount')
                        ->__('Unspecified error occurred.');
                }

                //throw new GhoSter_SocialCount_Model_Pinterest_Exception($message);

            } else {
                $message = sprintf(
                    Mage::helper('ghoster_socialcount')
                        ->__('HTTP error %d occurred while issuing request.'),
                    $status
                );

                //throw new Exception($message);
            }
        }

        return $decodedResponse;
    }


    public function setShareCount($shareCount)
    {
        $this->shareCount = json_decode($shareCount);
    }


    public function getUrl()
    {
        return $this->url;
    }
}
