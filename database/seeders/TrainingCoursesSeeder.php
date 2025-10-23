<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // ✅ Add this line

class TrainingCoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            "3G WELDER",
            "4G WELDER",
            "6G ARC WELDER",
            "6G WELDER",
            "ADVANCED FIRE FIGHTER",
            "ADVANCED FIRE FIGHTING",
            "ARC WELDER",
            "AUTHORIZED GAS TESTER",
            "BAR BENDING MACHINE OPERATOR",
            "BASIC FIRE FIGHTING",
            "BASIC FIRE WATCHER",
            "BASIC FIRST AIDER",
            "BLOCK CUTTING OPERATOR",
            "BOB CAT OPERATOR",
            "BOOMLIFT OPERATOR",
            "BRICK CRANE OPERATOR",
            "CHEMICAL HANDLING",
            "CHEMICAL HANDLING SAFETY AWARENESS",
            "COMPRESSED GAS SAFETY AWARENESS TRAINING",
            "CONCRETE MACHINE OPERATOR",
            "CONCRETE PUMP OPERATOR",
            "CONFINED SPACE ENTRY",
            "CONFINED SPACE RESCUE",
            "COPPER BRAZING /WELDER",
            "CRADLE OPERATOR",
            "CRANE OPERATOR",
            "CRAWLER CRANE OPERATOR",
            "DEFENSIVE DRIVING AWARENESS",
            "Defensive Driving Awareness (SKID STEER LOADER)",
            "DRILLING RIG MACHINE OPERATOR",
            "EXCAVATOR OPERATOR",
            "FIRE FIGHTER",
            "FIRE WARDEN",
            "FIRE WATCHER",
            "FIRST AIDER",
            "FLAGMAN",
            "FORKLIFT OPERATOR",
            "FOOD SAFETY AWARENESS",
            "GAS CUTTING & WELDING SAFETY",
            "GRINDING MACHINE OPERATOR",
            "HAIB CRANE OPERATOR",
            "HDPE (Pipe Welding Machine Operator)",
            "HIGH VOLTAGE OPERATOR",
            "HOLE WATCHER",
            "LIFITING SUPERVISIOR",
            "LIFE GUARD",
            "LOADER CRANE OPERATOR",
            "LORRY CRANE OPERATOR",
            "MANLIFT & SCISSOR LIFT OPERATOR",
            "MIG WELDER",
            "MOBILE CRANE OPERATOR",
            "MOBILE ELEVATING WORK PLATFORM",
            "NOZZLEMAN",
            "OVER HEAD CRANE OPERATOR",
            "PAT SAFETY",
            "PORTABLE APPLIANCE TESTER",
            "POWER TOOLS SAFETY",
            "POWER TOOLS SAFETY AWARENESS",
            "RIGGER",
            "RIGGING SUPERVISOR",
            "ROAD ROLLER COMPACTOR",
            "SAFE MOBILE CRANE OPERATOR",
            "Safe Use of Building Maintenance Unit (BMU)",
            "Safety In Mobile Elevated Work Platform (MEWP)",
            "SCAFFOLDER",
            "SCAFFOLDING ERECTION & DISMANTLING",
            "SCAFFOLDING INSPECTOR",
            "SCISSOR LIFT OPERATOR",
            "SHOVEL OPERATOR",
            "SKID STEER LOADER OPERATOR",
            "STEEL ROLLER OPERATOR",
            "THREADING & GROOVING MACHINE OPERATOR",
            "TOWER CRANE OPERATOR",
            "WATER TANKER OPERATOR",
            "WATERBARS WELDING TEST",
            "WELDER",
            "WHEEL LOADER OPERATOR",
            "WINDOW CRADLE OPERATOR",
            "WORK AT HEIGHT",
        ];

        foreach ($courses as $course) {
            if (!DB::table('training_courses')->where('name', $course)->exists()) {
                DB::table('training_courses')->insert([
                    'name' => $course,
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
