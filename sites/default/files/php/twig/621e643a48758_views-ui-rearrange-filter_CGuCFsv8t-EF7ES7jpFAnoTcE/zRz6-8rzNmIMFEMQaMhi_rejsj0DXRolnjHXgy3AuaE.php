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

/* themes/mediteran/templates/admin/views-ui-rearrange-filter-form.html.twig */
class __TwigTemplate_178f8facebd204237183b84be8f10b42f705c16ac8da790144b9e21939f593bb extends \Twig\Template
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
        // line 15
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "override", [], "any", false, false, true, 15), 15, $this->source), "html", null, true);
        echo "
<div class=\"scroll\" data-drupal-views-scroll>
  ";
        // line 17
        if (($context["grouping"] ?? null)) {
            // line 18
            echo "    ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "filter_groups", [], "any", false, false, true, 18), "operator", [], "any", false, false, true, 18), 18, $this->source), "html", null, true);
            echo "
  ";
        } else {
            // line 20
            echo "    ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["form"] ?? null), "filter_groups", [], "any", false, false, true, 20), "groups", [], "any", false, false, true, 20), 0, [], "any", false, false, true, 20), 20, $this->source), "html", null, true);
            echo "
  ";
        }
        // line 22
        echo "  ";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["ungroupable_table"] ?? null), 22, $this->source), "html", null, true);
        echo "
  ";
        // line 23
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["table"] ?? null), 23, $this->source), "html", null, true);
        echo "
</div>
";
        // line 25
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->withoutFilter($this->sandbox->ensureToStringAllowed(($context["form"] ?? null), 25, $this->source), "override", "filter_groups", "remove_groups", "filters"), "html", null, true);
        echo "
";
    }

    public function getTemplateName()
    {
        return "themes/mediteran/templates/admin/views-ui-rearrange-filter-form.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  68 => 25,  63 => 23,  58 => 22,  52 => 20,  46 => 18,  44 => 17,  39 => 15,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/mediteran/templates/admin/views-ui-rearrange-filter-form.html.twig", "/Applications/XAMPP/xamppfiles/htdocs/digitalcms9/themes/mediteran/templates/admin/views-ui-rearrange-filter-form.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("if" => 17);
        static $filters = array("escape" => 15, "without" => 25);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['if'],
                ['escape', 'without'],
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
