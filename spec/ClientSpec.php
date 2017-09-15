<?php

namespace spec\Webgriffe\LibTriveneto;

use PhpSpec\ObjectBehavior;
use Psr\Log\LoggerInterface;
use Webgriffe\LibTriveneto\NotificationMessage\Result\NotificationErrorResult;
use Webgriffe\LibTriveneto\PaymentInit\Sender\RequestSenderInterface;
use Webgriffe\LibTriveneto\PaymentInit\Result;

class ClientSpec extends ObjectBehavior
{
    public function it_is_initializable(RequestSenderInterface $sender, LoggerInterface $logger)
    {
        $this->beConstructedWith($sender, $logger);
        $this->shouldHaveType('Webgriffe\LibTriveneto\Client');
    }

    public function it_throws_exception_if_user_is_missing(RequestSenderInterface $sender, LoggerInterface $logger)
    {
        $this->beConstructedWith($sender, $logger);
        $this->shouldThrow(new \InvalidArgumentException("Missing user id"))->duringInit('', 'pwd', 'url', 1, 'signsecret');
    }

    public function it_throws_exception_if_password_is_missing(RequestSenderInterface $sender, LoggerInterface $logger)
    {
        $this->beConstructedWith($sender, $logger);
        $this->shouldThrow(new \InvalidArgumentException("Missing password"))->duringInit('a', '', 'url', 1, 'signsecret');
    }

    public function it_throws_exception_if_init_url_is_missing(RequestSenderInterface $sender, LoggerInterface $logger)
    {
        $this->beConstructedWith($sender, $logger);
        $this->shouldThrow(new \InvalidArgumentException("Missing payment init URL"))->duringInit('a', 'pwd', '', 1, 'signsecret');
    }

    public function it_throws_exception_if_action_is_missing(RequestSenderInterface $sender, LoggerInterface $logger)
    {
        $this->beConstructedWith($sender, $logger);
        $this->shouldThrow(new \InvalidArgumentException("Missing payment action (accounting type)"))
            ->duringInit('a', 'pwd', 'url', '', 'signsecret');
    }

    public function it_throws_exception_if_action_is_not_a_valid_value(RequestSenderInterface $sender, LoggerInterface $logger)
    {
        $this->beConstructedWith($sender, $logger);
        $this->shouldThrow(new \InvalidArgumentException('Invalid payment action specified: a'))
            ->duringInit('a', 'pwd', 'url', 'a', 'signsecret');
    }

    public function it_throws_exception_if_sign_secret_is_missing(RequestSenderInterface $sender, LoggerInterface $logger)
    {
        $this->beConstructedWith($sender, $logger);
        $this->shouldThrow(new \InvalidArgumentException('Sign secret must be at least 8 chars long'))
            ->duringInit('a', 'pwd', 'url', 1, '');
    }

    public function it_throws_exception_if_sign_secret_is_too_short(RequestSenderInterface $sender, LoggerInterface $logger)
    {
        $this->beConstructedWith($sender, $logger);
        $this->shouldThrow(new \InvalidArgumentException('Sign secret must be at least 8 chars long'))
            ->duringInit('a', 'pwd', 'url', 1, 'abc');
    }

    public function it_throws_exception_if_init_was_not_called_before_calling_paymentinit(RequestSenderInterface $sender, LoggerInterface $logger)
    {
        $this->beConstructedWith($sender, $logger);
        $this->shouldThrow(new \Exception("Init was not called"))
            ->duringPaymentInit('10001', 100, 978, 'ITA', 'http://notify.com', 'http://error.com');
    }

    public function it_throws_exception_if_transaction_id_is_missing(RequestSenderInterface $sender, LoggerInterface $logger)
    {
        $this->constructAndInit($sender, $logger);
        $this->shouldThrow(new \InvalidArgumentException('No transaction id provided'))
            ->duringPaymentInit('', 100, 978, 'ITA', 'http://notify.com', 'http://error.com');
    }

    public function it_throws_exception_if_amount_is_missing(RequestSenderInterface $sender, LoggerInterface $logger)
    {
        $this->constructAndInit($sender, $logger);
        $this->shouldThrow(new \InvalidArgumentException('Invalid amount'))
            ->duringPaymentInit('100001', '', 978, 'ITA', 'http://notify.com', 'http://error.com');
    }

    public function it_throws_exception_if_amount_is_non_numeric(RequestSenderInterface $sender, LoggerInterface $logger)
    {
        $this->constructAndInit($sender, $logger);
        $this->shouldThrow(new \InvalidArgumentException('Invalid amount'))
            ->duringPaymentInit('100001', 'a', 978, 'ITA', 'http://notify.com', 'http://error.com');
    }

    public function it_throws_exception_if_amount_is_negative(RequestSenderInterface $sender, LoggerInterface $logger)
    {
        $this->constructAndInit($sender, $logger);
        $this->shouldThrow(new \InvalidArgumentException('Invalid amount'))
            ->duringPaymentInit('100001', -10, 978, 'ITA', 'http://notify.com', 'http://error.com');
    }

