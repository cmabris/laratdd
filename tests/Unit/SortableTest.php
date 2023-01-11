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
        $this->sortable->setCurrentOrder('first_name');

        $this->assertSame('link-sortable link-sorted-up', $this->sortable->classes('first_name'));
    }

    /** @test */
    function return_css_classes_to_indicate_the_column_is_sorted_in_descendent_order()
    {
        $this->sortable->setCurrentOrder('first_name', 'desc');

        $this->assertSame('link-sortable link-sorted-down', $this->sortable->classes('first_name'));
    }

    /** @test */
    function builds_a_url_with_sortable_data()
    {
        $this->assertSame(
            'http://laratdd/demo?order=first_name&direction=asc',
            $this->sortable->url('first_name')
        );
    }

    /** @test */
    function builds_a_url_with_descendent_order()
    {
        $this->assertSame(
            'http://laratdd/demo?order=first_name&direction=desc',
            $this->sortable->url('first_name', 'desc')
        );
    }
}
