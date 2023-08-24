<?php

use Backpack\Basset\Facades\Basset;
?>
<!-- select2 from array -->
@php
    $field['allows_null'] = $field['allows_null'] ?? $crud->model::isColumnNullable($field['name']);
@endphp
@include('crud::fields.inc.wrapper_start')
    <label>{!! $field['label'] !!}</label>
    <select
        name="{{ $field['name'] }}@if (isset($field['allows_multiple']) && $field['allows_multiple']==true)[]@endif"
        style="width: 100%"
        data-init-function="bpFieldInitSelect2FromArrayElement"
        data-field-is-inline="{{var_export($inlineCreate ?? false)}}"
        data-language="{{ str_replace('_', '-', app()->getLocale()) }}"
        @include('crud::fields.inc.attributes', ['default_class' =>  'form-control select2_from_array'])
        @if (isset($field['allows_multiple']) && $field['allows_multiple']==true)multiple @endif
        >

        @if ($field['allows_null'])
            <option value="">-</option>
        @endif

        @if (count($field['options']))
            @foreach ($field['options'] as $key => $value)
                @if((old(square_brackets_to_dots($field['name'])) !== null && (
                        $key == old(square_brackets_to_dots($field['name'])) ||
                        (is_array(old(square_brackets_to_dots($field['name']))) &&
                        in_array($key, old(square_brackets_to_dots($field['name'])))))) ||
                        (null === old(square_brackets_to_dots($field['name'])) &&
                            ((isset($field['value']) && (
                                        $key == $field['value'] || (
                                                is_array($field['value']) &&
                                                in_array($key, $field['value'])
                                                )
                                        )) ||
                                (!isset($field['value']) && isset($field['default']) &&
                                ($key == $field['default'] || (
                                                is_array($field['default']) &&
                                                in_array($key, $field['default'])
                                            )
                                        )
                                ))
                        ))
                    <option value="{{ $key }}" selected>{{ $value }}</option>
                @else
                    <option value="{{ $key }}">{{ $value }}</option>
                @endif
            @endforeach
        @endif
    </select>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
@include('crud::fields.inc.wrapper_end')

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field);
    @endphp

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
        {{-- How to load a CSS file? --}}
        @basset('public/assets/Packages/select2/dist/css/select2.min.css')
        @basset('public/assets/Packages/select2-bootstrap-theme/dist/select2-bootstrap.min.css')

        {{-- How to add some CSS? --}}
        <!-- @bassetBlock('backpack/crud/fields/select_multiple_from_array_field-style.css')
            <style>
                .select_multiple_from_array_field_class {
                    display: none;
                }
            </style>
        @endBassetBlock -->
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        {{-- How to load a JS file? --}}
        @basset('public/assets/Packages/select2/dist/js/select2.full.min.js')

        {{-- How to add some JS to the field? --}}
        @bassetBlock('path/to/script.js')
        <script>
            // function bpFieldInitDummyFieldElement(element) {
            //     // this function will be called on pageload, because it's
            //     // present as data-init-function in the HTML above; the
            //     // element parameter here will be the jQuery wrapped
            //     // element where init function was defined
            //     console.log(element.val());
            // }
        </script>
        @endBassetBlock
        <script>
            function bpFieldInitSelect2FromArrayElement(element) {
                if (!element.hasClass("select2-hidden-accessible"))
                    {
                        let $isFieldInline = element.data('field-is-inline');

                        element.select2({
                            theme: "bootstrap",
                            dropdownParent: $isFieldInline ? $('#inline-create-dialog .modal-content') : document.body
                        }).on('select2:unselect', function(e) {
                            if ($(this).attr('multiple') && $(this).val().length == 0) {
                                $(this).val(null).trigger('change');
                            }
                        });
                    }
            }
        </script>
    @endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}


