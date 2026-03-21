# Executive Summary

**What this project is**: NJ Car Rentals — a Laravel-based web application that manages car rentals, buy-and-sell listings, customer inquiries, and GPS tracking for fleet monitoring.

**Goal**: Deliver a professional, dark monochrome UI with product-focused pages, implement core backend modules (messages, GPS ingestion, transactions), and provide a clear local developer setup and checklist for verification.

**Next steps for developers**: Run the local setup (see Getting Started), ensure the database is available (SQLite is recommended for quick local setup), and run `npm install` and `npm run build` to produce front-end assets (Windows users may need to adjust PowerShell execution policy; network issues may require alternate networking or mirrors).

---

## Table of Contents

- Executive Summary
- Getting Started
- Actionable Checklist
- Project Scope
- System Modules
- Data Schema / Migrations
- API Endpoints
- Limitations

---

## Getting Started

Quick local setup (recommended):

1. Run `composer setup` (recommended; automates Composer install, `.env` copy, `key:generate`, `migrate`).
2. If doing steps manually:
   - Copy `.env.example` -> `.env` and run `php artisan key:generate`.
   - Create SQLite DB: `php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"`
   - Run `php artisan migrate` and `php artisan db:seed --class=NJCarRentalsSeeder`.
3. Install front-end dependencies and build assets: `npm install` then `npm run build` (or `npm run dev` while developing).
4. Start the app: `composer dev` (recommended) or `php artisan serve`.
5. Run tests: `composer test` or `php artisan test`.

---

## Actionable Checklist (high priority)

- [ ] Resolve DB connection (choose SQLite for quick local dev or fix/start MySQL).
- [ ] Run `php artisan migrate` and `php artisan db:seed` to populate demo data.
- [ ] Run `npm install` and `npm run build`; if blocked, use the existing `public/css/dark-fallback.css` until assets are built.
- [ ] Add sample seeds for messages and GPS positions (for manual and integration testing).
- [ ] Verify UI pages (home, vehicles, rental) for accessibility and proper contrast; add ARIA attributes and keyboard focus states.
- [ ] Add tests for the new API endpoints (messages, gps, transactions) and migrations.
- [ ] Remove `public/css/dark-fallback.css` when final build artifacts are in place.

---

Chapter 1
    Introduction
Digital systems continue to transform how businesses manage their services and connect with customers. One of the industries that benefits greatly from digitalization is transportation, particularly car rental services. A web-based platform allows customers to view available vehicles and make inquiries more efficiently than the old way like walk-in or through text messaging transactions (Garcia & Mendoza, 2022). This way also helps businesses organize records, reduce manual error, and provide more efficient and convenient service. (Clemente & Santos, 2020). 
In cities like Olongapo, car rentals remain as a convenient option for residents, workers, and especially for visitors. However, many local businesses like AS Rent a Car still rely on manual processes such as written logs, Facebook messenger messages, and phone calls. These methods are often prone to miscommunication, and booking conflicts (Reyes & Bautista, 2021). Customers from nearby areas like Zambales, Bataan, and Pampanga also lack direct access to updated rental information. 
This study proposes a web-based car rental and buy-and-sell system designed to digitalize the operations of NJ Car Rentals. In addition to improving reservation and transaction management, the integration of the Global Positioning System (GPS) tracking feature further enhances the security of NJ car rental operations. It allows NJ Car Rentals to monitor vehicle locations in real time, helping ensure proper vehicle usage, improve fleet management and enhance customer safety. For NJ Car Rentals, incorporating GPS tracking can assist the owner in tracking rented vehicles, reducing the risk of misuse or loss, and providing more accurate information regarding vehicle availability. This feature also supports operational transparency and builds customers' trust by promoting safer and a more reliable rental service (Villanueva, 2023).
1.1 Background of the Study
Car rental services have become essential for people who need temporary transportation for travel, work or personal use. In places like Olongapo City, where mostly both locals and visitors rely on rental cars for their convenience, the need for a less hassle and organized transaction process continues to grow. NJ Car Rentals, a small but growing business around Olongapo City, currently manages their services though old ways like, such as phone calls, text messages and walk-ins.
While doing this setup, it sometimes leads to delays, miscommunication, and difficulty keeping track of records specially when clients come from nearby places such as Zambales, Bataan and Pampanga. With more customers preferring online convenience, the need for a digital platform becomes more apparent. 
This study aims to develop a web-based system that allows NJ Car Rentals to manage car rentals and car buy-and-sell transactions through a user-friendly website. By shifting to digital processes, the business can offer more flexible access, faster transactions, and better management of records.
The idea for this study came from the need to digitalize the business and improve its operation. A web-based platform can help the owner easily manage their listings, organize rental schedules, and make the service more accessible for the people outside Olongapo City (Clemente & Santos, 2020).

