// $ chrome.exe --remote-debugging-port=9222 --user-data-dir="./temp"

var webdriver = require('selenium-webdriver');
var chrome = require("selenium-webdriver/chrome");
var options = new chrome.Options();
options.options_["debuggerAddress"] = "localhost:9222";

(async function example() {
    driver = await new webdriver.Builder()
        .forBrowser('chrome')
        .setChromeOptions(options)
        .build();

    await driver.get('https://web.whatsapp.com/');
    await driver.quit();
})();