<form action="confirm_payment.php" method="POST">
    <input type="hidden" name="match_id" value="<?= $match_id ?>">
    <input type="number" name="seats" required>
    <input type="text" name="total_price" required>
    <button type="submit">Confirm Payment</button>
</form>
