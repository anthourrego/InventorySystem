/**
 * @license Copyright (c) 2003-2022, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function (config) {
  // Define changes to default configuration here.
  // For complete reference see:
  // https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_config.html

  // The toolbar groups arrangement, optimized for two toolbar rows.
  config.toolbarGroups = [
    { name: 'document', groups: ['mode', 'document', 'doctools'] },
    { name: 'clipboard', groups: ['clipboard', 'undo'] },
    { name: 'editing', groups: ['find', 'selection', 'spellchecker', 'editing'] },
    { name: 'links', groups: ['links'] },
    { name: 'insert', groups: ['insert'] },
    { name: 'forms', groups: ['forms'] },
    { name: 'tools', groups: ['tools'] },
    { name: 'document', groups: ['mode', 'document', 'doctools'] },
    { name: 'others', groups: ['others'] },
    '/',
    { name: 'basicstyles', groups: ['basicstyles', 'cleanup'] },
    { name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align']},
    { name: 'styles', groups: ['Format', 'Font', 'FontSize'] },
    { name: 'colors', groups: ['colors'] },
    { name: 'about', groups: ['about'] },
    {
      name: 'align',
      groups: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
    },
  ];

  // Remove some buttons provided by the standard plugins, which are
  // not needed in the Standard(s) toolbar.
  // config.removeButtons = 'Underline,Subscript,Superscript';

  // Set the most common block elements.
  config.format_tags = 'p;h1;h2;h3;pre';

  // Simplify the dialog windows.
  config.removeDialogTabs = 'image:advanced;link:advanced';

  config.extraPlugins = 'colorbutton,colordialog, justify, font, dialog, dialogadvtab';

  config.height = 'calc(100vh - 340px)';
};
