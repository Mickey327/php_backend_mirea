<?php
    const
    host = 'mysql',
    dbUser = 'user',
    password = 'password',
    db = 'appDB';

function connectDB(): mysqli { return new mysqli(
    host, dbUser, password, db
); }
?>