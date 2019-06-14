import { shallowMount } from '@vue/test-utils'
import axios from 'axios'
import test from 'ava'
import sinon from "sinon";
import AdminLogin from '../../../../../pages/admin/login'

test('template test', t => {
  const wrapper = shallowMount(AdminLogin);
  t.is(wrapper.find('.card-header-title').text(), '管理画面ログイン');
  t.is(wrapper.find('input[type="email"]').attributes('placeholder'), 'メールアドレス');
  t.is(wrapper.find('input[type="password"]').attributes('placeholder'), 'パスワード');
  t.is(wrapper.find('button').text(), 'ログイン');

  // pushing login button
  const spy = sinon.spy();
  wrapper.setMethods({ login: spy });
  wrapper.find('button').trigger('click');
  t.true(spy.called);
});

test('script test', async t => {
  const wrapper = shallowMount(AdminLogin);

  t.is(wrapper.vm.$data.loader, false);
  t.deepEqual(wrapper.vm.$data.error, {});
  t.is(wrapper.vm.$data.email, '');
  t.is(wrapper.vm.$data.password, '');
  t.is(wrapper.vm.$data.remember, false);

  wrapper.vm.$axios = axios;
  wrapper.vm.$axios.$post = () => Promise.resolve({
    token: 'aaaaa',
    admin: 'iiiii',
    expires_in: 3600
  });

  wrapper.vm.$router = {
    push: path => {}
  };

  const stub = sinon.stub();
  wrapper.vm.$router = {
    push: stub
  };

  const spy = sinon.spy();
  const spy2 = sinon.spy();
  wrapper.setMethods({
    saveToken: spy,
    fetchAdmin: spy2
  });

  await wrapper.vm.login();
  t.true(stub.called);
  t.true(spy.called);
  t.true(spy2.called);

  t.is(stub.args[0][0], '/admin');
});