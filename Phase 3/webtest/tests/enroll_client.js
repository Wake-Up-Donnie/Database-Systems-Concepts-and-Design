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

  'able to enroll client' : function(browser) {
    browser
    .click("a[href='./view-reports']")
    .click("a[href='./view-client-search-report']")
    .waitForElementVisible('body', 1000)
    .assert.title("View Client Search Report")
    .click("a[href='./enroll-client']")
    .waitForElementVisible('body', 1000)
    .assert.title("Enroll Client")
    .clearValue("input[name='firstname']")
    .clearValue("input[name='lastname']")
    .clearValue("input[name='idnumber']")
    .clearValue("input[name='iddescription']")
    .clearValue("select[name='ishead']")
    .setValue("input[name='firstname']", 'Joe')
    .setValue("input[name='lastname']", 'Client10')
    .setValue("input[name='idnumber']", Date.now())
    .setValue("input[name='iddescription']", 'Driving License')
    .setValue("select[name='ishead']", 0)
    .click("input[name='submit']")
    .waitForElementVisible('body', 1000)
    .assert.title("Enroll Client Result")
    .assert.containsText("p", "Successfully enrolled client")
    .end();
  }
};
