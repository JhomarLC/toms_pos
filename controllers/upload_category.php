<?php
$check = getimagesize($_FILES["category_image"]["tmp_name"]);
if($check !== false) {
  $uploadOk = 1;
} else {
  echo "File is not an image.";
  // $_SESSION['alert'] = array(
  //   "message" => "File is not an image.",
  //   "type" => "error"
  // );
  $uploadOk = 0;
  // header("Location: ../admin/menu/item-add");
}

// // Check if file already exists
// if (file_exists($target_file)) {
//   // $_SESSION['alert'] = array(
//   //   "message" => "Sorry, file already exists.",
//   //   "type" => "error"
//   // );
//   $uploadOk = 0;
//   // header("Location: ../admin/menu/item-add");
// }

// Check file size
if ($_FILES["category_image"]["size"] > 500000) {
  // $_SESSION['alert'] = array(
  //   "message" => "Sorry, your file is too large.",
  //   "type" => "error"
  // );
  $uploadOk = 0;
  // header("Location: ../admin/menu/item-add");
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  // $_SESSION['alert'] = array(
  //   "message" => "Sorry, only JPG, JPEG, PNG & GIF files are allowed.",
  //   "type" => "error"
  // );
  $uploadOk = 0;
  // header("Location: ../admin/menu/item-add");
}

// // Check if $uploadOk is set to 0 by an error
// if ($uploadOk == 0) {
//   $_SESSION['alert'] = array(
//     "message" => "Sorry, your file was not uploaded.",
//     "type" => "error"
//   );
//   header("Location: ../admin/menu/item-add");
// } else {
//   if (!move_uploaded_file($_FILES["category_image"]["tmp_name"], $target_file)) {
//     $_SESSION['alert'] = array(
//       "message" => "Sorry, there was an error uploading your file.",
//       "type" => "error"
//     );
//     header("Location: ../admin/menu/item-add");
//   }
// }
?>