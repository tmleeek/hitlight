<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 8/18/16
 * Time: 10:56 AM
 */
class GhoSter_SocialCount_Model_Google_Client
{

    const XML_PATH_ENABLED = 'social_share_count/google/active';

    const XML_PATH_API_KEY = 'social_share_count/google/api_key';

    const COUNT_SERVICE_URI = 'https://clients6.google.com/rpc';

    protected $url = null;

    protected $shareCount = null;

    protected $method = 'pos.plusones.get';


    /**
     * Create Count Url
     *
     * @return string
     */
    public function createCountUrl()
    {
        $url =
            self::COUNT_SERVICE_URI . '?' .
            http_build_query(
                array(
                    'key' => $this->_getAPIKey()
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

    public function getParameterPost()
    {
        $config = array(
            'method' => $this->method,
            'id' => 'p',
            'params' => array(
                'nolog' => true,
                'id' => $this->url,
                'source' => 'widget',
                'userId' => '@viewer',
                'groupId' => '@self'
            ),
            'jsonrpc' => '2.0',
            'key' => 'p',
            'apiVersion' => 'v1'
        );

        return $config;
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
            'POST',
            array(
                'key' => $this->_getAPIKey()
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
     * @throws GhoSter_SocialCount_Model_Google_Exception
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

        $client->setRawData(json_encode($this->getParameterPost()), 'application/json');

        $response = $client->request($method);

        GhoSter_SocialCount_Helper_Data::log($response->getStatus() . ' - ' . $response->getBody());

        $decodedResponse = json_decode($response->getBody());

        if ($response->isError()) {
            $status = $response->getStatus();
            if (($status == 400 || $status == 401)) {
                if (isset($decodedResponse->error->message)) {
                    $message = $decodedResponse->error->message;
                } else {
                    $message = Mage::helper('ghoster_socialcount')
                        ->__('Unspecified error occurred.');
                }

                //throw new GhoSter_SocialCount_Model_Google_Exception($message);

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


    protected function _getAPIKey()
    {
        return $this->_getStoreConfig(self::XML_PATH_API_KEY);
    }

    protected function _getStoreConfig($xmlPath)
    {
        return Mage::getStoreConfig($xmlPath, Mage::app()->getStore()->getId());
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