    public function it_throws_exception_if_amount_is_zero(RequestSenderInterface $sender, LoggerInterface $logger)
    {
        $this->constructAndInit($sender, $logger);
        $this->shouldThrow(new \InvalidArgumentException('Invalid amount'))
            ->duringPaymentInit('100001', 0, 978, 'ITA', 'http://notify.com', 'http://error.com');
    }

    public function it_throws_exception_if_amount_has_more_than_2_decimal_places(RequestSenderInterface $sender, LoggerInterface $logger)
    {
        $this->constructAndInit($sender, $logger);
        $this->shouldThrow(new \InvalidArgumentException('Invalid amount'))
            ->duringPaymentInit('100001', 10.123, 978, 'ITA', 'http://notify.com', 'http://error.com');
    }

    public function it_throws_exception_if_currency_is_missing(RequestSenderInterface $sender, LoggerInterface $logger)
    {
        $this->constructAndInit($sender, $logger);
        $this->shouldThrow(new \InvalidArgumentException('Invalid currency'))
            ->duringPaymentInit('100001', 100, '', 'ITA', 'http://notify.com', 'http://error.com');
    }

    public function it_throws_exception_if_currency_is_invalid(RequestSenderInterface $sender, LoggerInterface $logger)
    {
        $this->constructAndInit($sender, $logger);
        $this->shouldThrow(new \InvalidArgumentException('Invalid currency'))
            ->duringPaymentInit('100001', 100, '', 'ITA', 'http://notify.com', 'http://error.com');
    }

    public function it_throws_exception_if_language_is_missing(RequestSenderInterface $sender, LoggerInterface $logger)
    {
        $this->constructAndInit($sender, $logger);
        $this->shouldThrow(new \InvalidArgumentException('Invalid language'))
            ->duringPaymentInit('100001', 100, 978, '', 'http://notify.com', 'http://error.com');
    }

    public function it_throws_exception_if_language_is_invalid(RequestSenderInterface $sender, LoggerInterface $logger)
    {
        $this->constructAndInit($sender, $logger);
        $this->shouldThrow(new \InvalidArgumentException('Invalid language'))
            ->duringPaymentInit('100001', 100, 978, 'ABC', 'http://notify.com', 'http://error.com');
    }

    public function it_throws_exception_if_notify_url_is_missing(RequestSenderInterface $sender, LoggerInterface $logger)
    {
        $this->constructAndInit($sender, $logger);
        $this->shouldThrow(new \InvalidArgumentException('Missing notify URL'))
            ->duringPaymentInit('100001', 100, 978, 'ITA', '', 'http://error.com');
    }

    public function it_throws_exception_if_error_url_is_missing(RequestSenderInterface $sender, LoggerInterface $logger)
    {
        $this->constructAndInit($sender, $logger);
        $this->shouldThrow(new \InvalidArgumentException('Missing error URL'))
            ->duringPaymentInit('100001', 100, 978, 'ITA', 'http://notify.com', '');
    }

    public function it_does_not_block_sender_exceptions(RequestSenderInterface $sender, LoggerInterface $logger)
    {
        $queryString = 'id=a&password=pwd&action=1&amt=100.00&currencycode=978&langid=ITA&responseURL=http%3A%2F%2Fnotify.com&errorURL=http%3A%2F%2Ferror.com&trackid=100001&udf1=apwd1100.00978ITA100001_40c7de6cad5c34abd935761832ebbbd9c735b40b';
        $sender->send('url', $queryString)->willThrow(new \Exception('Test error'));

        $this->constructAndInit($sender, $logger);
        $this->shouldThrow(new \Exception('Test error'))
            ->duringPaymentInit('100001', 100, 978, 'ITA', 'http://notify.com', 'http://error.com');
    }

    public function it_throws_exception_when_gateway_reports_an_error(RequestSenderInterface $sender, LoggerInterface $logger)
    {
        $queryString = 'id=a&password=pwd&action=1&amt=100.00&currencycode=978&langid=ITA&responseURL=http%3A%2F%2Fnotify.com&errorURL=http%3A%2F%2Ferror.com&trackid=100001&udf1=apwd1100.00978ITA100001_40c7de6cad5c34abd935761832ebbbd9c735b40b';
        $sender->send('url', $queryString)->willReturn('!ERROR!PY10000 Internal error');

        $this->constructAndInit($sender, $logger);
        $this->shouldThrow(new \Exception('PY10000 Internal error'))
            ->duringPaymentInit('100001', 100, 978, 'ITA', 'http://notify.com', 'http://error.com');
    }

