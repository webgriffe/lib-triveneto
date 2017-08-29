<?php

namespace spec\Webgriffe\LibTriveneto;

use PhpSpec\ObjectBehavior;
use Psr\Log\LoggerInterface;
use Webgriffe\LibTriveneto\PaymentInit\RequestSender;

class ClientSpec extends ObjectBehavior
{
    public function it_is_initializable(LoggerInterface $logger, RequestSender $sender)
    {
        $this->beConstructedWith($logger, $sender);
        $this->shouldHaveType('Webgriffe\LibTriveneto\Client');
    }

    public function it_throws_exception_if_user_is_missing(LoggerInterface $logger, RequestSender $sender)
    {
        $this->beConstructedWith($logger, $sender);
        $this->shouldThrow(new \InvalidArgumentException("Missing user id"))->duringInit('', 'pwd', 'url', 1, 'signsecret');
    }

    public function it_throws_exception_if_password_is_missing(LoggerInterface $logger, RequestSender $sender)
    {
        $this->beConstructedWith($logger, $sender);
        $this->shouldThrow(new \InvalidArgumentException("Missing password"))->duringInit('a', '', 'url', 1, 'signsecret');
    }

    public function it_throws_exception_if_init_url_is_missing(LoggerInterface $logger, RequestSender $sender)
    {
        $this->beConstructedWith($logger, $sender);
        $this->shouldThrow(new \InvalidArgumentException("Missing payment init URL"))->duringInit('a', 'pwd', '', 1, 'signsecret');
    }

    public function it_throws_exception_if_action_is_missing(LoggerInterface $logger, RequestSender $sender)
    {
        $this->beConstructedWith($logger, $sender);
        $this->shouldThrow(new \InvalidArgumentException("Missing payment action (accounting type)"))
            ->duringInit('a', 'pwd', 'url', '', 'signsecret');
    }

    public function it_throws_exception_if_action_is_not_a_valid_value(LoggerInterface $logger, RequestSender $sender)
    {
        $this->beConstructedWith($logger, $sender);
        $this->shouldThrow(new \InvalidArgumentException('Invalid payment action specified: a'))
            ->duringInit('a', 'pwd', 'url', 'a', 'signsecret');
    }

    public function it_throws_exception_if_sign_secret_is_missing(LoggerInterface $logger, RequestSender $sender)
    {
        $this->beConstructedWith($logger, $sender);
        $this->shouldThrow(new \InvalidArgumentException('Sign secret must be at least 8 chars long'))
            ->duringInit('a', 'pwd', 'url', 1, '');
    }

    public function it_throws_exception_if_sign_secret_is_too_short(LoggerInterface $logger, RequestSender $sender)
    {
        $this->beConstructedWith($logger, $sender);
        $this->shouldThrow(new \InvalidArgumentException('Sign secret must be at least 8 chars long'))
            ->duringInit('a', 'pwd', 'url', 1, 'abc');
    }

    public function it_throws_exception_if_init_was_not_called_before_calling_paymentinit(LoggerInterface $logger, RequestSender $sender)
    {
        $this->beConstructedWith($logger, $sender);
        $this->shouldThrow(new \Exception("Init was not called"))
            ->duringPaymentInit('10001', 100, 978, 'ITA', 'http://response.com', 'http://error.com');
    }

    public function it_throws_exception_if_transaction_id_is_missing(LoggerInterface $logger, RequestSender $sender)
    {
        $this->constructAndInit($logger, $sender);
        $this->shouldThrow(new \InvalidArgumentException('No transaction id provided'))
            ->duringPaymentInit('', 100, 978, 'ITA', 'http://response.com', 'http://error.com');
    }

    public function it_throws_exception_if_amount_is_missing(LoggerInterface $logger, RequestSender $sender)
    {
        $this->constructAndInit($logger, $sender);
        $this->shouldThrow(new \InvalidArgumentException('Invalid amount'))
            ->duringPaymentInit('100001', '', 978, 'ITA', 'http://response.com', 'http://error.com');
    }

    public function it_throws_exception_if_amount_is_non_numeric(LoggerInterface $logger, RequestSender $sender)
    {
        $this->constructAndInit($logger, $sender);
        $this->shouldThrow(new \InvalidArgumentException('Invalid amount'))
            ->duringPaymentInit('100001', 'a', 978, 'ITA', 'http://response.com', 'http://error.com');
    }

    public function it_throws_exception_if_amount_is_negative(LoggerInterface $logger, RequestSender $sender)
    {
        $this->constructAndInit($logger, $sender);
        $this->shouldThrow(new \InvalidArgumentException('Invalid amount'))
            ->duringPaymentInit('100001', -10, 978, 'ITA', 'http://response.com', 'http://error.com');
    }

    public function it_throws_exception_if_amount_is_zero(LoggerInterface $logger, RequestSender $sender)
    {
        $this->constructAndInit($logger, $sender);
        $this->shouldThrow(new \InvalidArgumentException('Invalid amount'))
            ->duringPaymentInit('100001', 0, 978, 'ITA', 'http://response.com', 'http://error.com');
    }

