import { extend } from 'flarum/common/extend';
import UserPage from 'flarum/forum/components/UserPage';
import app from 'flarum/forum/app';

export default function addProfileVisibilityHandler() {
  extend(UserPage.prototype, 'onupdate', function () {
    const user = this.user;

    if (!user) return;

    const effectiveVisibility = user.attribute('effectiveProfileVisibility');
    const currentUser = app.session.user;
    const isOwner = currentUser && currentUser.id() === user.id();
    const canBypass = app.forum.attribute('canBypassProfileVisibility');

    let canView = true;

    switch (effectiveVisibility) {
      case 'everyone':
        canView = true;
        break;
      case 'members':
        canView = !!currentUser;
        break;
      case 'private':
        canView = !!(isOwner || canBypass);
        break;
      default:
        canView = true;
    }

    if (canView) return;

    // Show appropriate message
    const placeholderElement = this.element.querySelector('.PostsUserPage .Placeholder, .DiscussionsUserPage .Placeholder');

    if (placeholderElement?.querySelector('p')) {
      let messageKey: string;

      if (effectiveVisibility === 'members') {
        messageKey = 'huseyinfiliz-private-profile-plus.forum.profile_members_only';
      } else {
        messageKey = 'huseyinfiliz-private-profile-plus.forum.profile_private';
      }

      placeholderElement.querySelector('p')!.textContent = app.translator.trans(messageKey) as string;
    }
  });
}
