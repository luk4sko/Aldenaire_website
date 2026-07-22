<?php
$pdo = new PDO(
    "pgsql:host=aws-0-eu-west-3.pooler.supabase.com;port=5432;dbname=postgres",
    "postgres.tzmwequninfkosgfxiee",
    "Gdtfjuu55ege."
);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
