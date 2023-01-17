<?php

namespace Tests\Unit;

use App\Sortable;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SortableTest extends TestCase
{
    protected $sortable;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sortable = new Sortable('http://laratdd/demo');
    }
    /** @test */
    function return_a_css_class_to_indicate_the_column_is_sortable()
    {
        $this->assertSame('link-sortable', $this->sortable->classes('first_name'));
    }

    /** @test */
    function return_css_classes_to_indicate_the_column_is_sorted_in_ascendent_order()
    {
        $this->sortable->appends(['order' => 'first_name']);

        $this->assertSame('link-sortable link-sorted-up', $this->sortable->classes('first_name'));
    }

    /** @test */
    function return_css_classes_to_indicate_the_column_is_sorted_in_descendent_order()
    {
        $this->sortable->appends(['order' => 'first_name-desc']);

        $this->assertSame('link-sortable link-sorted-down', $this->sortable->classes('first_name'));
    }

    /** @test */
    function builds_a_url_with_sortable_data()
    {
        $this->assertSame(
            'http://laratdd/demo?order=first_name',
            $this->sortable->url('first_name')
        );
    }

    /** @test */
    function builds_a_url_with_desc_order_if_the_current_column_matches_the_given_one_and_the_current_direction_is_asc()
    {
        $this->sortable->appends(['order' => 'first_name']);

        $this->assertSame(
            'http://laratdd/demo?order=first_name-desc',
            $this->sortable->url('first_name-desc')
        );
    }

    /** @test */
    function appends_query_data_to_the_url()
    {
        $this->sortable->appends([
            'a' => 'parameter',
            'and' => 'another-parameter'
        ]);

        $this->assertSame(
            'http://laratdd/demo?a=parameter&and=another-parameter&order=first_name',
            $this->sortable->url('first_name')
        );
    }

    /** @test */
    function gets_the_info_about_the_column_name_and_the_order_direction()
    {
        $this->assertSame(['first_name', 'asc'], Sortable::info('first_name'));
        $this->assertSame(['first_name', 'desc'], Sortable::info('first_name-desc'));
        $this->assertSame(['email', 'asc'], Sortable::info('email'));
        $this->assertSame(['email', 'desc'], Sortable::info('email-desc'));
    }
}
