# 🎓 Event Management System

A web-based **Event Management System** designed to organize, manage, and streamline university events and activities. The platform provides facilities for event publishing, student registration, faculty event requests, club management, speaker information, attendance tracking, notifications, and communication.

The system aims to simplify event coordination and improve interaction between students, faculty members, event organizers, and administrators through a centralized web platform.

---

## 🚀 Project Overview

The Event Management System provides a digital platform for managing university events and related activities.

It supports event administration, participant registration, faculty involvement, club activities, event schedules, and communication services.

## ✨ Key Features

### 📅 Event Management
- View available university events
- Browse event details
- Add and manage events
- Delete and update event information
- View individual event information
- Manage event schedules

### 📝 Event Registration
- Register for university events
- Manage event registrations
- View registered participants
- Manage registration information

### 👨‍🏫 Faculty Management
- Faculty information management
- Faculty event requests
- Review and manage faculty event requests

### 🏛️ Club Management
- Browse available university clubs
- View club information
- Join university clubs
- Manage club-related information

### 🎤 Speaker Management
- Manage speaker information
- Display event speakers
- Organize speaker-related details

### 📊 Attendance Management
- Retrieve event information
- Retrieve attendance information
- Support event attendance tracking

### 🔔 Notification System
- User notifications
- View notification details
- Manage notification records
- Delete notifications

### 💬 Communication and Support
- AI chatbot interface
- FAQ section
- Live chat functionality
- Contact page
- User feedback system

### 📰 Additional Modules
- University event blog
- About page
- User login and logout
- Administrative management

---

## 🛠️ Technologies Used

| Technology | Purpose |
|---|---|
| PHP | Backend development |
| MySQL | Database management |
| HTML5 | Web page structure |
| CSS3 | Styling and responsive design |
| JavaScript | Frontend interactions |
| Bootstrap | UI components and layout |
| jQuery | Frontend functionality |
| PHPMailer | Email functionality |
| XAMPP | Local development environment |
| Python | Additional utility scripts |

---

## 📁 Project Structure

```text
Event-Management-System/
│
├── images/
│
├── js/
│
├── PHPMailer-master/
│
├── uploads/
│
├── All_event.php
├── home.php
├── web.php
├── about.php
├── blog.php
├── contact.php
│
├── login.php
├── login_dp.php
├── logout_db.php
│
├── admin.php
├── admin_action.php
├── admin_add_event.php
├── admin_reports.php
├── admin_users_add.php
├── admin_view_req.php
│
├── event_add_delete.php
├── event_registrations.php
├── reg_even.php
├── registrastion.php
├── schedule.php
├── speakers.php
│
├── faculty.php
├── faculty_event_req.php
│
├── avaliable_club.php
├── club_name.php
├── join_club.php
│
├── chatbot.js
├── chatbot.php
├── chatbot.css
│
├── faqchat.js
├── faqchat.php
├── faqchat_db.php
├── faqpre_db.php
│
├── livechat.php
├── livechat_db.php
├── livechat.css
│
├── notifications.php
├── notification_view.php
├── notification_user.php
├── notifications_db.php
│
├── feedback.php
├── feedback_db.php
│
├── db.php
├── style.css
└── README.md
```

*The structure above highlights the main files and folders; additional CSS, PHP, JavaScript, and utility files are included in the repository.*

---

## ⚙️ Installation and Setup

Follow these steps to run the project locally.

### 1. Install XAMPP

Download XAMPP:

https://www.apachefriends.org/

Start the following services:

- Apache
- MySQL

### 2. Clone the Repository

Open your terminal and execute:

```bash
git clone https://github.com/mdOmerfaruq/Event-Management-System.git
```

### 3. Move the Project

Place the project folder inside:

```text
C:\xampp\htdocs\
```

Project directory:

```text
C:\xampp\htdocs\event_management_system
```

### 4. Configure the Database

1. Open phpMyAdmin.
2. Visit http://localhost/phpmyadmin
3. Create the database required by the application.
4. Configure the database connection in `db.php`.
5. Import the database SQL backup if provided.

### 5. Configure Email Functionality

The project includes PHPMailer for email-related functionality.

Configure the SMTP settings using your own email service credentials. Keep passwords and other private credentials outside the public repository.

### 6. Run the Application

Open your browser and visit:

```text
http://localhost/event_management_system/
```

---

## 🎯 Project Objectives

- Simplify university event management.
- Provide an organized event registration process.
- Improve communication between students and faculty.
- Support university club activities.
- Manage event schedules and attendance.
- Improve event-related notifications.
- Provide centralized administrative control.

---

## 🔮 Future Improvements

- Improved role-based access control
- Advanced event analytics and reporting
- QR code-based attendance management
- Automated email notifications
- Online event registration confirmation
- Enhanced chatbot integration
- Improved mobile responsiveness
- Secure payment integration for paid events

---

## 🔐 Security Notes

- Never publish API keys, database passwords, or SMTP credentials.
- Keep private configuration files out of GitHub.
- Use prepared statements for database queries.
- Apply secure authentication and session management.
- Keep third-party API credentials on the PHP backend.
- Configure access restrictions for administrative modules.

---

## 👨‍💻 Developer

**Md. Omer Faruq**

BSc in Computer Science & Engineering  
Major in Software Engineering  
United International University (UIU), Bangladesh

**GitHub:** https://github.com/mdOmerfaruq

**Repository:** https://github.com/mdOmerfaruq/Event-Management-System

---

## 📄 License

This project is developed for educational and academic purposes. Please contact the developer before redistribution or commercial use.
