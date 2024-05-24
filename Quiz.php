<?php
// Variabel dan Tipe Data
$quizTitle = "System Quiz";
$questions = [
    "Apa ibukota Indonesia?" => "Jakarta",
    "2 + 2 = ?" => "4",
    "Warna campuran merah dan biru adalah?" => "Ungu"
];

// Function
function checkAnswer($question, $answer, $questions) {
    return $questions[$question] === $answer;
}

// Object-Oriented Programming 1 (Class dan Method)
class Question {
    public $question;
    public $answer;

    function __construct($question, $answer) {
        $this->question = $question;
        $this->answer = $answer;
    }

    function check($answer) {
        return $this->answer === $answer;
    }
}

// Object-Oriented Programming 2 (Inheritance)
class Quiz {
    private $questions = [];
    private $score = 0;

    function addQuestion($question) {
        $this->questions[] = $question;
    }

    function getQuestions() {
        return $this->questions;
    }

    function checkAnswer($question, $answer) {
        if ($question->check($answer)) {
            $this->score++;
        }
    }

    function getScore() {
        return $this->score;
    }
}

// Stack
class Stack {
    private $stack = [];

    function push($item) {
        array_push($this->stack, $item);
    }

    function pop() {
        return array_pop($this->stack);
    }

    function top() {
        return end($this->stack);
    }

    function isEmpty() {
        return empty($this->stack);
    }
}

// Queue
class Queue {
    private $queue = [];

    function enqueue($item) {
        array_push($this->queue, $item);
    }

    function dequeue() {
        return array_shift($this->queue);
    }

    function front() {
        return $this->queue[0];
    }

    function isEmpty() {
        return empty($this->queue);
    }
}

// Memeriksa apakah nama sudah di-submit
session_start();
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
if (!isset($_SESSION['name']) && isset($_POST['name'])) {
    $_SESSION['name'] = $_POST['name'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $quizTitle; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px 40px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            color: #333;
        }
        form {
            margin-top: 20px;
        }
        input[type="text"] {
            padding: 10px;
            margin-top: 10px;
            width: 80%;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            margin-top: 20px;
            border: none;
            background-color: #007BFF;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        p {
            color: #555;
        }
        .score {
            margin-top: 20px;
            font-size: 24px;
            color: #333;
        }
        .back-button {
            margin-top: 20px;
            padding: 10px 20px;
            border: none;
            background-color: #28a745;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
        }
        .back-button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (!isset($_SESSION['name'])): ?>
            <h1>Selamat Datang di <?php echo $quizTitle; ?></h1>
            <form method="post" action="">
                <label for="name">Masukkan Nama Anda:</label><br>
                <input type="text" id="name" name="name" required><br>
                <input type="submit" value="Mulai Quiz">
            </form>
        <?php else: ?>
            <h1><?php echo $quizTitle; ?></h1>
            <h2>Halo, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h2>
            <form method="post" action="">
                <?php foreach ($questions as $question => $answer): ?>
                    <p><?php echo $question; ?></p>
                    <input type="text" name="answers[<?php echo $question; ?>]" required><br>
                <?php endforeach; ?>
                <input type="submit" value="Submit">
            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['answers'])) {
                $quiz = new Quiz();
                foreach ($questions as $question => $answer) {
                    $quiz->addQuestion(new Question($question, $answer));
                }

                $userAnswers = $_POST['answers'];
                foreach ($quiz->getQuestions() as $questionObj) {
                    $quiz->checkAnswer($questionObj, $userAnswers[$questionObj->question]);
                }

                echo "<div class='score'>Skor Anda: " . $quiz->getScore() . "</div>";
            }
            ?>
            <form method="get" action="">
                <input type="submit" name="logout" value="Kembali ke Login" class="back-button">
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
