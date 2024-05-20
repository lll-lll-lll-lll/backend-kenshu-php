CREATE TABLE `user` (
  `id` serial PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `mail` varchar(255) UNIQUE NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_url` text NOT NULL,
  `created_at` timestamp default CURRENT_TIMESTAMP,
  `updated_at` timestamp default CURRENT_TIMESTAMP
);

CREATE TABLE `article` (
  `id` serial PRIMARY KEY,
  `title` varchar(255) NOT NULL,
  `contents` text NOT NULL,
  `created_at` timestamp default CURRENT_TIMESTAMP,
  `user_id` integer NOT NULL,
  CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
);

CREATE TABLE `article_image` (
  `id` serial PRIMARY KEY,
  `url` text NOT NULL,
  `created_at` timestamp default CURRENT_TIMESTAMP,
  `article_id` integer NOT NULL,
  CONSTRAINT `fk_article_id` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`)
);

CREATE TABLE `tag` (
  `id` serial PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp default CURRENT_TIMESTAMP
);

CREATE TABLE `article_tag` (
  `id` serial PRIMARY KEY,
  `article_id` integer NOT NULL,
  `tag_id` integer NOT NULL,
  `created_at` timestamp default CURRENT_TIMESTAMP,
  CONSTRAINT `fk_article_id` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`),
  CONSTRAINT `fk_tag_id` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`)
);

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
