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

<<<<<<< HEAD
/* __string_template__658f0776441ff29d0f35d5256185c045c009c9c355e64bcc639287352c9a993e */
class __TwigTemplate_3600c7e58f8ed9356c7c3228a04af70fecc2d24717291b5d95ab914c1c412eae extends \Twig\Template
=======
<<<<<<< HEAD:sites/default/files/php/twig/62241ff69a851___string_template__572eac_CF4MM0XiJewGtNxWoelyyPsNm/zn9QcTcYXHxqMpjd3QvykI9ECSZFbQpIlUp42Oe8gMY.php
/* __string_template__572eac398cdb2f58b3d57352e6704a32900744f2402b2444b3f9a2ca8580119d */
class __TwigTemplate_dcc9081a807806c37fab4aceae365ee75c372463d7035f814383530a6c48de9b extends \Twig\Template
=======
/* __string_template__658f0776441ff29d0f35d5256185c045c009c9c355e64bcc639287352c9a993e */
class __TwigTemplate_3600c7e58f8ed9356c7c3228a04af70fecc2d24717291b5d95ab914c1c412eae extends \Twig\Template
>>>>>>> CmstNewVersion2:sites/default/files/php/twig/62241ff69a851___string_template__658f07_AMgUBE0RiuYi_xisTaImI0SI5/zas0q8MfP5czUgtzC81CbJwBjQumbxfxbBMPYcjLOAQ.php
>>>>>>> CmstNewVersion2
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
<<<<<<< HEAD
        echo "destination=/digitalcms9/en/node/638";
=======
<<<<<<< HEAD:sites/default/files/php/twig/62241ff69a851___string_template__572eac_CF4MM0XiJewGtNxWoelyyPsNm/zn9QcTcYXHxqMpjd3QvykI9ECSZFbQpIlUp42Oe8gMY.php
        echo "0 Module";
=======
        echo "destination=/digitalcms9/en/node/638";
>>>>>>> CmstNewVersion2:sites/default/files/php/twig/62241ff69a851___string_template__658f07_AMgUBE0RiuYi_xisTaImI0SI5/zas0q8MfP5czUgtzC81CbJwBjQumbxfxbBMPYcjLOAQ.php
>>>>>>> CmstNewVersion2
    }

    public function getTemplateName()
    {
<<<<<<< HEAD
        return "__string_template__658f0776441ff29d0f35d5256185c045c009c9c355e64bcc639287352c9a993e";
=======
<<<<<<< HEAD:sites/default/files/php/twig/62241ff69a851___string_template__572eac_CF4MM0XiJewGtNxWoelyyPsNm/zn9QcTcYXHxqMpjd3QvykI9ECSZFbQpIlUp42Oe8gMY.php
        return "__string_template__572eac398cdb2f58b3d57352e6704a32900744f2402b2444b3f9a2ca8580119d";
=======
        return "__string_template__658f0776441ff29d0f35d5256185c045c009c9c355e64bcc639287352c9a993e";
>>>>>>> CmstNewVersion2:sites/default/files/php/twig/62241ff69a851___string_template__658f07_AMgUBE0RiuYi_xisTaImI0SI5/zas0q8MfP5czUgtzC81CbJwBjQumbxfxbBMPYcjLOAQ.php
>>>>>>> CmstNewVersion2
    }

    public function getDebugInfo()
    {
        return array (  39 => 1,);
    }

    public function getSourceContext()
    {
<<<<<<< HEAD
        return new Source("", "__string_template__658f0776441ff29d0f35d5256185c045c009c9c355e64bcc639287352c9a993e", "");
=======
<<<<<<< HEAD:sites/default/files/php/twig/62241ff69a851___string_template__572eac_CF4MM0XiJewGtNxWoelyyPsNm/zn9QcTcYXHxqMpjd3QvykI9ECSZFbQpIlUp42Oe8gMY.php
        return new Source("", "__string_template__572eac398cdb2f58b3d57352e6704a32900744f2402b2444b3f9a2ca8580119d", "");
=======
        return new Source("", "__string_template__658f0776441ff29d0f35d5256185c045c009c9c355e64bcc639287352c9a993e", "");
>>>>>>> CmstNewVersion2:sites/default/files/php/twig/62241ff69a851___string_template__658f07_AMgUBE0RiuYi_xisTaImI0SI5/zas0q8MfP5czUgtzC81CbJwBjQumbxfxbBMPYcjLOAQ.php
>>>>>>> CmstNewVersion2
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
