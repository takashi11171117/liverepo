import Vuex from 'vuex'
import { shallowMount, createLocalVue, RouterLinkStub } from '@vue/test-utils'
import test from 'ava'
import Buefy from 'buefy';
import Header from '../../../../components/front/Header'

const localVue = createLocalVue();
localVue.use(Vuex);
localVue.use(Buefy);

const $auth = {
  loggedIn: true
};

test('template test', t => {
  const wrapper = shallowMount(Header, {
    localVue,
    stubs: {
      NLink: RouterLinkStub
    },
    mocks: {
      $auth
    }
  });

  const links = wrapper.findAll(RouterLinkStub);

  t.deepEqual(links.at(0).props().to, {
    name: 'index',
  });

  t.deepEqual(links.at(1).props().to, {
    name: 'user-post',
  });

  t.deepEqual(links.at(2).props().to, {
    name: 'user',
  });
});