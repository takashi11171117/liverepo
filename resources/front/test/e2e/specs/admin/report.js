const {EventEmitter} = require('events');

module.exports = {
  beforeEach: client => {
    EventEmitter.defaultMaxListeners = 100;
  },

  tags: 'admin_report',
  'I can enter the admin page' : (client) => {
    const url = client.globals.baseUrl;

    // be successful
    client
      .url(`${url}/admin/login`)
      .waitForElementVisible('body', 1000)
      .setValue('input[type=email]', 'test@gmail.com')
      .setValue('input[type=password]', '3387Ezweb')
      .click('button.form__submit')
      .pause(500)
      .assert.containsText('.app-main h1.title', 'メンバー一覧')
  },
  'I can show element': (client) => {
    const url = client.globals.baseUrl;

    client
      .url(`${url}/admin`)
      .setCookie({
        name: 'admin',
        value: '{%7B%22id%22%3A11%2C%22name%22%3A%22%E8%A5%BF%E4%B9%8B%E5%9C%92%20%E6%B4%8B%E4%BB%8B%22%2C%22email%22%3A%22test%40gmail.com%22%2C%22email_verified_at%22%3A%222019-07-09%2011%3A24%3A27%22%2C%22created_at%22%3A%222019-07-09%2011%3A24%3A27%22%2C%22updated_at%22%3A%222019-07-09%2011%3A24%3A27%22%7D}'
      })
      .setCookie({
        name: 'token',
        value: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvYXV0aFwvYWRtaW4iLCJpYXQiOjE1NjI2NzE2NjUsImV4cCI6MTU2MjY3NTI2NSwibmJmIjoxNTYyNjcxNjY1LCJqdGkiOiJaazBHWXpneEdaNk5KSTZiIiwic3ViIjoxMSwicHJ2IjoiZGY4ODNkYjk3YmQwNWVmOGZmODUwODJkNjg2YzQ1ZTgzMmU1OTNhOSJ9.aawo5jmISurKgxXZPUuOWK_KTVLi-uXJW4T14nvRenc'
      })
      .url(`${url}/admin/reports`)
      .waitForElementVisible('body', 1000)
      .assert.containsText('h1.title', 'レポート一覧')
      .assert.visible('#search')
      .assert.visible('#per-page')
      .assert.visible('#search-button')
      .assert.visible('#new')
      .assert.visible('#logout')
  },
};