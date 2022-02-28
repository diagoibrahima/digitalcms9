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

/* modules/contrib/restui/templates/restui-resource-info.html.twig */
class __TwigTemplate_56c8b1eefe615add618136860d9104c321e15e45d1c76a6e7eb28b243274e945 extends \Twig\Template
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
        if ((($context["granularity"] ?? null) == "resource")) {
            // line 16
            echo "    <p>methods: ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, twig_join_filter($this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["configuration"] ?? null), "methods", [], "any", false, false, true, 16), 16, $this->source), ", "), "html", null, true);
            echo "<br>
        formats: ";
            // line 17
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, twig_join_filter($this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["configuration"] ?? null), "formats", [], "any", false, false, true, 17), 17, $this->source), ", "), "html", null, true);
            echo "<br>
        authentication: ";
            // line 18
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, twig_join_filter($this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["configuration"] ?? null), "authentication", [], "any", false, false, true, 18), 18, $this->source), ", "), "html", null, true);
            echo "
    </p>
";
        } else {
            // line 21
            echo "    ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["configuration"] ?? null));
            foreach ($context['_seq'] as $context["method"] => $context["properties"]) {
                // line 22
                echo "        <p>";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($context["method"], 22, $this->source), "html", null, true);
                echo "<br>
            formats: ";
                // line 23
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, twig_join_filter($this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["properties"], "supported_formats", [], "any", false, false, true, 23), 23, $this->source), ", "), "html", null, true);
                echo "<br>
            authentication: ";
                // line 24
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, twig_join_filter($this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["properties"], "supported_auth", [], "any", false, false, true, 24), 24, $this->source), ", "), "html", null, true);
                echo "
        </p>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['method'], $context['properties'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
    }

    public function getTemplateName()
    {
        return "modules/contrib/restui/templates/restui-resource-info.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  70 => 24,  66 => 23,  61 => 22,  56 => 21,  50 => 18,  46 => 17,  41 => 16,  39 => 15,);
    }

    public function getSourceContext()
    {
        return new Source("", "modules/contrib/restui/templates/restui-resource-info.html.twig", "/Applications/XAMPP/xamppfiles/htdocs/digitalcms9/modules/contrib/restui/templates/restui-resource-info.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("if" => 15, "for" => 21);
        static $filters = array("escape" => 16, "join" => 16);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['if', 'for'],
                ['escape', 'join'],
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
