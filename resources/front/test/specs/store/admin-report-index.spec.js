import Vuex from 'vuex'
import { createLocalVue } from '@vue/test-utils'
import _ from 'lodash'
import * as index from '../../../store/admin-report-index'
import test from "ava";
import axios from 'axios';
import sinon from "sinon";
import { Snackbar } from 'buefy/dist/components/snackbar'

const localVue = createLocalVue();
localVue.use(Vuex);

let pagination = {
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
};

let action;
const router = sinon.spy();
const testedAction = (context = {}, payload = {}) => {
  if (payload.hasOwnProperty('reject')) {
    axios.$get = () => Promise.reject('error');
    axios.$post = () => Promise.reject('error');
  } else {
    axios.$get = () => Promise.resolve(pagination);
    axios.$post = () => Promise.resolve(pagination);
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
    pagination: pagination,
    isLoading: false,
    page: 2,
    perPage: 30,
    search: 'aaaaaaa',
  });

  t.deepEqual(store.getters['pagination'], pagination);
  t.is(store.getters['isLoading'], false);
  t.is(store.getters['page'], 2);
  t.is(store.getters['perPage'], 30);
  t.is(store.getters['search'], 'aaaaaaa');
});

test('actions', async t => {
  //fetchReportPagination
  action = 'fetchReportPagination';

  await testedAction({ commit }, {
    page: 3,
    s: 'test'
  });
  t.false(router.called);
  t.deepEqual(store.getters['pagination'], pagination);
  t.is(store.getters['isLoading'], false);
  t.is(store.getters['page'], 3);
  t.is(store.getters['perPage'], 20);
  t.is(store.getters['search'], 'test');

  router.resetHistory();

  resetState();

  await testedAction({ commit }, {
    reject: true,
  });
  t.deepEqual(store.getters['pagination'], {});
  t.is(store.getters['isLoading'], true);
  t.is(store.getters['page'], 1);
  t.is(store.getters['perPage'], 20);
  t.is(store.getters['search'], '');
  t.true(router.called);

  //deleteReport
  action = 'deleteReport';
  const stub = sinon.stub(window, 'confirm');
  stub.returns(true);

  resetState();

  await testedAction({ commit }, {
    query: {
      page: 2,
      perPage: 30,
      s: 'test'
    },
    admin: {
      id: 1
    }
  });
  t.deepEqual(store.getters['pagination'], pagination);
  t.is(store.getters['isLoading'], false);
  t.is(store.getters['page'], 2);
  t.is(store.getters['perPage'], 30);
  t.is(store.getters['search'], 'test');

  //addReport
  action = 'addReport';

  await testedAction({ commit });
});

const resetState = () => {
  store.replaceState({
    pagination: {},
    isLoading: true,
    page: 1,
    perPage: 20,
    search: '',
  });
};