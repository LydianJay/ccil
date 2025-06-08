<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class CensusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Insert IP Groups
         $ipGroups = [
            'Non IP',
            'Mamanwa',
            'Bisaya',
        ];

        $ipGroupIds = [];
        foreach ($ipGroups as $ip) {
            $id = DB::table('ip_group')->insertGetId([
                'ip_name' => $ip
            ]);
            $ipGroupIds[$ip] = $id;
        }

        // Insert Households and Families
        $households     = [];
        $families       = [];
        for ($i = 1; $i <= 5; $i++) {
            $households[$i] = DB::table('household')->insertGetId([
                'no_members'    => 0, // will be updated later
                'address'       => 'Sitio Silop, Urbiztondo, Claver, SDN'
            ]);

            $families[$i] = DB::table('family')->insertGetId([
                'household_id'  => $households[$i],
                'no_members'    => 0
            ]);
        }

        // Individuals data
        $individuals = [
            [1, 1, 'Mamanwa', 'husband', 'Lito', 'Kabongkabong', 'Ambongan', null, 'male', '1997-10-01'],
            [1, 1, 'Non IP', 'wife', 'Jocelyn', 'Dogmoc', 'Bentulan', null, 'female', '1974-03-13'],
            [1, 1, 'Mamanwa', 'son', 'Josh Lito', 'Bentulan', 'Ambongan', null, 'male', '2012-05-26'],
            [1, 1, 'Mamanwa', 'son', 'Lito Jr.', 'Bentulan', 'Ambongan', null, 'male', '2019-08-18'],

            [2, 2, 'Mamanwa', 'wife', 'Merlina', 'Hurod', 'Antawan', null, 'female', '2000-06-25'],
            [2, 2, 'Mamanwa', 'husband', 'Edgar Boboy', null, 'Antawan', null, 'male', '1996-10-18'],
            [2, 2, 'Mamanwa', 'son', 'Rex', 'Hurod', 'Antawan', null, 'male', '2017-09-13'],
            [2, 2, 'Mamanwa', 'son', 'Johnrex', 'Hurod', 'Antawan', null, 'male', '2019-07-11'],

            [3, 3, 'Mamanwa', 'husband', 'Cris Jerome', '(Saldy) Prada', 'Badjang', null, 'male', '2003-12-10'],
            [3, 3, 'Mamanwa', 'wife', 'Jea', 'Corob', 'Ambongan', null, 'female', '2005-09-07'],

            [4, 4, 'Mamanwa', 'husband', 'Danjev', 'Calinawan', 'Bago', null, 'male', '2000-08-23'],
            [4, 4, 'Mamanwa', 'wife', 'Jovelyn', 'Delamente', 'Bago', null, 'female', '2001-05-07'],
            [4, 4, 'Mamanwa', 'daughter', 'Danlyn', 'Delamente', 'Bago', null, 'female', '2019-10-10'],

            [5, 5, 'Mamanwa', 'husband', 'Delfin', 'Calinawan', 'Bago', null, 'male', '2004-06-23'],
            [5, 5, 'Mamanwa', 'wife', 'Cristine', 'Sandag', 'Day-om', null, 'female', '2006-07-20'],
            [5, 5, 'Mamanwa', 'son', 'Zihan Carl', null, 'Bago', null, 'male', '2024-01-23'],
        ];

        $householdHeads = [];

        foreach ($individuals as $index => $ind) {
            [$hh, $fam, $ip, $role, $fname, $mname, $lname, $ext, $gender, $dob] = $ind;

            $id = DB::table('individual')->insertGetId([
                'household_id' => $households[$hh],
                'family_id' => $families[$fam],
                'ip_group_id' => $ipGroupIds[$ip],
                'family_role' => $role,
                'fname' => $fname,
                'mname' => $mname,
                'lname' => $lname,
                'ext' => $ext,
                'dob' => $dob,
                'gender' => $gender,
                'address' => 'Sitio Silop, Urbiztondo, Claver, SDN',
            ]);

            // Assign household head if role is husband
            if ($role === 'husband' && !isset($householdHeads[$hh])) {
                DB::table('household_head')->insert([
                    'household_id' => $households[$hh],
                    'individual_id' => $id
                ]);
                $householdHeads[$hh] = $id;
            }

            // Update member counts
            DB::table('household')->where('household_id', $households[$hh])->increment('no_members');
            DB::table('family')->where('family_id', $families[$fam])->increment('no_members');
        }
    }
}
