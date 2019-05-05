const {EventEmitter} = require('events');

module.exports = {
  beforeEach: client => {
    EventEmitter.defaultMaxListeners = 100;
  },

  tag: 'demo',
  'I can show element': (client) => {
    const url = client.globals.baseUrl;

    client
      .url(`${url}/`)
      .waitForElementVisible('body', 1000)
      .assert.containsText('h1', 'レポートを書いたらライブに行ける！お笑いライブレポ')
  },
};