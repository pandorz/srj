<?php

namespace AppBundle\Service;

use Exception;
use Monolog\Logger;
use AppBundle\Twig\AssetVersionExtension;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;
use Twig\Environment;

class Mailer
{
    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $templateName;

    /**
     * @var array
     */
    private $templateData;

    /**
     * @var string|array
     */
    private $to;

    /**
     * @var string
     */
    private $replyTo;

    /**
     * @var string|array
     */
    private $bcc;

    /**
     * @var string
     */
    private $noReplyEmail;

    /**
     * @var string
     */
    private $noReplyName;

    /**
     * @var string
     */
    private $adminEmail;

    /**
     * @var AssetExtension
     */
    private $assetExtension;

    /**
     * @var string
     */
    private $webDir;

    /**
     * @var string
     */
    private $logoFileMediaPath;

    /**
     * @var \Swift_Mailer
     */
    private $swiftMailer;

    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var array
     */
    private $attachments;


    public function __construct(
        string $noReplyEmail,
        string $noReplyName,
        string $adminEmail,
        string $webDir,
        string $logoFileMediaPath,
        AssetVersionExtension $assetExtension,
        \Swift_Mailer $swiftMailer,
        Environment $twig,
        Logger $logger
    ) {
        $this->noReplyEmail      = $noReplyEmail;
        $this->noReplyName       = $noReplyName;
        $this->adminEmail        = $adminEmail;
        $this->assetExtension    = $assetExtension;
        $this->webDir            = realpath($webDir);
        $this->logoFileMediaPath = $logoFileMediaPath;
        $this->swiftMailer       = $swiftMailer;
        $this->twig              = $twig;
        $this->logger            = $logger;
    }

    /**
     * @param mixed $subject
     *
     * @return Mailer
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @param string $template
     * @param array $data
     *
     * @return Mailer
     */
    public function setTemplate(string $template, array $data = [])
    {
        $this->templateName = $template;
        $this->templateData = $data;

        return $this;
    }

    /**
     * @param mixed $to
     *
     * @return Mailer
     */
    public function setTo($to)
    {
        if (!is_array($to)) {
            $to = [$to];
        }

        $this->to = $to;

        return $this;
    }

    /**
     * @param mixed $to
     *
     * @return Mailer
     */
    public function addTo($to)
    {
        $this->to[] = $to;

        return $this;
    }

    /**
     * @param mixed $bcc
     *
     * @return Mailer
     */
    public function setBcc($bcc)
    {
        if (!is_array($bcc)) {
            $bcc = [$bcc];
        }

        $this->bcc = $bcc;

        return $this;
    }

    /**
     * @param mixed $bcc
     *
     * @return Mailer
     */
    public function addBcc($bcc)
    {
        $this->bcc[] = $bcc;

        return $this;
    }

    /**
     * @return array
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * @param array $attachments
     */
    public function setAttachments(array $attachments)
    {
        $this->attachments = $attachments;
    }

    /**
     * @return string
     */
    public function getReplyTo()
    {
        return $this->replyTo;
    }

    /**
     * @param string $replyTo
     * @return Mailer
     */
    public function setReplyTo(string $replyTo)
    {
        $this->replyTo = $replyTo;

        return $this;
    }

    /**
     * Send a Email
     *
     * @return bool
     * @throws \Exception
     */
    public function send()
    {
        try {
            $from   = [$this->noReplyEmail => $this->noReplyName];
            $to     = $this->to ?? $this->adminEmail;

            /**
             * Init SwiftMailer
             */
            $message          = \Swift_Message::newInstance();
            $this->templateData['logo_cid'] = $message->embed(
                \Swift_Image::fromPath($this->webDir.$this->logoFileMediaPath)
            );

            $cssToInlineStyles = new CssToInlineStyles();

            $htmlMail = $this->twig->render(
                'emails/'.$this->templateName.'.html.twig',
                $this->templateData
            );

            $cssMail = file_get_contents(
                $this->webDir.'/'.$this->assetExtension->getAssetVersion('css/mail.css')
            );

            $htmlMail = $cssToInlineStyles->convert($htmlMail, $cssMail);

            $message
                ->setSubject($this->subject)
                ->setFrom($from)
                ->setTo($to)
                ->setBody($htmlMail, 'text/html');

            if (!is_null($this->bcc) && !empty($this->bcc)) {
                if (is_array($this->bcc)) {
                    foreach ($this->bcc as $mailBcc) {
                        if (!empty($mailBcc)) {
                            $message->addBcc($mailBcc);
                        }
                    }
                } else {
                    $message->setBcc($this->bcc);
                }
            }

            if (!is_null($this->replyTo)) {
                $message->setReplyTo($this->replyTo);
            }

            $message->addPart(
                $this->twig->render('emails/'.$this->templateName.'.txt.twig', $this->templateData),
                'text/plain'
            );

            //Attachments Manager
            if (!empty($this->attachments)) {
                foreach ($this->attachments as $attachment) {
                    $message->attach(\Swift_Attachment::newInstance(
                        file_get_contents($attachment['path']),
                        $attachment['name'],
                        $attachment['mime_type']
                    ));
                }
            }

            $nbMailSent = $this->swiftMailer->send($message, $failedRecipients);

            if ($nbMailSent === 0 || !empty($failedRecipients)) {
                throw new Exception(
                    "Can't send email [".$this->subject."] from [".
                    json_encode($from)."] to [".implode(', ', $failedRecipients)."]"
                );
            }
        } catch (Exception $e) {
            $this->logger->critical($e->getMessage(), ['exception' => $e]);

            throw $e;
        }

        return true;
    }
}
