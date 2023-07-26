<?php
require 'vendor/autoload.php';
use Phpml\ModelManager;
function predict_with_model($json_model_file, $example_new_data) {
    // Read the JSON model file
    $json_content = file_get_contents($json_model_file);

    // Decode the JSON content
    $model_data = json_decode($json_content, true);

    // Retrieve the coefficients and intercept
    $coefficients = $model_data['coefficients'];
    $intercept = $model_data['intercept'];

    // Perform prediction on the example new data
    $predicted_price = 0;
    for ($i = 0; $i < count($coefficients); $i++) {
        $predicted_price += $coefficients[$i] * $example_new_data[$i];
    }
    $predicted_price += $intercept;

    return $predicted_price;
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  </head>
  <body>
  <div class="modal position-static d-block" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Prediksi Harga Saham (MCD)</h5>
        </div>
        <div class="modal-body">
        <form method="post" action="">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Masukan Harga Pembukaan</label>
    <input type="text" name="pembukaan" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail2" class="form-label">Masukan Harga Tertinggi</label>
    <input type="text" name="tinggi" class="form-control" id="exampleInputEmail2" aria-describedby="emailHelp">
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail3" class="form-label">Masukan Harga Terendah</label>
    <input type="text" name="terendah" class="form-control" id="exampleInputEmail3" aria-describedby="emailHelp">
  </div>
 
  <button name="submit" type="submit" class="btn btn-primary">Submit</button>
</form>
<br>
<div class="modal-footer">

    </div>
          <?php
if(isset($_POST['submit'])){
$buka = $_POST['pembukaan'];
$tinggi = $_POST['tinggi'];
$rendah = $_POST['terendah'];
if (!empty($buka) && !empty($tinggi) && !empty($rendah)) {  
$feature_columns = [$buka, $tinggi, $rendah];
$json_model_file = 'model.json';
$predicted_price = predict_with_model($json_model_file, $feature_columns);

$formatted_predicted_price = number_format($predicted_price, 3, '.', ',');
echo "Hasil Prediksi Harga (Penutup) :" . $formatted_predicted_price . "\n";
}
else {
    echo'Ada  Bagian Yang Kosong ';
}
  }
else{
}
    ?>
        </div>
        
      </div>
    </div>
  </div>
  

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </body>
</html>