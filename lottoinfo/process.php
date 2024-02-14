<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate and process the form data
    $name = htmlspecialchars($_POST["name"]);
    $ticketNumber = intval($_POST["ticket_number"]);

    // Perform additional validation as needed

    // Simulate lottery logic (e.g., random winner)
    $winningNumber = rand(1, 100);
    $isWinner = $ticketNumber === $winningNumber;

    // Display result
    echo "<h2>Lottery Result</h2>";
    echo "<p>Name: $name</p>";
    echo "<p>Your Ticket Number: $ticketNumber</p>";
    echo "<p>Winning Number: $winningNumber</p>";
    echo "<p>" . ($isWinner ? "Congratulations! You won!" : "Sorry, you didn't win this time.") . "</p>";
} else {
    // Redirect to the home page if accessed directly
    header("Location: index.html");
    exit();
}
?>