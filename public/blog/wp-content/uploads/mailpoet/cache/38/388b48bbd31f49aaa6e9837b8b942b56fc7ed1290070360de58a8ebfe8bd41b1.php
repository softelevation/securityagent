<?php

use MailPoetVendor\Twig\Environment;
use MailPoetVendor\Twig\Error\LoaderError;
use MailPoetVendor\Twig\Error\RuntimeError;
use MailPoetVendor\Twig\Markup;
use MailPoetVendor\Twig\Sandbox\SecurityError;
use MailPoetVendor\Twig\Sandbox\SecurityNotAllowedTagError;
use MailPoetVendor\Twig\Sandbox\SecurityNotAllowedFilterError;
use MailPoetVendor\Twig\Sandbox\SecurityNotAllowedFunctionError;
use MailPoetVendor\Twig\Source;
use MailPoetVendor\Twig\Template;

/* deactivationSurvey/js.html */
class __TwigTemplate_be4c90b4639764998c1bc7c9b02bdf23871522a5d27049786fa2568911496583 extends \MailPoetVendor\Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 1
        echo "<script type=\"text/javascript\">
  jQuery(function(\$){
    var deactivateLink = \$('#the-list').find('[data-slug=\"mailpoet\"] span.deactivate a');
    var overlay = \$('#mailpoet-deactivate-survey');
    var closeButton = \$('#mailpoet-deactivate-survey-close');
    var formOpen = false;

    deactivateLink.on('click', function(event) {
      event.preventDefault();
      overlay.css('display', 'table');
      formOpen = true;
    });

    closeButton.on('click', function(event) {
      event.preventDefault();
      overlay.css('display', 'none');
      formOpen = false;
      location.href = deactivateLink.attr('href');
    });

    \$(document).keyup(function(event) {
      if ((event.keyCode === 27) && formOpen) {
        location.href = deactivateLink.attr('href');
      }
    });
  });
</script>
";
    }

    public function getTemplateName()
    {
        return "deactivationSurvey/js.html";
    }

    public function getDebugInfo()
    {
        return array (  30 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "deactivationSurvey/js.html", "D:\\xampp\\htdocs\\securityagent\\public\\blog\\wp-content\\plugins\\mailpoet\\views\\deactivationSurvey\\js.html");
    }
}
