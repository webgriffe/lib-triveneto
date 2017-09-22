<?php
/**
 * Created by PhpStorm.
 * User: andrea
 * Date: 29/08/17
 * Time: 17.04
 */

namespace Webgriffe\LibTriveneto\Signature;

interface SignatureChecker
{
    /**
     * @param CheckableSignature $checkableSignature
     * @return bool
     */
    public function checkSignature(CheckableSignature $checkableSignature);
}