    public function it_generates_signs_and_sends_paymentinit_message(RequestSenderInterface $sender, LoggerInterface $logger)
    {
        $queryString = 'id=a&password=pwd&action=1&amt=100.00&currencycode=978&langid=ITA&responseURL=http%3A%2F%2Fnotify.com&errorURL=http%3A%2F%2Ferror.com&trackid=100001&udf1=apwd1100.00978ITA100001_40c7de6cad5c34abd935761832ebbbd9c735b40b';
        $sender->send('url', $queryString)->willReturn('123456:http://redirect.com');

        $this->constructAndInit($sender, $logger);
        /** @var Result $initResult */
        $initResult = $this->paymentInit('100001', 100, 978, 'ITA', 'http://notify.com', 'http://error.com');
        $initResult->getUrl()->shouldBe('http://redirect.com?PaymentID=123456');
        $initResult->getPaymentId()->shouldBe('123456');
    }

    public function it_throws_exception_if_init_was_not_called_before_calling_paymentverify(RequestSenderInterface $sender, LoggerInterface $logger)
    {
        $this->beConstructedWith($sender, $logger);
        $this->shouldThrow(new \Exception("Init was not called"))->duringPaymentVerify(
            [
                'paymentid' => '123456',
                'tranid' => '789012',
                'result' => 'APPROVED',
                'auth' => '1234567890',
                'postdate' => '0829',
                'trackid' => '100001',
                'ref' => '0987654321',
                'udf1' => '',
                'payinst'   => 'CC',
                'ipcountry' => 'IT',
            ]
        );
    }

    public function it_throws_exception_if_signature_is_invalid(RequestSenderInterface $sender, LoggerInterface $logger)
    {
        $this->constructAndInit($sender, $logger);

        $this->shouldThrow(new \Exception('Signature is invalid'))->duringPaymentVerify(
            [
                'paymentid' => '123',
                'tranid'    => '456',
                'result'    => 'APPROVED',
                'auth'      => '123456',
                'postdate'  => '0829',
                'trackid'   => '100001',
                'ref'       => '0987654321',
                'udf1'      => 'apwd1100.00978ITA100001_40c7de6cad5c34abd935761832ebbbd9c735b40a',
                'payinst'   => 'CC',
                'ipcountry' => 'IT',
            ]
        );
    }

    public function it_returns_false_on_a_failure_notification(RequestSenderInterface $sender, LoggerInterface $logger)
    {
        $this->constructAndInit($sender, $logger);

        $this->paymentVerify(
            [
                'paymentid' => '123',
                'tranid'    => '456',
                'result'    => 'NOT APPROVED',
                'auth'      => '123456',
                'postdate'  => '0829',
                'trackid'   => '100001',
                'ref'       => '0987654321',
                'udf1'      => 'apwd1100.00978ITA100001_40c7de6cad5c34abd935761832ebbbd9c735b40b',
                'payinst'   => 'CC',
                'ipcountry' => 'IT',
            ]
        )->getIsSuccess()->shouldBe(false);
    }

    public function it_returns_true_on_an_approved_notification(RequestSenderInterface $sender, LoggerInterface $logger)
    {
        $this->constructAndInit($sender, $logger);

        $this->paymentVerify(
            [
                'paymentid' => '123',
                'tranid'    => '456',
                'result'    => 'APPROVED',
                'auth'      => '123456',
                'postdate'  => '0829',
                'trackid'   => '100001',
                'ref'       => '0987654321',
                'udf1'      => 'apwd1100.00978ITA100001_40c7de6cad5c34abd935761832ebbbd9c735b40b',
                'payinst'   => 'CC',
                'ipcountry' => 'IT',
            ]
        )->getIsSuccess()->shouldBe(true);
    }

    public function it_returns_true_on_a_captured_notification(RequestSenderInterface $sender, LoggerInterface $logger)
    {
        $this->constructAndInit($sender, $logger);

        $this->paymentVerify(
            [
                'paymentid' => '123',
                'tranid'    => '456',
                'result'    => 'CAPTURED',
                'auth'      => '123456',
                'postdate'  => '0829',
                'trackid'   => '100001',
                'ref'       => '0987654321',
                'udf1'      => 'apwd1100.00978ITA100001_40c7de6cad5c34abd935761832ebbbd9c735b40b',
                'payinst'   => 'CC',
                'ipcountry' => 'IT',
            ]
        )->getIsSuccess()->shouldBe(true);
    }

    public function it_throws_verificationfailedexception_when_gateway_reports_an_error(RequestSenderInterface $sender, LoggerInterface $logger)
    {
        $this->constructAndInit($sender, $logger);

        $result = $this->paymentVerify(
            [
                'paymentid' => '123',
                'error'     => 'code',
                'errorText' => 'desc',
            ]
        );

        $result->shouldBeAnInstanceOf(NotificationErrorResult::class);
        $result->getPaymentId()->shouldBe('123');
        $result->getErrorCode()->shouldBe('code');
        $result->getErrorDescription()->shouldBe('desc');
    }

    /**
     * @param RequestSenderInterface $sender
     * @param LoggerInterface $logger
     */
    private function constructAndInit(RequestSenderInterface $sender, LoggerInterface $logger)
    {
        $this->beConstructedWith($sender, $logger);
        $this->init('a', 'pwd', 'url', 1, 'signsecret');
    }
}
