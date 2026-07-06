<?php

namespace Tests\Unit;

use App\Http\Requests\StoreAnggotaRequest;
use App\Http\Requests\UpdateAnggotaRequest;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AgeValidationTest extends TestCase
{
    use WithFaker;

    #[DataProvider('requestClasses')]
    public function test_member_must_be_at_least_five_years_old(string $requestClass): void
    {
        $rules = (new $requestClass())->rules()['tanggal_lahir'];

        $tooYoung = Validator::make([
            'tanggal_lahir' => today()->subYears(4)->toDateString(),
        ], ['tanggal_lahir' => $rules]);

        $minimumAge = Validator::make([
            'tanggal_lahir' => today()->subYears(5)->toDateString(),
        ], ['tanggal_lahir' => $rules]);

        $this->assertTrue($tooYoung->fails());
        $this->assertFalse($minimumAge->fails());
    }

    public static function requestClasses(): array
    {
        return [
            'store request' => [StoreAnggotaRequest::class],
            'update request' => [UpdateAnggotaRequest::class],
        ];
    }
}