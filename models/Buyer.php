<?php
require_once 'connections/db.php';

class Buyer
{
    public $amount;
    public $buyer;
    public $receipt_id;
    public $items;
    public $buyer_email;
    public $buyer_ip;
    public $note;
    public $city;
    public $phone;
    public $hash_key;
    public $entry_at;
    public $entry_by;

    /**
     * Store buyers
     * @return bool
     */
    public function save()
    {
        global $conn;

        $itemsString = is_array($this->items) ? implode(', ', $this->items) : '';

        $stmt = $conn->prepare("INSERT INTO buyers (amount, buyer, receipt_id, items, buyer_email, buyer_ip, note, city, phone, hash_key, entry_at, entry_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        if ($stmt === FALSE) {
            return false;
        }

        $stmt->bind_param(
            "issssssssssi",
            $this->amount,
            $this->buyer,
            $this->receipt_id,
            $itemsString,
            $this->buyer_email,
            $this->buyer_ip,
            $this->note,
            $this->city,
            $this->phone,
            $this->hash_key,
            $this->entry_at,
            $this->entry_by
        );

        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    /**
     * Get all buyers
     * @param $startDate
     * @param $endDate
     * @param $userId
     * @return array|void
     */
    public function getAll($startDate = null, $endDate = null, $userId = null)
    {
        global $conn;

        $query  = "SELECT * FROM buyers WHERE 1=1";
        $params = [];
        $types  = "";

        if ($startDate && $endDate) {
            $query   .= " AND entry_at BETWEEN ? AND ?";
            $params[] = $startDate;
            $params[] = $endDate;
            $types   .= "ss";
        }

        if ($userId) {
            $query   .= " AND entry_by = ?";
            $params[] = $userId;
            $types   .= "i";
        }

        $stmt = $conn->prepare($query);

        if ($stmt === FALSE) {
            die("Error preparing statement: " . $conn->error);
        }

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            die("Query Error: " . $stmt->error);
        }

        return [];
    }
}
