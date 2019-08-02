import { shallowMount, createLocalVue } from '@vue/test-utils'
import test from 'ava'
import Buefy from 'buefy';
import sinon from "sinon";
import AdminReportNew from '../../../../../pages/admin/reports/new'

const localVue = createLocalVue();
localVue.use(Buefy);

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

test('template test', t => {
  const wrapper = shallowMount(AdminReportNew, {
    localVue
  });
  t.is(wrapper.find('.title').text(), 'レポート追加');
  t.true(wrapper.find('textinput-stub[name="title"]').exists());
  t.true(wrapper.find('textinput-stub[name="content"]').exists());
  t.true(wrapper.find('selectinput-stub[name="status"]').exists());
  t.true(wrapper.find('selectinput-stub[name="rating"]').exists());
  t.true(wrapper.find('tagifyinput-stub[name="tags"]').exists());
  t.true(wrapper.find('imageinput-stub[name="images.0"]').exists());
  t.is(wrapper.find('button').text(), '保存する');

  // pushing login button
  const spy = sinon.spy();
  wrapper.setMethods({ onSubmit: spy });
  wrapper.find('button').trigger('click');
  t.true(spy.called);
});

test('script test', async t => {
  const wrapper = shallowMount(AdminReportNew, {
    localVue
  });

  t.is(wrapper.vm.$data.title, '');
  t.is(wrapper.vm.$data.content, '');
  t.is(wrapper.vm.$data.status, '');
  t.deepEqual(wrapper.vm.$data.error, {});

  wrapper.vm.$router = {
    push: path => {}
  };

  const spy = sinon.stub();
  wrapper.vm.$router = {
    push: spy
  };

  const spy2 = sinon.stub();
  wrapper.vm.$snackbar = {
    open: spy2
  };

  const stub = sinon.stub(window, 'confirm');
  stub.returns(true);

  const stub2 = sinon.stub();
  stub2.returns(Promise.resolve());
  wrapper.setMethods({
    addReport: stub2,
  });

  await wrapper.vm.onSubmit();
  t.true(stub2.called);
  t.true(spy.called);
  t.true(spy2.called);
  t.deepEqual(spy.args[0][0], '/admin/reports');
  t.deepEqual(spy2.args[0][0], {
    duration: 5000,
    message: 'レポートを追加しました。',
    type: 'is-success',
  });
});