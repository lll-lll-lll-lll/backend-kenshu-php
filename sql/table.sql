CREATE TABLE `user` (
  `id` integer PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `mail` varchar(255) UNIQUE NOT NULL,
  `password` varchar(255) UNIQUE NOT NULL,
  `profile_url` TEXT NOT NULL,
  `created_at` timestamp default CURRENT_TIMESTAMP,
  `updated_at` timestamp default CURRENT_TIMESTAMP
);

CREATE TABLE `article` (
  `id` integer PRIMARY KEY,
  `title` varchar(255) NOT NULL,
  `contents` TEXT NOT NULL,
  `created_at` timestamp default CURRENT_TIMESTAMP,
  `user_id` integer NOT NULL
);

CREATE TABLE `article_image` (
  `id` integer PRIMARY KEY,
  `url`TEXT NOT NULL,
  `created_at` timestamp default CURRENT_TIMESTAMP,
  `article_id` integer NOT NULL
);

CREATE TABLE `tag` (
  `id` integer PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp default CURRENT_TIMESTAMP
);

CREATE TABLE `article_tag` (
  `id` integer PRIMARY KEY,
  `article_id` integer NOT NULL,
  `tag_id` integer NOT NULL,
  `created_at` timestamp default CURRENT_TIMESTAMP
);

ALTER TABLE `user_unsubscribed` ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

ALTER TABLE `article` ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

ALTER TABLE `article_deleted` ADD FOREIGN KEY (`article_id`) REFERENCES `article` (`id`);

ALTER TABLE `article_image` ADD FOREIGN KEY (`article_id`) REFERENCES `article` (`id`);

ALTER TABLE `article_tag` ADD FOREIGN KEY (`article_id`) REFERENCES `article` (`id`);

ALTER TABLE `article_tag` ADD FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`);



CREATE OR REPLACE FUNCTION update_updated_at_column()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_update_updated_at_column
BEFORE UPDATE ON "user"
FOR EACH ROW
EXECUTE FUNCTION update_updated_at_column();
