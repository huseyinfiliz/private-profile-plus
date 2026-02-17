import app from 'flarum/forum/app';
import addProfileVisibilitySettings from './addProfileVisibilitySettings';
import addProfileVisibilityHandler from './addProfileVisibilityHandler';

app.initializers.add('private-profile-plus', () => {
  addProfileVisibilitySettings();
  addProfileVisibilityHandler();
});
