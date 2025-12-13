<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Demo',
                'price' => 0.00,
                'notice_limit' => 5,
                'technician_limit' => 1,
                'features' => [
                    'mobile_app' => true,
                    'photos' => true,
                    'basic_history' => true,
                    'ai_basic' => false,
                    'ai_advanced' => false,
                    'digital_signature' => false,
                    'basic_kpis' => false,
                    'automatic_routes' => false,
                    'calendars' => false,
                    'integrations' => false,
                    'advanced_reporting' => false,
                    'trial_period' => true,
                ],
            ],
            [
                'name' => 'Starter',
                'price' => 15.00,
                'notice_limit' => 20,
                'technician_limit' => 1,
                'features' => [
                    'mobile_app' => true,
                    'photos' => true,
                    'basic_history' => true,
                    'ai_basic' => false,
                    'ai_advanced' => false,
                    'digital_signature' => false,
                    'basic_kpis' => false,
                    'automatic_routes' => false,
                    'calendars' => false,
                    'integrations' => false,
                    'advanced_reporting' => false,
                ],
            ],
            [
                'name' => 'Basic',
                'price' => 29.00,
                'notice_limit' => 100,
                'technician_limit' => 3,
                'features' => [
                    'mobile_app' => true,
                    'photos' => true,
                    'basic_history' => true,
                    'ai_basic' => true,
                    'ai_basic_features' => [
                        'type_detection' => true,
                        'urgency_detection' => true,
                        'probable_solution' => true,
                    ],
                    'digital_signature' => true,
                    'basic_kpis' => true,
                    'ai_advanced' => false,
                    'automatic_routes' => false,
                    'calendars' => false,
                    'integrations' => false,
                    'advanced_reporting' => false,
                ],
            ],
            [
                'name' => 'Pro',
                'price' => 49.00,
                'notice_limit' => -1, // Unlimited
                'technician_limit' => 10,
                'features' => [
                    'mobile_app' => true,
                    'photos' => true,
                    'basic_history' => true,
                    'ai_basic' => true,
                    'ai_advanced' => true,
                    'ai_advanced_features' => [
                        'complete_diagnosis' => true,
                        'technician_assignment' => true,
                        'estimated_time' => true,
                    ],
                    'digital_signature' => true,
                    'basic_kpis' => true,
                    'automatic_routes' => true,
                    'calendars' => true,
                    'integrations' => true,
                    'advanced_reporting' => true,
                ],
            ],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::create($plan);
        }
    }
}
