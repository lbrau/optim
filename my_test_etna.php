<?php

require_once 'vendor/autoload.php';

class WebDriverDemoShootout extends Sauce\Sausage\WebDriverTestCase
{

    protected $base_url = 'https://intra.etna-alternance.net/';
   // protected $base_url = 'http://tutorialapp.saucelabs.com';

    public static $browsers = array(
        // run FF15 on Vista on Sauce
        array(
            'browserName' => 'firefox',
            'desiredCapabilities' => array(
                'version' => '15',
                'platform' => 'VISTA'
            )
        )
    );

    protected function randomUser()
    {
        $id = uniqid();
        return array(
            'username' => "fakeuser_$id",
            'password' => 'testpass',
            'name' => "Fake $id",
            'email' => "$id@fake.com"
        );
    }

    protected function doLogin($username, $password)
    {
        $this->url('/');
        $this->byName('login')->value($username);
        $this->byName('password')->value($password);
        $this->byCss('input.login')->click();

        $this->assertTextPresent("Logged in successfully", $this->byId('message'));
    }

    protected function doLogout()
    {
        $this->url('/logout');
        $this->assertTextPresent("Logged out successfully", $this->byId('message'));
    }

    protected function doRegister($user, $logout = false)
    {
        $user['confirm_password'] = isset($user['confirm_password']) ?
            $user['confirm_password'] : $user['password'];
        $this->url('/register');
        //$this->byId('username')->value($user['username']);
        $this->byId('password')->value($user['password']);
        $this->byId('confirm_password')->value($user['confirm_password']);
        $this->byId('name')->value($user['name']);
        $this->byId('email')->value($user['email']);
        $this->byId('form.submitted')->click();

        if ($logout)
            $this->doLogout();
    }

    public function setUpPage()
    {
        $this->url('https://intra.etna-alternance.net/');
        //$this->url('http://tutorialapp.saucelabs.com');
    }

    public function testLoginFailsWithBadCredentials()
    {
        $true_username = "brau_l";
        $true_password = $this->pass();
        //$fake_username = uniqid();
        //$fake_password = uniqid();

        $this->url('/');
        $this->byId('login-text')->value($true_username);
        $this->byId('password')->value($true_password);
        //$this->byId('login-text')->value($fake_username);
        //$this->byName('password')->value($fake_password);
        $this->byCss('input.submit')->click();
        $this->assertTextPresent("Failed to login.", $this->byId('message'));
    }

    public function pass() {
        return "b6SlX4rw";
    }

}
