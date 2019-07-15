import Vuex from 'vuex'
import { shallowMount, createLocalVue, RouterLinkStub } from '@vue/test-utils'
import test from 'ava'
import Buefy from 'buefy';
import sinon from "sinon";
import AdminIndexHead from '../../../../components/admin/AdminIndexHead'

const localVue = createLocalVue();
localVue.use(Vuex);
localVue.use(Buefy);

const $store = {
  getters: {
    'admin-index/page': 1,
    'admin-index/perPage': 20,
    'admin-index/search': '',
  }
};

test('template test', t => {
  const $route = {
    query: {}
  };

  const wrapper = shallowMount(AdminIndexHead, {
    localVue,
    mocks: {
      $route,
      $store,
    },
    stubs: {
      NLink: RouterLinkStub,
    }
  });

  t.is(wrapper.find('#search').attributes('placeholder'), '検索する');
  t.true(wrapper.find('#per-page').exists());

  const links = wrapper.findAll(RouterLinkStub);
  t.deepEqual(links.at(0).props().to, {
    path: '/admin/admin/new',
  });

  const spy = sinon.spy();
  wrapper.setMethods({ onSearch: spy });
  wrapper.find('#search').trigger('change');
  t.true(spy.called);

  const spy2 = sinon.spy();
  wrapper.setMethods({ changePerPage: spy2 });
  wrapper.find('#per-page').trigger('change');
  t.true(spy2.called);
});

test('script test', async t => {
  const $route = {
    query: {
      page: 1,
      per_page: 20,
      s: ''
    }
  };

  const wrapper = shallowMount(AdminIndexHead, {
    localVue,
    mocks: {
      $route,
      $store,
    },
    stubs: {
      NLink: RouterLinkStub,
    }
  });

  t.deepEqual(wrapper.vm.$data.query, {
    page: 1,
    per_page: 20,
    s: ''
  });

  wrapper.vm.$router = {
    push: path => {}
  };

  const router = sinon.stub();
  wrapper.vm.$router = {
    push: router
  };

  const updateInputMock = sinon.spy();
  wrapper.setMethods({ UPDATE_INPUT: updateInputMock });

  const event = {
    target: {
      value: 20
    }
  };

  wrapper.vm.onSearch(event);
  t.true(router.called);
  t.true(updateInputMock.called);


  t.deepEqual(router.args[0][0], {
    path: '/admin',
    query: {
      page: 1,
      per_page: 20,
      s: event.target.value,
    }
  });
  t.deepEqual(updateInputMock.args[0][0], {
    'search': event.target.value
  });

  router.resetHistory();
  updateInputMock.resetHistory();

  const event2 = {
    target: {
      value: 30
    }
  };

  wrapper.vm.changePerPage(event2);
  t.true(router.called);
  t.true(updateInputMock.called);


  t.deepEqual(router.args[0][0], {
    path: '/admin',
    query: {
      page: 1,
      per_page: event2.target.value,
      s: '',
    }
  });
  t.deepEqual(updateInputMock.args[0][0], {
    'perPage': event2.target.value
  });
});