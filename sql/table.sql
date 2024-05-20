CREATE TABLE `user` (
  `id` integer PRIMARY KEY,
  `name` varchar(255),
  `mail` varchar(255) UNIQUE NOT NULL,
  `password` varchar(255) UNIQUE NOT NULL,
  `profile_url` varchar(255),
  `created_at` timestamp,
  `updated_at` timestamp
);

-- ユーザ退会イベントテーブル
CREATE TABLE `user_unsubscribed` (
  `id` integer PRIMARY KEY,
  `created_at` timestamp,
  `user_id` integer
);

CREATE TABLE `article` (
  `id` integer PRIMARY KEY,
  `title` varchar(255),
  `contents` varchar(255),
  `created_at` timestamp,
  `user_id` integer
);

-- 記事削除イベントテーブル
CREATE TABLE `article_deleted` (
  `id` integer PRIMARY KEY,
  `created_at` timestamp,
  `article_id` integer
);

CREATE TABLE `article_image` (
  `id` integer PRIMARY KEY,
  `url` varchar(255),
  `created_at` timestamp,
  `article_id` integer
);

CREATE TABLE `tag` (
  `id` integer PRIMARY KEY,
  `name` varchar(255),
  `created_at` timestamp
);

CREATE TABLE `article_tag` (
  `id` integer PRIMARY KEY,
  `article_id` integer,
  `tag_id` integer,
  `created_at` timestamp
);

ALTER TABLE `user_unsubscribed` ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

ALTER TABLE `article` ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

ALTER TABLE `article_deleted` ADD FOREIGN KEY (`article_id`) REFERENCES `article` (`id`);

ALTER TABLE `article_image` ADD FOREIGN KEY (`article_id`) REFERENCES `article` (`id`);

ALTER TABLE `article_tag` ADD FOREIGN KEY (`article_id`) REFERENCES `article` (`id`);

ALTER TABLE `article_tag` ADD FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`);
