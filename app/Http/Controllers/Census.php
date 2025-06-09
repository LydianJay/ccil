<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Individual;
use Illuminate\Support\Facades\DB;
class Census extends Controller
{
    public function index(Request $request) {

        $data['individuals'] = Individual::join('ip_group', 'ip_group.ip_group_id', '=', 'individual.ip_group_id')
            ->leftJoin('household_head', 'household_head.individual_id', '=', 'individual.id')
            ->select('*', DB::raw('TIMESTAMPDIFF(YEAR, dob, CURDATE()) AS age'))
            ->orderBy('individual.household_id')
            ->select([
                'individual.fname', 
                'individual.lname', 
                'individual.mname', 
                'individual.ext',
                'individual.gender',
                'individual.household_id',
                'individual.family_id',
                'individual.family_role',
                'household_head.household_head_id',
                DB::raw('TIMESTAMPDIFF(YEAR, dob, CURDATE()) AS age'),
                'ip_group.ip_name',
                'individual.address',
            ])
            ->get();


        // dd($data['individuals']);
        return view('pages.census.view', $data);
    }  
}
