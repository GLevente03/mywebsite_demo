# 🌍 Levi Around The World – Web Application

A personal full-stack web application built with PHP, focusing on secure user management, email verification, and scalable architecture.
This project serves as both a learning platform and a foundation for future extensions (mobile apps, IoT integration, data visualization).

---

## 🚀 Features

* 🔐 User registration & authentication system
* 📧 Email verification with secure token handling
* 🌐 Multi-language support (session & cookie based)
* 🛡️ Strong password validation rules
* 🚫 Basic anti-spam protection (IP-based registration limit)
* 🧹 Cleanup of unverified accounts
* 📬 SMTP email sending via PHPMailer and CRON job on the Server

---

## 🛠️ Tech Stack

* **Backend:** PHP (OOP, MVC-like structure)
* **Database:** MySQL
* **Mailing:** PHPMailer
* **Frontend:** HTML, CSS
* **Server:** Apache (Raspberry Pi environment)

---

## 📁 Project Structure

```
/project-root
│── /view                #View + Travel2Gather API
│── /controller          # Controllers
│── /model               # Database & business logic
│── /lang                # Translation files
│── /vendor              # Composer dependencies
│── composer.json
│── composer.lock
```

---

## ⚙️ Installation

### 1. Clone the repository

```
git clone https://github.com/yourusername/your-repo.git
cd your-repo
```

---

### 2. Install dependencies

```
composer install
```

---

### 3. Server setup

* Set Apache **DocumentRoot** to `/public`
* PHP version **8.0+ recommended**

---

## 🔐 Security

* Sensitive data is **not stored in the repository**
* Databese host name, port, db name, db password, db username, mail password and API keys from Travel2Gather are NOT included.
* Input validation is applied on critical operations

---

## 📧 Email Verification Flow

1. User registers
2. Token is generated and stored
3. Verification email is sent
4. User confirms via link
5. Account is activated

---

## 🧪 Development Notes

* Follows a modular, MVC-inspired structure
* Designed for extensibility and maintainability
* Can be extended with REST APIs or external services

---

## 📌 Roadmap

* 📱 Mobile application integration
* 📊 Data visualization dashboards
* 🔔 Push notification system
* 🌍 Extended internationalization

---

## 👤 Author

Personal hobby project under continuous development.

---

## ⚠️ Disclaimer

This project is intended for educational and personal use.
Before deploying in production, additional security hardening and scalability improvements are recommended.
