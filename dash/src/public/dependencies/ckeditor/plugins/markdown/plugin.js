/**
 * Copyright (c) 2014-2020, CKSource - Frederico Knabben. All rights reserved.
 * Licensed under the terms of the MIT License (see LICENSE.md).
 *
 * Basic sample plugin inserting current date and time into the CKEditor editing area.
 *
 * Created out of the CKEditor Plugin SDK:
 * https://ckeditor.com/docs/ckeditor4/latest/guide/plugin_sdk_intro.html
 */

// Register the plugin within the editor.
CKEDITOR.plugins.add('markdown', {

	// Register the icons. They must match command names.
	icons: 'markdown',

	// The plugin initialization logic goes inside this method.
	init: function (editor) {

		// Define the editor command that inserts a timestamp.
		editor.addCommand('changeMarkdown', {
			modes: { wysiwyg: 0, source: 1 },

			// Define the function that will be fired when the command is executed.
			exec: function (editor) {
				markdown();
			}
		});

		// Create the toolbar button that executes the above command.
		editor.ui.addButton('Markdown', {
			label: 'Change Markdown',
			command: 'changeMarkdown',
			// toolbar: 'insert'
		});
	}
});
