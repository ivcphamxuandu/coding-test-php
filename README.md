## Get Started

This guide will walk you through the steps needed to get this project up and running on your local machine.

### Prerequisites

Before you begin, ensure you have the following installed:

- Docker
- Docker Compose

### Building the Docker Environment

Build and start the containers:

```
docker-compose up -d --build
```

### Installing Dependencies

```
docker-compose exec app sh
composer install
```

### Database Setup

Set up the database:

```
bin/cake migrations migrate
```

---

### Accessing the Application

The application should now be accessible at http://localhost:34251

## How to check

### Authentication

TODO: pls summarize how to check "Authentication" bahavior

- Install plugin "cakephp/authentication": "^2.6"
- Config Application.php to load Authentication Plugin
  - Load identifiers, ensure we check email and password fields
  - Load the authenticators to get session first
  - Configure form data check to pick email and password
- Load component Authentication in AppController.php
        $this->loadComponent('Authentication.Authentication');
        $this->Authentication->addUnauthenticatedActions(['login']);
- Create login view in login.php and login action in UserController.php
### Article Management

TODO: pls summarize how to check "Article Management" bahavior
- Create Article with bake command to create Article Page with CRUD
- Create seed data for articles table
- Revise routes.php for article apis
- Revise CRUD function in ArticlesController.php to return json data (not yet)
- Authorization for every APIs (not yet)
### Like Feature

TODO: pls summarize how to check "Like Feature" bahavior
Create
- Create table user_article_likes
- Use bake to create Models UserArticleLike
- Add function like($id = null)  handle like button in article detail view
- Create route for this api