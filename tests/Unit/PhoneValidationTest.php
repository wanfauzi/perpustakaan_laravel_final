<?php

namespace Tests\Unit;

use App\Http\Requests\StoreAnggotaRequest;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class PhoneValidationTest extends TestCase
{
    #[DataProvider('phoneNumbers')]
    public function test_phone_number_format(string $phone, bool $expected): void
    {
        $rules = (new StoreAnggotaRequest())->rules()['telepon'];
        $regexRule = collect($rules)->first(
            fn (string $rule) => str_starts_with($rule, 'regex:')
        );
        $pattern = substr($regexRule, strlen('regex:'));

        $this->assertSame($expected, preg_match($pattern, $phone) === 1);
    }

    public static function phoneNumbers(): array
    {
        return [
            'invalid landline-like prefix' => ['0222222222222', false],
            'invalid letters' => ['08123ABC789', false],
            'valid local mobile' => ['081234567890', true],
            'valid country code' => ['6281234567890', true],
            'valid plus country code' => ['+6281234567890', true],
        ];
    }
}