import Vuex from 'vuex'
import { mount, createLocalVue, RouterLinkStub } from '@vue/test-utils'
import test from 'ava'
import Buefy from 'buefy';
import sinon from "sinon";
import AdminReportIndexTable from '../../components/admin/AdminReportIndexTable'

const localVue = createLocalVue();
localVue.use(Vuex);
localVue.use(Buefy);

const $store = {
  getters: {
    'admin-report-index/isLoading': false,
    'admin-report-index/pagination': {
      "first_page_url": "/admin/report?page=1",
      "path": "path",
      "per_page": 20,
      "total": 78,
      "data": [
        {
          "title": "test",
          "content": "test content",
          "status": 0,
          "created_at": "created_at",
          "updated_at": "updated_at",
          "id": 1,
        },
        {
          "title": "test2",
          "content": "test content2",
          "status": 0,
          "created_at": "created_at",
          "updated_at": "updated_at",
          "id": 2,
        }
      ],
      "last_page": 6,
      "last_page_url": "/admin/report?page=4",
      "next_page_url": "/admin/report?page=2",
      "to": 20,
      "prev_page_url": null,
      "current_page": 1
    },
  }
};

test('template test', t => {
  const $route = {
    query: {}
  };
  const wrapper = mount(AdminReportIndexTable, {
    localVue,
    mocks: {
      $store,
      $route
    },
    stubs: {
      Pagination: "<div id='pagination'></div>",
      'n-link': RouterLinkStub,
    }
  });
  t.true(wrapper.find('td[data-label="タイトル"]').exists());
  t.true(wrapper.find('td[data-label="ステータス"]').exists());
  t.true(wrapper.find('td[data-label="更新日"]').exists());

  const links = wrapper.findAll(RouterLinkStub);
  t.deepEqual(links.at(0).props().to, {
    path: '/admin/report/edit/1',
  });

  const spy = sinon.spy();
  wrapper.setMethods({ deleteReport: spy });
  wrapper.find('#delete1').trigger('click');
  t.true(spy.called);
});