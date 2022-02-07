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

/* __string_template__bf70efdff1c5fcae9dc28eece808e4992a82f113bd616a0f99bbd879c97527e3 */
class __TwigTemplate_b8d5bba577671a57da44c9d7c6a93f573dd776438669db8a913b1e9d9c13baaa extends \Twig\Template
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
        echo "<div class=\"tw-p-3 tw-bg-white tw-rounded tw-mb-4\">                                                                                                                                                                                 
                <p class=\"tw-font-semibold\">Content completion</p>
                <p class=\"tw-font-bold tw-text-5xl tw-text-center tw-my-3 tw-text-red-600 tw-translations-indicator\">0%</p>
                <p class=\"tw-my-2 tw-text-center tw-text-gray-500\">of content translated. <br><span class=\"contentrestetotranslate\">2<span> to translate</p>
                <p class=\"tw-rounded tw-bg-red-100 tw-border tw-border-red-500 tw-text-gray-800 p-1\">There is no or few content translated</p>
                <hr class=\"tw-my-4\">
               
                <div class=\"tw-grid tw-grid-cols-4 tw-gap-1 tw-place-items-stretch\">
                    <p class=\"tw-text-center tw-text-gray-500 tw-text-xl cursor-pointer title=\"Export as PDF\">
                          <a id=\"pdflink\" href=\"/digitalcms9/en/download/content.pdf/";
        // line 10
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["nid"] ?? null), 10, $this->source), "html", null, true);
        echo "\"><i class=\"fas fa-file-pdf\"></i></a>
                    </p>

                    <p class=\"tw-text-center tw-text-gray-500 tw-text-xl cursor-pointer  title=\"Translations\">
                         <a id=\"excellink\" href=\"/digitalcms9/en/localization-excel-export.xls/";
        // line 14
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["nid"] ?? null), 14, $this->source), "html", null, true);
        echo "?page&_format=xls\"><i class=\"fa fa-language\" aria-hidden=\"true\"></i></a>
                    </p>
                    <p class=\"tw-text-center tw-text-gray-500 tw-text-xl cursor-pointer  title=\"Export translations\">
                            <a href=\"#\" class=\"ziplink\" > <i class=\"fa fa-download\" aria-hidden=\"true\"></i></a>
                    </p>


                    <p class=\"tw-text-center tw-text-gray-500 tw-text-xl cursor-pointer  title=\"Course settings\"><i class=\"fa fa-cog\" aria-hidden=\"true\"></i></p>

                </div>
            </div>
";
    }

    public function getTemplateName()
    {
        return "__string_template__bf70efdff1c5fcae9dc28eece808e4992a82f113bd616a0f99bbd879c97527e3";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  57 => 14,  50 => 10,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "__string_template__bf70efdff1c5fcae9dc28eece808e4992a82f113bd616a0f99bbd879c97527e3", "");
    }
    
    public function checkSecurity()
    {
        static $tags = array();
        static $filters = array("escape" => 10);
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
