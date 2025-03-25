# Blog Management System

**Assignment:** Blog Management System (Mini Project)

## Features

-   **User Authentication & Profile**
    -   Users can register and login to access the full functionality. (JWT/Session)
    -   Each user will have a unique username.
    -   Users can upload a profile picture; if not uploaded, a default image will be used.
    -   Guests can only view public posts but cannot comment or post.
-   **Post Management**
    -   Users can create, edit, and delete their posts.
    -   Posts can contain images along with text content.
    -   Posts will be sorted in descending order (latest first).
    -   Users can set the visibility of posts:
        -   Public → Visible to everyone (including guests).
        -   Private → Visible only to the post owner.
-   **Tags & Search System**
    -   Posts can be tagged for better categorization.
    -   Users can search posts by:
        -   Title
        -   Content
        -   Tags
        -   Username
-   **Real-Time Comment System**
    -   Users can comment on any public post.
    -   Real-time comments update using Pusher.
    -   Users can reply to comments (nested comments supported).
    -   The post owner can delete comments on their posts.
-   **Like & Unlike System**
    -   Users can like or unlike posts with a single button.
    -   The like count updates in real-time using Pusher.
-   **Bookmark System (Save for Later)**
    -   Users can bookmark posts to view later.
-   **Real-Time Notification System**
    -   Users receive real-time notifications when:
        -   Someone likes their post.
        -   Someone comments on their post.
        -   Someone replies to their comment.
    -   Vue 3-based Toast Notification system for a smooth user experience.

## Database Design

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
    -   `user_id` (References users (id)) - cascade on delete
    -   `title`
    -   `content` (text)
    -   `image` (nullable)
    -   `visibility` (enum[public, private])
    -   `created_at`
    -   `updated_at`

-   **Tags Table (tags)**

    -   `id`
    -   `name` (unique)
    -   `created_at`
    -   `updated_at`

-   **Post Tags Table (post_tag)**

    -   `id`
    -   `post_id` (References posts (id)) - cascade on delete
    -   `tag_id` (References tags(id)) - cascade on delete
    -   `created_at`
    -   `updated_at`

-   **Comments Table (comments)**

    -   `id`
    -   `user_id` (References users (id)) - cascade on delete
    -   `post_id` (References posts (id)) - cascade on delete
    -   `parent_id` (nullable(For nested comments))
    -   `content` (text)
    -   `created_at`
    -   `updated_at`

-   **Likes Table (likes)**

    -   `id`
    -   `user_id` (References users (id)) - cascade on delete
    -   `post_id` (References posts (id)) – cascade on delete
    -   `Created_at`

-   **Bookmarks Table (bookmarks)**

    -   `id`
    -   `user_id` (References users (id)) - cascade on delete
    -   `post_id` (References posts (id)) – cascade on delete
    -   `created_at`

-   **Notifications Table (notifications)**
    -   `id`
    -   `user_id` (References users (id)) - cascade on delete
    -   `type` (enum[like, comment, reply])
    -   `message` (text)
    -   `created_at`
    -   `read_at` (nullable)

## Project Presentation Video

[Link to your Google Drive video presentation here]

## Database SQL File

[Database SQL File name, example: database.sql]
