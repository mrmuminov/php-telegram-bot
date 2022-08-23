------------------------------
-- user table ----------------
CREATE TABLE IF NOT EXISTS public."user"
(
    id         BIGSERIAL                NOT NULL
        CONSTRAINT user_pk PRIMARY KEY,
    chat_id    BIGINT                   NOT NULL,
    step       VARCHAR,
    language   VARCHAR(10),
    status     VARCHAR DEFAULT 'ACTIVE' NOT NULL,
    created_at INTEGER                  NOT NULL
);

CREATE UNIQUE INDEX IF NOT EXISTS user_chat_id_uindex
    ON public."user" (chat_id);

CREATE INDEX IF NOT EXISTS user_status_index
    ON public."user" (status);


------------------------------
-- user_username table ----------------
CREATE TABLE IF NOT EXISTS public."user_username"
(
    id         BIGSERIAL                NOT NULL
        CONSTRAINT user_username_pk PRIMARY KEY,
    chat_id    BIGINT                   NOT NULL,
    username   VARCHAR(32),
    status     VARCHAR DEFAULT 'ACTIVE' NOT NULL,
    created_at INTEGER                  NOT NULL
);

CREATE UNIQUE INDEX IF NOT EXISTS user_username_chat_id_uindex
    ON public."user_username" (chat_id);

CREATE INDEX IF NOT EXISTS user_username_status_index
    ON public."user_username" (status);


------------------------------
-- user_first_name table ----------------
CREATE TABLE IF NOT EXISTS public."user_first_name"
(
    id         BIGSERIAL                NOT NULL
        CONSTRAINT user_first_name_pk PRIMARY KEY,
    chat_id    BIGINT                   NOT NULL,
    first_name VARCHAR(64),
    status     VARCHAR DEFAULT 'ACTIVE' NOT NULL,
    created_at INTEGER                  NOT NULL
);

CREATE UNIQUE INDEX IF NOT EXISTS user_first_name_chat_id_uindex
    ON public."user_first_name" (chat_id);

CREATE INDEX IF NOT EXISTS user_first_name_status_index
    ON public."user_first_name" (status);


------------------------------
-- user_last_name table ----------------
CREATE TABLE IF NOT EXISTS public."user_last_name"
(
    id         BIGSERIAL                NOT NULL
        CONSTRAINT user_last_name_pk PRIMARY KEY,
    chat_id    BIGINT                   NOT NULL,
    last_name  VARCHAR(64),
    status     VARCHAR DEFAULT 'ACTIVE' NOT NULL,
    created_at INTEGER                  NOT NULL
);

CREATE UNIQUE INDEX IF NOT EXISTS user_last_name_chat_id_uindex
    ON public."user_last_name" (chat_id);

CREATE INDEX IF NOT EXISTS user_last_name_status_index
    ON public."user_last_name" (status);


------------------------------
-- user_bio table ----------------
CREATE TABLE IF NOT EXISTS public."user_bio"
(
    id         BIGSERIAL                NOT NULL
        CONSTRAINT user_bio_pk PRIMARY KEY,
    chat_id    BIGINT                   NOT NULL,
    bio        VARCHAR(200),
    status     VARCHAR DEFAULT 'ACTIVE' NOT NULL,
    created_at INTEGER                  NOT NULL
);

CREATE UNIQUE INDEX IF NOT EXISTS user_bio_chat_id_uindex
    ON public."user_bio" (chat_id);

CREATE INDEX IF NOT EXISTS user_bio_status_index
    ON public."user_bio" (status);


------------------------------
-- user_phone table ----------------
CREATE TABLE IF NOT EXISTS public."user_phone"
(
    id         BIGSERIAL                NOT NULL
        CONSTRAINT user_phone_pk PRIMARY KEY,
    chat_id    BIGINT                   NOT NULL,
    phone      VARCHAR(20),
    status     VARCHAR DEFAULT 'ACTIVE' NOT NULL,
    created_at INTEGER                  NOT NULL
);

CREATE UNIQUE INDEX IF NOT EXISTS user_phone_chat_id_uindex
    ON public."user_phone" (chat_id);

CREATE INDEX IF NOT EXISTS user_phone_status_index
    ON public."user_phone" (status);
