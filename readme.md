# EasyRegex

## A Human-Readable Regex Builder for PHP

EasyRegex is a fluent and human-readable regex builder for PHP that simplifies constructing complex regular expressions without manually writing regex patterns.

---

## Installation

To install this package using Composer, run:

```sh
composer require thejano/easy-php-regex
```

---

## Usage

### Creating Regex Patterns

Use the `EasyRegex` class to build and generate regex patterns fluently.

#### Example: Matching an Email Address

```php
use TheJano\EasyRegex\EasyRegex;

$regex = (new EasyRegex())
    ->startAnchor()
    ->word()
    ->oneOrMore()
    ->add('@')
    ->word()
    ->oneOrMore()
    ->add('.')
    ->word()
    ->between(2, 5)
    ->endAnchor()
    ->toRegExp();

// Output: /^\w+@\w+\.\w{2,5}$/
```

#### Example: Validating a Strong Password

```php
$regex = (new EasyRegex())
    ->startAnchor()
    ->hasLetter()
    ->hasDigit()
    ->hasSpecialCharacter()
    ->atLeast(8)
    ->endAnchor()
    ->toRegExp();

// Output: /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[!@#$%^&*]).{8,}$/
```

#### Example: Matching a URL

```php
$regex = (new EasyRegex())
    ->protocol()
    ->www()
    ->word()
    ->oneOrMore()
    ->tld()
    ->path()
    ->toRegExp();

// Output: /https?:\/\/(www\.)?\w+\.[a-zA-Z]{2,}(\/\w*)*/
```

---

## Available Methods

### Character Classes
- `digit()` - Matches a digit (`\d`)
- `word()` - Matches a word character (`\w`)
- `whitespace()` - Matches a whitespace character (`\s`)
- `nonWhitespace()` - Matches a non-whitespace character (`\S`)
- `letter()` - Matches a letter (`[a-zA-Z]`)
- `anyCharacter()` - Matches any character (`.`)

### Quantifiers
- `optional()` - Matches zero or one times (`?`)
- `exactly(int $n)` - Matches exactly `n` times (`{n}`)
- `atLeast(int $n)` - Matches at least `n` times (`{n,}`)
- `atMost(int $n)` - Matches up to `n` times
- `between(int $min, int $max)` - Matches between `min` and `max` times (`{min,max}`)
- `oneOrMore()` - Matches one or more times (`+`)
- `zeroOrMore()` - Matches zero or more times (`*`)

### Grouping & Anchors
- `startGroup()` - Starts a non-capturing group (`(?:`)
- `startCaptureGroup()` - Starts a capturing group (`(`)
- `startNamedGroup(string $name)` - Starts a named group (`(?<name>`)
- `endGroup()` - Ends a group (`)`)
- `startAnchor()` - Matches the beginning of the string (`^`)
- `endAnchor()` - Matches the end of the string (`$`)

### Lookaheads & Lookbehinds
- `negativeLookahead(string $pattern)` - Negative lookahead (`(?!pattern)`)
- `positiveLookahead(string $pattern)` - Positive lookahead (`(?=pattern)`)
- `positiveLookbehind(string $pattern)` - Positive lookbehind (`(?<=pattern)`)
- `negativeLookbehind(string $pattern)` - Negative lookbehind (`(?<!pattern)`)

### Flags
- `global()` - Applies the global (`g`) flag
- `caseInsensitive()` - Applies the case-insensitive (`i`) flag
- `multiline()` - Applies the multiline (`m`) flag
- `dotAll()` - Applies the dot-all (`s`) flag
- `sticky()` - Applies the sticky (`y`) flag

### Unicode Support
- `unicodeChar(string $variant = '')` - Matches a Unicode letter (`\p{L}`)
- `unicodeDigit()` - Matches a Unicode digit (`\p{N}`)
- `unicodePunctuation()` - Matches a Unicode punctuation (`\p{P}`)
- `unicodeSymbol()` - Matches a Unicode symbol (`\p{S}`)

### Special Helpers
- `escapeLiteral(string $text)` - Escapes special characters
- `ipv4Octet()` - Matches an IPv4 octet (`(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)`)
- `protocol()` - Matches `http` or `https`
- `www()` - Matches optional `www.`
- `tld()` - Matches a top-level domain (`\.[a-zA-Z]{2,}`)
- `path()` - Matches a URL path (`(\/\w*)*`)

### Generating Regex Patterns
- `toString()` - Returns the raw regex pattern
- `toRegExp()` - Returns the full regex pattern wrapped in `/.../`

---

## Running Tests

To run the test suite using Pest, execute:

```sh
vendor/bin/pest
```

---

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).

---

## Author

Created by [Pshtiwan Mahmood](mailto:pshtiwan@thejano.com).

