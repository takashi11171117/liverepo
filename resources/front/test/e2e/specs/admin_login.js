module.exports = {
  tag: 'demo',
  'I can get error messages' : (client) => {
    const url = client.globals.baseUrl;

    // get error
    client
      .url(`${url}/admin/login`)
      .waitForElementVisible('body', 1000)
      .assert.visible('input[type=email]')
      .assert.visible('input[type=password]')
      .assert.visible('button.form__submit')
      .assert.visible('.navbar-item img')
      .assert.containsText('.card-header-title', '管理画面ログイン')
      .setValue('input[type=email]', '')
      .setValue('input[type=password]', '')
      .click('button.form__submit')
      .pause(30)
      .assert.visible('.info--error')
  },
  'I can enter the admin page' : (client) => {
    const url = client.globals.baseUrl;

    // be successful
    client
      .url(`${url}/admin/login`)
      .waitForElementVisible('body', 1000)
      .setValue('input[type=email]', 'test')
      .setValue('input[type=password]', 'test')
      .click('button.form__submit')
      .pause(100)
      .assert.containsText('.app-main h1.title', 'メンバー一覧')
  },

  after : (client) => {
    client.end();
  }
};