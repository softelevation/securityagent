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

/* mp2migration.html */
class __TwigTemplate_95e25a287e15150c9c66620d62ed8dd99c16a03707f6dc19af1f0d47d81022bc extends \MailPoetVendor\Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->blocks = [
            'content' => [$this, 'block_content'],
            'after_javascript' => [$this, 'block_after_javascript'],
            'translations' => [$this, 'block_translations'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "layout.html";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $this->parent = $this->loadTemplate("layout.html", "mp2migration.html", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = [])
    {
        // line 4
        echo "
<div class=\"wrap mailpoet-about-wrap\">
  <h1>";
        // line 6
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Welcome to MailPoet version 3!");
        echo " ";
        echo \MailPoetVendor\twig_escape_filter($this->env, $this->getAttribute(($context["settings"] ?? null), "version", []), "html", null, true);
        echo "</h1>

  <p class=\"about-text\">";
        // line 8
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Before we start, we will first migrate your data automatically from your previous MailPoet to the new one.");
        echo "</p>

  <h3>";
        // line 10
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("What will be kept in MailPoet 3");
        echo "</h3>
  <ul class=\"default-list\">
    <li><strong>";
        // line 12
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Subscribers and lists");
        echo " <img draggable=\"false\" class=\"emoji\" alt=\"✔\" src=\"https://s.w.org/images/core/emoji/2.2.1/svg/2714.svg\"></strong></li>
    <li><strong>";
        // line 13
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Forms");
        echo " <img draggable=\"false\" class=\"emoji\" alt=\"✔\" src=\"https://s.w.org/images/core/emoji/2.2.1/svg/2714.svg\"></strong></li>
    <li><strong>";
        // line 14
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Settings");
        echo " <img draggable=\"false\" class=\"emoji\" alt=\"✔\" src=\"https://s.w.org/images/core/emoji/2.2.1/svg/2714.svg\"></strong></li>
    <li>";
        // line 15
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Archive of sent newsletters (will not be migrated)");
        echo "</li>
    <li>";
        // line 16
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Statistics (will not be migrated)");
        echo "</li>
  </ul>
  <div style=\"position: absolute; top: .2em; right: 0;\"></div>
  <hr />

  <div>
    <br />
    <div id=\"import-actions\">
      <input type=\"submit\" name=\"import\" id=\"import\" class=\"button button-primary\" value=\"";
        // line 24
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Start upgrade");
        echo "\"  />
      <input type=\"submit\" name=\"stop-import\" id=\"stop-import\" class=\"button button-secondary\" value=\"";
        // line 25
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Pause");
        echo "\" style=\"display: none\"/>
      <small> <a id=\"skip-import\" href=\"#\">";
        // line 26
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("No thanks, I'll skip and start from scratch.");
        echo "</a></small>
      <br />
      <br />
    </div>

    <div id=\"progressbar\" class=\"mailpoet_progress mailpoet_progress_complete\" style=\"display: none\">
      <span id=\"progresslabel\" class=\"mailpoet_progress_label\">0%</span>
    </div>

    <div id=\"upgrade-completed\" style=\"display: none\">
      <h3>";
        // line 36
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Upgrade completed!");
        echo "</h3>
      <input type=\"button\" name=\"goto-welcome\" id=\"goto-welcome\" class=\"button button-primary\" value=\"";
        // line 37
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Go to MailPoet");
        echo "\"  />
    </div>

    <br />
    <div id=\"logger-container\" style=\"display: none\">
      <small><strong>";
        // line 42
        echo $this->env->getExtension('MailPoet\Twig\I18n')->translate("Log...");
        echo "</strong></small>
      <div id=\"logger\"></div>
    </div>

  </div>

</div>
";
    }

    // line 51
    public function block_after_javascript($context, array $blocks = [])
    {
        // line 52
        echo "  ";
        echo $this->env->getExtension('MailPoet\Twig\Assets')->generateJavascript("mp2migrator.js");
        // line 54
        echo "
  <script type=\"text/javascript\">
    var mailpoet_mp2_migrator = {
      log_file_url: '";
        // line 57
        echo \MailPoetVendor\twig_escape_filter($this->env, ($context["log_file_url"] ?? null), "html", null, true);
        echo "',
      progress_url: '";
        // line 58
        echo \MailPoetVendor\twig_escape_filter($this->env, ($context["progress_url"] ?? null), "html", null, true);
        echo "'
    };
  </script>
";
    }

    // line 63
    public function block_translations($context, array $blocks = [])
    {
        // line 64
        echo "  ";
        echo $this->env->getExtension('MailPoet\Twig\I18n')->localize(["import_complete" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("IMPORT COMPLETE"), "importing" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("Importing…"), "import_stopped_by_user" => $this->env->getExtension('MailPoet\Twig\I18n')->translate("IMPORT STOPPED BY USER")]);
        // line 68
        echo "
";
    }

    public function getTemplateName()
    {
        return "mp2migration.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  166 => 68,  163 => 64,  160 => 63,  152 => 58,  148 => 57,  143 => 54,  140 => 52,  137 => 51,  125 => 42,  117 => 37,  113 => 36,  100 => 26,  96 => 25,  92 => 24,  81 => 16,  77 => 15,  73 => 14,  69 => 13,  65 => 12,  60 => 10,  55 => 8,  48 => 6,  44 => 4,  41 => 3,  31 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "mp2migration.html", "D:\\xampp\\htdocs\\securityagent\\public\\blog\\wp-content\\plugins\\mailpoet\\views\\mp2migration.html");
    }
}
