CREATE TABLE "user"
(
    id         SERIAL PRIMARY KEY,
    chat_id    BIGINT,
    step       VARCHAR(200),
    phone      VARCHAR(20),
    username   VARCHAR(64),
    language   VARCHAR(10),
    created_at integer,
    status     VARCHAR(30)
);
CREATE INDEX index_foreign_key_user_chat ON "user" (chat_id);

