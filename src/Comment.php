<?php

namespace Spatie\SqlCommenter;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Stringable;

class Comment implements Stringable
{
    public static function make(string $key, ?string $value): self
    {
        return new self($key, $value);
    }

    /**
     * @param Collection<Comment> $comments
     *
     * @return string
     */
    public static function formatCollection(Collection $comments): string
    {
        if ($comments->isEmpty()) {
            return '';
        }

        $commentsAsString = $comments
            ->map(fn (Comment $comment) => (string)$comment)
            ->join(",");

        return Str::of($commentsAsString)
            ->prepend('/*')
            ->append("*/");
    }

    public function __construct(
        public string $key,
        public ?string $value,
    ) {
    }

    public function __toString(): string
    {
        return urlencode($this->key) . "=" . "'" . urlencode($this->value) . "'";
    }
}
