<?php

namespace App;

class JsonFile
{
    private $_file;

    public function __construct($path){
        $this->_file = $this->parseJson($path);

        if (JSON_ERROR_NONE !== json_last_error()) {
            $errorMessage = sprintf(
                'Invalid Config (JSON error) "%s" in "%s"', $this->getErrorMessage(json_last_error()), $path);

            throw new Exception($errorMessage);
        }
    }

    public function getFile(){
        return $this->_file;
    }

    public function getSection($keyname){
        return isset($this->_file[$keyname]) ? $this->_file[$keyname] : null;
    }

    private function parseJson($filename)
    {
        $json = file_get_contents($filename);

        return json_decode($json, true);
    }

    private function getErrorMessage($code){
        $msgs = array(
            JSON_ERROR_DEPTH            => 'The maximum stack depth has been exceeded',
            JSON_ERROR_STATE_MISMATCH   => 'Invalid or malformed JSON',
            JSON_ERROR_CTRL_CHAR        => 'Control character error, possibly incorrectly encoded',
            JSON_ERROR_SYNTAX           => 'Syntax error',
            JSON_ERROR_UTF8             => 'Malformed UTF-8 characters, possibly incorrectly encoded',
        );

        return isset($msgs[$code]) ? $msgs[$code] : 'Unknown';
    }
}