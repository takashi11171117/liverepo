module.exports = {
  tags: 'auth_login',
  'I can get error messages' : (client) => {
    const url = client.globals.baseUrl;

    // get error
    client
      .url(`${url}/auth/login`)
      .waitForElementVisible('body', 1000)
      .setValue('input[type=email]', '')
      .setValue('input[type=password]', '')
      .click('button#login-button')
      .pause(100)
      .assert.visible('.help')
  },
  'I can enter the admin page' : (client) => {
    const url = client.globals.baseUrl;

    // be successful
    client
      .url(`${url}/auth/login`)
      .waitForElementVisible('body', 1000)
      .setValue('input[type=email]', 'test@gmail.com')
      .setValue('input[type=password]', '3387Ezweb')
      .click('button#login-button')
      .pause(500)
      .assert.visible('.main-content')
  },

  after : (client) => {
    client.end();
  }
};