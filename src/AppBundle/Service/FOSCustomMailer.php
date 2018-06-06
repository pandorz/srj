<?php

namespace AppBundle\Service;

use FOS\UserBundle\Model\UserInterface;
use Monolog\Logger;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Translation\TranslatorInterface;
use FOS\UserBundle\Mailer\MailerInterface;

class FOSCustomMailer implements MailerInterface
{
    /**
     * @var Mailer
     */
    private $mailer;

    /**
     * @var UrlGeneratorInterface
     */
    private $router;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var Logger
     */
    private $logger;

    public function __construct(Mailer $mailer, UrlGeneratorInterface $router, TranslatorInterface $translator, Logger $logger)
    {
        $this->mailer       = $mailer;
        $this->translator   = $translator;
        $this->router       = $router;
        $this->logger       = $logger;
    }

    public function sendConfirmationEmailMessage(UserInterface $user)
    {
        // TODO: Implement sendConfirmationEmailMessage() method.
    }

    public function sendResettingEmailMessage(UserInterface $user)
    {
        $url  = $this->router->generate('fos_user_resetting_reset', array('token' => $user->getConfirmationToken()), UrlGeneratorInterface::ABSOLUTE_URL);
        $data = [
            'confirmationUrl'   => $url,
            'username'          => $user->getUsername()
        ];

        try {
            $this->mailer
                ->setTo($user->getEmail())
                ->setSubject($this->translator->trans('lost_pwd.mail.sujet'))
                ->setTemplate(
                    'new_password',
                    [
                        'title' => $this->translator->trans('lost_pwd.mail.titre'),
                        'subtitle' => $this->translator->trans('lost_pwd.mail.soustitre'),
                        'data' => $data
                    ]
                )
                ->send();
        } catch (\Exception $e) {
            $this->logger->addAlert($e->getMessage());
        }
    }
}