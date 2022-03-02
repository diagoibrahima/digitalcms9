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

/* __string_template__a44b7cd44419b455479bbd129879d0d0a00271c6ddad8635194e4284a4b07884 */
class __TwigTemplate_4f5b7c61d6f9e2fd7030960bf4ebd7e0d4a7d985721e952f89f8c0dd7b86a582 extends \Twig\Template
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
<i class=\"fa fa-power-off\"></i></a></></div>";
    }

    public function getTemplateName()
    {
        return "__string_template__a44b7cd44419b455479bbd129879d0d0a00271c6ddad8635194e4284a4b07884";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "__string_template__a44b7cd44419b455479bbd129879d0d0a00271c6ddad8635194e4284a4b07884", "");
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
