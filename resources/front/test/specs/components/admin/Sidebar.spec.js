import { shallowMount, RouterLinkStub } from '@vue/test-utils'
import test from 'ava'
import Sidebar from '../../../../components/admin/Sidebar'

test('The title is correct', t => {
  const wrapper = shallowMount(Sidebar, {
    stubs: {
      NLink: RouterLinkStub
    }
  });
  t.is(wrapper.find('.menu-label').text(), 'メニュー');
});

test('There are two input elements', t => {
  const wrapper = shallowMount(Sidebar, {
    stubs: {
      NLink: RouterLinkStub
    }
  });
  t.is(wrapper.find('#nav-dashboard').text(), 'ダッシュボード');
  t.is(wrapper.find('#nav-user').text(), 'ユーザー');
  t.is(wrapper.find('#nav-report').text(), 'レポート');

  const links = wrapper.findAll(RouterLinkStub);
  t.deepEqual(links.at(0).props().to, {
    path: '/admin',
  });
  t.deepEqual(links.at(1).props().to, {
    path: '/admin/admin',
  });
  t.deepEqual(links.at(2).props().to, {
    path: '/admin/report',
  });
});