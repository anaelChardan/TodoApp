<?php

namespace Specification\Todo\ShareSpace\Infrastructure\Http\Exception;

use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Messenger\Exception\ValidationFailedException;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

class FlattenExceptionSpec extends ObjectBehavior
{
    function let()
    {
        $exception = new HttpException(502, 'message');

        $this->beConstructedThrough('createFrom', [$exception]);
    }

    function it_has_a_code()
    {
        $this->getCode()->shouldReturn(0);
    }

    function it_has_message()
    {
        $this->getMessage()->shouldReturn('message');
    }

    function it_has_a_status_code()
    {
        $this->getStatusCode()->shouldReturn(502);
    }

    function it_has_file()
    {
        $this->getFile()->shouldReturn(__FILE__);
    }

    function it_has_a_line()
    {
        $this->getLine()->shouldReturn(15);
    }

    function it_has_a_class()
    {
        $this->getClass()->shouldReturn(HttpException::class);
    }

    function it_processes_validation_failed_exception()
    {
        $violations = [];
        $violations[] = new ConstraintViolation('Invalid Diet', null, [], 'root', 'diet', 'humans');
        $violationList = new ConstraintViolationList($violations);
        $this->beConstructedThrough('createFrom', [new ValidationFailedException(new \SplObjectStorage(), $violationList)]);
        $this->getErrors()->shouldReturn([
           'diet' => 'Invalid Diet'
        ]);
        $this->getStatusCode()->shouldReturn(400);
    }
}
