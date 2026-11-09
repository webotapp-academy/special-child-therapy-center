<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Enquiry;
use App\Models\DiagnosticAssessment;
use App\Models\Student;
use App\Models\IepGoal;
use App\Models\IepMilestone;
use App\Models\TherapySession;
use App\Models\DailyCareLog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Staff & Admin Users
        $admin = User::create([
            'name' => 'Admin Director',
            'email' => 'admin@specialcare.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '+91 98765 43210',
            'specialization' => 'School Administration & SEN Management',
        ]);

        $psychologist = User::create([
            'name' => 'Dr. Priya Sharma',
            'email' => 'priya@specialcare.com',
            'password' => Hash::make('password'),
            'role' => 'therapist',
            'phone' => '+91 98765 11111',
            'specialization' => 'Clinical Child Psychologist & Diagnostic Specialist',
        ]);

        $educator = User::create([
            'name' => 'Ananya Roy',
            'email' => 'ananya@specialcare.com',
            'password' => Hash::make('password'),
            'role' => 'educator',
            'phone' => '+91 98765 22222',
            'specialization' => 'Lead Special Educator (Early Intervention)',
        ]);

        $speechTherapist = User::create([
            'name' => 'Vikram Sen',
            'email' => 'vikram@specialcare.com',
            'password' => Hash::make('password'),
            'role' => 'therapist',
            'phone' => '+91 98765 33333',
            'specialization' => 'Speech & Language Pathologist',
        ]);

        $otTherapist = User::create([
            'name' => 'Neha Patel',
            'email' => 'neha@specialcare.com',
            'password' => Hash::make('password'),
            'role' => 'therapist',
            'phone' => '+91 98765 44444',
            'specialization' => 'Occupational & Sensory Integration Therapist',
        ]);

        // Parent User
        $parent = User::create([
            'name' => 'Rajesh Gupta',
            'email' => 'parent@specialcare.com',
            'password' => Hash::make('password'),
            'role' => 'parent',
            'phone' => '+91 98111 22334',
            'specialization' => null,
        ]);

        // 2. Create Enquiries
        // Enquiry 1: Admitted student (Aarav)
        $enq1 = Enquiry::create([
            'enquiry_no' => 'ENQ-2026-001',
            'child_name' => 'Aarav Gupta',
            'dob' => Carbon::now()->subYears(5)->subMonths(3),
            'gender' => 'Male',
            'parent_name' => 'Rajesh & Pooja Gupta',
            'relation' => 'Father',
            'phone' => '+91 98111 22334',
            'email' => 'parent@specialcare.com',
            'address' => 'Flat 402, Sunshine Heights, Mumbai',
            'referred_by' => 'Dr. Kulkarni (Pediatrician)',
            'primary_concerns' => ['Speech Delay', 'No Eye Contact', 'Repetitive Hand Flapping', 'Sensory Meltdowns in Malls'],
            'notes' => 'Child responds minimally to name call. Uses mother\'s hand as a tool. Does not eat solid/crunchy textures.',
            'status' => 'admitted',
            'assessment_scheduled_at' => Carbon::now()->subMonths(2),
            'handled_by' => $admin->id,
        ]);

        // Enquiry 2: Assessment Scheduled (Vivaan)
        Enquiry::create([
            'enquiry_no' => 'ENQ-2026-002',
            'child_name' => 'Vivaan Mehra',
            'dob' => Carbon::now()->subYears(4)->subMonths(8),
            'gender' => 'Male',
            'parent_name' => 'Kavita Mehra',
            'relation' => 'Mother',
            'phone' => '+91 98222 33445',
            'email' => 'kavita.mehra@gmail.com',
            'address' => '12 Rosewood Villas, Mumbai',
            'referred_by' => 'Play School Principal',
            'primary_concerns' => ['Hyperactivity', 'Auditory Sensitivity', 'Aggression when routine changes'],
            'notes' => 'Covers ears whenever mixer or bell rings. Extremely energetic, difficulty sitting still for more than 2 minutes.',
            'status' => 'assessment_scheduled',
            'assessment_scheduled_at' => Carbon::now()->addDays(2)->setHour(11)->setMinute(0),
            'handled_by' => $admin->id,
        ]);

        // Enquiry 3: Assessed, ready for admission (Maya)
        $enq3 = Enquiry::create([
            'enquiry_no' => 'ENQ-2026-003',
            'child_name' => 'Maya Nair',
            'dob' => Carbon::now()->subYears(6)->subMonths(1),
            'gender' => 'Female',
            'parent_name' => 'Deepak Nair',
            'relation' => 'Father',
            'phone' => '+91 98333 44556',
            'email' => 'deepak.nair@example.com',
            'address' => 'B-301 Palm Grove, Mumbai',
            'referred_by' => 'Self / Online Search',
            'primary_concerns' => ['Non-Verbal Communication', 'Toe Walking', 'Sensory Seeking'],
            'notes' => 'Likes spinning wheels and watching fans. Excellent visual memory but zero verbal functional speech.',
            'status' => 'assessed',
            'assessment_scheduled_at' => Carbon::now()->subDays(3),
            'handled_by' => $admin->id,
        ]);

        // 3. Diagnostic Assessments
        // Diagnostic 1: For Aarav
        $diag1 = DiagnosticAssessment::create([
            'assessment_no' => 'DIAG-2026-001',
            'enquiry_id' => $enq1->id,
            'child_name' => 'Aarav Gupta',
            'dob' => $enq1->dob,
            'gender' => 'Male',
            'assessment_date' => Carbon::now()->subMonths(2),
            'assessor_id' => $psychologist->id,
            'assessor_name' => 'Dr. Priya Sharma',
            'cars_score' => 34.5,
            'cars_severity' => 'Mild-to-Moderate Autism',
            'isaa_score' => 88.0,
            'primary_diagnosis' => 'Autism Spectrum Disorder (ASD)',
            'severity_level' => 'Level 2 (Requiring Substantial Support)',
            'speech_evaluation' => 'Receptive language ~18 months; Expressive language ~14 months. Uses isolated single sounds. No spontaneous sentences.',
            'motor_evaluation' => 'Mild hypotonia, fair gross motor skills, difficulty with pincer grasp and buttoning.',
            'sensory_profile' => [
                'auditory' => 'Hypersensitive (avoids blenders, drills, loud speakers)',
                'tactile' => 'Aversive to squishy/sticky textures (clay, slime)',
                'vestibular' => 'Seeks linear swinging, calms when rocked',
                'proprioceptive' => 'Responds well to deep pressure and joint compressions',
            ],
            'behavioral_observations' => 'Poor eye contact (less than 2 secs), occasional hand flapping when excited, lines up toy cars.',
            'recommendation' => 'Admit to Early Intervention Special Day Class. Prescribe Speech Therapy 3x/week and Occupational Sensory Therapy 3x/week.',
            'status' => 'admitted',
        ]);

        // Diagnostic 2: For Maya
        DiagnosticAssessment::create([
            'assessment_no' => 'DIAG-2026-002',
            'enquiry_id' => $enq3->id,
            'child_name' => 'Maya Nair',
            'dob' => $enq3->dob,
            'gender' => 'Female',
            'assessment_date' => Carbon::now()->subDays(2),
            'assessor_id' => $psychologist->id,
            'assessor_name' => 'Dr. Priya Sharma',
            'cars_score' => 37.0,
            'cars_severity' => 'Severe Autism',
            'isaa_score' => 96.5,
            'primary_diagnosis' => 'Autism Spectrum Disorder (ASD) Non-Verbal',
            'severity_level' => 'Level 2-3',
            'speech_evaluation' => 'Completely non-verbal. Strong candidate for PECS Phase 1-2 and AAC Tablet introduction.',
            'motor_evaluation' => 'Persistent toe walking, poor balance beam performance, requires vestibular regulation.',
            'sensory_profile' => [
                'auditory' => 'Under-responsive (doesn\'t orient to sudden noises)',
                'visual' => 'Fixates on repetitive lights and fans',
                'tactile' => 'Enjoys deep pressure massage',
                'vestibular' => 'Hypo-responsive, loves spinning and bouncing',
            ],
            'behavioral_observations' => 'High energy, repetitive visual stimming, minimal shared attention.',
            'recommendation' => 'Admission recommended for Junior Bloomers Class with dedicated Shadow Aide support. Start PECS immediately.',
            'status' => 'completed',
        ]);

        // 4. Enrolled Student: Aarav Gupta
        $student = Student::create([
            'admission_no' => 'SC-2026-001',
            'enquiry_id' => $enq1->id,
            'diagnostic_assessment_id' => $diag1->id,
            'parent_user_id' => $parent->id,
            'first_name' => 'Aarav',
            'last_name' => 'Gupta',
            'dob' => $enq1->dob,
            'gender' => 'Male',
            'blood_group' => 'B+',
            'admission_date' => Carbon::now()->subMonths(1)->subDays(15),
            'classroom_batch' => 'Early Intervention - Batch Lotus',
            'primary_educator_id' => $educator->id,
            'shadow_teacher' => 'Sunita Verma (Caregiver Aide)',
            'primary_diagnosis' => 'Autism Spectrum Disorder (ASD)',
            'severity_level' => 'Level 2',
            'communication_mode' => 'PECS & Emerging 2-Word Phrases',
            'sensory_triggers' => 'Sudden loud claps/bells, scratchy clothing tags, bright fluorescent flicker.',
            'calming_methods' => 'Weighted green dino vest, 3-minute linear hammock swing, deep squeeze hug, bubble blowing.',
            'comfort_item' => 'Blue textured sensory teether ring & dinosaur plush',
            'food_texture_preferences' => 'Prefers crispy snacks (dosa, crackers). Rejects mixed gravies/slime foods.',
            'allergies' => 'Mild lactose intolerance (almond/soy milk preferred)',
            'medical_notes' => 'No seizures reported. Regular multivitamin supplement.',
            'guardian_name' => 'Rajesh Gupta',
            'guardian_relation' => 'Father',
            'guardian_phone' => '+91 98111 22334',
            'guardian_email' => 'parent@specialcare.com',
            'address' => 'Flat 402, Sunshine Heights, Andheri West, Mumbai',
            'emergency_contact_phone' => '+91 98111 22335 (Mother: Pooja)',
            'status' => 'active',
        ]);

        // 5. IEP Goals for Aarav
        $goal1 = IepGoal::create([
            'student_id' => $student->id,
            'domain' => 'Speech & Communication',
            'title' => 'Functional Requesting using PECS & 2-Word approximations',
            'description' => 'Aarav will exchange picture cards (PECS Phase 3) to request preferred snacks and items ("Want Water", "Want Car") with 80% accuracy over 3 consecutive weeks.',
            'baseline' => 'Was pulling teacher\'s hand without vocalization or visual cue.',
            'target_date' => Carbon::now()->addMonths(2),
            'progress_percentage' => 70,
            'status' => 'in_progress',
            'evaluator_notes' => 'Aarav now independently discriminates between "Juice" and "Biscuit" cards on the communication board!',
        ]);

        IepMilestone::create(['iep_goal_id' => $goal1->id, 'milestone_title' => 'Phase 1: Physical exchange of single card to trainer', 'is_completed' => true, 'completed_at' => Carbon::now()->subWeeks(3)]);
        IepMilestone::create(['iep_goal_id' => $goal1->id, 'milestone_title' => 'Phase 2: Traveling distance to communication book', 'is_completed' => true, 'completed_at' => Carbon::now()->subWeek()]);
        IepMilestone::create(['iep_goal_id' => $goal1->id, 'milestone_title' => 'Phase 3: Picture discrimination between preferred and non-preferred item', 'is_completed' => false]);
        IepMilestone::create(['iep_goal_id' => $goal1->id, 'milestone_title' => 'Phase 4: Sentence strip ("I Want...")', 'is_completed' => false]);

        $goal2 = IepGoal::create([
            'student_id' => $student->id,
            'domain' => 'Occupational & Sensory',
            'title' => 'Sensory Modulation & Fine Motor Pincer Grasp',
            'description' => 'Tolerate 5 minutes of sensory tactile table (finger paint / therapy putty) without distress and pick up 10 small beads using thumb-index pincer grasp.',
            'baseline' => 'Refused any contact with sticky textures; displayed defensive withdrawal.',
            'target_date' => Carbon::now()->addMonths(3),
            'progress_percentage' => 85,
            'status' => 'in_progress',
            'evaluator_notes' => 'Great breakthrough: Aarav played with dry lentils and medium therapy putty for 6 minutes today without needing calming tools!',
        ]);

        $goal3 = IepGoal::create([
            'student_id' => $student->id,
            'domain' => 'Social & Play Skills',
            'title' => 'Parallel Play and 3-Turn Ball Rolling with Peer',
            'description' => 'Aarav will participate in rolling a ball back and forth with a classmate for 3 consecutive turns with verbal/visual prompting.',
            'baseline' => 'Isolated play only; walked away when peers approached.',
            'target_date' => Carbon::now()->addMonths(1),
            'progress_percentage' => 50,
            'status' => 'in_progress',
            'evaluator_notes' => 'Rolls ball twice before losing focus; responds well when music cue is played.',
        ]);

        $goal4 = IepGoal::create([
            'student_id' => $student->id,
            'domain' => 'Life Skills (ADL)',
            'title' => 'Independent Handwashing Routine with Visual Schedule',
            'description' => 'Complete the 5-step hand washing sequence (Turn tap, Wet hands, Soap, Scrub, Dry) using visual strip with maximum 1 prompt.',
            'baseline' => 'Needed full physical assistance (hand-over-hand) at every step.',
            'target_date' => Carbon::now()->addMonths(1),
            'progress_percentage' => 90,
            'status' => 'in_progress',
            'evaluator_notes' => 'Mastered turning tap, soaping, and towel drying. Only requires minor prompt for rinsing soap bubbles thoroughly.',
        ]);

        // 6. Therapy Sessions
        TherapySession::create([
            'student_id' => $student->id,
            'therapist_id' => $speechTherapist->id,
            'therapist_name' => 'Vikram Sen',
            'therapy_type' => 'Speech Therapy',
            'session_date' => Carbon::now()->subDays(1),
            'duration_minutes' => 45,
            'activities_performed' => 'Oral motor blowing bubbles, PECS discrimination game, syllable imitation (/ba/, /ma/, /pa/).',
            'engagement_level' => 'Excellent',
            'clinical_soap_notes' => 'S: Child arrived smiling and eager. O: Successfully pointed to requested picture 8/10 times. Vocalized /pa/ for balloon. A: Significant improvement in vocal imitation. P: Continue Phase 3 PECS with real objects next session.',
            'parent_summary' => 'Aarav did wonderfully today! He used the "Ball" picture card twice independently and happily imitated "Ba-Ba" while playing with bubbles.',
        ]);

        TherapySession::create([
            'student_id' => $student->id,
            'therapist_id' => $otTherapist->id,
            'therapist_name' => 'Neha Patel',
            'therapy_type' => 'Occupational Therapy',
            'session_date' => Carbon::now()->subDays(2),
            'duration_minutes' => 45,
            'activities_performed' => 'Suspended platform swing, obstacle balance beam crawl, textured dough bead retrieval, weighted blanket calming.',
            'engagement_level' => 'Good',
            'clinical_soap_notes' => 'S: Arrived slightly overwhelmed after transit. O: 10 mins linear swinging organized his nervous system. Pincer grasp exercise: 8/10 success. A: Sensory threshold stabilized quickly. P: Progress to firmer putty.',
            'parent_summary' => 'Aarav loved the sensory swing today! He retrieved 8 hidden marbles from the therapy putty with great finger strength.',
        ]);

        // 7. Daily Care Logs
        DailyCareLog::create([
            'student_id' => $student->id,
            'log_date' => Carbon::now()->subDays(1),
            'morning_mood' => 'Calm',
            'afternoon_mood' => 'Happy',
            'meal_intake' => 'Full Meal',
            'meal_notes' => 'Ate his whole paratha and sliced cucumber without resistance. Drank 250ml water.',
            'potty_training_log' => 'Routine Success',
            'nap_minutes' => 40,
            'meltdown_count' => 0,
            'meltdown_triggers' => null,
            'teacher_notes_for_parent' => 'Aarav had a peaceful and productive day! Enjoyed circle time music and clapped along with the group.',
            'logged_by_id' => $educator->id,
        ]);

        DailyCareLog::create([
            'student_id' => $student->id,
            'log_date' => Carbon::now()->subDays(2),
            'morning_mood' => 'Anxious',
            'afternoon_mood' => 'Calm',
            'meal_intake' => 'Half Eaten',
            'meal_notes' => 'Ate roasted snack, hesitated with fruit cup due to wet texture.',
            'potty_training_log' => 'Prompted Success',
            'nap_minutes' => 30,
            'meltdown_count' => 1,
            'meltdown_triggers' => 'Loud school bell during transit',
            'teacher_notes_for_parent' => 'Had a 3-minute distress when bell rang; caregiver gave him the weighted dinosaur vest and he settled down smoothly.',
            'logged_by_id' => $educator->id,
        ]);

        // 8. Behavioral Incident (ABC Log)
        \App\Models\BehavioralIncident::create([
            'student_id' => $student->id,
            'incident_date' => Carbon::now()->subDays(2),
            'incident_time' => '11:45:00',
            'location' => 'Cafeteria Transit Hall',
            'antecedent' => 'Sudden loud school bell rang while transitioning between classrooms; sensory overstimulation.',
            'behavior_type' => 'Meltdown & Crying',
            'behavior_description' => 'Covered ears, sat on floor, cried intensely and displayed mild hand flapping distress.',
            'intensity' => 'Moderate',
            'duration_minutes' => 4,
            'intervention_used' => 'Shadow aide promptly applied weighted dinosaur vest, guided him to quiet sensory tent, and offered silicone teether.',
            'post_incident_state' => 'Settled and calm after 5 minutes; drank water and rejoined group.',
            'logged_by_id' => $educator->id,
            'notified_parent' => true,
        ]);

        // 9. Fee Packages & Invoices
        $pkg1 = \App\Models\FeePackage::create([
            'name' => 'Full Day Specialized Schooling & Care',
            'description' => 'Includes 5 days/week special education, shadow aide support, meals, and sensory room access.',
            'amount' => 18000.00,
            'billing_cycle' => 'Monthly',
            'sessions_count' => 0,
            'is_active' => true,
        ]);

        $pkg2 = \App\Models\FeePackage::create([
            'name' => 'Speech & OT Integrated Therapy Bundle (12 Sessions)',
            'description' => '6 Speech Therapy + 6 Sensory Integration Occupational Therapy sessions per month.',
            'amount' => 12000.00,
            'billing_cycle' => 'Monthly',
            'sessions_count' => 12,
            'is_active' => true,
        ]);

        \App\Models\Invoice::create([
            'invoice_no' => 'INV-2026-001',
            'student_id' => $student->id,
            'fee_package_id' => $pkg1->id,
            'item_description' => 'Full Day Specialized Schooling & Care - November 2026',
            'amount' => 18000.00,
            'invoice_date' => Carbon::now()->startOfMonth(),
            'due_date' => Carbon::now()->startOfMonth()->addDays(10),
            'paid_date' => Carbon::now()->startOfMonth()->addDays(3),
            'payment_method' => 'UPI / GPay',
            'transaction_reference' => 'UPI/9876543210/AXIS',
            'status' => 'paid',
            'notes' => 'Paid in full by Rajesh Gupta.',
        ]);

        \App\Models\Invoice::create([
            'invoice_no' => 'INV-2026-002',
            'student_id' => $student->id,
            'fee_package_id' => $pkg2->id,
            'item_description' => 'Speech & OT Integrated Bundle (12 Sessions) - November 2026',
            'amount' => 12000.00,
            'invoice_date' => Carbon::now()->startOfMonth(),
            'due_date' => Carbon::now()->startOfMonth()->addDays(15),
            'paid_date' => null,
            'payment_method' => null,
            'status' => 'pending',
            'notes' => 'Awaiting payment confirmation.',
        ]);

        // 10. Attendance
        \App\Models\Attendance::create([
            'student_id' => $student->id,
            'date' => Carbon::now()->subDays(1),
            'status' => 'present',
            'arrival_time' => '09:05:00',
            'arrival_state' => 'Calm',
            'transport_mode' => 'School Bus',
            'bus_route' => 'Route 3 - Andheri West',
            'transit_attendant' => 'Sunita Verma',
            'notes' => 'Boarded bus happily with sensory backpack.',
        ]);
    }
}
