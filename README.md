Cybershop (PHP + MySQL + Bootstrap 5)
1) Setup
Create a MySQL database named cybershop.
Import the SQL schema: sql/schema.sql
Update database credentials in: app/config.php
Place this project in your web root, e.g.:
XAMPP: htdocs/cybershop/
Access the site:
Shop: /public/index.php
Admin dashboard: /admin/dashboard.php
2) Demo admin login

Replace with your own local credentials

Email: your_admin_email_here
Password: your_admin_password_here
3) Postman API endpoints (JSON)

Base URL example: http://localhost/cybershop

POST /api/register.php
{"fullName":"Test User","email":"test@example.com","password":"your_password_here"}
POST /api/login.php
{"email":"your_admin_email_here","password":"your_admin_password_here"}
GET /api/products.php
POST /api/orders_create.php
{"items":[{"productId":1,"qty":2},{"productId":2,"qty":1}]}
POST /api/admin/products_create.php (admin only)
{"name":"Product Name","price":99.99,"stock":10,"imageUrl":"/assets/images/example.png"}
4) Notes on images
Store imageUrl as a local path, e.g.: /assets/images/cybershop.png
Free image sources: AI-generated, Unsplash, Pexels, Pixabay
5) Current System Capabilities
User authentication
Product management
Cart & checkout
Orders lifecycle
Payment tracking (PCI-aware)
Admin control panel
Security logging (CYBER FEATURE ⭐)
Configurable system settings
Notifications
Settings Table Includes
site_name
contact_email
currency
maintenance_mode
pci_compliance_mode
enable_2fa
max_failed_attempts
session_timeout_minutes
low_stock_threshold
PCI Compliance Highlights
No card data stored
Payments separated
Status controlled
Settings configurable
Summary of What’s Built
Full e-commerce backend ✔
Admin dashboard ✔
Order lifecycle ✔
Payment tracking ✔
Security logging ✔
Configurable system settings ✔

This version is safe for GitHub, professional, and ready to show your capstone project.

If you want, I can also write a complete .gitignore + placeholders setup for your project so that you can push it right now safely, including your SQL schema and images.

Do you want me to do that next?