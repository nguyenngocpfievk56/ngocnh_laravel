<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TalkTest extends DuskTestCase
{
   /**
    * A Dusk test example.
    *
    * @return void
    */
    public function urlTalk()
   {
       return '/talk/talk/business/1772/';
   }
   public function urlLogin()
   {
       return '/auth/do-login';
   }

    public function testNotLogged()
   {
       $this->browse(function ($browser)  {
           $browser->visit($this->urlTalk())
                   ->assertSee('コメントするにはログインしてください');
       });
   }
   public function testCommentWrongTalk()
   {
       $this->browse(function ($browser)  {
           $browser->visit($this->urlLogin())
                   ->type('email', '1@elife.co.jp')
                   ->type('passwd', '111222333')
                   ->press('ログイン')
                   ->waitFor('.is-login')
                   ->visit($this->urlTalk())
                   ->press('投稿する')
                   ->assertPathIs($this->urlTalk())
                   ->waitForText('入力必須です。');
       });
   }
   public function testCommentTalk()
   {
       $this->browse(function ($browser)  {
           $comment = 'abcdefg';
           $browser->visit($this->urlTalk())
                   ->type('description',$comment)
                   ->press('投稿する')
                   ->assertPathIs($this->urlTalk())
                   ->waitForText($comment);
       });
   }
}
