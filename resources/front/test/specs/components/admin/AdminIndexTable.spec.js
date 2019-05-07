import Vuex from 'vuex'
import { mount, createLocalVue, RouterLinkStub } from '@vue/test-utils'
import test from 'ava'
import Buefy from 'buefy';
import sinon from "sinon";
import AdminIndexTable from '../../../../components/admin/AdminIndexTable'

const localVue = createLocalVue();
localVue.use(Vuex);
localVue.use(Buefy);

const $store = {
  getters: {
    'admin-index/isLoading': false,
    'admin-index/pagination': {
      "first_page_url": "/admin?page=1",
      "path": "path",
      "per_page": 20,
      "total": 78,
      "data": [
        {
          "password": "password",
          "updated_at": "updated_at",
          "name": "name",
          "created_at": "created_at",
          "id": 1,
          "email": "email"
        },
        {
          "password": "password",
          "updated_at": "updated_at",
          "name": "name",
          "created_at": "created_at",
          "id": 2,
          "email": "email"
        }
      ],
      "last_page": 6,
      "last_page_url": "/admin?page=4",
      "next_page_url": "/admin?page=2",
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
  const wrapper = mount(AdminIndexTable, {
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
  t.true(wrapper.find('td[data-label="名前"]').exists());
  t.true(wrapper.find('td[data-label="メールアドレス"]').exists());
  t.true(wrapper.find('td[data-label="作成日"]').exists());
  t.true(wrapper.find('td[data-label="更新日"]').exists());

  const links = wrapper.findAll(RouterLinkStub);
  t.deepEqual(links.at(0).props().to, {
    path: '/admin/admin/edit/1',
  });

  const spy = sinon.spy();
  wrapper.setMethods({ deleteAdmin: spy });
  wrapper.find('#delete1').trigger('click');
  t.true(spy.called);
});