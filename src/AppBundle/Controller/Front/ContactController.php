<?php

namespace AppBundle\Controller\Front;

use AppBundle\Service\Mailer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ContactController
 * @package AppBundle\Controller\Front
 *
 * -------------------- *
 * @Route("/contact")
 * -------------------- *
 */
class ContactController extends BaseController
{

    /**
     * Contact
     *
     * -------------------- *
     * @Route("/", name="contact")
     * @Method({"GET", "POST"})
     * -------------------- *
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $defaultContact = [];
        $form = $this->createFormBuilder($defaultContact)
            ->add(
                'nom',
                TextType::class,
                [
                    'required' => true,
                    'label_attr' => ['class' => 'u-hiddenVisually'],
                    'attr' => ['class' => 'fld', 'placeholder' => '*Nom'],
                    'label' => 'Nom'
                ]
            )
            ->add(
                'prenom',
                TextType::class,
                [
                    'required' => true,
                    'label_attr' => ['class' => 'u-hiddenVisually'],
                    'attr' => ['class' => 'fld', 'placeholder' => '*Prenom'],
                    'label' => 'Prenom'
                ]
            )
            ->add(
                'objet',
                TextType::class,
                [
                    'required' => true,
                    'label_attr' => ['class' => 'u-hiddenVisually'],
                    'attr' => [
                        'class' => 'fld',
                        'placeholder' => '*Objet de votre demande'
                    ],
                    'label' => 'Sujet'
                ]
            )
            ->add(
                'email',
                EmailType::class,
                [
                    'required' => true,
                    'label_attr' => ['class' => 'u-hiddenVisually'],
                    'attr' => [
                        'class' => 'fld',
                        'placeholder' => '*Votre email'
                    ],
                    'label' => 'Email'
                ]
            )
            ->add(
                'message',
                TextareaType::class,
                [
                    'required' => true,
                    'label_attr' => ['class' => 'fldLabel'],
                    'attr' => [
                        'class' => 'fld',
                        'placeholder' => 'Bonjour,',
                        'rows' => 8
                    ],
                    'label' => 'Votre message'
                ]
            )
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            //-- Check Google Recaptcha
            if (hash_equals($this->getEnvironment(), 'prod')) {
                try {
                    $this->checkGoogleRecaptcha($request->request->get('g-recaptcha-response'));
                } catch (\Exception $e) {
                    if ($e->getCode() == self::EXCEPTION_CODE_GOOGLE_RECAPTCHA_FAILED) {
                        $form->addError(
                            new FormError(
                                $this->getTranslator()->trans(
                                    'general.error.grecaptcha.detected_as_robot',
                                    [],
                                    'validators'
                                )
                            )
                        );
                    } else {
                        $form->addError(
                            new FormError(
                                $this->getTranslator()->trans(
                                    'general.error.grecaptcha.error_on_verify',
                                    [],
                                    'validators'
                                )
                            )
                        );
                    }
                }
            }
            //--

            if ($form->isValid()) {
                $data = $form->getData();

                $retour_mail = $this->get('app.mailer')
                    ->setSubject($this->getTranslator()->trans('contact.mail.sujet'))
                    ->setReplyTo($data['email'])
                    ->setTemplate(
                        'contact',
                        [
                            'title'     => $this->getTranslator()->trans('contact.mail.titre'),
                            'subtitle'  => $this->getTranslator()->trans('contact.mail.soustitre'),
                            'data'      => $data
                        ]
                    )
                    ->send();

                if ($retour_mail) {
                    $request
                        ->getSession()
                        ->getFlashBag()
                        ->add('success', 'Votre message a été envoyé');
                } else {
                    $request
                        ->getSession()
                        ->getFlashBag()
                        ->add('error', 'Erreur lors de l\'envoi de votre message. Réessayez ultérieument');
                }
            }
        }

        return $this->render('front/contact/contact.html.twig', ['form' => $form->createView()]);
    }
}
