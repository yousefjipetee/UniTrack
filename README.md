# UniTrack – University Course Management System

UniTrack is a full-stack University Course Management System designed specifically for Computer Science students.

The system provides a secure and responsive platform for managing university courses, instructors, students, departments, and course enrollments.

---

## Project Overview

UniTrack was developed as a full-stack web application using PHP, MySQL, HTML, CSS, and JavaScript.

The system contains two main user roles:

- Administrator
- Student

Each role has different permissions and access levels.

---

## Main Features

### Authentication

- Student registration
- Secure login
- Logout
- Session management
- Password hashing using `password_hash()`
- Password verification using `password_verify()`
- Protected pages
- Role-based authorization

### Student Features

Students can:

- Access their dashboard
- Browse available Computer Science courses
- Search for courses
- View course details
- View instructor information
- Enroll in courses
- Drop enrolled courses
- View currently enrolled courses
- View course history
- Update their profile information

### Administrator Features

Administrators can:

- Access the administrator dashboard
- View system statistics
- Manage courses
- Create courses
- Edit courses
- Delete courses
- Manage students
- Edit student information
- Delete students
- Manage instructors
- Create instructors
- Edit instructors
- Delete instructors
- Manage departments
- Create departments
- Edit departments
- Delete departments

---

## Security Features

Security is an important part of UniTrack.

The project implements:

- Prepared SQL statements
- Password hashing
- Password verification
- Session-based authentication
- Role-based authorization
- CSRF protection
- Server-side validation
- Client-side validation
- HTML validation
- Encrypted sensitive user data
- AES-256-GCM encryption
- Protected administrative pages

Passwords are never stored as plain text.

Sensitive information such as the user's phone number is encrypted before being stored in the database.

---

## AJAX Functionality

UniTrack uses JavaScript and AJAX to provide dynamic interactions without unnecessary page reloads.

Examples include:

- Course enrollment
- Course dropping
- Enrollment status updates
- Dynamic course search
- Student search
- Dynamic interface updates

The AJAX workflow follows:

```text
JavaScript
    ↓
Fetch Request
    ↓
PHP API
    ↓
MySQL Database
    ↓
PHP Response
    ↓
JavaScript DOM Update