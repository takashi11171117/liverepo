import Vuex from 'vuex'
import { createLocalVue } from '@vue/test-utils'
import _ from 'lodash'
import * as index from '../../../store/index'
import test from "ava";
import sinon from "sinon";
import Cookies from "js-cookie";
import * as utils from '../../../utils';

const localVue = createLocalVue();
localVue.use(Vuex);

let action;
const testedAction = (context = {}, payload = {}) => {
  let router;
  if (payload.hasOwnProperty('router')) {
    router = payload.router;
  } else {
    router = () => {};
  }
  return index.actions[action].bind({
    $router: {
      push: router
    },
  })(context, payload)
};

let store;
let token, admin, sidebar, commit;

test.beforeEach(() => {
  store = new Vuex.Store(_.cloneDeep(index));
  commit = store.commit;
  token = 'test_token';
  admin = { name: 'hoge', email: 'hoge@test.com' };
  sidebar = { opened: false, hidden: false };
});

test('getters', t => {
  store.replaceState({
    device: {
      isMobile: false,
      isTablet: false
    },
    sidebar: sidebar,
    token: token,
    admin: admin,
  });

  t.deepEqual(store.getters['admin'], admin);
  t.is(store.getters['token'], token);
  t.is(store.getters['check'], true);
  t.is(store.getters['sidebar'], sidebar);
});

test('actions', async t => {
  //saveToken
  action = 'saveToken';
  const cookieSetMock = sinon.spy();
  Cookies.set = cookieSetMock;

  testedAction({ commit }, {token: token, remember: 3600});
  t.true(cookieSetMock.called);
  t.is(store.getters['token'], token);
  cookieSetMock.resetHistory();

  //fetchAdmin
  action = 'fetchAdmin';

  await testedAction({ commit }, {admin});
  t.true(cookieSetMock.called);
  t.is(store.getters['admin'], admin);
  cookieSetMock.resetHistory();

  //updateAdmin
  action = 'updateAdmin';

  await testedAction({ commit }, {admin});
  t.is(store.getters['admin'], admin);

  //logout
  action = 'logout';
  const cookieRemoveMock = sinon.spy();
  Cookies.remove = cookieRemoveMock;

  const router = sinon.stub();

  await testedAction({ commit }, {router});
  t.is(cookieRemoveMock.callCount, 2);
  t.true(router.called);
  t.is(store.getters['admin'], null);
  t.is(store.getters['token'], null);
  t.is(store.getters['check'], false);

  //nuxtServerInit
  action = 'nuxtServerInit';
  const cookieFromRequestMock = sinon.stub();
  const obj = {
    name: 'test',
    email: 'test@gmail.com'
  };
  const str = encodeURIComponent(JSON.stringify(obj));
  cookieFromRequestMock.returns(str);
  utils.cookieFromRequest = cookieFromRequestMock;

  testedAction({ commit });
  t.deepEqual(store.getters['admin'], obj);
  t.deepEqual(store.getters['token'], str);
  t.is(store.getters['check'], true);

  //nuxtClientInit
  action = 'nuxtClientInit';
  const cookieGetMock = sinon.stub();
  cookieGetMock.returns(str);
  Cookies.get = cookieGetMock;

  testedAction({ commit });
  t.deepEqual(store.getters['admin'], obj);
  t.deepEqual(store.getters['token'], str);
  t.is(store.getters['check'], true);

  //toggleDevice
  action = 'toggleDevice';
  testedAction({ commit }, 'mobile');
  t.deepEqual(store.getters['device'], {
    isMobile: true,
    isTablet: false
  });

  testedAction({ commit }, 'tablet');
  t.deepEqual(store.getters['device'], {
    isMobile: false,
    isTablet: true
  });

  //toggleSidebar
  action = 'toggleSidebar';
  store.replaceState({
    device: {
      isMobile: true,
      isTablet: false
    },
    sidebar: sidebar,
    token: token,
    admin: admin,
  });

  // when opend is true in mobile
  testedAction({ commit }, {
    opened: true,
  });
  t.deepEqual(store.getters['sidebar'], {
    opened: true,
    hidden: false
  });

  // when opend is true and hidden is true in mobile
  testedAction({ commit }, {
    opened: true,
    hidden: true,
  });
  t.deepEqual(store.getters['sidebar'], {
    opened: true,
    hidden: true
  });


  // when opened is true in otherß
  store.replaceState({
    device: {
      isMobile: false,
      isTablet: false
    },
    sidebar: sidebar,
    token: token,
    admin: admin,
  });

  testedAction({ commit }, {
    opened: true,
    hidden: false
  });
  t.deepEqual(store.getters['sidebar'], {
    opened: true,
    hidden: false
  });
});