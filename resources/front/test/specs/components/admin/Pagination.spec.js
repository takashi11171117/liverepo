import { shallowMount, RouterLinkStub } from '@vue/test-utils'
import test from 'ava'
import Pagination from '../../../../components/admin/Pagination'

test('template test', t => {
  const $route = {
    query: {
      s: ''
    }
  };

  const wrapper = shallowMount(Pagination, {
    mocks: {
      $route
    },
    stubs: {
      'n-link': RouterLinkStub,
    },
    propsData: {
      current_path: '/admin',
      pagination: {
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
  });

  const links = wrapper.findAll('a');
  t.is(links.at(0).attributes().id, 'previous-page');
  t.is(links.at(1).attributes().id, 'next-page');
  t.is(links.at(2).classes()[1], 'is-current');
  t.is(links.at(3).attributes().id, 'after-page');
  t.is(links.at(4).attributes().id, 'last-page');
});

test('script test', t => {
  const $route = {
    query: {
      s: 'aaaa'
    }
  };

  const wrapper = shallowMount(Pagination, {
    mocks: {
      $route
    },
    stubs: {
      'n-link': RouterLinkStub,
    },
    propsData: {
      current_path: '/admin',
      pagination: {
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
  });

  t.is(wrapper.vm.$data.isPrevious, false);
  t.is(wrapper.vm.$data.isNext, true);
  t.is(wrapper.vm.$data.isFirst, false);
  t.is(wrapper.vm.$data.isLast, true);
  t.is(wrapper.vm.$data.firstLinkQuery.s, 'aaaa');
  t.is(wrapper.vm.$data.firstLinkQuery.page, 1);
  t.is(wrapper.vm.$data.previousLinkQuery.page, 0);
  t.is(wrapper.vm.$data.nextLinkQuery.page, 2);
  t.is(wrapper.vm.$data.lastLinkQuery.page, 6);
  t.is(wrapper.vm.$data.currentLinkQuery.page, 1);
});