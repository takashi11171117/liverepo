import { shallowMount, createLocalVue, RouterLinkStub } from '@vue/test-utils'
import test from 'ava'
import Buefy from 'buefy';
import AuthLogin from '../../../../pages/auth/login'

const localVue = createLocalVue();
localVue.use(Buefy);

test('template test', async t => {
  const wrapper = shallowMount(AuthLogin, {
    localVue,
    stubs: {
      NLink: RouterLinkStub
    },
  });
  t.is(wrapper.find('.title').text(), 'ログイン');
  t.true(wrapper.find('textinput-stub[type="email"]').exists());
  t.true(wrapper.find('textinput-stub[type="password"]').exists());
  t.true(wrapper.find('#login-button').exists());
  t.is(wrapper.find('#login-button').text(), 'ログイン');
});