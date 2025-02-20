<?php

namespace TheJano\EasyRegex;

class EasyRegex
{
    private array $parts = [];
    private string $flags = '';

    public function digit(): self
    {
        return $this->add('\d');
    }

    public function word(): self
    {
        return $this->add('\w');
    }

    public function whitespace(): self
    {
        return $this->add('\s');
    }

    public function nonWhitespace(): self
    {
        return $this->add('\S');
    }

    public function letter(): self
    {
        return $this->add('[a-zA-Z]');
    }

    public function anyCharacter(): self
    {
        return $this->add('.');
    }

    public function notRange(string $chars): self
    {
        return $this->add("[^" . $chars . "]");
    }

    public function hasSpecialCharacter(): self
    {
        return $this->add('(?=.*[!@#$%^&*])');
    }

    public function hasLetter(): self
    {
        return $this->add('(?=.*[a-zA-Z])');
    }

    public function hasDigit(): self
    {
        return $this->add('(?=.*\d)');
    }

    public function optional(): self
    {
        return $this->add('?');
    }

    public function exactly(int $n): self
    {
        return $this->add("{" . $n . "}");
    }

    public function atLeast(int $n): self
    {
        return $this->add("{" . $n . ",}");
    }

    public function atMost(int $n): self
    {
        if (!empty($this->parts)) {
            $lastIndex = count($this->parts) - 1;
            $this->parts[$lastIndex] = preg_replace('/\\\\d$/', '\d{0,' . $n . '}', $this->parts[$lastIndex]);
        }
        return $this;
    }

    public function between(int $min, int $max): self
    {
        return $this->add("{" . $min . "," . $max . "}");
    }

    public function oneOrMore(): self
    {
        return $this->add('+');
    }

    public function zeroOrMore(): self
    {
        return $this->add('*');
    }

    public function lazy(): self
    {
        return $this->add('?');
    }

    public function startGroup(): self
    {
        return $this->add('(?:');
    }

    public function startCaptureGroup(): self
    {
        return $this->add('(');
    }

    public function startNamedGroup(string $name): self
    {
        return $this->add('(?<' . $name . '>');
    }

    public function endGroup(): self
    {
        return $this->add(')');
    }

    public function startAnchor(): self
    {
        return $this->add('^');
    }

    public function endAnchor(): self
    {
        return $this->add('$');
    }

    public function wordBoundary(): self
    {
        return $this->add('\b');
    }

    public function nonWordBoundary(): self
    {
        return $this->add('\B');
    }

    public function negativeLookahead(string $pattern): self
    {
        return $this->add('(?!' . $pattern . ')');
    }

    public function positiveLookahead(string $pattern): self
    {
        return $this->add('(?=' . $pattern . ')');
    }

    public function positiveLookbehind(string $pattern): self
    {
        return $this->add('(?<=' . $pattern . ')');
    }

    public function negativeLookbehind(string $pattern): self
    {
        return $this->add('(?<!' . $pattern . ')');
    }

    public function global(): self
    {
        $this->flags .= 'g';
        return $this;
    }

    public function caseInsensitive(): self
    {
        $this->flags .= 'i';
        return $this;
    }

    public function multiline(): self
    {
        $this->flags .= 'm';
        return $this;
    }

    public function dotAll(): self
    {
        $this->flags .= 's';
        return $this;
    }

    public function sticky(): self
    {
        $this->flags .= 'y';
        return $this;
    }

    public function unicodeChar(string $variant = ''): self
    {
        return $this->add('\p{L' . $variant . '}');
    }

    public function unicodeDigit(): self
    {
        return $this->add('\p{N}');
    }

    public function unicodePunctuation(): self
    {
        return $this->add('\p{P}');
    }

    public function unicodeSymbol(): self
    {
        return $this->add('\p{S}');
    }

    public function escapeLiteral(string $text): self
    {
        return $this->add(preg_quote($text, '/'));
    }

    public function repeat(int $count): self
    {
        return $this->add("{" . $count . "}");
    }

    public function ipv4Octet(): self
    {
        return $this->add('(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)');
    }

    public function protocol(): self
    {
        return $this->add('https?:\/\/');
    }

    public function www(): self
    {
        return $this->add('(www\.)?');
    }

    public function tld(): self
    {
        return $this->add('\.[a-zA-Z]{2,}');
    }

    public function path(): self
    {
        return $this->add('(\/[\w-]*)*');
    }


    public function toString(): string
    {
        return implode('', $this->parts);
    }

    public function toRegExp(): string
    {
        return '/' . $this->toString() . '/' . $this->flags;
    }

    public function add(string $part): self  // NOW PUBLIC
    {
        $this->parts[] = $part;
        return $this;
    }
}