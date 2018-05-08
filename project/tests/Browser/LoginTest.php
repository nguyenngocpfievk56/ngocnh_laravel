<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
   /**
    * A Dusk test example.
    *
    * @return void
    */
   public function urlLogin()
   {
       return '/auth/do-login';
   }

   public function testWrongLoginMessage()
   {
       //dont type anything
       $this->browse(function ($browser)  {
           $browser->visit($this->urlLogin())
                   ->press('ログイン')
                   ->assertSee('入力必須です。')
                   ->assertPathIs('/auth/do-login');
       });
       //type wrong
       $this->browse(function (Browser $browser) {
           $browser->visit($this->urlLogin())
               ->type('email', 'abcdef@elife.co.jp')
               ->type('passwd', 'aaaaaaaa')
               ->press('ログイン')
               ->assertSee('ログインに失敗しました。')
               ->assertPathIs($this->urlLogin());
       });
   }
   public function testBasicLogin()
   {
       $this->browse(function ($browser)  {
           $browser->visit($this->urlLogin())
                   ->type('email', '1@elife.co.jp')
                   ->type('passwd', '111222333')
                   ->press('ログイン')
                   ->assertVisible('.is-login')
                   ->assertSee('すずき')
                   ->assertPathIs('/');
       });
   }
   
   public function testUserLogout()
   {
       $this->browse(function ($browser)  {
           $browser->visit('/')
                   ->click('.cs-h-toolbar-item--user')
                   ->clickLink('ログアウト')
                   ->visit('/')
                   ->assertSee('ログイン');
       });
   }
}
