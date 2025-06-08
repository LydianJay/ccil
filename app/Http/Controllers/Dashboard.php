<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Individual;

class Dashboard extends Controller
{
    

    public function index(Request $request) {
        $data['individuals'] = Individual::join('ip_group', 'ip_group.ip_group_id', '=', 'individual.ip_group_id')
            ->leftJoin('household_head', 'household_head.individual_id', '=', 'individual.id')
            ->select('*', DB::raw('TIMESTAMPDIFF(YEAR, dob, CURDATE()) AS age'))
            ->orderBy('id')
            ->get();
    
        // Existing groupings
        $ageGroups = $data['individuals']->groupBy(function ($person) {
            $age = $person->age;
            if ($age <= 4) return 'Babies (0-4)';
            elseif ($age <= 17) return 'Minors (5-17)';
            return 'Adults (18+)';
        });
        
        $data['ageGroupData'] = [
            'Babies (0-4)' => $ageGroups->get('Babies (0-4)', collect())->count(),
            'Minors (5-17)' => $ageGroups->get('Minors (5-17)', collect())->count(),
            'Adults (18+)' => $ageGroups->get('Adults (18+)', collect())->count(),
        ];
    
        $data['ipGroupData'] = $data['individuals']
            ->groupBy('ip_name')
            ->map(fn($group) => $group->count())
            ->toArray();
    
        $data['ageFrequency'] = $data['individuals']
            ->groupBy('age')
            ->map(fn($group) => $group->count())
            ->sortKeys()
            ->toArray();
    
        // NEW: Custom Age + Gender Groups for Pie Chart
        $ageGenderGroups = [
            'Minor Male 5-12 YO Elementary' => 0,
            'Minor Female 5-12 YO Elementary' => 0,
            'Minor Male/Female 13-19 YO High School' => 0,
            'Adult Male/Female 20-25 YO College' => 0,
            'Adult Male 26-59 YO' => 0,
            'Adult Female 26-59 YO' => 0,
            'Adult Male/Female 60 YO & Above' => 0,
        ];
    
        foreach ($data['individuals'] as $person) {
            $age = $person->age;
            $gender = strtolower($person->gender); // assuming 'Male' or 'Female'
    
            if ($age >= 5 && $age <= 12) {
                if ($gender == 'male') {
                    $ageGenderGroups['Minor Male 5-12 YO Elementary']++;
                } elseif ($gender == 'female') {
                    $ageGenderGroups['Minor Female 5-12 YO Elementary']++;
                }
            } elseif ($age >= 13 && $age <= 19) {
                $ageGenderGroups['Minor Male/Female 13-19 YO High School']++;
            } elseif ($age >= 20 && $age <= 25) {
                $ageGenderGroups['Adult Male/Female 20-25 YO College']++;
            } elseif ($age >= 26 && $age <= 59) {
                if ($gender == 'male') {
                    $ageGenderGroups['Adult Male 26-59 YO']++;
                } elseif ($gender == 'female') {
                    $ageGenderGroups['Adult Female 26-59 YO']++;
                }
            } elseif ($age >= 60) {
                $ageGenderGroups['Adult Male/Female 60 YO & Above']++;
            }
        }
    
        $data['ageGenderGroups'] = $ageGenderGroups;
    
        return view('pages.dashboard.view', $data);
    }
    
}
