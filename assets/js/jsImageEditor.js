var initEditorImg = (selector, image) => {
  let TABS = FilerobotImageEditor.TABS;
  let TOOLS = FilerobotImageEditor.TOOLS;
  let config = {
    source: image,
    annotationsCommon: {
      fill: '#ff0000',
    },
    closeAfterSave: true,
    Text: { text: 'Filerobot...' },
    translations: {
      profile: 'Perfil',
      coverPhoto: 'Cover foto',
      facebook: 'Facebook',
      socialMedia: 'Social Media',
      fbProfileSize: '180x180px',
      fbCoverPhotoSize: '820x312px',
    },
    rect: {},
    language: 'es',
    // showBackButton: true,
    Crop: {
      presetsItems: [{
        titleKey: 'classicTv',
        descriptionKey: '4:3',
        ratio: 4 / 3,
        // icon: CropClassicTv, // optional, CropClassicTv is a React Function component. Possible (React Function component, string or HTML Element)
      }, {
        titleKey: 'cinemascope',
        descriptionKey: '21:9',
        ratio: 21 / 9,
        // icon: CropCinemaScope, // optional, CropCinemaScope is a React Function component.  Possible (React Function component, string or HTML Element)
      }],
      presetsFolders: [{
        titleKey: 'Media', // will be translated into Social Media as backend contains this translation key
        // icon: Social, // optional, Social is a React Function component. Possible (React Function component, string or HTML Element)
        groups: [{
          titleKey: 'facebook',
          items: [{
            titleKey: 'Perfil',
            width: 180,
            height: 180,
            descriptionKey: 'fbProfileSize',
          }, {
            titleKey: 'Cubrir Foto',
            width: 820,
            height: 312,
            descriptionKey: 'fbCoverPhotoSize',
          }],
        }],
      }],
    },
    defaultSavedImageName: 'defecto',
    defaultSavedImageType: 'png',
    tabsIds: [TABS.ADJUST], // or ['Adjust', TABS.ANNOTATE, TABS.WATERMARK]
    defaultTabId: TABS.ADJUST, // or 'Annotate'
    defaultToolId: TOOLS.TEXT, // or 'Text'
  };

  return new FilerobotImageEditor(document.querySelector(selector), config);
}