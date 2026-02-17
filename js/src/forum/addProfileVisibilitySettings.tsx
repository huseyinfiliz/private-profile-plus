import app from 'flarum/forum/app';
import { extend } from 'flarum/common/extend';
import SettingsPage from 'flarum/forum/components/SettingsPage';
import Select from 'flarum/common/components/Select';

function visibilityLabel(level: string): string {
  const key: Record<string, string> = {
    everyone: 'huseyinfiliz-private-profile-plus.forum.user.settings.option_everyone',
    members: 'huseyinfiliz-private-profile-plus.forum.user.settings.option_members',
    private: 'huseyinfiliz-private-profile-plus.forum.user.settings.option_private',
  };

  return key[level] ? (app.translator.trans(key[level]) as string) : level;
}

export default function addProfileVisibilitySettings() {
  extend(SettingsPage.prototype, 'settingsItems', function (this: SettingsPage, items) {
    const globalDefault = String(app.forum.attribute('profileVisibilityDefault') || 'everyone');
    const globalDefaultLabel = visibilityLabel(globalDefault);

    if (!this.user) return;

    const currentValue = String(this.user.preferences()?.profileVisibility || 'default');

    const defaultOptionLabel = app.translator.trans('huseyinfiliz-private-profile-plus.forum.user.settings.option_default', {
      level: globalDefaultLabel,
    });

    const options: Record<string, string> = {
      default: defaultOptionLabel as string,
      everyone: app.translator.trans('huseyinfiliz-private-profile-plus.forum.user.settings.option_everyone') as string,
      members: app.translator.trans('huseyinfiliz-private-profile-plus.forum.user.settings.option_members') as string,
      private: app.translator.trans('huseyinfiliz-private-profile-plus.forum.user.settings.option_private') as string,
    };

    items.add(
      'profileVisibility',
      m('.Form-group', [
        m('label', app.translator.trans('huseyinfiliz-private-profile-plus.forum.user.settings.profile_visibility_heading')),
        m('.helpText', app.translator.trans('huseyinfiliz-private-profile-plus.forum.user.settings.profile_visibility_help')),
        m(Select, {
          options: options,
          value: currentValue,
          onchange: (value: string) => {
            this.user!.savePreferences({ profileVisibility: value });
          },
        }),
      ])
    );
  });
}
