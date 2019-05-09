const {EventEmitter} = require('events');

module.exports = {
  beforeEach: client => {
    EventEmitter.defaultMaxListeners = 100;
  },

  tags: 'admin_report',
  'I can show element': (client) => {
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
      .url(`${url}/admin/report`)
      .waitForElementVisible('body', 1000)
      .assert.containsText('h1.title', 'レポート一覧')
      .assert.visible('#search')
      .assert.visible('#per-page')
      .assert.visible('#search-button')
      .assert.visible('#new')
      .assert.visible('#logout')
  },
};