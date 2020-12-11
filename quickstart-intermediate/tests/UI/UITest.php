<?php
use Facebook\WebDriver\WebDriverBy;
use PHPUnit\Framework\TestCase;
use Facebook\WebDriver\WebDriverDimension;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverExpectedCondition;
/**
 * @property RemoteWebDriver driver
 */
class UITest extends TestCase
{
    const WINDOW_HEIGHT = 900;
    const WINDOW_WIDTH = 1080;
    const SELENIUM_SERVER_HOST = "http://selenium-chrome:4444/wd/hub";
    protected $driver;
    public function testRegisterToAddTask()
    {
        // ドライバーを生成
        $this->driver = RemoteWebDriver::create(self::SELENIUM_SERVER_HOST, DesiredCapabilities::chrome());
        // ブラウザの設定
        $this->driver->manage()->window()->setSize(new WebDriverDimension(self::WINDOW_WIDTH, self::WINDOW_HEIGHT));
        // 接続
        $this->driver->get("http://web/");
        $this->driver->wait()->until(WebDriverExpectedCondition::titleIs('Laravel Quickstart - Intermediate'));
        sleep(1);

        // =============================
        // 新規登録
        // =============================
        $registerElement = $this->driver->findElement(WebDriverBy::id("register"));
        $registerElement->click();

        $usernameElement = $this->driver->findElement(WebDriverBy::id("username"));
        $this->driver->wait()->until(WebDriverExpectedCondition::visibilityOf($usernameElement));
        sleep(1);
        $usernameElement->sendKeys('uitester');

        $emailElement = $this->driver->findElement(WebDriverBy::id("email"));
        $now = date("YmdHis");
        $emailText = 'uitester' . $now . '@example.com';
        $emailElement->sendKeys($emailText);
        sleep(1);

        $passwordElement = $this->driver->findElement(WebDriverBy::id("password"));
        $passwordText = 'Testtest1';
        $passwordElement->sendKeys($passwordText);
        sleep(1);

        $passwordConfirmElement = $this->driver->findElement(WebDriverBy::id("password_confirmation"));
        $passwordConfirmElement->sendKeys($passwordText);
        sleep(1);

        $submitElement = $this->driver->findElement(WebDriverBy::cssSelector('button[type="submit"]'));
        $submitElement->click();


        $loginNameElement = $this->driver->findElement(WebDriverBy::id("loginName"));
        $this->driver->wait()->until(WebDriverExpectedCondition::visibilityOf($loginNameElement));
        sleep(1);

        // =============================
        // ログアウト
        // =============================
        $dropDownElement = $this->driver->findElement(WebDriverBy::className("dropdown"));
        $this->driver->wait()->until(WebDriverExpectedCondition::visibilityOf($dropDownElement));
        $dropDownElement->click();
        sleep(1);

        $logoutElement = $this->driver->findElement(WebDriverBy::id("logout"));
        $logoutElement->click();
        sleep(1);

        // =============================
        // ログイン
        // =============================
        $loginElement = $this->driver->findElement(WebDriverBy::id("login"));
        $this->driver->wait()->until(WebDriverExpectedCondition::visibilityOf($loginElement));
        $loginElement->click();
        sleep(1);

        $emailElement = $this->driver->findElement(WebDriverBy::id("email"));
        $this->driver->wait()->until(WebDriverExpectedCondition::visibilityOf($emailElement));
        sleep(1);
        $emailElement->sendKeys($emailText);
        sleep(1);
        $passwordElement = $this->driver->findElement(WebDriverBy::id("password"));
        $passwordElement->sendKeys($passwordText);
        sleep(1);
        $submitElement = $this->driver->findElement(WebDriverBy::cssSelector('button[type="submit"]'));
        $submitElement->click();

        // =============================
        // タスク登録
        // =============================
        $taskNameElement = $this->driver->findElement(WebDriverBy::id("task-name"));
        $this->driver->wait()->until(WebDriverExpectedCondition::visibilityOf($taskNameElement));
        $taskText = "coding script.";
        $taskNameElement->sendKeys($taskText);

        $addSubmitElement = $this->driver->findElement(WebDriverBy::id("addSubmit"));
        $addSubmitElement->click();
        sleep(1);

        $currentTaskElement = $this->driver->findElement(WebDriverBy::className("table-text"));
        $currentTaskText = $currentTaskElement->getText();

        $this->assertSame($currentTaskText, $taskText);
        $this->driver->quit();
    }
}