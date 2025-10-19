<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Member;
use App\Enums\MemberEnums\Gender;
use App\Enums\MemberEnums\Status;
use App\Enums\MemberEnums\ChurchRole;
use App\Enums\MemberEnums\HillsJourney;
use App\Enums\MemberEnums\Ministry;
use App\Enums\MemberEnums\MinistryRole;
use Carbon\Carbon;

class MemberSeeder extends Seeder
{
    public function run()
    {
        // Clear existing members
        Member::truncate();

        // 1. HEAD PASTOR - Top of hierarchy
        $headPastor = Member::create([
            'first_name' => 'Genesis',
            'middle_name' => 'Michael',
            'last_name' => 'Macapagal',
            'age' => 40,
            'gender' => Gender::MALE->value,
            'birth_date' => Carbon::create(1985, 9, 15),
            'address' => '123 Church Street, Hills City',
            'contact' => '09171234567',
            'status' => Status::PROFESSIONAL->value,
            'invitedBy' => null,
            'church_role' => ChurchRole::HEAD_PASTOR->value,
            'hills_journey' => HillsJourney::GRADUATE->value,
            'ministry' => Ministry::MUSIC_AND_ARTS->value,
            'ministry_role' => MinistryRole::LEADER->value,
            'ministry_assignment' => 'Pastor',
            'network_leader_id' => null, // Head Pastor has no network leader
            'life_guide_id' => null, // Head Pastor has no life guide
            'isActive' => true,
        ]);

        // 2. PASTOR - Reports to Head Pastor
        $pastor = Member::create([
            'first_name' => 'Mabel',
            'middle_name' => 'Jane',
            'last_name' => 'Macapagal',
            'age' => 38,
            'gender' => Gender::FEMALE->value,
            'birth_date' => Carbon::create(1985, 8, 22),
            'address' => '456 Faith Avenue, Hills City',
            'contact' => '09172345678',
            'status' => Status::PROFESSIONAL->value,
            'invitedBy' => 'John Smith',
            'church_role' => ChurchRole::PASTOR->value,
            'hills_journey' => HillsJourney::GRADUATE->value,
            'ministry' => Ministry::MUSIC_AND_ARTS->value,
            'ministry_role' => MinistryRole::LEADER->value,
            'ministry_assignment' => 'Pastor',
            'network_leader_id' => $headPastor->id, // Pastor reports to Head Pastor
            'life_guide_id' => $headPastor->id,
            'isActive' => true,
        ]);

        // 3. CORE LEADER - Reports to Head Pastor
        $coreLeader = Member::create([
            'first_name' => 'Joriel Brian',
            'middle_name' => 'Santos',
            'last_name' => 'Sudario',
            'age' => 26,
            'gender' => Gender::MALE->value,
            'birth_date' => Carbon::create(1999, 9, 29),
            'address' => '789 Hope Road, Hills City',
            'contact' => '09173456789',
            'status' => Status::YOUNG_PROFESSIONAL->value,
            'invitedBy' => 'Sarah Johnson',
            'church_role' => ChurchRole::CORE_LEADER->value,
            'hills_journey' => HillsJourney::GRADUATE->value,
            'ministry' => Ministry::MUSIC_AND_ARTS->value,
            'ministry_role' => MinistryRole::MEMBER->value,
            'ministry_assignment' => 'Lead Guitarist',
            'network_leader_id' => $headPastor->id,
            'life_guide_id' => $headPastor->id,
            'isActive' => true,
        ]);

        // 4. LIFE GUIDE - Reports to Core Leader, Guided by Core Leader
        $lifeGuide = Member::create([
            'first_name' => 'Hazael',
            'middle_name' => 'Clara',
            'last_name' => 'Dumalaon',
            'age' => 19,
            'gender' => Gender::MALE->value,
            'birth_date' => Carbon::create(1995, 11, 5),
            'address' => '321 Love Lane, Hills City',
            'contact' => '09174567890',
            'status' => Status::STUDENT->value,
            'invitedBy' => 'Michael Brown',
            'church_role' => ChurchRole::LIFE_GUIDE->value,
            'hills_journey' => HillsJourney::GRADUATE->value,
            'ministry' => Ministry::HOSPITALITY->value,
            'ministry_role' => MinistryRole::MEMBER->value,
            'ministry_assignment' => 'Entrance',
            'network_leader_id' => $coreLeader->id, // Life Guide reports to Core Leader
            'life_guide_id' => $coreLeader->id, // Life Guide is guided by Core Leader
            'isActive' => true,
        ]);

        // 5. MEMBER - Reports to Core Leader, Guided by Life Guide
        $member = Member::create([
            'first_name' => 'Ashley',
            'middle_name' => 'James',
            'last_name' => 'Basilio',
            'age' => 18,
            'gender' => Gender::MALE->value,
            'birth_date' => Carbon::create(1998, 7, 30),
            'address' => '654 Grace Street, Hills City',
            'contact' => '09175678901',
            'status' => Status::STUDENT->value,
            'invitedBy' => 'Maria Garcia',
            'church_role' => ChurchRole::MEMBER->value,
            'hills_journey' => HillsJourney::START_UP_SESSION->value,
            'ministry' => Ministry::HILLS_KIDS->value,
            'ministry_role' => MinistryRole::MEMBER->value,
            'ministry_assignment' => 'Teacher',
            'network_leader_id' => $coreLeader->id, // Member reports to Core Leader
            'life_guide_id' => $lifeGuide->id, // Member is guided by Life Guide
            'isActive' => true,
        ]);
    }
}
