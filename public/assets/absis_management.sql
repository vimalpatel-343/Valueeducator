-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2025 at 09:28 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absis_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `absis_advances`
--

CREATE TABLE `absis_advances` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `reason` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `approved_by` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `absis_attendance`
--

CREATE TABLE `absis_attendance` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `attendance_date` date NOT NULL,
  `check_in` time DEFAULT NULL,
  `check_out` time DEFAULT NULL,
  `hours_worked` decimal(5,2) DEFAULT NULL,
  `status` enum('present','absent','leave','holiday') DEFAULT 'present',
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `absis_employees`
--

CREATE TABLE `absis_employees` (
  `id` int(11) NOT NULL,
  `employee_code` varchar(20) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `employee_type_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `id_card_number` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `date_of_joining` date NOT NULL,
  `status` enum('active','resigned','terminated') DEFAULT 'active',
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `absis_employee_documents`
--

CREATE TABLE `absis_employee_documents` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `document_type` varchar(50) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `uploaded_by` int(11) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `absis_employee_types`
--

CREATE TABLE `absis_employee_types` (
  `id` int(11) NOT NULL,
  `type_name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absis_employee_types`
--

INSERT INTO `absis_employee_types` (`id`, `type_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Security', 'Security staff for industrial companies', '2025-10-05 06:53:12', '2025-10-05 06:53:12'),
(2, 'Nurse', 'Nursing staff for hospitals', '2025-10-05 06:53:12', '2025-10-05 06:53:12'),
(3, 'Watchman', 'Watchman for various facilities', '2025-10-05 06:53:12', '2025-10-05 06:53:12');

-- --------------------------------------------------------

--
-- Table structure for table `absis_employee_uniforms`
--

CREATE TABLE `absis_employee_uniforms` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `issued_date` date NOT NULL,
  `expected_return_date` date DEFAULT NULL,
  `actual_return_date` date DEFAULT NULL,
  `status` enum('issued','returned','damaged') DEFAULT 'issued',
  `remarks` text DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `absis_expenses`
--

CREATE TABLE `absis_expenses` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `expense_date` date NOT NULL,
  `description` text DEFAULT NULL,
  `receipt_file_path` varchar(255) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `absis_expense_categories`
--

CREATE TABLE `absis_expense_categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absis_expense_categories`
--

INSERT INTO `absis_expense_categories` (`id`, `category_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Office Expenses', 'General office expenses', '2025-10-05 06:53:12', '2025-10-05 06:53:12'),
(2, 'Petrol Expenses', 'Fuel and transportation expenses', '2025-10-05 06:53:12', '2025-10-05 06:53:12'),
(3, 'Medical Expenses', 'Medical and healthcare expenses', '2025-10-05 06:53:12', '2025-10-05 06:53:12'),
(4, 'Rent Payment', 'Office or facility rent payments', '2025-10-05 06:53:12', '2025-10-05 06:53:12'),
(5, 'Light Bill', 'Electricity and utility bills', '2025-10-05 06:53:12', '2025-10-05 06:53:12'),
(6, 'Food Expenses', 'Food and catering expenses', '2025-10-05 06:53:12', '2025-10-05 06:53:12'),
(7, 'Advance to Staff', 'Advances given to staff members', '2025-10-05 06:53:12', '2025-10-05 06:53:12');

-- --------------------------------------------------------

--
-- Table structure for table `absis_invoices`
--

CREATE TABLE `absis_invoices` (
  `id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `invoice_number` varchar(50) NOT NULL,
  `invoice_date` date NOT NULL,
  `due_date` date NOT NULL,
  `total_amount` decimal(12,2) NOT NULL,
  `gst_percentage` decimal(5,2) DEFAULT 0.00,
  `gst_amount` decimal(12,2) DEFAULT 0.00,
  `net_amount` decimal(12,2) NOT NULL,
  `status` enum('draft','sent','paid','overdue','cancelled') DEFAULT 'draft',
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `absis_invoice_items`
--

CREATE TABLE `absis_invoice_items` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `employee_type_id` int(11) NOT NULL,
  `rate_per_day` decimal(10,2) NOT NULL,
  `days_worked` int(11) NOT NULL,
  `amount` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `absis_payments`
--

CREATE TABLE `absis_payments` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `payment_date` date NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `payment_method` enum('cash','cheque','bank_transfer') NOT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `status` enum('pending','completed','failed') DEFAULT 'pending',
  `received_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `absis_penalties`
--

CREATE TABLE `absis_penalties` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `reason` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `approved_by` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `absis_salary`
--

CREATE TABLE `absis_salary` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `basic_salary` decimal(10,2) NOT NULL,
  `allowances` decimal(10,2) DEFAULT 0.00,
  `deductions` decimal(10,2) DEFAULT 0.00,
  `advance_deduction` decimal(10,2) DEFAULT 0.00,
  `penalty_deduction` decimal(10,2) DEFAULT 0.00,
  `net_salary` decimal(10,2) NOT NULL,
  `payment_status` enum('pending','paid') DEFAULT 'pending',
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `absis_stock`
--

CREATE TABLE `absis_stock` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `location` varchar(100) DEFAULT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `absis_stock_history`
--

CREATE TABLE `absis_stock_history` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `transaction_type` enum('issue','return','defect','adjustment') NOT NULL,
  `quantity` int(11) NOT NULL,
  `transaction_date` date NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `absis_stock_items`
--

CREATE TABLE `absis_stock_items` (
  `id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `absis_units`
--

CREATE TABLE `absis_units` (
  `id` int(11) NOT NULL,
  `unit_name` varchar(100) NOT NULL,
  `address` text DEFAULT NULL,
  `contact_person` varchar(100) DEFAULT NULL,
  `contact_phone` varchar(20) DEFAULT NULL,
  `contact_email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absis_units`
--

INSERT INTO `absis_units` (`id`, `unit_name`, `address`, `contact_person`, `contact_phone`, `contact_email`, `created_at`, `updated_at`) VALUES
(1, 'Unit 1 ', 'cdczc', 'demo', '7867876756', 'dec@gmail.com', '2025-10-05 12:50:37', '2025-10-06 08:07:48'),
(3, 'Unit 1 test', '35, Patel Street, At & Po : Kudiyaba, Ta : Olpad, Dis : Surat', 'Vimal Patel', '09558449166', 'vimalpatel343@gmail.com', '2025-10-06 07:41:18', '2025-10-06 07:41:18'),
(4, 'demo', '35, Patel Street, At & Po : Kudiyaba, Ta : Olpad, Dis : Surat', 'Vimal Patel', '09558449166', 'vimalpatel343@gmail.com', '2025-10-06 07:41:49', '2025-10-06 07:41:49'),
(6, 'test', 'testtesttest', 'test', '09558449166', 'test@gmail.com', '2025-10-06 07:52:27', '2025-10-06 07:52:27'),
(7, 'test12A', 'test12Atest12Atest12Atest12A', 'test12A', '09558449166', 'test12A@gmail.com', '2025-10-06 08:01:36', '2025-10-06 08:01:36'),
(8, 'Unit 1 Edit', '35, Patel Street, At & Po : Kudiyaba, Ta : Olpad, Dis : Surat', 'Vimal Patel', '09558449166', 'vimalpatel343@gmail.com', '2025-10-06 08:05:45', '2025-10-06 08:05:45'),
(9, 'Unit 12', '35, Patel Street, At & Po : Kudiyaba, Ta : Olpad, Dis : Surat', 'Vimal Patel', '09558449166', 'vimalpatel343@gmail.com', '2025-10-06 08:08:28', '2025-10-06 08:08:28');

-- --------------------------------------------------------

--
-- Table structure for table `absis_unit_pricing`
--

CREATE TABLE `absis_unit_pricing` (
  `id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `employee_type_id` int(11) NOT NULL,
  `rate_per_day` decimal(10,2) NOT NULL,
  `effective_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absis_unit_pricing`
--

INSERT INTO `absis_unit_pricing` (`id`, `unit_id`, `employee_type_id`, `rate_per_day`, `effective_date`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 15.00, '2025-10-05', '2025-10-05 12:57:31', '2025-10-05 12:57:31'),
(2, 1, 2, 20.00, '2025-10-05', '2025-10-05 12:57:31', '2025-10-05 12:57:31'),
(3, 1, 3, 15.00, '2025-10-05', '2025-10-05 12:57:31', '2025-10-05 12:57:31'),
(4, 9, 1, 12.00, '2025-10-06', '2025-10-06 08:08:28', '2025-10-06 08:08:28'),
(5, 9, 2, 34.00, '2025-10-06', '2025-10-06 08:08:28', '2025-10-06 08:08:28'),
(6, 9, 3, 45.00, '2025-10-06', '2025-10-06 08:08:28', '2025-10-06 08:08:28');

-- --------------------------------------------------------

--
-- Table structure for table `absis_users`
--

CREATE TABLE `absis_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(100) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `role_id` int(11) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absis_users`
--

INSERT INTO `absis_users` (`id`, `username`, `password`, `email`, `full_name`, `role_id`, `status`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'admin@absis.com', 'System Administrator', 1, 'active', '2025-10-07 01:04:31', '2025-10-05 06:53:12', '2025-10-07 06:34:31');

-- --------------------------------------------------------

--
-- Table structure for table `absis_user_logs`
--

CREATE TABLE `absis_user_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(100) NOT NULL,
  `details` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `absis_user_roles`
--

CREATE TABLE `absis_user_roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absis_user_roles`
--

INSERT INTO `absis_user_roles` (`id`, `role_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', 'Full system access with all permissions', '2025-10-05 06:53:12', '2025-10-05 06:53:12'),
(2, 'admin', 'Access to all modules except system configuration', '2025-10-05 06:53:12', '2025-10-05 06:53:12'),
(3, 'editor', 'Limited access to employee data and basic reports', '2025-10-05 06:53:12', '2025-10-05 06:53:12'),
(4, 'accountant', 'Access to invoicing and payment tracking', '2025-10-05 06:53:12', '2025-10-05 06:53:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absis_advances`
--
ALTER TABLE `absis_advances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `approved_by` (`approved_by`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `absis_attendance`
--
ALTER TABLE `absis_attendance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_id` (`employee_id`,`attendance_date`),
  ADD KEY `unit_id` (`unit_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `absis_employees`
--
ALTER TABLE `absis_employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_code` (`employee_code`),
  ADD KEY `employee_type_id` (`employee_type_id`),
  ADD KEY `unit_id` (`unit_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `absis_employee_documents`
--
ALTER TABLE `absis_employee_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `uploaded_by` (`uploaded_by`);

--
-- Indexes for table `absis_employee_types`
--
ALTER TABLE `absis_employee_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type_name` (`type_name`);

--
-- Indexes for table `absis_employee_uniforms`
--
ALTER TABLE `absis_employee_uniforms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `absis_expenses`
--
ALTER TABLE `absis_expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `absis_expense_categories`
--
ALTER TABLE `absis_expense_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `absis_invoices`
--
ALTER TABLE `absis_invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_number` (`invoice_number`),
  ADD KEY `unit_id` (`unit_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `absis_invoice_items`
--
ALTER TABLE `absis_invoice_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_id` (`invoice_id`),
  ADD KEY `employee_type_id` (`employee_type_id`);

--
-- Indexes for table `absis_payments`
--
ALTER TABLE `absis_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_id` (`invoice_id`),
  ADD KEY `received_by` (`received_by`);

--
-- Indexes for table `absis_penalties`
--
ALTER TABLE `absis_penalties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `approved_by` (`approved_by`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `absis_salary`
--
ALTER TABLE `absis_salary`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_id` (`employee_id`,`month`,`year`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `absis_stock`
--
ALTER TABLE `absis_stock`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `absis_stock_history`
--
ALTER TABLE `absis_stock_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `unit_id` (`unit_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `absis_stock_items`
--
ALTER TABLE `absis_stock_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `absis_units`
--
ALTER TABLE `absis_units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `absis_unit_pricing`
--
ALTER TABLE `absis_unit_pricing`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unit_id` (`unit_id`,`employee_type_id`,`effective_date`),
  ADD KEY `employee_type_id` (`employee_type_id`);

--
-- Indexes for table `absis_users`
--
ALTER TABLE `absis_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `absis_user_logs`
--
ALTER TABLE `absis_user_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `absis_user_roles`
--
ALTER TABLE `absis_user_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absis_advances`
--
ALTER TABLE `absis_advances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `absis_attendance`
--
ALTER TABLE `absis_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `absis_employees`
--
ALTER TABLE `absis_employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `absis_employee_documents`
--
ALTER TABLE `absis_employee_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `absis_employee_types`
--
ALTER TABLE `absis_employee_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `absis_employee_uniforms`
--
ALTER TABLE `absis_employee_uniforms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `absis_expenses`
--
ALTER TABLE `absis_expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `absis_expense_categories`
--
ALTER TABLE `absis_expense_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `absis_invoices`
--
ALTER TABLE `absis_invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `absis_invoice_items`
--
ALTER TABLE `absis_invoice_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `absis_payments`
--
ALTER TABLE `absis_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `absis_penalties`
--
ALTER TABLE `absis_penalties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `absis_salary`
--
ALTER TABLE `absis_salary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `absis_stock`
--
ALTER TABLE `absis_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `absis_stock_history`
--
ALTER TABLE `absis_stock_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `absis_stock_items`
--
ALTER TABLE `absis_stock_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `absis_units`
--
ALTER TABLE `absis_units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `absis_unit_pricing`
--
ALTER TABLE `absis_unit_pricing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `absis_users`
--
ALTER TABLE `absis_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `absis_user_logs`
--
ALTER TABLE `absis_user_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `absis_user_roles`
--
ALTER TABLE `absis_user_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absis_advances`
--
ALTER TABLE `absis_advances`
  ADD CONSTRAINT `absis_advances_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `absis_employees` (`id`),
  ADD CONSTRAINT `absis_advances_ibfk_2` FOREIGN KEY (`approved_by`) REFERENCES `absis_users` (`id`),
  ADD CONSTRAINT `absis_advances_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `absis_users` (`id`);

--
-- Constraints for table `absis_attendance`
--
ALTER TABLE `absis_attendance`
  ADD CONSTRAINT `absis_attendance_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `absis_employees` (`id`),
  ADD CONSTRAINT `absis_attendance_ibfk_2` FOREIGN KEY (`unit_id`) REFERENCES `absis_units` (`id`),
  ADD CONSTRAINT `absis_attendance_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `absis_users` (`id`);

--
-- Constraints for table `absis_employees`
--
ALTER TABLE `absis_employees`
  ADD CONSTRAINT `absis_employees_ibfk_1` FOREIGN KEY (`employee_type_id`) REFERENCES `absis_employee_types` (`id`),
  ADD CONSTRAINT `absis_employees_ibfk_2` FOREIGN KEY (`unit_id`) REFERENCES `absis_units` (`id`),
  ADD CONSTRAINT `absis_employees_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `absis_users` (`id`);

--
-- Constraints for table `absis_employee_documents`
--
ALTER TABLE `absis_employee_documents`
  ADD CONSTRAINT `absis_employee_documents_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `absis_employees` (`id`),
  ADD CONSTRAINT `absis_employee_documents_ibfk_2` FOREIGN KEY (`uploaded_by`) REFERENCES `absis_users` (`id`);

--
-- Constraints for table `absis_employee_uniforms`
--
ALTER TABLE `absis_employee_uniforms`
  ADD CONSTRAINT `absis_employee_uniforms_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `absis_employees` (`id`),
  ADD CONSTRAINT `absis_employee_uniforms_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `absis_stock_items` (`id`),
  ADD CONSTRAINT `absis_employee_uniforms_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `absis_users` (`id`);

--
-- Constraints for table `absis_expenses`
--
ALTER TABLE `absis_expenses`
  ADD CONSTRAINT `absis_expenses_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `absis_expense_categories` (`id`),
  ADD CONSTRAINT `absis_expenses_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `absis_users` (`id`);

--
-- Constraints for table `absis_invoices`
--
ALTER TABLE `absis_invoices`
  ADD CONSTRAINT `absis_invoices_ibfk_1` FOREIGN KEY (`unit_id`) REFERENCES `absis_units` (`id`),
  ADD CONSTRAINT `absis_invoices_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `absis_users` (`id`);

--
-- Constraints for table `absis_invoice_items`
--
ALTER TABLE `absis_invoice_items`
  ADD CONSTRAINT `absis_invoice_items_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `absis_invoices` (`id`),
  ADD CONSTRAINT `absis_invoice_items_ibfk_2` FOREIGN KEY (`employee_type_id`) REFERENCES `absis_employee_types` (`id`);

--
-- Constraints for table `absis_payments`
--
ALTER TABLE `absis_payments`
  ADD CONSTRAINT `absis_payments_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `absis_invoices` (`id`),
  ADD CONSTRAINT `absis_payments_ibfk_2` FOREIGN KEY (`received_by`) REFERENCES `absis_users` (`id`);

--
-- Constraints for table `absis_penalties`
--
ALTER TABLE `absis_penalties`
  ADD CONSTRAINT `absis_penalties_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `absis_employees` (`id`),
  ADD CONSTRAINT `absis_penalties_ibfk_2` FOREIGN KEY (`approved_by`) REFERENCES `absis_users` (`id`),
  ADD CONSTRAINT `absis_penalties_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `absis_users` (`id`);

--
-- Constraints for table `absis_salary`
--
ALTER TABLE `absis_salary`
  ADD CONSTRAINT `absis_salary_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `absis_employees` (`id`),
  ADD CONSTRAINT `absis_salary_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `absis_users` (`id`);

--
-- Constraints for table `absis_stock`
--
ALTER TABLE `absis_stock`
  ADD CONSTRAINT `absis_stock_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `absis_stock_items` (`id`),
  ADD CONSTRAINT `absis_stock_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `absis_users` (`id`);

--
-- Constraints for table `absis_stock_history`
--
ALTER TABLE `absis_stock_history`
  ADD CONSTRAINT `absis_stock_history_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `absis_stock_items` (`id`),
  ADD CONSTRAINT `absis_stock_history_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `absis_employees` (`id`),
  ADD CONSTRAINT `absis_stock_history_ibfk_3` FOREIGN KEY (`unit_id`) REFERENCES `absis_units` (`id`),
  ADD CONSTRAINT `absis_stock_history_ibfk_4` FOREIGN KEY (`created_by`) REFERENCES `absis_users` (`id`);

--
-- Constraints for table `absis_unit_pricing`
--
ALTER TABLE `absis_unit_pricing`
  ADD CONSTRAINT `absis_unit_pricing_ibfk_1` FOREIGN KEY (`unit_id`) REFERENCES `absis_units` (`id`),
  ADD CONSTRAINT `absis_unit_pricing_ibfk_2` FOREIGN KEY (`employee_type_id`) REFERENCES `absis_employee_types` (`id`);

--
-- Constraints for table `absis_users`
--
ALTER TABLE `absis_users`
  ADD CONSTRAINT `absis_users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `absis_user_roles` (`id`);

--
-- Constraints for table `absis_user_logs`
--
ALTER TABLE `absis_user_logs`
  ADD CONSTRAINT `absis_user_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `absis_users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
