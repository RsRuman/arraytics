<?php

require_once 'models/Buyer.php';
class BuyerController
{
    private $model;

    public function __construct()
    {
        $this->model = new Buyer();
    }

    /**
     * Create buyer page || buyer submission form
     * @return void
     */
    public function create()
    {
        require_once 'views/buyerForm.php';
    }

    /**
     * Store buyers
     * @return void
     */
    public function store()
    {
        if (isset($_COOKIE['submitted'])) {
            echo "You have already submitted within the last 24 hours.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Collect and sanitize input data
            $amount      = filter_input(INPUT_POST, 'amount', FILTER_SANITIZE_NUMBER_INT);
            $buyer       = filter_input(INPUT_POST, 'buyer', FILTER_SANITIZE_STRING);
            $receipt_id  = filter_input(INPUT_POST, 'receipt_id', FILTER_SANITIZE_STRING);
            $items       = filter_input(INPUT_POST, 'items', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);;
            $buyer_email = filter_input(INPUT_POST, 'buyer_email', FILTER_SANITIZE_EMAIL);
            $buyer_ip    = $_SERVER['REMOTE_ADDR']; // Get user's IP
            $note        = filter_input(INPUT_POST, 'note', FILTER_SANITIZE_STRING);
            $city        = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
            $phone       = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
            $entry_by    = filter_input(INPUT_POST, 'entry_by', FILTER_SANITIZE_NUMBER_INT);

            var_dump($items);

            // Validate inputs
            if (filter_var($buyer_email, FILTER_VALIDATE_EMAIL) === false) {
                echo "Invalid email address.";
                return;
            }

            if (!is_numeric($amount) || $amount < 0) {
                echo "Amount must be a non-negative number.";
                return;
            }

            if (strlen($buyer) > 20 || preg_match('/[^a-zA-Z0-9\s]/', $buyer)) {
                echo "Buyer must be text, spaces, or numbers and not exceed 20 characters.";
                return;
            }

            if (empty($receipt_id)) {
                echo "Receipt ID cannot be empty.";
                return;
            }

            if (empty($items)) {
                echo "Items cannot be empty.";
                return;
            }

            if (str_word_count($note) > 30) {
                echo "Note must not exceed 30 words.";
                return;
            }

            if (empty($city) || preg_match('/[^a-zA-Z\s]/', $city)) {
                echo "City must be text and spaces.";
                return;
            }

            if (!is_numeric($phone)) {
                echo "Phone must be numbers.";
                return;
            }

            if (!is_numeric($entry_by) || $entry_by < 0) {
                echo "Entry By must be a non-negative number.";
                return;
            }

            // Hash the receipt_id
            $salt     = 'random_salt';
            $hash_key = hash('sha512', $receipt_id . $salt);

            // Save data to database using buyer model
            $this->model->amount      = $amount;
            $this->model->buyer       = $buyer;
            $this->model->receipt_id  = $receipt_id;
            $this->model->items       = $items;
            $this->model->buyer_email = $buyer_email;
            $this->model->buyer_ip    = $buyer_ip;
            $this->model->note        = $note;
            $this->model->city        = $city;
            $this->model->phone       = '880'. $phone;
            $this->model->entry_by    = $entry_by;
            $this->model->hash_key    = $hash_key;
            $this->model->entry_at    = date('Y-m-d');

            if ($this->model->save()) {
                echo "Data saved successfully.";
            } else {
                echo "Failed to save data.";
            }
        } else {
            echo "Invalid request method.";
        }
    }

    /**
     * Home page || Report page
     * @return void
     */
    public function report()
    {
        $startDate = isset($_GET['start_date']) ? filter_input(INPUT_GET, 'start_date', FILTER_SANITIZE_STRING) : null;
        $endDate   = isset($_GET['end_date']) ? filter_input(INPUT_GET, 'end_date', FILTER_SANITIZE_STRING) : null;
        $userId    = isset($_GET['user_id']) ? filter_input(INPUT_GET, 'user_id', FILTER_SANITIZE_NUMBER_INT) : null;

        // Fetch data from the model
        $data = $this->model->getAll($startDate, $endDate, $userId);

        // Pass data to the view
        require_once 'views/report.php';
    }
}
