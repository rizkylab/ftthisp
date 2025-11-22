# FTTH Management System

## Overview
This Laravel based application manages Fiber‑to‑the‑Home (FTTH) infrastructure, including OLTs, ODPs, fiber cables, customers, and areas. It now includes dummy data for the **Bengkulu** area.

## Features
- CRUD for OLT, ODP, FiberCable, Customer, and Area models.
- Role‑based users (admin, technician).
- Database seeders that generate realistic random data for testing.
- New `areas` table with coordinates and province information.
- Comprehensive seeder (`AreaSeeder`) that inserts a dummy Bengkulu city record.

## Installation
1. **Clone the repository**
   ```bash
   git clone <repository‑url>
   cd ftth
   ```
2. **Install dependencies**
   ```bash
   composer install
   ```
3. **Copy environment file**
   ```bash
   cp .env.example .env
   ```
   Edit `.env` with your database credentials.
4. **Generate application key**
   ```bash
   php artisan key:generate
   ```
5. **Run migrations**
   ```bash
   php artisan migrate
   ```
6. **Seed the database** (includes the Bengkulu area)
   ```bash
   php artisan db:seed
   ```
7. **Start the development server**
   ```bash
   php artisan serve
   ```

## Database Structure
- **areas** – `id`, `name`, `province`, `coordinates` (JSON), timestamps.
- **olts** – OLT devices with coordinates and port information.
- **odps** – Optical Distribution Points linked to OLTs.
- **fiber_cables** – Connections between OLTs and ODPs.
- **customers** – End‑users linked to ODPs.
- **roles** & **users** – Authentication and authorization.

## Seeding
- `DatabaseSeeder` runs the following seeders in order:
  1. `RoleSeeder` (creates admin & technician roles)
  2. `UserSeeder` (creates admin & technician users)
  3. `OltSeeder`, `OdpSeeder`, `FiberCableSeeder` (random data)
  4. `CustomerSeeder` (random customers)
  5. **`AreaSeeder`** – adds a dummy Bengkulu city record.

## Contributing
1. Fork the repository.
2. Create a feature branch.
3. Ensure code follows PSR‑12 standards.
4. Submit a pull request.

## License
This project is licensed under the MIT License.
