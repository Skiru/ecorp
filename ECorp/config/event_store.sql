CREATE TABLE IF NOT EXISTS users_aggregate_roots (
    id UUID not null,
    event text not null,
    class_name varchar(150) not null,
    PRIMARY KEY (id)
);



