<?php

namespace BarnebysMautic;

class Tags
{

    private $_tags = [];

    /**
     * @param $name
     * @return $this
     */
    public function addTag($name) {
        if (!in_array($name, $this->_tags)) {
            $this->_tags[] = $name;
        }

        return $this;
    }

    /**
     * @param $name
     * @return $this
     */
    public function removeTag($name) {
        if (in_array($name, $this->_tags)) {
            unset($this->_tags[$name]);
        }

        $this->_tags[] = '-' . $name;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return ['tags' => $this->_tags];
    }

}
