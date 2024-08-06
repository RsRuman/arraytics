<?php

require_once 'connections/db.php';

// SQL to create the table
$sql = "CREATE TABLE IF NOT EXISTS buyers (
    id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    amount INT(10),
    buyer VARCHAR(255),
    receipt_id VARCHAR(20),
    items VARCHAR(255),
    buyer_email VARCHAR(50),
    buyer_ip VARCHAR(20),
    note TEXT,
    city VARCHAR(20),
    phone VARCHAR(20),
    hash_key VARCHAR(255),
    entry_at DATE,
    entry_by INT(10)
)";

// Execute the query
if ($conn->query($sql) !== TRUE) {
    echo "Error creating table: " . $conn->error . "\n";
}
