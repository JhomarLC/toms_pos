<?php
setcookie("account_signed_in", "", time() - 3600, "/", "", true, true);
header("Location: ../");