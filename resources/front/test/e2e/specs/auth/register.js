module.exports = {
  tags: 'auth_register',
  'I can get error messages' : (client) => {
    const url = client.globals.baseUrl;

    // get error
    client
      .url(`${url}/auth/register`)
      .waitForElementVisible('body', 1000)
      .setValue('input[type=text]', '')
      .setValue('input[type=email]', '')
      .setValue('input[type=password]', '')
      .click('button#login-button')
      .pause(100)
      .assert.visible('.info--error')
  },
  'I can create user' : (client) => {
    const url = client.globals.baseUrl;

    // be successful
    client
      .url(`${url}/auth/register`)
      .waitForElementVisible('body', 1000)
      .setValue('input[type=text]', 'Hoge')
      .setValue('input[type=email]', 'test2@gmail.com')
      .setValue('input[type=password]', '3387Ezweb')
      .click('button#login-button')
      .pause(500)
      .assert.containsText('.title', 'ログイン')
  },

  after : (client) => {
    client.end();
  }
};