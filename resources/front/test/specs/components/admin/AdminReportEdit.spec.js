import Vuex from 'vuex'
import { shallowMount, createLocalVue } from '@vue/test-utils'
import test from 'ava'
import Buefy from 'buefy';
import VueTagsInput from '@johmun/vue-tags-input'
import sinon from "sinon";
import ReportEdit from '../../../../components/admin/ReportEdit'

const localVue = createLocalVue();
localVue.use(Vuex);
localVue.use(Buefy);
localVue.component('vue-tags-input', VueTagsInput);

localVue.directive('preview-input', {
  bind(el, binding, vnode) {

    const isMultiple = (el.getAttribute('multiple') === 'multiple');
    const expression = binding.expression;

    el.addEventListener('change', (e) => {
      vnode.context[expression] = (isMultiple) ? [] : null;
      const files = e.target.files;
      const fileCount = files.length;
      let loadedCount = 0;

      if(fileCount > 0) {

        for(let i = 0 ; i < fileCount ; i++) {

          let file = files[i];
          let reader = new FileReader();
          reader.onload = (e) => {

            let dataURL = e.target.result;

            if(isMultiple) {
              vnode.context[expression].push(dataURL)
            } else {
              vnode.context[expression] = dataURL;
            }

            loadedCount++;

            if(loadedCount === fileCount) {
              el.dispatchEvent(
                new Event('ready')
              );
            }
          };
          reader.readAsDataURL(file);
        }
      }
    });
  }
});

const $store = {
  getters: {
    'admin-report-edit/title': '',
    'admin-report-edit/content': '',
    'admin-report-edit/status': '0',
    'admin-report-edit/rating': '1',
    'admin-report-edit/report_images': [],
    'admin-report-edit/report_tags': [],
    'admin-report-edit/file': null,
    'admin-report-edit/error': {},
  }
};

test('template test', t => {
  const wrapper = shallowMount(ReportEdit, {
    localVue,
    mocks: {
      $store,
    },
    propsData: {
      reportId: '1'
    }
  });

  t.is(wrapper.find('.title').text(), 'レポート編集');
  t.true(wrapper.find('textinput-stub[name="title"]').exists());
  t.true(wrapper.find('textinput-stub[name="content"]').exists());
  t.true(wrapper.find('selectinput-stub[name="status"]').exists());
  t.true(wrapper.find('selectinput-stub[name="rating"]').exists());
  t.true(wrapper.find('tagifyinput-stub[name="tags"]').exists());
  t.true(wrapper.find('imageinput-stub[name="images.0"]').exists());
  t.is(wrapper.find('button').text(), '保存する');

  const spy = sinon.spy();
  wrapper.setMethods({ updateEachData: spy });
  wrapper.find('button').trigger('click');
  t.true(spy.called);
});