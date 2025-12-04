-- Migration: add optional columns to support activation and approval workflows
-- Run these statements on your MySQL database connected to this project.
-- Backup your database before running any ALTERs.

-- Add is_active column to users (default 1 = active)
ALTER TABLE users
  ADD COLUMN IF NOT EXISTS is_active TINYINT(1) DEFAULT 1;

-- Add is_approved column to courses (default 0 = pending)
ALTER TABLE courses
  ADD COLUMN IF NOT EXISTS is_approved TINYINT(1) DEFAULT 0;

-- Note: some MySQL versions do not support IF NOT EXISTS for ADD COLUMN.
-- If you get syntax errors, run safe ALTERs like below after checking existing columns:
-- ALTER TABLE users ADD COLUMN is_active TINYINT(1) DEFAULT 1;
-- ALTER TABLE courses ADD COLUMN is_approved TINYINT(1) DEFAULT 0;

-- After running the migration, admin activation and course approval features will function properly.
