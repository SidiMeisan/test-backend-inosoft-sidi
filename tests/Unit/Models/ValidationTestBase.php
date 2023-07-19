<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

abstract class ValidationTestBase extends TestCase
{
    use InteractsWithExceptionHandling;

    protected $model;

    /**
     * @dataProvider validationDataProvider
     */
    public function testValidation(array $data, bool $shouldPass)
    {
        $model = $this->createModel();

        if ($shouldPass) {
            $this->assertValidationPasses($model, $data);
        } else {
            $this->assertValidationFails($model, $data);
        }
    }

    protected function createModel()
    {
        return new $this->model();
    }

    protected function assertValidationPasses($model, $data)
    {
        $validatedData = $model->validate($data);

        $this->assertEquals($data, $validatedData);
    }

    protected function assertValidationFails($model, $data)
    {
        $this->expectException(ValidationException::class);

        Validator::make($data, $model->rules())->validate();
    }

    abstract public function validationDataProvider(): array;
}
