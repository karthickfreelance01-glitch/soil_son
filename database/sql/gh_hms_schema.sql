-- gh.hms-society.com database structure (from hmssocie_gh_software_fixed.sql, Nov 20 2026)
-- Structure only: same tables and columns, no patient data.

-- TABLE: counsellor_notes
CREATE TABLE `counsellor_notes` (
  `id` int UNSIGNED NOT NULL,
  `patient_id` bigint UNSIGNED NOT NULL,
  `staff_id` bigint UNSIGNED NOT NULL,
  `note_date` date NOT NULL,
  `assess_problem` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `counselling_given` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `document` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `counsellor_notes`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `counsellor_notes`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

-- TABLE: dangerously_ill
CREATE TABLE `dangerously_ill` (
  `id` int NOT NULL,
  `patient_id` int NOT NULL,
  `patient_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `age` int DEFAULT NULL,
  `admission_date` date DEFAULT NULL,
  `before_admission_condition` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `treatment_given` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `dangerously_ill`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `dangerously_ill`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

-- TABLE: death_register
CREATE TABLE `death_register` (
  `id` int UNSIGNED NOT NULL,
  `patient_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `death_datetime` datetime NOT NULL,
  `report_attachment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `death_register`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `death_register`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

-- TABLE: doctor_notes
CREATE TABLE `doctor_notes` (
  `id` bigint UNSIGNED NOT NULL,
  `patient_id` bigint UNSIGNED NOT NULL,
  `note_date` date NOT NULL,
  `height` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bp` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pr` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `temp` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `spo2` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `document` varchar(5000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
ALTER TABLE `doctor_notes`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `doctor_notes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

-- TABLE: escape_registers
CREATE TABLE `escape_registers` (
  `id` bigint UNSIGNED NOT NULL,
  `patient_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `patient_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `escape_datetime` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `video_footage` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `police_fir_copy` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `file_attach` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `escape_registers`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `escape_registers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

-- TABLE: expenses
CREATE TABLE `expenses` (
  `id` int NOT NULL,
  `expense_name` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `expenses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

-- TABLE: expenses_details
CREATE TABLE `expenses_details` (
  `id` int NOT NULL,
  `expenses_id` int NOT NULL,
  `amount` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `accounttype` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `expense_date` date NOT NULL,
  `notes` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `expenses_details`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `expenses_details`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

-- TABLE: follow_ups
CREATE TABLE `follow_ups` (
  `id` int NOT NULL,
  `patient_id` int NOT NULL,
  `op_number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `feedback` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `follow_ups`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `follow_ups`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

-- TABLE: injuries
CREATE TABLE `injuries` (
  `id` int NOT NULL,
  `patient_id` int NOT NULL,
  `patient_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `age` int DEFAULT NULL,
  `admission_date` date DEFAULT NULL,
  `injury_date` date NOT NULL,
  `injury_time` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `incident` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `physician` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `injuries`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `injuries`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

-- TABLE: internships
CREATE TABLE `internships` (
  `id` int NOT NULL,
  `student_details` text,
  `training_period` varchar(100) DEFAULT NULL,
  `pronoun` varchar(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `internships`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `internships`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

-- TABLE: medical_equipments
CREATE TABLE `medical_equipments` (
  `id` bigint UNSIGNED NOT NULL,
  `equipment_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `repair` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_date` date NOT NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
ALTER TABLE `medical_equipments`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `medical_equipments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

-- TABLE: medicines
CREATE TABLE `medicines` (
  `id` int NOT NULL,
  `vendor_id` int DEFAULT NULL,
  `drug_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `category_id` int NOT NULL,
  `manufactured_date` date NOT NULL,
  `expiry_date` date NOT NULL,
  `price` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `selling_price` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `stock` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `medicines`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

-- TABLE: medicine_bill
CREATE TABLE `medicine_bill` (
  `id` bigint UNSIGNED NOT NULL,
  `bill_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `patient_id` bigint UNSIGNED NOT NULL,
  `overall_total` decimal(10,2) DEFAULT '0.00',
  `round_off` decimal(10,2) DEFAULT '0.00',
  `final_amount` decimal(10,2) DEFAULT '0.00',
  `hospital_account` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `payment_mode` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `initial_payment` decimal(10,2) DEFAULT '0.00',
  `pending_payment` decimal(10,2) DEFAULT '0.00',
  `issue_date` date DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `issue_time` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `medicine_bill`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `medicine_bill`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

-- TABLE: medicine_categories
CREATE TABLE `medicine_categories` (
  `id` int NOT NULL,
  `medicine_category` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `medicine_categories`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `medicine_categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

-- TABLE: medicine_issues
CREATE TABLE `medicine_issues` (
  `id` int NOT NULL,
  `patient_id` int NOT NULL,
  `bill_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `drug_id` varchar(5000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `issue_time` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `drug_count` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `complaints` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `price` decimal(10,2) DEFAULT '0.00',
  `line_total` decimal(10,2) DEFAULT '0.00',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `medicine_issues`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `medicine_issues`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

-- TABLE: nurse_notes
CREATE TABLE `nurse_notes` (
  `id` bigint UNSIGNED NOT NULL,
  `patient_id` bigint UNSIGNED NOT NULL,
  `note_date` date NOT NULL,
  `height` varchar(50) DEFAULT NULL,
  `weight` varchar(50) DEFAULT NULL,
  `bp` varchar(50) DEFAULT NULL,
  `pr` varchar(50) DEFAULT NULL,
  `temp` varchar(50) DEFAULT NULL,
  `spo2` varchar(50) DEFAULT NULL,
  `notes` longtext,
  `document` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `nurse_notes`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `nurse_notes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

-- TABLE: patients
CREATE TABLE `patients` (
  `id` int UNSIGNED NOT NULL,
  `ip_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date_of_admission` date NOT NULL,
  `time_of_admission` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `duration_month` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `age` int DEFAULT NULL,
  `gender` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `marital_status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `occupation` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `admitted_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contact_number` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `referral_source` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `patient_case` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `blood_group` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `staff_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `present_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `permanent_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `aadhar_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `discharge_status` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Pending',
  `discharge_date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `discharge_advice` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `patients`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

-- TABLE: patient_billings
CREATE TABLE `patient_billings` (
  `id` int UNSIGNED NOT NULL,
  `patient_id` int UNSIGNED NOT NULL,
  `bill_date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `bill_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `category` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `notes` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `received_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `pending_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `payment_mode` enum('Cash','Others','Card','UPI','NetBanking') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `account_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `payment_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `patient_billings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`);
ALTER TABLE `patient_billings`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

-- TABLE: patient_bills
CREATE TABLE `patient_bills` (
  `id` int UNSIGNED NOT NULL,
  `patient_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `monthly_amount` decimal(10,2) DEFAULT '0.00',
  `per_day` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pick_up` decimal(10,2) DEFAULT NULL,
  `medicine` decimal(10,2) DEFAULT '0.00',
  `other_expense` decimal(10,2) DEFAULT '0.00',
  `total_amount` decimal(10,2) DEFAULT '0.00',
  `received_amount` decimal(10,2) DEFAULT NULL,
  `pending_amount` decimal(10,2) DEFAULT NULL,
  `payment_mode` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `account_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `payment_date` date DEFAULT NULL,
  `monthly_bills` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `payments` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `discharge_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `final_amount` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `discount` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `patient_bills`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `patient_bills`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

-- TABLE: patient_hearings
CREATE TABLE `patient_hearings` (
  `id` bigint UNSIGNED NOT NULL,
  `patient_id` bigint UNSIGNED NOT NULL,
  `date_of_admission` date DEFAULT NULL,
  `fir_csr` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_hearing` date NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
ALTER TABLE `patient_hearings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`);
ALTER TABLE `patient_hearings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

-- TABLE: reports
CREATE TABLE `reports` (
  `id` bigint UNSIGNED NOT NULL,
  `patient_id` bigint UNSIGNED NOT NULL,
  `report_date` date NOT NULL,
  `document_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `document_file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `reports`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

-- TABLE: staff
CREATE TABLE `staff` (
  `id` int NOT NULL,
  `role` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `staff_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `contact_no` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `join_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `salary` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `staff`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

-- TABLE: staff_attendance
CREATE TABLE `staff_attendance` (
  `id` int NOT NULL,
  `staff_id` int NOT NULL,
  `attendance_date` date NOT NULL,
  `status` enum('Present','Absent','Half Day') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `staff_attendance`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `staff_attendance`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

-- TABLE: user
CREATE TABLE `user` (
  `id` int NOT NULL,
  `role` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

-- TABLE: vendors
CREATE TABLE `vendors` (
  `id` int NOT NULL,
  `vendor_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `contact_person` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `vendors`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
