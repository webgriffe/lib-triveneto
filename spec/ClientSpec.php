<?php

namespace spec\Webgriffe\LibTriveneto;

use PhpSpec\ObjectBehavior;
use Psr\Log\LoggerInterface;

class ClientSpec extends ObjectBehavior
{
    public function it_is_initializable(LoggerInterface $logger)
    {
        $this->beConstructedWith($logger);
        $this->shouldHaveType('Webgriffe\LibTriveneto\Client');
    }

    public function it_throws_exception_if_user_is_missing(LoggerInterface $logger)
    {
        $this->beConstructedWith($logger);
        $this->shouldThrow(new \InvalidArgumentException("Missing user id"))->duringInit('', '', '', '');
    }

    public function it_throws_exception_if_password_is_missing(LoggerInterface $logger)
    {
        $this->beConstructedWith($logger);
        $this->shouldThrow(new \InvalidArgumentException("Missing password"))->duringInit('a', '', '', '');
    }

    public function it_throws_exception_if_init_url_is_missing(LoggerInterface $logger)
    {
        $this->beConstructedWith($logger);
        $this->shouldThrow(new \InvalidArgumentException("Missing payment init URL"))->duringInit('a', 'pwd', '', '');
    }

    public function it_throws_exception_if_action_is_missing(LoggerInterface $logger)
    {
        $this->beConstructedWith($logger);
        $this->shouldThrow(new \InvalidArgumentException("Missing payment action (accounting type)"))
            ->duringInit('a', 'pwd', 'url', '');
    }

    public function it_throws_exception_if_init_was_not_called_before_calling_paymentinit(LoggerInterface $logger)
    {
        $this->beConstructedWith($logger);
        $this->shouldThrow(new \Exception("Init was not called"))->duringPaymentInit();
    }

    public function it_throws_exception_if_init_was_not_called_before_calling_paymentverify(LoggerInterface $logger)
    {
        $this->beConstructedWith($logger);
        $this->shouldThrow(new \Exception("Init was not called"))->duringPaymentVerify();
    }
}
