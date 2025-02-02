<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;

class AccessDeniedListener implements EventSubscriberInterface
{
    private RequestStack $requestStack;
    private AuthorizationCheckerInterface $authorization;

    public function __construct(RequestStack $requestStack, AuthorizationCheckerInterface $authorization)
    {
        $this->requestStack = $requestStack;
        $this->authorization = $authorization;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelException', 2],
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if (!$exception instanceof AccessDeniedException) {
            return;
        }

        $request = $this->requestStack->getCurrentRequest();
        if ($request && $request->getPathInfo() === '/') {
            return;
        }

        $session = $this->requestStack->getSession();

        $session->getFlashBag()->add('error', 'Vous n\'avez pas l\'autorisation de réaliser cette action.');

        if ($exception->getCode() === 403 && !$this->authorization->isGranted('IS_AUTHENTICATED_FULLY')) {
            $event->setResponse(new RedirectResponse('/login'));
            return;
        }

        if ($exception->getCode() === 403 && $this->authorization->isGranted('IS_AUTHENTICATED_FULLY')) {
            $event->setResponse(new RedirectResponse('/'));
            return;
        }
    }
}
