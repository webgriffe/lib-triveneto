<?php
/**
 * Created by PhpStorm.
 * User: andrea
 * Date: 29/08/17
 * Time: 14.54
 */

namespace Webgriffe\LibTriveneto\PaymentInit;

class RequestSender
{
    public function post($url, $dataAsQueryString)
    {
        $ch = curl_init($url);

        //Set http headers
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_POST, 1);

        //Set data
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataAsQueryString);

        //Return the result with the return value of curl_exec()
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        //Go for it
        return curl_exec($ch);
    }
}
