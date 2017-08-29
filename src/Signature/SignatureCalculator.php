<?php
/**
 * Created by PhpStorm.
 * User: andrea
 * Date: 29/08/17
 * Time: 17.14
 */

namespace Webgriffe\LibTriveneto\Signature;

abstract class SignatureCalculator implements Signer, SignatureChecker
{
    protected $signSecret;

    public function __construct($signSecret)
    {
        $this->signSecret = $signSecret;
    }

    public function sign(Signable $signable)
    {
        //Add the signature string (minus the secret key) to the signature to allow one to see the data that made up the
        //signature itself t check it as much as possible.

        //This is still not a safe signature scheme, as there is no check on Triveneto's part. An attacker could,
        //theoretically, replace the amount in the PaymentInit request and not touch the signature, and it would all
        //work. The only defense against this is SSL.
        //Even if Triveneto sent back all of the data it used to generate the payment (amount, currency code, language
        //id etc.), as long as there is no signature check on Trivenetoìs side it remains possible to perform the attack
        //described above. So this signature is there just to make it more difficult to fake the server to server
        //message, not to make everything 100% secure.
        $signable->setSignature($this->computeSignature($signable));
    }

    public function checkSignature(CheckableSignature $signablecheckableSignature)
    {
        $computedSignature = $this->computeSignature($signablecheckableSignature);
        if (function_exists('hash_equals')) {
            return hash_equals($computedSignature, $signablecheckableSignature->getSignature());
        }

        //Not safe against timing attacks, but better than forcing the users to upgrade to a newer PHP version
        return strcmp($computedSignature, $signablecheckableSignature->getSignature()) === 0;
    }

    /**
     * @param ComputableSignature $signable
     * @return string
     */
    abstract protected function computeSignature(ComputableSignature $signable);
}
