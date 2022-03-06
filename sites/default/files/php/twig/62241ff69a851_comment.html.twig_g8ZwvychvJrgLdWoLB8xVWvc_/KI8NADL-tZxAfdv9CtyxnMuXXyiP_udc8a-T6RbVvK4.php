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

/* themes/mediteran/templates/content/comment.html.twig */
class __TwigTemplate_f6e0426c3e729566d21f4c3a77056805f2b3c12d5e8f246e978874e32f3cc65b extends \Twig\Template
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
        // line 67
        echo "
";
        // line 69
        $context["classes"] = [0 => "comment", 1 => "js-comment", 2 => (((        // line 72
($context["status"] ?? null) != "published")) ? (($context["status"] ?? null)) : ("")), 3 => ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source,         // line 73
($context["comment"] ?? null), "owner", [], "any", false, false, true, 73), "anonymous", [], "any", false, false, true, 73)) ? ("by-anonymous") : ("")), 4 => (((        // line 74
($context["author_id"] ?? null) && (($context["author_id"] ?? null) == twig_get_attribute($this->env, $this->source, ($context["commented_entity"] ?? null), "getOwnerId", [], "method", false, false, true, 74)))) ? ((("by-" . $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["commented_entity"] ?? null), "getEntityTypeId", [], "method", false, false, true, 74), 74, $this->source)) . "-author")) : (""))];
        // line 77
        echo "<article";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", [0 => ($context["classes"] ?? null)], "method", false, false, true, 77), 77, $this->source), "html", null, true);
        echo ">
  ";
        // line 83
        echo "  <mark class=\"hidden\" data-comment-timestamp=\"";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["new_indicator_timestamp"] ?? null), 83, $this->source), "html", null, true);
        echo "\"></mark>

  <footer class=\"comment__meta\">
    ";
        // line 86
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["user_picture"] ?? null), 86, $this->source), "html", null, true);
        echo "
    <p class=\"comment__submitted\">";
        // line 87
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["submitted"] ?? null), 87, $this->source), "html", null, true);
        echo "</p>

    ";
        // line 94
        echo "    ";
        if (($context["parent"] ?? null)) {
            // line 95
            echo "      <p class=\"parent visually-hidden\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["parent"] ?? null), 95, $this->source), "html", null, true);
            echo "</p>
    ";
        }
        // line 97
        echo "
    ";
        // line 98
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["permalink"] ?? null), 98, $this->source), "html", null, true);
        echo "
  </footer>

  <div";
        // line 101
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["content_attributes"] ?? null), "addClass", [0 => "content"], "method", false, false, true, 101), 101, $this->source), "html", null, true);
        echo ">
    ";
        // line 102
        if (($context["title"] ?? null)) {
            // line 103
            echo "      ";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["title_prefix"] ?? null), 103, $this->source), "html", null, true);
            echo "
      <h3";
            // line 104
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["title_attributes"] ?? null), 104, $this->source), "html", null, true);
            echo ">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["title"] ?? null), 104, $this->source), "html", null, true);
            echo "</h3>
      ";
            // line 105
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["title_suffix"] ?? null), 105, $this->source), "html", null, true);
            echo "
    ";
        }
        // line 107
        echo "    ";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["content"] ?? null), 107, $this->source), "html", null, true);
        echo "
  </div>
</article>
";
    }

    public function getTemplateName()
    {
        return "themes/mediteran/templates/content/comment.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  108 => 107,  103 => 105,  97 => 104,  92 => 103,  90 => 102,  86 => 101,  80 => 98,  77 => 97,  71 => 95,  68 => 94,  63 => 87,  59 => 86,  52 => 83,  47 => 77,  45 => 74,  44 => 73,  43 => 72,  42 => 69,  39 => 67,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/mediteran/templates/content/comment.html.twig", "/Applications/XAMPP/xamppfiles/htdocs/digitalcms9/themes/mediteran/templates/content/comment.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 69, "if" => 94);
        static $filters = array("escape" => 77);
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
