<template>
    <DefaultField
        :field="field"
        :errors="errors"
        :show-help-text="showHelpText"
        :full-width-content="true"
        @keydown.stop
    >
        <template #field>
            <div
                :id="`editor-js-${field.attribute}`"
                ref="input"
                class="editor-js"
            />
        </template>
    </DefaultField>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova';

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field'],

    data() {
        return {
            editor: null
        };
    },

    methods: {
        setInitialValue() {
            this.value = this.field.value;

            const self = this;

            const currentContent = (typeof self.field.value === 'object')
                ? self.field.value
                : JSON.parse(self.field.value);

            const editor = NovaEditorJS.getInstance({
                holder: `editor-js-${self.field.attribute}`,
                defaultBlock: self.field.editorSettings.initialBlock,
                placeholder: self.field.editorSettings.placeholder,
                autofocus: self.field.editorSettings.autofocus,
                i18n: {
                    direction: (self.field.editorSettings.rtl ?? false) ? 'rtl' : 'ltr',
                },
                data: currentContent,
                minHeight: 35,

                onReady() {
                    self.editor = editor;
                    self.$emit('editor-js-ready', editor);
                },
                onChange() {
                    editor.save().then((savedData) => {
                        self.handleChange(savedData);
                        self.$emit('editor-js-change', savedData);
                    });
                },
            }, self.field);
            
            this.editor = editor;
        },

        fill(formData) {
            if (this.editor) {
                this.editor.save().then((savedData) => {
                    const value = typeof savedData === 'string' ? savedData : JSON.stringify(savedData);
                    formData.append(this.field.attribute, value || '');
                });
            } else {
                const value = typeof this.value === 'string' ? this.value : JSON.stringify(this.value);
                formData.append(this.field.attribute, value || '');
            }
        },

        handleChange(value) {
            this.value = JSON.stringify(value);
        },

        getEditorData() {
            return new Promise((resolve) => {
                if (this.editor) {
                    this.editor.save().then(resolve);
                } else {
                    resolve(this.value);
                }
            });
        },

        getEditorInstance() {
            return this.editor;
        }
    },
};
</script>