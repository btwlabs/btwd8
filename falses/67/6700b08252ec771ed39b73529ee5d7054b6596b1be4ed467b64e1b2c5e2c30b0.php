<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* themes/contrib/basic/templates/page.html.twig */
class __TwigTemplate_6a249487b1ab219064df5dfefe056e477b8ab485ed475d9d33b48e1f36cf21c2 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $tags = ["set" => 1, "if" => 11];
        $filters = ["render" => 1, "escape" => 3];
        $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['set', 'if'],
                ['render', 'escape'],
                []
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->getSourceContext());

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

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 1
        $context["main_menu"] = $this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar($this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "primary_menu", [])));
        // line 2
        $context["secondary_menu"] = $this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar($this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "secondary_menu", [])));
        // line 3
        echo "<div";
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["attributes"] ?? null), "addClass", [0 => "layout-container", 1 => (((        // line 5
($context["main_menu"] ?? null) || ($context["secondary_menu"] ?? null))) ? ("with-navigation") : ("")), 2 => ((        // line 6
($context["secondary_menu"] ?? null)) ? ("with-subnav") : (""))], "method")), "html", null, true);
        // line 7
        echo ">

  <!-- ______________________ HEADER _______________________ -->

  ";
        // line 11
        if ($this->getAttribute(($context["page"] ?? null), "header", [])) {
            // line 12
            echo "    <header id=\"header\">
      <div class=\"container\">
        <div id=\"header-region\">
          ";
            // line 15
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "header", [])), "html", null, true);
            echo "
        </div>
      </div>
    </header><!-- /#header -->
  ";
        }
        // line 20
        echo "
  ";
        // line 21
        if ((($context["main_menu"] ?? null) || ($context["secondary_menu"] ?? null))) {
            // line 22
            echo "    <nav id=\"navigation\" class=\"menu";
            if (($context["main_menu"] ?? null)) {
                echo " with-primary";
            }
            if (($context["secondary_menu"] ?? null)) {
                echo " with-secondary";
            }
            echo "\">
      <div class=\"container\">
        ";
            // line 24
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["main_menu"] ?? null)), "html", null, true);
            echo "
        ";
            // line 25
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["secondary_menu"] ?? null)), "html", null, true);
            echo "
      </div>
    </nav><!-- /#navigation -->
  ";
        }
        // line 29
        echo "
  <!-- ______________________ MAIN _______________________ -->

  <div id=\"main\">
    <div class=\"container\">
      <div id=\"content-wrapper\">
        <section id=\"content\">

          <div id=\"content-header\">

            ";
        // line 39
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "breadcrumb", [])), "html", null, true);
        echo "

            ";
        // line 41
        if ($this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar($this->getAttribute(($context["page"] ?? null), "highlighted", []))) {
            // line 42
            echo "              <div id=\"highlighted\">";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "highlighted", [])), "html", null, true);
            echo "</div>
            ";
        }
        // line 44
        echo "
            ";
        // line 45
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["title_prefix"] ?? null)), "html", null, true);
        echo "

            ";
        // line 47
        if (($context["title"] ?? null)) {
            // line 48
            echo "              <h1 class=\"title\">";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["title"] ?? null)), "html", null, true);
            echo "</h1>
            ";
        }
        // line 50
        echo "
            ";
        // line 51
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["title_suffix"] ?? null)), "html", null, true);
        echo "
            ";
        // line 52
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "help", [])), "html", null, true);
        echo "

            ";
        // line 54
        if (($context["tabs"] ?? null)) {
            // line 55
            echo "              <div class=\"tabs\">";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["tabs"] ?? null)), "html", null, true);
            echo "</div>
            ";
        }
        // line 57
        echo "
            ";
        // line 58
        if (($context["action_links"] ?? null)) {
            // line 59
            echo "              <ul class=\"action-links\">";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["action_links"] ?? null)), "html", null, true);
            echo "</ul>
            ";
        }
        // line 61
        echo "
          </div><!-- /#content-header -->

          <div id=\"content-area\">
            ";
        // line 65
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "content", [])), "html", null, true);
        echo "
          </div>

        </section><!-- /#content -->

        ";
        // line 70
        if ($this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar($this->getAttribute(($context["page"] ?? null), "sidebar_first", []))) {
            // line 71
            echo "          <aside id=\"sidebar-first\" class=\"column sidebar first\">
            ";
            // line 72
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "sidebar_first", [])), "html", null, true);
            echo "
          </aside><!-- /#sidebar-first -->
        ";
        }
        // line 75
        echo "
        ";
        // line 76
        if ($this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar($this->getAttribute(($context["page"] ?? null), "sidebar_second", []))) {
            // line 77
            echo "          <aside id=\"sidebar-second\" class=\"column sidebar second\">
            ";
            // line 78
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "sidebar_second", [])), "html", null, true);
            echo "
          </aside><!-- /#sidebar-second -->
        ";
        }
        // line 81
        echo "
      </div><!-- /#content-wrapper -->
    </div><!-- /.container -->
  </div><!-- /#main -->

  <!-- ______________________ FOOTER _______________________ -->

  ";
        // line 88
        if ($this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar($this->getAttribute(($context["page"] ?? null), "footer", []))) {
            // line 89
            echo "    <footer id=\"footer\">
      <div class=\"container\">
        <div id=\"footer-region\">
          ";
            // line 92
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "footer", [])), "html", null, true);
            echo "
        </div>
      </div>
    </footer><!-- /#footer -->
  ";
        }
        // line 97
        echo "
