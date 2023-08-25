<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DropdownController extends Controller
{
    public function view()
    {
        $makes = DB::table('car_make')
            ->get();

        return view('home', compact('makes'));
    }

    public function getModels(Request $request)
    {
        $models = DB::table('car_model')
            ->where('id_car_make', $request->id_car_make)
            ->get();

        if (count($models) > 0) {
            return response()->json($models);
        }
    }

    public function getGenerations(Request $request)
    {
        $generations = DB::table('car_generation')
            ->where('id_car_model', $request->id_car_model)
            ->get();

        if (count($generations) > 0) {
            return response()->json($generations);
        }
    }

    public function getSeries(Request $request)
    {
        $series = DB::table('car_serie')
            ->where('id_car_generation', $request->id_car_generation)
            ->get();

        if (count($series) > 0) {
            return response()->json($series);
        }
    }

    public function getTrims(Request $request)
    {
        $trims = DB::table('car_trim')
            ->where('id_car_serie', $request->id_car_serie)
            ->get();

        if (count($trims) > 0) {
            return response()->json($trims);
        }
    }

    /*
    public function getEquipment(Request $request)
    {
        $equipment = DB::table('car_equipment')
            ->where('id_car_trim', $request->id_car_trim)
            ->get();

        if (count($equipment) > 0) {
            return response()->json($equipment);
        }
    }
    */

    /*
        Get all car specifications and categories.
    */
    public function getSpecs(Request $request)
    {
        // Query car_specification_value for car trims to get all vals and units for spec
        $spec_vals = DB::table('car_specification_value')
            ->where('id_car_trim', $request->id_car_trim)
            ->get();

        $result = [];

        if (count($spec_vals) > 0) {
            // For each spec, get the name from car_specification
            foreach ($spec_vals as $spec) {
                $val = $spec->value;
                $unit = $spec->unit;

                // Query the car_specification table for the name
                $specification = DB::table('car_specification')
                    ->where('id_car_specification', $spec->id_car_specification)
                    ->first();

                if ($specification) {
                    $name = $specification->name;
                    $specArr = [
                        'name' => $name,
                        'parent_id' => $specification->id_parent, //parent id to be used to find category
                        'value' => ($val ? $val : ''),
                        'unit' => ($unit ? $unit : ''),
                        'isTitle' => false
                    ];
                    $result[] = $specArr;
                }
            }
        }

        // Get parent categories from car_specification
        $spec_categories = DB::table('car_specification')
            ->where('id_parent', null)
            ->get();

        // For each category, get the name and add to result
        foreach ($spec_categories as $cat) {
            $catArr = [
                'name' => $cat->name,
                'id' => $cat->id_car_specification, //category id
                'isTitle' => true
            ];
            $result[] = $catArr;
        }

        return $result;
    }
}
