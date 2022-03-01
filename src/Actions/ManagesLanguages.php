<?php

namespace TechEnby\OctoPrint\Actions;

trait ManagesLanguages
{
    public function languages()
    {
        return $this->get('languages')['language_packs'];
    }

    public function uploadLanguage()
    {
        return $this->post('languages', ['json' => ['command' => 'start']]);
    }

    public function deleteLanguage($locale, $pack)
    {
        return $this->delete("languages/{$locale}/{$pack}")['language_packs'];
    }
}
