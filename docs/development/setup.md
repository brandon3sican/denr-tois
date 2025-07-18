# Local Development Setup

## Prerequisites
- PHP 8.1 or higher
- Composer
- Node.js 16.x or higher
- MySQL 8.0 or higher
- Git

## Installation Steps

### 1. Clone the Repository
```bash
git clone https://github.com/brandon3sican/denr-tois.git
cd denr-tois
```

### 2. Install PHP Dependencies
```bash
composer install
```

### 3. Install NPM Dependencies
```bash
npm install
```

### 4. Environment Setup
1. Copy `.env.example` to `.env`
   ```bash
   cp .env.example .env
   ```
2. Generate application key
   ```bash
   php artisan key:generate
   ```
3. Configure your database settings in `.env`

### 5. Database Setup
1. Create a new MySQL database
2. Run migrations and seeders
   ```bash
   php artisan migrate --seed
   ```

### 6. Build Assets
```bash
npm run dev
# or for production
npm run build
```

### 7. Start the Development Server
```bash
php artisan serve
```

## Development Workflow

### Branching Strategy
- `main` - Production branch
- `develop` - Development branch
- `feature/*` - Feature branches
- `bugfix/*` - Bug fix branches

### Coding Standards
- PSR-12 coding style
- Follow Laravel best practices
- Write tests for new features
- Document complex logic

### Running Tests
```bash
php artisan test
```

### Debugging
- Xdebug is configured
- Debug bar is included
- Logs are stored in `storage/logs`

## Common Tasks

### Database Migrations
```bash
# Create new migration
php artisan make:migration create_table_name

# Run migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback
```

### Creating New Features
1. Create a new feature branch
2. Implement the feature
3. Write tests
4. Update documentation
5. Create a pull request

## IDE Configuration
- Recommended: PHPStorm or VSCode
- PHP CS Fixer configuration included
- EditorConfig for consistent coding styles

## Troubleshooting
- Clear configuration cache: `php artisan config:clear`
- Clear route cache: `php artisan route:clear`
- Clear view cache: `php artisan view:clear`
- Clear application cache: `php artisan cache:clear`
