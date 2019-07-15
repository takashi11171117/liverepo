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
      genderOption: {
        0: '男性',
        1: '女性',
      },
      monthNamesOption: [
        "1月",
        "2月",
        "3月",
        "4月",
        "5月",
        "6月",
        "7月",
        "8月",
        "9月",
        "10月",
        "11月",
        "12月",
      ],
      dayNamesOption: ["日", "月", "火", "水", "木", "金", "土"]
    }
  },
  methods: {
    $truncate: (str, len) => {
      return str.length <= len ? str : (str.substr(0, len)+"...");
    },
    $console: (...args) => {
      console.dir(args);
    },
    $calcAge: (birth) => {
      if (birth !== null) {
        const birthDate = new Date(birth);

        const y2 = birthDate.getFullYear().toString().padStart(4, '0');
        const m2 = (birthDate.getMonth() + 1).toString().padStart(2, '0');
        const d2 = birthDate.getDate().toString().padStart(2, '0');

        const today = new Date();
        const y1 = today.getFullYear().toString().padStart(4, '0');
        const m1 = (today.getMonth() + 1).toString().padStart(2, '0');
        const d1 = today.getDate().toString().padStart(2, '0');

        return Math.floor((Number(y1 + m1 + d1) - Number(y2 + m2 + d2)) / 10000) + '代';
      }

      return null;
    }
  },
});