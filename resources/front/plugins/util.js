import Vue from "vue";

Vue.mixin({
  data: () => {
    return {
      reportStatus: {
        0: '下書き',
        1: '公開',
        2: 'ゴミ箱'
      },
      reportRating: {
        1: '★',
        2: '★★',
        3: '★★★',
        4: '★★★★',
        5: '★★★★★'
      },
    }
  },
  methods: {
    $truncate: (str, len) => {
      return str.length <= len ? str : (str.substr(0, len)+"...");
    },
    $console: (...args) => {
      console.dir(args);
    },
  },
});