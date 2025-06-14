# Backend Roadmap - Laravel Systems

This repository contains three independent Laravel-based systems demonstrating different backend development patterns and architectural approaches. Each system showcases distinct authentication strategies, database technologies, and deployment methodologies.

## Table of Contents
- [Systems Overview](#systems-overview)
- [Repository Architecture](#repository-architecture)
- [Technology Stack](#technology-stack)
- [Authentication Patterns](#authentication-patterns)
- [Docker Deployment](#docker-deployment)
- [API Endpoints](#api-endpoints)
- [Development Environment](#development-environment)

## Systems Overview

### 1. Image Processing System
- **Port**: 8001
- **Database**: PostgreSQL
- **Authentication**: Laravel Sanctum
- **Purpose**: Advanced image manipulation with cloud storage integration

### 2. Movie Reservation System
- **Port**: 5432
- **Database**: PostgreSQL
- **Authentication**: Session-based
- **Purpose**: Reservation management platform

### 3. E-commerce API System
- **Port**: 8000
- **Database**: PostgreSQL
- **Authentication**: JWT tokens
- **Purpose**: Product catalog API

## Repository Architecture
backend_roadmap_compose_laravel/
├── image-processing/
├── movie-reservation-system/
├── api-ecomerce/
├── .env
├── Docker setup
├── vendor/
├── README.md
├── Dockerfile
└── Database migrations


Each system operates independently with its own:
- Codebase
- Database configuration
- Deployment setup

## Technology Stack

**Common to all systems:**
- Laravel Framework
- PHP Runtime
- Composer dependencies
- Docker containers
- PostgreSQL databases
- Artisan migrations

**System-specific technologies:**
- **Image Processing**: Laravel Sanctum
- **E-commerce API**: JWT Authentication
- **Movie Reservation**: Session Authentication

## Authentication Patterns

| System | Method | Key Components |
|--------|--------|----------------|
| Movie Reservation | Session | `SESSION_DRIVER=database`, `SESSION_CONNECTION=pgsql` |
| E-commerce API | JWT | Bearer Token, `/api/auth/login`, `/api/auth/register` |
| Image Processing | Laravel Sanctum | API Token, `personal_access_tokens` table |


## Development Environment

Common Laravel artifacts:

    Standard Laravel project structure

    .env* configuration files

    vendor/ (Composer dependencies)

    storage/ (File storage)

    Database migrations

Ignored files:

    .phpunit.cache

    IDE directories (.vscode/, .idea/, .fleet/)

    node_modules/

    public/build

    Environment configs

    Log files



This README provides a comprehensive overview while maintaining good structure and readability. You may want to:
1. Add installation instructions specific to each system
2. Include contribution guidelines
3. Add license information
4. Include screenshots or diagrams if available
5. Add system-specific documentation links