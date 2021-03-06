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

/* __string_template__c7c3add4e32e89e4e3283ffdde7f6759a28bd4bb7e15c2f11bf4df5ce7d25304 */
class __TwigTemplate_33448c6ffd1a2e0f4dc6a7a91f677aa4c3baaf564836fb2b8ef73aaeb2667b97 extends \Twig\Template
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
        echo "<div class=\"grid grid-cols-2 gap-3 justify-items-stretch items-stretch \">
     <div class=\"flex items-center bg-transparent border-gray-400 border-dashed border-2 rounded-lg h-36\">
       <div class=\"grid grid-cols-2 gap-3 justify-items-stretch items-stretch \">
     <div class=\"flex items-center bg-transparent border-gray-400 border-dashed border-2 rounded-lg h-36\">
         ";
        // line 5
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["views_add_button_field"] ?? null), 5, $this->source), "html", null, true);
        echo "
     </div>
     <div class=\"flex items-center bg-transparent border-gray-400 border-dashed border-2 rounded-lg h-36\">
     </div>
</div>
     </div>
     <div class=\"flex items-center bg-transparent border-gray-400 border-dashed border-2 rounded-lg h-36\">
     </div>
</div>";
    }

    public function getTemplateName()
    {
        return "__string_template__c7c3add4e32e89e4e3283ffdde7f6759a28bd4bb7e15c2f11bf4df5ce7d25304";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  45 => 5,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "__string_template__c7c3add4e32e89e4e3283ffdde7f6759a28bd4bb7e15c2f11bf4df5ce7d25304", "");
    }
    
    public function checkSecurity()
    {
        static $tags = array();
        static $filters = array("escape" => 5);
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
