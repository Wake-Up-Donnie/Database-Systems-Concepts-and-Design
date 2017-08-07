module.exports = {
  beforeEach : function(browser) {
    browser
      .url(browser.launch_url)
      .waitForElementVisible('body', 1000)
      .assert.title("Login")
      .clearValue("input[name='username']")
      .clearValue("input[name='password']")
      .setValue("input[name='username']", 'emp1')
      .setValue("input[name='password']", 'gatech123')
      .click("input[name='submit']")
      .waitForElementVisible('body', 1000)
      .assert.title("Main Menu")
  },

  after : function(browser, done) {
    done();
  },

  'able to search client' : function(browser) {
    browser
    .click("a[href='./view-reports']")
    .click("a[href='./view-client-search-report']")
    .waitForElementVisible('body', 1000)
    .assert.title("View Client Search Report")
    .click("a[href='./search-client']")
    .waitForElementVisible('body', 1000)
    .assert.title("Search Client")
    .clearValue("input[name='firstname']")
    .clearValue("input[name='lastname']")
    .clearValue("input[name='idnumber']")
    .setValue("input[name='firstname']", 'Joe')
    .setValue("input[name='lastname']", 'Client1')
    .click("input[name='submit']")
    .waitForElementVisible('body', 1000)
    .assert.title("Search Client Result")
    .assert.containsText("td", "Joe")
    .click("a")
    .assert.title("Edit Client")
    .clearValue("input[name='idnumber']")
    .setValue("input[name='idnumber']", Date.now())
    .click("input[name='submit']")
    .assert.title("Edit Client Result")
    .assert.containsText("p", "Successfully edited client")
    .end();
  }
};
