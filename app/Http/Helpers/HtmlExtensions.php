<?php

namespace App\Http\Helpers;

use App\TypeEmail;
use App\TypePhone;

class HtmlExtensions
{

    public static function selectEmail($id, $name, $class = "", $selected = "")
    {
        $types = TypeEmail::all(['id', 'name']);
        $html = '<select '.$selected.' name="' . $name . '" id="' . $id . '" class="' . $class . '">';

        foreach ($types as $type) {
            $html .= '<option ' . (($type->id == $selected) ? 'selected' : "" ). '  value="' . $type->id . '">' . $type->name . ' </option>';
        }

        $html .= '</select>';
        return $html;
    }

    public static function selectPhone($id, $name, $class = "", $selected = "")
    {
        $types = TypePhone::all(['id', 'name']);
        $html = '<select  name="' . $name . '" id="' . $id . '" class="' . $class . '">';

        foreach ($types as $type) {
            $html .= '<option ' . (($type->id == $selected) ? 'selected' : "")  . ' value="' . $type->id . '">' . $type->name . ' </option>';
        }

        $html .= '</select>';
        return $html;
    }
}
