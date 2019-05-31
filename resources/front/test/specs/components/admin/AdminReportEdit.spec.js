import Vuex from 'vuex'
import { mount, createLocalVue } from '@vue/test-utils'
import test from 'ava'
import Buefy from 'buefy';
import sinon from "sinon";
import ReportEdit from '../../../../components/admin/ReportEdit'

const localVue = createLocalVue();
localVue.use(Vuex);
localVue.use(Buefy);

const $store = {
  getters: {
    'admin-report-edit/title': '',
    'admin-report-edit/content': '',
    'admin-report-edit/status': '0',
    'admin-report-edit/rating': '1',
    'admin-report-edit/file': null,
    'admin-report-edit/error': {},
  }
};

test('template test', t => {
  const wrapper = mount(ReportEdit, {
    localVue,
    mocks: {
      $store,
    },
    propsData: {
      reportId: '1'
    }
  });

  t.is(wrapper.find('.title').text(), 'レポート編集');
  t.true(wrapper.find('#title').exists());
  t.true(wrapper.find('#content').exists());
  t.true(wrapper.find('#status').exists());
  t.true(wrapper.find('#rating').exists());
  t.true(wrapper.find('#image1').exists());
  t.is(wrapper.find('button').text(), '保存する');

  const spy = sinon.spy();
  wrapper.setMethods({ updateEachData: spy });
  wrapper.find('button').trigger('click');
  t.true(spy.called);
});