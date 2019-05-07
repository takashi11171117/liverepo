const {EventEmitter} = require('events');

module.exports = {
  beforeEach: client => {
    EventEmitter.defaultMaxListeners = 100;
  },

  tags: 'admin',
  'I can show element' : (client) => {
    const url = client.globals.baseUrl;

    client
      .url(`${url}/admin`)
      .setCookie({
        name: 'admin',
        value: '{%22id%22:1%2C%22name%22:%22Kareem%20Jaskolski%22%2C%22email%22:%22earlene.shanahan@gmail.com%22%2C%22created_at%22:%222018-10-17%2021:08:58%22%2C%22updated_at%22:%222019-04-01%2014:37:43%22}'
      })
      .setCookie({
        name: 'token',
        value: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImp0aSI6IjVjYTk1NDVjZDg4OGQifQ.eyJpc3MiOiJodHRwOlwvXC8xOTIuMTY4LjEuMzU6ODAwMCIsImF1ZCI6Imh0dHA6XC9cLzE5Mi4xNjguMS4zNTo4MDAwIiwianRpIjoiNWNhOTU0NWNkODg4ZCIsImlhdCI6MTU1NDYwMTA1MiwibmJmIjoxNTU0NjAxMTEyLCJleHAiOjE1NTQ2MDQ2NTIsInVpZCI6MX0.d4sccBtKV0WjPUT_oRSyDYpQ7c75CJCowT-UZZLiOm0'
      })
      .url(`${url}/admin`)
      .waitForElementVisible('body', 1000)
      .assert.containsText('h1.title', 'メンバー一覧')
      .assert.visible('#search')
      .assert.visible('#per-page')
      .assert.visible('#search-button')
      .assert.visible('#new')
      .assert.visible('#logout')
  },
  'I can log out' : (client) => {
    const url = client.globals.baseUrl;

    client
      .setCookie({
        name: 'admin',
        value: '{%22id%22:1%2C%22name%22:%22Kareem%20Jaskolski%22%2C%22email%22:%22earlene.shanahan@gmail.com%22%2C%22created_at%22:%222018-10-17%2021:08:58%22%2C%22updated_at%22:%222019-04-01%2014:37:43%22}'
      })
      .setCookie({
        name: 'token',
        value: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImp0aSI6IjVjYTk1NDVjZDg4OGQifQ.eyJpc3MiOiJodHRwOlwvXC8xOTIuMTY4LjEuMzU6ODAwMCIsImF1ZCI6Imh0dHA6XC9cLzE5Mi4xNjguMS4zNTo4MDAwIiwianRpIjoiNWNhOTU0NWNkODg4ZCIsImlhdCI6MTU1NDYwMTA1MiwibmJmIjoxNTU0NjAxMTEyLCJleHAiOjE1NTQ2MDQ2NTIsInVpZCI6MX0.d4sccBtKV0WjPUT_oRSyDYpQ7c75CJCowT-UZZLiOm0'
      })
      .url(`${url}/admin`)
      .waitForElementVisible('body', 1000)
      .click('#logout')
      .pause(30)
      .assert.containsText('.card-header-title', '管理画面ログイン')
  },
  'I can get query' : (client) => {
    const url = client.globals.baseUrl;

    client
      .setCookie({
        name: 'admin',
        value: '{%22id%22:1%2C%22name%22:%22Kareem%20Jaskolski%22%2C%22email%22:%22earlene.shanahan@gmail.com%22%2C%22created_at%22:%222018-10-17%2021:08:58%22%2C%22updated_at%22:%222019-04-01%2014:37:43%22}'
      })
      .setCookie({
        name: 'token',
        value: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImp0aSI6IjVjYTk1NDVjZDg4OGQifQ.eyJpc3MiOiJodHRwOlwvXC8xOTIuMTY4LjEuMzU6ODAwMCIsImF1ZCI6Imh0dHA6XC9cLzE5Mi4xNjguMS4zNTo4MDAwIiwianRpIjoiNWNhOTU0NWNkODg4ZCIsImlhdCI6MTU1NDYwMTA1MiwibmJmIjoxNTU0NjAxMTEyLCJleHAiOjE1NTQ2MDQ2NTIsInVpZCI6MX0.d4sccBtKV0WjPUT_oRSyDYpQ7c75CJCowT-UZZLiOm0'
      })
      .url(`${url}/admin`)
      .waitForElementVisible('body', 1000)
      .setValue('#search', 's')
      .click('#search-button')
      .assert.urlContains('s=s')
      .click("#per-page option[value='30']")
      .assert.urlContains('?per_page=30')
      .click('#previous-page')
      .assert.urlContains('?page=-1')
      .click('#next-page')
      .assert.urlContains('?page=1')
      .click('#last-page')
      .assert.urlContains('?page=6')
      .click('#before-page')
      .assert.urlContains('?page=-1')
      .click('#after-page')
      .assert.urlContains('?page=1')
  },
  'I can move new admin page' : (client) => {
    const url = client.globals.baseUrl;

    // show admin new
    client
      .setCookie({
        name: 'admin',
        value: '{%22id%22:1%2C%22name%22:%22Kareem%20Jaskolski%22%2C%22email%22:%22earlene.shanahan@gmail.com%22%2C%22created_at%22:%222018-10-17%2021:08:58%22%2C%22updated_at%22:%222019-04-01%2014:37:43%22}'
      })
      .setCookie({
        name: 'token',
        value: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImp0aSI6IjVjYTk1NDVjZDg4OGQifQ.eyJpc3MiOiJodHRwOlwvXC8xOTIuMTY4LjEuMzU6ODAwMCIsImF1ZCI6Imh0dHA6XC9cLzE5Mi4xNjguMS4zNTo4MDAwIiwianRpIjoiNWNhOTU0NWNkODg4ZCIsImlhdCI6MTU1NDYwMTA1MiwibmJmIjoxNTU0NjAxMTEyLCJleHAiOjE1NTQ2MDQ2NTIsInVpZCI6MX0.d4sccBtKV0WjPUT_oRSyDYpQ7c75CJCowT-UZZLiOm0'
      })
      .url(`${url}/admin/admin`)
      .waitForElementVisible('body', 1000)
      .click('#new')
      .pause(50)
      .assert.containsText('h1.title', 'メンバー追加')
      .assert.visible('#name')
      .assert.visible('#email')
      .assert.visible('#password')
      .assert.visible('#password-confirm')

      // show error
      .click('#submit')
      .acceptAlert()
      .pause(100)
      .assert.visible('.help.is-danger')

      // add admin
      .setValue('#name', 'a')
      .setValue('#email', 'i')
      .setValue('#password', 'pass')
      .setValue('#password-confirm', 'pass')
      .click('#submit')
      .pause(50)
      .acceptAlert()
      .pause(50)
      .assert.containsText('h1.title', 'メンバー一覧')
  },
  'I can move edit admin page' : (client) => {
    const url = client.globals.baseUrl;

    // show admin new
    client
      .setCookie({
        name: 'admin',
        value: '{%22id%22:1%2C%22name%22:%22Kareem%20Jaskolski%22%2C%22email%22:%22earlene.shanahan@gmail.com%22%2C%22created_at%22:%222018-10-17%2021:08:58%22%2C%22updated_at%22:%222019-04-01%2014:37:43%22}'
      })
      .setCookie({
        name: 'token',
        value: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImp0aSI6IjVjYTk1NDVjZDg4OGQifQ.eyJpc3MiOiJodHRwOlwvXC8xOTIuMTY4LjEuMzU6ODAwMCIsImF1ZCI6Imh0dHA6XC9cLzE5Mi4xNjguMS4zNTo4MDAwIiwianRpIjoiNWNhOTU0NWNkODg4ZCIsImlhdCI6MTU1NDYwMTA1MiwibmJmIjoxNTU0NjAxMTEyLCJleHAiOjE1NTQ2MDQ2NTIsInVpZCI6MX0.d4sccBtKV0WjPUT_oRSyDYpQ7c75CJCowT-UZZLiOm0'
      })
      .url(`${url}/admin`)
      .waitForElementVisible('body', 1000)
      .click('a[href="/admin/admin/edit/0"]')
      .pause(50)
      .assert.containsText('h1.title', 'メンバー編集')
      .assert.visible('#name')
      .assert.visible('#email')
      .assert.visible('#password')
      .assert.visible('#password-confirm')

    // show error
      .setValue('#name', ['\u0008', '\u0008', '\u0008', '\u0008'])
      .setValue('#email', ['\u0008', '\u0008', '\u0008', '\u0008', '\u0008'])
      .click('#submit')
      .pause(100)
      .acceptAlert()
      .pause(100)
      .assert.visible('.help.is-danger')

    // add admin
      .setValue('#name', 'a')
      .setValue('#email', 'i')
      .setValue('#password', 'pass')
      .setValue('#password-confirm', 'pass')
      .click('#submit')
      .pause(50)
      .acceptAlert()
      .pause(50)
      .assert.containsText('h1.title', 'メンバー編集')
  },

  'I can delete an admin' : (client) => {
    const url = client.globals.baseUrl;

    // show admin new
    client
      .setCookie({
        name: 'admin',
        value: '{%22id%22:1%2C%22name%22:%22Kareem%20Jaskolski%22%2C%22email%22:%22earlene.shanahan@gmail.com%22%2C%22created_at%22:%222018-10-17%2021:08:58%22%2C%22updated_at%22:%222019-04-01%2014:37:43%22}'
      })
      .setCookie({
        name: 'token',
        value: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImp0aSI6IjVjYTk1NDVjZDg4OGQifQ.eyJpc3MiOiJodHRwOlwvXC8xOTIuMTY4LjEuMzU6ODAwMCIsImF1ZCI6Imh0dHA6XC9cLzE5Mi4xNjguMS4zNTo4MDAwIiwianRpIjoiNWNhOTU0NWNkODg4ZCIsImlhdCI6MTU1NDYwMTA1MiwibmJmIjoxNTU0NjAxMTEyLCJleHAiOjE1NTQ2MDQ2NTIsInVpZCI6MX0.d4sccBtKV0WjPUT_oRSyDYpQ7c75CJCowT-UZZLiOm0'
      })
      .url(`${url}/admin`)
      .waitForElementVisible('body', 1000)
      .click('#delete0')
      .pause(50)
      .acceptAlert()
      .assert.containsText('h1.title', 'メンバー一覧')
  },

  after : (client) => {
    client.end();
  },

  afterEach: () => {
    EventEmitter.defaultMaxListeners = 10;
  }
};