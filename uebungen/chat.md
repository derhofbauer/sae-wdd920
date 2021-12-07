# Chat System

+ Einzelchats
+ Gruppenchats

## Models / Tabellen

+ Chat
    + Name
    + image_path
+ User
    + status
    + last_activity_at
+ Message
    + user_id
    + text / content
    + chat_id
    + sent_at
+ chats_users_mm
    + chat_id
    + user_id
    + last_seen_at
    + mute_until?
    + is_admin?
+ Image
    + user_id
    + message_id
    + path
