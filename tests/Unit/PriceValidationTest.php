<?php

namespace Tests\Unit;

use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
use ReflectionMethod;
use Tests\TestCase;

class PriceValidationTest extends TestCase
{
    #[DataProvider('priceCases')]
    public function test_price_formats_are_normalized_and_validated(
        string $requestClass,
        string $input,
        bool $expectedValid,
        ?string $expectedNormalized = null,
    ): void {
        $request = $requestClass::create('/', 'POST', ['harga' => $input]);
        $prepare = new ReflectionMethod($requestClass, 'prepareForValidation');
        $prepare->invoke($request);

        $normalized = (string) $request->input('harga');
        $validator = Validator::make(
            ['harga' => $normalized],
            ['harga' => $request->rules()['harga']]
        );

        $this->assertSame($expectedValid, ! $validator->fails());

        if ($expectedNormalized !== null) {
            $this->assertSame($expectedNormalized, $normalized);
        }
    }

    public static function priceCases(): array
    {
        $cases = [];

        foreach ([StoreBukuRequest::class, UpdateBukuRequest::class] as $requestClass) {
            $prefix = $requestClass === StoreBukuRequest::class ? 'store' : 'update';
            $cases["{$prefix} integer"] = [$requestClass, '123333', true, '123333'];
            $cases["{$prefix} comma decimal"] = [$requestClass, '99900,00', true, '99900.00'];
            $cases["{$prefix} Indonesian format"] = [$requestClass, '99.900,00', true, '99900.00'];
            $cases["{$prefix} dot decimal"] = [$requestClass, '99900.50', true, '99900.50'];
            $cases["{$prefix} negative"] = [$requestClass, '-1', false, '-1'];
            $cases["{$prefix} invalid text"] = [$requestClass, 'sembilan', false, 'sembilan'];
            $cases["{$prefix} too many decimals"] = [$requestClass, '12,345', false, '12.345'];
        }

        return $cases;
    }
}