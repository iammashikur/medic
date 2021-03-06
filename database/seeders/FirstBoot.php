<?php

namespace Database\Seeders;

use App\Models\AppointmentStatus;
use App\Models\DoctorSpecialization;
use App\Models\Gender;
use App\Models\PatientTestStatus;
use App\Models\TransactionType;
use App\Models\User;
use Illuminate\Database\Seeder;

class FirstBoot extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Admin
        User::insert([
            'name' => 'Super Admin',
            'email' => 'admin@admin.com',
            'hospital_id' => 1,
            'is_admin' => 1,
            'password' => bcrypt('password'),
        ]);

        // Gengers
        Gender::insert(
            [
                ['id' => 1, 'gender' => 'Male'],
                ['id' => 2, 'gender' => 'Female'],
                ['id' => 3, 'gender' => 'Other']
            ]
        );

        // Specialization of doctors
        DoctorSpecialization::insert(
            [
                ['id' => 1, 'hospital_id' => 1, 'specialization' => 'General practitioner'],
                ['id' => 2, 'hospital_id' => 1, 'specialization' => 'OB/GYN – obstetrician and gynaecologist'],
                ['id' => 3, 'hospital_id' => 1, 'specialization' => 'Psychiatrist'],
                ['id' => 4, 'hospital_id' => 1, 'specialization' => 'Dentist'],
                ['id' => 5, 'hospital_id' => 1, 'specialization' => 'General surgeon'],
                ['id' => 6, 'hospital_id' => 1, 'specialization' => 'Dermatologist']
            ]
        );

        // Appointment Statuses
        AppointmentStatus::insert(
            [
                ['id' => 1, 'status' => 'pending'],
                ['id' => 2, 'status' => 'confirmed'],
                ['id' => 3, 'status' => 'denied'],
                ['id' => 4, 'status' => 'cancelled'],
                ['id' => 5, 'status' => 'completed']
            ]
        );

        // Appointment Statuses
        PatientTestStatus::insert(
            [
                ['id' => 1, 'status' => 'pending'],
                ['id' => 2, 'status' => 'completed'],
                ['id' => 3, 'status' => 'cancelled'],
            ]
        );


        TransactionType::insert(
            [
                ['id' => 1, 'operator' => '+', 'type' => 'appointment'],
                ['id' => 2, 'operator' => '+', 'type' => 'test'],
                ['id' => 3, 'operator' => '-', 'type' => 'refund'],
            ]
        );

    }
}
