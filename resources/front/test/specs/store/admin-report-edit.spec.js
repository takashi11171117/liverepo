import Vuex from 'vuex'
import { createLocalVue } from '@vue/test-utils'
import _ from 'lodash'
import * as index from '../../../store/admin-report-edit'
import test from "ava";
import axios from 'axios';
import sinon from "sinon";
import { Snackbar } from 'buefy/dist/components/snackbar'

const localVue = createLocalVue();
localVue.use(Vuex);

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

const report = {
  title: 'test2',
  content: 'test content2',
  status: '2',
  rating: '1',
  report_images: [],
  report_tags: [],
  file: null,
};

let action;
const router = sinon.spy();
const testedAction = (context = {}, payload = {}) => {
  if (payload.hasOwnProperty('reject')) {
    axios.$get = () => Promise.reject(error);
    axios.$post = () => Promise.reject(error);
  } else {
    axios.$get = () => Promise.resolve({data: report});
    axios.$post = () => Promise.resolve({data: report});
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
    title: 'test',
    content: 'test content',
    status: '0',
    rating: '1',
    error: error,
    report_images: ['aaa'],
    report_tags: ['iii'],
    file: null,
  });

  t.is(store.getters['title'], 'test');
  t.is(store.getters['content'], 'test content');
  t.is(store.getters['status'], '0');
  t.is(store.getters['rating'], '1');
  t.deepEqual(store.getters['report_images'], ['aaa']);
  t.deepEqual(store.getters['report_tags'], ['iii']);
  t.deepEqual(store.getters['error'], error);
});


test('actions', async t => {
  //fetchEachData
  action = 'fetchEachData';

  await testedAction({ commit }, {id: 1});

  t.false(router.called);
  t.is(store.getters['title'], report.title);
  t.is(store.getters['content'], report.content);
  t.is(store.getters['status'], report.status);
  t.is(store.getters['rating'], report.rating);
  t.deepEqual(store.getters['report_images'], report.report_images);

  resetState();
  await testedAction({ commit }, {id: 1, reject: true});

  t.true(router.called);
  t.is(store.getters['title'], '');
  t.is(store.getters['content'], '');
  t.is(store.getters['status'], '0');

  router.resetHistory();

  //updateEachData
  resetState();

  const state = {
    title: report.title,
    content: report.content,
    status: report.status,
    report_images: ['aaa'],
    report_tags: ['iii'],
    file: null,
    error: {},
  };

  action = 'updateEachData';
  const stub = sinon.stub(window, 'confirm');
  stub.returns(true);

  const snackbarMock = sinon.spy();
  Snackbar.open = snackbarMock;

  await testedAction({ commit, state }, {id: 1});

  t.true(snackbarMock.called);
  t.is(store.getters['title'], report.title);
  t.is(store.getters['content'], report.content);
  t.is(store.getters['status'], report.status);
  t.deepEqual(store.getters['report_images'], []);
  t.deepEqual(store.getters['report_tags'], []);
  t.is(store.getters['file'], null);

  await testedAction({ commit, state }, {id: 1, reject: true});

  t.true(snackbarMock.called);
  t.deepEqual(store.getters['error'], error.response.data.errors);
});

const resetState = () => {
  store.replaceState({
    title: '',
    content: '',
    status: '0',
    report_images: [],
    report_tags: [],
    file: null,
    error: {},
  });
};