</div><!-- /.layout-container -->
";
    }

    public function getTemplateName()
    {
        return "themes/contrib/basic/templates/page.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  247 => 97,  239 => 92,  234 => 89,  232 => 88,  223 => 81,  217 => 78,  214 => 77,  212 => 76,  209 => 75,  203 => 72,  200 => 71,  198 => 70,  190 => 65,  184 => 61,  178 => 59,  176 => 58,  173 => 57,  167 => 55,  165 => 54,  160 => 52,  156 => 51,  153 => 50,  147 => 48,  145 => 47,  140 => 45,  137 => 44,  131 => 42,  129 => 41,  124 => 39,  112 => 29,  105 => 25,  101 => 24,  90 => 22,  88 => 21,  85 => 20,  77 => 15,  72 => 12,  70 => 11,  64 => 7,  62 => 6,  61 => 5,  59 => 3,  57 => 2,  55 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("{% set main_menu = page.primary_menu|render %}
{% set secondary_menu = page.secondary_menu|render %}
<div{{ attributes.addClass(
  'layout-container',
  main_menu or secondary_menu ? 'with-navigation',
  secondary_menu ? 'with-subnav'
) }}>

  <!-- ______________________ HEADER _______________________ -->

  {% if page.header %}
    <header id=\"header\">
      <div class=\"container\">
        <div id=\"header-region\">
          {{ page.header }}
        </div>
      </div>
    </header><!-- /#header -->
  {% endif %}

  {% if main_menu or secondary_menu %}
    <nav id=\"navigation\" class=\"menu{% if main_menu %} with-primary{% endif %}{% if secondary_menu %} with-secondary{% endif %}\">
      <div class=\"container\">
        {{ main_menu }}
        {{ secondary_menu }}
      </div>
    </nav><!-- /#navigation -->
  {% endif %}

  <!-- ______________________ MAIN _______________________ -->

  <div id=\"main\">
    <div class=\"container\">
      <div id=\"content-wrapper\">
        <section id=\"content\">

          <div id=\"content-header\">

            {{ page.breadcrumb }}

            {% if page.highlighted|render %}
              <div id=\"highlighted\">{{ page.highlighted }}</div>
            {% endif %}

            {{ title_prefix }}

            {% if title %}
              <h1 class=\"title\">{{ title }}</h1>
            {% endif %}

            {{ title_suffix }}
            {{ page.help }}

            {% if tabs %}
              <div class=\"tabs\">{{ tabs }}</div>
            {% endif %}

            {% if action_links %}
              <ul class=\"action-links\">{{ action_links }}</ul>
            {% endif %}

          </div><!-- /#content-header -->

          <div id=\"content-area\">
            {{ page.content }}
          </div>

        </section><!-- /#content -->

        {% if page.sidebar_first|render %}
          <aside id=\"sidebar-first\" class=\"column sidebar first\">
            {{ page.sidebar_first }}
          </aside><!-- /#sidebar-first -->
        {% endif %}

        {% if page.sidebar_second|render %}
          <aside id=\"sidebar-second\" class=\"column sidebar second\">
            {{ page.sidebar_second }}
          </aside><!-- /#sidebar-second -->
        {% endif %}

      </div><!-- /#content-wrapper -->
    </div><!-- /.container -->
  </div><!-- /#main -->

  <!-- ______________________ FOOTER _______________________ -->

  {% if page.footer|render %}
    <footer id=\"footer\">
      <div class=\"container\">
        <div id=\"footer-region\">
          {{ page.footer }}
        </div>
      </div>
    </footer><!-- /#footer -->
  {% endif %}

</div><!-- /.layout-container -->
", "themes/contrib/basic/templates/page.html.twig", "/app/themes/contrib/basic/templates/page.html.twig");
    }
}
