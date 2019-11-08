<?php

namespace Tests\Browser;

use App\Lists;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\ListCreatePage;
use Tests\Browser\Pages\ListsPage;
use Tests\DuskTestCase;

class ListsTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function openListsPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new ListsPage)
                ->assertSee('Lists');
        });
    }

    /** @test */
    public function isThereListOnListsPage()
    {
        $list = factory(Lists::class)->create([
            'name'  => 'My testing list',
        ]);

        $this->browse(function (Browser $browser) use ($list) {
            $browser->visit(new ListsPage)
            ->assertSee($list->name);
        });
    }

    /** @test */
    public function openCreateListPageFromLists()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new ListsPage)
            ->clickLink('Create list')
            ->assertSee('Create new list');
        });
    }

    /** @test */
    public function createNewList()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new ListCreatePage)
            ->type('name', 'My latest list')
            ->press('Save')
            ->assertSee('My latest list');
        });
    }
}
