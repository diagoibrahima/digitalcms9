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

/* themes/mediteran/templates/admin/admin-block.html.twig */
class __TwigTemplate_ecd6de36c77b164380ac9a54100e1f325525e70c22a0d1ed557c2c2d1bdd30ef extends \Twig\Template
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
        // line 17
        $context["classes"] = [0 => "panel"];
        // line 21
        echo "<div";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", [0 => ($context["classes"] ?? null)], "method", false, false, true, 21), 21, $this->source), "html", null, true);
        echo ">
  ";
        // line 22
        if (twig_get_attribute($this->env, $this->source, ($context["block"] ?? null), "title", [], "any", false, false, true, 22)) {
            // line 23
            echo "    <h3 class=\"panel__title\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["block"] ?? null), "title", [], "any", false, false, true, 23), 23, $this->source), "html", null, true);
            echo "</h3>
  ";
        }
        // line 25
        echo "  ";
        if (twig_get_attribute($this->env, $this->source, ($context["block"] ?? null), "content", [], "any", false, false, true, 25)) {
            // line 26
            echo "    <div class=\"panel__content\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["block"] ?? null), "content", [], "any", false, false, true, 26), 26, $this->source), "html", null, true);
            echo "</div>
  ";
        } elseif (twig_get_attribute($this->env, $this->source,         // line 27
($context["block"] ?? null), "description", [], "any", false, false, true, 27)) {
            // line 28
            echo "    <div class=\"panel__description\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["block"] ?? null), "description", [], "any", false, false, true, 28), 28, $this->source), "html", null, true);
            echo "</div>
  ";
        }
        // line 30
        echo "</div>
";
    }

    public function getTemplateName()
    {
        return "themes/mediteran/templates/admin/admin-block.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  70 => 30,  64 => 28,  62 => 27,  57 => 26,  54 => 25,  48 => 23,  46 => 22,  41 => 21,  39 => 17,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/mediteran/templates/admin/admin-block.html.twig", "/Applications/XAMPP/xamppfiles/htdocs/digitalcms9/themes/mediteran/templates/admin/admin-block.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 17, "if" => 22);
        static $filters = array("escape" => 21);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['set', 'if'],
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
