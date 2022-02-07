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

/* themes/mediteran/templates/admin/system-themes-page.html.twig */
class __TwigTemplate_05774ee805eb103906c606ab82b5643d26af877df7e9c2cae56210fee4f9fe0d extends \Twig\Template
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
        // line 31
        echo "<div";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["attributes"] ?? null), 31, $this->source), "html", null, true);
        echo ">
  ";
        // line 32
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["theme_groups"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["theme_group"]) {
            // line 33
            echo "    ";
            // line 34
            $context["theme_group_classes"] = [0 => "system-themes-list", 1 => ("system-themes-list-" . $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source,             // line 36
$context["theme_group"], "state", [], "any", false, false, true, 36), 36, $this->source)), 2 => "clearfix"];
            // line 40
            echo "    <div";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["theme_group"], "attributes", [], "any", false, false, true, 40), "addClass", [0 => ($context["theme_group_classes"] ?? null)], "method", false, false, true, 40), 40, $this->source), "html", null, true);
            echo ">
      <h2 class=\"system-themes-list__header\">";
            // line 41
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["theme_group"], "title", [], "any", false, false, true, 41), 41, $this->source), "html", null, true);
            echo "</h2>
      ";
            // line 42
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["theme_group"], "themes", [], "any", false, false, true, 42));
            foreach ($context['_seq'] as $context["_key"] => $context["theme"]) {
                // line 43
                echo "        ";
                // line 44
                $context["theme_classes"] = [0 => ((twig_get_attribute($this->env, $this->source,                 // line 45
$context["theme"], "is_default", [], "any", false, false, true, 45)) ? ("theme-default") : ("")), 1 => ((twig_get_attribute($this->env, $this->source,                 // line 46
$context["theme"], "is_admin", [], "any", false, false, true, 46)) ? ("theme-admin") : ("")), 2 => "theme-selector", 3 => "clearfix"];
                // line 51
                echo "        <div";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["theme"], "attributes", [], "any", false, false, true, 51), "addClass", [0 => ($context["theme_classes"] ?? null)], "method", false, false, true, 51), 51, $this->source), "html", null, true);
                echo ">
          ";
                // line 52
                if (twig_get_attribute($this->env, $this->source, $context["theme"], "screenshot", [], "any", false, false, true, 52)) {
                    // line 53
                    echo "            ";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["theme"], "screenshot", [], "any", false, false, true, 53), 53, $this->source), "html", null, true);
                    echo "
          ";
                }
                // line 55
                echo "          <div class=\"theme-info\">
            <h3 class=\"theme-info__header\">";
                // line 57
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["theme"], "name", [], "any", false, false, true, 57), 57, $this->source), "html", null, true);
                echo " ";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["theme"], "version", [], "any", false, false, true, 57), 57, $this->source), "html", null, true);
                // line 58
                if (twig_get_attribute($this->env, $this->source, $context["theme"], "notes", [], "any", false, false, true, 58)) {
                    // line 59
                    echo "                (";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->safeJoin($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["theme"], "notes", [], "any", false, false, true, 59), 59, $this->source), ", "));
                    echo ")";
                }
                // line 61
                echo "</h3>
            <div class=\"theme-info__description\">";
                // line 62
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["theme"], "description", [], "any", false, false, true, 62), 62, $this->source), "html", null, true);
                echo "</div>
            ";
                // line 64
                echo "            ";
                if (twig_get_attribute($this->env, $this->source, $context["theme"], "incompatible", [], "any", false, false, true, 64)) {
                    // line 65
                    echo "              <div class=\"incompatible\">";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["theme"], "incompatible", [], "any", false, false, true, 65), 65, $this->source), "html", null, true);
                    echo "</div>
            ";
                } else {
                    // line 67
                    echo "              ";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["theme"], "operations", [], "any", false, false, true, 67), 67, $this->source), "html", null, true);
                    echo "
            ";
                }
                // line 69
                echo "          </div>
        </div>
      ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['theme'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 72
            echo "    </div>
  ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['theme_group'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 74
        echo "</div>
";
    }

    public function getTemplateName()
    {
        return "themes/mediteran/templates/admin/system-themes-page.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  136 => 74,  129 => 72,  121 => 69,  115 => 67,  109 => 65,  106 => 64,  102 => 62,  99 => 61,  94 => 59,  92 => 58,  88 => 57,  85 => 55,  79 => 53,  77 => 52,  72 => 51,  70 => 46,  69 => 45,  68 => 44,  66 => 43,  62 => 42,  58 => 41,  53 => 40,  51 => 36,  50 => 34,  48 => 33,  44 => 32,  39 => 31,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/mediteran/templates/admin/system-themes-page.html.twig", "/Applications/XAMPP/xamppfiles/htdocs/digitalcms9/themes/mediteran/templates/admin/system-themes-page.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("for" => 32, "set" => 34, "if" => 52);
        static $filters = array("escape" => 31, "safe_join" => 59);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['for', 'set', 'if'],
                ['escape', 'safe_join'],
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
