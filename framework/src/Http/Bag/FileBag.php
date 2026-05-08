<?php

namespace Framework\Http\Bag;

class FileBag extends ParamBag
{
    /** @param array $file */
    public function set(string $key, $file)
    {
        return parent::set($key, $this->normalize($file));
    }

    private function normalize(array $file): array
    {
        if (!is_array($file['name'])) {
            return $file;
        }

        $items = [];
        $count = count($file['name']);

        for ($a = 0; $a < $count; $a++) {
            $item = [];
            foreach ($file as $key => $values) {
                $item[$key] = $values[$a];
            }

            $items[] = $item;
        }

        return $items;
    }
}
