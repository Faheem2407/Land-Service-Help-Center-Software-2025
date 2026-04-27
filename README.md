# 🌍 Land Service Assistance & Receipt Management System 

A complete real-life Laravel-based solution for generating digital receipts, managing land service centers, calculating processing charges, and automating land-service support operations.  
This system is actively used in production by land service centers in Bangladesh (Jamalpur Branch).

---

## 📌 Overview

This project provides an automated workflow for generating Bangla receipts, managing service-center details, user roles, fees, categories, and printing operations.  
It includes a print-optimized A4 receipt layout for land-related digital services, aligned with real governmental service standards.

Built using **Laravel**, this system features a robust backend, dynamic Blade views, and high-performance admin modules.

---

## ✨ Features

### 🧾 Dynamic Receipt Generation
- Bangla-language receipt template  
- Auto-print functionality  
- A4-optimized layout for physical receipts  
- Processing + online charge calculation  
- Dynamic receiver, category & service info  
- Custom center branding (name, logo, address, contact)

### 🏢 Service Center Management
- Manage center info (name, address, phone, mobile)  
- Center in-charge & helper assignment  
- Custom text fields for dynamic receipts  

### 👥 User Roles & Permissions
- Admin panel  
- Center in-charge  
- Helpers/staff  
- Customers  

### 🗂️ Service & Category Management
- Add/edit/delete land service categories  
- Auto-binding to receipts and reports  

### 💸 Fee & Charge System
- Processing charge  
- Online charge  
- Automatic total calculation  
- Display in Bangla number format  

### 📊 Admin Dashboard
- DataTables integration  
- Order management  
- Pending services  
- Delivery assignment system  

### 🖨️ Print Optimization
- Clean A4 layout  
- Exact color printing  
- Browser print-friendly CSS  
- Removes UI clutter for print media  

---

## 🛠️ Tech Stack

| Layer | Technology |
|-------|------------|
| **Backend** | Laravel 12+ |
| **Frontend** | Blade, HTML5, CSS3 |
| **Database** | MySQL |
| **Auth** | Laravel Breeze |
| **Others** | Yajra DataTables |
| **Server** | Ubuntu 22.04, Apache/Nginx |

A4 Bangla Receipt:

- ভূমিসেবা সহায়তা প্রদান বাবদ ফি গ্রহণের রশিদ  
- সেবা গ্রহীতার নাম  
- ভূমিসেবার নাম  
- প্রসেসিং চার্জ + অনলাইন চার্জ = মোট ফি  
- ইনচার্জের স্বাক্ষর ও কেন্দ্রের তথ্য  

This project includes a full HTML/CSS template optimized for printing:

```html
ভূমিসেবা সহায়তা প্রদান বাবদ ফি গ্রহণের রশিদ
সহায়তা কেন্দ্রের নাম, ঠিকানা, মোবাইল
সেবা গ্রহীতার নাম
ভূমিসেবার নাম
গৃহীত ফি: প্রসেসিং + অনলাইন চার্জ = মোট

👤 Author
Developer: MD.Abed Hasan Fahim
