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

/* themes/mediteran/templates/admin/system-modules-details.html.twig */
class __TwigTemplate_1b591f597d0691c89c72a3c7a7493cd7b28072cd77a78e4ac35e32789368f46e extends \Twig\Template
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
        // line 25
        echo "<table class=\"responsive-enabled\" data-striping=\"1\">
  <thead>
    <tr>
      <th class=\"checkbox visually-hidden\">";
        // line 28
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Installed"));
        echo "</th>
      <th class=\"name visually-hidden\">";
        // line 29
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Name"));
        echo "</th>
      <th class=\"description visually-hidden priority-low\">";
        // line 30
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Description"));
        echo "</th>
    </tr>
  </thead>
  <tbody>
    ";
        // line 34
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["modules"] ?? null));
        $context['loop'] = [
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        ];
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["module"]) {
            // line 35
            echo "      ";
            $context["zebra"] = twig_cycle([0 => "odd", 1 => "even"], $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["loop"], "index0", [], "any", false, false, true, 35), 35, $this->source));
            // line 36
            echo "      <tr";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["module"], "attributes", [], "any", false, false, true, 36), "addClass", [0 => ($context["zebra"] ?? null)], "method", false, false, true, 36), 36, $this->source), "html", null, true);
            echo ">
        <td class=\"checkbox\">
          ";
            // line 38
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["module"], "checkbox", [], "any", false, false, true, 38), 38, $this->source), "html", null, true);
            echo "
        </td>
        <td class=\"module\">
          <label id=\"";
            // line 41
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["module"], "id", [], "any", false, false, true, 41), 41, $this->source), "html", null, true);
            echo "\" for=\"";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["module"], "enable_id", [], "any", false, false, true, 41), 41, $this->source), "html", null, true);
            echo "\" class=\"module-name table-filter-text-source\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["module"], "name", [], "any", false, false, true, 41), 41, $this->source), "html", null, true);
            echo "</label>
        </td>
        <td class=\"description expand priority-low\">
          <details class=\"js-form-wrapper form-wrapper\" id=\"";
            // line 44
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["module"], "enable_id", [], "any", false, false, true, 44), 44, $this->source), "html", null, true);
            echo "-description\">
            <summary aria-controls=\"";
            // line 45
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["module"], "enable_id", [], "any", false, false, true, 45), 45, $this->source), "html", null, true);
            echo "-description\" role=\"button\" aria-expanded=\"false\"><span class=\"text module-description\">";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["module"], "description", [], "any", false, false, true, 45), 45, $this->source), "html", null, true);
            echo "</span></summary>
            <div class=\"details-wrapper\">
              <div class=\"details-description\">
                <div class=\"requirements\">
                  <div class=\"admin-requirements\">";
            // line 49
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Machine name: <span dir=\"ltr\" class=\"table-filter-text-source\">@machine-name</span>", ["@machine-name" => twig_get_attribute($this->env, $this->source, $context["module"], "machine_name", [], "any", false, false, true, 49)]));
            echo "</div>
                  ";
            // line 50
            if (twig_get_attribute($this->env, $this->source, $context["module"], "version", [], "any", false, false, true, 50)) {
                // line 51
                echo "                    <div class=\"admin-requirements\">";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Version: @module-version", ["@module-version" => twig_get_attribute($this->env, $this->source, $context["module"], "version", [], "any", false, false, true, 51)]));
                echo "</div>
                  ";
            }
            // line 53
            echo "                  ";
            if (twig_get_attribute($this->env, $this->source, $context["module"], "requires", [], "any", false, false, true, 53)) {
                // line 54
                echo "                    <div class=\"admin-requirements\">";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Requires: @module-list", ["@module-list" => twig_get_attribute($this->env, $this->source, $context["module"], "requires", [], "any", false, false, true, 54)]));
                echo "</div>
                  ";
            }
            // line 56
            echo "                  ";
            if (twig_get_attribute($this->env, $this->source, $context["module"], "required_by", [], "any", false, false, true, 56)) {
                // line 57
                echo "                    <div class=\"admin-requirements\">";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Required by: @module-list", ["@module-list" => twig_get_attribute($this->env, $this->source, $context["module"], "required_by", [], "any", false, false, true, 57)]));
                echo "</div>
                  ";
            }
            // line 59
            echo "                </div>
                ";
            // line 60
            if (twig_get_attribute($this->env, $this->source, $context["module"], "links", [], "any", false, false, true, 60)) {
                // line 61
                echo "                  <div class=\"links\">
                    ";
                // line 62
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable([0 => "help", 1 => "permissions", 2 => "configure"]);
                foreach ($context['_seq'] as $context["_key"] => $context["link_type"]) {
                    // line 63
                    echo "                      ";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed((($__internal_compile_0 = twig_get_attribute($this->env, $this->source, $context["module"], "links", [], "any", false, false, true, 63)) && is_array($__internal_compile_0) || $__internal_compile_0 instanceof ArrayAccess ? ($__internal_compile_0[$context["link_type"]] ?? null) : null), 63, $this->source), "html", null, true);
                    echo "
                    ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['link_type'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 65
                echo "                  </div>
                ";
            }
            // line 67
            echo "              </div>
            </div>
          </details>
        </td>
      </tr>
    ";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['module'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 73
        echo "  </tbody>
</table>
";
    }

    public function getTemplateName()
    {
        return "themes/mediteran/templates/admin/system-modules-details.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  188 => 73,  169 => 67,  165 => 65,  156 => 63,  152 => 62,  149 => 61,  147 => 60,  144 => 59,  138 => 57,  135 => 56,  129 => 54,  126 => 53,  120 => 51,  118 => 50,  114 => 49,  105 => 45,  101 => 44,  91 => 41,  85 => 38,  79 => 36,  76 => 35,  59 => 34,  52 => 30,  48 => 29,  44 => 28,  39 => 25,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/mediteran/templates/admin/system-modules-details.html.twig", "/Applications/XAMPP/xamppfiles/htdocs/digitalcms9/themes/mediteran/templates/admin/system-modules-details.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("for" => 34, "set" => 35, "if" => 50);
        static $filters = array("t" => 28, "escape" => 36);
        static $functions = array("cycle" => 35);

        try {
            $this->sandbox->checkSecurity(
                ['for', 'set', 'if'],
                ['t', 'escape'],
                ['cycle']
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
