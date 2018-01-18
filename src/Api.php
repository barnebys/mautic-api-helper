<?php

namespace BarnebysMautic;

use BarnebysMautic\Exception\ContactNotFoundException;
use Mautic\Api\Api as BaseApi;

class Api
{

    private static $url;

    public static function setBaseUrl($url)
    {
        self::$url = $url;
    }

    /**
     * @return BaseApi
     *
     * @throws Exception\AuthInstanceException
     */
    private static function getApiInstance()
    {
        $auth = Auth::getInstance();

        return new BaseApi($auth->getMauticAuth(), self::$url);
    }

    /**
     * @param string $mail
     * @return integer
     *
     * @throws ContactNotFoundException
     * @throws Exception\AuthInstanceException
     * @throws \Exception
     */
    public static function getContactIdByMail($mail)
    {
        $api = self::getApiInstance();

        $parameters = [
            'search' => $mail,
            'limit' => 1
        ];

        $data = $api->makeRequest('contacts', $parameters);
        $contacts = $data['contacts'];
        if(sizeof($contacts) > 0){
            return (int) current($contacts)['id'];
        }

        throw new ContactNotFoundException();
    }

    /**
     * @param string $email
     * @param integer $templateId
     * @param array $tokens
     * @param boolean $html
     *
     * @return array
     *
     * @throws ContactNotFoundException
     * @throws Exception\AuthInstanceException
     * @throws \Exception
     */
    public static function sendToLead($email, $templateId, array $tokens = [], $html = false)
    {
        return self::sendToContact($email, $templateId, $tokens, $html);
    }

    /**
     * @param string $email
     * @param integer $templateId
     * @param array $tokens
     * @param boolean $html
     *
     * @return array
     *
     * @throws ContactNotFoundException
     * @throws Exception\AuthInstanceException
     * @throws \Exception
     */
    public static function sendToContact($email, $templateId, array $tokens = [], $html = false)
    {
        if (!isset($tokens['tokens'])) {
            $tokens = ['tokens' => $tokens];
        }

        $contactId = self::getContactIdByMail($email);

        $api = self::getApiInstance();

        $baseUrl = sprintf('emails/%s/contact/%s/send', $templateId, $contactId);
        $htmlUrl = sprintf('emails/%s/contact/%s/send-content', $templateId, $contactId);

        return $api->makeRequest($html === true ? $htmlUrl : $baseUrl, $tokens, 'POST');
    }

}
