OnlineCourse - Authentication (Part 1)

Setup instructions (development):

1. Create a MySQL database named `onlinecourse` (or change credentials in `config/Database.php`).

2. Create `users` table with the following SQL:

```sql
CREATE TABLE `users` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(191) NOT NULL,
	`email` VARCHAR(191) NOT NULL UNIQUE,
	`password` VARCHAR(255) NOT NULL,
	`role` VARCHAR(50) NOT NULL DEFAULT 'student',
	`created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
);
```

3. Place the project in your web server root (e.g., XAMPP `htdocs`) and open in browser: `http://localhost/onlinecourse`.

4. Available routes (basic):
- `index.php?action=register` — register
- `index.php?action=login` — login
- `index.php?action=logout` — logout
- `index.php?action=profile` — manage account (must be logged in)

Notes:
- Passwords are hashed using PHP `password_hash` and verified with `password_verify`.
- This is a minimal demo implementation for Part 1 (authentication/account management). Improve validation, CSRF protection, and UI for production use.
