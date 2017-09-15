<?php
/**
 * Created by PhpStorm.
 * User: andrea
 * Date: 29/08/17
 * Time: 14.54
 */

namespace Webgriffe\LibTriveneto\PaymentInit\Sender;

class RequestSender implements RequestSenderInterface
{
    /**
     * @param string $url
     * @param string $dataAsQueryString
     *
     * @return string
     * @throws \Exception
     */
    public function send($url, $dataAsQueryString)
    {
        $ch = curl_init($url);

        //Set http headers
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, 1);

        //Set data
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataAsQueryString);

        //Return the result with the return value of curl_exec()
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        //Go for it
        $result = curl_exec($ch);

        try {
            if ($result === false) {
                throw new \Exception('Error while trying to contact payment gateway: '. curl_error($ch));
            }

            return $result;
        } finally {
            curl_close($ch);
        }
    }
}
