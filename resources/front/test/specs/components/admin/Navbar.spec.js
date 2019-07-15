import Vuex from 'vuex'
import { shallowMount, createLocalVue, RouterLinkStub } from '@vue/test-utils'
import test from 'ava'
import sinon from 'sinon'
import * as indexStore from '../../../../store/index'
import NavBar from '../../../../components/admin/NavBar'

const localVue = createLocalVue();
localVue.use(Vuex);

const $store = {
  getters: {
    admin: {
      name: 'test'
    }
  }
};

test('template test at the exception of login page', t => {
  const $nuxt = {
    $route: {
      path: '/admin'
    }
  };

  const mock = sinon.spy();

  const wrapper = shallowMount(NavBar, {
    mocks: {
      $nuxt,
      $store
    },
    stubs: {
      'b-icon': '<div class="b-icon"></div>',
      NLink: RouterLinkStub,
    },
  });
  t.is(wrapper.find('#logout').text(), 'ログアウト');
  t.regex(wrapper.find('#account').text(), /ようこそ testさん/);
  t.is(wrapper.find('#logo').attributes().src, '~assets/logo.svg');
  t.is(wrapper.find('.burger').exists(), true);
  wrapper.setMethods({ menuToggle: mock });
  wrapper.find('.burger').trigger('click');
  t.true(mock.called);
  wrapper.setMethods({ onLogout: mock });
  wrapper.find('#logout').trigger('click');
  t.true(mock.called);
});

test('script test at login page', t => {
  let store = new Vuex.Store(indexStore);
  let admin = { name: 'test' };
  const $nuxt = {
    $route: {
      path: '/admin/login'
    }
  };

  const wrapper = shallowMount(NavBar, {
    store,
    localVue,
    mocks: {
      $nuxt,
    },
    stubs: {
      'b-icon': '<div class="b-icon"></div>',
      NLink: RouterLinkStub,
    }
  });

  const mock = sinon.spy();
  store.replaceState({ admin });
  t.is(wrapper.vm.$data.hasOwnProperty('menuActive'), true);
  t.is(wrapper.vm.$data.hasOwnProperty('admin'), true);

  wrapper.vm.menuToggle();
  t.is(wrapper.vm.$data.menuActive, true);

  wrapper.setMethods({ logout: mock });
  wrapper.vm.onLogout();
  t.true(mock.called);
});

test('template test at login page', t => {
  const $nuxt = {
    $route: {
      path: '/admin/login'
    }
  };

  const wrapper = shallowMount(NavBar, {
    mocks: {
      $nuxt,
      $store
    },
    stubs: {
      'b-icon': '<div class="b-icon"></div>',
      NLink: RouterLinkStub,
    }
  });
  t.is(wrapper.find('.buttons').html(), '<div class="buttons"><!----></div>');
  t.is(wrapper.find('.admin').html(), '<div class="admin"><!----></div>');
});
