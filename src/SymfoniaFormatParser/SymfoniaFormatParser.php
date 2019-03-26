<?php

namespace SymfoniaFormatParser;

class SymfoniaFormatParser
{
    /**
     * @param String $input
     * @return array
     */
    public static function parse($input)
    {
        return self::toArray($input);
    }

    /**
     * @param String $input
     * @return array
     */
    private static function toArray(String $input)
    {
        $input = iconv("CP1250", "UTF-8", $input);
        $data = [];
        $curr = &$data;
        $stack = [];
        $separator = "\r\n";
        $line = strtok($input, $separator);
        while ($line !== false) {
            $objectName = self::checkIfLineIsStructureStart($line);
            if ($objectName) {
                $stack[] = &$curr;
                $curr = &$curr[];
                $curr["__NAME__"] = $objectName;
                $line = strtok($separator);
                continue;
            } else if (trim($line) == "}") {
                $curr = &$stack[count($stack) - 1];
                array_pop($stack);
                $line = strtok($separator);
                continue;
            }
            $explode = explode("=", trim($line));
            $curr[trim($explode[0])] = $explode[1];
            $line = strtok($separator);
        }

        $data = self::array_group_by($data, "__NAME__");
        $data = self::flatten($data);

        return $data;
    }

    private static function checkIfLineIsStructureStart($line)
    {
        if (substr($line, -1, 1) === '{') {
            $re = '/([a-z0-9]+){/i';
            preg_match($re, $line, $matches);
            if (!count($matches) > 0) {
                return false;
            }
            $structureName = $matches[1];
            return $structureName;
        }
        return false;
    }

    /**
     * @param array $array
     * @param $key
     * @return array
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    private static function array_group_by(array $array, $key)
    {
        $func = (!is_string($key) && is_callable($key) ? $key : null);
        $_key = $key;
        $grouped = [];
        foreach ($array as $value) {
            $key = null;
            if (is_callable($func)) {
                $key = call_user_func($func, $value);
            } elseif (is_object($value) && isset($value->{$_key})) {
                $key = $value->{$_key};
            } elseif (isset($value[$_key])) {
                $key = $value[$_key];
            }
            if ($key === null) {
                continue;
            }
            unset($value[$_key]);
            $grouped[$key][] = $value;
        }
        if (func_num_args() > 2) {
            $args = func_get_args();
            foreach ($grouped as $key => $value) {
                $params = array_merge([$value], array_slice($args, 2, func_num_args()));
                $grouped[$key] = call_user_func_array('array_group_by', $params);
            }
        }
        return $grouped;
    }

    /**
     * @param $data
     * @return mixed
     */
    private static function flatten($data)
    {
        foreach ($data as $key => $item) {
            if (count($item) == 1) {
                $data[$key] = $item[0];
            } else {
                $data[$key] = $item;
            }
        }

        foreach ($data as $l1key => $level1) {
            foreach ($level1 as $l2key => $level2) {
                if (is_array($level2) && array_key_exists("__NAME__", $level2)) {
                    $data[$l1key][$level2["__NAME__"]] = $level2;
                    unset($data[$l1key][$level2["__NAME__"]]["__NAME__"]);
                    unset($data[$l1key][$l2key]);
                }
            }
        }
        return $data;
    }
}