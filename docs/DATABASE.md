# database

```mermaid
erDiagram
    USER ||--o{ WEBLOG : publishes
    USER ||--o{ COMMENT : publishes
    WEBLOG ||--o{ COMMENT : contains
    WEBLOG ||--o{ CATEGORY_WEBLOG : has
    CATEGORY ||--o{ CATEGORY_WEBLOG : includes
    WEBLOG ||--o{ IMAGE : contains

    USER {
        int id
        string username
        string name
        string email
        string password
        boolean is_subscriber
    }
    
    CATEGORY {
        int id
        string title
    }
    
    WEBLOG {
        int id
        string title
        string text
        int user_id
        boolean is_premium
        datetime published_at
    }
    
    CATEGORY_WEBLOG {
        int weblog_id
        int category_id
    }
    
    COMMENT {
        int id
        string text
        int weblog_id
        int user_id
        datetime published_at
    }

    IMAGE {
        int id
        string url
        string alt_text
        int weblog_id
        datetime uploaded_at
    }
```

Toelichting:

- `users.username` en `users.email` zijn uniek; `email` is nullable, omdat registratie alleen een gebruikersnaam en wachtwoord vraagt.
- `users.is_subscriber` is een boolean met standaardwaarde `false`.
- `weblogs.published_at` is geïndexeerd; `weblogs.is_premium` is een boolean met standaardwaarde `false`.
- `category_weblog` heeft een samengestelde primaire sleutel (`weblog_id`, `category_id`).
- Alle foreign keys hebben cascade-delete, zodat comments, afbeeldingen en categorie-koppelingen met het artikel verdwijnen.
