<?php

namespace Tests\Feature;

use App\User;
use App\Lists;
use App\Campaign;
use Tests\TestCase;
use App\Jobs\SendCampaign;
use App\Mail\CampaignMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CampaignTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function itCanOpenCampainsIndexPage()
    {
        $campaign = factory(Campaign::class)->create();
        $campaign2 = factory(Campaign::class)->create();

        $response = $this->actingAs($this->user)->get(route('campaigns.index'));

        $response->assertSuccessful()->assertSeeText($campaign->subject);

        $this->assertEquals(2, Campaign::count());
    }

    /** @test */
    public function itCanOpenCampaignCreatePage()
    {
        $response = $this->actingAs($this->user)->get(route('campaigns.create'));

        $response->assertSuccessful()->assertSeeText('Create new campaign');
    }

    /** @test */
    public function itCanSaveNewCampaign()
    {
        $response = $this->actingAs($this->user)->post(route('campaigns.store'), [ 'subject' => 'My campaign', 'sending_name' => 'Emir', 'sending_email' => 'tom@sawyer.com', 'content' => 'Content' ]);

        $this->assertEquals(1, Campaign::count());
    }

    /** @test */
    public function itCanOpenEditCampaignPage()
    {
        $campaign = factory(Campaign::class)->create();

        $response = $this->actingAs($this->user)->get(route('campaigns.edit', $campaign->id));

        $response->assertSuccessful();
    }

    /** @test */
    public function itCanUpdateCampaign()
    {
        $campaign = factory(Campaign::class)->create();

        $response = $this->actingAs($this->user)->put(route('campaigns.update', $campaign->id), 
        [ 'subject' => 'Edited subject',
        'sending_name' => $campaign->sending_name,
        'sending_email' => $campaign->sending_email,
        'content' => $campaign->content
        ]);
        
        $response->assertRedirect(route('campaigns.show', $campaign->id));

        $campaign = Campaign::first();

        $this->assertEquals('Edited subject', $campaign->subject);
    }

    /** @test */
    public function itCanDeleteCampaign()
    {
        $campaign = factory(Campaign::class)->create();

        $response = $this->actingAs($this->user)->delete(route('campaigns.delete', $campaign->id));

        $this->assertEquals(0, Campaign::count());
        
    }

    /** @test */
    public function itSendsTestMail()
    {
        Mail::fake();

        $campaign = factory(Campaign::class)->create();

        $email = 'emir@test.com';
        $response = $this->actingAs($this->user)->post(route('campaigns.send.test', $campaign->id), [ 'email' => $email]);

        Mail::assertQueued(CampaignMail::class, function ($mail) use ($email) {
            return $mail->hasTo($email);
        });
    }

    /** @test */
    public function itCanDuplicateCampaign()
    {
        $campaign = factory(Campaign::class)->state('sent')->create();

        $response = $this->actingAs($this->user)->post(route('campaigns.duplicate', $campaign->id));

        $record = Campaign::all()->last();

        $this->assertEquals(2, Campaign::count());
        $this->assertEquals('draft', $record->status);
    }

}
