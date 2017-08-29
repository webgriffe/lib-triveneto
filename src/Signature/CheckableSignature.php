<?php
/**
 * Created by PhpStorm.
 * User: andrea
 * Date: 29/08/17
 * Time: 17.07
 */

namespace Webgriffe\LibTriveneto\Signature;

interface CheckableSignature extends ComputableSignature
{
    /**
     * @return string
     */
    public function getSignature();
}