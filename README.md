
# Localbrand.x Task


## Prerequisites

-   PHP 8.x or higher
-   Composer
-   MySQL or another database

## Steps to Set Up the Project

### 1. Clone the Project

Clone the repository:

`git clone https://github.com/elza3ym/localbrand-task.git`

### 2. Install Dependencies

Run the following to install project dependencies:

`composer install`

### 3. Configure Environment

Copy the environment file:


`cp .env.example .env`

Edit `.env` for database and queue settings:

-   **Database**:

```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_user
    DB_PASSWORD=your_database_password
```


### 4. Generate App Key

Generate the application key:
`php artisan key:generate`

### 5. Set Up Database

Create the database and run migrations:

`php artisan migrate:fresh --seed`

### 6. Start the Application

Run the Laravel server:
`php artisan serve`

Your app should now be available at `http://127.0.0.1:8000`.

## Running Queues

### 7. Run Queue Worker

To process queued jobs, run:
`php artisan queue:work`

This will start processing jobs that are pushed to the queue.

## API Endpoints

Below are the API endpoints available in the application, along with their respective headers and request details.

### Base URL
All API endpoints use the following base URL:
{{BASE_URL}}

Copy
Replace `{{BASE_URL}}` with your actual server URL (e.g., `http://127.0.0.1:8000`).

---

### 1. Authentication

#### Login
- **URL**: `{{BASE_URL}}/api/login`
- **Method**: `POST`
- **Headers**: None
- **Body** (raw JSON):
  ```json
  {
      "email": "test@test.com",
      "password": "test1234"
  }
Description: Authenticates a user and returns an access token.

### 2. Employee
####  Import Employees
- **URL**: `{{BASE_URL}}/api/employee`
- **Method**: `POST`
- **Headers**: `Authorization: Bearer <access_token>`

Replace <access_token> with the token received after login.

- **Body**: (form-data):
  - **key**:: file
  - **type**: file
  - **value**: Select a CSV file to upload (e.g., import.csv).
- **Description**: Imports employee data from a CSV file.

####  Get All Employees
- **URL**:  `{{BASE_URL}}/api/employee`
- **Method**: `GET`
- **Headers**: `Authorization: Bearer <access_token>`

Replace <access_token> with the token received after login.
- **Description**: Retrieves a list of all employees.

####  Get Employee by ID
- **URL**: `{{BASE_URL}}/api/employee/{id}`

Replace {id} with the employee's ID (e.g., 13272).

- **Method**: `GET`
- **Headers**: `Authorization: Bearer <access_token>`

Replace <access_token> with the token received after login.

- **Description**: Retrieves details of a specific employee by their ID.

#### Delete Employee
- **URL**: `{{BASE_URL}}/api/employee/{id}`

Replace {id} with the employee's ID (e.g., 13272).

- **Method**: `DELETE`
- **Headers**: `Authorization: Bearer <access_token>`

Replace <access_token> with the token received after login.

- **Description**: Deletes a specific employee by their ID.

#### Notes
- Replace ```{{BASE_URL}}``` with your actual server URL (e.g., http://127.0.0.1:8000).
- Ensure you have a valid access_token (received after login) for endpoints that require authentication.
- For the Import Employees endpoint, make sure the CSV file is properly formatted.


#### Thoughts
- Add Tests to the importer.
- Create new interface for Serializer for each input ( Date, Phone, Age... ).
