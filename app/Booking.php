<?php

class Booking {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    /**
     * Save a booking record.
     *
     * The database table currently named `records` stores the following
     * columns: Client, Phone, Services, date.  The form collects
     * (name, phone, service, date) so we map those directly.
     *
     * @return bool true on success, false on failure
     */
    public function saveBooking(string $name, string $phone, string $service, string $date): bool {
        $sql = "INSERT INTO records (Client, Phone, Services, date) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false;
        }

        // bind parameters and execute
        $stmt->bind_param('ssss', $name, $phone, $service, $date);
        return $stmt->execute();
    }
}
