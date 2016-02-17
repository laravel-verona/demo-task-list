<?php

class TaskCreateRequestTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->request = new \App\Http\Requests\TaskCreateRequest();
    }

    /** @test */
    public function everyone_should_be_authorized_to_make_the_request()
    {
        $this->assertTrue($this->request->authorize());
    }

    /** @test */
    public function the_validation_should_be_performed_on_name_and_done_fields()
    {
        $this->assertArrayHasKey('name', $this->request->rules());
        $this->assertArrayHasKey('done', $this->request->rules());
    }

    /** @test */
    public function the_validation_on_the_name_of_the_task_is_required()
    {
        $this->assertContains('required', $this->request->rules()['name']);
    }

    /** @test */
    public function the_done_attribute_of_the_task_should_be_a_boolean_value()
    {
        $this->assertContains('boolean', $this->request->rules()['done']);
    }
}
