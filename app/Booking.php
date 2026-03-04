<?php

class Booking {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function saveBooking(string $name, string $phone, string $service, string $date): bool {
        $sql = "INSERT INTO records (Client, Phone, Services, date) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param('ssss', $name, $phone, $service, $date);
        return $stmt->execute();
    }

    public function getAllBookings() {
        $result = $this->conn->query("SELECT * FROM records ORDER BY id DESC");
        $bookings = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $bookings[] = $row;
            }
        }
        return $bookings;
    }
}