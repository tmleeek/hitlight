<?php

/**
 * Created by PhpStorm.
 * Magento
 * Date: 8/17/16
 * Time: 3:58 PM
 */
class GhoSter_SocialCount_Model_Facebook_Client
{
    const COUNT_SERVICE_URI = 'https://graph.facebook.com';

    protected $url = null;

    protected $shareCount = null;


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
                    'id' => Mage::getUrl('', array(
                        '_current' => true,
                        '_use_rewrite' => true
                    ))
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
                'id' => $this->url
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
     * @throws GhoSter_SocialCount_Model_Facebook_Exception
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

                //throw new GhoSter_SocialCount_Model_Facebook_Exception($message);

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
