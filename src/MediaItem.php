<?php

namespace AngryMoustache\DeviantartRss;

use SimpleXMLElement;

class MediaItem
{
    public function __construct(SimpleXMLElement $item)
    {
        $this->link = (string) $item->link;
        $item = $item->children('media', true);

        foreach ($item as $key => $value) {
            if ((string) $value !== '') {
                $this->{$key} = (string) $value;
            } else {
                $this->{$key}[] = (((array) $value->attributes())['@attributes'] ?? []);
            }
        }
    }

    public function getImage()
    {
        return optional($this)->content[0]['url'] ?? null;
    }

    public function getThumbnail()
    {
        return optional($this)->thumbnail[0]['url'] ?? null;
    }
}
