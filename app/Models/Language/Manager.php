<?php

namespace App\Models\Language;

class Manager
{
    public function store($data)
    {
        $data = $this->processSave($data);
        $language = new Language($data);
        $language->save();
        $this->updateDefault($language);
        return $language;
    }

    public function update($id, $data)
    {
        $language = Language::findOrFail($id);
        $data = $this->processSave($data);
        $language->update($data);
        $this->updateDefault($language);
        return $language;
    }

    protected function processSave($data)
    {
        if (!isset($data['default'])) {
            $data['default'] = Language::NOT_DEFAULT_LNG;
        }
        return $data;
    }

    protected function updateDefault(Language $language)
    {
        if ($language->default == Language::DEFAULT_LNG) {
            Language::where('id', '!=', $language->id)->update(['default' => Language::NOT_DEFAULT_LNG]);
        }
    }

    public function delete($id)
    {
        Language::find($id)->delete();
        return true;
    }
}