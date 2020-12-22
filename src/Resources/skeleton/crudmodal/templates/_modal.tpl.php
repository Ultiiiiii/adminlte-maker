<div class="modal fade" id="modalEditNew" tabindex="-1" role="dialog" aria-labelledby="modalEditNewLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="modalEditNewLabel">{{ modal.title }}</h4>
            </div>
            {% embed '@AdminLTE/Widgets/box-widget.html.twig' %}
                {% block box_before %}{{ form_start(modal.form) }}{% endblock %}
{#                {% block box_title %}{{ 'Title'|trans }}{% endblock %}#}

                {% block box_body %}
                    {% if modal.form is defined and modal.form is not empty %}
                        {{ form_widget(modal.form) }}
                    {% endif %}
                    {% if modal.message is defined and modal.message is not empty %}
                        {{ modal.message | raw }}
                    {% endif %}

                {% endblock %}

                {% block box_footer %}
                    {% if modal.footer is defined and modal.footer is not empty %}
                        {{ modal.footer | raw }}
                    {% endif %}
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