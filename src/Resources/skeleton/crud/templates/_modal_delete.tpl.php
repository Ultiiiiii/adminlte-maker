<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="modalDelete">{{ modal.title }}</h4>
            </div>
            {% embed '@AdminLTE/Widgets/box-widget.html.twig' %}
{#                {% if modal.form is defined and modal.form is not empty %}#}
{#                    {% block box_before %}{{ form_start(modal.form) }}{% endblock %}#}
{#                {% endif %}#}

{#                {% if modal.title is defined and modal.title is not empty %}#}
{#                    {% block box_title %}{{ modal.title|trans }}{% endblock %}#}
{#                {% endif %}#}

                {% block box_body %}
                    {% if form is defined and form is not empty %}
                        {{ form_widget(form) }}
                    {% endif %}

                    {% if modal.message is defined and modal.message is not empty %}
                        {{ modal.message | raw }}
                    {% endif %}

                {% endblock %}

                {% block box_footer %}
                    <div class="pull-right">
                       <a type="submit" class="btn btn-danger" role="button" href="{{ path('<?= $route_name ?>_delete', {'id': <?= $entity_twig_var_singular ?>.<?= $entity_identifier ?>, 'token': csrf_token('delete' ~ <?= $entity_twig_var_singular ?>.<?= $entity_identifier ?>) }) }}" >{{ 'Delete'|trans }}</a>
                    </div>

                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ 'Close'|trans }}</button>
                {% endblock %}

                {% block box_after %}
                    {% if modal.form is defined and modal.form is not empty %}
                        {{ form_end(modal.form) }}
                    {% endif %}
                {% endblock %}
            {% endembed %}
        </div>
    </div>
</div>