CREATE TABLE "user"
(
    id          serial PRIMARY KEY,
    name        varchar(255)        NOT NULL,
    mail        varchar(255) UNIQUE NOT NULL,
    password    varchar(255)        NOT NULL,
    profile_url text                NOT NULL,
    created_at  timestamp default CURRENT_TIMESTAMP,
    updated_at  timestamp default CURRENT_TIMESTAMP
);


CREATE TABLE IF NOT EXISTS "article"
(
    id         serial PRIMARY KEY,
    title      varchar(255) NOT NULL,
    contents   text         NOT NULL,
    created_at timestamp default CURRENT_TIMESTAMP,
    user_id    integer      NOT NULL,
    CONSTRAINT fk_user_id FOREIGN KEY (user_id) REFERENCES "user" (id)
);

CREATE TABLE IF NOT EXISTS "article_image"
(
    id                   serial PRIMARY KEY,
    thumbnail_image_path text    NOT NULL,
    sub_image_path       text    NOT NULL,
    created_at           timestamp default CURRENT_TIMESTAMP,
    article_id           integer NOT NULL,
    CONSTRAINT fk_article_id FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS "tag"
(
    id         serial PRIMARY KEY,
    name       varchar(255) UNIQUE NOT NULL,
    created_at timestamp default CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS "article_tag"
(
    id         serial PRIMARY KEY,
    article_id integer NOT NULL,
    tag_id     integer NOT NULL,
    created_at timestamp default CURRENT_TIMESTAMP,
    CONSTRAINT fk_article_id FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE,
    CONSTRAINT fk_tag_id FOREIGN KEY (tag_id) REFERENCES tag (id)
);
CREATE OR REPLACE FUNCTION update_updated_at_column()
    RETURNS TRIGGER AS
$$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_update_updated_at_column
    BEFORE UPDATE
    ON "user"
    FOR EACH ROW
EXECUTE FUNCTION update_updated_at_column();

CREATE UNIQUE INDEX idx_user_mail ON "user" (mail);

INSERT INTO "tag" (name)
VALUES ('総合');
INSERT INTO "tag" (name)
VALUES ('テクノロジー');
INSERT INTO "tag" (name)
VALUES ('モバイル');
INSERT INTO "tag" (name)
VALUES ('アプリ');
INSERT INTO "tag" (name)
VALUES ('エンタメ');
INSERT INTO "tag" (name)
VALUES ('ビューティー');
INSERT INTO "tag" (name)
VALUES ('ファッション');
INSERT INTO "tag" (name)
VALUES ('ライフスタイル');
INSERT INTO "tag" (name)
VALUES ('ビジネス');
INSERT INTO "tag" (name)
VALUES ('グルメ');
INSERT INTO "tag" (name)
VALUES ('スポーツ');


