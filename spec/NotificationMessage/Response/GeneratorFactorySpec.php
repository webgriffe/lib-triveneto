<?php

namespace spec\Webgriffe\LibTriveneto\NotificationMessage\Response;

use PhpSpec\ObjectBehavior;
use Webgriffe\LibTriveneto\NotificationMessage\Result\NotificationResult;
use Webgriffe\LibTriveneto\NotificationMessage\Result\NotificationResultInterface;

class GeneratorFactorySpec extends ObjectBehavior
{
    public function it_generates_error_when_response_is_not_instance_of_notificationresult(NotificationResultInterface $result)
    {
        $this->getGenerator($result, 'success', 'error')->generate()->shouldBe('REDIRECT=error');
    }

    public function it_generates_error_when_response_is_error(NotificationResult $result)
    {
        $result->getIsSuccess()->willReturn(false);
        $result->getIsPending()->willReturn(false);
        $this->getGenerator($result, 'success', 'error')->generate()->shouldBe('REDIRECT=error');
    }

    public function it_generates_success_when_response_is_success(NotificationResult $result)
    {
        $result->getIsSuccess()->willReturn(true);
        $result->getIsPending()->willReturn(false);
        $this->getGenerator($result, 'success', 'error')->generate()->shouldBe('REDIRECT=success');
    }

    public function it_generates_success_when_response_is_pending(NotificationResult $result)
    {
        $result->getIsSuccess()->willReturn(false);
        $result->getIsPending()->willReturn(true);
        $this->getGenerator($result, 'success', 'error')->generate()->shouldBe('REDIRECT=success');
    }
}
