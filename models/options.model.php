<?php

/*
  # Tatwerat Team FrameWork
  # By Abdo Hamoud
 */

class M_Options extends AH_Model {

    public $model_msg;

    public function getOptions($name) {
        $options = $this->DB->table('options');
        $options->where('option_name', $name);
        $data = $options->get_one();
        if ($data)
            return $data['option_value'];
    }

    public function get_themeOptions($name) {
        $options = $this->DB->table('options');
        $options->where('option_name', 'theme');
        $data = $options->get_one();
        if ($data) {
            $theme_options = $data['option_value'];
            if ($theme_options) {
                $option_array = unserialize($theme_options);
                if (is_array($option_array)) {
                    if (isset($option_array[$name]))
                        return $option_array[$name];
                }
            }
        }
    }

    public function saveOptions($data) {
        $options = $this->DB->table('options');
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $options->where('option_name', $key);
                $options->update(array('option_value' => serialize($value)));
            } else {
                $options->where('option_name', $key);
                $options->update(array('option_value' => $this->DB->escape($this->xss_remove($value), true)));
            }
        }
    }

}
