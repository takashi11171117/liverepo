import Vuex from 'vuex'
import { createLocalVue } from '@vue/test-utils'
import _ from 'lodash'
import * as index from '../../../store/admin-edit'
import test from "ava";
import axios from 'axios';
import sinon from "sinon";
import { Snackbar } from 'buefy/dist/components/snackbar'

const localVue = createLocalVue();
localVue.use(Vuex);

const admin = {
  id: 1,
  name: 'test',
  email: 'test@gmail.com'
};

const error = {
  response: {
    data: {
      message: 'error',
      errors: [
        'error1', 'error2'
      ]
    }
  }
};

let action;
const router = sinon.spy();
const testedAction = (context = {}, payload = {}) => {
  if (payload.hasOwnProperty('reject')) {
    axios.$get = () => Promise.reject(error);
    axios.$post = () => Promise.reject(error);
  } else {
    axios.$get = () => Promise.resolve(admin);
    axios.$post = () => Promise.resolve(admin);
  }
  return index.actions[action].bind({
    $axios: axios,
    $router: {
      push: router
    },
  })(context, payload)
};

let store, commit;

test.beforeEach(() => {
  store = new Vuex.Store(_.cloneDeep(index));
  commit = store.commit;
});

test('getters', t => {
  store.replaceState({
    admin: admin,
    name: admin.name,
    email: admin.email,
    password: '12345',
    passwordConfirm: '12345',
    error: error,
  });

  t.deepEqual(store.getters['admin'], admin);
  t.is(store.getters['name'], admin.name);
  t.is(store.getters['email'], admin.email);
  t.is(store.getters['password'], '12345');
  t.is(store.getters['passwordConfirm'], '12345');
  t.deepEqual(store.getters['error'], error);
});


test('actions', async t => {
  //fetchAdmin
  action = 'fetchAdmin';

  await testedAction({ commit }, {id: 1});

  t.false(router.called);
  t.deepEqual(store.getters['admin'], admin);
  t.is(store.getters['name'], admin.name);
  t.is(store.getters['email'], admin.email);

  resetState();
  await testedAction({ commit }, {id: 1, reject: true});

  t.true(router.called);
  t.deepEqual(store.getters['admin'], {});
  t.is(store.getters['name'], '');
  t.is(store.getters['email'], '');

  router.resetHistory();

  //updateAdmin
  resetState();

  const state = {
    admin: admin,
    name: admin.name,
    email: admin.email,
    password: '12345',
    passwordConfirm: '12345',
    error: {},
  };

  action = 'updateAdmin';
  const stub = sinon.stub(window, 'confirm');
  stub.returns(true);

  const snackbarMock = sinon.spy();
  Snackbar.open = snackbarMock;

  await testedAction({ commit, state });

  t.true(snackbarMock.called);
  t.deepEqual(store.getters['admin'], admin);
  t.is(store.getters['name'], admin.name);
  t.is(store.getters['email'], admin.email);

  await testedAction({ commit, state }, {reject: true});

  t.true(snackbarMock.called);
  t.deepEqual(store.getters['error'], error.response.data.errors);
});

const resetState = () => {
  store.replaceState({
    admin: {},
    name: '',
    email: '',
    password: '',
    passwordConfirm: '',
    error: {},
  });
};