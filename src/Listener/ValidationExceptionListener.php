<?php


namespace App\Listener;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Exception\ValidatorException;

class ValidationExceptionListener implements EventSubscriberInterface
{
    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => 'onException',
        ];
    }

    public function onException(ExceptionEvent $event)
    {
        $throwable = $event->getThrowable();
        if (!$throwable instanceof ValidatorException && !$throwable instanceof NotNormalizableValueException) {
            return;
        }

        $errors = [];
        $errors[] = $throwable->getMessage();

        /** @var ConstraintViolationInterface $violation */
        /*foreach ($throwable->getViolations() as $violation) {
            $errors[$violation->getPropertyPath()] = $violation->getMessage();
        }*/

        $response = new JsonResponse([
            'errors' => $errors,
        ], 400);

        $event->setResponse($response);
        $event->stopPropagation();
    }
}