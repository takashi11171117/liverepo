import Vuex from 'vuex'
import { mount, createLocalVue } from '@vue/test-utils'
import test from 'ava'
import Buefy from 'buefy';
import sinon from "sinon";
import AdminEdit from '../../../../components/admin/AdminEdit'

const localVue = createLocalVue();
localVue.use(Vuex);
localVue.use(Buefy);

const $store = {
  getters: {
    'admin-edit/admin': {},
    'admin-edit/name': '',
    'admin-edit/email': '',
    'admin-edit/password': '',
    'admin-edit/passwordConfirm': '',
    'admin-edit/error': {},
  }
};

test('template test', t => {
  const wrapper = mount(AdminEdit, {
    localVue,
    mocks: {
      $store,
    }
  });

  t.is(wrapper.find('.title').text(), 'メンバー編集');
  t.true(wrapper.find('#name').exists());
  t.true(wrapper.find('#email').exists());
  t.true(wrapper.find('#password').exists());
  t.true(wrapper.find('#password-confirm').exists());
  t.is(wrapper.find('button').text(), '保存する');

  const spy = sinon.spy();
  wrapper.setMethods({ updateAdmin: spy });
  wrapper.find('button').trigger('click');
  t.true(spy.called);
});