<?php

namespace AppBundle\Controller\Front;

use AppBundle\Entity\Conference;
use Symfony\Bundle\FrameworkBundle\Templating\TemplateReference;
use Symfony\Bundle\TwigBundle\Controller\ExceptionController;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;

class ErrorController extends ExceptionController
{

    /**
     * ErrorController constructor.
     */
    public function __construct(\Twig_Environment $twig, $debug)
    {
        parent::__construct($twig, $debug);
    }

    public function findTemplate(Request $request, $format, $code, $showException)
    {
        $locale = $request->getLocale();

        $name = $showException ? 'exception' : 'error';
        if ($showException && 'html' == $format) {
            $name = 'exception_full';
        }

        $templates = array();

        // For error pages, add names of template for the specific HTTP status code and format
        if (!$showException) {

            if (!empty($locale)) {
                $templates[] = $name.$code.'.'.$locale;
            }

            $templates[] = $name.$code;
        }

        if (!empty($locale)) {
            $templates[] = $name.'.'.$locale;
        }

        $templates[] = $name;

        // try to find a template for the given name
        foreach ($templates as $templateName) {
            $template = new TemplateReference('TwigBundle', 'Exception', $templateName, $format, 'twig');
            if ($this->templateExists($template)) {
                return $template;
            }
        }

        // default to a generic HTML exception
        $request->setRequestFormat('html');

        return new TemplateReference('TwigBundle', 'Exception', $showException ? 'exception_full' : $name, 'html', 'twig');
    }

    public function showAction(Request $request, FlattenException $exception, DebugLoggerInterface $logger = null)
    {
        return parent::showAction($request, $exception, $logger);
    }
}