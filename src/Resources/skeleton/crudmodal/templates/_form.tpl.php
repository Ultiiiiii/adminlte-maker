{{ form_start(form) }}
    {{ form_widget(form) }}
    <button class="btn btn-primary"><i class='fas fa-save'></i> {{ button_label|default('Save') }}</button>
{{ form_end(form) }}
