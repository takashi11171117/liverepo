import Vue from 'vue'

// formatメソッド
Date.format = function (d, pattern) {
  if (typeof pattern !== 'string') { return }

  const dYear = d.getFullYear()
  const dMonth = d.getMonth()
  const dDate = d.getDate()
  const dDay = d.getDay()
  const dHours = d.getHours()
  const dMinutes = d.getMinutes()
  const dSeconds = d.getSeconds()

  const preZero = (value) => {
    return (parseInt(value) < 10) ? '0' + value : value
  }

  const from24to12 = (hours) => {
    return (hours > 12) ? hours - 12 : hours
  }

  const ampm = () => {
    return (dHours < 12) ? 'am' : 'pm'
  }

  const isoDay = function () {
    return (dDay === 0) ? '7' : dDay
  }

  const weekFullEn = () => {
    const week = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']
    return week[dDay]
  }

  const weekJp = () => {
    const week = ['日', '月', '火', '水', '木', '金', '土']
    return week[dDay]
  }

  const monthFullEn = () => {
    const month = ['January', 'February', 'March', 'April', 'May', 'June',
      'July', 'August', 'September', 'October', 'November', 'December']
    return month[dMonth]
  }

  const monthOldJp = () => {
    const month = ['睦月', '如月', '弥生', '卯月', '皐月', '水無月',
      '文月', '葉月', '長月', '神無月', '霜月', '師走']
    return month[dMonth]
  }

  const lastDayOfMonth = function (dateObj) {
    const tmp = new Date(dateObj.getFullYear(), dateObj.getMonth() + 1, 1)
    tmp.setTime(tmp.getTime() - 1)
    return tmp.getDate()
  }

  const isLeapYear = () => {
    const tmp = new Date(dYear, 0, 1)
    let sum = 0
    for (let i = 0; i < 12; i++) {
      tmp.setMonth(i)
      sum += lastDayOfMonth(tmp)
    }

    return (sum === 365) ? '0' : '1'
  }

  const dateCount = () => {
    const tmp = new Date(dYear, 0, 1)
    let sum = -1
    for (let i = 0; i < dMonth; i++) {
      tmp.setMonth(i)
      sum += lastDayOfMonth(tmp)
    }

    return sum + dDate
  }

  const dateSuffix = () => {
    const suffix = [
      'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th', 'th',
      'th', 'th', 'th', 'th', 'th', 'th', 'th', 'th', 'th', 'th',
      'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th', 'th', 'st'
    ]

    return suffix[dDate - 1]
  }

  let res = ''

  for (let i = 0, len = pattern.length; i < len; i++) {
    const c = pattern.charAt(i)

    switch (c) {
      case '#':
        if (i === len - 1) { break }
        res += pattern.charAt(++i)
        break

      case 'Y': res += dYear; break

      case 'y': res += dYear.toString().substr(2, 2); break

      case 'm': res += preZero(dMonth + 1); break

      case 'n': res += dMonth + 1; break

      case 'd': res += preZero(dDate); break

      case 'j': res += dDate; break

      case 'w': res += dDay; break

      case 'N': res += isoDay(); break

      case 'l': res += weekFullEn(); break

      case 'D': res += weekFullEn().substr(0, 3); break

      case 'J': res += weekJp(); break

      case 'F': res += monthFullEn(); break

      case 'O': res += monthOldJp(); break

      case 'a': res += ampm(); break

      case 'A': res += ampm().toUpperCase(); break

      case 'H': res += preZero(dHours); break

      case 'h': res += preZero(from24to12(dHours)); break

      case 'g': res += from24to12(dHours); break

      case 'G': res += dHours; break

      case 'i': res += preZero(dMinutes); break

      case 's': res += preZero(dSeconds); break

      case 'M': res += monthFullEn().substr(0, 3); break

      case 't': res += lastDayOfMonth(d); break

      case 'L': res += isLeapYear(); break

      case 'z': res += dateCount(); break

      case 'S': res += dateSuffix(); break

      default : res += c; break
    }
  }

  return res
}

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
        1: '女性'
      },
      monthNamesOption: [
        '1月',
        '2月',
        '3月',
        '4月',
        '5月',
        '6月',
        '7月',
        '8月',
        '9月',
        '10月',
        '11月',
        '12月'
      ],
      dayNamesOption: ['日', '月', '火', '水', '木', '金', '土'],
      prefsOption: {
        1: '北海道',
        2: '青森県',
        3: '岩手県',
        4: '宮城県',
        5: '秋田県',
        6: '山形県',
        7: '福島県',
        8: '茨城県',
        9: '栃木県',
        10: '群馬県',
        11: '埼玉県',
        12: '千葉県',
        13: '東京都',
        14: '神奈川県',
        15: '新潟県',
        16: '富山県',
        17: '石川県',
        18: '福井県',
        19: '山梨県',
        20: '長野県',
        21: '岐阜県',
        22: '静岡県',
        23: '愛知県',
        24: '三重県',
        25: '滋賀県',
        26: '京都府',
        27: '大阪府',
        28: '兵庫県',
        29: '奈良県',
        30: '和歌山県',
        31: '鳥取県',
        32: '島根県',
        33: '岡山県',
        34: '広島県',
        35: '山口県',
        36: '徳島県',
        37: '香川県',
        38: '愛媛県',
        39: '高知県',
        40: '福岡県',
        41: '佐賀県',
        42: '長崎県',
        43: '熊本県',
        44: '大分県',
        45: '宮崎県',
        46: '鹿児島県',
        47: '沖縄県'
      }
    }
  },
  methods: {
    $truncate: (str, len) => {
      return str.length <= len ? str : (str.substr(0, len) + '...')
    },
    $console: (...args) => {
      // eslint-disable-next-line
      console.dir(args)
    },
    $calcAge: (birth) => {
      if (!(birth === '' || birth === null || birth === undefined)) {
        const newBirth = new Date(birth.replace(/-/g, '/'))
        const birthDate = new Date(newBirth)

        const y2 = birthDate.getFullYear().toString().padStart(4, '0')
        const m2 = (birthDate.getMonth() + 1).toString().padStart(2, '0')
        const d2 = birthDate.getDate().toString().padStart(2, '0')

        const today = new Date()
        const y1 = today.getFullYear().toString().padStart(4, '0')
        const m1 = (today.getMonth() + 1).toString().padStart(2, '0')
        const d1 = today.getDate().toString().padStart(2, '0')

        return Math.floor((Number(y1 + m1 + d1) - Number(y2 + m2 + d2)) / 10000) + '代'
      }

      return null
    },
    $isset: (data) => {
      return !(data === '' || data === null || data === undefined)
    }
  }
})
