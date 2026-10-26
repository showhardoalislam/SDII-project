STUDENT COUNCIL QUERY PORTAL — সেটআপ নির্দেশনা
=============================================

1) ZIP Extract করুন।
2) Student_Council_Query_Portal ফোল্ডারটি রাখুন:
   C:\xampp\htdocs\Student_Council_Query_Portal
3) XAMPP Control Panel থেকে Apache এবং MySQL Start করুন।
4) http://localhost/phpmyadmin/ খুলুন।
5) Import ট্যাবে database.sql নির্বাচন করে Import করুন।
6) ওয়েবসাইট খুলুন:
   http://localhost/Student_Council_Query_Portal/

MySQL settings:
config/config.php ফাইলে DB_PORT, DB_USER, DB_PASS আছে।
ডিফল্ট: port 3306, user root, password blank.

Admin account:
1) ওয়েবসাইটে Register দিয়ে একটি account খুলুন।
2) phpMyAdmin → student_councile → SQL ট্যাবে চালান:
   UPDATE users SET role='admin' WHERE email='your-registered-email@example.com';
   নিজের registered email বসাবেন।
3) Logout করে আবার login করুন। Admin dashboard খুলবে।

Features:
- Responsive homepage and FAQ page
- Student registration/login/logout
- Secure password hashing, prepared SQL statements, CSRF token
- Submit and track student queries
- Admin status updates and responses

গুরুত্বপূর্ণ:
MySQL চালু না থাকলে database features কাজ করবে না। MySQL-এর data ফোল্ডারের ফাইল
সমাধান না জেনে Delete করবেন না। এটি coursework/starter project; public production use-এর
আগে HTTPS, rate limits, email verification, backup এবং security review যোগ করুন।
