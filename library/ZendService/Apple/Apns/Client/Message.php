<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @category   ZendService
 * @package    ZendService_Apple
 * @subpackage Apns
 */

namespace ZendService\Apple\Apns\Client;

use ZendService\Apple\Exception;
use ZendService\Apple\Apns\Message as ApnsMessage;
use ZendService\Apple\Apns\Response\Message as MessageResponse;

/**
 * Message Client
 *
 * @category   ZendService
 * @package    ZendService_Apple
 * @subpackage Apns
 */
class Message extends AbstractClient
{
    /**
     * APNS URIs
     * @var array
     */
    protected $uris = array(
        'ssl://gateway.sandbox.push.apple.com:2195',
        'ssl://gateway.push.apple.com:2195',
    );

    /**
     * Send Message
     *
     * @param  ZendService\Apple\Apns\Message          $message
     * @return ZendService\Apple\Apns\Response\Message
     */
    public function send(ApnsMessage $message)
    {
        if (!$this->isConnected()) {
            throw new Exception\RuntimeException('You must first open the connection by calling open()');
        }

        $ret = $this->write($message->getPayloadJson());
        if ($ret === false) {
            throw new Exception\RuntimeException('Server is unavailable; please retry later');
        }
        $messageResponse = $this->read();

        if ($ret == 0 && $messageResponse == '') {
            return false;
        }


        return new MessageResponse($messageResponse);
    }


    public function sendPayload($payload)
    {
        if (!$this->isConnected()) {
            throw new Exception\RuntimeException('You must first open the connection by calling open()');
        }

        $ret = $this->write($payload);
        if ($ret === false) {
            throw new Exception\RuntimeException('Server is unavailable; please retry later');
        }
        $messageResponse = $this->read();

        if ($ret == 0 && $messageResponse == '') {
            return false;
        }


        return new MessageResponse($messageResponse);
    }
}
