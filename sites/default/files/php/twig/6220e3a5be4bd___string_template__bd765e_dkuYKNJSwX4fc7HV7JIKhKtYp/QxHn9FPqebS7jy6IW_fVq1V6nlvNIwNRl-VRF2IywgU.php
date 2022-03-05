<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* __string_template__bd765e1afd38cd6c521411c51b1663f4c270f85a1d691800bc0d7ed7a9eeee33 */
class __TwigTemplate_05eccc9b474aac9b1563b5e9f9e7866f28876fa31c90773d2fcfa115aa3f16a7 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<div class=\"tw-shadow tw-text-right tw-px-8\"> <span class=\"blocuers-name-flag\"><i class=\"fa fa-fw fa-user-circle user-avatar\"></i>";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["field_full_name"] ?? null), 1, $this->source), "html", null, true);
        echo " ";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["field_pays_teste"] ?? null), 1, $this->source), "html", null, true);
        echo " </span>  <div  class=\"new-logoutbutton\"> <a href=\"/digitalcms9/en/user/logout?current=/liste-of-content\" data-drupal-link-system-path=\"user/logout\"> <span class=\"link-text\"></span>
<i class=\"fa fa-power-off\"></i></a></></div>
<h6 class=\"country-of-userlog\">";
        // line 3
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["field_pays_teste_1"] ?? null), 3, $this->source), "html", null, true);
        echo "</h6>";
    }

    public function getTemplateName()
    {
        return "__string_template__bd765e1afd38cd6c521411c51b1663f4c270f85a1d691800bc0d7ed7a9eeee33";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  47 => 3,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "__string_template__bd765e1afd38cd6c521411c51b1663f4c270f85a1d691800bc0d7ed7a9eeee33", "");
    }
    
    public function checkSecurity()
    {
        static $tags = array();
        static $filters = array("escape" => 1);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                [],
                ['escape'],
                []
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
