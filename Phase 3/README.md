# Hello World

# Set up development environment
1. Install MAMP. Note: you do NOT need PRO version (http://documentation.mamp.info/en/MAMP-Mac/Installation/)
1. Configure DocumentRoot to be /6400Spring17Team067/Phase 3/web (http://documentation.mamp.info/en/MAMP-Mac/Preferences/Web-Server/)
1. Try to go to localhost:8888 and localhost:8888/web-reports/
1. Done!

# Turn on debug
1. Go to `/Applications/MAMP/bin/php/php7.1.1/conf/php.ini`
1. Change as below:
    1. `error_reporting  =  E_ALL`
    1. `display_errors = On`

# Set up testing environment
1. Installation
    1. Install brew: `/usr/bin/ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"`
    1. Install nodejs: `brew install nodejs`
    1. Install nightwatch: `npm install -g nightwatch`

1. Run nightwatch (http://nightwatchjs.org/guide)
    1. `cd webtest`
    1. `nightwatch tests/*`
