# livewire-trello

A Laravel application with Trello-like task management for member users.

## Features

- **Task Boards**: Create multiple project boards with custom colors
- **Task Lists**: Organize tasks in columns (To Do, In Progress, Done)  
- **Tasks**: Create tasks with title, description, priority, and due dates
- **Drag & Drop**: Move tasks between lists and reorder positions
- **User Management**: Role-based access (member/admin users)

## Quick Start

```bash
# Setup
cp .env.example .env
php artisan key:generate
php artisan migrate

# Development
composer run dev    # Start all services (server + assets)
```

## Usage

1. Register and login as a member user
2. Navigate to `/member/boards` 
3. Create your first board
4. Add task lists (columns)
5. Create tasks and drag them between lists

## Stack

- Laravel 12.0
- Livewire 3.6.4  
- TailwindCSS 4.0
- SortableJS
- SQLite

## Commands

```bash
php artisan serve          # Laravel server
npm run dev               # Vite dev server  
php artisan test          # Run tests
vendor/bin/pint           # Code formatting
```