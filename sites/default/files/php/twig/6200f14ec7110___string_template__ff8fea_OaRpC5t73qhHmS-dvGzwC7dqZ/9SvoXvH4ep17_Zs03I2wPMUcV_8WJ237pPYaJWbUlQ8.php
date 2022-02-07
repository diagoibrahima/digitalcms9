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

/* __string_template__ff8feadf873cec65a1cff9032bdec49acd1b2c9d590510b4101cde018d60f7eb */
class __TwigTemplate_20eb9976b755b963b5b0e9cd8cf3d655ee47b03f6ad1578b3a0fc86f0a8c40bc extends \Twig\Template
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
        echo "<div class=\"choosechannel\">
<div class=\"channel \">
";
        // line 3
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, twig_striptags($this->sandbox->ensureToStringAllowed(($context["body"] ?? null), 3, $this->source)), "html", null, true);
        echo "
</div>
<hr>
<div class\"card\">
";
        // line 7
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["body"] ?? null), 7, $this->source), "html", null, true);
        echo "
</div>
<hr>
<div class\"card\">
";
        // line 11
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["body"] ?? null), 11, $this->source), "html", null, true);
        echo "
</div>

</div>


";
    }

    public function getTemplateName()
    {
        return "__string_template__ff8feadf873cec65a1cff9032bdec49acd1b2c9d590510b4101cde018d60f7eb";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  57 => 11,  50 => 7,  43 => 3,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "__string_template__ff8feadf873cec65a1cff9032bdec49acd1b2c9d590510b4101cde018d60f7eb", "");
    }
    
    public function checkSecurity()
    {
        static $tags = array();
        static $filters = array("escape" => 3, "striptags" => 3);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                [],
                ['escape', 'striptags'],
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
