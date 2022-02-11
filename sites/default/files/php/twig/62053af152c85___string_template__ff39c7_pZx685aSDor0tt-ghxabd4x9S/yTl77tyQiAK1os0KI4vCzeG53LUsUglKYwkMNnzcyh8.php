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

/* __string_template__ff39c7c8fd786e9889b36bc71356f47aea8bc0b6a454768a87ba62e1b67ed031 */
class __TwigTemplate_82b80cadad956b108b044c0fbfe931b7ff57f963c4075105cb0f2758b3dc132e extends \Twig\Template
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
        echo "<div>
<div class='image-profile-user' > ";
        // line 2
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["user_picture"] ?? null), 2, $this->source), "html", null, true);
        echo " <div class='name-profile-user'> ";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["uid"] ?? null), 2, $this->source), "html", null, true);
        echo " </div> </div>
<p class='has-commented'>Has commented on localization </p> 
<p  class='commented-body' >";
        // line 4
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["field_commentbody2"] ?? null), 4, $this->source), "html", null, true);
        echo "</p> 
<p class='commented-date'>";
        // line 5
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["created"] ?? null), 5, $this->source), "html", null, true);
        echo " </p>
<div class='commente-links'>
<p class='commente commented-delete'> ";
        // line 7
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["delete_comment"] ?? null), 7, $this->source), "html", null, true);
        echo " <i class=\"fa fa-trash-o\"></i></p>
<p class='commente  commented-edit'>  ";
        // line 8
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["edit_comment"] ?? null), 8, $this->source), "html", null, true);
        echo " <i class=\"fa fa-pencil\"></i> </p>
<p class='commente  commented-replyto'>  ";
        // line 9
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["replyto_comment"] ?? null), 9, $this->source), "html", null, true);
        echo "  <i class=\"fa fa-mail-reply\"></i></p>
</div>
<div class='separateur-comment'> </div>
</div>";
    }

    public function getTemplateName()
    {
        return "__string_template__ff39c7c8fd786e9889b36bc71356f47aea8bc0b6a454768a87ba62e1b67ed031";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  66 => 9,  62 => 8,  58 => 7,  53 => 5,  49 => 4,  42 => 2,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "__string_template__ff39c7c8fd786e9889b36bc71356f47aea8bc0b6a454768a87ba62e1b67ed031", "");
    }
    
    public function checkSecurity()
    {
        static $tags = array();
        static $filters = array("escape" => 2);
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
