import { shallowMount, createLocalVue } from '@vue/test-utils'
import test from 'ava'
import Buefy from 'buefy';
import sinon from "sinon";
import AdminReportNew from '../../../../../pages/admin/report/new'

const localVue = createLocalVue();
localVue.use(Buefy);

test('template test', t => {
  const wrapper = shallowMount(AdminReportNew, {
    localVue
  });
  t.is(wrapper.find('.title').text(), 'レポート追加');
  t.true(wrapper.find('#title').exists());
  t.true(wrapper.find('#content').exists());
  t.true(wrapper.find('#status').exists());
  t.is(wrapper.find('button').text(), '保存する');

  // pushing login button
  const spy = sinon.spy();
  wrapper.setMethods({ onSubmit: spy });
  wrapper.find('button').trigger('click');
  t.true(spy.called);
});

test('script test', async t => {
  const wrapper = shallowMount(AdminReportNew, {
    localVue
  });

  t.is(wrapper.vm.$data.title, '');
  t.is(wrapper.vm.$data.content, '');
  t.is(wrapper.vm.$data.status, '');
  t.deepEqual(wrapper.vm.$data.error, {});

  wrapper.vm.$router = {
    push: path => {}
  };

  const spy = sinon.stub();
  wrapper.vm.$router = {
    push: spy
  };

  const spy2 = sinon.stub();
  wrapper.vm.$snackbar = {
    open: spy2
  };

  const stub = sinon.stub(window, 'confirm');
  stub.returns(true);

  const stub2 = sinon.stub();
  stub2.returns(Promise.resolve());
  wrapper.setMethods({
    addReport: stub2,
  });

  await wrapper.vm.onSubmit();
  t.true(stub2.called);
  t.true(spy.called);
  t.true(spy2.called);
  t.deepEqual(spy.args[0][0], '/admin/report');
  t.deepEqual(spy2.args[0][0], {
    duration: 5000,
    message: 'レポートを追加しました。',
    type: 'is-success',
  });
});