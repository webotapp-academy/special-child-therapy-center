# Aura SpecialCare - Special Child Care & Autism Academy Management System

An open-source, specialized school management and clinical therapy tracking system built with **Laravel** for special education needs (SEN) centers, autism academies, child development clinics, and therapeutic day schools.

---

## 🌟 Key Features & Workflow

### 1. Step 1: Enquiry & Lead Screening Pipeline
- Register walk-ins, phone inquiries, and pediatrician referrals.
- **Autism & Developmental Red Flags Checklist:** Speech delay, lack of eye contact, repetitive stimming, toe walking, sensory aversions, meltdowns in crowds, hyperactivity.
- **Clinical Scheduling:** Book diagnostic evaluation appointments with clinical specialists.

### 2. Step 2: Clinical Diagnostic Assessment (CARS & ISAA)
- **Childhood Autism Rating Scale (CARS-2):** Standardized 15–60 score calculator with automated severity classification:
  - *Non-Autistic* (< 30)
  - *Mild-to-Moderate Autism* (30 – 36.5)
  - *Severe Autism* (37 – 60)
- **ISAA (Indian Scale for Assessment of Autism)** score tracking.
- **Clinical Domain Baselines:** Speech & language baseline (PECS readiness), fine/gross motor evaluation, and sensory profile matrix (Auditory, Visual, Tactile, Vestibular, Proprioceptive).
- **One-Click Enrollment:** Instantly converts completed diagnostic assessments into enrolled student profiles.

### 3. Step 3: Student Admission & 360° Special Profile
- **Accommodations Profile:** Classroom batch, shadow aide allocation, known sensory triggers, calming kit (weighted vest, hammock swing, silicone teether), comfort items, and dietary texture preferences.
- **IEP Management:** Target SMART goals across Speech & Communication, Occupational & Sensory, Social & Play, Behavioral Regulation, and Life Skills (ADL) with measurable sub-milestones.
- **Therapy SOAP Logs:** Clinical session notes (Subjective, Objective, Assessment, Plan) for Speech Therapy, OT, and ABA.
- **Daily Care Routine Sheets:** Tracks meals eaten, potty training progress, naps, and mood check-ins.

### 4. Step 4: Dedicated Parent Progress Portal
- **Strict Privacy Isolation:** Parents can only see their own verified child's records.
- **Live Developmental Mastery Bars:** Visual progress tracking across Speech, Motor, Social, and Life Skills.
- **Daily Care Transparency:** Real-time visibility into child's meal intake, nap duration, mood ratings, and educator notes.
- **Therapist Highlights & Home Practice:** Daily therapy praise and home reinforcement exercises for parents.
- **Printable Progress Card:** Instant export for parents and pediatricians.

---

## 🔐 Pre-Configured Demo Logins

| Role | Email | Password | Access / View |
| :--- | :--- | :--- | :--- |
| **Administrator** | `admin@specialcare.com` | `password` | Full school administration, admissions, enquiries, staff management |
| **Therapist** | `priya@specialcare.com` | `password` | Clinical diagnostics, CARS/ISAA assessments, IEP goals, session logs |
| **Parent** | `parent@specialcare.com` | `password` | Dedicated Parent Progress Portal (strictly for child *Aarav Gupta*) |

---

## 🚀 Quick Start & Installation

### Prerequisites
- PHP >= 8.2
- Composer
- MySQL (e.g. via local XAMPP on port 3306)

### 1. Clone the Repository
```bash
git clone https://github.com/webotapp-academy/special-child-therapy-center.git
cd special-child-therapy-center
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Environment Configuration
```bash
cp .env.example .env
php artisan key:generate
```

Configure your MySQL connection in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=special
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Run Migrations & Seed Database
```bash
php artisan migrate --seed
```

### 5. Launch the Application
```bash
php artisan serve
```
Open **`http://127.0.0.1:8000`** (or access via XAMPP at `http://localhost/special/public`).

---

## 🛠️ Tech Stack
- **Backend:** Laravel 11/12 (PHP 8.2+)
- **Database:** MySQL
- **Frontend:** Tailwind CSS, Alpine.js, Plus Jakarta Sans Typography
- **Architecture:** Clean MVC with Role-Based Access Control (RBAC)

---

## 📄 License
This project is open-source and available under the [MIT License](LICENSE).
