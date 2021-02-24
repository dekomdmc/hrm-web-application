create TABLE if not exists chart_of_account_groups(
    id int primary key auto_increment,
    name varchar(100) not null,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
insert into chart_of_account_groups(name)
values('Income'),
('Expenses');
create TABLE if not exists chart_of_accounts(
    id int primary key auto_increment,
    group_id int,
    Foreign key (group_id) references chart_of_account_groups(id),
    name varchar(100),
    created_by int not null,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
insert into permissions(name, guard_name)
values ('view dashboard', 'web'),
values ('view hr', 'web'),
values ('view hr employee', 'web'),
values ('view hr attendance', 'web'),
values ('view hr holiday', 'web'),
values ('view hr leave', 'web'),
values ('view hr meeting', 'web'),
values ('view hr asset', 'web'),
values ('view hr document', 'web'),
values ('view hr company policy', 'web'),
values ('view hr company policy', 'web'),


values ('view presale', 'web'),
values ('view presale lead', 'web'),
values ('view presale deal', 'web'),
values ('view presale estimate', 'web'),