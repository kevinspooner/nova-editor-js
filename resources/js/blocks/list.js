NovaEditorJS.booting((editorConfig, fieldConfig) => {
    if (fieldConfig.toolSettings.list.activated === true) {
        const listConfig = {
            class: require('@editorjs/list'),
            inlineToolbar: fieldConfig.toolSettings.list.inlineToolbar,
            shortcut: fieldConfig.toolSettings.list.shortcut,
        };
        
        // Add nested support if configured (nested lists are supported by default in @editorjs/list)
        if (fieldConfig.toolSettings.list.nested !== undefined) {
            listConfig.config = {
                // Nested lists are enabled by default in @editorjs/list
                // This option is here for future configuration if needed
            };
        }
        
        editorConfig.tools.list = listConfig;
    }
});