1.2 Statement of the Problem
1.2.1 General Problem
Currently, NJ Car Rentals lacks a centralized digital system to manage rental and buy-and-sell transactions efficiently. As a result, transaction records, inventory monitoring, and customer information are handled manually or through disconnected processes, increasing the risk of errors, delays, and data inconsistency. This limitation affects operational efficiency, customer service quality, and decision-making within the business. 

1.2.2 Specific Problem
i.	NJ Car Rentals experience difficulty in effectively monitoring vehicle availability due to the continued use of manual processing and record-keeping systems, which are often inaccurate, outdated, and prone to human error.
ii.	The business lacks a dedicated online platform that allows customers to easily access updated information on vehicles available for rent and for sale, limiting accessibility for clients from neighboring provinces such as Zambales, Bataan, and Pampanga.
iii.	Customer inquiries, reservations, and complaints are often delayed and disorganized because they are processed through multiple communication channels, including phone calls, text messages, and social media platforms.
iv.	Manual handling of reservations and transaction records increases the likelihood of double bookings, data inconsistencies, and loss of important customer and financial information.
v.	The absence of a GPS tracking system limits the business owner’s ability to monitor rented vehicles in real time, making the business vulnerable to vehicle misuse, theft, delayed returns, and safety-related concerns.




1.3 Objectives of the Study
1.3.1 General Objective
The objective of this study is designed to address the operational challenges faced by AS Car Rentals and ensure the development of a web-based car rental, buy and sell, and GPS tracking system that improves efficiency, accessibility, and customer satisfaction from Olongapo city and neighboring cities.
  	

1.3.2 Specific Objectives
Specifically, this study aims to:
i.	Design and develop an administrative dashboard integrated with a GPS tracking system to enable the business owner to efficiently monitor vehicle availability and track rented vehicles in real time.
ii.	Develop a user-friendly website that allows customers to conveniently view updated listings of vehicles available for rental and for sale.
iii.	Create an automated digital system for managing customer inquiries and reservations to ensure faster, more organized, and more efficient transactions.
iv.	Implement a centralized digital record system that minimizes reservation conflicts, improves data accuracy, and ensures secure storage of customer and transaction information.
v.	Integrate a GPS tracking feature that enhances operational security and customer safety by enabling real-time monitoring of rented vehicles.



1.4 Significance of the Study
This web-based system aims to help customers make reservations, inquiries and view cars for rent and buy-and-sell to minimize inconsistent response and fast transactions. This study benefits the following:

i.	NJ Car Rentals - The system will enhance operational efficiency by digitalizing transactions, organizing records, and enabling faster responses to customers inquiries. The GPS tracking feature will allow the business owner to monitor rented vehicles in real time, reducing the risks of misuse or loss, improving fleet management, and ensuring more accurate vehicle availability. Overall, the system will help the business operate more effectively and it provides a higher quality of services to its customers.

ii.	Customers – Users can conveniently browse available vehicles, make a reservation online, and submit inquiries without needing to visit the rental office. The GPS enabled tracking system ensures that rented vehicles are properly monitored, which promotes customers safety and increases confidence in the reliability of the service. By providing easy access to rental and buy and sell records, the system reduces delays and inconsistent responses, making the overall rental experience faster and more convenient.

iii.	Business Owner/Admin – The administrative dashboard allows the owner to manage the vehicle listings, rental schedules, customer records, and buy and sell transactions efficiently. GPS monitoring provides valuable insights for operational decision-making, helps prevent unauthorized use of vehicles, and improves overall management of the fleet. This helps to reduce the administrative burden of manual tracking and enables the business to maintain better control over its operations.

iv.	Future Research – This project may serve as a reference for the future studies on digital business solutions, web-based rental systems, and GPS enabled management tools. Researchers can analyse the system’s implementation, study its benefits in small business contexts or use it as a model for developing a similar application in other industries.

v.	Local Community – The system promotes digital transformation and supports the growth of small businesses in Olongapo City. By improving the safety, efficiency, and accessibility of car rental services, its enterprises contribute to a broader goal of modernizing service oriented business in the community.

1.5 Scope and Limitations
1.5.1 Scope
This study focuses on the development of a web-based car rental, buy and sell, and GPS tracking system for NJ Car Rentals, a small business. The system is intended to digitalize and streamline the business’s existing processes, which currently rely on manual and semi-digital methods such as text messaging, phone calls, and walk-ins. By introducing an integrated online platform. The study aims to enhance the transaction efficiency, improve customer experience, and strengthen vehicle monitoring through GPS based features.

The system covers the following user roles:

