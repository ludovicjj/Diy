Hello <?php
if (isset($name)) {
     echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
}
?>
