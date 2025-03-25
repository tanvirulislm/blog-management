# 🚀 Blog Management System 📝

**Assignment:** Blog Management System (Mini Project)

---

## ✨ Features

-   **👤 User Authentication & Profiles**
    -   Secure registration and login with JWT/Session.
    -   Unique usernames for all users.
    -   Profile picture uploads (default image fallback).
    -   Guest viewing of public posts (limited access).
-   **✍️ Post Management**
    -   Create, edit, and delete personal posts.
    -   Rich post content with images.
    -   Chronological post display (latest first).
    -   Post visibility control (public/private).
-   **🏷️ Tags & 🔍 Search System**
    -   Tag posts for easy categorization.
    -   Powerful search by title, content, tags, and username.
-   **💬 Real-Time Comment System**
    -   Interactive comments on public posts.
    -   Live comment updates with Pusher.
    -   Nested comment replies for rich discussions.
    -   Post owner comment deletion.
-   **❤️ Like & Unlike System**
    -   One-click like/unlike functionality.
    -   Real-time like count updates via Pusher.
-   **🔖 Bookmark System (Save for Later)**
    -   Save posts for later viewing.
-   **🔔 Real-Time Notification System**
    -   Instant notifications for likes, comments, and replies.
    -   Smooth Vue 3 toast notifications.

---

## 📊 Database Design

-   **Users Table (users)**

    -   `id`
    -   `username` (unique)
    -   `email` (unique)
    -   `password`
    -   `profile_pic` (nullable)
    -   `created_at`
    -   `updated_at`

-   **Posts Table (posts)**

    -   `id`
    -   `user_id` (References users (id), CASCADE DELETE)
    -   `title`
    -   `content` (TEXT)
    -   `image` (nullable)
    -   `visibility` (ENUM: public, private)
    -   `created_at`
    -   `updated_at`

-   **Tags Table (tags)**

    -   `id`
    -   `name` (unique)
    -   `created_at`
    -   `updated_at`

-   **Post Tags Table (post_tag)**

    -   `id`
    -   `post_id` (References posts (id), CASCADE DELETE)
    -   `tag_id` (References tags (id), CASCADE DELETE)
    -   `created_at`
    -   `updated_at`

-   **Comments Table (comments)**

    -   `id`
    -   `user_id` (References users (id), CASCADE DELETE)
    -   `post_id` (References posts (id), CASCADE DELETE)
    -   `parent_id` (nullable, for nested comments)
    -   `content` (TEXT)
    -   `created_at`
    -   `updated_at`

-   **Likes Table (likes)**

    -   `id`
    -   `user_id` (References users (id), CASCADE DELETE)
    -   `post_id` (References posts (id), CASCADE DELETE)
    -   `created_at`

-   **Bookmarks Table (bookmarks)**

    -   `id`
    -   `user_id` (References users (id), CASCADE DELETE)
    -   `post_id` (References posts (id), CASCADE DELETE)
    -   `created_at`

-   **Notifications Table (notifications)**
    -   `id`
    -   `user_id` (References users (id), CASCADE DELETE)
    -   `type` (ENUM: like, comment, reply)
    -   `message` (TEXT)
    -   `created_at`
    -   `read_at` (nullable)

---

## 🎥 Project Presentation Video

[Link to your Google Drive video presentation here]

---

## 💾 Database SQL File

[Database SQL File name, example: `database.sql`]

---