i.	Admin. Admin has the highest level of authority within the platform, The admins manage all core business operations, including vehicle listings, rental scheduling, buy and sell postings, customer records, and transaction history. The admin can also add, update, or remove vehicles, oversee staff activity, and access detailed reporting to monitor the overall performance of the platform. The admin is also responsible for managing user accounts and ensuring that the platform remains organized, secure, and up to date.

ii.	Staff. Staff members serve as intermediaries between the customers and the admin. Their main responsibility is to handle customer related operations such as receiving reservation requests, responding to customer inquiries, and assisting in the use of the chatbox module. The staff ensure that all customer interactions are properly documented in the system and processed accurately and efficiently. While they have access to important customer and transaction records, their permissions are limited, they cannot modify system wide settings, manage the entire inventory, or access the confidential records.

iii.	Customer. Customer is the primary end user of the system, typically individuals who want to rent or purchase a vehicle from NJ Car Rentals. Customers can use the platform to browse available cars, check details such as pricing and availability and make informed decisions before renting or buying. They can create personal accounts, manage their profile information, and track their reservation or inquiry status. Through the system’s user-friendly interface chatbox feature, their customer can conveniently communicate with the staff, ask questions, and receive timely assistance without the need for walk-ins or phone calls.

iv.	Guest. Guest users are individuals who access the platform without creating an account. They are provided with limited system privileges but can still explore essential features of the website. Guest users can browse available cars for rent or sale, view general vehicle information, and explore the platform’s interface to familiarize themselves with NJ Car Rental’s offerings. However, they cannot submit reservation requests, send inquiries or access personalized features until they register and login.
System Modules
The proposed web-based system for NJ Car Rentals consists of several key modules designed to enhance user experience, improve operational efficiency, and support digitalized car rental, buy-and-sell, and vehicle monitoring processes.
i.	Admin Account Modules
●	Login Module. Provides secure access to the administrative dashboard by requiring valid credentials, ensuring that only authorized personnel can manage sensitive business data.
●	Admin Dashboard Module. Serves as the central control panel displaying active rentals, pending reservations, vehicle availability, inquiry notifications, booking alerts, and GPS tracking summaries.
●	Vehicle Management Module. Allows the Admin to add, update, and remove vehicles for rent or sale, manage vehicle details, upload images, and update availability status.
●	Rental Schedule Management Module. Enables monitoring of upcoming, ongoing, and completed rentals, detection of scheduling conflicts, and adjustment of rental periods.
●	Buy-and-Sell Management Module. Handles vehicle sales listings, pricing updates, reservation status, and monitoring of customer inquiries related to vehicle purchases.
●	Customer Records Module. Stores and organizes customer profiles, rental history, inquiry logs, and buy-and-sell transaction records.
●	Transaction History Module. Maintains a complete record of all system transactions, including reservations, inquiries, and completed rental or sales records.
●	GPS Tracking Module. Allows real-time monitoring of rented vehicles to enhance security, prevent unauthorized use, and improve fleet management.
ii.	 Customer Account Modules
●	Login Module. Provides secure access for staff members using assigned credentials.
●	Staff Dashboard Module. Displays incoming inquiries, pending reservations, and customer concerns requiring action.
●	Inquiry and Communication Module (Chatbox). Facilitates direct communication between staff and customers for inquiries, updates, and follow-ups.
●	Reservation Monitoring Module. Allows staff to view and organize reservation requests and forward them to the Admin for approval.
●	Customer Interaction Log Module. Records all customer inquiries and staff responses to ensure transparency and service consistency.
iii.	Customer Account Modules
●	Login Module. Allows customers to securely access their accounts.
●	Sign-Up Module. Enables account creation using basic personal information.
●	Homepage Module. Displays announcements, featured vehicles, navigation menus, and summaries of active transactions.
●	Car Rental Module. Allows browsing of rental vehicles with filtering, search, and reservation request features.
●	Buy-and-Sell Module. Displays vehicles available for purchase with complete details and inquiry options.
●	Inquiry Module (Chatbox). Allows customers to communicate directly with staff.
●	User Account Module. Enables customers to update personal information and view transaction history.
iv.	Guest Modules 
●	Vehicle Viewing Module. Allows browsing of vehicles for rent or sale without login.
●	Vehicle Information Module. Displays detailed vehicle specifications and availability.
●	Registration Module. Allows guest users to create an account.
●	Login Module. Serves as the access point for registered users.
●	Information and Policy Viewer Module. Provides access to rental policies, terms and conditions, and FAQs.
●	Promotions and Announcements Module. Displays public promotions, discounts, and announcements.
●	Navigation and Search Module. Supports browsing through search and sorting features.
1.5.2 Limitations
The study is subject to the following limitations:
i.	The system will not include online payment processing during the initial development phase. Payment transactions will be handled manually outside the system.
ii.	The system is web-based only and does not include a dedicated mobile application for Android or iOS platforms.