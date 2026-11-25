<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Tables the gh.hms code uses but that are NOT in hmssocie_gh_software_fixed.sql
 * (Payment Categories, Loans, Patient Other Expenses, Emergency Hospitalization,
 * Emergency Call Register). Columns are exactly the ones the gh controllers
 * read and write. Existing tables are skipped.
 */
return new class extends Migration
{
    public function up(): void
    {
        $tables = [
            'payment_categories' => "CREATE TABLE `payment_categories` (
                `id` int NOT NULL AUTO_INCREMENT,
                `payment_category` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
                `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
                `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci",

            'loans' => "CREATE TABLE `loans` (
                `id` int NOT NULL AUTO_INCREMENT,
                `loan_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
                `bank_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
                `loan_date` date NOT NULL,
                `hospital_payment_category` int DEFAULT NULL,
                `created_at` timestamp NULL DEFAULT NULL,
                `updated_at` timestamp NULL DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci",

            'patient_expenses' => "CREATE TABLE `patient_expenses` (
                `id` int NOT NULL AUTO_INCREMENT,
                `patient_id` int NOT NULL,
                `total_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
                `paid_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
                `payments` longtext COLLATE utf8mb4_general_ci,
                `notes` text COLLATE utf8mb4_general_ci,
                `status` varchar(25) COLLATE utf8mb4_general_ci DEFAULT 'Pending',
                `date` date DEFAULT NULL,
                `created_at` timestamp NULL DEFAULT NULL,
                `updated_at` timestamp NULL DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci",

            'emergency_hospitalizations' => "CREATE TABLE `emergency_hospitalizations` (
                `id` int NOT NULL AUTO_INCREMENT,
                `patient_id` int NOT NULL,
                `date` date DEFAULT NULL,
                `illness` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
                `doctor` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
                `remarks` text COLLATE utf8mb4_general_ci,
                `created_at` timestamp NULL DEFAULT NULL,
                `updated_at` timestamp NULL DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci",

            'emergency_callregister' => "CREATE TABLE `emergency_callregister` (
                `id` int NOT NULL AUTO_INCREMENT,
                `patient_id` int NOT NULL,
                `date` date DEFAULT NULL,
                `illness` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
                `doctor` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
                `remarks` text COLLATE utf8mb4_general_ci,
                `created_at` timestamp NULL DEFAULT NULL,
                `updated_at` timestamp NULL DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci",
        ];

        foreach ($tables as $name => $sql) {
            if (! Schema::hasTable($name)) {
                DB::unprepared($sql);
            }
        }

        // The "hospital account" dropdowns (billing, medicine bills, loans) read this table.
        if (DB::table('payment_categories')->count() === 0) {
            foreach (['Cash', 'Current account', 'Savings account'] as $name) {
                DB::table('payment_categories')->insert(['payment_category' => $name, 'created_at' => now(), 'updated_at' => now()]);
            }
        }
    }

    public function down(): void
    {
        // Never drop hospital tables automatically.
    }
};
