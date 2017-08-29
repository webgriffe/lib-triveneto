<?php
/**
 * Created by PhpStorm.
 * User: andrea
 * Date: 29/08/17
 * Time: 17.09
 */

namespace Webgriffe\LibTriveneto\Signature;


interface ComputableSignature
{
    /**
     * @return string
     */
    public function getSignatureData();
}