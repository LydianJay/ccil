<?php

namespace App\Http\Controllers;

use App\Models\Family;
use Illuminate\Http\Request;

use App\Models\Individual;
use App\Models\Household;
use App\Models\HouseholdHead;
use Illuminate\Support\Facades\DB;
class Census extends Controller
{
    public function index(Request $request) {


        $page   = $request->input('page', 1);
        $limit  = 10; // Number of records per page
        $search = $request->input('search', null);

        

        $data['individuals']    = Individual::join('ip_group', 'ip_group.ip_group_id', '=', 'individual.ip_group_id')
                                ->leftJoin('household_head', 'household_head.individual_id', '=', 'individual.id')
                                ->select('*', DB::raw('TIMESTAMPDIFF(YEAR, dob, CURDATE()) AS age'))
                                ->orderBy('individual.household_id')
                                ->select([
                                    'individual.id',
                                    'individual.dob',
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
                                ]);
        
        if ($search) {
            $data['individuals'] = $data['individuals']->where(function($query) use ($search) {
                $query->where('individual.fname', 'like', '%' . $search . '%')
                      ->orWhere('individual.lname', 'like', '%' . $search . '%')
                      ->orWhere('individual.mname', 'like', '%' . $search . '%');
            });
        }

        $data['individuals']    = $data['individuals']->limit($limit)
                                ->offset(($page - 1) * $limit)
                                ->get();

        $data['ip_groups']          = DB::table('ip_group')->get();
        $data['household_heads']    = DB::table('household_head')
                                    ->join('individual', 'household_head.individual_id', '=', 'individual.id')
                                    ->select('household_head.household_head_id', 'individual.fname', 'individual.lname', 'individual.mname', 'individual.ext')
                                    ->get();


        $data['roles']          = ['wife', 'husband', 'daughter', 'son', 'other'];
        $count                  = $search ? $data['individuals']->count() : Individual::count();
        $data['page_count']     = $count > 0 ? ceil($count / $limit) : 0;
        $data['page']           = $page;

        // dd($data['individuals']->count());
        return view('pages.census.view', $data);
    }
    
    

    public function add_record(Request $request) {

        $data = $request->validate([
            'fname'                 => 'required|string|max:255',
            'mname'                 => 'nullable|string|max:255',
            'lname'                 => 'required|string|max:255',
            'ext'                   => 'nullable|string|max:10',
            'dob'                   => 'required|date',
            'gender'                => 'required',
            'family_role'           => 'required|in:wife,husband,daughter,son,other',
            'ip'                    => 'required|exists:ip_group,ip_group_id',
            'household_head_id'     => 'nullable|exists:household_head,household_head_id',
            'address'               => 'nullable|string|max:255',
        ]);
        $family_id = null;
        if($data['household_head_id']) { 
            // Check if the household head already exists
            $existingHead = DB::table('household_head')
                ->where('household_head_id', $data['household_head_id'])
                ->first();


            

            if (!$existingHead) {
                return redirect()->back()->with('error', 'Invalid Household Head ID');
            }
            
            
            $household_id = Household::where('household_id', $existingHead->household_id)
                ->value('household_id');
    
    
            $family_id = Family::where('household_id', $household_id)
                ->value('family_id');
    
            
    
            $individual_id = Individual::create([
                'household_id'          => $household_id,
                'family_id'             => $family_id,
                'ip_group_id'           => $data['ip'],
                'family_role'           => $data['family_role'],
                'fname'                 => $data['fname'],
                'mname'                 => $data['mname'],
                'lname'                 => $data['lname'],
                'ext'                   => $data['ext'],
                'dob'                   => $data['dob'],
                'gender'                => $data['gender'],
                'address'               => $request->input('address', null),
            ]);
            
    
            
    
            
            
        } 

        else {

            // If household head is not provided, create a new household and family
            $household_id = Household::create([
                'no_members'    => 0,
                'address'       => $request->input('address', null)
            ])->household_id;

            $family_id = Family::create([
                'household_id'  => $household_id,
                'no_members'    => 1,
            ])->family_id; 

            $individual_id = Individual::create([
                'household_id'          => $household_id,
                'family_id'             => $family_id,
                'ip_group_id'           => $data['ip'],
                'family_role'           => $data['family_role'],
                'fname'                 => $data['fname'],
                'mname'                 => $data['mname'],
                'lname'                 => $data['lname'],
                'ext'                   => $data['ext'],
                'dob'                   => $data['dob'],
                'gender'                => $data['gender'],
                'address'               => $request->input('address', null),
            ]);
            // Create household head record
            HouseholdHead::create([
                'household_id'  => $household_id,
                'individual_id' => $individual_id->id,
            ]);

        }




        return redirect()->back()->with('status',['alert' => 'alert-success', 'msg' => 'Added a new record!'] );

    }


    public function id_card(Request $request) {

        $id = $request->input('id', null);
        if (!$id) {
            return redirect()->back()->with('error', 'Invalid ID');
        }

        $data['i'] = Individual::join('ip_group', 'ip_group.ip_group_id', '=', 'individual.ip_group_id')
                                ->leftJoin('household_head', 'household_head.individual_id', '=', 'individual.id')
                                ->select('*', DB::raw('TIMESTAMPDIFF(YEAR, dob, CURDATE()) AS age'))
                                ->where('individual.id', $id)
                                ->first();

        if (!$data['i']) {
            return redirect()->back()->with('error', 'Individual not found');
        }
        return view('pages.census.id_card', $data);

    }



}
