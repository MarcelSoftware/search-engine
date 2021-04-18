<?php

namespace Sowas;

class SearchEngine
{
    public function __construct(array $data = null, string $attribute = null)
    {
        $this->data = $data;
        $this->attribute = $attribute;

        if ($data === null) {
            $this->data = explode("\n", file_get_contents(__DIR__ . "/../words/deutsch.txt"));
        }
    }

    public function search(string $search_term, int $out_count = null, int $min_percentage = null)
    {
        $matches = [];
        foreach ($this->data as $word) {
            if ($this->attribute === null) {
                $matches[$word] = 0;
            } else {
                $attr = $this->attribute;
                $matches[$word->$attr] = 0;
            }
        }

        foreach ($this->data as $title) {
            if ($this->attribute === null) {
                similar_text($title, $search_term, $percentage);
            } else {
                $attr = $this->attribute;
                similar_text($title->$attr, $search_term, $percentage);
            }
            if ($this->attribute === null) {
                $matches[$title] = $percentage;
            } else {
                $attr = $this->attribute;
                $matches[$title->$attr] = $percentage;
            }
        }

        arsort($matches);

        if ($min_percentage !== null) {
            $matches = $this->getOnlyGoodMatches($matches, $min_percentage);
        }

        if ($out_count === null) {
            $matches = array_keys($matches);
            if ($this->attribute === null) {
                return $matches;
            }
            $outMatches = [];
            $attr = $this->attribute;
            foreach ($matches as $match) {
                $item = null;
                foreach ($this->data as $data) {
                    if ($data->$attr == $match) {
                        $item = $data;
                    }
                }
                $outMatches[] = $item;
            }
            return $outMatches;
        }
        return array_keys(array_slice($matches, 0, $out_count));
    }

    private function getOnlyGoodMatches(array $matches, int $min_percentage = 0): array
    {
        $out_matches = [];
        foreach ($matches as $word => $percentage) {
            if ($percentage < $min_percentage) {
                return $out_matches;
            }
            $out_matches[$word] = $percentage;
        }
        return $out_matches;
    }
}
