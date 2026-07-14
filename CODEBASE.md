# CODEBASE.md — credit-union-2-0-llc/laravel-azure-ad-oauth

## Purpose
Provides a Laravel Socialite driver for Azure Active Directory authentication. It enables Single Sign-On (SSO) by handling OAuth flows, user creation, and role mapping within Laravel applications.

## Stack
PHP, Laravel Framework, Laravel Socialite. Key libraries include `metro/gistics/laravel-azure-ad-oauth` for the provider logic and facade integration. Requires a standard PHP web server runtime.

## Entry Points
Run `composer require metrogistics/laravel-azure-ad-oauth` to install. Use `php artisan vendor publish` to configure defaults. Access the login flow via the `/login/microsoft` route (configurable) or trigger programmatically via Socialite.

## Key Directories
Root contains standard Laravel package structure. `src/` holds the ServiceProvider, AzureUserFacade, and UserFactory logic. `config/` stores publishable configuration for client IDs, secrets, and user field mappings.

## External Dependencies
Microsoft Azure Active Directory (Entra ID) for identity provider services. Requires a configured Azure App Registration with valid Client ID, Secret, and Reply URLs. Depends on Laravel's built-in authentication system and database for user storage.

## Development Status
Active integration package. Supports Laravel 5.5+ via auto-discovery. Core SSO functionality is stable; role mapping and custom user callbacks are active features requiring manual configuration in the Azure portal and app service providers.

## Gotchas
The `password` column in the users table must be nullable. A 36-character `VARCHAR` field (default `azure_id`) is required to store the Azure AD object ID. Secrets must be set to "Never Expires" during Azure App Registration setup. User assignment is mandatory in Azure properties for sign-in to work.