    public function it_throws_exception_if_amount_has_more_than_2_decimal_places(LoggerInterface $logger, RequestSender $sender)
    {
        $this->constructAndInit($logger, $sender);
        $this->shouldThrow(new \InvalidArgumentException('Invalid amount'))
            ->duringPaymentInit('100001', 10.123, 978, 'ITA', 'http://response.com', 'http://error.com');
    }

    public function it_throws_exception_if_currency_is_missing(LoggerInterface $logger, RequestSender $sender)
    {
        $this->constructAndInit($logger, $sender);
        $this->shouldThrow(new \InvalidArgumentException('Invalid currency'))
            ->duringPaymentInit('100001', 100, '', 'ITA', 'http://response.com', 'http://error.com');
    }

    public function it_throws_exception_if_currency_is_invalid(LoggerInterface $logger, RequestSender $sender)
    {
        $this->constructAndInit($logger, $sender);
        $this->shouldThrow(new \InvalidArgumentException('Invalid currency'))
            ->duringPaymentInit('100001', 100, '', 'ITA', 'http://response.com', 'http://error.com');
    }

    public function it_throws_exception_if_language_is_missing(LoggerInterface $logger, RequestSender $sender)
    {
        $this->constructAndInit($logger, $sender);
        $this->shouldThrow(new \InvalidArgumentException('Invalid language'))
            ->duringPaymentInit('100001', 100, 978, '', 'http://response.com', 'http://error.com');
    }

    public function it_throws_exception_if_language_is_invalid(LoggerInterface $logger, RequestSender $sender)
    {
        $this->constructAndInit($logger, $sender);
        $this->shouldThrow(new \InvalidArgumentException('Invalid language'))
            ->duringPaymentInit('100001', 100, 978, 'ABC', 'http://response.com', 'http://error.com');
    }

    public function it_throws_exception_if_success_url_is_missing(LoggerInterface $logger, RequestSender $sender)
    {
        $this->constructAndInit($logger, $sender);
        $this->shouldThrow(new \InvalidArgumentException('Missing success URL'))
            ->duringPaymentInit('100001', 100, 978, 'ITA', '', 'http://error.com');
    }

    public function it_throws_exception_if_error_url_is_missing(LoggerInterface $logger, RequestSender $sender)
    {
        $this->constructAndInit($logger, $sender);
        $this->shouldThrow(new \InvalidArgumentException('Missing error URL'))
            ->duringPaymentInit('100001', 100, 978, 'ITA', 'http://response.com', '');
    }

    public function it_does_not_block_sender_exceptions(LoggerInterface $logger, RequestSender $sender)
    {
        $queryString = 'id=a&password=pwd&action=1&amt=100.00&currencycode=978&langid=ITA&responseURL=http%3A%2F%2Fresponse.com&errorURL=http%3A%2F%2Ferror.com&trackid=100001&udf1=apwd1100.00978ITA100001%7C40c7de6cad5c34abd935761832ebbbd9c735b40b';
        $sender->post('url', $queryString)->willThrow(new \Exception('Test error'));

        $this->constructAndInit($logger, $sender);
        $this->shouldThrow(new \Exception('Test error'))
            ->duringPaymentInit('100001', 100, 978, 'ITA', 'http://response.com', 'http://error.com');
    }

    public function it_throws_exception_when_gateway_reports_an_error(LoggerInterface $logger, RequestSender $sender)
    {
        $queryString = 'id=a&password=pwd&action=1&amt=100.00&currencycode=978&langid=ITA&responseURL=http%3A%2F%2Fresponse.com&errorURL=http%3A%2F%2Ferror.com&trackid=100001&udf1=apwd1100.00978ITA100001%7C40c7de6cad5c34abd935761832ebbbd9c735b40b';
        $sender->post('url', $queryString)->willReturn('!ERROR!PY10000 Internal error');

        $this->constructAndInit($logger, $sender);
        $this->shouldThrow(new \Exception('PY10000 Internal error'))
            ->duringPaymentInit('100001', 100, 978, 'ITA', 'http://response.com', 'http://error.com');
    }

    public function it_generates_signs_and_sends_paymentinit_message(LoggerInterface $logger, RequestSender $sender)
    {
        $queryString = 'id=a&password=pwd&action=1&amt=100.00&currencycode=978&langid=ITA&responseURL=http%3A%2F%2Fresponse.com&errorURL=http%3A%2F%2Ferror.com&trackid=100001&udf1=apwd1100.00978ITA100001%7C40c7de6cad5c34abd935761832ebbbd9c735b40b';
        $sender->post('url', $queryString)->willReturn('123456:http://redirect.com');

        $this->constructAndInit($logger, $sender);
        $this->paymentInit('100001', 100, 978, 'ITA', 'http://response.com', 'http://error.com')->shouldBe('http://redirect.com?PaymentID=123456');
    }

    public function it_throws_exception_if_init_was_not_called_before_calling_paymentverify(LoggerInterface $logger, RequestSender $sender)
    {
        $this->beConstructedWith($logger, $sender);
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
            ]
        );
    }

    /**
     * @param LoggerInterface $logger
     * @param RequestSender $sender
     */
    private function constructAndInit(LoggerInterface $logger, RequestSender $sender)
    {
        $this->beConstructedWith($logger, $sender);
        $this->init('a', 'pwd', 'url', 1, 'signsecret');
    }
}
