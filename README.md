# backend-kenshu-php

# 要件
バックエンド
- POST /users
  - user_name
  - email
  - password
  - profile_url (optional)


```sql
    id serial PRIMARY KEY,
    name varchar(255) NOT NULL,
    mail varchar(255) UNIQUE NOT NULL,
    password varchar(255) NOT NULL,
    profile_url text NOT NULL,
    created_at timestamp default CURRENT_TIMESTAMP,
    updated_at timestamp default CURRENT_TIMESTAMP
```
