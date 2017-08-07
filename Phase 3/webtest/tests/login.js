module.exports = {
  before : function(browser) {
    browser
      .url(browser.launch_url)
      .waitForElementVisible('body', 1000)
      .assert.title("Login")
  },

  after : function(browser, done) {
    done();
  },

  'able to login' : function(browser) {
    browser
      .clearValue("input[name='username']")
      .clearValue("input[name='password']")
      .setValue("input[name='username']", 'emp1')
      .setValue("input[name='password']", 'gatech123')
      .click("input[name='submit']")
      .waitForElementVisible('body', 1000)
      .assert.title("Main Menu")
      .end();
  }
};
