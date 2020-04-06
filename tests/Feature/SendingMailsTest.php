<?php

namespace Tests\Feature;

use App\Campaign;
use App\Service;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Mail;
use Swift_Events_EventListener;
use Swift_Message;
use Tests\TestCase;

class SendingMailsTest extends TestCase
{
    use DatabaseMigrations;

    protected $emails = [];

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();

        Mail::getSwiftMailer()->registerPlugin(new TestingMailEventListener($this));
    }

    /** @test */
    public function itSendsTestMail()
    {
        $campaign = factory(Campaign::class)->create();
        $service = factory(Service::class)->create();

        $email = 'emir@test.com';
        $response = $this->actingAs($this->user)->post(route('campaigns.send.test', $campaign->id), ['email' => $email]);

        $this->assertNotEmpty($this->emails);
    }

    public function addEmail(Swift_Message $email)
    {
        $this->emails[] = $email;
    }
}

class TestingMailEventListener implements Swift_Events_EventListener
{
    protected $test;

    public function __construct($test)
    {
        $this->test = $test;
    }

    public function beforeSendPerformed($event)
    {
        $message = $event->getMessage();

        $this->test->addEmail($message);
    }
}
