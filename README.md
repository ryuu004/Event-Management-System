# Event Management System

A PHP-based event management system with MVC architecture that allows organizers to create and manage events, and participants to register for events.

## Features

- User Authentication (Organizer and Participant roles)
- Event Creation and Management
- Event Registration with Ticket Generation
- Event Participant Management
- Role-based Access Control

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Composer
- Apache/Nginx web server

## Installation

1. Clone the repository:

```bash
git clone <repository-url>
cd event-management-system
```

2. Install dependencies:

```bash
composer install
```

3. Create a MySQL database and import the schema:

```bash
mysql -u your_username -p your_database_name < database/schema.sql
```

4. Copy the environment file and configure it:

```bash
cp .env.example .env
```

Edit the `.env` file with your database credentials and JWT secret.

5. Configure your web server to point to the project's root directory.

## API Endpoints

### Authentication

- POST /auth/register - Register a new user
- POST /auth/login - Login user
- POST /auth/logout - Logout user

### Events

- GET /events - List all published events
- POST /events/create - Create a new event (Organizer only)
- POST /events/update/{id} - Update an event (Organizer only)
- DELETE /events/delete/{id} - Delete an event (Organizer only)
- POST /events/register/{id} - Register for an event (Participant only)
- GET /events/my-events - View user's events
- GET /events/participants/{id} - View event participants (Organizer only)

## Database Structure

### Users Table

- id (Primary Key)
- username
- email
- password
- role (organizer/participant)
- created_at

### Events Table

- id (Primary Key)
- title
- description
- venue
- event_date
- start_time
- end_time
- capacity
- price
- organizer_id (Foreign Key)
- status (draft/published)
- created_at

### Event Registrations Table

- id (Primary Key)
- event_id (Foreign Key)
- participant_id (Foreign Key)
- ticket_code
- status (active/cancelled)
- created_at

## Security Features

- Password Hashing
- JWT-based Authentication
- Role-based Authorization
- Input Validation
- CORS Protection

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a new Pull Request
