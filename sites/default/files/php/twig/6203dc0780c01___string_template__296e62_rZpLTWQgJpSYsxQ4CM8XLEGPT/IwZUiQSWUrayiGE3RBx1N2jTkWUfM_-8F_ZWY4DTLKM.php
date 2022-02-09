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

/* __string_template__296e62595275a05c87c5ebed3d1c2d6fc69dfe28504b026d87e62a94a3d1d7f5 */
class __TwigTemplate_ee0bc6fa95da71b1624adba56292ab7ccece3b2be46ff86cc1d1c32a61483993 extends \Twig\Template
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
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["name"] ?? null), 2, $this->source), "html", null, true);
        echo "  </div> </div> <p class='has-commented'>Has commented on localization </p>



<p class='commented-body' >";
        // line 6
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["field_commentbody2"] ?? null), 6, $this->source), "html", null, true);
        echo "</p>
<p class='commented-date'>";
        // line 7
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["created"] ?? null), 7, $this->source), "html", null, true);
        echo " </p>
<div class='commente-links'>
<p class='commente commented-delete'> ";
        // line 9
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["delete_comment"] ?? null), 9, $this->source), "html", null, true);
        echo " <i class=\"fa fa-trash-o\"></i></p>
<p class='commente commented-edit'> ";
        // line 10
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["edit_comment"] ?? null), 10, $this->source), "html", null, true);
        echo " <i class=\"fa fa-pencil\"></i> </p>
<p class='commente commented-replyto'> ";
        // line 11
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["replyto_comment"] ?? null), 11, $this->source), "html", null, true);
        echo " <i class=\"fa fa-mail-reply\"></i></p>
</div>
<div class='separateur-comment'> </div>
</div>";
    }

    public function getTemplateName()
    {
        return "__string_template__296e62595275a05c87c5ebed3d1c2d6fc69dfe28504b026d87e62a94a3d1d7f5";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  68 => 11,  64 => 10,  60 => 9,  55 => 7,  51 => 6,  42 => 2,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "__string_template__296e62595275a05c87c5ebed3d1c2d6fc69dfe28504b026d87e62a94a3d1d7f5", "");
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
