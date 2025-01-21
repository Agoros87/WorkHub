<?php


use App\Models\Advertisement;
use function Pest\Laravel\get;

it('Shows advertisements overview', function () {
    //Arrange
    $firstAds = Advertisement::factory()->create();
    $secondAds = Advertisement::factory()->create();
    $thirdAds= Advertisement::factory()->create();

    //Act

    get(route('welcome'))
        ->assertSeeText([
            $firstAds->title,
            $firstAds->description,
            $secondAds->title,
            $secondAds->description,
            $thirdAds->title,
            $thirdAds->description,
        ]);
});
