{% extends '<?= $base_layout ?>' %}

{% block page_content %}
    <div class="row">
        <div class="col-md-12">
            {% embed '@AdminLTE/Widgets/box-widget.html.twig' %}
                {% block box_before %}{{ form_start(form) }}{% endblock %}
                {% block box_title %}{{ 'Edit <?= strtolower($entity_class_name) ?>'|trans }}{% endblock %}
                {% block box_body %}
                    {{ form_widget(form) }}
                {% endblock %}
                {% block box_footer %}
                    <div class="pull-right">
                        <button type="submit" class="btn btn-primary"><i class='fas fa-save'></i> {{ button_label|default('Save'|trans) }}</button>
                        <a class="btn btn-warning " href="{{ path('<?= $route_name ?>_index') }}"><i class='fas fa-arrow-alt-circle-left'></i> {{ 'Back to list'|trans }}</a>
                    </div>
                {% endblock %}
                {% block box_after %}{{ form_end(form) }}{% endblock %}
            {% endembed %}
        </div>
    </div>
{% endblock %}
