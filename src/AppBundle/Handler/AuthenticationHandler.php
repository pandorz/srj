<?php

namespace AppBundle\Handler;

use AppBundle\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Translation\TranslatorInterface;


class AuthenticationHandler implements AuthenticationSuccessHandlerInterface, AuthenticationFailureHandlerInterface
{

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var TranslatorInterface
     */
    private $translator;


    public function __construct(TranslatorInterface $translator, RouterInterface $router)
    {
        $this->router       = $router;
        $this->translator   = $translator;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        /** @var Utilisateur $user */
        $user   = $token->getUser();
        if (!$user->getAccesSite()) {
            $request->getSession()->invalidate();

            $result = [
                'message' => $this->translator->trans('fos_user.no_access', [], 'validators', $request->getLocale())
            ];

            return new JsonResponse($result, Response::HTTP_BAD_REQUEST);
        }

        $result = [
            'path' => $this->router->generate('my_space', [], UrlGeneratorInterface::ABSOLUTE_URL)
        ];

        return new JsonResponse($result);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $result = [
            'message' => $this->translator->trans('fos_user.bad_credentials', [], 'validators', $request->getLocale())
        ];

        return new JsonResponse($result, Response::HTTP_BAD_REQUEST);
    }
}
