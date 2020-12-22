{% extends '<?= $base_layout ?>' %}

{% block page_content %}
    <!-- start of modal -->
    {% if modal is defined and modal is not empty %}
        {{ include('<?= $route_name ?>/_modal.html.twig', { modal: modal } ) }}
    {% endif %}
    <!-- end of modal -->
    <div class="row">
        <div class="col-md-12">
            {% embed '@AdminLTE/Widgets/box-widget.html.twig' %}
                {% block box_before %}{% endblock %}
                {% block box_title %}{{ '<?= $entity_class_name ?> index'|trans }}{% endblock %}
                {% block box_tools %}
                <div class="pull-right">
                    <button class="btn btn-primary " data-toggle="modal" data-target="#modalEditNew"><i class="fa fa-plus-square"></i> {{ 'Create new'|trans }}</button>
                </div>
                {% endblock %}
                {% block box_body %}
                    <div id="<?= $entity_twig_var_plural ?>">{{ 'Loading'|trans }}...</div>
                {% endblock %}
                {% block box_footer %}{% endblock %}
                {% block box_after %}{% endblock %}
            {% endembed %}
        </div>
    </div>
{% endblock %}

{% block stylesheets %}
    {{ parent() }}
    <link rel="stylesheet" type="text/css" href="<?= $cdn_css ?>"/>
{% endblock %}

{% block javascripts %}
    {{ parent() }}
    <script type="text/javascript" src="<?= $cdn_js ?>"></script>
    <script src="{{ asset('bundles/datatables/js/datatables.js') }}"></script>
    <script type="text/javascript">
    $(function() {
        $('#<?= $entity_twig_var_plural ?>').initDataTables({{ datatable_settings(datatable) }});
    });
    </script>
{% endblock %}
