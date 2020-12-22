{% extends '<?= $base_layout ?>' %}

{% block page_content %}
    <!-- start of modal -->
    {% if modal is defined and modal is not empty %}
        {{ include('<?= $route_name ?>/_modal.html.twig', { modal: modal } ) }}
    {% endif %}
    <!-- end of modal -->
    {% if modalDelete is defined and modalDelete is not empty %}
        {{ include('<?= $route_name ?>/_modal_delete.html.twig', { modal: modalDelete } ) }}
    {% endif %}
    <!-- end of modal -->

    <div class="row">
        <div class="col-md-12">
            {% embed '@AdminLTE/Widgets/box-widget.html.twig' %}
                {% block box_before %}{% endblock %}
                {% block box_title %}{{ '<?= $entity_class_name ?>'|trans }}{% endblock %}
                {% block box_body %}
    <table class="table">
        <tbody>
<?php foreach ($entity_fields as $field): ?>
            <tr>
                <th>{{ '<?= ucfirst($field['fieldName']) ?>'|trans }}</th>
                <td>{{ <?= $helper->getEntityFieldPrintCode($entity_twig_var_singular, $field) ?> }}</td>
            </tr>
<?php endforeach; ?>
        </tbody>
    </table>
    {% endblock %}
                {% block box_footer %}
                    <div class="pull-right">
                        <button class="btn btn-primary "data-toggle="modal" data-target="#modalEditNew"><i class='fas fa-edit'></i> {{ 'Edit'|trans }}</button>
                        <a class="btn btn-warning " href="{{ path('<?= $route_name ?>_index') }}"><i class='fas fa-arrow-alt-circle-left'></i> {{ 'Back to list'|trans }}</a>
                        <button type="button" class="btn btn-danger"  data-toggle="modal" data-target="#modalDelete"><i class='fas fa-trash'></i> {{ 'Delete'|trans }}</button>
                    </div>
                {% endblock %}
                {% block box_after %}{% endblock %}
            {% endembed %}
        </div>
    </div>
{% endblock %}
