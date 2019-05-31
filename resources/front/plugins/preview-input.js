import Vue from "vue";

Vue.directive('preview-input', {
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