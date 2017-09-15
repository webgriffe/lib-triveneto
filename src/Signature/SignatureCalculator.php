<?php
/**
 * Created by PhpStorm.
 * User: andrea
 * Date: 29/08/17
 * Time: 17.14
 */

namespace Webgriffe\LibTriveneto\Signature;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

abstract class SignatureCalculator implements Signer, SignatureChecker
{
    protected $signSecret;

    /**
     * @var LoggerInterface
     */
    protected $logger = null;

    public function __construct($signSecret, LoggerInterface $logger = null)
    {
        $this->signSecret = $signSecret;
        $this->logger = $logger;
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
        $signature = $this->computeSignature($signable);
        $this->log('Signing object. Computed signature: '.$signature);
        $signable->setSignature($signature);
    }

    public function checkSignature(CheckableSignature $signablecheckableSignature)
    {
        $receivedSignature = $signablecheckableSignature->getSignature();
        $this->log('Received signature: '.$receivedSignature);
        $computedSignature = $this->computeSignature($signablecheckableSignature);
        $this->log('Computed signature: '.$receivedSignature);

        if (function_exists('hash_equals')) {
            return hash_equals($computedSignature, $receivedSignature);
        }

        //Not safe against timing attacks, but better than forcing the users to upgrade to a newer PHP version
        $this->log('Function hash_equals() was not found. Falling back to strcmp()', LogLevel::WARNING);
        return strcmp($computedSignature, $receivedSignature) === 0;
    }

    /**
     * @param ComputableSignature $signable
     * @return string
     */
    abstract protected function computeSignature(ComputableSignature $signable);

    protected function log($message, $level = LogLevel::DEBUG)
    {
        if ($this->logger) {
            $this->logger->log($level, '[Lib Triveneto]: '.$message);
        }
    }
}
