# Barangay Bulletin - Purok Civiles (Lab Activity 11)

A community bulletin web application for Barangay Matina Crossing (Purok Civiles) built with Laravel, Eloquent ORM relationships, eager loading, and Form Request validation.

## Seeded Accounts

All seeded accounts use the password: `bulletin2026`

| Role | Name | Email | Permissions |
| :--- | :--- | :--- | :--- |
| **Kagawad (Author)** | Kagawad Christian Civiles | `kagawad.civiles@bulletin.test` | Can create posts and comment on posts |
| **Resident** | Lola Civiles | `lola.civiles@bulletin.test` | Can view posts and post comments (403 on post creation) |

## Purok Civiles Tags

1. `Purok Civiles`
2. `Urgent`
3. `Libre`
4. `Schedule`
5. `Bayanihan`

## Eloquent Relationship Architecture

* **User ↔ Author (`hasOne` / `belongsTo`)**: Separates authentication accounts (`users`) from official Barangay writer profiles (`authors`). `authors.user_id` is nullable and unique so regular residents can log in without having author privileges.
* **Author → Post (`hasMany` / `belongsTo`)**: One Kagawad author publishes many bulletin posts, linked via `posts.author_id`.
* **Post ↔ Comment & User ↔ Comment (`hasMany` / `belongsTo`)**: Each comment belongs to one specific post (`comments.post_id`) and one logged-in user (`comments.user_id`), while posts and users each own many comments.
* **Post ↔ Tag (`belongsToMany`)**: Posts can have multiple tags and each tag can categorize multiple posts, resolved cleanly through the `post_tag` pivot table with a composite primary key.
* **Author → Comment (`hasManyThrough`)**: Aggregates all comments received across an author's posts via the intermediate `posts` table, eliminating any need for a redundant `author_id` column on `comments`.

## How to Run Locally

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
npm install
npm run dev
php artisan serve