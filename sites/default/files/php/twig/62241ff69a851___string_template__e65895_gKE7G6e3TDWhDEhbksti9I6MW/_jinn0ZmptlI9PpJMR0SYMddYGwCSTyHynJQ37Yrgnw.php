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

/* __string_template__e65895a7d69e26053085dfe137a87bbfe89a5b2138740fd99ad340f80e830213 */
class __TwigTemplate_74a0865b579d97329f30e96c928777b73cf226c9d8f43d62deff7196cfd0237f extends \Twig\Template
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
        echo "<!-- General Report -->
<div class=\"grid grid-cols-4 gap-6 xl:grid-cols-1 card-dasboard\">



<!-- card -->
<div class=\"report-card\">
<div class=\"card\">
<div class=\"card-body flex flex-col\">



<!-- top -->
<div class=\"flex flex-row justify-between items-center\">
<i class=\"fas fa-book\"></i>
<span class=\"rounded-full text-white badge bg-teal-400 text-xs Cours\">



</span>
</div>
<!-- end top -->
<!-- bottom -->
<div class=\"mt-8\">
<h1 class=\"h5 num-4\"></h1>
<p>Courses</p>
</div>
<!-- end bottom -->



</div>
</div>
<div class=\"footer bg-white p-1 mx-4 border border-t-0 rounded rounded-t-none\"></div>
</div>
<!-- end card -->




<!-- card -->
<div class=\"report-card\">
<div class=\"card\">
<div class=\"card-body flex flex-col\">



<!-- top -->
<div class=\"flex flex-row justify-between items-center\">
<i class=\"fas fa-comment-dots\"></i>
<span class=\"rounded-full text-white badge bg-teal-400 text-xs Messages\">
23
<i class=\"fal fa-chevron-up ml-1\"></i>
</span>
</div>
<!-- end top -->
<!-- bottom -->
<div class=\"mt-8\">
<h1 class=\"h5 num-4\"></h1>
<p>Messages</p>
</div>
<!-- end bottom -->



</div>
</div>
<div class=\"footer bg-white p-1 mx-4 border border-t-0 rounded rounded-t-none\"></div>
</div>
<!-- end card -->





<!-- card -->
<div class=\"report-card\">
<div class=\"card\">
<div class=\"card-body flex flex-col\">



<!-- top -->
<div class=\"flex flex-row justify-between items-center\">
<i class=\"fas fa-language\"></i>
<span class=\"rounded-full text-white badge bg-red-400 text-xs Module\">




</span>
</div>
<!-- end top -->
<!-- bottom -->
<div class=\"mt-8\">
<h1 class=\"h5 num-4\"></h1>
<p>Languages localization</p>
</div>
<!-- end bottom -->



</div>
</div>
<div class=\"footer bg-white p-1 mx-4 border border-t-0 rounded rounded-t-none\"></div>
</div>
<!-- end card -->




<!-- card -->
<div class=\"report-card\">
<div class=\"card\">
<div class=\"card-body flex flex-col\">



<!-- top -->
<div class=\"flex flex-row justify-between items-center\">
<i class=\"fas fa-language\"></i>
<span class=\"rounded-full text-white badge bg-teal-400 text-xs Messagestranslated\">



<i class=\"fal fa-chevron-up ml-1\"></i>
</span>
</div>
<!-- end top -->
<!-- bottom -->
<div class=\"mt-8\">
<h1 class=\"h5 num-4\"></h1>
<p>Localization Rate</p>
</div>
<!-- end bottom -->



</div>
</div>
<div class=\"footer bg-white p-1 mx-4 border border-t-0 rounded rounded-t-none\"></div>
</div>
<!-- end card -->




</div>";
    }

    public function getTemplateName()
    {
        return "__string_template__e65895a7d69e26053085dfe137a87bbfe89a5b2138740fd99ad340f80e830213";
    }

    public function getDebugInfo()
    {
        return array (  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "__string_template__e65895a7d69e26053085dfe137a87bbfe89a5b2138740fd99ad340f80e830213", "");
    }
    
    public function checkSecurity()
    {
        static $tags = array();
        static $filters = array();
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                [],
                [],
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
