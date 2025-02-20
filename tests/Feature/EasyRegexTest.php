<?php

use TheJano\EasyRegex\EasyRegex;

it('generates digit regex', function () {
    $regex = (new EasyRegex())->digit()->toRegExp();

    expect($regex)->toBe('/\d/')
        ->and('5')->toMatch($regex)
        ->and('a')->not->toMatch($regex);
});

it('generates word regex', function () {
    $regex = (new EasyRegex())->word()->toRegExp();

    expect($regex)->toBe('/\w/')
        ->and('a')->toMatch($regex)
        ->and('9')->toMatch($regex)
        ->and(' ')->not->toMatch($regex);
});

it('generates letter regex', function () {
    $regex = (new EasyRegex())->letter()->toRegExp();

    expect($regex)->toBe('/[a-zA-Z]/')
        ->and('a')->toMatch($regex)
        ->and('Z')->toMatch($regex)
        ->and('1')->not->toMatch($regex);
});

it('generates whitespace regex', function () {
    $regex = (new EasyRegex())->whitespace()->toRegExp();

    expect($regex)->toBe('/\s/')
        ->and(' ')->toMatch($regex)
        ->and('a')->not->toMatch($regex);
});

it('generates non-whitespace regex', function () {
    $regex = (new EasyRegex())->nonWhitespace()->toRegExp();

    expect($regex)->toBe('/\S/')
        ->and('a')->toMatch($regex)
        ->and(' ')->not->toMatch($regex);
});

it('generates regex for letters and digits', function () {
    $regex = (new EasyRegex())->hasLetter()->hasDigit()->toRegExp();

    expect($regex)->toBe('/(?=.*[a-zA-Z])(?=.*\d)/')
        ->and('a1')->toMatch($regex)
        ->and('abc')->not->toMatch($regex)
        ->and('123')->not->toMatch($regex);
});

it('anchors regex correctly', function () {
    $regex = (new EasyRegex())
        ->startAnchor()
        ->hasLetter()
        ->hasDigit()
        ->word()
        ->oneOrMore()
        ->endAnchor()
        ->toRegExp();

    expect($regex)
        ->toBe('/^(?=.*[a-zA-Z])(?=.*\d)\w+$/')
        ->and('a1')->toMatch($regex)
        ->and('abc')->not->toMatch($regex)
        ->and('123')->not->toMatch($regex);
});

it('handles exact repetitions', function () {
    $regex = (new EasyRegex())->digit()->exactly(3)->toRegExp();

    expect($regex)->toBe('/\d{3}/')
        ->and('123')->toMatch($regex)
        ->and('12')->not->toMatch($regex);
});

it('handles at least repetitions', function () {
    $regex = (new EasyRegex())->letter()->atLeast(2)->toRegExp();

    expect($regex)->toBe('/[a-zA-Z]{2,}/')
        ->and('ab')->toMatch($regex)
        ->and('abc')->toMatch($regex)
        ->and('a')->not->toMatch($regex);
});

it('handles at most repetitions', function () {
    $regex = (new EasyRegex())->digit()->atMost(2)->toRegExp();

    expect($regex)->toBe('/\d{0,2}/')
        ->and('')->toMatch($regex)
        ->and('1')->toMatch($regex)
        ->and('12')->toMatch($regex);
});

it('handles between repetitions', function () {
    $regex = (new EasyRegex())->digit()->between(2, 4)->toRegExp();

    expect($regex)->toBe('/\d{2,4}/')
        ->and('12')->toMatch($regex)
        ->and('1234')->toMatch($regex)
        ->and('1')->not->toMatch($regex);
});

it('generates IPv4 address regex', function () {
    $regex = (new EasyRegex())
        ->ipv4Octet()
        ->add('\.')
        ->ipv4Octet()
        ->add('\.')
        ->ipv4Octet()
        ->add('\.')
        ->ipv4Octet()
        ->toRegExp();

    expect($regex)->toBe('/(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)/')
        ->and('192.168.1.1')->toMatch($regex)
        ->and('255.255.255.255')->toMatch($regex)
        ->and('256.256.256.256')->not->toMatch($regex);
});

it('validates URLs correctly using EasyRegex', function () {
    $regex = (new EasyRegex())
        ->startAnchor()
        ->protocol()
        ->www()
        ->add('[a-zA-Z0-9-]+')
        ->tld()
        ->path()
        ->endAnchor()
        ->toRegExp();


    expect($regex)
        ->toBe('/^https?:\/\/(www\.)?[a-zA-Z0-9-]+\.[a-zA-Z]{2,}(\/[\w-]*)*$/')
        ->and('https://www.example.com')->toMatch($regex)
        ->and('http://example.org/path/to/page')->toMatch($regex)
        ->and('https://my-site.xyz/category/item')->toMatch($regex)
        ->and('http://test.gov')->toMatch($regex)
        ->and('ftp://example.com')->not->toMatch($regex)
        ->and('https://example.c')->not->toMatch($regex)
        ->and('http://.example.com')->not->toMatch($regex)
        ->and('https://www..com')->not->toMatch($regex);
});


it('validates subdomain URLs correctly using EasyRegex', function () {
    $regex = (new EasyRegex())
        ->startAnchor()
        ->protocol()
        ->www()
        ->add('[a-zA-Z0-9]([a-zA-Z0-9-]*[a-zA-Z0-9])?(\.[a-zA-Z0-9]([a-zA-Z0-9-]*[a-zA-Z0-9])?)*')
        ->tld()
        ->path()
        ->endAnchor()
        ->toRegExp();

    expect($regex)
        ->toBe('/^https?:\/\/(www\.)?[a-zA-Z0-9]([a-zA-Z0-9-]*[a-zA-Z0-9])?(\.[a-zA-Z0-9]([a-zA-Z0-9-]*[a-zA-Z0-9])?)*\.[a-zA-Z]{2,}(\/[\w-]*)*$/')
        ->and('https://sub.example.com')->toMatch($regex)
        ->and('https://api.test.io')->toMatch($regex)
        ->and('https://mail.google.co.uk')->toMatch($regex)
        ->and('http://blog.my-website.net')->toMatch($regex)
        ->and('https://dev.subdomain.example.org')->toMatch($regex)
        ->and('ftp://example.com')->not->toMatch($regex)
        ->and('https://sub..example.com')->not->toMatch($regex)
        ->and('https://-sub.example.com')->not->toMatch($regex)
        ->and('http://example.c')->not->toMatch($regex)
        ->and('http://.example.com')->not->toMatch($regex);
});

