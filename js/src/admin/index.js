import app from 'flarum/admin/app';

app.initializers.add('private-profile-plus', () => {
  app.extensionData
    .for('huseyinfiliz-private-profile-plus')
    .registerSetting({
      setting: 'huseyinfiliz-private-profile-plus.default_visibility',
      type: 'select',
      label: app.translator.trans('huseyinfiliz-private-profile-plus.admin.settings.default_visibility_label'),
      help: app.translator.trans('huseyinfiliz-private-profile-plus.admin.settings.default_visibility_help'),
      options: {
        everyone: app.translator.trans('huseyinfiliz-private-profile-plus.admin.settings.option_everyone'),
        members: app.translator.trans('huseyinfiliz-private-profile-plus.admin.settings.option_members'),
        private: app.translator.trans('huseyinfiliz-private-profile-plus.admin.settings.option_private'),
      },
      default: 'everyone',
    })
    .registerPermission(
      {
        icon: 'fas fa-eye',
        label: app.translator.trans('huseyinfiliz-private-profile-plus.admin.permissions.bypass_profile_visibility'),
        permission: 'huseyinfiliz-private-profile-plus.bypassProfileVisibility',
      },
      'moderate'
    );
});
